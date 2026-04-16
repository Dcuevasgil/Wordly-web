import { useState } from "react";

// CSS
import "../../../styles/components/inputs.css";

export default function Input({
  icon,
  type = "text",
  placeholder,
  name,
  value,
  onChange
}) {
  const [showPassword, setShowPassword] = useState(false);

  const isPassword = type === "password";

  const handleTogglePassword = () => {
    setShowPassword((prev) => !prev);
  };

  return (
    <div className="input-container">
      {/* LEFT ICON */}
      {icon && <img src={icon} alt="" className="icon-left" />}

      {/* INPUT */}
      <input
        type={isPassword ? (showPassword ? "text" : "password") : type}
        placeholder={placeholder}
        name={name}
        value={value}
        onChange={onChange}
      />

      {/* RIGHT ICON */}
      {isPassword && (
        <button
          type="button"
          className="password-toggle"
          onClick={handleTogglePassword}
          aria-label={showPassword ? "Ocultar contraseña" : "Mostrar contraseña"}
        >
          <svg
            className="eye-icon"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
          >
            {/* Ojo fijo */}
            <path
              d="M2 12C3.8 8.5 7.4 6 12 6C16.6 6 20.2 8.5 22 12C20.2 15.5 16.6 18 12 18C7.4 18 3.8 15.5 2 12Z"
              stroke="currentColor"
              strokeWidth="2"
              strokeLinecap="round"
              strokeLinejoin="round"
            />
            <circle
              cx="12"
              cy="12"
              r="3"
              stroke="currentColor"
              strokeWidth="2"
            />

            {/* Línea diagonal animada */}
            <line
              x1="5"
              y1="19"
              x2="19"
              y2="5"
              className={`eye-slash ${showPassword ? "eye-slash-visible" : "eye-slash-hidden"}`}
            />
          </svg>
        </button>
      )}
    </div>
  );
}