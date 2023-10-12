from typing import Union, Set
from fastapi import FastAPI
from pydantic import BaseModel

from app import predict

class Symptoms(BaseModel):
    user_symptoms: Set[str]

app = FastAPI()

@app.post("/symptom-checker")
async def prediction(symptoms: Symptoms):
    # Request Input Data
    user_input_symptoms = symptoms.user_symptoms

    # Prediction
    result = predict(user_input_symptoms)
    health_condition =  result['health_condition']
    predicted_probability = result['predicted_probability']

    return {
        "health_condition": health_condition, 
        "predicted_probability": predicted_probability
        }
