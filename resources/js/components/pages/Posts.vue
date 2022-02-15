<template>
    <main>
        <div class="content">
            <h3>i miei post:</h3>

            <div v-if="posts">
                <PostItem 
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
                />

                <div class="navigation">
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

        <Sidebar 
            :tags ="tags"
            :categories ="categories"
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
            apiUrl: 'http://127.0.0.1:8000/api/posts?page=',
            posts: null,
            pagination: {},
            categories: [],
            tags: []
        }
    },
    
    mounted(){
        this.getPosts();
    },

    methods: {
        getPosts(page = 1){
            this.posts = null;
           axios.get(this.apiUrl + page)
            .then(res => {
                //dopo aver modificato il controller, res.data contiene categories e tags oltre all'array dei post
                this.posts = res.data.posts.data;
                this.categories = res.data.categories;
                this.tags = res.data.tags;

                this.pagination = {
                    current: res.data.current_page,
                    last: res.data.last_page
                }
                console.log(this.pagination);
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