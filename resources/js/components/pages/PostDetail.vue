<template>
   <div class="container">
      <h2>{{ post.title }}</h2>
      <p v-if="post.category" class="category">{{ post.category.name }}</p>
      <div>
         <span v-for="(tag, index) in post.tags"
            :key="`tag${index}`"
         >{{ tag.name }}</span>
      </div>
      <p>{{ post.content }}</p>
   </div>
</template>

<script>
export default {
   name: 'PostDetail',

   data(){
      return{
         apiUrl: 'http://127.0.0.1:8000/api/posts/',
         post: {
            title: '',
            content:'',
            category: {},
            tags: []
         }
      }
   },

   methods: {
      getApi(){
         axios.get(this.apiUrl + this.$route.params.slug)
            .then(res => {
               this.post = res.data;
               console.log(this.post);
            })
      }
   },

   mounted(){
      console.log(this.$route.params.slug);
      this.getApi();
   }
}
</script>

<style lang="scss" scoped>
   .container {
      width: 70%;
      margin: 0 auto;
      h2{
         margin: 20px 0;
      }
      .category {
            margin: 5px 0;
            color: rgb(107, 105, 105);
      }
      span {
         margin-right: 10px;
         display: inline-block;
         padding: 4px 8px;
         font-size: 10px;
         background-color: rgb(176, 242, 245);
         border-radius: 5px;
      }
   }

</style>