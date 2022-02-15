<template>
   <div>
      <div class="box cat">
         <p>Categorie:</p>
         <span
            v-for="category in categories"
            :key="`category${category.id}`"
         >{{ category.name }}</span>
         
      </div>

      <div class="box">
         <p>Tag:</p>
         <span
            v-for="tag in tags"
            :key="`tag${tag.id}`"
         >{{ tag.name }}</span>
      </div>
   </div>
</template>

<script>
export default {
   name: 'Sidebar',

   props: {
      'categories': Array,
      'tags': Array 
   }
}
</script>

<style lang="scss" scoped>
   .box, span {
      border: 1px solid grey;
      border-radius: 8px;
      padding: 8px;
   }
   .box {
      margin-bottom: 20px;
      background-color: rgb(235, 229, 229);
   }
   span {
      display: inline-block;
      background-color: rgb(236, 165, 165);
      margin: 8px;
      cursor: pointer;
      &:hover {
         background-color: rgb(248, 203, 203);
      }
   }
   .box.cat {
      span {
         background-color: rgb(250, 221, 56);
         &:hover {
         background-color: rgb(248, 236, 166);
         }
      }
   }
   

</style>