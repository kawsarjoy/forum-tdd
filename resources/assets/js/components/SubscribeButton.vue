<template>
    
    <button :class="classes" @click="subscribe" v-text="subscribeText"></button>

</template>


<script>
export default {

    props: ['active'],

    data(){

        return {

            isActive: this.active,
        }
    },

    computed: {

        classes(){

            return ['btn', this.isActive ? 'btn-danger' : 'btn-success'];
        },

        subscribeText(){

            return this.isActive ? 'Unsubscribe' : 'Subscribe';
        }
    },
    
    methods: {

        subscribe(){

            let requestType = this.isActive ? 'delete' : 'post';

            axios[requestType](location.pathname + '/subscriptions');

            this.isActive = ! this.isActive;

        }
    }

}
</script>
