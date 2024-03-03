import { useState, useEffect } from "react";
import HomeworkItem from "../components/HomeworkItem";
import LoadingSpinner from "../components/LoadingSpinner";
function HomeWorkListing() {
  const [homeworks, setHomeworks] = useState([]);
  const [error, setError] = useState(null);
    const [loading, setLoading] = useState(false);
    
  useEffect(() => {
    setLoading(true);
    fetch(`http://localhost:8000/api/list-class-hw`, {
        mode: "cors",
        method: 'post',
        headers: {
            "Access-Control-Allow-Origin": "*",
          "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token")
         }
    })
      .then((response) => response.json())
        .then((data) => { 
            console.log("data received");
            setHomeworks(data);
            setLoading(false);
            console.log(data);
        })    
      .catch(setError);
  }, []);

  if (loading) {
    return (
      <LoadingSpinner />
    );
  }
  if (error) {
      console.log(error);
  }
  if (homeworks.length == 0) {
    return (
      <>
      <div className="p-5 bg-image"></div>
      <div className="card mx-4 mx-md-5 shadow-5-strong">
        <div className="card-body py-5 px-md-5">
          <div className="row d-flex justify-content-center">
            <div className="col-lg-8 text-center">
              <h2 className="fw-bold mb-5">Posted Homework</h2>
              <p>There are no posted homework from your classes.</p>
            </div>
          </div>
        </div>
      </div>  
      </>
    )
  } 

  return (
    <>
      <h2 className="fw-bold mb-5 text-center">Posted Homework</h2>
      <div className="accordion" id="accordionExample">
        {homeworks.map((item, index) => (
            <HomeworkItem
                hwid={item.id}
                title={item.homework_title}
                description={item.description}
                posted={item.posted_date}
                deadline={item.submission_deadline}
                key={"homework" + index}
                item={index}
                id={"homework" + index}
                data_target={"collapse" + index}
          />
        ))}
      </div>
    </>
  );
}

export default HomeWorkListing;
