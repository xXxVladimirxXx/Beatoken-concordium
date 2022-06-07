<template>
    <!-- MODAL create collection -->
    <div
        class="modal fade"
        id="create-collection"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-dialog-contact">
            <div class="modal-content modal-content-contact">
                <div class="modal-header modal-header-contact">
                    <h5 class="modal-title">Create Collection</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <i class="icon-btn-close"></i>
                    </button>
                </div>
                <div class="modal-body modal-body-contact">
                    <div class="create-nft__container" style="width:100%">
                          <div class="cover-img__block" style="color:white">
                              <div class="cover-img flex-center" style="color:white">
                                  <!-- <img src="" alt="cover-img"/>-->
                                  <span v-if="collection.cover_image != {} && collection.cover_image.name">{{ collection.cover_image.name }}</span>
                              </div>
                              <p class="cover-title">Select cover for your Collection</p>
                              <label for="nft_cover" class="upload-btn">Upload cover</label>
                              <!--<label>{{collection.cover_image.name}}</label>-->
                              <input style="display:none" type="file" @change="processCoverImageCreate($event)" id="nft_cover" accept="image/*">
                          </div>

                          <div class="create-nft__block desc">
                              <div class="inputs-nft__block">
                                  <label>* Name</label>
                                  <input type="text" name="name" class="form-control input-black" v-model="collection.name" required>
                              </div>

                              <div class="inputs-nft__block textarea">
                                  <label style="width:auto" >* Description</label>
                                  <input type="text" name="description" class="form-control input-black" v-model="collection.description" required>
                              </div>
                          </div>

                          <div class="row">
                                <div class="col-12 flex-center">
                                    <button @click="createCollection" :disabled="collection.cover_image == {} || !collection.cover_image.name || collection.name == '' || collection.description == ''" class="upload-btn" style="margin:1rem 0">Create Collection</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'create-collection',
    data() {
        return {
            collection: {
                cover_image: {},
                name: '',
                description: ''
            }
        }
    },
    methods: {
        processCoverImageCreate(e) { this.collection.cover_image = e.target.files[0] },
        createCollection() {
            this.$loader(true)
            const formData = new FormData()
            if (this.collection.cover_image.name) formData.append('cover_image', this.collection.cover_image)
            if (this.collection.name) formData.append('name', this.collection.name)
            if (this.collection.description) formData.append('description', this.collection.description)

            this.$store.dispatch('collections/storeCollection', formData)
                .then(() => {
                    this.$emit('showNotForSale')

                    this.collection = {cover_image: {name:''}, name: '', description: ''}

                    this.$notify({title: 'Your collection has been successfully created', type: 'success'});
                    this.$loader(false)
                    $('#create-collection').modal('hide')
                }).catch((e) => {this.$loader(false); this.$notify({title: 'Server error. Please try again later', type: 'error'}) })
        },
    }
}
</script>
