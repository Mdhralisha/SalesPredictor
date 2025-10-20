from flask import Flask, request, jsonify
from flask_cors import CORS
import pandas as pd
import numpy as np
import joblib

# === Initialize Flask app ===
app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

# === Load K-Means model components ===
kmeans_components = joblib.load('k_means.joblib')
kmeans_centroids = kmeans_components['centroids']
kmeans_scaler = kmeans_components['scaler']
kmeans_cluster_mapping = kmeans_components['cluster_mapping']

# === Load XGBoost model components ===
xgb_model = joblib.load("xgb_model.pkl")
xgb_scaler = joblib.load("scaler.pkl")
xgb_encoder = joblib.load("encoder.pkl")

# === Helper for K-Means ===
def assign_clusters(X, centroids):
    distances = np.linalg.norm(X[:, np.newaxis] - centroids, axis=2)
    return np.argmin(distances, axis=1)

# === K-Means endpoint ===
@app.route('/predict', methods=['POST'])
def predict_cluster():
    try:
        data = request.json
        net_amount = float(data['net_amount'])
        quantity = float(data['quantity'])

        X = np.array([[net_amount, quantity]])
        X_scaled = kmeans_scaler.transform(X)
        label = assign_clusters(X_scaled, kmeans_centroids)[0]
        cluster_name = kmeans_cluster_mapping[label]
        centroid_original = kmeans_scaler.inverse_transform([kmeans_centroids[label]])[0]

        return jsonify({
            'cluster': cluster_name,
            'centroid': {
                'net_amount': float(centroid_original[0]),
                'quantity': float(centroid_original[1])
            }
        })

    except Exception as e:
        return jsonify({'error': str(e)}), 400

# === XGBoost endpoint ===
@app.route('/xgb/predict', methods=['POST'])
def predict_sales():
    try:
        data = request.json
        df = pd.DataFrame([data])

        # Feature engineering
        df["TRNDATE"] = pd.to_datetime(df["TRNDATE"])
        df["Year"] = df["TRNDATE"].dt.year
        df["Month"] = df["TRNDATE"].dt.month
        df["Day"] = df["TRNDATE"].dt.day
        df["DayOfWeek"] = df["TRNDATE"].dt.dayofweek
        df["WeekOfYear"] = df["TRNDATE"].dt.isocalendar().week.astype(int)
        df["IsWeekend"] = df["DayOfWeek"].isin([5, 6]).astype(int)

        df["PricePerUnit"] = df["RATE"] / np.maximum(df["QUANTITY"], 1)
        df["LogQuantity"] = np.log1p(df["QUANTITY"])
        df["LogRate"] = np.log1p(df["RATE"])

        # One-Hot Encoding
        encoded = xgb_encoder.transform(df[["MCAT", "UNIT"]])
        encoded_cols = xgb_encoder.get_feature_names_out(["MCAT", "UNIT"])
        encoded_df = pd.DataFrame(encoded, columns=encoded_cols, index=df.index)
        df = pd.concat([df, encoded_df], axis=1)

        # Select features
        feature_cols = [
            "RATE", "LogRate", "PricePerUnit", "Discount",
            "Year", "Month", "Day", "DayOfWeek", "WeekOfYear", "IsWeekend"
        ] + [col for col in encoded_cols if col.startswith("MCAT_") or col.startswith("UNIT_")]

        X = df[feature_cols].fillna(0)

        # Scale numerical features
        numerical_cols = ["RATE", "LogRate", "PricePerUnit", "Year", "Month", "Day", "DayOfWeek", "WeekOfYear"]
        X.loc[:, numerical_cols] = xgb_scaler.transform(X[numerical_cols])

        # Predict
        prediction = xgb_model.predict(X)[0]

        return jsonify({"predicted_quantity": float(prediction)})

    except Exception as e:
        return jsonify({'error': str(e)}), 400

# === Run the app ===
if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
