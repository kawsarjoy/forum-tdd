<template>
    
    <div>

        <div v-if="signedIn">
                
            <div class="form-group">

                <textarea name="body" 
                        id="body" 
                        rows="5" 
                        class="form-control" 
                        placeholder="Have somthing to say?" 
                        required 
                        v-model="body">
                </textarea>

            </div>

            <button class="btn btn-default" 
                    type="submit"
                    @click="addReply">Post</button>

        </div>

        <div v-else>

            <p class="text-center">Please <a href="/login">Sign in</a> to participate in this discussion.</p>

        </div>

    </div>

</template>


<script>

    export default {

        data(){
            return {
                body: '',
                //endpoint: ''
            }
        },

        computed: {

            signedIn(){

                return window.App.signedIn;
            }
        },

        methods: {

            addReply(){

                axios.post(location.pathname + '/replies', {body: this.body})

                     .catch(error => {

                         flash(error.response.data, 'danger');
                     })
                     .then(({data}) => {

                         this.body = '';

                         flash('Your reply has been posted!');

                         this.$emit('created', data)
                     });
            }
        }
    }

</script>
