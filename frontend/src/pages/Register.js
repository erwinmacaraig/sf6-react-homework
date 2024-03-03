import { Link } from "react-router-dom";
import { useEffect, useState } from "react";
import LoadingSpinner from "../components/LoadingSpinner";
import ModalAlert from "../components/ModalAlert";
function Register() {
  const [classList, setClassList] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [registrationStatus, setRegistrationStatus] = useState(false);
  const [alertTitle, setAlertTitle] = useState(null);
  const [alertMessage, setAlertMessage] = useState(null);
  const [navigateTo, setNavigateTo] = useState(null);

  const handleRegistrationSubmit = (e) => {
    e.preventDefault();
    setLoading(true);
    console.log(document.querySelector("#student-classes").selectedOptions);
    const choosenClasses =
      document.querySelector("#student-classes").selectedOptions;
    const values = Array.from(choosenClasses).map(({ value }) =>
      parseInt(value)
    );
    console.log(values);
    const registrationData = {
      firstName: document.querySelector("#firstName").value,
      familyName: document.querySelector("#familyName").value,
      email: document.querySelector("#email").value,
      password: document.querySelector("#password").value,
      role: document.querySelector('input[name="role"]:checked').value,
      classes: values,
    };
    console.log(registrationData);
    fetch("http://localhost:8000/api/register-student", {
      mode: "cors",
      method: "post",
      body: JSON.stringify(registrationData),
      headers: {
        "Access-Control-Allow-Origin": "*",
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        setLoading(false);
        setAlertTitle("Registration Succesful");
        setAlertMessage(
          "Your registration has been processed. You may now login."
        );
        setNavigateTo("/login");
        setRegistrationStatus(true);
      })
      .catch((error) => {
        setLoading(false);
        setError(error);
        setAlertTitle("Error");
        setAlertMessage(
          "There was a problem processing your registration. Please contact system administrator"
        );
        setNavigateTo("/register");
        setRegistrationStatus(true);
      });
  };

  useEffect(() => {
    setLoading(true);
    fetch("http://localhost:8000/api/classes", {
      method: "get",
      mode: "cors",
      headers: {
        "Access-Control-Allow-Origin": "*",
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        setClassList(data);
        setLoading(false);
      })
      .catch((error) => {
        setError(error);
      });
  }, []);

  if (loading) {
    return <LoadingSpinner />;
  }
  if (error) {
    console.log(error);
  }
  if (!classList) return null;
  return (
    <section className="text-center">
      <div className="p-5 bg-image"></div>
      <div className="card mx-4 mx-md-5 shadow-5-strong">
        <div className="card-body py-5 px-md-5">
          <div className="row d-flex justify-content-center">
            <div className="col-lg-8">
              <h2 className="fw-bold mb-5">Student Registration</h2>
              <form onSubmit={handleRegistrationSubmit}>
                <div className="row">
                  <div className="col-md-6 mb-4">
                    <div className="form-outline">
                      <input
                        type="text"
                        id="firstName"
                        className="form-control"
                      />
                      <label className="form-label" htmlFor="firstName">
                        First name
                      </label>
                    </div>
                  </div>
                  <div className="col-md-6 mb-4">
                    <div className="form-outline">
                      <input
                        type="text"
                        id="familyName"
                        className="form-control"
                      />
                      <label className="form-label" htmlFor="familyName">
                        Last name
                      </label>
                    </div>
                  </div>
                </div>

                <div className="form-outline mb-4">
                  <input type="email" id="email" className="form-control" />
                  <label className="form-label" htmlFor="email">
                    Email address
                  </label>
                </div>

                <div className="form-outline mb-4">
                  <input
                    type="password"
                    id="password"
                    className="form-control"
                  />
                  <label className="form-label" htmlFor="password">
                    Password
                  </label>
                </div>

                <div className="row">
                  <div className="col-md-6 mb-4">
                    <div className="form-outline">
                      <input
                        className="form-check-input"
                        type="radio"
                        name="role"
                        id="studentRoleRadio"
                        checked
                        value="ROLE_STUDENT"
                      />
                      <label
                        className="form-check-label"
                        for="studentRoleRadio"
                      >
                        Student
                      </label>
                    </div>
                  </div>

                  <div className="col-md-6 mb-4">
                    <div className="form-outline">
                      <input
                        className="form-check-input"
                        type="radio"
                        name="role"
                        id="teacherRoleRadio"
                        value="ROLE_TEACHER"
                      />
                      <label
                        className="form-check-label"
                        for="teacherRoleRadio"
                      >
                        Teacher
                      </label>
                    </div>{" "}
                  </div>
                </div>

                <div className="form-outline mb-4">
                  <select
                    id="student-classes"
                    className="form-select"
                    multiple
                    aria-label="multiple select example"
                  >
                    {classList.map((item, index) => {
                      return (
                        <option key={"subject" + index + 1} value={item.id}>
                          {item.class_title}
                        </option>
                      );
                    })}
                  </select>
                  <label className="form-label" htmlFor="student-classes">
                    Available Classes
                  </label>
                </div>

                <button
                  type="submit"
                  className="btn btn-primary btn-block mb-4"
                >
                  Register
                </button>
                <p>
                  Already registered? <Link to="/login">Login Here</Link>
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
      <ModalAlert
        show={registrationStatus}
        alertTitle={alertTitle}
        alertMessage={alertMessage}
        navigateTo={navigateTo}
      />
    </section>
  );
}
export default Register;
