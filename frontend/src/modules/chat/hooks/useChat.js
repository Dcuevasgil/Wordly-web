import { useState } from "react";
import { sendMessage as sendMessageRequest } from "../services/chatService";

export function useChat() {

    // Variables de estado
    const [messages, setMessages] = useState([]);
    const [conversationId, setConversationId] = useState(null);
    const [isSending, setIsSending] = useState(false);
    const [error, setError] = useState(null);


    async function send(content) {

        // Nada que enviar, o ya hay un envío en curso
        if (!content?.trim() || isSending) return;

        setIsSending(true);
        setError(null);

        try {
            const data = await sendMessageRequest(content, conversationId);

            setConversationId(data.conversation_id);
            setMessages(data.messages);

        } catch (err) {
            setError(err.message);

        } finally {
            setIsSending(false);
        }

    }


    return { messages, conversationId, isSending, error, send };
}