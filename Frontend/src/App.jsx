import { BrowserRouter, Routes, Route } from 'react-router-dom'
import './App.css'
import Home from './pages/Home/Home'
import Navbar from './components/Navbar/Navbar'
import Login from './pages/Login/Login'
import Register from './pages/Register/Register'

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
      </Routes>
    </BrowserRouter>
  )
}

export default App
