import { useState, useEffect } from "react";
import HomeworkItem from "../components/HomeworkItem";
import LoadingSpinner from "../components/LoadingSpinner";
function HomeWorkListing() {
  const [homeworks, setHomeworks] = useState(null);
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
         },
        body: JSON.stringify({
            "user":40
        })

    })
      .then((response) => response.json())
        .then((data) => { 
            console.log("data received");
            setHomeworks(data);
            setLoading(false);
            console.log(data);
        })
    //   .then(() => setLoading(false))
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
  if (!homeworks) return null;

  return (
    <>
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
