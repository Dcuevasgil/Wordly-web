export default function LogoutConfirmModal({
    isOpen,
    onClose,
    origin,
    onConfirm
}) {
    return (
        <div
            className={`profile-overlay ${isOpen ? "active" : ""}`}
            onClick={onClose}
        >
            <div
                className="logout-modal"
                style={{
                    "--origin-x": `${origin.x}px`,
                    "--origin-y": `${origin.y}px`
                }}
                onClick={(e) => e.stopPropagation()}
            >
                <div className="logout-modal-header">
                    <h2>Cerrar sesión</h2>
                </div>

                <div className="logout-modal-body">
                    <p>¿Seguro que quieres cerrar sesión?</p>
                    <span>Tendrás que volver a iniciar sesión para entrar en Wordly.</span>
                </div>

                <div className="logout-modal-footer">
                    <button onClick={onClose}>
                        Cancelar
                    </button>

                    <button onClick={onConfirm}>
                        Cerrar sesión
                    </button>
                </div>
            </div>
        </div>
    );
}