export default function MessageBubble({ role, content }) {

    // La clase depende de quién escribe el mensaje
    const className = role === "user"
        ? "chat-bubble chat-bubble-user"
        : "chat-bubble chat-bubble-assistant";

    return <div className={className}>{content}</div>;
}