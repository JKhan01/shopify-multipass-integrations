import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import Login from './forms/Login';
import { Route, Routes } from 'react-router-dom';
import Signup from './forms/Signup';
import { useEffect } from 'react';

function App() {

  useEffect(()=>{
    let url = new URL(window.location.href);
    if (url.searchParams.has("url")){
      window.location.href=url.searchParams.get("url");
    }
  });
  return (
    <div className="App">
      <div className=' bg-success'>
        <h2 className="text-white">Shopify Multipass Workaround</h2>
      </div>
      <Routes>
        <Route exact path="/login" element={<Login />}></Route>
        <Route exact path="/signup" element={<Signup />}></Route>
      </Routes>
    </div>
  );
}

export default App;
