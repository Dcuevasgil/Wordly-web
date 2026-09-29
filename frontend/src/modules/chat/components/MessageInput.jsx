import { useState } from "react";

export default function MessageInput({ onSend, isSending }) {

    const [value, setValue] = useState("");


    function handleSend() {

        // Sin contenido o con un envío en curso, no se hace nada
        if (!value.trim() || isSending) return;

        onSend(value);
        setValue("");
    }


    function handleKeyDown(event) {

        // Enter envía; Shift+Enter hace salto de línea
        if (event.key === "Enter" && !event.shiftKey) {
            event.preventDefault();
            handleSend();
        }
    }


    return (
        <div className="chat-input-bar">

            <textarea
                value={value}
                onChange={(event) => setValue(event.target.value)}
                onKeyDown={handleKeyDown}
                placeholder="Write your message..."
                rows={1}
            />

            <button
                type="button"
                className="chat-send-button"
                onClick={handleSend}
                disabled={isSending || !value.trim()}
            >
                Send
            </button>

        </div>
    );
}