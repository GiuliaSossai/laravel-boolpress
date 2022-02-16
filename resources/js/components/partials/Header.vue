<template>
  <header>
       <nav>
           <div>
               <h2>blog dei blog</h2>
           </div>
           <ul>
               <li><router-link :to="{name: 'home'}">home</router-link></li>
               <li><router-link :to="{name: 'about'}">about</router-link></li>
               <li><router-link :to="{name: 'blog'}">blog</router-link></li>
               <li><router-link :to="{name: 'contacts'}">keep in contact</router-link></li>
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
        background-color: rgb(247, 247, 247);
        border-bottom: 2px solid rgb(230, 230, 230);
        padding: 30px 50px;
        text-align: center;
        position: fixed;
        width: 100%;
        nav {
            display: flex;
            justify-content: space-between;
            h2 {
                color: #95979b;
                text-transform: uppercase;
                letter-spacing: 3px;
            }
        }
        ul {
            list-style: none;
            li {
                display: inline-block;
                margin: 0 20px;
                a {
                    text-transform: uppercase;
                    text-decoration: none;
                    cursor: pointer;
                    color: rgb(123, 119, 112);
                    &:hover {
                        color: rgb(80, 52, 9);
                    }
                    &.router-link-exact-active {
                        //text-decoration: underline;
                        border-bottom: 2px solid #606264;
                    }
                }
            }
        }
    }

</style>