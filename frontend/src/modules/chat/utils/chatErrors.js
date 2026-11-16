// Textos que ve el usuario según el tipo de error
const ERROR_TEXTS = {
    network: "Can't connect to the server. Check your connection and try again.",
    timeout: "The response is taking too long. Please try again.",
    401: "Your session has expired. Please log in again.",
    429: "You're sending messages too fast. Wait a moment and try again.",
    default: "Something went wrong on our side. Please try again.",
};


export function getChatErrorText(error) {

    // Sin respuesta del servidor: no hay código
    if (error.type === "network" || error.type === "timeout") {
        return ERROR_TEXTS[error.type];
    }

    // Con respuesta: texto según el código, o el genérico si no lo tenemos
    return ERROR_TEXTS[error.status] ?? ERROR_TEXTS.default;
}