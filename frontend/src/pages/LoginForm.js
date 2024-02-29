import { Link } from "react-router-dom";

function LoginForm() {
  return (
    <form>
      <div className="p-5 bg-image"></div>

      <div className="card mx-4 mx-md-5 shadow-5-strong">
        <div className="card-body py-5 px-md-5">
          <div className="row d-flex justify-content-center">
            <div className="col-lg-8">
              <h2 className="fw-bold mb-5 text-center">Login</h2>
              <form>
                <label className="form-label" for="form3Example3">
                  Email address
                </label>
                <div className="form-outline mb-4">
                  <input
                    type="email"
                    id="form3Example3"
                    className="form-control"
                  />
                </div>
                <div className="form-outline mb-4">
                  <label className="form-label" for="form3Example4">
                    Password
                  </label>
                  <input
                    type="password"
                    id="form3Example4"
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
    </form>
  );
}

export default LoginForm;
