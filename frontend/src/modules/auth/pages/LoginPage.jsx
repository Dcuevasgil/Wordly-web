import { useState } from 'react'

// CSS
import '../../../LoginPage.css'


// SVGs
import WordlyLogo from '../../../assets/svg/logo.svg';
import Bombilla from '../../../assets/svg/bulb.svg';
import Trofeo from '../../../assets/svg/trophy.svg';
import Sobre from '../../../assets/svg/mail.svg';
import Candado from '../../../assets/svg/lock-closed.svg';

// Components
import ButtonLogin from "../components/ButtonLogin";

function App() {

  // States for animations
  const [openModal, setOpenModal] = useState(null);
  const [activeButton, setActiveButton] = useState(false);


  return (
    <>
      <div className="container-home">

        <div className="left-column">

          <div className="container-logo-word">

            <img src={WordlyLogo} className="logo" alt="Wordly Logo" />

            <h1 className="title-home">Wordly</h1>

          </div>

          <div className="container-title-home-1">

            <h1 className="title-home-1">Aprende jugando con Wordly</h1>

            <p className="paragraph">Un sistema fácil y efectivo para mejorar en el dia a dia</p>

          </div>

          <div className="container-left-actions">
            {/* Botones futuros */}
            <ButtonLogin
              icon={Bombilla}
              text="Aprende"
              variant="success"
              onClick={() => console.log("Aprende")}
            />

            <ButtonLogin
              icon={Trofeo}
              text="Progresa"
              variant="progress"
              onClick={() => console.log("Progresa")}
            />
          </div>

        </div>

        <div className="right-column">

          <div className="container-login-register-form">

            <div className="login-register-container">

              <h2 className="log-in">Inicia sesión</h2>
              <h2 className="create-account">Crear cuenta</h2>

              <div className="line"></div>

            </div>

            <form className="log-in">
              <p className="welcome">Bienvenido de nuevo</p>
              
              <fieldset className="inputs-container">
                
                <div className="input-email">
                  
                  <img src={Sobre} alt="Email Icon" />
                  <input type="email" placeholder="Correo electrónico" />

                </div>

                <div className="input-password">

                  <img src={Candado} alt="Password Icon" />
                  <input type="password" placeholder="Contraseña" />

                </div>
                
                <button type="submit">Inicia sesión</button>
              
              </fieldset>

            </form>


          </div>

        </div>

      </div>
    </>
  )
}

export default App
