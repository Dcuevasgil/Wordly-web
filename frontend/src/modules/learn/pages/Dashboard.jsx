import { useState, useEffect } from "react";
import { useNavigate, Outlet } from "react-router-dom";

// CSS
import "../../../styles/base/reset.css";
import "../../../Dashboard.css";

// SVGs
import Logo from "../../../assets/svg/dashboard/logo-dashboard.svg";

// Components
import CreateProfileModal from "../components/modals/CreateProfileModal";

function Dashboard() {
  const navigate = useNavigate();


  const [openDropdown, setOpenDropdown] = useState(null);
  const [isProfileOpen, setIsProfileOpen] = useState(false);
  const [modalOrigin, setModalOrigin] = useState({ x: 0, y: 0});

  console.log("MODAL OPEN:", isProfileOpen);


  const unreadMessages = [
    { id: 1, from: "Juan" },
    { id: 2, from: "María" }
  ];

  const pendingReviews = 0;

  const generateNotifications = () => {
    const resultNotifications = [];

    if (unreadMessages.length > 0) {
      resultNotifications.push({
        id: "messages",
        type: "messages",
        message: `Tienes ${unreadMessages.length} sin leer`
      });
    }

    if (pendingReviews > 0) {
      resultNotifications.push({
        id: "reviews",
        type: "review",
        message: `Tienes ${pendingReviews} revisiones pendientes`
      });
    }

    return resultNotifications;
  };

  const toggleNotifications = () => {
    setOpenDropdown((prev) =>
      prev === "notifications" ? null : "notifications"
    );
  };

  const toggleProfile = () => {
    setOpenDropdown((prev) => (prev === "profile" ? null : "profile"));
  };

  const notifications = generateNotifications();

  useEffect(() => {
    const handleClickOutside = () => {
      setOpenDropdown(null);
    };

    document.addEventListener("click", handleClickOutside);

    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
  }, []);

  return (
    <div className="grid">
      <nav className="left-column-style-1 flex direction-column gap-12 pad-16">

        <div
          className="nav-item flex direction-row items-center gap-8 interaction-press"
          onClick={() => navigate("/dashboard")}
        >
          <span className="nav-icon flex justify-center items-center primary">
            <img src={Logo} alt="Wordly logo in dashboard navigation" />
          </span>

          <span className="text-16 font-md-sans weight-600 color-black">
            Dashboard
          </span>
        </div>

        <div
          className="nav-item flex direction-row items-center gap-8 interaction-press"
          onClick={() => navigate("/dashboard")}
        >
          <span className="nav-icon flex justify-center items-center primary">
            <img src={Logo} alt="Wordly logo in dashboard navigation" />
          </span>

          <span className="text-16 font-md-sans weight-600 color-black">
            Inicio
          </span>
        </div>


        <div
          className="nav-item flex direction-row items-center gap-8 interaction-press"
          onClick={() => navigate("/dashboard/settings")}
        >
          <span className="nav-icon flex justify-center items-center primary">
            <md-icon>settings</md-icon>
          </span>

          <span className="text-16 font-md-sans weight-600 color-black">
            Configuración
          </span>
        </div>

        <div
          className="nav-item flex direction-row items-center gap-8 interaction-press"
          onClick={() => navigate("/dashboard/messages")}
        >
          <span className="nav-icon flex justify-center items-center primary">
            <md-icon>chat_bubble</md-icon>
          </span>

          <span className="text-16 font-md-sans weight-600 color-black">
            Mensajes
          </span>
        </div>

        <div
          className="nav-item flex direction-row items-center gap-8 interaction-press"
          onClick={() => navigate("/dashboard/practice")}
        >
          <span className="nav-icon flex justify-center items-center primary">
            <md-icon>create_outline</md-icon>
          </span>

          <span className="text-16 font-md-sans weight-600 color-black">
            Ejercicios para practicar
          </span>
        </div>
      </nav>

      <div className="right-column-style-1">
        <header className="dashboard-header flex direction-row items-center justify-around pad-12">
          <div className="header-left">
            <span className="title-dashboard text-28 weight-700 color-white">
              Wordly
            </span>
          </div>

          <div className="header-center flex justify-center">
            <div className="search-dashboard flex direction-row items-center gap-8 pad-10-20 rounded-full">
              <md-icon>search</md-icon>
              <input
                className="search-text text-16 weight-500 color-white"
                placeholder="Busca algo..."
              />
            </div>
          </div>

          <div className="header-right flex direction-row gap-12">
            <div className="notifications-wrapper">
              <div
                className="circle-icon border-color-black ripple-icon interaction-press interaction-hover"
                onClick={(e) => {
                  e.stopPropagation();
                  toggleNotifications();
                }}
              >
                <md-icon>notifications</md-icon>
                <md-ripple></md-ripple>
              </div>

              <div
                className={`dropdown dropdown--notifications ${
                  openDropdown === "notifications" ? "active" : ""
                }`}
                onClick={(e) => {
                  e.stopPropagation();
                }}
              >
                <div className="dropdown-content">
                  {notifications.length === 0 ? (
                    <p>No tienes notificaciones</p>
                  ) : (
                    notifications.map((notification) => (
                      <div key={notification.id} className="notification-item">
                        {notification.message}
                      </div>
                    ))
                  )}
                </div>
              </div>
            </div>

            <div className="profile-wrapper">
              <div
                className="circle-icon border-color-black ripple-icon interaction-press interaction-hover"
                onClick={(e) => {
                  e.stopPropagation();
                  toggleProfile();
                }}
              >
                <md-icon>person</md-icon>
                <md-ripple></md-ripple>
              </div>

              <div
                className={`dropdown dropdown--profile ${
                  openDropdown === "profile" ? "active" : ""
                }`}
                onClick={(e) => {
                  e.stopPropagation();
                }}
              >
                <div className="dropdown-content">
                  <ul className="dropdown-section">
                    <li className="dropdown-title">Perfil</li>
                    <li 
                      className="dropdown-item interaction-hover interaction-press"
                      onClick={(e) => {
                        const rect = e.currentTarget.getBoundingClientRect();

                        setModalOrigin({
                          x: rect.left + rect.width / 2,
                          y: rect.top + rect.height / 2
                        });

                        setIsProfileOpen(true);
                        setOpenDropdown(null);
                      }}
                      >
                        Mi perfil
                    </li>
                    
                    
                    <li className="dropdown-item interaction-hover interaction-press">Cambiar curso</li>
                  </ul>

                  <ul className="dropdown-section">
                    <li className="dropdown-title">Mi avance</li>
                    <li className="dropdown-item interaction-hover interaction-press">Logros</li>
                    <li className="dropdown-item interaction-hover interaction-press">Mi progreso</li>
                  </ul>

                  <ul className="dropdown-section">
                    <li className="dropdown-title">Sesión</li>
                    <li className="dropdown-item interaction-hover interaction-press">Cerrar sesión</li>

                    {/* <li className="dropdown-item interaction-hover interaction-press">Mi progreso</li> */}


                  </ul>
                </div>


                




              </div>
            </div>
          </div>
        </header>

        <main className="grid-main">
          <Outlet />
        </main>

        <CreateProfileModal
          isOpen={isProfileOpen}
          onClose={() => setIsProfileOpen(false)}
          origin={modalOrigin}
        />
      </div>
    </div>
  );
}

export default Dashboard;