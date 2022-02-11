<template>
    <div class="item">
        <h4>{{ post.title }}</h4>
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
    }

</style>