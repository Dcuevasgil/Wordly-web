import { 
    useState,
    useEffect 
} from 'react'

// JS 

// CSS 
import '../../../styles/base/reset.css';
import '../../../Dashboard.css';

// SVGs 
import Logo from '../../../assets/svg/dashboard/logo-dashboard.svg';

// Navegación
// import naviate from 

function Dashboard() {

    // States animations 
    const [openDropdown, setOpenDropdown] = useState(null);

    const unreadMessages = [
        { id: 1, from: "Juan" },
        { id: 2, from: "María" }
    ];

    const pendingReviews = 0;

    // Generacion de notificaciones 
    const generateNotifications = () => {
        let resultNotifications = [];

        // Notificaciones no leidas 
        if (unreadMessages.length > 0) {
            resultNotifications.push({
                id: "messages",
                type: "messages",
                message: `Tienes ${unreadMessages.length} sin leer`
            });
        }

        // Revisiones pendientes 
        if (pendingReviews > 0) {
            resultNotifications.push({
                id: "reviews",
                type: "review",
                message: `Tienes ${pendingReviews} revisiones pendientes`
            });
        }

        return resultNotifications;
    }


    // Toggle Notifications 
    const toggleNotifications = () => {
        setOpenDropdown(prev => prev === "notifications" ? null : "notifications");
    }

    // Toggle Profile 
    const toggleProfile = () => {
        setOpenDropdown(prev => prev === "profile" ? null : "profile");
    }

    const notifications = generateNotifications();

    // UseEffects 
    useEffect(() => {
        const handleClickOutside = () => {
            setOpenDropdown(null);
        }

        document.addEventListener("click", handleClickOutside);

        return () => {
            document.removeEventListener("click", handleClickOutside);
        }
    }, []);


    return (
        <>
            <div className="grid">

                <nav className="left-column-style-1 flex direction-column gap-12 pad-16"> {/* Navegación entre pestañas */}

                    <div className="nav-item flex direction-row items-center gap-8 is-active">
                        <span className="nav-icon flex justify-center items-center primary">
                            <img src={Logo} alt="Wordly logo in dashboard navigation" />
                        </span>

                        <span className="text-16 font-md-sans weight-600 color-black">Dashboard</span>
                    </div>

                    <div className="nav-item flex direction-row items-center gap-8">

                        <span className="nav-icon flex justify-center items-center primary">
                            <md-icon>settings</md-icon>
                        </span>

                        <span className="text-16 font-md-sans weight-600 color-black">Configuración</span>
                    </div>

                    <div className="nav-item flex direction-row items-center gap-8">
                        <span className="nav-icon flex justify-center items-center primary">
                            <md-icon>chat_bubble</md-icon> 
                        </span> 
                        <span className="text-16 font-md-sans weight-600 color-black">Mensajes</span> 
                    </div>

                    <div className="nav-item flex direction-row items-center gap-8">
                        <span className="nav-icon flex justify-center items-center primary">
                            <md-icon>school-outline</md-icon> 
                        </span> 
                        <span className="text-16 font-md-sans weight-600 color-black">Ejercicios de práctica</span>
                    </div>
                </nav> 
                
                {/* Dashboard */}
                <div className="right-column-style-1">
                    
                    {/* Header */}
                    <header className="dashboard-header flex direction-row items-center justify-around pad-12">

                        <div className="header-left"> 
                            <span className="title-dashboard text-28 weight-700 color-white">Wordly</span> 
                        </div> 
                        
                        <div className="header-center flex justify-center"> 
                            <div className="search-dashboard flex direction-row items-center gap-8 pad-10-20 rounded-full"> 
                                <md-icon>search</md-icon> 
                                <input className="search-text text-16 weight-500 color-white" placeholder="Busca algo..." /> 
                            </div>
                        </div> 
                        
                        <div className="header-right flex direction-row gap-12"> 
                            {/* 🔔 NOTIFICATIONS */} 
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

                                {/* <div className={dropdown dropdown--notifications ${openDropdown === "notifications" ? "active" : ""}}> */} 
                                
                                <div 
                                    className={`dropdown dropdown--notifications ${openDropdown === "notifications" ? "active" : ""}`}
                                    onClick={(e) => { 
                                        e.stopPropagation();
                                    }}
                                    > 
                                
                                    <div className="dropdown-content"> 
                                        {notifications.length === 0 ? (
                                            <p>No tienes notificaciones</p>
                                        ) : (
                                            notifications.map(notification => (
                                                <div key={notification.id} className="notification-item"> 
                                                    {notification.message} 
                                                </div>)
                                                )
                                            )
                                        } 
                                    </div> 
                                </div> 
                                
                                {/* {openDropdown === "notifications" && ( <div className="dropdown dropdown--notifications"> </div> )} */} 
                            </div> 
                            
                            {/* 👤 PROFILE */} 
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
                                
                                {/* {openDropdownProfile ? ( <nav className="simple-container"> <ul> <li>Ver Perfil</li> <li>Mi progreso</li> <hr /> <li>Cerrar sesión</li> </ul> </nav> )} */} 
                                
                                <div 
                                    className={`dropdown dropdown--profile ${openDropdown === "profile" ? "active" : ""}`}
                                    onClick={(e) => { 
                                        e.stopPropagation();
                                    }}
                                    > 
                                    <div className="dropdown-content"> 
                                        
                                        {/* SECTION 1*/} 
                                        <ul className="dropdown-section"> 
                                            <li className="dropdown-title">Perfil</li> 
                                            <li className="dropdown-item">Mi perfil</li> 
                                            <li className="dropdown-item">Cambiar curso</li> 
                                            <li className="dropdown-item">Apariencia</li>
                                        </ul>
                                        
                                        {/* SECTION 2*/} 
                                        <ul className="dropdown-section"> 
                                            <li className="dropdown-title">Mi avance</li> 
                                            <li className="dropdown-item">Logros</li> 
                                            <li className="dropdown-item">Mi progreso</li> 
                                        </ul> 
                                        
                                        {/* SECTION 3 */} 
                                        {/* <ul className="dropdown-section"> 
                                            <li className="dropdown-title">Perfil</li> 
                                            <li className="dropdown-item">Mi perfil</li> 
                                            <li className="dropdown-item">Cambiar curso</li> 
                                        </ul> */}
                                    </div> 

                                </div>

                            </div>

                        </div>

                    </header> 
                    
                    <main className="grid-main"> 
                        
                        <div className="simple-container pad-16 flex direction column gap-12 interaction-hover interaction-press"> 
                            
                            <h3 className="title text-8 weight-500">¿Qué estudiar hoy?</h3> 
                            <nav> 
                                <ul className="list-unorder flex direction-column gap-8"> 
                                    
                                    <li className="item interaction-press interaction-hover"> 
                                        <a href="#" className="link text-7 weight-500 font-dm-sans">
                                            Phrasal Verbs
                                        </a> 
                                    </li> 
                                    
                                    <li className="item interaction-press interaction-hover"> 
                                        <a href="#" className="link text-7 weight-500 font-dm-sans">
                                            Present simple 
                                        </a> 
                                    </li> 
                                    
                                    <li className="item interaction-press interaction-hover"> 
                                        <a href="#" className="link text-7 weight-500 font-dm-sans"> 
                                            Past continous 
                                        </a> 
                                    </li> 
                                
                                </ul> 
                            
                            </nav> 
                        
                        </div> 
                        
                        <div className="simple-container pad-16 flex direction column gap-12 interaction-hover interaction-press"> 
                            
                            <h3 className="title text-8 weight-500">¿Qué estudiar hoy?</h3> 
                            <nav> 
                                <ul className="list-unorder flex direction-column gap-8"> 
                                    
                                    <li className="item interaction-press interaction-hover"> 
                                        <a href="#" className="link text-7 weight-500 font-dm-sans">
                                            Phrasal Verbs
                                        </a> 
                                    </li> 
                                    
                                    <li className="item interaction-press interaction-hover"> 
                                        <a href="#" className="link text-7 weight-500 font-dm-sans">
                                            Present simple 
                                        </a> 
                                    </li> 
                                    
                                    <li className="item interaction-press interaction-hover"> 
                                        <a href="#" className="link text-7 weight-500 font-dm-sans"> 
                                            Past continous 
                                        </a> 
                                    </li> 
                                
                                </ul> 
                            
                            </nav> 
                        
                        </div> 
                        
                        <div className="simple-container-style-1"> 
                            
                            <h3>Racha diaria...</h3> 
                            
                            <div className="number-text"> 
                                <h1>0</h1> 
                                <h3>días</h3> 
                            </div> 

                        </div> 
                        
                        <div className="simple-container-style-1"> 
                            <p>Precisión</p> 
                            
                            <div className="precision-number"> 
                                <span>0%</span>
                            </div> 
                            
                        </div> 
                        
                        <div className="simple-container-style-1"> 
                            
                            <p>Revisiones pendientes</p> 
                            
                            <div className="number-pending-reviews"> 
                                <span>0%</span>
                            </div> 
                            
                        </div> 
                        
                        <div className="simple-container-style-1"> 
                            
                            <h3>Racha diaria...</h3> 
                            
                            <div className="number-text"> 
                                <h1>0</h1> 
                                <h3>días</h3> 
                            </div> 

                        </div> 

                    </main> 
                
                </div> 
            </div> 
        </> 
    )
} 

export default Dashboard;