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

        // Guardamos la lista actual por si hay que deshacer
        const previousMessages = messages;

        // Mensaje provisional: se pinta ya, sin esperar al backend
        const optimisticMessage = {
            id: `temp-${Date.now()}`,
            role: "user",
            content,
        };

        setMessages((current) => [...current, optimisticMessage]);
        setIsSending(true);
        setError(null);

        try {
            const data = await sendMessageRequest(content, conversationId);

            // El historial real sustituye al provisional
            setConversationId(data.conversation_id);
            setMessages(data.messages);

        } catch (err) {
            // Si falla, quitamos el mensaje provisional
            setMessages(previousMessages);
            setError(err.message);

        } finally {
            setIsSending(false);
        }

    }


    return { messages, conversationId, isSending, error, send };
}