<template>
    <div class="item">
        <h3><router-link :to="{name: 'detail', params:{slug: post.slug}}">{{ post.title }}</router-link></h3>

        <div class="box">
            <p v-if="post.category" class="category">{{ post.category.name }}</p>
            <div>
                <span
                    v-for="(tag, index) in post.tags"
                    :key="`tag${index}`"
                >{{ tag.name }}</span>
            </div>

            <small>{{ getDateFormat() }}</small>
        </div>
        
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
        width: 80%;
        padding: 20px;
        //border: 1px solid rgb(123, 119, 112);
        margin-bottom: 30px;
        background-color: #f0efef;
        a {
            text-transform: uppercase;
            text-decoration: none;
            color: #4a4a4a;
            letter-spacing: 2px;
            &:hover {
                color: #777777;
            }
        }
        .box {
            margin: 10px 0;
            .category, small {
                color: #777777;
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
        
    }

</style>