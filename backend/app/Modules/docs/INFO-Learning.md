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

- `GET /api/learning/next-word`
- `POST /api/learning/answer`
- `GET /api/learning/progress`
- `POST /api/learning/study-session/start`
- `POST /api/learning/study-session/finish`

---

## 📝 Examen de nivel (assessment)

### Objetivo
Calcular el nivel real del usuario a partir de sus respuestas y asignarlo en `user_paths.level`.

### Decisiones tomadas
- **Cálculo por umbral global** (% de aciertos totales). Alternativa por bloques descartada para el MVP.
- **Sin persistencia**: no se guarda el examen ni las respuestas. El nivel anterior se sobrescribe sin dejar rastro. El examen tampoco escribe en `exercise_attempts`.
- El examen es **el mismo para todos**: no depende del nivel declarado en el onboarding.
- **Reparto fijo**: 4 ejercicios por nivel (12 en total). Con umbral global el resultado depende directamente de la composición.
- **Selección aleatoria** (`inRandomOrder()`) dentro de cada nivel. Hoy solo tiene efecto en `basic`, que es el único con más de 4 ejercicios disponibles.
- **Fallo ruidoso** si algún nivel no llega a 4 ejercicios: `RuntimeException`. Un examen incompleto rompería los umbrales en silencio.
- **`error_code: onboarding_required`** (403) si el usuario no tiene matrícula activa. Mismo código que `getExercisesByTopic()`.

### Configuración
`config/filter-quiz.php` → clave `assessment`:
- `total_exercises`: 12
- `per_level`: 4
- `thresholds`: intermediate 33, advanced 67 (inclusivos)

`levels` en ese mismo archivo es la fuente única de la jerarquía de niveles.

### Endpoints
- `GET /api/learning/assessment` → devuelve los 12 ejercicios (sin soluciones)
- `POST /api/learning/assessment` → recibe respuestas, calcula y asigna nivel

### Contenido
14 ejercicios en total: 6 basic, 4 intermediate, 4 advanced.

**Criterio de nivel**: orden del temario de inglés, no dificultad percibida.
El nivel es propiedad del **tema** (`topic_exercise`), no del ejercicio individual:
dos ejercicios del mismo topic no pueden estar en niveles distintos.

Columna `code` (`VARCHAR(50) UNIQUE`) como identificador estable. Formato `topic-NN`.
Mismo patrón que `languages.code` y `learning_paths.code`: `code` es el identificador
máquina, `question` es el texto que puede cambiar sin romper nada.

`ExerciseSeeder` es idempotente vía `updateOrCreate`. Las respuestas se identifican
por `exercise_id` + `answer`. Verificado: dos pasadas seguidas dejan 14 ejercicios
y 56 respuestas.

### Deuda abierta
- Sin historial de exámenes → si se necesita, retrofit a tabla `assessments`
- No se puede limitar el número de intentos (no hay registro)
- Preguntas en blanco: hoy `required`. Si se permiten → `nullable`
- Ventana entre el `exists()` del controller y el `update()` del servicio: la matrícula
  podría desaparecer en medio. Irrelevante en MVP, pero la comprobación en el servicio
  seguiría siendo la red de seguridad correcta
- `config()` devuelve `null` silenciosamente si la clave no existe. Un typo en el nombre
  de una clave produjo un examen de 14 preguntas con un 200. Las claves leídas en runtime
  deberían validarse
- **Este documento describe estructura que no existe**: `LearningController`,
  `NextWordService`, `EvaluateAnswerService`, `StudySessionService`,
  `SubmitAnswerRequest` y los endpoints `next-word` / `progress` / `study-session`
  no están implementados. Pendiente reescritura completa del documento