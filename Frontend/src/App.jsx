import { BrowserRouter, Routes, Route } from 'react-router-dom'
import './App.css'
import Home from './pages/Home/Home'
import Navbar from './components/Navbar/Navbar'
import Login from './pages/Login/Login'
import Register from './pages/Register/Register'
import UploadImage from './pages/uploadImage/UploadImage'

function App() {
  return (
    <BrowserRouter>
      <Navbar />
      <Routes>
        <Route
          path='/'
          element={<Login />}
        />
        <Route
          path='/home'
          element={<Home />}
        />
        <Route
          path='/register'
          element={<Register />}
        />
        <Route
          path='/upload'
          element={<UploadImage />}
        />
      </Routes>
    </BrowserRouter>
  )
}

export default App
