import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import App from './modules/auth/pages/LoginPage.jsx'
import './styles/main.css'

function main() {
  console.log("Aplicacion lista");
}

main(); // 👈 LLAMADA AQUÍ

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <App />
  </StrictMode>,
)