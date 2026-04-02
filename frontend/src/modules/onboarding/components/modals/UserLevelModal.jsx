import {
    useState
} from "react";

import Hoja from '../../../../assets/svg/modal/nivel/leaf-outline.svg';
import Subida from '../../../../assets/svg/modal/nivel/trending-up-outline.svg';
import Fuego from '../../../../assets/svg/modal/nivel/flame-outline.svg';

function UserLevelModal() {
    const [currentModal, setCurrentModal] = useState("level");

    const [userConfig, setUserConfig] = useState({
        level: null,
        learningType: null,
    });

    const steps = [
        "level",
        "learningType",
    ];



    const handleSelectLevel = (level) => {

        // Guardo el nivel seleccionado en la configuracion del usuario
        setUserConfig((prev) => {
            return {
                ...prev, // copia superficial del objeto userConfig
                level
            }
        });

        setCurrentModal("learningType");

    }

    const handleSelectLearningType = (learningType) => {

        // Guardo el nivel seleccionado en la configuracion del usuario
        setUserConfig((prev) => {
            return {
                ...prev, // copia superficial del objeto userConfig
                learningType
            }
        });

        setCurrentModal("confirm");

    }

    return (
        <>
        {currentModal === "level" ? (

            <div className="box-container flex direction-column items-center justify-center border-width-2px border-state-s">

                <div className="modal-container">

                    <button 
                        className="simple-container-style-1 card background-color-first-card-user-modal"
                        onClick={() => handleSelectLevel("beginner")}
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
                        onClick={() => handleSelectLevel("intermediate")}
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
                        onClick={() => handleSelectLevel("advanced")}
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
            
        ) : (
            // <button type="button">
            //     <p>Continuar</p>
            // </button>
            <h1>Step 2</h1>
        )}
        </>

    );
}

export default UserLevelModal;