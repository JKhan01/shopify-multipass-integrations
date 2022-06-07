import React, {Component} from 'react';
// import TokenGenerator from '../multipass-helper/TokenGenerator';

class Login extends Component{

    validateAndLogin(event){
        // event.preventDefault();
        let username = event.target.getElementsByTagName("input")[0].value;
        let password = event.target.getElementsByTagName("input")[1].value;
        console.log(username);
        console.log(password);
        
        
        if (username === "jkhan266work@gmail.com"){
                // let multipassTokenObject = new TokenGenerator();
                // console.log(multipassTokenObject.generateUrl());
                // window.location.replace(multipassTokenObject.generateUrl());
                console.log("Correct Cred");
                return true;
            }


        console.log("Invalid Credentials");
        return false;


    }

    componentDidMount(){
        let url = new URL(window.location.href);
        if (url.searchParams.get("error") === "invalid"){
            alert("Invalid Credentials were provided. Please provide correct credentials.");
        }
    }

    render(){
        return (<div className='container'><form method="POST" action='http://localhost:5005/login'>
            <input type="email" name='email' placeholder="Enter Email" className='form-control' required></input>
            <br></br>
            <input type="password" name="password" placeholder="Password" className="form-control" required />
            <br></br>
            <button type="submit" className="btn btn-success">Submit</button>
        </form></div>);
    }
}
export default Login;