import axios from 'axios'

const bufToken = localStorage.getItem('user-token')
const bufUser = JSON.parse(localStorage.getItem('currentUser'))

if (bufToken) {
    axios.defaults.headers.common.Authorization = `Bearer ${bufToken}`
}

export default {
    namespaced: true,
    state: {
        token: bufToken || "",
        currentUser: bufUser || {},
        user: {}
    },
    actions: {
        login({ commit }, user) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/login", data: user, method: "POST" })
                    .then(resp => {
                        const token = resp.data.token
                        const currentUser = resp.data.user

                        localStorage.setItem("user-token", token)
                        localStorage.setItem("currentUser", JSON.stringify(currentUser))
                        axios.defaults.headers.common.Authorization = `Bearer ${token}`
                        commit("setToken", token)
                        commit("setCurrentUser", currentUser)

                        resolve(resp.data)
                    })
                    .catch(err => {
                        localStorage.removeItem("user-token")
                        localStorage.removeItem("currentUser")
                        reject(err.response)
                    });
            });
        },
        register({ commit }, user) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/register", data: user, method: "POST" })
                    .then(resp => {
                        const token = resp.data.token
                        const currentUser = resp.data.user

                        localStorage.setItem("user-token", token)
                        localStorage.setItem("currentUser", JSON.stringify(currentUser))
                        axios.defaults.headers.common.Authorization = `Bearer ${token}`
                        commit("setToken", token)
                        commit("setCurrentUser", currentUser)

                        resolve(resp.data)
                    }, err => {
                        localStorage.removeItem("user-token")
                        localStorage.removeItem("currentUser")
                        reject(err.response)
                    })
            });
        },
        getAllUsers() {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/users", method: "GET" })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            });
        },
        changeAvatar({}, formData) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/users/change-avatar", data: formData, method: "POST", headers: { "Content-Type": "multipart/form-data" } })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            });
        },
        changePassword({}, data) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/users/change-password", data: data, method: "POST"})
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            });
        },
        update({}, user) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/users/" + user.id, data: user, method: "PUT" })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            });
        },
        editProfile({}, user) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/users/edit-profile", data: user, method: "POST" })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            });
        },
        getCurrentUser({ commit }) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/users/current-user", method: "GET" })
                    .then(resp => {
                        localStorage.setItem("currentUser", JSON.stringify(resp.data))
                        commit("setCurrentUser", resp.data)
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            });
        },
        getUser({ commit }, user_id) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/users/" + user_id, method: "GET" })
                    .then(resp => {
                        commit("setUser", resp.data)
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            });
        },
        forgotPassword({}, email) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/forgot-password/" + email, method: "GET" })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response.data)
                    })
            });
        },
        verifyHash({}, token) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/check-token", method: "POST", data: {token} })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response.data)
                    })
            });
        },
        changePasswordWhenForgot({}, data) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/reset/process", method: "POST", data: data })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response.data)
                    })
            });
        },
        verify({}, code) {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/users/email/verify", method: "POST", data: {code} })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            });
        },
        resend() {
            return new Promise((resolve, reject) => {
                axios({ url: "/api/users/email/resend", method: "GET" })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            });
        },
        logout({ commit }) {
            axios({ url: "/logout", method: "GET" })
            localStorage.removeItem("user-token")
            localStorage.removeItem("currentUser")
            commit("setToken", "")
            commit("setCurrentUser", {})
            document.location.reload();
        }
    },
    mutations: {
        setToken(state, token) {
            state.token = token
        },
        setCurrentUser(state, currentUser) {
            state.currentUser = currentUser
        },
        setUser(state, user) {
            state.user = user
        }
    },
    getters: {
        getCurrentUser(state) {
            return state.currentUser
        },
        getUser(state) {
            return state.user
        }
    }
};
