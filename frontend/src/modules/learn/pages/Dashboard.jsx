import { useState, useEffect } from "react";
import { Outlet, NavLink, useNavigate } from "react-router-dom";

// CSS
import "../../../styles/base/reset.css";
import "../../../Dashboard.css";

// SVG
import Logo from "../../../assets/svg/dashboard/logo-dashboard.svg";

// Components
import ProfileModal from "../components/profile/ProfileModal";
import ChangeCourseModal from "../components/profile/ChangeCourseModal";
import AchievementsModal from "../components/achievements/AchievementsModal";
import ProgressModal from "../components/profile/ProgressModal";
import LogoutConfirmModal from "../components/profile/LogoutConfirmModal";

function Dashboard() {
  const navigate = useNavigate();

  const [openDropdown, setOpenDropdown] = useState(null);

  // Modal perfil
  const [isProfileOpen, setIsProfileOpen] = useState(false);

  // Modal cambiar curso
  const [isCourseOpen, setIsCourseOpen] = useState(false);
  const [courseOrigin, setCourseOrigin] = useState({ x: 0, y: 0 });

  // Modal logros
  const [isAchievementsOpen, setIsAchievementsOpen] = useState(false);
  const [achievementsOrigin, setAchievementsOrigin] = useState({ x: 0, y: 0 });

  // De momento voy a hacer la prueba con este curso
  // Más adelante vendrá del backend
  const [selectedCourse, setSelectedCourse] = useState("english-general");

  // Modal mi progreso
  const [isProgressOpen, setIsProgressOpen] = useState(false);
  const [progressOrigin, setProgressOrigin] = useState({ x: 0, y: 0 });

  // Modal cerrar sesión
  const [isLogoutOpen, setIsLogoutOpen] = useState(false);
  const [logoutOrigin, setLogoutOrigin] = useState({ x: 0, y: 0 });

  // Punto de origen del modal perfil
  const [modalOrigin, setModalOrigin] = useState({ x: 0, y: 0 });

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
        message: `Tienes ${unreadMessages.length} sin leer`
      });
    }

    if (pendingReviews > 0) {
      resultNotifications.push({
        id: "reviews",
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

  const handleLogout = () => {
    localStorage.removeItem("token");
    navigate("/");
  };

  const notifications = generateNotifications();

  useEffect(() => {
    const handleClickOutside = () => setOpenDropdown(null);
    document.addEventListener("click", handleClickOutside);

    return () => document.removeEventListener("click", handleClickOutside);
  }, []);

  return (
    <div className="grid">

      {/* SIDEBAR */}
      <nav className="left-column-style-1 flex direction-column gap-12 pad-16">

        <NavLink 
          to="/dashboard"
          className={({ isActive }) => 
            `nav-item flex direction-row items-center gap-8 interaction-press ${isActive ? "is-active" : ""}`
          }
        >
          <span className="nav-icon flex justify-center items-center primary">
            <img src={Logo} alt="Wordly logo" />
          </span>

          <span className="text-16 font-md-sans weight-600 color-black">
            Dashboard
          </span>
        </NavLink>

        <NavLink 
          to="/dashboard/settings"
          className={({ isActive }) => 
            `nav-item flex direction-row items-center gap-8 interaction-press ${isActive ? "is-active" : ""}`
          }
        >
          <span className="nav-icon flex justify-center items-center primary">
            <md-icon>settings</md-icon>
          </span>

          <span className="text-16 font-md-sans weight-600 color-black">
            Configuración
          </span>
        </NavLink>

        <NavLink 
          to="/dashboard/messages"
          className={({ isActive }) => 
            `nav-item flex direction-row items-center gap-8 interaction-press ${isActive ? "is-active" : ""}`
          }
        >
          <span className="nav-icon flex justify-center items-center primary">
            <md-icon>chat_bubble</md-icon>
          </span>

          <span className="text-16 font-md-sans weight-600 color-black">
            Mensajes
          </span>
        </NavLink>

        <NavLink 
          to="/dashboard/practice"
          className={({ isActive }) => 
            `nav-item flex direction-row items-center gap-8 interaction-press ${isActive ? "is-active" : ""}`
          }
        >
          <span className="nav-icon flex justify-center items-center primary">
            <md-icon>create_outline</md-icon>
          </span>

          <span className="text-16 font-md-sans weight-600 color-black">
            Ejercicios para practicar
          </span>
        </NavLink>

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
                className="circle-icon border-color-black interaction-press interaction-hover"
                onClick={(e) => {
                  e.stopPropagation();
                  toggleNotifications();
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
                    notifications.map((n) => (
                      <div key={n.id} className="notification-item">
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
                className="circle-icon border-color-black interaction-press interaction-hover"
                onClick={(e) => {
                  e.stopPropagation();
                  toggleProfile();
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

                    <li 
                      className="dropdown-item interaction-hover interaction-press"
                      onClick={(e) => {
                        const rect = e.currentTarget.getBoundingClientRect();

                        setCourseOrigin({
                          x: rect.left + rect.width / 2,
                          y: rect.top + rect.height / 2
                        });

                        setIsCourseOpen(true);
                        setOpenDropdown(null);
                      }}
                    >
                      Cambiar curso
                    </li>
                  </ul>

                  <ul className="dropdown-section">
                    <li className="dropdown-title">Mi avance</li>

                    <li 
                      className="dropdown-item interaction-hover interaction-press"
                      onClick={(e) => {
                        const rect = e.currentTarget.getBoundingClientRect();

                        setAchievementsOrigin({
                          x: rect.left + rect.width / 2,
                          y: rect.top + rect.height / 2
                        });

                        setIsAchievementsOpen(true);
                        setOpenDropdown(null);
                      }}
                    >
                      Logros
                    </li>

                    <li 
                      className="dropdown-item interaction-hover interaction-press"
                      onClick={(e) => {
                        const rect = e.currentTarget.getBoundingClientRect();

                        setProgressOrigin({
                          x: rect.left + rect.width / 2,
                          y: rect.top + rect.height / 2
                        });

                        setIsProgressOpen(true);
                        setOpenDropdown(null);
                      }}
                    >
                      Mi progreso
                    </li>
                  </ul>

                  <ul className="dropdown-section">
                    <li className="dropdown-title">Sesión</li>

                    <li 
                      className="dropdown-item interaction-hover interaction-press"
                      onClick={(e) => {
                        const rect = e.currentTarget.getBoundingClientRect();

                        setLogoutOrigin({
                          x: rect.left + rect.width / 2,
                          y: rect.top + rect.height / 2
                        });

                        setIsLogoutOpen(true);
                        setOpenDropdown(null);
                      }}
                    >
                      Cerrar sesión
                    </li>
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
        <ProfileModal
          isOpen={isProfileOpen}
          onClose={() => setIsProfileOpen(false)}
          origin={modalOrigin}
        />

        {/* MODAL CAMBIAR CURSO */}
        <ChangeCourseModal
          isOpen={isCourseOpen}
          onClose={() => setIsCourseOpen(false)}
          origin={courseOrigin}
        />

        {/* MODAL LOGROS */}
        <AchievementsModal
          isOpen={isAchievementsOpen}
          onClose={() => setIsAchievementsOpen(false)}
          origin={achievementsOrigin}
          selectedCourse={selectedCourse}
        />

        {/* MODAL MI PROGRESO */}
        <ProgressModal
          isOpen={isProgressOpen}
          onClose={() => setIsProgressOpen(false)}
          origin={progressOrigin}
          selectedCourse={selectedCourse}
          setSelectedCourse={setSelectedCourse}
        />

        {/* MODAL CERRAR SESIÓN */}
        <LogoutConfirmModal
          isOpen={isLogoutOpen}
          onClose={() => setIsLogoutOpen(false)}
          origin={logoutOrigin}
          onConfirm={handleLogout}
        />

      </div>
    </div>
  );
}

export default Dashboard;