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
                <tr class = "ingredient-rows recipeCreateTable">
                    <td>
                        <select>
                        <option>
                            blé  
                        </option>
                      
                        </select>
                    </td>
                    <td>
                        <input type="number">
                    </td>
                    <td>
                        <select>
                            <option>L</option>
                            <option>g</option>
                            <option>unité</option>
                        </select>
                        <input type="button" id="add-row" name="add-row" value="+">
                    </td>
                </tr>
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


export default{
    name: 'RecipeCreate',
    data() {
        return {     
        title:'',
        description:'',
        types: [],
        ingredients: [],
        selectedTypes:null,
        selectedIngredients:[],
        image: null,
        imageId: null,
        titleEmpty: false,
        descriptionEmpty: false,
        ingredientEmpty: false,
        typeEmpty: false, 
        }
    },
    
     async created(){
      
      
      this.loadTypes();
  },
 methods: {  
    async handleSubmit(evt){
          evt.preventDefault();
          if(this.title == ''){
              console.log(' TITRE EST VIDE !!');
              this.titleEmpty = true;
          }
          if(this.stage == ''){
              console.log('ETAPE EST VIDE !!');
              this.stageEmpty = true;
          }
          if(this.selectedIngredients.length == 0){
              console.log('INGREDIENT EST VIDE !!');
              this.ingredientEmpty = true;
          }
          if(this.selectedTypes == null){
              console.log('TYPE EST VIDE !!');
              this.typeEmpty = true;
          }
         
        
          if(this.title != '' && 
          this.selectedTypes != null &&
          this.stage != '' &&
          this.selectedIngredients.length != 0
          ){
            const result = await recipeService.saveRecipe(
            this.title,
            this.selectedTypes,
            this.stage,
            this.selectedIngredients
            ); 
          
          
          if(result){
              this.$router.push('/');
          }
        }
      },    
      async uploadImage(evt){
        evt.preventDefault();
        
    this.picture = this.ref;
    console.log(this.picture);
        const imageData = HTMLInputElement.files;
        //console.log(imageData);
        if(imageData.length != 0){
         const result = await recipeService.uploadImage(
            this.imageData
            );  
            
            if(result){
                console.log('image ok');
            }
        }
      },

     async loadTypes(){
    this.types = await recipeService.loadRecipesTypes();
    }
 }    
   
}
</script>

<style>
</style>
