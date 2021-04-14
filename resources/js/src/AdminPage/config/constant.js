export default {
  webBaseURL: process.env.MIX_APP_URL,
  
  auth0Config: {
    domain: '',
    clientID: '',
    // make sure this line is contains the port: 8080
    redirectUri: 'http://localhost:8080/callback',
    // we will use the api/v2/ to access the user information as payload
    audience: '',
    responseType: 'token id_token',
    scope: 'openid profile'
  }
}
