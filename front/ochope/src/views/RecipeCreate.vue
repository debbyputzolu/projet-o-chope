<template>

    <section class="recipeCreate">
        <h1 class="recipeCreateTitle">Nouvelle recette</h1>
        <form @submit="saveRecipe" class="recipeCreateForm">

            <div>
                <label>
                    Titre de la recette <input v-model="title"/>
                </label>
            </div>


            <div>
                <label>
                    Image d'illustration <input type="file" @change="uploadImage"/>
                    <img v-if="image" :src="image"/>
                    <input v-model="imageId" type="hidden"/>
                </label>
            </div>


            <div>
                <div >
                    <label> Type de recette
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


            <div>
                <label>
                    Description <textarea v-model="description"></textarea>
                </label>
            </div>


            <div>
                <table id="array"> Ingrédients
                <tr>
                    <td>Nom</td><td>Quantité</td><td>Unité</td>
                </tr>
                <tr class = "ingredient-rows">
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
                    </td>
                </tr>
            </table>
            
            <table>
                <tr>
                    <td>
                        <input type="button" id="add-row" name="add-row" value="+">
                    </td>
                </tr>
            </table>
            </div>

            <div>
                <button>Enregistrer</button>
            </div>



        </form>

    </section>

</template>

<script>

export default{
    name: 'RecipeCreate',
   
    
   
}
</script>

<style>
</style>
