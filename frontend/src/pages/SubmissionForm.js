import { useState, useEffect } from "react";
import DatePicker from "react-datepicker";
import Dropzone from 'react-dropzone';

import NavigationBar from "../components/NavigationBar";
import { useParams } from 'react-router-dom'
import LoadingSpinner from "../components/LoadingSpinner";
import ModalAlert from "../components/ModalAlert";

import "react-datepicker/dist/react-datepicker.css";

function SubmissionForm() {
  const [registrationStatus, setRegistrationStatus] = useState(false);
  const [alertTitle, setAlertTitle] = useState(null);
  const [alertMessage, setAlertMessage] = useState(null);
  const [navigateTo, setNavigateTo] = useState(null);
  const [startDate, setStartDate] = useState(new Date());
  const { homeworkId } = useParams();
  const [hwState, setHwState] = useState({
    "description": "",
    "submission_deadline": "",
    "posted_date": "",
    "homework_title": "",
    "first_name": "",
    "family_name": "",
    "class_title": "",
    "date_submitted": null,
    "submission_id": null,
    "submitted_to_homework_id": null
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [formErrors, setFormErrors] = useState({});

  const [filesToUpload, setFilesTopload] = useState([]);

  const [formData, setFormData] = useState({
    title: "",
    remarks: ""
  });
  
  function ListFiles() {
    const fileList = filesToUpload.map(file => {

      return (
        <li key={file.path}>
          {file.path} - {file.size} bytes
        </li>);
    });

    return (
      <ul>{fileList}</ul>
    );
  }
  const processFilesToUpload = (acceptedFiles) => {
    setFilesTopload(acceptedFiles);
  }
  const handleInputChange = (e) => {
    const { name, value } = e.target;    
    setFormData({
      ...formData,
      [name]: value
    });
  };
  const validateForm = () => {
    let isValid = true;
    const newErrors = {};

    
    if (!formData.title) {
      newErrors.title = "Please provide a title for your work";
      isValid = false;
    }

    // Validate password
    if (!formData.remarks) {
      newErrors.remarks = "Provide a content for your submission.";
      isValid = false;
    }

    setFormErrors(newErrors);
    return isValid;
  };

  const handleHomeworkSubmission = (e) => {
    e.preventDefault();

    if (validateForm()) {
setLoading(true);
    const submissionDate = document.querySelector('#date-submitted').value;
    const submitHwBody = {
      "homework_id": homeworkId,
      "date_submitted": submissionDate,
      "title": formData.title,
      "remarks": formData.remarks
    }

    fetch('http://localhost:8000/api/process-homework-submission', {
      mode: 'cors',
      method: 'post',
      headers: {
        "Access-Control-Allow-Origin": "*",
        "Content-Type": "application/json",
        "Authorization": "Bearer " + localStorage.getItem("token")
      },
      body: JSON.stringify(submitHwBody)
    })
      .then((response) => {
        if (response.status !== 200) {
          setLoading(false);
          setAlertTitle("Submission Error");
          setAlertMessage("There was an error processing your submission. Please contact system administrator");
          setNavigateTo("/homework");
          setRegistrationStatus(true);
        }
        return response.json();
      })
      .then((data) => {
        setLoading(false);
        if (data.code === 401) {
          setAlertTitle(data.message);
          setAlertMessage("Your session has expired. Please login again");
          setNavigateTo("/login");

        } else {
          setAlertTitle("Submission Succesful");
          setAlertMessage("Your submission has been accepted. You will be notified by your instructor.");
          setNavigateTo("/homework");

        }
        setRegistrationStatus(true);

      })
      .catch((error) => {
        setError(error);
        setLoading(false);
      });

    filesToUpload.forEach((file) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => {
        const binaryStr = reader.result.toString().split(',')[1];
        fetch('http://localhost:8000/api/upload-homework', {
          mode: 'cors',
          method: 'post',
          headers: {
            "Access-Control-Allow-Origin": "*",
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token")
          },
          body: JSON.stringify({ f: binaryStr, name: file.name, homework: homeworkId })

        }).then(response => response.json())
          .then((data) => {
            console.log(data);
          });
      }

    });
    } // end form validation
  }


  useEffect(() => {
    setLoading(true);
    fetch(`http://localhost:8000/api/homework`, {
      method: 'post',
      mode: 'cors',
      headers: {
        "Access-Control-Allow-Origin": "*",
        "Content-Type": "application/json",
        "Authorization": "Bearer " + localStorage.getItem("token")
      },
      body: JSON.stringify({ homeworkId: homeworkId })
    })
      .then((response) => {
        if (response.status !== 200) {
          setAlertTitle('Server Error');
          setAlertMessage("Contact system administrator for assistance");
          setNavigateTo("/homework");
          setRegistrationStatus(true);
        }
        return response.json();
      })
      .then((data) => {
        console.log(data);
        setLoading(false);
        if (data.code === 401) {
          setAlertTitle(data.message);
          setAlertMessage("Your session has expired. Please login again");
          setNavigateTo("/login");
          setRegistrationStatus(true);
        } else {
          setHwState(data);
        }


      })
      .catch(setError);
  }, [homeworkId]);

  function RenderControl() {
    if (hwState.submission_id) {
      return (
        <>
          <div className="alert alert-warning" role="alert">
            You already have submitted your work last {hwState.date_submitted}
          </div>

        </>
      );
    } else {
      return (
        <>
          <button style={{ width: "100%" }} type="submit" className="btn btn-primary">
            Submit
          </button>
        </>
      )
    }
  }

  if (loading) {
    return (
      <LoadingSpinner />
    );
  }
  if (error) {
    console.log(error);
  }
  if (Object.keys(hwState).length === 0) {
    return (
      <>
        <NavigationBar />
        <div className="p-5 bg-image"></div>
        <div className="card mx-4 mx-md-5 shadow-5-strong">
          <div className="card-body py-5 px-md-5">
            <div className="row d-flex justify-content-center">
              <div className="col-lg-8 text-center">
                <h2 className="fw-bold mb-5">Submit Your Work</h2>
                <p>There is no posted homework.</p>
              </div>
            </div>
          </div>
        </div>
      </>
    );
  }
  return (
    <>
      <NavigationBar />
      <ModalAlert show={registrationStatus} alertTitle={alertTitle} alertMessage={alertMessage} navigateTo={navigateTo} />
      <section className="text-center">
        <h2 className="fw-bold mb-5">Submit Your Work</h2>
      </section>
      <div className="card mx-4 mx-md-5 shadow-5-strong">
        <div className="card-body py-5 px-md-5">
          <div className="row d-flex justify-content-center">
            <h6>Class: {hwState.class_title}</h6>
            <h6>Instructor: {hwState.first_name} {hwState.family_name}.</h6>
            <h6>Homework: {hwState.homework_title}.</h6>
            <h6>Date Posted: {hwState.posted_date}.</h6>
            <h6>Deadline of Submission: {hwState.submission_deadline}.</h6>
            <p>{hwState.description}</p>
          </div>
        </div>
      </div>
      <form className="mx-4 mx-md-5 mt-5" onSubmit={handleHomeworkSubmission}>
        <div className="row">
          <div className="col-md-12 mb-4">
            <div className="form-outline">
              <div className="form-group">
                <label htmlFor="date-submitted">Submission Date:</label>

                <DatePicker
                  dateFormat="yyyy/MM/dd"
                  selected={startDate}
                  onChange={(date) => setStartDate(date)}
                  className="form-control"
                  id="date-submitted"
                  disabled
                />

              </div>
            </div>
          </div>
        </div>

        <div className="row">
          <div className="col-md-12 mb-4">
            <div className="form-outline">
              <div className="form-group">
                <label htmlFor="inputSubmissionTitle">Submission Title</label>
                <input
                  name="title"
                  type="text"
                  className="form-control"
                  id="inputSubmissionTitle"
                  aria-describedby="submission Help"
                  placeholder="Enter Title of your Work"
                  onChange={handleInputChange}
                />
                {formErrors.title && <div className="error"  style={{color: 'red'}}>{formErrors.title}</div>}
              </div>
            </div>
          </div>
        </div>

        <div className="row">
          <div className="col-md-12 mb-4">
            <div className="form-outline">
              <label>Upload Here:</label>
              <div className="form-group">
                <Dropzone maxFiles={1} onDrop={(acceptedFiles) => processFilesToUpload(acceptedFiles)}>
                  {({ getRootProps, getInputProps }) => (
                    <section>
                      <div {...getRootProps({ className: 'dropzone dropzone-style' })}>
                        <input {...getInputProps()} />
                        <p>Drag 'n' drop some files here, or click to select files</p>
                      </div>
                      <aside>
                        <h5>File</h5>
                        <ListFiles />
                      </aside>

                    </section>


                  )}
                </Dropzone>
              </div>
            </div>
          </div>
        </div>

        <div className="row">
          <div className="col-md-12 mb-4">
            <div className="form-outline">
              <div className="form-group">
                <label htmlFor="submissionRemarks">
                  Remarks
                </label>
                <textarea
                  onChange={handleInputChange}
                  name="remarks"
                  className="form-control"
                  id="submissionRemarks"
                  rows="3"
                ></textarea>
                {formErrors.remarks && <div className="error"  style={{color: 'red'}}>{formErrors.remarks}</div>}
              </div>
            </div>
          </div>
        </div>
        <RenderControl />
      </form>
    </>
  );
}
export default SubmissionForm;
