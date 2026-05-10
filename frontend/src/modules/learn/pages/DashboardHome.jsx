import { useNavigate } from "react-router-dom";

function DashboardHome() {
    const navigate = useNavigate();

    return (
        <div className="dashboard-home font-dm-sans">

            <div 
                className="dashboard-card"
                onClick={() => navigate("/dashboard/lessons")}
            > 
                <h3 className="dashboard-card-title">Lecciones</h3> 

                <h1 className="dashboard-card-number">65%</h1>

                <span className="dashboard-card-text">Completadas</span>
                <span className="dashboard-card-subtext">13 / 20 lecciones</span>
            </div> 

            <div 
                className="dashboard-card"
                onClick={() => navigate("/dashboard/practice")}
            > 
                <h3 className="dashboard-card-title">Test</h3> 

                <h1 className="dashboard-card-number">43%</h1>

                <span className="dashboard-card-text">Precisión media</span>
                <span className="dashboard-card-subtext">Errores: 4.8</span>
                <span className="dashboard-card-subtext">Últimos: 4.4</span>
            </div> 

            <div 
                className="dashboard-card"
            >
                <h3 className="dashboard-card-title">Revisiones</h3>

                <h1 className="dashboard-card-number">3</h1>

                <span className="dashboard-card-text">Pendientes hoy</span>

                <button 
                    className="dashboard-card-button"
                    onClick={() => navigate("/dashboard/review")}
                >
                    Revisar ahora
                </button>
            </div>

            <div className="dashboard-card">
                <h3 className="dashboard-card-title">Racha diaria</h3>

                <h1 className="dashboard-card-number">
                    56 días🔥
                </h1>

                <span className="dashboard-card-subtext">Tu mejor marca: 60</span>
            </div>

        </div>
    )
}

export default DashboardHome;