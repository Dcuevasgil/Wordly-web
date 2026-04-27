import { useState, useEffect } from "react";
import { useNavigate, Outlet } from "react-router-dom";

// CSS
import "../../../styles/base/reset.css";
import "../../../Dashboard.css";

// SVG
import Logo from "../../../assets/svg/dashboard/logo-dashboard.svg";

// Components
import CreateProfileModal from "../components/profile/CreateProfileModal";

function Dashboard() {

  const navigate = useNavigate();

  const [openDropdown, setOpenDropdown] = useState(null);
  const [isProfileOpen, setIsProfileOpen] = useState(false);
  const [modalOrigin, setModalOrigin] = useState({ x: 0, y: 0 });

  const notifications = [
    { id: 1, message: "Tienes 2 mensajes sin leer" },
    { id: 2, message: "Tienes 3 revisiones pendientes" }
  ];

  useEffect(() => {
    const handleClickOutside = () => setOpenDropdown(null);
    document.addEventListener("click", handleClickOutside);

    return () => document.removeEventListener("click", handleClickOutside);
  }, []);

  return (
    <div className="grid font-dm-sans">

      {/* SIDEBAR */}
      <nav className="left-column-style-1 flex direction-column gap-12 pad-16">

        <div
          className="nav-item flex direction-row items-center gap-8 interaction-press"
          onClick={() => navigate("/dashboard")}
        >
          <img src={Logo} alt="logo" className="nav-icon"/>
          <span className="text-16 weight-600 color-black">Inicio</span>
        </div>

        <div
          className="nav-item flex direction-row items-center gap-8 interaction-press"
          onClick={() => navigate("/dashboard/settings")}
        >
          <md-icon>settings</md-icon>
          <span className="text-16 weight-600 color-black">Configuración</span>
        </div>

        <div
          className="nav-item flex direction-row items-center gap-8 interaction-press"
          onClick={() => navigate("/dashboard/messages")}
        >
          <md-icon>chat_bubble</md-icon>
          <span className="text-16 weight-600 color-black">Chat</span>
        </div>

      </nav>

      {/* MAIN */}
      <div className="right-column-style-1">

        {/* HEADER */}
        <header className="dashboard-header flex items-center justify-between pad-12">

          <span className="title-dashboard text-28 weight-700 color-white">
            Wordly
          </span>

          <div className="search-dashboard flex items-center gap-8 pad-10-20 rounded-full">
            <md-icon>search</md-icon>
            <input placeholder="Busca algo..." />
          </div>

          <div className="header-right flex direction-row gap-12">

            {/* NOTIFICATIONS */}
            <div className="notifications-wrapper">

              <div
                className="circle-icon interaction-press interaction-hover"
                onClick={(e) => {
                  e.stopPropagation();
                  setOpenDropdown(prev => prev === "notifications" ? null : "notifications");
                }}
              >
                <md-icon>notifications</md-icon>
              </div>

              <div
                className={`dropdown dropdown--notifications ${
                  openDropdown === "notifications" ? "active" : ""
                }`}
                onClick={(e) => e.stopPropagation()}
              >
                <div className="dropdown-content">
                  {notifications.length === 0 ? (
                    <p>No tienes notificaciones</p>
                  ) : (
                    notifications.map(n => (
                      <div key={n.id} className="dropdown-item">
                        {n.message}
                      </div>
                    ))
                  )}
                </div>
              </div>

            </div>

            {/* PROFILE */}
            <div className="profile-wrapper">

              <div
                className="circle-icon interaction-press interaction-hover"
                onClick={(e) => {
                  e.stopPropagation();
                  setOpenDropdown(prev => prev === "profile" ? null : "profile");
                }}
              >
                <md-icon>person</md-icon>
              </div>

              <div
                className={`dropdown dropdown--profile ${
                  openDropdown === "profile" ? "active" : ""
                }`}
                onClick={(e) => e.stopPropagation()}
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

                    <li className="dropdown-item interaction-hover interaction-press">
                      Cambiar curso
                    </li>
                  </ul>

                  <ul className="dropdown-section">
                    <li className="dropdown-title">Mi avance</li>
                    <li className="dropdown-item">Logros</li>
                    <li className="dropdown-item">Mi progreso</li>
                  </ul>

                  <ul className="dropdown-section">
                    <li className="dropdown-title">Sesión</li>
                    <li className="dropdown-item">Cerrar sesión</li>
                  </ul>

                </div>
              </div>

            </div>

          </div>

        </header>

        {/* CONTENIDO */}
        <main className="dashboard-content">
          <Outlet />
        </main>

        {/* MODAL PERFIL */}
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