import { useEffect, useState } from "react";

export default function Practice() {

  const [exercises, setExercises] = useState([]);
  const [currentIndex, setCurrentIndex] = useState(0);

  const [userAnswer, setUserAnswer] = useState("");
  const [result, setResult] = useState(null);

  const [loading, setLoading] = useState(true);

  const token = localStorage.getItem("token");

  const API_URL = "http://localhost:8000";


  console.log("TOKEN:", token);
  useEffect(() => {
    const fetchExercises = async () => {
      try {
        const res = await fetch(`${API_URL}/api/learning/exercises`, {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json"
          }
        });

        const data = await res.json();

        setExercises(data.data || []);
        setLoading(false);

        console.log(data)

      } catch (error) {
        console.error("Error fetching exercises:", error);
        setLoading(false);
      }
    };

    fetchExercises();
  }, []);

  const exercise = exercises[currentIndex];

  const normalize = (text) =>
    text
      .toLowerCase()
      .trim()
      .replace(/[.,!?]/g, "")
      .replace(/\s+/g, " ");

  // 🔥 CHECK ANSWER (GENÉRICO)
  const checkAnswer = (answer) => {

    const normalizedUser = normalize(answer);

    const isCorrect = exercise.correct_answers.some(
      (a) => normalize(a) === normalizedUser
    );

    setResult({
      isCorrect,
      feedback: isCorrect ? "Correcto ✅" : "Incorrecto ❌",
      correctAnswer: exercise.correct_answers[0],
      explanation: exercise.explanation
    });
  };

  const nextExercise = () => {
    setUserAnswer("");
    setResult(null);

    if (currentIndex < exercises.length - 1) {
      setCurrentIndex(currentIndex + 1);
    } else {
      setCurrentIndex(0);
    }
  };

  if (loading) return <p>Cargando ejercicios...</p>;
  if (!exercise) return <p>No hay ejercicios disponibles</p>;

  return (
    <div style={{ padding: "24px", maxWidth: "500px" }}>

      <h2>{exercise.question}</h2>

      {/* 🧠 SINGLE CHOICE */}
      {exercise.type === "single-choice" && (
        <div style={{ marginTop: "16px" }}>
          {exercise.correct_answers.map((answer, index) => (
            <button
              key={index}
              onClick={() => checkAnswer(answer)}
              style={{
                display: "block",
                marginBottom: "8px",
                padding: "10px",
                width: "100%",
                borderRadius: "8px",
                cursor: "pointer"
              }}
            >
              {answer}
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
            onClick={() => checkAnswer(userAnswer)}
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