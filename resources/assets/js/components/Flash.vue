<template>
    <div class="alert alert-success alert-flash" 
        :class="'alert-'+lavel" 
        role="alert" 
        v-show="show" 
        v-text="body">
        
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data(){
            return {
                body: '',
                show: false,
                lavel: 'success',
            }
        },

        created(){
            if(this.message)
            {
                this.flash(this.message);
            }

            window.events.$on('flash', data =>  this.flash(data));
        },

        methods: {

            flash(data){
                this.body = data.message;
                this.lavel = data.lavel;
                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    };
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
