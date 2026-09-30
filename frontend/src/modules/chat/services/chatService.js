const API_URL = import.meta.env.VITE_API_URL;

// Tiempo máximo de espera: el arranque en frío de Ollama ronda los 13 s
const REQUEST_TIMEOUT_MS = 60000;

// Error con tipo ("network", "timeout", "http") y código HTTP si lo hay
function createChatError(type, status = null) {
    const error = new Error(type);
    error.type = type;
    error.status = status;
    return error;
}

function authHeaders() {
    return {
        "Authorization": `Bearer ${localStorage.getItem("token")}`,
        "Accept": "application/json",
    };
}


export async function getConversations(page = 1) {

    const response = await fetch(`${API_URL}/chat/conversations?page=${page}`, {
        method: "GET",
        headers: authHeaders(),
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.message || "Could not load conversations");
    }

    return data;

}


export async function getConversationMessages(conversationId) {

    const response = await fetch(`${API_URL}/chat/conversations/${conversationId}/messages`, {
        method: "GET",
        headers: authHeaders(),
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.message || "Could not load messages");
    }

    return data;
}


export async function sendMessage(content, conversationId = null) {

    // Permite cortar la petición si tarda demasiado
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), REQUEST_TIMEOUT_MS);

    let response;

    try {
        response = await fetch(`${API_URL}/chat/message`, {
            method: "POST",
            headers: {
                ...authHeaders(),
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                content,
                conversation_id: conversationId,
            }),
            signal: controller.signal,
        });

    } catch (err) {
        // AbortError: lo cortamos nosotros por tiempo
        if (err.name === "AbortError") {
            throw createChatError("timeout");
        }

        // Cualquier otro fallo aquí: no se pudo conectar
        throw createChatError("network");

    } finally {
        clearTimeout(timeoutId);
    }

    // El servidor respondió, pero con error
    if (!response.ok) {
        throw createChatError("http", response.status);
    }

    return await response.json();
}