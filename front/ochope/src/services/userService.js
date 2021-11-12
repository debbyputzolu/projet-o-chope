import axios from 'axios'
import storage from '../plugins/storage.js'

const userService = {

    baseURI:'http://localhost/valkyrie/apotheose/ochope/back/public/wp-json/jwt-auth/v1',
 
    baseOchope: 'http://localhost/valkyrie/apotheose/ochope/back/public/wp-json/ochope/v1',

    login: async function(login, password){
        // première utilisation de axios.post, il ne nous suffit plus de juste récupérer des données grace a notre api (axios.get), nous voulons ENVOYER des donnes vers notre api, j'utilise donc axios.post(ENDPOINT, DonnesAEnvoyer)
        // Pour etre plus précis, nous pouvons parler pour les données a envoyer de "corps de la requete"
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
        // je viens récupérer les infos sur le user grace a l'entrée "userData" dans mon localstorage
        const userData = storage.get('userData');
        // je récupère un object ! Je peux donc acceder au "tirroir" token en faisant monObjet.token
        // si userData n'est PAS EGAL a null (donc si il contient bien qqchose)
        if(userData != null){
            const token = userData.token;
            if(token){
                //console.log(token);
                // j'ai bien récupéré un token, je vais pouvoir faire la vérification ..
                
                // Attention, il ne me suffit PAS d'envoyer des données comme nous avons pu le faire dans la methode login (ci-dessus), il va falloir que j'envoi ce token au back en passant pas les en-têtes (headers) de ma requete ! 
                // Nous allons donc découvrir qu'il est possible de donner un 3eme argument a la methode post : 
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

                // console.log(response.data);
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
                //console.log(result);
            return result;
            
    },

    

};





export default userService;


