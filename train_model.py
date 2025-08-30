import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import mean_absolute_error
import joblib

df = pd.read_csv("novapass.csv", parse_dates=["event_date","sale_date"])

df["days_to_event"] = (df["event_date"] - df["sale_date"]).dt.days.fillna(0)
df["sold_ratio"] = (df["tickets_sold"] / df["total_tickets"]).fillna(0)

features = ["original_price","days_to_event","sold_ratio","popularity","crypto_change"]
X = df[features]
y = df["sale_price"]

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

model = RandomForestRegressor(n_estimators=200, random_state=42)
model.fit(X_train, y_train)


preds = model.predict(X_test)
print("Mean Absolute Error:", mean_absolute_error(y_test, preds))

joblib.dump(model, "resale_model.pkl")
print("✅ Model saved as resale_model.pkl")
