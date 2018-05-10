<template>
  <div class="panel panel-default">
      <div class="panel-heading">Chats</div>

        <div class="panel-body">
            <table class="table">
                <tr v-for="(user,key) in contacts" :key="key">
                    <td @click="createChat(user)">{{user.name}}</td>
                </tr>
            </table>
        </div>
  </div>
</template>
<script>
import Router from '../router'
export default {
    data(){
        return{
            contacts: []
        }
        
    },
    
    created() {
        this.fetchContacts();
    },

    methods: {
        fetchContacts() {
            var vm=this
            axios.get('/api/user').then(response => {
                vm.contacts = response.data;
                console.log(response.data)
            });
        },
        createChat(user) {
            let data = {
                user2 : user.id
            }
            axios.post('/api/createChat',data).then(response => {
                localStorage.setItem(response.data,user.id)
                Router.push('/chat/'+response.data)
            })
        }
    }
}
</script>
