import { useDropzone } from "react-dropzone";

function MyDropzone(props) {
    const {acceptedFiles, getRootProps, getInputProps} = useDropzone();
  
  const files = acceptedFiles.map(file => (
    <li key={file.path}>
      {file.path} - {file.size} bytes
    </li>
  ));

  return (
    <section>
      <div {...getRootProps({className: 'dropzone dropzone-style'})}>
        <input {...getInputProps()} />
        <p>Drag 'n' drop some files here, or click to select files</p>
      </div>
      <aside>
        <h5>File</h5>
        <ul>{files}</ul>
      </aside>
    </section>
  );
}

export default MyDropzone;