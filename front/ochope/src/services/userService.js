import axios from 'axios'
import storage from '../plugins/storage.js'

const userService = {

    baseURI:'http://localhost/valkyrie/apotheose/ochope/back/public/wp-json/jwt-auth/v1',
 
    baseOchope: 'http://localhost/valkyrie/apotheose/ochope/back/public/wp-json/ochope/v1',

    login: async function(login, password){
        // first use of axios.post, it is not enough for us to just recover data thanks to our API (axios.get), we want to SEND data to our api, so I am using axios.post(ENDPOINT, DonnesAEnvoyer)
        // To be more precise, we can speak for the data to be sent of "body of the request"
        let response = await axios.post(
            userService.baseURI + '/token',
            {
                username: login,
                password: password
            }
            ).catch(
                function(){
                    return false;
                }
            );
            
        return response.data;
        
    },

    isConnected: async function(){
        // I come to retrieve the information on the user thanks to the entry "userData" in my localstorage
        const userData = storage.get('userData');
        // I get an object! I can therefore access the token "drawer" by entering myObjet.token
        // if userData is NOT EQUAL to null (so if it does contain something)
        if(userData != null){
            const token = userData.token;
            if(token){
                // I have recovered a token, I will be able to verify ..
                
                // Attention, it is NOT enough for me to send data as we were able to do in the login method (above), I will have to send this token to the back without passing the headers of my request!
                // We are therefore going to discover that it is possible to give a 3rd argument to the post method : 
                // axios.post(Endpoint, DonnesRequete, Options)
                const options = {
                    headers: {
                        Authorization: 'Bearer ' + token
                    }
                };

                //
                const response = await axios.post(
                    userService.baseURI + '/token/validate', 
                    null, 
                    options).catch(
                        function(){
                            return false;
                        }
                    );

                return response.data;
                
            }
 
        }

    },

    logout: function(){
        storage.unset('userData');
    },

    async inscription(username, email, password){
        
        console.log('requete axios');
        const result = await axios.post(
                    userService.baseOchope + '/inscription',
                    {
                        username: username,
                        //lastname: lastname,
                        //firstname: firstname,
                        email: email,
                        password: password
                    } 
                ) 
                .catch(function(){
                    return false;
                })

            return result;
            
    },   

};


export default userService;
