import axios from "axios";

export default {
    state: {
        GetCategories: [],
        updateCategoryData: [],
        ManagePosts: [],
    },
    getters: {
        RenderCategories(state) {
            return state.GetCategories;
        },
        RenderAllPost(state) {
            return state.ManagePosts;
        }
    },
    actions: {
        RenderAllCategories(data) {
            axios.post('/get-category').then(function (response) {
                data.commit('GetCategories', response.data.categories);
            });
        },
        UpdateCategoryDataGet(data) {
            axios.post('/category-update/' + id).then((res) => {
                return data.commit('GetUpdateData', res.data.myData);
            });
        },
        // Post Get Post Data
        RenderAllPost(data) {
            axios.post('/post/manage').then(function (response) {
                return data.commit('getPosts', response.data.posts);
            });
        }
    },
    mutations: {
        GetCategories(state, data) {
            return state.GetCategories = data;
        },
        GetUpdateData(state, data) {
            return state.updateCategoryData = data;
        },
        getPosts(state, data) {
            return state.ManagePosts = data;
        }

    }
}
