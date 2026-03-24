import '../../../styles/components/modal.css';

export default function Modal({ 
    onClose,
    children,
    type
}) {
    return (

        <div 
            className="modal-overlay" 
            onClick={onClose}
            >
            
            <div 
                className={`modal-content modal-${type}`}
                onClick={(e) => e.stopPropagation()}
                >
            
                <button 
                    className="modal-close"
                    onClick={onClose}
                    >
                        ✕
                </button>

                <div className="group-icon-title">

                    <div className="modal-icon">
                        {type === "success" && "✅"}
                        {type === "error" && "❌"}
                    </div>

                    <h3 className="modal-title">
                        {type === "success" ? "Success" : "Error"}
                    </h3>
                </div>

                <p className="modal-message">
                    {children}
                </p>
            
            </div>
            
        </div>
    );
}