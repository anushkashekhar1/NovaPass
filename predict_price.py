from flask import Flask, request, jsonify
import pandas as pd
import joblib

app = Flask(__name__)

model = joblib.load("resale_model.pkl")

@app.route("/predict", methods=["POST"])
def predict():
    data = request.json
    features = pd.DataFrame([{
        "original_price": data.get("original_price", 0),
        "days_to_event": data.get("days_to_event", 0),
        "sold_ratio": data.get("sold_ratio", 0),
        "popularity": data.get("popularity", 0),
        "crypto_change": data.get("crypto_change", 0),
    }])
    prediction = model.predict(features)[0]
    return jsonify({"resale_price": round(prediction, 2)})

if __name__ == "__main__":
    app.run(debug=True)
