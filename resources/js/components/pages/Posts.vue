<template>
    <main>
        <h3>Lista post</h3>

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
        

    </main>
</template>

<script>
import PostItem from '../partials/PostItem';

export default {
    name: 'Posts',

    components: {
        PostItem,
    },
    
    data(){
        return {
            //dopo la paginazione bisogna correggere la url per fare la query
            apiUrl: 'http://127.0.0.1:8000/api/posts?page=',
            posts: null,
            pagination: {}
        }
    },
    
    mounted(){
        this.getPosts();
    },

    methods: {
        getPosts(page = 1){
           axios.get(this.apiUrl + page)
            .then(res => {
                this.posts = res.data.data;
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
        padding: 30px;
        h3 {
            margin-bottom: 30px;
        }
        button {
            padding: 10px;
            margin-right: 10px;
        }
    }

</style>