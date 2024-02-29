
import { Link } from 'react-router-dom';

function Register() {
    return (
      <section className="text-center">
        <div className="p-5 bg-image"></div>

        <div className="card mx-4 mx-md-5 shadow-5-strong">
          <div className="card-body py-5 px-md-5">
            <div className="row d-flex justify-content-center">
              <div className="col-lg-8">
                <h2 className="fw-bold mb-5">Student Registration</h2>
                <form>
                  <div className="row">
                    <div className="col-md-6 mb-4">
                      <div className="form-outline">
                        <input
                          type="text"
                          id="form3Example1"
                          className="form-control"
                        />
                        <label className="form-label" for="form3Example1">
                          First name
                        </label>
                      </div>
                    </div>
                    <div className="col-md-6 mb-4">
                      <div className="form-outline">
                        <input
                          type="text"
                          id="form3Example2"
                          className="form-control"
                        />
                        <label className="form-label" for="form3Example2">
                          Last name
                        </label>
                      </div>
                    </div>
                  </div>

                  <div className="form-outline mb-4">
                    <input
                      type="email"
                      id="form3Example3"
                      className="form-control"
                    />
                    <label className="form-label" for="form3Example3">
                      Email address
                    </label>
                  </div>

                  <div className="form-outline mb-4">
                    <input
                      type="password"
                      id="form3Example4"
                      className="form-control"
                    />
                    <label className="form-label" for="form3Example4">
                      Password
                    </label>
                  </div>                  

                  <button
                    type="submit"
                    className="btn btn-primary btn-block mb-4"
                  >
                    Register
                                </button> 
                  <p>Already registered? <Link to="/login">Login Here</Link></p>              
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    );

    
}
export default Register;