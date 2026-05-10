import { useState } from "react";

export default function ChangeCourseModal({
    isOpen,
    onClose,
    origin
}) {
    const courses = [
        {
            id: "english-general",
            title: "Inglés general",
            description: "Practica vocabulario, gramática y comprensión general.",
            icon: "language"
        },
        {
            id: "phrasal-verbs",
            title: "Phrasal Verbs",
            description: "Domina expresiones comunes del inglés real.",
            icon: "school"
        },
        {
            id: "developer-english",
            title: "Inglés para developers",
            description: "Aprende vocabulario técnico para programación.",
            icon: "code"
        },
        {
            id: "exam-practice",
            title: "Preparación de examen",
            description: "Entrena con tests y preguntas tipo examen.",
            icon: "assignment"
        }
    ];

    const [selectedCourse, setSelectedCourse] = useState("english-general");

    const handleSaveCourse = () => {
        console.log("Curso guardado:", selectedCourse);
        onClose();
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
                    <h2>Cambiar curso</h2>

                    <button className="modal-close" onClick={onClose}>
                        ✕
                    </button>
                </div>

                <div className="modal-body flex direction-column gap-12">

                    <div className="modal-section">
                        <label>Curso actual</label>
                        <input 
                            value={
                                courses.find(course => course.id === selectedCourse)?.title
                            } 
                            readOnly 
                        />
                    </div>

                    <div className="modal-section">
                        <label>Selecciona nuevo curso</label>

                        <div className="course-card-grid">
                            {courses.map((course) => (
                                <button
                                    key={course.id}
                                    type="button"
                                    className={`course-card ${
                                        selectedCourse === course.id ? "active" : ""
                                    }`}
                                    onClick={() => setSelectedCourse(course.id)}
                                >
                                    <md-icon>{course.icon}</md-icon>

                                    <h3>{course.title}</h3>

                                    <p>{course.description}</p>
                                </button>
                            ))}
                        </div>
                    </div>

                    <div className="modal-section">
                        <label>Qué cambiará</label>
                        <p className="modal-info">
                            Al cambiar de curso, tus próximas lecciones y tests se adaptarán al nuevo contenido.
                        </p>
                    </div>

                </div>

                <div className="modal-footer">
                    <button onClick={onClose}>
                        Cancelar
                    </button>

                    <button onClick={handleSaveCourse}>
                        Guardar curso
                    </button>
                </div>
            </div>
        </div>
    );
}