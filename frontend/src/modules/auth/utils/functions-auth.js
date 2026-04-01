


export function getToken() {

    // leo la info del token
    const token = localStorage.getItem("token");

    // Si no existe el token o ha caducado -> me redirige al login directo
    return token;

}


export function checkAuth() {

    // obtengo el token
    const token = fetch("/api/me", {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });

    if (token) {
        return "The user has been authenticated correctly"
    } else {
        console.error("The user is already authenticated");
    }
}