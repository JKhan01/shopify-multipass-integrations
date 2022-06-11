// var UserModel = /** @class */ (function () {
//     function UserModel() {
//     }
//     UserModel.prototype.setUserEmail = function (email) {
//         this.userEmail = email;
//     };
//     UserModel.prototype.setUserPassword = function (password) {
//         this.userPassword = password;
//     };
//     UserModel.prototype.setUserAddress = function (address) {
//         this.userAddress = address;
//     };
//     UserModel.prototype.getUserEmail = function () {
//         return this.userEmail;
//     };
//     UserModel.prototype.getUserPassword = function () {
//         return this.userPassword;
//     };
//     UserModel.prototype.getUserAddress = function () {
//         return this.userAddress;
//     };
//     return UserModel;
// }());

class UserModel{
    userEmail;
    userPassword;
    userAddress;
    userCity;
    userZip;
    userProvince;
    userCountry;
    userFirstName;
    userLastName;
    userPhoneNumber;
    
    constructor(){}

    getUserPhoneNumber(){
        return this.userPhoneNumber;
    }
    getUserFirstName(){
        return this.userFirstName;
    }

    getUserLastName(){
        return this.userLastName;
    }

    getUserEmail(){
        return this.userEmail;
    }
    getUserAddress(){
        return this.userAddress;
    }    
    getUserPassword(){
        return this.userPassword;
    }

    getUserCity(){
        return this.userCity;
    }

    getUserZip(){
        return this.userZip;
    }
    getUserProvince(){
        return this.userProvince;
    }
    
    getUserCountry(){
        return this.userCountry;
    }

    setUserEmail(email){
        this.userEmail = email;
    }

    setUserPassword(password){
        this.userPassword = password;
    }

    setUserAddress(address){
        this.userAddress = address;
    }
    
    setUserCity(city){
        this.userCity = city;
    }

    setUserZip(zip){
        this.userZip = zip;
    }
    setUserProvince(province){
        this.userProvince = province;
    }

    setUserCountry(country){
        this.userCountry = country;
    }

    setUserFirstName(firstName){
        this.userFirstName = firstName;
    }

    setUserLastName(lastName){
        this.userLastName = lastName;
    }

    setUserPhoneNumber(phone){
        this.userPhoneNumber = phone;
    }


}

exports.UserModel = UserModel;