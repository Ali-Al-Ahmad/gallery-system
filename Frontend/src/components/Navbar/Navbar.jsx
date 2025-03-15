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
            src='/logo.svg'
            alt='logo.svg'
          />
        </Link>
        <div className='nav-items'>
          {/* if User Not LoggedIn show register/login */}
          {!localStorage.getItem('user_id') && (
            <Link
              to={currentPath === '/register' ? '/' : 'register'}
              className='nav-link'
            >
              <p>{currentPath === '/register' ? 'Login' : 'Signup'}</p>
            </Link>
          )}

          {/* if User LoggedIn show Home/Upload */}
          {localStorage.getItem('user_id') && (
            <Link
              to={currentPath === '/home' ? '/upload' : 'home'}
              className='nav-link'
            >
              <p>{currentPath === '/home' ? 'Upload' : 'Home'}</p>
            </Link>
          )}

          {/*show Logout only if loggedin */}

          {localStorage.getItem('user_id') && (
            <Link
              onClick={() => localStorage.removeItem('user_id')}
              to='/'
              className='nav-link'
            >
              <p>Logout</p>
            </Link>
          )}
        </div>
      </nav>
    </div>
  )
}

export default Navbar
