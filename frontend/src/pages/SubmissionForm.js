import { useState, useEffect } from "react";
import DatePicker from "react-datepicker";
import MyDropzone from "../components/MyDropzone"
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
        "class_title": "" ,
        "date_submitted": null,
        "submission_id": null, 
        "submitted_to_homework_id": null
    });
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);


    const handleHomeworkSubmission = (e) => {
      e.preventDefault();
      setLoading(true);
        const submissionDate = document.querySelector('#date-submitted').value; 
        const submitTitle = document.querySelector('#inputSubmissionTitle').value;
        const remarks = document.querySelector("#submissionRemarks").value;

        console.log(submissionDate);
        console.log(submitTitle);
      console.log(remarks);

      const submitHwBody = {
        "homework_id": homeworkId, 
        "date_submitted": submissionDate,
        "title": submitTitle,
        "remarks": remarks

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
            body: JSON.stringify({homeworkId:homeworkId})
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

  function RenderControl(){ 
    if (hwState.submission_id)
          {
            return (
              <>
                <div class="alert alert-warning" role="alert">
          You already have submitted your work last {hwState.date_submitted}
        </div>
        
              </>
            );
          } else {
            return (
              <>
                <button style={{width: "100%"}} type="submit" className="btn btn-primary">
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
      <ModalAlert show={registrationStatus} alertTitle={alertTitle} alertMessage={alertMessage} navigateTo={navigateTo}  />
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
                      <p>{ hwState.description}</p>
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
                  type="text"
                  className="form-control"
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
                          <div className="form-group">
                              <MyDropzone />
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
                  className="form-control"
                  id="submissionRemarks"
                  rows="3"
                ></textarea>
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
