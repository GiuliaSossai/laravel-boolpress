<template>
    <div class="item">
        <h4><router-link :to="{name: 'detail', params:{slug: post.slug}}">{{ post.title }}</router-link></h4>

        <p v-if="post.category" class="category">{{ post.category.name }}</p>
        <div>
            <span
                v-for="(tag, index) in post.tags"
                :key="`tag${index}`"
            >{{ tag.name }}</span>
        </div>

        <small>{{ getDateFormat() }}</small>
        <p>{{ getExtract() }}</p>
    </div>
</template>

<script>
export default {
    name: 'Post',

    props: {
        'post': Object
    },

    methods: {
        getExtract(){
            return this.post.content.substr(0,50) + '..';
        },

        getDateFormat(){
            const d = new Date;
            let day = d.getDate();
            let month = d.getMonth() + 1;
            let year = d.getFullYear();

            return `${year} - ${month} - ${day}`;
        }
    }
}
</script>

<style lang="scss" scoped>
    .item {
        padding: 20px 0;
        a {
            text-decoration: none;
            color: black;
            &:hover {
                color: brown;
            }
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