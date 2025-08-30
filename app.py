from flask import Flask, request, jsonify
import joblib
import numpy as np

app = Flask(__name__)

# load trained model
model = joblib.load("model.pkl")

@app.route("/predict", methods=["POST"])
def predict():
    data = request.json
    features = np.array([data["base_price"], data["demand_level"], data["time_left"]]).reshape(1, -1)
    price = model.predict(features)[0]
    return jsonify({"suggested_price": price})

if __name__ == "__main__":
    app.run(debug=True)
