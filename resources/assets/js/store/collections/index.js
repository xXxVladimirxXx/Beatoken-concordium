import axios from 'axios'

export default {
    namespaced: true,
    actions: {
        allCollections({}) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/collections',
                  method: 'GET',
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
              })
        },
        getCollectionsNotForSale({}) {
            return new Promise((resolve, reject) => {
                axios({ url: '/api/collections/collections-not-for-sale', method: 'GET' })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            })
        },
        getCollectionsForSale({}) {
            return new Promise((resolve, reject) => {
                axios({ url: '/api/collections/collections-for-sale', method: 'GET' })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            })
        },
        getCollectionsInDrop({}) {
            return new Promise((resolve, reject) => {
                axios({ url: '/api/collections/collections-in-drop', method: 'GET' })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            })
        },
        storeCollection({}, collection) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/collections',
                  method: 'POST',
                  data: collection,
                  headers: { "Content-Type": "multipart/form-data" },
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
              })
        },
        showCollection({}, collection_id) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/collections/' + collection_id,
                  method: 'GET',
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
              })
        },
        showCollectionByTab({}, {collection_id, notForSale, forSale, inDrop}) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/collections/show-by-tab/' + collection_id,
                  data: {notForSale, forSale, inDrop},
                  method: 'POST',
                }).then(resp => {
                    resolve(resp.data)
                }, err => {
                    reject(err.response)
                })
              })
        }
    }
};
