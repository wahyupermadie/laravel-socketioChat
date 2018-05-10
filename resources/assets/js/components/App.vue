<template>
  <div id="app">
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    data(){
        return{

        }
        
    },

    created() {
        this.getUserLogin();
    },

    methods: {
        getUserLogin() {
            axios.get('/api/getUser').then(response => {
                localStorage.setItem('user_id',response.data.id)
                localStorage.setItem('user_name',response.data.name)
                console.log(response.data)
                // this.messages = response.data;
            });
        },
    }
}
</script>

