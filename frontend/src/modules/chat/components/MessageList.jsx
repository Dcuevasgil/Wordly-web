import MessageBubble from "./MessageBubble";

export default function MessageList({ messages, isSending }) {

    // Conversación vacía: todavía no se ha enviado nada
    if (messages.length === 0 && !isSending) {
        return (
            <div className="chat-messages">
                <p className="chat-empty">Start the conversation</p>
            </div>
        );
    }

    return (
        <div className="chat-messages">

            {messages.map((message) => (
                <MessageBubble
                    key={message.id}
                    role={message.role}
                    content={message.content}
                />
            ))}

            {isSending && <p className="chat-typing">Writing...</p>}

        </div>
    );
}