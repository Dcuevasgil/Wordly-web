import '../../../styles/components/icons.css'


export default function IconButton({
    icon,
    altText
}) {
    return (
        <div className="notifications-circle">
            {icon && <img src={icon} alt={altText} />}
        </div>
    );
}