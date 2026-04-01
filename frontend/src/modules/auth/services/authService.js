const API_URL = "http://localhost:8000/api";

export async function handleLogin(credentials) {
    // Respuesta de la API
    const response = await fetch(`${API_URL}/login`, {
        method: "POST",
        
        headers: {

            "Content-Type": "application/json",
            "Accept": "application/json",

        },

        body: JSON.stringify(credentials),
    });

    const data = await response.json();

    if (!response.ok) {

        throw new Error(data.message || "Login failed");

    }

    return credentials;

}

export async function handleRegister(userData) {

    // Respuesta de la API
    const response = await fetch(`${API_URL}/register`, {
        method: "POST",
        
        headers: {

            "Content-Type": "application/json",
            "Accept": "application/json",

        },

        body: JSON.stringify(userData),
    });

    const data = await response.json();

    if (!response.ok) {

        throw new Error(data.message || "Register failed");

    }

    return userData;

}