<template>
   <div class="panel panel-default">
      <div class="panel-heading">Chats</div>

        <div class="panel-body">
            <chat-messages :messages="messages"></chat-messages>
        </div>
        <div class="panel-footer">
                <div class="input-group">
                    <input id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="addMessage">

                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat" @click="addMessage">
                            Send
                        </button>
                    </span>
                </div>
        </div>
  </div>
</template>
<script>
    import ChatMessages from './ChatMessages.vue'
    export default {
        components:{
            'chat-messages':ChatMessages
        },
        data(){
            return{
                newMessage:'',
                messages: [],
                user:{}
            }
            
        },
        sockets: {
            connect: function(){
                console.log('socket connected')
            },
            // Fired when the server sends something on the "messageChannel" channel.
            chatMessage: function(val){
                this.messages.push(val)
                console.log('this method was fired by the socket server. eg: io.emit("customEmit", data)')
            }
        },
        created() {
            this.fetchMessages();
        },

        methods: {
            fetchMessages() {
                // console.log(this.messages)
                let chat_id = {
                    sender : localStorage.getItem(this.$route.params.id),
                    chat_id : this.$route.params.id
                }
                axios.post('/api/getMessages',chat_id).then(response => {
                    // console.log(response.data.name)
                    this.messages = response.data;
                });
            },

            addMessage() {
                let message = {
                    messages : this.newMessage,
                    chat_id: this.$route.params.id,
                    user2 : localStorage.getItem(this.$route.params.id),
                    name : localStorage.getItem('user_name'),
                    senderName : localStorage.getItem('user_name')
                }
                this.$socket.emit('chatMessage', message)
                axios.post('/api/messages', message).then(response => {
                    this.newMessage = ''
                });
                this.messages.push(message);
            }
        }
    }
</script>
