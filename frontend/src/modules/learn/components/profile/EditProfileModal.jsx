export default function EditProfileModal({
    isOpen,
    onClose,
    origin,
    user,
    setUser
}) {

    const handleChange = (field, value) => {
        setUser(prev => ({
            ...prev,
            [field]: value
        }));
    };

    const handleSave = () => {
        console.log("Perfil editado:", user);
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
                    <h2>Editar perfil</h2>

                    <button className="modal-close" onClick={onClose}>
                        ✕
                    </button>
                </div>

                <div className="modal-body flex direction-column gap-12">
                    <div className="modal-section">
                        <label>Nombre</label>
                        <input
                            type="text"
                            value={user.name}
                            onChange={(e) => handleChange("name", e.target.value)}
                        />
                    </div>

                    <div className="modal-section">
                        <label>Nivel</label>
                        <select
                            value={user.level}
                            onChange={(e) => handleChange("level", e.target.value)}
                        >
                            <option value="">Selecciona tu nivel</option>
                            <option value="principiante">Principiante</option>
                            <option value="intermedio">Intermedio</option>
                            <option value="avanzado">Avanzado</option>
                        </select>
                    </div>
                </div>

                <div className="modal-footer">
                    <button onClick={onClose}>
                        Cancelar
                    </button>

                    <button onClick={handleSave}>
                        Guardar cambios
                    </button>
                </div>
            </div>
        </div>
    );
}