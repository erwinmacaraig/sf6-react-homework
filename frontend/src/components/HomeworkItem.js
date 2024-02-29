import { useState, useRef } from "react";

function HomeworkItem(props) {
  const targetData = "#" + props.data_target;
  const divRef = useRef(null);
  const [toggle, setToggle] = useState(false);

  function handleShowHideCard() {
    setToggle(!toggle);
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
            Homework Item {parseInt(props.item) + 1}
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
          <h5 className="card-title">Special title treatment</h5>
          <p className="card-text">
            With supporting text below as a natural lead-in to additional
            content.
          </p>
          <a href="#" className="btn btn-primary">
            Go somewhere
          </a>
        </div>
        <div className="card-footer text-muted text-center">2 days ago</div>
      </div>
    </div>
  );
}

export default HomeworkItem;
