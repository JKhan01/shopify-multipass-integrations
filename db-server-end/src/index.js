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

const REACT_SERVER_URL = require("./SensitiveCred").REACT_SERVER_URL;
const PROXY_MAPPER_NAME = require("./SensitiveCred").PROXY_MAPPER_NAME;
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

            res.redirect(303,PROXY_MAPPER_NAME+"/generate/"+JSON.stringify(results));
            
        }
        );


    } catch (error) {
        console.log(error);
        res.sendStatus(500);   
    }
    
})

app.get("/generate/:value",(req,res)=>{
    console.log("Value: "+req.params.value);
    if (JSON.parse(req.params.value).length != 0){
        let fetchedData = JSON.parse(req.params.value)[0];
        let userModel = new UserModel();
    
        userModel.setUserEmail(fetchedData.user_email);
        userModel.setUserFirstName(fetchedData.first_name);
        userModel.setUserLastName(fetchedData.last_name);
    
        userModel.setUserAddress(fetchedData.address_line1);
        userModel.setUserCity(fetchedData.address_city);
        userModel.setUserProvince(fetchedData.address_province);
        userModel.setUserCountry(fetchedData.address_country);
        userModel.setUserZip(fetchedData.address_zip);
        console.log(userModel.getUserAddress());
    
        urlGenObject = new TokenGenerator(userModel);
        url = urlGenObject.generateUrl();
        console.log(url);
        res.redirect(303,`${REACT_SERVER_URL}/?url=${url}`);
    }else{
        res.redirect(303,`${REACT_SERVER_URL}/login?error=invalid`);
    }

    
    
    // res.send("Success");

})

app.post("/signup",(req,res)=>{
    try {
        let userModel = new UserModel();
        userModel.setUserAddress(req.body.address_line1);
        userModel.setUserCity(req.body.address_city);
        userModel.setUserCountry(req.body.address_country);
        userModel.setUserEmail(req.body.email);
        userModel.setUserFirstName(req.body.first_name);
        userModel.setUserLastName(req.body.last_name);
        userModel.setUserPassword(req.body.password);
        userModel.setUserPhoneNumber(req.body.phone_number);

        userModel.setUserProvince(req.body.address_province);
        userModel.setUserZip(req.body.address_zip);

        connection.query(`select * from ${tableName} where ${columnName01} = '${userModel.getUserEmail()}'`,
        (error,results)=>{
            if (error){
                console.log("Error Occured!\n"+error);
                res.sendStatus(500); 
            }
            if (results.length != 0){
                res.redirect(303,`${REACT_SERVER_URL}/signup?error=exists`);
            }else{
                const queryString = `insert into ${tableName} values('${userModel.getUserEmail()}',
                            '${userModel.getUserPassword()}','${userModel.getUserFirstName()}','${userModel.getUserLastName()}',
                            '${userModel.getUserAddress()}', '${userModel.getUserCity()}','${userModel.getUserProvince()}',
                            '${userModel.getUserCountry()}','${userModel.getUserZip()}','${userModel.getUserPhoneNumber()}'
                            );`;

                res.redirect(303,PROXY_MAPPER_NAME+"/create/"+queryString);
            }
        }
        );


    } catch (error) {
        console.log("Error Occured \n"+error);
        res.sendStatus(500); 
    }
})

app.get("/create/:queryString",(req,res)=>{
    try {
        let queryString = req.params.queryString;
        console.log(queryString);
        connection.query(queryString,(error,results)=>{
            if (error){
                console.log("Error Occured!\n"+error);
                res.redirect(303,`${REACT_SERVER_URL}/signup?error=query`);
                
            }
                console.log("Inserted Successfully! Redirect to :" + `${REACT_SERVER_URL}/login?created=true`);
                res.redirect(303, `${REACT_SERVER_URL}/login?created=true`);
        });
    } catch (error) {
        console.log("Error Occured \n"+error);
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

app.post("/checkout", (req,res)=>{
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
