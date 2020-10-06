<template>
    <form action="" @submit="createTransaction(transaction)">
        <h4 class="text-center font-weight-bold">Post creation form</h4>
        <div class="form-group">
            <input type="text" placeholder="Post title" v-model="transaction.id" class="form-control">

        </div>
        <div class="form-group">
                <textarea v-model="transaction.id" placeholder="Post content" class="form-control">

                </textarea>
        </div>
        <div class="form-group">
            <button :disabled="!isValid" class="btn btn-block btn-primary" @click.prevent="createTransaction(transaction)">Submit
            </button>
        </div>
    </form>
</template>

<script>
export default {
    name: "CreateTransaction",
    data() {
        return {
            post: {
                title: '',
                content: ''
            }
        }
    },
    methods: {
        createPost(post) {
            this.$store.dispatch('createTransaction', post)
        }
    },
    computed: {
        isValid() {
            return this.transaction.title !== '' && this.transaction.content !== ''
        }
    }
}
</script>

<style scoped>

</style>
