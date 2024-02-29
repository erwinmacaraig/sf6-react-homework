import { useState } from "react";
import DatePicker from "react-datepicker";
import MyDropzone from "../components/MyDropzone"
import NavigationBar from "../components/NavigationBar";

import "react-datepicker/dist/react-datepicker.css";

function SubmissionForm() {
    const [startDate, setStartDate] = useState(new Date());
  return (
      <>
           <NavigationBar />
      <section className="text-center">
        <h2 className="fw-bold mb-5">Submit Your Work</h2>
      </section>
      <div className="card mx-4 mx-md-5 shadow-5-strong">
        <div className="card-body py-5 px-md-5">
          <div className="row d-flex justify-content-center">
            <p>This will contain the project description</p>
          </div>
        </div>
      </div>
      <form className="mx-4 mx-md-5 mt-5">
        <div className="row">
          <div className="col-md-12 mb-4">
            <div className="form-outline">
              <div class="form-group">
                <label for="date-submitted">Submission Date:</label>
                              <p>
                                  <DatePicker
      dateFormat="yyyy/MM/dd"
      selected={startDate}
                                  onChange={(date) => setStartDate(date)}
                                  className="form-control"
                                  id="date-submitted"
                                  disabled
    />
                </p>
              </div>
            </div>
          </div>
        </div>

        <div className="row">
          <div className="col-md-12 mb-4">
            <div className="form-outline">
              <div class="form-group">
                <label for="inputSubmissionTitle">Submission Title</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputSubmissionTitle"
                  aria-describedby="submission Help"
                  placeholder="Enter Title of your Work"
                />
              </div>
            </div>
          </div>
        </div>

        <div className="row">
          <div className="col-md-12 mb-4">
                      <div className="form-outline">
                           <label>Upload Here:</label>
                          <div class="form-group">
                              <MyDropzone />
                          </div>
                      </div>
                  </div>
                  </div>
                      
        <div class="row">
          <div className="col-md-12 mb-4">
            <div className="form-outline">
              <div class="form-group">
                <label for="exampleFormControlTextarea1">
                  Remarks
                </label>
                <textarea
                  class="form-control"
                  id="exampleFormControlTextarea1"
                  rows="3"
                ></textarea>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">
          Submit
        </button>
      </form>
    </>
  );
}
export default SubmissionForm;
