import './Home.css'
import { useEffect, useState } from 'react'
import axiosInstance from '../../api/axiosInstance'
import Card from '../../components/Card/Card'
import { toast } from 'react-toastify'
import EditForm from '../../components/EditForm/EditForm'

const Home = () => {
  const userId = localStorage.getItem('user_id')
  const [images, setImages] = useState([])
  const [filtered_images, setFilteredImages] = useState([])
  const [editImage, setEditImage] = useState(null)

  useEffect(() => {
    getUserImages()
  }, [editImage])

  useEffect(() => {}, [editImage])

  useEffect(() => {
    setFilteredImages(images)
  }, [images])

  const getUserImages = async () => {
    const response = await axiosInstance.get(
      `/getAllUserImages?user_id=${userId}`
    )
    setImages(response.data.data.images)
  }

  const handleSearch = (value) => {
    const filteredImages = images.filter(
      (image) =>
        image.title.toLowerCase().includes(value.toLowerCase()) ||
        image.description.toLowerCase().includes(value.toLowerCase()) ||
        image.tags.filter((tag) => tag.toLowerCase().includes(value)).length > 0
    )
    setFilteredImages(filteredImages)
  }

  const handleDelteImage = async (image_id) => {
    const confirmed = confirm('Are you sure you want to delete?')

    try {
      if (confirmed) {
        const response = await axiosInstance.delete(
          `/deleteImage?image_id=${image_id}`
        )
        if (response.data.success) {
          toast.success('Image Delete Successully')
          setImages((all) => all.filter((img) => img.id !== image_id))
          return
        }
        toast.error('error deleting')
      }
    } catch (error) {
      console.log(error)
    }
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
        <div className='all-images'>
          {filtered_images.length > 0 ? (
            filtered_images.map((image) => (
              <div
                key={image.id}
                className='card'
              >
                <Card
                  id={image.id}
                  title={image.title}
                  description={image.description}
                  image_path={image.image_path}
                  tags={image.tags}
                />

                {/* edit and delete buttons */}
                <img
                  src='/trash-solid.svg'
                  className='delete-button'
                  onClick={() => handleDelteImage(image.id)}
                />
                <div className='edit-container-with-button'>
                  <img
                    src='/edit.svg'
                    className='edit-button'
                    onClick={() =>
                      setEditImage({
                        id: image.id,
                        title: image.title,
                        description: image.description,
                        image_path: image.image_path,
                        tags: image.tags.join(','),
                      })
                    }
                  />

                  {/* onclick edit-form popup */}
                  {editImage?.id && editImage.id == image.id && (
                    <EditForm
                      image_id={editImage?.id}
                      title={editImage?.title}
                      description={editImage?.description}
                      image_path={editImage?.image_path}
                      tags={editImage?.tags}
                      setEditImage={setEditImage}
                    />
                  )}
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
