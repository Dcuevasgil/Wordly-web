import { useEffect, useState, useRef } from "react";
import { getExercises, submitAnswer } from "../services/exerciseService";

const SECONDS_PER_QUESTION = 30;

export default function Practice() {

  

  const [exercises, setExercises] = useState([]);
  const [currentIndex, setCurrentIndex] = useState(0);

  const [userAnswer, setUserAnswer] = useState("");
  const [result, setResult] = useState(null);

  const [timeLeft, setTimeLeft] = useState(SECONDS_PER_QUESTION);  

  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const startTime = useRef(Date.now());

  useEffect(() => {

    let cancelled = false;

    const fetchExercises = async () => {
      try {
        const data = await getExercises();
        if (!cancelled) setExercises(data);
      } catch (err) {
        if (!cancelled) setError(err.message);
      } finally {
        if (!cancelled) setLoading(false);
      }
    };

    fetchExercises();

    return () => { cancelled = true };
  }, []);

  
  const exercise = exercises[currentIndex];

  useEffect(() => {
    
    if (!exercise || result !== null || timeLeft <= 0) return;

    const timerId = setTimeout(() => setTimeLeft(timeLeft -1), 1000);

    return () => clearTimeout(timerId);
  }, [exercise, result, timeLeft]);


  const handleAnswer = async (answer, answerId = null) => {

    try {

      const isTimeout = answer === null;

      const data = await submitAnswer({
        exercise_id: exercise.id,
        user_responses: isTimeout ? [] : [answer],
        exercise_answer_id: answerId,
        response_time_ms: Date.now() - startTime.current,
      });

      setResult({
        isCorrect: data.is_correct,
        isTimeout,
        feedback: isTimeout ? "Pregunta sin responder ⏱️" : (data.is_correct ? "Correcto ✅" : "Incorrecto ❌"),
        correctAnswer: data.correct_answers[0],
        explanation: data.explanation,
      });

    } catch (err) {

      setError(err.message);
    
    }

  }

  useEffect(() => {
    if (timeLeft > 0 || result !== null || !exercise) return;

    handleAnswer(null);

  }, [timeLeft, result, exercise]);

  const nextExercise = () => {
    setUserAnswer("");
    setResult(null);
    setTimeLeft(SECONDS_PER_QUESTION);
    startTime.current = Date.now();

    if (currentIndex < exercises.length - 1) {
      setCurrentIndex(currentIndex + 1);
    } else {
      setCurrentIndex(0);
    }
  };

  if (loading) return <p>Cargando ejercicios...</p>;
  if (error) return <p>Error: {error}</p>
  if (!exercise) return <p>No hay ejercicios disponibles</p>;

  return (
    <div style={{ padding: "24px", maxWidth: "500px" }}>

      <p>Tiempo restante: {timeLeft}s</p>
      <h2>{exercise.question}</h2>

      {/* 🧠 SINGLE CHOICE */}
      {exercise.type === "single-choice" && (
        <div style={{ marginTop: "16px" }}>
          {exercise.options.map((option) => (
            <button
              key={option.id}
              onClick={() => handleAnswer(option.answer, option.id)}
              disabled={result !== null}
              style={{
                display: "block",
                marginBottom: "8px",
                padding: "10px",
                width: "100%",
                borderRadius: "8px",
                cursor: "pointer"
              }}
            >
              {option.answer}
            </button>
          ))}
        </div>
      )}

      {/* 🧠 FILL BLANK */}
      {exercise.type === "fill-blank" && (
        <>
          <input
            type="text"
            value={userAnswer}
            onChange={(e) => setUserAnswer(e.target.value)}
            placeholder="Escribe tu respuesta..."
            style={{
              width: "100%",
              padding: "12px",
              marginTop: "12px",
              borderRadius: "8px",
              border: "1px solid #ccc"
            }}
          />

          <button
            onClick={() => handleAnswer(userAnswer)}
            disabled={result !== null}
            style={{
              marginTop: "12px",
              padding: "10px 16px",
              borderRadius: "8px",
              cursor: "pointer"
            }}
          >
            Comprobar
          </button>
        </>
      )}

      {/* 📊 RESULTADO */}
      {result && (
        <div style={{ marginTop: "20px" }}>
          <p>{result.feedback}</p>

          {!result.isCorrect && (
            <>
              <p>
                <strong>Respuesta correcta:</strong>{" "}
                {result.correctAnswer}
              </p>
              <p>{result.explanation}</p>
            </>
          )}

          <button
            onClick={nextExercise}
            style={{
              marginTop: "12px",
              padding: "8px 14px",
              borderRadius: "8px",
              cursor: "pointer"
            }}
          >
            Siguiente
          </button>
        </div>
      )}
    </div>
  );
}