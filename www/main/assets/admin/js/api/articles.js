const _urls = {
    DELETE: '/ajax/article/delete'
};

export default {

    urls: _urls,

    deleteArticle(params, callback) {
        axios.post(this.urls.DELETE, params)
            .then(response => {
                callback(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    },
}