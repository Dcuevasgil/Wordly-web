import { useState } from "react";
import { sendMessage as sendMessageRequest } from "../services/chatService";
import { getChatErrorText } from "../utils/chatErrors";

export function useChat() {

    // Variables de estado
    const [messages, setMessages] = useState([]);
    const [conversationId, setConversationId] = useState(null);
    const [isSending, setIsSending] = useState(false);


    async function send(content) {

        // Nada que enviar, o ya hay un envío en curso
        if (!content?.trim() || isSending) return;

        // Mensaje provisional: se pinta ya, sin esperar al backend
        const optimisticMessage = {
            id: `temp-${Date.now()}`,
            role: "user",
            content,
        };

        setMessages((current) => [...current, optimisticMessage]);
        setIsSending(true);

        try {
            const data = await sendMessageRequest(content, conversationId);

            // El historial real sustituye al provisional
            setConversationId(data.conversation_id);
            setMessages(data.messages);

        } catch (err) {
            // Tu mensaje se queda y debajo aparece la burbuja de error
            const errorMessage = {
                id: `error-${Date.now()}`,
                role: "error",
                content: getChatErrorText(err),
                status: err.status ?? null,
            };

            setMessages((current) => [...current, errorMessage]);

        } finally {
            setIsSending(false);
        }

    }


    return { messages, conversationId, isSending, send };
}