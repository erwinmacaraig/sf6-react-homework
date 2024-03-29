import DatePicker from "react-datepicker";
import NavigationBar from "../components/NavigationBar";
import LoadingSpinner from "../components/LoadingSpinner";
import { useState, useEffect, useRef } from "react";
import { useNavigate } from "react-router-dom";


function PostHomework() {
    const [startDate, setStartDate] = useState(new Date());
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [classList, setClassList] = useState([])
    const navigate = useNavigate();
    const selectRef = useRef();
    const descriptionRef = useRef();    

    const handleCreateHomework = (e) => {
        e.preventDefault();        
        console.log(selectRef.current.value);        
        console.log(descriptionRef.current.value)
        console.log(document.querySelector('#dedDate').value);
        console.log(document.querySelector('#inputHomeworkTitle').value);       

        setLoading(true);
        fetch('http://localhost:8000/api/post-homework', {
            mode: 'cors',
            method: 'post',
            headers: {
              "Content-Type": "application/json",
              "Authorization": "Bearer " + localStorage.getItem("token")
            },
            body: JSON.stringify({
                title: document.querySelector('#inputHomeworkTitle').value,
                description: descriptionRef.current.value,
                deadline: document.querySelector('#dedDate').value,
                student_class: selectRef.current.value,
               
            })
        })
            .then((response) => response.json())
            .then((data) => console.log(data))
            .then(() => setLoading(false))
            .then(() => {                
                // selectRef.current.value = classList[0]['id'];
                setStartDate(new Date());
                // descriptionRef.current.value = '';
                // document.querySelector('#inputHomeworkTitle').value = '';
                

            })
        .catch(setError);

     }

    useEffect(() => {
      setLoading(true);
      if (localStorage.getItem('role') !== 'ROLE_TEACHER') {
        navigate('/login');
      }
        fetch('http://localhost:8000/api/user-registered-class', {
            mode: "cors",
            method: 'get',
            headers: {
                "Access-Control-Allow-Origin": "*",
              "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("token")
            }
        })
            .then((response) => response.json())
            .then((data) => setClassList(data))
            .then(() => setLoading(false))
            .catch(setError);
    }, []);

    if (loading) {
    return (
      <LoadingSpinner />
    );
  }
    if (error) {
        navigate("/"); 
        console.log("ERROR", error);
    
  }
  if (classList.length === 0) {
    return (
      <>
        <NavigationBar />
        <div className="p-5 bg-image"></div>
        <div className="card mx-4 mx-md-5 shadow-5-strong">
          <div className="card-body py-5 px-md-5">
            <div className="row d-flex justify-content-center">
              <div className="col-lg-8 text-center">
                <h2 className="fw-bold mb-5">Post A New Homework</h2>
                <p>There is no assigned classes for you to teach.</p>
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
        <section className="text-center">
        <h2 className="fw-bold mb-5">Post A New Homework</h2>
        </section>
        
        <form onSubmit={handleCreateHomework}>
        <div className="mx-4 mx-md-5 shadow-5-strong">
          <div className="row">
            <div className="col">
              <div className="form-outline mb-4">
                <label htmlFor="subject-list">Class List</label>
                      <select
                                  ref={selectRef}
                  id="subject-list"
                  className="form-select form-select-md"
                                  aria-label=".form-select-sm example"                                  
                                  readOnly
                >
                  <option value={0} disabled>List of Your Classes</option>
                                  {classList.map((item, index) => { 
                                      return <option key={'subject' + index+1} value={item.id}>{item.class_title}</option> 
                                  })}
                </select>



              </div>
            </div>
            <div className="col-auto">
              <div className="form-outline">
                              <div className="form-group">
                                  
                  <label htmlFor="dedDate">Deadline Date:</label>
                  <br />
                    <DatePicker
                      dateFormat="yyyy/MM/dd"
                        selected={startDate}
                        minDate={new Date()}
                      onChange={(date) => setStartDate(date)}
                      className="form-control"
                      id="dedDate"
                    />
                  
                </div>
              </div>
            </div>
                  </div>
                  <div className="row">
          <div className="col-md-12 mb-4">
            <div className="form-outline">
              <div className="form-group">
                <label htmlFor="inputHomeworkTitle">Homework Title</label>
                <input
                  type="text"
                  className="form-control"
                  id="inputHomeworkTitle"
                  aria-describedby="Title Help"
                  placeholder="Specify the main title of this homework"
                />
              </div>
            </div>
          </div>
        </div>
          <div className="row d-flex justify-content-center">
            <div className="form-group">
              <label htmlFor="exampleFormControlTextarea1">
                Homework Description
              </label>
                          <textarea
                              ref={descriptionRef}
                className="form-control"
                id="exampleFormControlTextarea1"
                rows="8"
              ></textarea>
            </div>
                  </div>
                  <div className="row mt-4">
                      <div className="col">
                          <div className="form-outline">
                              <button type="submit" className="btn btn-primary" style={{width:"100%"}}>
          Submit
        </button>
                          </div>
                      </div>
            </div>
        </div>
      </form>
      
    </>
    );
  

 
}
export default PostHomework;
