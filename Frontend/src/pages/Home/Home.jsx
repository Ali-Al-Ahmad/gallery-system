import './Home.css'
import { useEffect } from 'react'
import { useNavigate } from 'react-router-dom'

const Home = () => {
  const navigate = useNavigate()

  useEffect(() => {
    const userId = localStorage.getItem('user_id')
    if (!userId) {
      navigate('/')
    }
  }, [navigate])

  return (
    <div>
      <h1>Home</h1>
    </div>
  )
}

export default Home
