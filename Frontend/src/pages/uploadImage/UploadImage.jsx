import './UploadImage.css'
import { useState } from 'react'
import axiosInstance from '../../api/axiosInstance'
import { toast } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'

const UploadImage = () => {
  const userId = localStorage.getItem('user_id')
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    tags: '',
    image: null,
  })
  const [preview, setPreview] = useState(null)

  const convertToBase64 = (file) => {
    return new Promise((resolve, reject) => {
      const reader = new FileReader()
      reader.readAsDataURL(file)
      reader.onload = () => resolve(reader.result)
      reader.onerror = (error) => reject(error)
    })
  }

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value })
  }

  const handleImageChange = async (e) => {
    const file = e.target.files[0]
    if (file) {
      setPreview(URL.createObjectURL(file))
      const base64 = await convertToBase64(file)
      setFormData({ ...formData, image: base64 })
    }
  }

  const handleUpload = async (e) => {
    e.preventDefault()

    try {
      const response = await axiosInstance.post('/addImage', {
        user_id: userId,
        title: formData.title,
        description: formData.description,
        tags: formData.tags.split(',').map((tag) => tag.trim()),
        image_data: formData.image,
      })
      console.log(response.data)

      toast.success('Image uploaded successfuly')
      setFormData({ title: '', description: '', tags: '', image: null })
      setPreview(null)
    } catch (error) {
      console.error('Upload Error:', error)
    }
  }

  return (
    <div className='upload-container'>
      <form onSubmit={handleUpload}>
        <input
          type='text'
          name='title'
          placeholder='Title'
          value={formData.title}
          onChange={handleChange}
          required
        />
        <textarea
          name='description'
          placeholder='Description'
          value={formData.description}
          onChange={handleChange}
          required
        />
        <input
          type='text'
          name='tags'
          placeholder='Tags (comma-separated)'
          value={formData.tags}
          onChange={handleChange}
          required
        />
        <input
          type='file'
          accept='image/*'
          onChange={handleImageChange}
          required
        />
        {preview && (
          <img
            src={preview}
            alt='Preview'
          />
        )}
        <button type='submit'>Upload Image</button>
      </form>
    </div>
  )
}

export default UploadImage
