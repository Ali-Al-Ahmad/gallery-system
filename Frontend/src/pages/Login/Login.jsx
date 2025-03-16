import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import axiosInstance from '../../api/axiosInstance'
import { toast } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'
import { Link } from 'react-router-dom'
import './Login.css'

const Login = () => {
  const navigate = useNavigate()
  const [formData, setFormData] = useState({
    email: '',
    password: '',
  })

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      if (formData.email === '' || formData.password === '') {
        toast.error(`All fields required`)
        return
      }

      const response = await axiosInstance.post('/login', formData)
      localStorage.setItem('user_id', response.data.data.id)
      toast.success(`Welcome ${response.data.data.full_name}`)
      navigate('/home')
    } catch (err) {
      console.log(err)
      toast.error(`Email or password is not correct`)
    }
  }

  return (
    <div className='register-page'>
      <form onSubmit={handleSubmit}>
        <input
          type='email'
          name='email'
          placeholder='Email'
          value={formData.email}
          onChange={handleChange}
          required
        />
        <input
          type='password'
          name='password'
          placeholder='Password'
          value={formData.password}
          onChange={handleChange}
          required
        />
        <button type='submit'>Login</button>
        <p>
          Don't have an account? <Link to='/register'>Register</Link>
        </p>
      </form>
    </div>
  )
}

export default Login
