export default function ProgressModal({
    isOpen,
    onClose,
    origin,
    selectedCourse,
    setSelectedCourse
}) {
    const courseNames = {
        "english-general": "Inglés general",
        "phrasal-verbs": "Phrasal Verbs",
        "developer-english": "Inglés para developers",
        "exam-practice": "Preparación de examen"
    };

    const progressData = {
        generalProgress: 65,
        completedLessons: 13,
        totalLessons: 20,
        averageAccuracy: 43,
        pendingReviews: 3,
        streak: 0,
        learnedWords: 25,
        completedTests: 8,
        lastLesson: "Present simple",
        lastTest: "Test por temas"
    };

    return (
        <div
            className={`profile-overlay ${isOpen ? "active" : ""}`}
            onClick={onClose}
        >
            <div
                className="profile-modal modal-base"
                style={{
                    "--origin-x": `${origin.x}px`,
                    "--origin-y": `${origin.y}px`
                }}
                onClick={(e) => e.stopPropagation()}
            >
                <div className="modal-header flex justify-between items-center">
                    <h2>Mi progreso</h2>

                    <button className="modal-close" onClick={onClose}>
                        ✕
                    </button>
                </div>

                <div className="modal-body flex direction-column gap-12">
                    <div className="modal-section">
                        <label>Curso actual</label>
                        
                        <select
                            value={selectedCourse}
                            onChange={(e) => setSelectedCourse(e.target.value)}
                        >
                            <option value="english-general">
                                Inglés general
                            </option>

                            <option value="phrasal-verbs">
                                Phrasal Verbs
                            </option>

                            <option value="developer-english">
                                Inglés para developers
                            </option>

                            <option value="exam-practice">
                                Preparación de examen
                            </option>
                        </select>
                    </div>

                    <div className="progress-grid">
                        <div className="progress-card">
                            <span>Progreso general</span>
                            <strong>{progressData.generalProgress}%</strong>
                            <small>Curso completado</small>
                        </div>

                        <div className="progress-card">
                            <span>Lecciones</span>
                            <strong>
                                {progressData.completedLessons}/{progressData.totalLessons}
                            </strong>
                            <small>Completadas</small>
                        </div>

                        <div className="progress-card">
                            <span>Precisión media</span>
                            <strong>{progressData.averageAccuracy}%</strong>
                            <small>En tests realizados</small>
                        </div>

                        <div className="progress-card">
                            <span>Racha actual</span>
                            <strong>{progressData.streak} días 🔥</strong>
                            <small>Actividad seguida</small>
                        </div>

                        <div className="progress-card">
                            <span>Revisiones</span>
                            <strong>{progressData.pendingReviews}</strong>
                            <small>Pendientes hoy</small>
                        </div>

                        <div className="progress-card">
                            <span>Vocabulario</span>
                            <strong>{progressData.learnedWords}</strong>
                            <small>Palabras aprendidas</small>
                        </div>
                    </div>

                    <div className="modal-section">
                        <label>Actividad reciente</label>

                        <div className="progress-activity">
                            <div>
                                <span>Última lección</span>
                                <strong>{progressData.lastLesson}</strong>
                            </div>

                            <div>
                                <span>Último test</span>
                                <strong>{progressData.lastTest}</strong>
                            </div>

                            <div>
                                <span>Tests completados</span>
                                <strong>{progressData.completedTests}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="modal-footer">
                    <button onClick={onClose}>
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    );
}