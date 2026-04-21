import React from "react";

export default function CreateProfileModal({ 
    isOpen, 
    onClose, 
    origin 
}) {
    return (
        <div className={`profile-overlay ${isOpen ? "active" : ""}`} onClick={onClose}>
  
            <div
                className="profile-modal"
                style={{
                "--origin-x": `${origin.x}px`,
                "--origin-y": `${origin.y}px`
                }}
                onClick={(e) => e.stopPropagation()}
            >
                <h1>Mi perfil</h1>
            </div>

        </div>
    );
}