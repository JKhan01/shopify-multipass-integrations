const UserDao = require("../dao/UserDao").UserDao;
class UserService{

    getUserDetails(userModel){
        
        const userDao = new UserDao();
        userDao.getUserDetails(userModel);
        let details = userDao.queryResult;
        console.log("Served Value "+ JSON.stringify(details));
        userDao.disconnectConnection();
        return details;
    }

    postUserDetails(userModel){
        const userDao = new UserDao();
        let details = userDao.postUserDetails(userModel);
        userDao.disconnectConnection();
        return details;
    }
}

exports.UserService = UserService;