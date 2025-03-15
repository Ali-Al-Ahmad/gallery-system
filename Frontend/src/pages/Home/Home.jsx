import './Home.css'
import { useEffect, useState } from 'react'
import axiosInstance from '../../api/axiosInstance'

const Home = () => {
  const userId = localStorage.getItem('user_id')
  const [user_images, setUserImages] = useState([])
  const [filtered_user_images, setFilteredFunctions] = useState([])

  useEffect(() => {
    getUserImages()
  }, [])

  const getUserImages = async () => {
    const response = await axiosInstance.get(
      `/getAllUserImages?user_id=${userId}`
    )
    setUserImages(response.data.data.images)
    setFilteredFunctions(response.data.data.images)
    console.log(response.data.data.images)
  }

  const handleSearch = (value) => {
    const filteredImages = user_images.filter(
      (image) =>
        image.title.toLowerCase().includes(value.toLowerCase()) ||
        image.description.toLowerCase().includes(value.toLowerCase()) ||
        image.tags.filter((tag) => tag.toLowerCase().includes(value)).length > 0
    )
    setFilteredFunctions(filteredImages)
  }

  return (
    <div>
      <div className='image-gallery'>
        <h2>Image Gallery</h2>
        <input
          type='search'
          className='search-bar'
          placeholder='Search images...'
          onChange={(e) => handleSearch(e.target.value)}
        />
        <div className='all_images'>
          {filtered_user_images.length > 0 ? (
            filtered_user_images.map((image) => (
              <div
                key={image.id}
                className='image-card'
              >
                <img
                  src={`http://localhost:8080/gallery-system/Backend/uploads/${image.image_path}`}
                  alt={image.title}
                  className='image-preview'
                />
                <div className='image-details'>
                  <h3>{image.title}</h3>
                  <p>{image.description}</p>
                  <div className='tags'>
                    {image.tags &&
                      image.tags.map((tag, index) => (
                        <span
                          key={index}
                          className='tag'
                        >
                          {tag}
                        </span>
                      ))}
                  </div>
                </div>
              </div>
            ))
          ) : (
            <h3>No images found.</h3>
          )}
        </div>
      </div>
    </div>
  )
}

export default Home
