export default function Modal({ 
    onClose,
    children,
}) {
    <div className="modal-overlay">
        
        <div className="modal">
        
            {children}
            <button onClick={onClose}>Cerrar</button>
        
        </div>
        
    </div>
}