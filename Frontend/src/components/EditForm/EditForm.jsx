import './EditForm.css'
import { useEffect, useState } from 'react'
import axiosInstance from '../../api/axiosInstance'
import { toast } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'
import { image_folder_path } from '../../utils/shared'
import { convertToBase64 } from '../../utils/shared'

const EditForm = ({
  image_id,
  title,
  description,
  tags,
  image_path,
  setEditImage,
}) => {
  const userId = localStorage.getItem('user_id')
  const [preview, setPreview] = useState(null)
  const [formData, setFormData] = useState({
    title: title,
    description: description,
    tags: tags,
    image: null,
  })

  useEffect(() => {
    setFormData({
      title: title,
      description: description,
      tags: tags,
    })
  }, [title])

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

    const confirmed = confirm('Are you sure you want to update?')
    if (confirmed) {
      const updatedImage = {
        user_id: userId,
        image_id,
        title: formData.title,
        description: formData.description,
        tags: formData.tags.split(',').map((tag) => tag.trim()),
        image_data: null,
      }
      if (preview) {
        updatedImage.image_data = formData.image
      }
      try {
        const response = await axiosInstance.post('/updateImage', updatedImage)
        console.log(response.data)

        toast.success('Image Updated successfuly')
        setFormData({ title: '', description: '', tags: '', image: null })
        setPreview(null)
        setEditImage(null)
      } catch (error) {
        console.error('Upload Error:', error)
      }
    }
  }

  return (
    <div className='edit-container'>
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
        />
        {preview && (
          <img
            src={preview}
            alt='Preview'
          />
        )}
        {image_path && !preview && (
          <img
            src={image_folder_path + image_path}
            alt='Preview'
          />
        )}
        <button
          type='submit'
          className='submit'
        >
          Edit Image
        </button>
        <button
          className='cancel'
          onClick={() => setEditImage(null)}
        >
          Cancel
        </button>
      </form>
    </div>
  )
}

export default EditForm
