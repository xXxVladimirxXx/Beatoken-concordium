import axios from 'axios'

export default {
    namespaced: true,
    state: {
        roles: {}
    },
    actions: {
        allRoles({ commit }) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/roles',
                  method: 'GET',
                }).then(resp => {
                    commit('setRoles', resp.data)
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
              })
        }
    },
    mutations: {
        setRoles(state, roles) {
            state.roles = roles
        },
    },
    getters: {
        getRoles(state) {
            return state.roles
        }
    }
};
