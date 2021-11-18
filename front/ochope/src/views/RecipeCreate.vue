<template>

    <section class="recipeCreate">
        <img src="../assets/images/recipecreate.png" class="recipeCreateImage">
        <h1 class="recipeCreateTitle">Nouvelle recette</h1>
        <form @submit="handleSubmit" class="recipeCreateForm">

            <div class="recipeCreateLabel">
                <label>
                    Titre de la recette <br><input v-model="title"/>
                </label>
            </div>
             <div class="error" v-if="titleEmpty">
                Vous devez saisir un titre
            </div>


            <div class="recipeCreateLabel">
                <label>
                    Image d'illustration <br><input type="file" @change="uploadImage"/>
                    <img v-if="image" :src="image"/>
                    <input v-model="imageId" type="hidden"/>
                </label>
            </div>


            <div class="recipeCreateLabel">Type de recette<br>
                <div v-for="type in types" :key="type.id">
                        <div>
                    <input type="radio" name="type" :value="type.id" v-model="selectedTypes" > {{type.name}}
                        </div>
                </div>
            </div>
            <div class="error" v-if="typeEmpty">
                Vous devez sélectionner un type de recette
            </div>


            <div class="recipeCreateLabel">
                <label>
                    Description <br> <textarea v-model="description"></textarea>
                </label>
            </div>
             <div class="error" v-if="descriptionEmpty">
                Vous devez saisir une description
            </div>

            <label class="recipeCreateLabel">Ingrédients</label>
            <div class="divIngredient">
                <center><table id="array" > 
                <tr class="recipeCreateTable">
                    <td>Nom</td><td>Quantité</td><td>Unité</td>
                </tr>
                
                <tr class = "ingredient-rows recipeCreateTable" v-for="(ingredientData, index) in selectedDoses" :key="index">
                    <td>
                        <select v-model="ingredientData.ingredient">
                        <option v-for="ingredientFound in ingredients" :key="ingredientFound.id" :value="ingredientFound.id" >{{ingredientFound.name}}</option>
                      
                        </select>
                    </td>
                    <td>
                        <input type="number" v-model="ingredientData.quantity">
                    </td>
                    <td>
                        <select v-model="ingredientData.unit">
                            <option value="0">L</option>
                            <option value="1">g</option>
                            <option value="2">unité</option>
                        </select> 
                    </td>
                 </tr>   
                    <td>
                      <input type="button" id="add-row" name="add-row" value="Ajouter un ingrédient" @click="handleClick">  
                    </td>
                
            </table></center>
            </div>
             <div class="error" v-if="ingredientEmpty">
                Vous devez sélectionner un ou des ingredient(s)
            </div>

            <div>
                <button class="recipeCreateButton">Enregistrer</button>
            </div>



        </form>

    </section>

</template>

<script>
import recipeService from '../services/recipeService.js';
import userService from '../services/userService.js';


export default{
    name: 'RecipeCreate',
    data() {
        return {     
        title:'',
        description:'',
        types: [],
        ingredients: [],
        selectedTypes:null,
        selectedDoses:[{
            ingredient: 0,
            quantity: 0,
            unit: 0
        }],
        image: null,
        imageId: null,
        titleEmpty: false,
        descriptionEmpty: false,
        ingredientEmpty: false,
        typeEmpty: false, 
        isUserConnected: false
        }
    },
    
     async created(){
        const isTokenValid = await userService.isConnected();
        if(!isTokenValid) {
            this.$router.push('login');
        }
        else {
            this.isUserConnected = true;
        }

    this.loadIngredients();
      
    this.loadTypes();
  },
 methods: {  
    async handleSubmit(evt){
          evt.preventDefault();
          if(this.title == ''){
              console.log(' TITRE EST VIDE !!');
              this.titleEmpty = true;
          }
          if(this.description == ''){
              console.log('ETAPE EST VIDE !!');
              this.descriptionEmpty = true;
          }
          if(this.selectedDoses.length == 0){
              console.log('INGREDIENT EST VIDE !!');
              this.ingredientEmpty = true;
          }
          if(this.selectedTypes == null){
              console.log('TYPE EST VIDE !!');
              this.typeEmpty = true;
          }
         
        
          if(this.title != '' && 
          this.selectedTypes != null &&
          this.description != '' &&
          this.selectedDoses.length != 0
          ){
            const result = await recipeService.saveRecipe(
            this.title,
            this.selectedTypes,
            this.description,
            this.selectedDoses,
            this.imageId
            ); 
         // console.log(this.title,this.selectedTypes,this.description,this.selectedDoses);
          
          if(result){
              this.$router.push('/');
          }
          //console.log(result);
        }
      },    
      async uploadImage(evt){
        evt.preventDefault();
        
       // const imageData = HTMLInputElement.files;
       const imageData = evt.target.files[0] ;
       //console.log('On est coté front dans upladImage');
        //console.log(imageData);
        if(imageData.length != 0){
         const result = await recipeService.uploadImage(imageData);  
            
            if(result){
                console.log('image ok');
                //console.log('result : ');
                //console.log(result);
                this.image = result.image.url;
                this.imageId= result.image.id;
            }
        }
      },

     async loadTypes(){
    this.types = await recipeService.loadRecipesTypes();
    },

    async loadIngredients() {
            this.ingredients = await recipeService.loadRecipesIngredients();
            this.selectedDoses[0].ingredient = this.ingredients[0].id;
        },
    
    handleClick(evt){
        evt.preventDefault();
        
        // const row = document.querySelector(".ingredient-rows"); //premier enfant
        // const addRow = row.cloneNode(true); //a insérer
        // const arrayIngredient = document.querySelector('#array'); //parent
        this.selectedDoses.push({
            ingredient: 0,
            quantity: 0,
            unit: 0
        });
        // arrayIngredient.insertBefore(addRow, row);
        
    }
 }    
   
}
</script>

<style>
</style>
