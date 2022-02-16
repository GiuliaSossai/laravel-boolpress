<template>
  <div>
        <Header />
        
        <router-view></router-view>

        <Footer />
  </div>
</template>

<script>

import Header from './components/partials/Header';
import Footer from './components/partials/Footer';
//import Posts from './components/Posts';

export default {
    name: "App",
    components: {
        Header,
        Footer,
        //Posts
    }
}
</script>

<style lang="scss">
  div {
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
  }

</style>