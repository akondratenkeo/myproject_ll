const data = {
    status: 'OK',
    data: [
        {
            id: 801,
            title: 'Lorem ipsum dolor sit amet, consectetur.',
            topic_id: 15,
            visited: 8
        }, {
            id: 809,
            title: 'Lorem ipsum dolor sit amet, consectetur.',
            topic_id: 15,
            visited: 6
        }, {
            id: 544,
            title: 'Lorem ipsum dolor sit amet, consectetur.',
            topic_id: 15,
            visited: 5
        }
    ]
};

const _urls = {
    GET_TOP: '//service.myproject.ll:8080/api/article/top'
};

export default {

    urls: _urls,

    getTopVisited(params, callback) {
        axios.post(this.urls.GET_TOP, params)
            .then(response => {
                setTimeout(function () {
                    callback(response.data);
                }, 1000);
            })
            .catch(error => {
                console.log(error);
            });
    },
}