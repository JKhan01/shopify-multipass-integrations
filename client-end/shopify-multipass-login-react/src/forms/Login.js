import React, {Component} from 'react';

class Login extends Component{

 render(){
        return (<div className='container'><form>
            <input type="email" placeholder="Enter Email" className='form-control' required></input>
            <br></br>
            <input type="password" name="password" placeholder="Password" className="form-control" required />
            <br></br>
            <button type="submit" className="btn btn-success">Submit</button>
        </form></div>);
    }
}
export default Login;