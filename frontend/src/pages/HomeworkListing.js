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
         },
        body: JSON.stringify({
            "user":40
        })

    })
      .then((response) => response.json())
      .then((data) => setHomeworks(data))
      .then(() => setLoading(false))
      .catch(setError);
  }, []);

  if (loading) {
    return (
      <LoadingSpinner />
    );
  }
  if (error) {
    return <pre>{JSON.stringify(error)}</pre>;
  }
  if (!homeworks) return null;

  return (
    <>
      <div className="accordion" id="accordionExample">
        {homeworks.map((item, index) => (
            <HomeworkItem
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
