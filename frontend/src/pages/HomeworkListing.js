import HomeworkItem from "../components/HomeworkItem";

function HomeWorkListing() {
  return (
    <>
      <div className="accordion" id="accordionExample">
        {[1, 2, 3].map((item, index) => (
          <HomeworkItem
            key={"test" + index}
            item={index}
            id={"test" + index}
            data_target={"collapse" + index}
          />
        ))}
      </div>
    </>
  );
}

export default HomeWorkListing;
