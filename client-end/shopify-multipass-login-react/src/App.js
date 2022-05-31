import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import Login from './forms/Login';
import { Route, Routes } from 'react-router-dom';

function App() {
  return (
    <div className="App">
      <div className=' bg-success'>
        <h2 className="text-white">Shopify Multipass Workaround</h2>
      </div>
      <Routes>
        <Route exact path="/login" element={<Login />}></Route>
      </Routes>
    </div>
  );
}

export default App;
