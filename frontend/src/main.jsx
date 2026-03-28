import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client'

import App from './App.jsx';

import './styles/main.css'

import '@material/web/icon/icon.js';
import '@material/web/ripple/ripple.js';

function main() {
  console.log("Aplicacion lista");
}

main();

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <App />
  </StrictMode>
  
)