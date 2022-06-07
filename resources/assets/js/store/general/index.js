export default {
    namespaced: true,
    state: {
        loader: false,
        tracks: []
    },
    mutations: {
        setLoader(state, loader) {
            state.loader = loader
        },
        setTracks(state, tracks) {
            state.tracks = tracks
        },
    },
    getters: {
        loader(state) {
            return state.loader
        },
        tracks(state) {
            return state.tracks
        }
    }
};
