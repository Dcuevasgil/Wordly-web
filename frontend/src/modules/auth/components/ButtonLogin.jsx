// Button Styles
import '../../../styles/components/button.css';

// SVG
import Bombilla from '../../../assets/svg/bulb.svg';

export default function ButtonLogin({
    icon,
    text,
    onClick,
    variant = "primary", // success, progress, etc.
}) {
    return (
        <button className={`button button-${variant}`} onClick={onClick}>
            {icon && <img src={icon} alt="icon" />}
            <span>{text}</span>
        </button>
    )
}

