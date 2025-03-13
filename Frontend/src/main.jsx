import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.jsx'
    import { ToastContainer } from 'react-toastify'

    createRoot(document.getElementById('root')).render(
      <StrictMode>
        <ToastContainer
          autoClose={2000}
          position='top-center'
        />
        <App />
      </StrictMode>
    )
