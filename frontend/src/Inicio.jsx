import { useState } from 'react'
import './Inicio.css'


// SVGs
import WordlyLogo from './assets/svg/logo.svg'

function App() {

  return (
    <>
      <div className="container-home">


        <div className="container-logo-word">

          <img src={WordlyLogo} className="logo" alt="Wordly Logo" />

          <h1 className="title-home">Wordly</h1>

        </div>

        <div className="container-title-home-1">

          <h1 className="title-home-1">Aprende jugando con Wordly</h1>

          <p className="paragraph">Un sistema fácil y efectivo para mejorar en el dia a dia</p>

        </div>

      </div>
    </>
  )
}

export default App
