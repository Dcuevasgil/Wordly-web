export default function MessageBubble({ role, content, status }) {

    // Burbuja de error: estilo propio y código si lo hay
    if (role === "error") {
        return (
            <div className="chat-bubble chat-bubble-error" role="alert">
                <p>{content}</p>
                {status && <span className="chat-bubble-error-code">Error {status}</span>}
            </div>
        );
    }

    // La clase depende de quién escribe el mensaje
    const className = role === "user"
        ? "chat-bubble chat-bubble-user"
        : "chat-bubble chat-bubble-assistant";

    return <div className={className}>{content}</div>;
}