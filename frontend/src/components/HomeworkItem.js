import { useState, useRef } from "react";
import { Link } from 'react-router-dom';

function HomeworkItem(props) {
  const targetData = "#" + props.data_target;
  const divRef = useRef(null);
  const [toggle, setToggle] = useState(false);

  function handleShowHideCard() {
    setToggle(!toggle);
  }

  function SubmitContainer() {
    if (localStorage.getItem === 'ROLE_TEACHER') {
      return (
        <p className="card-text text-end"></p>
      );
    } else if (localStorage.getItem === 'ROLE_STUDENT') {
      return (
        <p className="card-text text-end"><Link to={`/submit/${props.hwid}`} className="btn btn-primary">
          Submit
        </Link></p>
      );
    }
  }

  return (
    <div className="card">
      <div className="card-header text-center" id={props.id}>
        <h5 className="mb-0">
          <button
            className="btn btn-link"
            type="button"
            data-toggle="collapse"
            data-target={targetData}
            aria-expanded="true"
            aria-controls={props.data_target}
            onClick={handleShowHideCard}
          >
                      {props.subject} - {props.title}
          </button>
        </h5>
      </div>

      <div
        ref={divRef}
        id={props.data_target}
        className={"collapse " + (toggle ? "show" : "")}
        aria-labelledby="headingOne"
        data-parent="#accordionExample"
      >
        <div className="card-body">
                  <h5 className="card-title">{props.title}</h5>
          <p className="card-text">{props.description}</p>
          <SubmitContainer />
                  
        </div>
              <div className="card-footer text-muted text-center">Date Posted: {props.posted} | Deadline of Submission: {props.deadline }</div>
      </div>
    </div>
  );
}

export default HomeworkItem;
