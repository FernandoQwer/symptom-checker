import pickle
import pandas as pd
import numpy as np

from module.user_symptoms import get_user_symptoms

with open('symptoms_checker.pkl', 'rb') as file:
    symptom_checker = pickle.load(file)

ensemble_clf = symptom_checker['ensemble_model']
label_encoder = symptom_checker['label_encoder']
symptoms = symptom_checker['symptoms']


def predict(user_input_symptoms):
    user_symptoms = pd.DataFrame(get_user_symptoms(symptoms, user_input_symptoms))

    ensemble_prediction = ensemble_clf.predict(user_symptoms)
    predicted_probabilities = ensemble_clf.predict_proba(user_symptoms)

    # prediction index
    predicted_index = np.argmax(predicted_probabilities)
    predicted_probability = predicted_probabilities[0][predicted_index] * 100

    # Decode
    health_condition = label_encoder.inverse_transform(ensemble_prediction)

    result = {
        'health_condition': health_condition[0],
        'predicted_probability': f"{predicted_probability:.2f}"
    }

    return result

