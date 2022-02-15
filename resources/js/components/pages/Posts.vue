<template>
    <main>
        <div class="content">
            <div v-if="success">
                <h3>{{ title }}</h3>

                <div v-if="posts">
                    <PostItem 
                        v-for="post in posts"
                        :key="post.id"
                        :post="post"
                    />

                    <div class="navigation" v-if="globalPosts">
                        <button 
                            @click="getPosts(pagination.current - 1)"
                            :disabled="pagination.current === 1"
                        >prev</button>
                        <button
                            v-for="iteration in pagination.last"
                            :key="iteration"
                            @click="getPosts(iteration)"
                            :disabled="pagination.current === iteration"
                        >{{ iteration }}</button>
                        <button 
                            @click="getPosts(pagination.current + 1)"
                            :disabled="pagination.current === pagination.last"
                        >next</button>
                    </div>
                </div>

                <div v-else>
                    <h3>Loading...</h3>
                </div>
            </div>

            <div v-else>
                <h2>{{ error_msg }}</h2>
            </div>
            
        </div>

        <Sidebar 
            :tags ="tags"
            :categories ="categories"
            @getPostCategory="getPostCategory"
            @getPostTag="getPostTag"
            @getAllPosts="getPosts"
        />

    </main>
</template>

<script>
import PostItem from '../partials/PostItem';
import Sidebar from '../partials/Sidebar.vue';

export default {
    name: 'Posts',

    components: {
        PostItem,
        Sidebar
    },
    
    data(){
        return {
            //dopo la paginazione bisogna correggere la url per fare la query
            apiUrl: 'http://127.0.0.1:8000/api/posts',
            posts: null,
            pagination: {},
            categories: [],
            tags: [],
            success: true,
            error_msg: '',
            title: 'I miei post',
            globalPosts: true
        }
    },
    
    mounted(){
        this.getPosts();
    },

    methods: {
        reset(){
            this.erorr_msg = '';
            this.success = true;
            this.posts = null;
            this.title = 'I miei post';
            this.globalPosts = true;
        },

        getPosts(page = 1){
            this.reset();
            axios.get(this.apiUrl + '?page=' + page)
            .then(res => {
                //dopo aver modificato il controller, res.data contiene categories e tags oltre all'array dei post
                this.posts = res.data.posts.data;
                this.categories = res.data.categories;
                this.tags = res.data.tags;

                this.pagination = {
                    current: res.data.posts.current_page,
                    last: res.data.posts.last_page
                }
                console.log(this.pagination);
            })
        },

        getPostCategory(slug_category){
            this.reset();
            this.globalPosts = false;
            axios.get(this.apiUrl + '/postcategory/' + slug_category)
            .then( res => {
                console.log(res.data.category.posts);
                this.posts = res.data.category.posts;
                this.title = "I miei post per la categoria: " + res.data.category.name;
                if(!res.data.success){
                    this.error_msg = res.data.error;
                    this.success = false;
                }
            })
        },

        getPostTag(slug_tag){
            this.reset();
            this.globalPosts = false;
            axios.get(this.apiUrl + '/posttag/' + slug_tag)
            .then( res => {
                this.posts = res.data.tag.posts;
                this.title = "I miei post per il tag: " + res.data.tag.name;
                if(!res.data.success){
                    this.error_msg = res.data.error;
                    this.success = false;
                }
            })
        }
    }
}
</script>

<style lang="scss" scoped>
    main{
        width: 80%;
        margin: 0 auto;
        display: flex;
        padding: 30px;
        .content {
            margin-bottom: 100px;
            width: 70%;
            h3 {
            margin-bottom: 30px;
            }
            button {
                padding: 10px;
                margin-right: 10px;
            }
        }
        
    }

</style>