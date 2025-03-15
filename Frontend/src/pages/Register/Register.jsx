import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import axiosInstance from '../../api/axiosInstance'
import { toast } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'
import { Link } from 'react-router-dom'
import './Register.css'

const Register = () => {
  const navigate = useNavigate()
  const [formData, setFormData] = useState({
    full_name: '',
    email: '',
    password: '',
  })

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      if (
        formData.email === '' ||
        formData.password === '' ||
        formData.full_name === ''
      ) {
        toast.error(`All fields required`)
        return
      }

      const response = await axiosInstance.post('/register', formData)

      localStorage.setItem('user_id', response.data.data.user_id)
      toast.success(
        `Signup Successful! Welcome ${response.data.data.full_name}`
      )
      navigate('/home')
    } catch (err) {
      toast.error(`Signup failed! ${err.message}`)
    }
  }

  return (
    <div className='register-page'>
      <form onSubmit={handleSubmit}>
        <input
          type='text'
          name='full_name'
          placeholder='Full Name'
          value={formData.full_name}
          onChange={handleChange}
          required
        />
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
        <button type='submit'>Signup</button>
        <p className='form-text'>
          You have an account? <Link to='/'>Login</Link>
        </p>
      </form>
    </div>
  )
}

export default Register
