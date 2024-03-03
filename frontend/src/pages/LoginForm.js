import { Link } from "react-router-dom";
import { useState, useEffect } from "react";
import LoadingSpinner from "../components/LoadingSpinner";
import ModalAlert from "../components/ModalAlert";
import { useNavigate } from "react-router-dom";
function LoginForm() {

  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  
  const navigate = useNavigate();
   const [registrationStatus, setRegistrationStatus] = useState(false);
  const [alertTitle, setAlertTitle] = useState(null);
  const [alertMessage, setAlertMessage] = useState(null);
  const [navigateTo, setNavigateTo] = useState(null);
  


  useEffect(() => { 
    localStorage.removeItem('token');
  }, []);
  
  const handleLogin = (e) => { 
    e.preventDefault();
    setLoading(true); 
    const loginValues = {
      username: document.querySelector('#email').value,
      password: document.querySelector('#password').value
    };
    console.log(loginValues);

    fetch('http://localhost:8000/api/login_check', {
      mode: 'cors',
      method: 'post',
      body: JSON.stringify(loginValues),
      headers: {
        "Access-Control-Allow-Origin": "*",
        "Content-Type": "application/json",
      }
    })
      .then((response) => { 
        if (response.status !== 200) throw new Error(response.message)
        return response.json();
      })
      .then((data) => {
        console.log(data);
        setLoading(false);
        localStorage.setItem('token', data.token); 
        navigate('/homework');
       })
      .catch((error) => { 
        setLoading(false);
        setError(error)
        console.log(error); 
        setAlertTitle("Error");
         setAlertMessage("There was a problem loging in to your account. Please check your credentials");
         setNavigateTo("/");
        setRegistrationStatus(true);

      });
    
  }
  if (loading) {
    return (
      <LoadingSpinner />
    );
  }
  if (error) {
      console.log(error);
  }
  return (
    <>
      <ModalAlert show={registrationStatus} alertTitle={alertTitle} alertMessage={alertMessage} navigateTo={navigateTo}  />
      <div className="p-5 bg-image"></div>
      <div className="card mx-4 mx-md-5 shadow-5-strong">
        <div className="card-body py-5 px-md-5">
          <div className="row d-flex justify-content-center">
            <div className="col-lg-8">
              <h2 className="fw-bold mb-5 text-center">Login</h2>
              <form onSubmit={handleLogin}>
                <label className="form-label" htmlFor="email">
                  Email address
                </label>
                <div className="form-outline mb-4">
                  <input
                    type="email"
                    id="email"
                    className="form-control"
                  />
                </div>
                <div className="form-outline mb-4">
                  <label className="form-label" htmlFor="password">
                    Password
                  </label>
                  <input
                    type="password"
                    id="password"
                    className="form-control"
                  />
                </div>
                <div className="text-center">
                  <button
                    type="submit"
                    className="btn btn-primary btn-block mb-4"
                  >
                    Login
                  </button>
                </div>
                <div className="text-center">
                  <p>
                    Not a member? <Link to="/register">Register</Link>
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default LoginForm;
