function LoadingSpinner() {
  return (
    <div className="text-center">
      <div
        className="spinner-grow text-primary"
        role="status"
        style={{ marginTop: "110px" }}
      ></div>
      <div className="sr-only">Loading...</div>
    </div>
  );
}
export default LoadingSpinner;
