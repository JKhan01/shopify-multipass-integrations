// Resolve the Dependancies

const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const helmet = require('helmet');
const morgan = require('morgan');
const userData = require("./multipass-helper/SampleCredentials");
const TokenGenerator  = require('./multipass-helper/TokenGenerator').TokenGenerator;


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

app.post("/login",(req,res)=>{
    try {
        console.log(req.body);
        urlGenObject = new TokenGenerator();
        url = urlGenObject.generateUrl();
        console.log(url);
        res.redirect(303,url);
        
    } catch (error) {
        console.log(error);
        res.sendStatus(500);   
    }
    
})


// starting the server
app.listen(5005, () => {
    console.log('listening on port 5005');
  });
