const API_URL = "http://localhost:8000/api";

// Obtener la cabecera de autenticación para peticiones
function getAuthHeaders() {

    const token = localStorage.getItem("token");

    return {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": `Bearer ${token}`,
    };

}

export async function getExercises() {

    const response = await fetch(`${API_URL}/learning/exercises`, {
        method: "GET",
        headers: getAuthHeaders(),
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.error || "Failed to fetch exercises");
    }

    return data.data;
}

export async function submitAnswer(payload) {
    
    const response = await fetch(`${API_URL}/learning/exercises/attempt`, {
        method: "POST",
        headers: getAuthHeaders(),
        body: JSON.stringify(payload),
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.message || "Failed to submit answer");
    }

    return data;
}