import './Card.css'
import { image_folder_path } from '../../utils/shared'
const Card = ({ id, title, description, image_path, tags }) => {
  return (
    <div
      key={id}
      className='image-card'
    >
      <img
        src={image_folder_path + image_path}
        alt={title}
        className='image-preview'
      />
      <div className='image-details'>
        <h3>{title}</h3>
        <p>{description}</p>
        <div className='tags'>
          {tags &&
            tags.map((tag, index) => (
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
  )
}

export default Card
