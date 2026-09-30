import { useEffect, useRef } from "react";
import MessageBubble from "./MessageBubble";

export default function MessageList({ messages, isSending }) {

    // Referencia al contenedor que tiene el scroll interno
    const listRef = useRef(null);


    // Cada vez que llega un mensaje o empieza/termina la espera, bajamos al final
    useEffect(() => {

        const list = listRef.current;

        // En el estado vacío no hay contenedor con ref
        if (!list) return;

        list.scrollTo({ top: list.scrollHeight, behavior: "smooth" });

    }, [messages, isSending]);


    // Conversación vacía: todavía no se ha enviado nada
    if (messages.length === 0 && !isSending) {
        return (
            <div className="chat-messages">
                <p className="chat-empty">Start the conversation</p>
            </div>
        );
    }

    return (
        <div className="chat-messages" ref={listRef}>

            {messages.map((message) => (
                <MessageBubble
                    key={message.id}
                    role={message.role}
                    content={message.content}
                />
            ))}

            {isSending && (
                <div
                    className="chat-bubble chat-bubble-assistant chat-typing-bubble"
                    role="status"
                    aria-label="Writing..."
                >
                    <span className="chat-typing-dot"></span>
                    <span className="chat-typing-dot"></span>
                    <span className="chat-typing-dot"></span>
                </div>
            )}

        </div>
    );
}