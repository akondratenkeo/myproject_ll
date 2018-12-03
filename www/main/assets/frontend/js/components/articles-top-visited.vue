<style lang="scss">
    @-webkit-keyframes polaris-plug-shimmer-animation {
        0% {
            opacity: .35
        }

        to {
            opacity: 1
        }
    }

    @keyframes polaris-plug-shimmer-animation {
        0% {
            opacity: .35
        }

        to {
            opacity: 1
        }
    }
    .articles-top-visited {
        &-header {
            font-style: italic;
        }
        &-list {
            margin: 0;
            padding: 0 1rem 0 0 ;

            .article-item {
                margin-bottom: .5rem;

                &-title {
                    font-family: "Playfair Display", Georgia, "Times New Roman", serif;
                    font-size: 1.1rem;
                    font-style: italic;
                    line-height: 1.2;
                    text-transform: none;
                }
                &-visited-info {
                    padding: .1rem .25rem;
                    margin-left: .35rem;
                    display: inline-block;
                    font-size: .75rem;
                    line-height: 1;
                    border: 1px solid #dee2e6;
                    border-radius: .25rem;
                    color: #343a40;
                }
            }
        }
        .plug {
            &-list {
                margin: 0;
                padding: 0;
                line-height: 1;

                &-item {
                    padding-top: .15rem;
                    margin-bottom: 1rem;

                    .title-line-one-plug-box {
                        display: inline-block;
                        margin-right: 1rem;
                        margin-bottom: .25rem;
                        width: 70%;
                        height: .95rem;
                        border-radius: .25rem;
                        background-color: #ccc;
                        -webkit-animation: polaris-plug-shimmer-animation .8s linear infinite alternate;
                        animation: polaris-plug-shimmer-animation .8s linear infinite alternate;
                    }
                    .title-line-two-plug-box {
                        display: inline-block;
                        width: 45%;
                        height: .95rem;
                        border-radius: .25rem;
                        background-color: #ccc;
                        -webkit-animation: polaris-plug-shimmer-animation .8s linear infinite alternate;
                        animation: polaris-plug-shimmer-animation .8s linear infinite alternate;
                    }
                    .visited-box-plug {
                        display: inline-block;
                        width: 1.5rem;
                        height: .95rem;
                        border-radius: .25rem;
                        background-color: #aaa;
                        -webkit-animation: polaris-plug-shimmer-animation .8s linear infinite alternate;
                        animation: polaris-plug-shimmer-animation .8s linear infinite alternate;
                    }
                }
            }
        }
    }
</style>

<template>
    <div class="articles-top-visited">
        <div class="atv-content" v-if="!isLoading">
            <h4 class="articles-top-visited-header">Top viewed (by topic)</h4>
            <ul class="articles-top-visited-list list-unstyled">
                <li
                        class="article-item"
                        v-for="article in articles"
                        :key="article.id"
                >
                    <a :href="'/article/' + article.id" class="article-item-title">
                        {{ article.title }}<span class="article-item-visited-info"><i class="fa fa-eye"></i> {{ article.visited }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="plug" v-else>
            <h4 class="articles-top-visited-header">Top viewed (by topic)</h4>
            <ul class="plug-list list-unstyled">
                <li v-for="n in 5" class="plug-list-item">
                    <div>
                        <div class="title-line-one-plug-box"></div><br>
                    </div>
                    <div class="title-line-two-plug-box"></div>
                    <div class="visited-box-plug"></div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

    import serviceAPI from '../api/service';

    export default {

        created() {
            this.$bus.$on('update-top-visited', (payload) => {
                this.getTopVisitedArticles();
            });

            Echo.channel(this.channelName)
                .listen('.visited-changed', (payload) => {
                    this.$bus.$emit('update-top-visited');
                });
        },

        mounted() {
            this.getTopVisitedArticles();
        },

        props: {
            articleId: {
                type: String,
                required: true
            },
            topicId: {
                type: String,
                required: true
            },
        },

        data() {
            return {
                isLoading: false,
                articles: []
            }
        },

        computed: {
            channelName() {
                return `topic-top-${this.topicId}`;
            }
        },

        methods: {
            getTopVisitedArticles() {
                this.isLoading = true;

                serviceAPI.getTopVisited({ 'article_id': this.articleId, 'topic_id': this.topicId }, (response) => {
                    if (response.status === 'OK') {
                        this.articles = response.data;
                        this.isLoading = false;
                    }
                });
            }
        }
    }
</script>