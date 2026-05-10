export default function AchievementUnlockedModal({
  isOpen,
  onClose,
  achievement
}) {
  if (!achievement) return null;

  return (
    <div 
      className={`achievement-unlocked-overlay ${isOpen ? "active" : ""}`}
      onClick={onClose}
    >
      <div
        className="achievement-unlocked-modal"
        onClick={(e) => e.stopPropagation()}
      >
        <div className="achievement-unlocked-header">
          <h2>¡Felicidades, has completado un logro!</h2>
        </div>

        <div className="achievement-unlocked-body">
          <md-icon>{achievement.icon}</md-icon>

          <h3>{achievement.title}</h3>

          <p>{achievement.description}</p>
        </div>

        <div className="achievement-unlocked-footer">
          <button onClick={onClose}>
            Cerrar
          </button>
        </div>
      </div>
    </div>
  );
}