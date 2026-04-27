import { useNavigate } from "react-router-dom";

function DashboardHome() {

    const navigate = useNavigate();

    return (
        <div className="dashboard-home font-dm-sans">

            {/* CARD 1 — LECCIONES */}
            <div 
                className="simple-container pad-16 flex direction-column gap-12 interaction-hover interaction-press"
                onClick={() => navigate("/dashboard/lessons")}
            > 
                <h3 className="title text-8 weight-500">Lecciones</h3> 

                <h1 className="text-24 weight-600 color-white">
                    65%
                </h1>

                <span className="text-16 color-white">
                    Completadas
                </span>

                <span className="text-16 color-white">
                    13 / 20 lecciones
                </span>
            </div> 


            {/* CARD 2 — TEST */}
            <div 
                className="simple-container pad-16 flex direction-column gap-12 interaction-hover interaction-press"
                onClick={() => navigate("/dashboard/practice")}
            > 
                <h3 className="title text-8 weight-500">Test</h3> 

                <h1 className="text-24 weight-600 color-white">
                    43%
                </h1>

                <span className="text-16 color-white">
                    Precisión media
                </span>

                <div className="flex direction-column gap-8">
                    <span className="text-16 color-white">Errores: 4.8</span>
                    <span className="text-16 color-white">Últimos: 4.4</span>
                </div>
            </div> 


            {/* CARD 3 — REVISIONES */}
            <div 
                className="simple-container pad-16 flex direction-column gap-12 interaction-hover interaction-press"
                onClick={() => navigate("/dashboard/review")}
            >
                <h3 className="title text-8 weight-500">Revisiones</h3>

                <h1 className="text-24 weight-600 color-white">
                    3
                </h1>

                <span className="text-16 color-white">
                    Pendientes hoy
                </span>

                <button className="button button-progress">
                    Revisar ahora
                </button>
            </div>


            {/* CARD 4 — RACHA */}
            <div className="simple-container pad-16 flex direction-column gap-12 interaction-hover interaction-press">

                <h3 className="title text-8 weight-500">Racha diaria</h3>

                <h1 className="text-24 weight-600 color-white">
                    56 días 🔥
                </h1>

                {/* <span className="text-16 color-white">
                    Tu mejor marca: 60
                </span> */}
            </div>

        </div>
    )
}

export default DashboardHome;