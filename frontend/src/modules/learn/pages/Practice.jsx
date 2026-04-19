import { useEffect, useState } from "react";

export default function Practice() {

  // 📦 STATE
  const [exercises, setExercises] = useState([]);
  const [currentIndex, setCurrentIndex] = useState(0);

  const [userAnswer, setUserAnswer] = useState("");
  const [result, setResult] = useState(null);

  const [loading, setLoading] = useState(true);

  // 🔑 TOKEN (ajústalo a tu sistema)
  const token = localStorage.getItem("token");

  // 📡 FETCH EJERCICIOS
  useEffect(() => {
    const fetchExercises = async () => {
      try {
        const res = await fetch("/api/learning/exercises", {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json"
          }
        });

        const data = await res.json();

        setExercises(data.data || []);
        setLoading(false);

      } catch (error) {
        console.error("Error fetching exercises:", error);
        setLoading(false);
      }
    };

    fetchExercises();
  }, []);

  // 🔄 EJERCICIO ACTUAL
  const exercise = exercises[currentIndex];

  // 🔧 NORMALIZAR
  const normalize = (text) =>
    text
      .toLowerCase()
      .trim()
      .replace(/[.,!?]/g, "")
      .replace(/\s+/g, " ");

  // ⚖️ COMPROBAR
  const checkAnswer = () => {
    const normalizedUser = normalize(userAnswer);

    const isCorrect = exercise.correct_answers.some(
      (answer) => normalize(answer) === normalizedUser
    );

    let feedback = "";

    if (isCorrect) {
      feedback = "Correcto ✅";
    } else if (normalizedUser.includes("will")) {
      feedback =
        "Casi correcto ⚠️. Has usado 'will', pero aquí se esperaba un plan → 'going to'.";
    } else if (
      normalizedUser.includes("going to") &&
      !normalizedUser.includes("am") &&
      !normalizedUser.includes("is") &&
      !normalizedUser.includes("are")
    ) {
      feedback =
        "Casi correcto ⚠️. Te falta el verbo 'to be' (am/is/are).";
    } else {
      feedback = "Incorrecto ❌";
    }

    setResult({
      isCorrect,
      feedback,
      correctAnswer: exercise.correct_answers[0],
      explanation: exercise.explanation
    });
  };

  // 🔄 SIGUIENTE EJERCICIO
  const nextExercise = () => {
    setUserAnswer("");
    setResult(null);

    if (currentIndex < exercises.length - 1) {
      setCurrentIndex(currentIndex + 1);
    } else {
      // 🔁 Reiniciar o volver a pedir más ejercicios
      setCurrentIndex(0);
    }
  };

  // ⏳ LOADING
  if (loading) return <p>Cargando ejercicios...</p>;

  if (!exercise) return <p>No hay ejercicios disponibles</p>;

  return (
    <div style={{ padding: "24px", maxWidth: "500px" }}>

      {/* 📄 PREGUNTA */}
      <h2>{exercise.question}</h2>

      {/* 🖊️ INPUT */}
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

      {/* 🔘 BOTÓN */}
      <button
        onClick={checkAnswer}
        style={{
          marginTop: "12px",
          padding: "10px 16px",
          borderRadius: "8px",
          cursor: "pointer"
        }}
      >
        Comprobar
      </button>

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

          {/* 🔄 SIGUIENTE */}
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