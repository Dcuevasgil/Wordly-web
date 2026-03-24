import { useState, useRef, useEffect } from 'react'
import { useNavigate } from 'react-router';


// CSS
import '../../../Dashboard.css';


// SVGs
import Campana from '../../../assets/svg/dashboard/notifications-outline.svg';
import Perfil from '../../../assets/svg/dashboard/person-outline.svg';
import Lupa from '../../../assets/svg/dashboard/search-outline.svg';



function Dashboard() {

    // const navigate = useNavigate();

    return (
        <>
        
        
            <div className="left-column"> {/* Navegación entre pestañas */}

            </div>

            <div className="right-column"> {/* Dashboard */}

                {/* Header */}
                <div className="dashboard-header">

                    <div className="title-dashboard">
                        Wordly
                    </div>

                    <div className="search-dashboard">
                        <img 
                            src={Lupa} 
                            alt="magnifying glass icon" 
                        />

                        <h2 className="search-something">Busca algo...</h2>
                    </div>

                    <div className="notifications-circle">
                        <img 
                            src={Campana} 
                            alt="Notifications icon" 
                        />
                    </div>

                    {/* Pruebas */}
                    <div className="dash-container">
                        hola
                    </div>
                </div>



            </div>
        </>

        


    )
}

export default Dashboard;