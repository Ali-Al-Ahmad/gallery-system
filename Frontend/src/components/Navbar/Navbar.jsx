import { Link } from 'react-router-dom'
import { useLocation } from 'react-router-dom'
import './Navbar.css'

const Navbar = () => {
  const location = useLocation()
  const currentPath = location.pathname

  return (
    <div className='header'>
      <nav>
        <Link to='/home'>
          <img
            src='../../../src/assets/logo.svg'
            alt='logo.svg'
          />
        </Link>
        <div className='nav-items'>
          {!localStorage.getItem('user_id') && (
            <Link
              to={currentPath === '/register' ? '/' : 'register'}
              className='nav-link'
            >
              <p>{currentPath === '/register' ? 'Login' : 'Signup'}</p>
            </Link>
          )}
          {localStorage.getItem('user_id') && (
            <Link
              onClick={() => localStorage.removeItem('user_id')}
              to='/'
              className='nav-link'
            >
              <p>Logut</p>
            </Link>
          )}
        </div>
      </nav>
    </div>
  )
}

export default Navbar
