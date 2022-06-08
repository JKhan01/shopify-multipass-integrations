import { Component } from "react";


class Signup extends Component{

    componentDidMount(){
        let url = new URL(window.location.href);
        if (url.searchParams.get("error") === "query"){
            alert("Server unable to register new user. Please try again later!");
        }

        else if (url.searchParams.get("error") === "exists"){
            alert("Credentials already in use. Please provide correct credentials.");
        }
    }

    validateForm(event){
        if (event.target.getElementsByTagName("input")[1].value === event.target.getElementsByTagName("input")[2].value){
            return false;
        }
        alert("Passwords Dont match");
        return false;
    }

    checkPassword(event){
        if (document.getElementsByName("password")[0].value === document.getElementsByName("repassword")[0].value){
            document.getElementsByName("repassword")[0].style.borderColor = "green";
            return;
        }
        document.getElementsByName("repassword")[0].style.borderColor = "red";
        return;
    }

    checkPhoneNumber(event){
        let regex = new RegExp("[0-9]{10}");
        if (regex.test(document.getElementsByName("phone_number")[0].value)){
            document.getElementsByName("phone_number")[0].style.borderColor = "green";
            return;
        }
        document.getElementsByName("phone_number")[0].style.borderColor = "red";
        return;
    }
    checkZipCode(event){
        let regex = new RegExp("[0-9]{6}");
        if (regex.test(document.getElementsByName("address_zip")[0].value)){
            document.getElementsByName("address_zip")[0].style.borderColor = "green";
            return;
        }
        document.getElementsByName("address_zip")[0].style.borderColor = "red";
        return;
    }
    render(){
        return (
            <div className='container'><form method="POST" onSubmit={this.validateForm} action='http://localhost:5005/signup'>
            <input type="email" name='email' placeholder="Enter Email" className='form-control' required></input>
            <br></br>
            <input type="password" name="password" placeholder="Enter Password" className="form-control" required />
            <input type="password" name="repassword" placeholder="Re-enter Password" className="form-control" onKeyUp={this.checkPassword} required />
            <br></br>
            <h3>Personal Details</h3>
            <input type="text" name="first_name" placeholder="Enter First Name" className="form-control" required />
            <input type="text" name="last_name" placeholder="Enter Last Name" className="form-control" required />
            <input type="text" name="phone_number" placeholder="Enter 10 digit Phone Number" className="form-control" onKeyUp={this.checkPhoneNumber} pattern="[0-9]{10}" required />
            <br></br>
            <h3>Address Details</h3>
            <input type="text" name="address_line1" placeholder="Address Line 1" className="form-control" required />
            <input type="text" name="address_city" placeholder="City" className="form-control" required />
            <input type="text" name="address_province" placeholder="Province" className="form-control" required />
            <input type="text" name="address_zip" placeholder="6 Digit Zip Code" onKeyUp={this.checkZipCode} className="form-control" pattern="[0-9]{6}" required />
            <input type="text" name="address_country" placeholder="Country" className="form-control" required />
            <br></br>
            <label>Alread Registered?<a href="/login">Login</a></label><br></br>
            <button type="submit" className="btn btn-success">Submit</button>
        </form></div>
        );
    }
}

export default Signup;