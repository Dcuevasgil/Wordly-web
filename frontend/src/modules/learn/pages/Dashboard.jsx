import { useState, useRef, useEffect } from 'react'
import { useNavigate } from 'react-router';


// CSS
import '../../../styles/base/reset.css';
import '../../../Dashboard.css';


// SVGs
import Campana from '../../../assets/svg/dashboard/notifications-outline.svg';
import Perfil from '../../../assets/svg/dashboard/person-outline.svg';
import Lupa from '../../../assets/svg/dashboard/search-outline.svg';
// import Menu from '../../../assets/svg/dashboard/menu-outline.svg';
import Ajustes from '../../../assets/svg/dashboard/settings-outline.svg';
import Mensajes from '../../../assets/svg/dashboard/chatbubbles-outline.svg';
import Logo from '../../../assets/svg/dashboard/logo-dashboard.svg';


function Dashboard() {

    // const navigate = useNavigate();

    return (
        <>

            <div className="grid">
                
                <nav className="left-column-style-1 flex direction-column gap-12 pad-16"> 
                    {/* Navegación entre pestañas */}

                    <div className="nav-item flex direction-row items-center gap-8 is-active">
                        <span className="nav-icon flex justify-center items-center primary">
                            <img src={Logo} alt="Wordly logo in dashboard navigation" />
                        </span>
                        <span className="text-16 font-md-sans weight-600 color-black">Dashboard</span>
                    </div>
                    <div className="nav-item flex direction-row items-center gap-8">
                        <span className="nav-icon flex justify-center items-center primary">
                            <img src={Ajustes} alt="Wordly logo in dashboard navigation" />
                        </span>
                        <span className="text-16 font-md-sans weight-600 color-black">Configuración</span>
                    </div>
                    <div className="nav-item flex direction-row items-center gap-8">
                        <span className="nav-icon flex justify-center items-center primary">
                            <img src={Mensajes} alt="Wordly logo in dashboard navigation" />
                        </span>
                        <span className="text-16 font-md-sans weight-600 color-black">Mensajes</span>
                    </div>
                </nav>



                <div className="right-column-style-1"> 
                    {/* Dashboard */}

                    {/* Header */}
                    <header className="dashboard-header flex direction-row items-center justify-around pad-12">

                        <div className="header-left">
                            <span className="title-dashboard text-28 weight-700 color-white">
                                Wordly
                            </span>
                        </div>

                        <div className="header-center flex justify-center">
                            <div className="search-dashboard flex direction-row items-center gap-8 pad-10-20 rounded-full">
                                <img 
                                    src={Lupa} 
                                    alt="magnifying glass icon" 
                                />

                                <input className="search-text text-16 weight-500 color-white" placeholder="Busca algo..." />
                            </div>
                        </div>

                        <div className="header-right flex direction-row gap-12">
                            <div className="circle-icon flex items-center justify-center">
                                <img 
                                    src={Campana} 
                                    alt="Notifications icon" 
                                />
                            </div>
                            <div className="circle-icon flex items-center justify-center">
                                <img 
                                    src={Perfil} 
                                    alt="User icon" 
                                />
                            </div>
                        </div>
                        
                    </header>

                    <main className="grid-main">

                        <div className="simple-container pad-16 flex direction column gap-12">
                            
                            
                            <h3 className="title text-8 weight-500">¿Qué estudiar hoy?</h3>

                            <nav>
                                
                                <ul className="list-unorder flex direction-column gap-8">
                                    
                                    <li className="item">
                                        <a href="#" className="link text-7 weight-500">
                                            Phrasal Verbs
                                        </a>
                                    </li>
                                    <li className="item">
                                        <a href="#" className="link text-7 weight-500">
                                            Present simple
                                        </a>
                                    </li>
                                    <li className="item">
                                        <a href="#" className="link text-7 weight-500">
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
                                <h1>0</h1>
                            </div>

                        </div>

                        {/* <div className="simple-container-style-1">
                            
                            
                            <h3>Racha diaria...</h3>

                            <div className="number-text">
                                <h1>56</h1>
                                <h3>días</h3>
                            </div>

                        </div> */}

                    </main>

                </div>

            </div>
            
        </>

        


    )
}

export default Dashboard;