const API_URL = "http://localhost:8000/api";

export async function handleLogin(credentials) {

    const response = await fetch(`${API_URL}/login`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        body: JSON.stringify(credentials),
    });

    const data = await response.json();
    console.log("RESPUESTA LOGIN:", data);
    

    if (!response.ok) {
        throw new Error(data.message || "Login failed");
    }

    const token = data.data.access_token;

    localStorage.setItem("token", token);
    console.log("TOKEN GUARDADO:", localStorage.getItem("token"));
    

    return data.data;
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

    const token = data.data.access_token;

    localStorage.setItem("token", token)

    return data.data;

}