import { useEffect, useState } from 'react'
import { Navigate, Outlet } from 'react-router-dom'

const ProtectedRoutes = () => {
  const [loading, setLoading] = useState(true)
  const [isAuth, setIsAuth] = useState(false)

  const validateToken = async (token) => {
    if (!token) {
      setLoading(false)
      setIsAuth(false)
      localStorage.clear()
    } else {
      setLoading(false)
      setIsAuth(true)
    }
  }

  useEffect(() => {
    const token = localStorage.getItem('user_id')

    if (!token) {
      setLoading(false)
      setIsAuth(false)
      localStorage.clear()
    } else {
      validateToken(token)
    }
  }, [])

  return loading ? <p>Loading</p> : isAuth ? <Outlet /> : <Navigate to='/' />
}

export default ProtectedRoutes
