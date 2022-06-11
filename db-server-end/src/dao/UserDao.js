
var mysql      = require('mysql');

const tableName = "user_details";
const columnName01 = "user_email";
const columnName02 = "user_password";
class UserDao{
    connection = null;
    queryResult = {};
    constructor(){

        // this.connection = mysql.createConnection({
        // host     : 'localhost',
        // port: 3306,
        // user     : 'root',
        // password : 'root',
        // database : 'shopify_multipass'
        // });

        // this.connection.connect(function(err) {
        // if (err) {
        //     console.error('error connecting: ' + err.stack);
        //     return;
        // }

        // console.log('connected ');
        // });

    }


    getUserDetails(userModel){
        
        const columnValue = userModel.getUserEmail();
        const queryString = `select * from ${tableName} where ${columnName01}='${columnValue}' and ${columnName02} = '${userModel.getUserPassword()}'`;
        // let queryResult = [];
        console.log(queryString);
        this.connection.query(queryString,
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
            return this.getDetailsCallback(results[0]);
        }
        );

        // console.log(queryResult);
        // return this.queryResult;
    }

    async getDetailsCallback(result){
        console.log("Called");
        this.queryResult = await result;
    }

    postUserDetails(userModel,connection){
        const queryString = `insert into ${tableName} values('${userModel.getUserEmail()}',
                            '${userModel.getUserPassword()}','${userModel.getUserFirstName()}','${userModel.getUserLastName()}',
                            '${userModel.getUserAddress()}', '${userModel.getUserCity()}','${userModel.getUserProvince()}',
                            '${userModel.getUserCountry()}','${userModel.getUserZip()}','${userModel.getUserPhoneNumber()}'
                            );`;

        console.log(queryString);

        let queryStatus = false;
        let checkFlag = true;
        connection.query(`select * from ${tableName} where ${columnName01} = '${userModel.getUserEmail()}'`,
        (error,results)=>{
            if (error){
                console.log("Error Occured!\n"+error);
                return; 
            }
            if (results){
                checkFlag = false;
            }
        }
        )
        if (checkFlag){
            connection.query(queryString,(error,results)=>{
                if (error){
                    console.log("Error Occured!\n"+error);
                    return;
                    
                }
                    console.log("Inserted Successfully!");
                    queryStatus = true;
            });
        }
        


        return [checkFlag,queryStatus];
    }

    disconnectConnection(){
        this.connection.end(function(err) {
        // The connection is terminated now
            console.log("DB Connection Terminated");
        });
    }

}

exports.UserDao = UserDao;