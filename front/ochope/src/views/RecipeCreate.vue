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


            <div class="recipeCreateLabel">
                <div >
                    <label> Type de recette<br>
                        <div>
  <input type="radio" id="huey" name="drone" value="huey"
         checked>
  <label for="huey">Ambré</label>
</div>

<div>
  <input type="radio" id="dewey" name="drone" value="dewey">
  <label for="dewey">Blonde</label>
</div>

<div>
  <input type="radio" id="louie" name="drone" value="louie">
  <label for="louie">Brune</label>
</div>
                    </label>
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
        picture:[],
        titleEmpty: false,
        descriptionEmpty: false,
        ingredientEmpty: false,
        typeEmpty: false, 
        }
    },
    
    
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
      }
    
   
}
</script>

<style>
</style>
