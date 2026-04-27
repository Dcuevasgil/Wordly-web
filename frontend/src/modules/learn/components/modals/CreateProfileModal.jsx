import { useState } from "react";

export default function CreateProfileModal({ 
    isOpen, 
    onClose, 
    origin 
}) {

    const [user, setUser] = useState({
        name: "David",
        level: "Intermedio",
        streak: 56
    });

    const handleChange = (field, value) => {
        setUser(prev => ({
            ...prev,
            [field]: value
        }));
    };

    const handleSave = () => {
        console.log("Guardar usuario:", user);
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

                {/* HEADER */}
                <div className="modal-header flex justify-between items-center">
                    <h2>Mi perfil</h2>

                    <button 
                        className="modal-close"
                        onClick={onClose}
                    >
                        ✕
                    </button>
                </div>

                <div className="modal-body flex direction-column gap-12">

                    {/* NOMBRE */}
                    <div className="modal-section">
                        <label>Nombre</label>
                        <input
                            type="text"
                            value={user.name}
                            onChange={(e) => handleChange("name", e.target.value)}
                        />
                    </div>

                    {/* NIVEL */}
                    <div className="modal-section">
                        <label>Nivel</label>
                        <select
                            value={user.level}
                            onChange={(e) => handleChange("level", e.target.value)}
                        >
                            <option>Principiante</option>
                            <option>Intermedio</option>
                            <option>Avanzado</option>
                        </select>
                    </div>

                    {/* RACHA */}
                    <div className="modal-section">
                        <label>Racha</label>
                        <input /><span></span>
                    </div>

                </div>

                {/* FOOTER */}
                <div className="modal-footer">
                    <button onClick={handleSave}>
                        Guardar cambios
                    </button>
                </div>

            </div>

        </div>
    );
}