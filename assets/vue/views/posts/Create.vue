<template>
    <div>
        <div class="row col">
            <h1>Posts</h1>
        </div>
        <div class="row col">
            <form>
                <div class="form-row">
                    <div class="col-8">
                        <input type="text" name="title" id="title" v-model="title" class="form-control">
                        <input type="text" name="message" id="message" v-model="message" class="form-control">
                    </div>
                    <div class="col-4">
                        <button @click="createPost()" :disabled="message.length === 0 || isLoading" type="button" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <div v-if="isLoading" class="row col">
            <p>Loading...</p>
        </div>

        <div v-else-if="hasError" class="row col">
            <error-message :error="error"></error-message>
        </div>

        <div v-else-if="!hasPosts" class="row col">
            No posts!
        </div>

        <div v-else v-for="post in posts" :key="post.id" class="row col">
            <post :title="post.title" :message="post.message"></post>
        </div>
    </div>
</template>

<script>
    import Post from '../../components/Post';
    import ErrorMessage from '../../components/ErrorMessage';

    export default {
        name: 'posts',
        components: {
            Post,
            ErrorMessage,
        },
        data () {
            return {
                title: '',
                message: '',
            };
        },
        created () {
            this.$store.dispatch('fetchPosts');
        },
        computed: {
            isLoading () {
                return this.$store.getters['isLoading'];
            },
            hasError () {
                return this.$store.getters['hasError'];
            },
            error () {
                return this.$store.getters['error'];
            },
            hasPosts () {
                return this.$store.getters['hasPosts'];
            },
            posts () {
                return this.$store.getters['posts'];
            },
        },
        methods: {
            createPost () {
                let payload = {title: this.$data.title, message: this.$data.message};
                
                this.$store.dispatch('createPost', payload)
                    .then(() => this.$data.title = '', this.$data.message = '')
            },
        },
    }
</script>
