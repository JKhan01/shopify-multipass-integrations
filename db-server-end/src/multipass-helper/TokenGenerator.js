

const userData = require("./SampleCredentials");
const Multipass = require("multipass-js").Multipass;
const credentials = require("../SensitiveCred").credentials;

class TokenGenerator{


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
  