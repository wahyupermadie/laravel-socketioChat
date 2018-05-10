<template>
    <ul class="chat">
        <li class="left clearfix" v-for="(message,key) in messages" :key="key">
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font" v-if="message.flag == 'inbox'">
                        {{ message.name }}
                    </strong>
                    <strong class="primary-font" v-else>
                        {{ message.senderName }}
                    </strong>
                </div>
                <p>
                    {{ message.messages }}
                </p>
            </div>
        </li>
    </ul>
</template>

<script>
  export default {
    props: ['messages']
  };
</script>