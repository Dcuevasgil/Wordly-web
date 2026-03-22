# 🧠 Módulo Learning

## 🎯 Objetivo
Gestionar el aprendizaje del usuario: progreso, intentos, sesiones y revisión.

---

## 🗄️ Tablas implicadas
- user_words
- word_attempts
- study_sessions

---

## 🧠 Modelos

### UserWord.php
Tabla: user_words

Controla:
- progreso del usuario por palabra
- spaced repetition

---

### WordAttempt.php
Tabla: word_attempts

Controla:
- historial de respuestas
- errores

---

### StudySession.php
Tabla: study_sessions

Controla:
- sesiones de estudio
- estadísticas

---

## 🎮 Controladores

### LearningController.php

Métodos:
- getNextWord()
- submitAnswer()
- getUserProgress()
- startStudySession()
- finishStudySession()

---

## 🗄️ Migraciones

### create_user_words_table.php
Campos:
- id_user_words (PK)
- user_id (FK → users)
- word_id (FK → words)

- times_correct
- times_failed
- veces_reviewed

- days_interval
- ease_factor

- last_review
- next_review

- mastered_level

- register_date
- update_date

Restricción:
- UNIQUE(user_id, word_id)

---

### create_word_attempts_table.php
Campos:
- id_word_attempts (PK)
- user_id (FK → users)
- word_id (FK → words)

- user_response
- is_user_response_correct
- response_time_ms
- attempt_date

- register_date
- update_date

---

### create_study_sessions_table.php
Campos:
- id_study_sessions (PK)
- user_id (FK → users)

- start_date
- end_date

- total_words
- total_correct
- total_failures

- register_date
- update_date

---

## 🧾 Requests

### SubmitAnswerRequest.php
Valida:
- word_id
- user_response
- response_time_ms

### StudySessionRequest.php
Valida:
- inicio / fin de sesión

---

## 📦 Resources

- UserWordResource.php
- StudySessionResource.php

---

## ⚙️ Services

### NextWordService.php
Decide qué palabra mostrar

### EvaluateAnswerService.php
Valida respuesta

### UpdateUserWordProgressService.php
Actualiza progreso

### StudySessionService.php
Gestiona sesiones

---

## 🌐 Endpoints

- GET /api/learning/next-word
- POST /api/learning/answer
- GET /api/learning/progress
- POST /api/learning/study-session/start
- POST /api/learning/study-session/finish

---
