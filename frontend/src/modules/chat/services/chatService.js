const API_URL = import.meta.env.VITE_API_URL;

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

    const response = await fetch(`${API_URL}/chat/message`, {
        method: "POST",
        headers: {
            ...authHeaders(),
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            content,
            conversation_id: conversationId,
        }),
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.message || "Could not send messages");
    }

    return data;
}