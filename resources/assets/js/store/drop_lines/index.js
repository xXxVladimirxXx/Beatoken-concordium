import axios from 'axios'

export default {
    namespaced: true,
    actions: {
        storeDropLineByDrop({}, drop_id) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/drop-lines/store-by-drop/' + drop_id,
                    method: 'GET',
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
            })
        },
        myTimeToStartBuyDrop({}, drop_id) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/drop-lines/my-time-to-start-buy-drop/' + drop_id,
                    method: 'GET',
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
            })
        },
        myTimeToBuyDrop({}, drop_id) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/drop-lines/my-time-to-buy-drop/' + drop_id,
                    method: 'GET',
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
            })
        },
        deleteByDrop({}, drop_id) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/drop-lines/destroy-by-drop/' + drop_id,
                    method: 'GET',
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
            })
        }
    }
}
