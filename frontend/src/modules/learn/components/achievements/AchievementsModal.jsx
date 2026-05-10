const achievementsByCourse = {
    "english-general": [
        {
            id: 1,
            title: "Primer paso",
            description: "Completa tu primera lección de inglés general.",
            unlocked: true,
            icon: "flag"
        },
        {
            id: 2,
            title: "Racha inicial",
            description: "Estudia durante 3 días seguidos.",
            unlocked: true,
            icon: "local_fire_department"
        },
        {
            id: 3,
            title: "Vocabulario activo",
            description: "Aprende 25 palabras nuevas.",
            unlocked: false,
            icon: "menu_book"
        },
        {
            id: 4,
            title: "Constancia",
            description: "Completa 10 tests de repaso.",
            unlocked: false,
            icon: "workspace_premium"
        }
    ],

    "phrasal-verbs": [
        {
            id: 1,
            title: "Phrasal Starter",
            description: "Aprende tus primeros 5 phrasal verbs.",
            unlocked: true,
            icon: "rocket_launch"
        },
        {
            id: 2,
            title: "No te rindas",
            description: "Completa 3 tests de phrasal verbs.",
            unlocked: false,
            icon: "psychology"
        },
        {
            id: 3,
            title: "Modo conversación",
            description: "Usa 10 phrasal verbs en ejercicios prácticos.",
            unlocked: false,
            icon: "forum"
        }
    ],

    "developer-english": [
        {
            id: 1,
            title: "Hello, dev",
            description: "Aprende tus primeras 10 palabras técnicas.",
            unlocked: true,
            icon: "code"
        },
        {
            id: 2,
            title: "API Master",
            description: "Completa una lección sobre vocabulario de APIs.",
            unlocked: false,
            icon: "hub"
        },
        {
            id: 3,
            title: "Debugging English",
            description: "Supera un test de errores comunes en inglés técnico.",
            unlocked: false,
            icon: "bug_report"
        }
    ],

    "exam-practice": [
        {
            id: 1,
            title: "Primer simulacro",
            description: "Completa tu primer test tipo examen.",
            unlocked: true,
            icon: "assignment"
        },
        {
            id: 2,
            title: "Precisión seria",
            description: "Consigue un 80% o más en un test.",
            unlocked: false,
            icon: "target"
        },
        {
            id: 3,
            title: "Preparado para examen",
            description: "Completa 5 tests de examen.",
            unlocked: false,
            icon: "school"
        }
    ]
};

const courseNames = {
    "english-general": "Inglés general",
    "phrasal-verbs": "Phrasal Verbs",
    "developer-english": "Inglés para developers",
    "exam-practice": "Preparación de examen"
};

export default function AchievementsModal({
    isOpen,
    onClose,
    origin,
    selectedCourse
}) {
    const achievements = achievementsByCourse[selectedCourse] || [];

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
                    <h2>Logros</h2>

                    <button className="modal-close" onClick={onClose}>
                        ✕
                    </button>
                </div>

                <div className="modal-body flex direction-column gap-12">

                    <div className="modal-section">
                        <label>Curso actual</label>
                        <input 
                            value={courseNames[selectedCourse] || "Curso no seleccionado"} 
                            readOnly 
                        />
                    </div>

                    <div className="modal-section">
                        <label>Logros del curso</label>

                       <div className="achievement-grid">
                            {achievements.map((achievement) => (
                                <div
                                    key={achievement.id}
                                    className={`achievement-card ${
                                        achievement.unlocked ? "unlocked" : "locked"
                                    }`}
                                >
                                    <md-icon>{achievement.icon}</md-icon>

                                    <div className="achievement-info">
                                        <h3>{achievement.title}</h3>
                                        <p>{achievement.description}</p>
                                    </div>

                                    <span className="achievement-status">
                                        {achievement.unlocked ? "Desbloqueado" : "Bloqueado"}
                                    </span>
                                </div>
                            ))}
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