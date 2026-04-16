import { useState, useRef, useEffect } from 'react'
import { useNavigate } from 'react-router-dom';

// CSS
import '../../../LoginPage.css'

// Backend conexion
import { 
  handleLogin as loginRequest, 
  handleRegister as registerRequest 
} from '../services/authService';


// SVGs
import WordlyLogo from '../../../assets/svg/loginpage/logo.svg';
import Bombilla from '../../../assets/svg/loginpage/bulb.svg';
import Trofeo from '../../../assets/svg/loginpage/trophy.svg';
import Sobre from '../../../assets/svg/loginpage/mail.svg';
import Candado from '../../../assets/svg/loginpage/lock-closed.svg';
import Persona from '../../../assets/svg/loginpage/person.svg';
import MostrarContraseña from '../../../assets/svg/loginpage/eye.svg';
import OcultarContraseña from '../../../assets/svg/loginpage/eye-off.svg';

// Components
import ButtonLogin from "../components/ButtonLogin";
import Input from "../components/Input";
import Modal from '../components/Modal';

function LoginPage() {

  // Navigation
  const navigate = useNavigate();


  // Refs
  const loginRef = useRef(null);
  const registerRef = useRef(null);
  const contentRef = useRef(null);

  // States for animations
  const [activeTab, setActiveTab] = useState("login");

  // Modal de cursos y logros
  // const [openModal, setOpenModal] = useState(null);

  const [indicatorStyle, setIndicatorStyle] = useState({});
  const [contentHeight, setContentHeight] = useState("auto");


  // Modal del sistema
  const [modal, setModal] = useState({
    isOpen: false,
    message: "",
    type: "", // success | error | warning
  });

  const [loginForm, setLoginForm] = useState({
    email: "",
    password: "",
  });

  const [registerForm, setRegisterForm] = useState({
    name: "",
    email: "",
    password: "",
  });

  // UseEffects
  
  useEffect(() => {
    
    const current = activeTab === "login" ? loginRef.current : registerRef.current;

    if (current) {
      
      setIndicatorStyle({
        width: current.offsetWidth + "px",
        left: current.offsetLeft + "px",
      });
    
    }
  
  }, [activeTab]);

  useEffect(() => {
    if (!contentRef.current) return;

    const activeForm =
      activeTab === "login"
        ? contentRef.current.children[0]
        : contentRef.current.children[1];

    if (!activeForm) return;

    setContentHeight(activeForm.offsetHeight + "px");
  }, [activeTab]);

  useEffect(() => {
    const checkAuth = async () => {
      const token = localStorage.getItem("token");

      if (!token) return; // no haces nada → te quedas en login

      try {
        const res = await fetch("/api/me", {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        if (res.status === 200) {
          navigate("/dashboard");
        } else {
          localStorage.removeItem("token");
        }

      } catch (error) {
        if (!localStorage.removeItem("token")){
          console.log("The token could not be deleted successfully", error.message);
        }
      }
    };

    checkAuth();
  }, [navigate]);

  // Handles
  const handleLogin = async () => {

    try {

      const data = await loginRequest(loginForm);

      console.log("Login success:", data);

      setModal({
        isOpen: true,
        message: "Login successful, you have successfully logged in",
        type: "success"
      });

      navigate("/dashboard");

    } catch (error) {

      console.log("Login failed:", error);  
      setModal({
        isOpen: true,
        message: error.message,
        type: "error"
      })

    }

  }

  const handleRegister = async () => {

    try {

      const data = await registerRequest(registerForm);

      console.log("Register success:", data);

      localStorage.setItem("token", data.token);

      setModal({
        isOpen: true,
        message: "Register successful, you have successfully registered",
        type: "success"
      });

      navigate("/dashboard");

    } catch (error) {

      console.log("Register failed:", error);  
      setModal({
        isOpen: true,
        message: error.message,
        type: "error"
      })

    }

  }


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

            <div className={`tab-container ${activeTab === "login" ? "login" : "register"}`}>

              <button
                ref={loginRef}
                className={`tab-button ${activeTab === "login" ? "active" : ""}`}
                onClick={() => setActiveTab("login")}
              >
                Inicia sesión
              </button>

              <button
                ref={registerRef}
                className={`tab-button ${activeTab === "register" ? "active" : ""}`}
                onClick={() => setActiveTab("register")}
              >
                Crear cuenta
              </button>
              
              <span className="tab-indicator" style={indicatorStyle}></span>

            </div>

            {/* Sistema de pestañas */}
            
            <div 
              ref={contentRef}
              className={`tab-content ${activeTab}`}
              style={{ height: contentHeight }}
            >
              {/* pestaña login */}
              <div className={`form-slide ${activeTab === "login" ? "active" : ""}`}>
                
                <form 
                  className="form-container login-form" 
                  onSubmit={(e) => {
                    e.preventDefault();
                    handleLogin();
                  }}
                >
                  <p className="welcome">Bienvenido de nuevo</p>
                  
                  <Input 
                  
                    icon={Sobre}
                    type="email"
                    placeholder="Correo electrónico"
                    name="email"
                    value={loginForm.email}
                    onChange={(e) =>
                      setLoginForm({ ...loginForm, email: e.target.value })
                    }
                  
                  />

                  <Input 

                    icon={Candado}
                    toggleIconOpen={MostrarContraseña}
                    toggleIconClose={OcultarContraseña}
                    type="password"
                    placeholder="Contraseña"
                    name="password"
                    value={loginForm.password}
                    onChange={(e) =>
                      setLoginForm({ ...loginForm, password: e.target.value })
                    }
                  
                  />
                  
                  <button 
                    type="submit"
                    >
                      Inicia sesión
                  </button>

                </form>

              </div>
              
              {/* pestaña registro */}
              <div className={`form-slide ${activeTab === "register" ? "active" : ""}`}>
                
                <form 
                  className="form-container register-form" 
                  onSubmit={(e) => {
                    e.preventDefault();
                    handleRegister();
                  }}
                >
                  <p className="begin-your-journey">Empieza tu camino</p>
                  
                  <Input 
                    
                    icon={Persona}
                    type="text"
                    placeholder="Nombre"
                    name="name"
                    value={registerForm.name}
                    onChange={(e) =>
                      setRegisterForm({ ...registerForm, name: e.target.value })
                    }
                  
                  />

                  <Input 

                    icon={Sobre}                    
                    type="email"
                    placeholder="Correo electrónico"
                    name="email"
                    value={registerForm.email}
                    onChange={(e) =>
                      setRegisterForm({ ...registerForm, email: e.target.value })
                    }
                  
                  />

                  <Input 

                    icon={Candado}
                    toggleIconOpen={MostrarContraseña}
                    toggleIconClose={OcultarContraseña}
                    type="password"
                    placeholder="Contraseña"
                    name="password"
                    value={loginForm.password}
                    onChange={(e) =>
                      setLoginForm({ ...loginForm, password: e.target.value })
                    }
                  
                  />
                  <button 
                    type="submit"
                    >
                      Crear cuenta
                  </button>

                </form>
              
              </div>
            
            </div>

          </div>

        </div>

      </div>

      {/* MODAL GLOBAL */}
      {modal.isOpen && (
        <Modal
          type={modal.type}
          onClose={() => setModal({ ...modal, isOpen: false })}
        >
          <span>{modal.message}</span>
          {/* <ChargeIndicator /> */}
        </Modal>
      )}
    </>
  )
}

export default LoginPage;
