import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { useNavigate } from "react-router-dom";

function NavigationBar() {
  const [toggleShow, setToggleShow] = useState(false);
  const navigate = useNavigate();

  const logoutUser = () => { 
    localStorage.removeItem("token");
    navigate("/");
  };
    
    return (
      <nav
        className="navbar navbar-expand-lg navbar-light mb-4"
        style={{ backgroundColor: "#e3f2fd", padding: "15px 30px" }}
      >
        <Link className="navbar-brand" to="/homework">
          Home
        </Link>

        <button
          className="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span className="navbar-toggler-icon"></span>
        </button>
        <div className="collapse navbar-collapse" id="navbarNavDropdown">
          <ul className="navbar-nav">
            <li
              className={
                toggleShow ? "nav-item dropdown show" : "nav-item dropdown"
              }
              onClick={() => {
                setToggleShow(!toggleShow);
              }}
              onMouseLeave={() => {
                setToggleShow(!toggleShow);
              }}
            >
              <a
                className="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdownMenuLink"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded={toggleShow}
              >
                Homework
              </a>
              <div
                className={toggleShow ? "dropdown-menu show" : "dropdown-menu"}
                aria-labelledby="navbarDropdownMenuLink"
              >
                <Link className="dropdown-item" to="/submit">
                  Submit Homework
                </Link>
                <Link to="/create-homework" className="dropdown-item">
                  Post Homework
                </Link>
              </div>
            </li>
          </ul>
        </div>
        <a href='#'  onClick={logoutUser} className="nav-item mr-md-4 b">
          Logout
        </a>
      </nav>
    );
}

export default NavigationBar;
