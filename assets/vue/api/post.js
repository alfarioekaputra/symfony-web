import axios from 'axios';

export default {
    getAll () {
        return axios.get('/api/posts');
    },
    create (data) {
        return axios.post(
            '/api/post/create',
            {
                title: data.title,
                message: data.message,
            }
        )
    }
}