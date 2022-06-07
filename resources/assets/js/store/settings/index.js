import axios from 'axios'

export default {
    namespaced: true,
    actions: {
        allSettings({}) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/settings',
                    method: 'GET',
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
            })
        },
        addSettings({}, settings) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/settings',
                    method: 'POST',
                    data: settings,
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
            })
        },
    }
};
