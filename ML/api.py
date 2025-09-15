# from flask import Flask, request, jsonify
# from flask_cors import CORS
# from joblib import load
# import numpy as np

# app = Flask(__name__)
# CORS(app)  # Enable CORS for all rout

# # Load the model components
# model_components = load('k_means.joblib')
# centroids = model_components['centroids']
# scaler = model_components['scaler']
# cluster_mapping = model_components['cluster_mapping']

# def assign_clusters(X, centroids):
#     distances = np.linalg.norm(X[:, np.newaxis] - centroids, axis=2)
#     return np.argmin(distances, axis=1)

# @app.route('/predict', methods=['POST'])
# def predict():
#     try:
#         # Get data from request
#         data = request.json
#         net_amount = float(data['net_amount'])
#         quantity = float(data['quantity'])
        
#         # Prepare input
#         X = np.array([[net_amount, quantity]])
        
#         # Scale the input
#         X_scaled = scaler.transform(X)
        
#         # Predict cluster
#         label = assign_clusters(X_scaled, centroids)[0]
#         cluster_name = cluster_mapping[label]
        
#         # (Optional) Get centroid values in original scale
#         centroid_original = scaler.inverse_transform([centroids[label]])[0]
        
#         return jsonify({
#             'cluster': cluster_name,
#             'centroid': {
#                 'net_amount': float(centroid_original[0]),
#                 'quantity': float(centroid_original[1])
#             }
#         })
        
#     except Exception as e:
#         return jsonify({'error': str(e)}), 400

# if __name__ == '__main__':
#     app.run(debug=True, host='0.0.0.0', port=5000)
from flask import Flask, request, jsonify
from flask_cors import CORS
import pandas as pd
import numpy as np
import joblib

# === Initialize Flask app ===
app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

# === Load XGBoost model components ===
xgb_model = joblib.load('xgb_model.pkl')
xgb_scaler = joblib.load('scaler.pkl')
xgb_columns = joblib.load('model_columns.pkl')

# === Load KMeans model components ===
kmeans_components = joblib.load('k_means.joblib')
kmeans_centroids = kmeans_components['centroids']
kmeans_scaler = kmeans_components['scaler']
kmeans_cluster_mapping = kmeans_components['cluster_mapping']


# === Helper: XGBoost input processing and prediction ===
def prepare_quantity_input(year, month, discount_amt, rate, mcat_string):
    data = {
        'Year': year,
        'Month': month,
        'DISCOUNTAMNT': discount_amt,
        'RATE': rate,
    }

    df = pd.DataFrame([data])

    df['DISCOUNTED_RATE'] = df['DISCOUNTAMNT'] / df['RATE'].replace(0, np.nan)
    df['DISCOUNTED_RATE'].fillna(0, inplace=True)

    df['Rolling_3'] = 100  # Default rolling value
    df['Rate_Discount_Interaction'] = df['RATE'] * df['DISCOUNTED_RATE']

    mcat_col_name = f"MCAT_{mcat_string}"
    df[mcat_col_name] = 1

    for col in xgb_columns:
        if col not in df.columns:
            df[col] = 0

    df = df[xgb_columns]
    df_scaled = xgb_scaler.transform(df)

    prediction = xgb_model.predict(df_scaled)[0]
    return max(prediction, 0)


# === Helper: KMeans prediction ===
def assign_clusters(X, centroids):
    distances = np.linalg.norm(X[:, np.newaxis] - centroids, axis=2)
    return np.argmin(distances, axis=1)


# === Route 1: XGBoost Quantity Prediction ===
@app.route('/predict_quantity', methods=['POST'])
def predict_quantity():
    try:
        data = request.json
        year = int(data['Year'])
        month = int(data['Month'])
        discount_amt = float(data['DISCOUNTAMNT'])
        rate = float(data['RATE'])
        mcat = data['MCAT']

        predicted_qty = prepare_quantity_input(year, month, discount_amt, rate, mcat)

        return jsonify({'predicted_quantity': float(round(predicted_qty, 2))})


    except Exception as e:
        return jsonify({'error': str(e)}), 400


# === Route 2: KMeans Clustering Prediction ===
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


# === Run the app ===
if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
