<template>
  <header>
       <nav>
           <ul>
               <li><router-link :to="{name: 'home'}">home</router-link></li>
               <li><router-link :to="{name: 'blog'}">blog</router-link></li>
               <li><router-link :to="{name: 'about'}">about</router-link></li>
               <li><router-link :to="{name: 'contacts'}">contacts</router-link></li>
           </ul>
        </nav> 
  </header>
</template>

<script>
export default {
    name: 'Header'
}
</script>

<style lang="scss" scoped>
    header {
        background-color: rgb(253, 199, 117);
        padding: 30px 0;
        text-align: center;
        ul {
            list-style: none;
            li {
                display: inline-block;
                margin: 0 20px;
                a {
                    text-transform: uppercase;
                    font-weight: 800;
                    text-decoration: none;
                    cursor: pointer;
                    color: rgb(123, 119, 112);
                    &:hover {
                        color: rgb(80, 52, 9);
                    }
                    &.active {
                        color: rgb(11, 88, 7);
                    }
                }
            }
        }
    }

</style>