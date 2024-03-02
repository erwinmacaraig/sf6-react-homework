import { useState, useEffect } from 'react';
import Button from 'react-bootstrap/Button';
import { useNavigate } from "react-router-dom";
import Modal from 'react-bootstrap/Modal';

function ModalAlert(props) {
  const [show, setShow] = useState(false);
  const navigate = useNavigate();

  const handleClose = () => {
    setShow(false);
    navigate(props.navigateTo);
  };
  const handleShow = () => setShow(true);

  useEffect(() => {
    setShow(props.show); 
  }, [props.show]);

  return (
    <>     
      <Modal
        show={show}
        onHide={handleClose}
        backdrop="static"
        keyboard={false}
      >
        <Modal.Header closeButton>
          <Modal.Title>{props.alertTitle}</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          {props.alertMessage}
        </Modal.Body>
        <Modal.Footer>
          {/* <Button variant="secondary" onClick={handleClose}>
            Close
          </Button> */}
          <Button variant="primary" onClick={handleClose}>OK</Button>
        </Modal.Footer>
      </Modal>
    </>
  );
}

export default ModalAlert;