import axios from 'axios'

export default {
    namespaced: true,
    actions: {
        getTransactionsHistoryByUserId({}, user_id) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/transactions-history/by-user-id/' + user_id,
                    method: 'GET'
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
            })
        },
        showTransactionHistory({}, transactions_history_id) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/transactions-history/' + transactions_history_id,
                    method: 'GET',
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
            })
        }
    }
};
