import axios from 'axios'
import { parseMetaAttributes } from '../../mixins/nfts'

export default {
    namespaced: true,
    actions: {
        allNfts({}) {
            return new Promise((resolve, reject) => {
                axios({ url: '/api/nfts', method: 'GET'})
                    .then(resp => {
                        resolve(resp.data.map(nft => parseMetaAttributes(nft)))
                    }, err => {
                        reject(err.response)
                    })
            })
        },
        getNftsNotForSale({}) {
            return new Promise((resolve, reject) => {
                axios({ url: '/api/nfts/nfts-not-for-sale', method: 'GET' })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            })
        },
        getNftsForSale({}) {
            return new Promise((resolve, reject) => {
                axios({ url: '/api/nfts/nfts-for-sale', method: 'GET' })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            })
        },
        getNftsInDrop({}) {
            return new Promise((resolve, reject) => {
                axios({ url: '/api/nfts/nfts-in-drop', method: 'GET' })
                    .then(resp => {
                        resolve(resp.data)
                    }, err => {
                        reject(err.response)
                    })
            })
        },
        allNftsOfAllUsers({}) {
            return new Promise((resolve, reject) => {
                axios({ url: '/api/nfts/all-nfts-of-all-users',method: 'GET'})
                    .then(resp => {
                        resolve(resp.data.map(nft => parseMetaAttributes(nft)))
                    }, err => {
                        reject(err.response)
                    })
            })
        },
        allNftsByUserId({}, user_id) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/nfts/by-user-id/' + user_id,
                  method: 'GET',
                }).then(resp => {
                    resolve(resp.data.map(nft => parseMetaAttributes(nft)))
                }, err => {
                    reject(err.response)
                })
              })
        },
        allNftsForSale({}) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/nfts/nfts-for-sale',
                  method: 'GET',
                }).then(resp => {
                    resolve(resp.data.map(nft => parseMetaAttributes(nft)))
                }, err => {
                    reject(err.response)
                })
              })
        },
        storeNft({}, nft) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/nfts',
                  method: 'POST',
                  data: nft,
                  headers: { "Content-Type": "multipart/form-data" },
                }).then(resp => {
                    resolve(resp.data.map(nft => parseMetaAttributes(nft)))
                }, err => {
                    reject(err.response)
                })
              })
        },
        showNft({}, nft_id) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/nfts/' + nft_id,
                  method: 'GET',
                }).then(resp => {
                    resolve(parseMetaAttributes(resp.data))
                }, err => {
                    reject(err.response)
                })
              })
        },
        putForSale({}, nft) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/nfts/put-for-sale',
                    data: nft,
                    method: 'POST',
                }).then(resp => {
                    resolve(parseMetaAttributes(resp.data))
                }, err => {
                    reject(err.response)
                })
            })
        },
        removeFromSale({}, nft_id) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/nfts/remove-from-sale/' + nft_id,
                  method: 'GET',
                }).then(resp => {
                    resolve(parseMetaAttributes(resp.data))
                }, err => {
                    reject(err.response)
                })
              })
        },
        buy({}, {nft_id, order}) {
            return new Promise((resolve, reject) => {
                axios({
                  url: '/api/nfts/buy/' + nft_id,
                  data: order,
                  method: 'POST',
                }).then(resp => {
                    resolve(parseMetaAttributes(resp.data))
                }, err => {
                    reject(err.response)
                })
              })
        }
    }
};
