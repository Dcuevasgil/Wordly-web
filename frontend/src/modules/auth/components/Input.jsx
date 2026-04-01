import '../../../styles/components/inputs.css';

// SVG
import Bombilla from '../../../assets/svg/loginpage/bulb.svg';

export default function Input({
    icon,
    type = "text", // text, email, password, etc
    placeholder,
    name, 
    value,
    onChange
}) {
    return (
        <div className="input-container">
                            
            {icon && <img src={icon} alt="Email Icon" />}
            <input 
                type={type} 
                placeholder={placeholder}
                name={name}
                value={value}
                onChange={onChange}
            />

        </div>
    )
}
