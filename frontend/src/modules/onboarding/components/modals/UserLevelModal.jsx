import {
    useState
} from "react";

import Hoja from '../../../../assets/svg/modal/nivel/leaf-outline.svg';
import Subida from '../../../../assets/svg/modal/nivel/trending-up-outline.svg';
import Fuego from '../../../../assets/svg/modal/nivel/flame-outline.svg';

function UserLevelModal() {
    const [step, setStep] = useState(0);

    const [userConfig, setUserConfig] = useState({
        level: null,
        learningType: null,
    });

    const steps = [
        "level",
        "learningType",
    ];

    return (
        <>

            {/* Botón Modal Configuración Primeros pasos */}
            <div className="box-container flex direction-column items-center justify-center border-width-2px border-state-s">

                <div className="modal-container">

                    <button 
                        className="simple-container-style-1 card background-color-first-card-user-modal"
                        onClick={() => console.log("click")}
                        >

                        <img 
                            src={Hoja} 
                            alt="Leaf icon" 
                            style={{ 
                                width: "100px", 
                                aspectRatio: 1, 
                                objectFit: "contain" 
                            }} 
                        />
                        <h2 className="title-modal-button">Primeros pasos</h2>
                        
                    <md-ripple></md-ripple>
                    </button>

                    <button 
                        className="simple-container-style-2 card background-color-second-card-user-modal"
                        onClick={() => console.log("click")}
                        >

                        <img 
                            src={Subida} 
                            alt="Leaf icon" 
                            style={{ 
                                width: "100px", 
                                aspectRatio: 1, 
                                objectFit: "contain" 
                            }} 
                        />
                        <h2 className="title-modal-button">Ya me defiendo</h2>
                        
                    <md-ripple></md-ripple>
                    </button>

                    <button 
                        className="simple-container-style-3 card background-color-third-card-user-modal"
                        onClick={() => console.log("click")}
                        >

                        <img 
                            src={Fuego} 
                            alt="Leaf icon" 
                            style={{ 
                                width: "100px", 
                                aspectRatio: 1, 
                                objectFit: "contain" 
                            }} 
                        />
                        <h2 className="title-modal-button">Tengo nivel</h2>
                        
                    <md-ripple></md-ripple>
                    </button>
                </div>
            
            </div>

        </>
    );
}

export default UserLevelModal;