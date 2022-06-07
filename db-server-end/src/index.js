// Resolve the Dependancies

const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const helmet = require('helmet');
const morgan = require('morgan');
const userData = require("./multipass-helper/SampleCredentials");
const TokenGenerator  = require('./multipass-helper/TokenGenerator').TokenGenerator;
const UserService = require('./service/UserService.js').UserService;
const UserModel = require('./model/UserModel').UserModel;

const app = express();

// adding Helmet to enhance your Rest API's security
app.use(helmet());

// using bodyParser to parse JSON bodies and urlencoded form post data into JS objects
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({
    extended:true
}))

// enabling CORS for all requests
app.use(cors());

// adding morgan to log HTTP requests
app.use(morgan('combined'));

// Defining First Endpoint
app.get("/", (req, res) => {
    res.send(userData)
})

var mysql      = require('mysql');

const tableName = "user_details";
const columnName01 = "user_email";
const columnName02 = "user_password";

connection = mysql.createConnection({
    host     : 'localhost',
    port: 3306,
    user     : 'root',
    password : 'root',
    database : 'shopify_multipass'
    });

    connection.connect(function(err) {
    if (err) {
        console.error('error connecting: ' + err.stack);
        return;
    }

    console.log('connected ');
    });

app.post("/login",(req,res)=>{
    try {
        console.log(req.body);
        const userModel = new UserModel();
        userModel.setUserEmail(req.body.email);
        userModel.setUserPassword(req.body.password);

        // const userService = new UserService();
        // let result = async ()=>{return await userService.getUserDetails(userModel)};
        // urlGenObject = new TokenGenerator();

        const columnValue = userModel.getUserEmail();
        const queryString = `select * from ${tableName} where ${columnName01}='${columnValue}' and ${columnName02} = '${userModel.getUserPassword()}'`;
        // let queryResult = [];
        console.log(queryString);
        connection.query(queryString,
            (error,results)=>{
            if (error){
                console.log("Error Occured!\n"+error);
                return;
                
            }
            // queryResult = JSON.stringify(results);
            // console.log("Fetched Result: " + JSON.stringify(results[0]));
            // return (results)=>{
            //     queryResult = results;
            // }
            if (results.length != 0){
                // console.log(JSON.stringify(results[0]));
                const v = JSON.stringify(results[0]);
                userModel.getUserFirstName = JSON.parse(v).user_address;
                console.log(userModel.getUserAddress());
            }
            // return this.getDetailsCallback(results[0]);
            res.sendStatus(204);
        }
        );

        // console.log(queryResult);
        // return this.queryResult;
    
        // console.log("Line of Code Reached");
        // console.log(JSON.stringify(result));
        // if (result != null){
        //     // userModel.setUserAddress(result[0].)
        //     // urlGenObject = new TokenGenerator();
        //     // url = urlGenObject.generateUrl();
        //     // console.log(url);
        //     // res.redirect(303,url);
        //     console.log("Condition to be written");
        // }
        
        // res.sendStatus(204);

    } catch (error) {
        console.log(error);
        res.sendStatus(500);   
    }
    
})

app.get("/userdetails", (req,res) =>{
    const userService = new UserService();
    const userModel = new UserModel();
    // console.log(userModel.setUserEmail('jkhan266work@gmail.com'));
    userModel.setUserEmail('jkhan266work@gmail.com');
    console.log(userService.getUserDetails(userModel));

    // res.send(userService.getUserDetails(userModel));

    res.send("WOrking");
})

app.post("/orders", (req,res)=>{
    try {
        console.log(req.body);
        console.log(req.headers);
        res.sendStatus(200);
    } catch (error) {
        console.log("Error Occured \n"+error);
        res.sendStatus(500);
    }
})

// starting the server
app.listen(5005, () => {
    console.log('listening on port 5005');
  });
