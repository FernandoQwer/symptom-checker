def get_user_symptoms(symptoms, user_input_symptoms):
  temp_symptoms = symptoms.copy()

  # Update Symptoms
  for symptom in temp_symptoms:
    for user_symptom in user_input_symptoms:
      if(symptom == user_symptom):
        temp_symptoms[symptom] = [1]

  return temp_symptoms