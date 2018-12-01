<style lang="scss">

</style>

<template>
    <form action="/article/delete" method="POST">
        <input type="hidden" name="article_id" v-model="articleId">
    </form>
</template>

<script>

    import articlesAPI from '../api/articles';

    export default {

        created() {
            this.$bus.$on('delete-article', (payload) => {
                this.articleId = payload;
                this.submit();
            });
        },

        data() {
            return {
                articleId: null
            }
        },

        methods: {
            submit() {
                articlesAPI.deleteArticle({ 'article_id': this.articleId }, (response) => {
                    if (response.status === 'OK') {
                        window.location.reload();
                    }
                });
            }
        }
    }
</script>