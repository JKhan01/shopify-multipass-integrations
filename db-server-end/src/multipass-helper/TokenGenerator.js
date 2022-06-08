

let userData = require("./SampleCredentials");
const Multipass = require("multipass-js").Multipass;
const credentials = require("../SensitiveCred").credentials;

class TokenGenerator{


    // constructor(){}

    constructor(userDetails){
        
        userData.SampleCredentials.email=userDetails.getUserEmail();
        userData.SampleCredentials.first_name = userDetails.getUserFirstName();
        userData.SampleCredentials.last_name = userDetails.getUserLastName();
        userData.SampleCredentials.addresses[0].address1 = userDetails.getUserAddress();
        userData.SampleCredentials.addresses[0].city = userDetails.getUserCity();
        userData.SampleCredentials.addresses[0].zip = userDetails.getUserZip();
        userData.SampleCredentials.addresses[0].province = userDetails.getUserProvince();
        userData.SampleCredentials.addresses[0].country = userDetails.getUserCountry();
        userData.SampleCredentials.addresses[0].first_name = userDetails.getUserFirstName();
        userData.SampleCredentials.addresses[0].last_name = userDetails.getUserLastName();
        userData.SampleCredentials.addresses[0].phone = userDetails.getUserPhoneNumber();
    }

    generateUrl(){
        const multipass = new Multipass(credentials.SHOPIFY_MULTIPASS_TOKEN);
        const url = multipass
        .withCustomerData(userData.SampleCredentials)
        .withDomain(credentials.SHOPIFY_STORE_URL)
        .url();

        return url;
    }


}

exports.TokenGenerator = TokenGenerator;
  