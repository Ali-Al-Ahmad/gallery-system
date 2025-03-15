import { Routes, Route } from 'react-router-dom'
import './App.css'
import Home from './pages/Home/Home'
import Navbar from './components/Navbar/Navbar'
import Login from './pages/Login/Login'
import Register from './pages/Register/Register'
import UploadImage from './pages/uploadImage/UploadImage'
import ProtectedRoutes from './utils/ProtectedRoutes/ProtectedRoutes'

function App() {
  return (
    <>
      <Navbar />
      <Routes>
        <Route
          path='/'
          element={<Login />}
        />
        <Route element={<ProtectedRoutes />}>
          <Route
            path='/home'
            element={<Home />}
          />
        </Route>
        <Route
          path='/register'
          element={<Register />}
        />
        <Route
          path='/upload'
          element={<UploadImage />}
        />
      </Routes>
    </>
  )
}

export default App
