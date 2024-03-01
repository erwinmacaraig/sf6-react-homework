import React from 'react';
import ReactDOM from 'react-dom/client';
import 'bootstrap/dist/css/bootstrap.css';
import './index.css';
import { BrowserRouter, Routes, Route } from "react-router-dom"; 


import App from './App';
import SubmissionForm from './pages/SubmissionForm';
import Register  from './pages/Register';
import LoginForm from './pages/LoginForm';
import PostHomework from './pages/PostHomework';

import reportWebVitals from './reportWebVitals';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <>
    
    <BrowserRouter>    
    <Routes>
      <Route path="/" element={<App />} />
      {/* <Route path="/fetch" element={<FetchData />}>
        <Route path="reference" element={ <Reference />} />
      </Route>   */}
        <Route path="/login" element={<LoginForm />} /> 
        <Route path="/submit/:homeworkId?" element={<SubmissionForm />} /> 
        <Route path="/create-homework" element={<PostHomework />} />
      <Route path="/register" element={<Register />} />
    </Routes>
  </BrowserRouter>
  </>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
