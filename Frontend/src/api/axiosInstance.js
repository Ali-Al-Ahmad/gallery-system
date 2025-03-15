import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: 'http://52.47.202.106/server/',
  headers: {
    'Content-Type': 'application/json',
  },
})

export default axiosInstance
