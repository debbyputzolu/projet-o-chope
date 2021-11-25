import axios from 'axios';

import storage from '../plugins/storage.js';

const recipeService = {

    baseURI: 'http://localhost/projet/projet-o-chope/back/public/wp-json/wp/v2',
    oChopeBaseURI: 'http://localhost/projet/projet-o-chope/back/public/wp-json/ochope/v1',

    async loadRecipes() {
      const response = await axios.get(recipeService.baseURI + '/recipe?_embed=true');
      return response.data;
  },

  async loadRecipesTypes() {
    const response = await axios.get(recipeService.baseURI + '/recipe-type');
    return response.data;
  },

  async loadRecipesIngredients() {
    const response = await axios.get(recipeService.baseURI + '/ingredient');
    return response.data;
  },

  async getRecipesByType(selectedType) {
    const response = await axios.get(recipeService.baseURI + '/recipe?_embed=true&recipe-type=' + selectedType);
    return response.data;
  },

  async getRecipeById(recipeId) {
    const response = await axios.get(recipeService.baseURI + '/recipe/' + recipeId + '?_embed=true');
    return response.data;
  },

  async getUserInfo (name) {
    const response = await axios.get(recipeService.baseURI + '/users/?slug=' + name);
    return response.data;
  },

  async getRecipeByAuthor(username) {
    this.infoUser = await recipeService.getUserInfo(username);
    const authorId = this.infoUser[0].id;
    const response = await axios.get(recipeService.baseURI + '/recipe?_embed=true&author=' + authorId);
    return response.data;
  },

  async loadTerms(taxonomy) {
    const response = await axios.get(recipeService.baseURI + '/' + taxonomy);
    return response.data;
  },

  async getRecipesByTerm(taxonomy, termId) {
    const response = await axios.get(recipeService.baseURI + '/recipe?_embed=true&' + taxonomy + '=' + termId);
    return response.data;
  },

  async getRecipesByTerms(filters) {

    let url = recipeService.baseURI + '/recipe?_embed=true';
    for(let taxonomy in filters) {
      let termId = filters[taxonomy];

      if(termId) {
        url += '&' + taxonomy + '=' + termId;
      }
    }

    const response = await axios.get(url);
    return response.data;
  },

  async getCommentByRecipe(recipeId) {
    const response = await axios.get(recipeService.baseURI + '/comments?post=' + recipeId);
    return response.data;
  },

  async saveRecipe(title, type, description, selectedDoses, imageId) {

    const userData = storage.get('userData');
    if(userData != null) {
      const token = userData.token;
      if(token) {

        const options = {
          headers: {
            Authorization: 'Bearer ' + token
          }
        };


        const result = await axios.post(
          recipeService.oChopeBaseURI + '/recipe-save',
          {
            title: title,
            type: type,
            description: description,
            doses: selectedDoses, //array
            imageId: imageId
          },
          options
        ).catch(function(error) {
          console.log(error);
          return false;
        });
        return result;
      }
    }
    return false;
  },

  async saveDose(recipeId, ingredientId, quantity, unit) {

    const userData = storage.get('userData');

    if(userData != null) {
      const token = userData.token;
      if(token) {

        const options = {
          headers: {
            Authorization: 'Bearer ' + token
          }
        };


        const result = await axios.post(
          recipeService.oChopeBaseURI + '/dose-save',
          {
            recipeId: recipeId,
            ingredientId: ingredientId,
            quantity: quantity,
            unit: unit
          },
          options
        ).catch(function(error) {
          console.log(error);
          return false;
        });

        return result;
      }
    }
    return false;
  },

  async uploadImage(image) {
    let formData = new FormData();

    formData.append("image", image);

    const userData = storage.get('userData');
    const token = userData.token;

    const result = await axios.post(
      recipeService.oChopeBaseURI + '/upload-image',
      formData,
      {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Authorization': 'Bearer ' + token
        }
      }
    );
   console.log(result.data);
    return result.data;
  },

  async saveComment(recipeId, comment) {

    const userData = storage.get('userData');

    if(userData != null) {
      const token = userData.token;
      if(token) {

        const options = {
          headers: {
            Authorization: 'Bearer ' + token
          }
        };


        const result = await axios.post(
          recipeService.oChopeBaseURI + '/comment-save',
          {
            recipeId: recipeId,
            comment: comment,
          },
          options
        ).catch(function(error) {
          console.log(error);
          return false;
        });

        return result;
      }
    }
    return false;
  }

};

export default recipeService;