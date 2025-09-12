from flask import Flask, request, jsonify
from flask_cors import CORS
from joblib import load
import numpy as np

app = Flask(__name__)
CORS(app)  # Enable CORS for all rout

# Load the model components
model_components = load('k_means.joblib')
centroids = model_components['centroids']
scaler = model_components['scaler']
cluster_mapping = model_components['cluster_mapping']

def assign_clusters(X, centroids):
    distances = np.linalg.norm(X[:, np.newaxis] - centroids, axis=2)
    return np.argmin(distances, axis=1)

@app.route('/predict', methods=['POST'])
def predict():
    try:
        # Get data from request
        data = request.json
        net_amount = float(data['net_amount'])
        quantity = float(data['quantity'])
        
        # Prepare input
        X = np.array([[net_amount, quantity]])
        
        # Scale the input
        X_scaled = scaler.transform(X)
        
        # Predict cluster
        label = assign_clusters(X_scaled, centroids)[0]
        cluster_name = cluster_mapping[label]
        
        # (Optional) Get centroid values in original scale
        centroid_original = scaler.inverse_transform([centroids[label]])[0]
        
        return jsonify({
            'cluster': cluster_name,
            'centroid': {
                'net_amount': float(centroid_original[0]),
                'quantity': float(centroid_original[1])
            }
        })
        
    except Exception as e:
        return jsonify({'error': str(e)}), 400

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
