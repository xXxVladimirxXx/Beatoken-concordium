<template>
    <!-- MODAL -->
    <!-- CreateNft -->
    <div
        class="modal fade"
        id="createNft"
        tabindex="-1"
        aria-labelledby="prizeModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="prizeModalLabel">Create NFT</h5>
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
                    <div class="user-modal__data flex-center">
                        <img :src="user.full_uri_avatar" alt="user-avatar" />
                        <p>{{ user.name }}</p>
                    </div>
                    <div class="flex" style="flex-direction:column-reverse;margin-bottom:2rem">
                        <label v-if="nft.file != {}">{{nft.file.name}}</label>
                        <label for="nft_file" class="btn btn-success" style="margin:0 3rem">Select file for NFT</label>
                        <input style="display:none" type="file" @change="processFileCreate($event)" id="nft_file" accept="audio/mp3, video/mp4, image/jpeg">
                    </div>

                    <div class="create-nft__container" style="width:100%">
                        <div v-if="nft.file != {} && nft.file.name">
                            <div class="cover-img__block" style="color:white">
                                <div class="cover-img flex-center" style="color:white">
                                    <!-- <img src="" alt="cover-img"/>-->
                                    <span v-if="nft.cover_image != {} && nft.cover_image.name">{{ nft.cover_image.name }}</span>
                                </div>
                                <p class="cover-title">Select token cover for your NFT</p>
                                <label for="nft_cover" class="upload-btn">Upload cover</label>
                                <!--<label>{{nft.cover_image.name}}</label>-->
                                <input style="display:none" type="file" @change="processCoverImageCreate($event)" id="nft_cover" accept="image/*">
                            </div>

                            <div class="cover-img__block" style="color:white">
                                <div class="cover-img flex-center" style="color:white">
                                    <!-- <img src="" alt="cover-img"/>-->
                                    <span v-if="nft.cover_video != {} && nft.cover_video.name">{{ nft.cover_video.name }}</span>
                                </div>
                                <p class="cover-title">Select video cover for your NFT</p>
                                <label for="nft_cover_video" class="upload-btn">Upload cover</label>
                                <!--<label>{{nft.cover_video.name}}</label>-->
                                <input style="display:none" type="file" @change="processCoverVideoCreate($event)" id="nft_cover_video" accept="video/mp4">
                            </div>


                            <div class="create-nft__block desc">
                                <div class="inputs-nft__block">
                                    <label>* Name</label>
                                    <input type="text" name="name" class="form-control input-black" v-model="nft.name" required>
                                </div>

                                <div class="inputs-nft__block textarea">
                                    <label>* Description</label>
                                    <input type="text" name="description" class="form-control input-black" v-model="nft.description" required>
                                </div>
                            </div>

                            <div class="create-nft__block properties">
                                <div class="inputs-nft__block">
                                    <label>Type</label>
                                    <input type="text" name="type" class="form-control input-black" v-model="nft.type">
                                </div>
                            </div>

                            <div class="create-nft__block properties">
                                <div class="inputs-nft__block">
                                    <label>Attachment</label>
                                    <input type="text" name="type" class="form-control input-black" v-model="nft.attachment">
                                </div>
                            </div>

                            <div class="cover-img__block" style="color:white">
                                <div class="cover-img flex-center" style="color:white">
                                    <!-- <img src="" alt="cover-img"/>-->
                                    <span v-if="nft.attachment_file != {} && nft.attachment_file.name">{{ nft.attachment_file.name }}</span>
                                </div>
                                <p class="cover-title">Select attachment file for your NFT</p>
                                <label for="attachment_file" class="upload-btn">Upload cover</label>
                                <!--<label>{{nft.cover_video.name}}</label>-->
                                <input style="display:none" type="file" @change="processAttachmentFileCreate($event)" id="attachment_file" accept="image/*">
                            </div>

                            <div class="row">
                                <div class="col-12 flex-center">
                                    <button @click="createNft" :disabled="nft.cover_image == {} || !nft.cover_image.name || nft.name == '' || nft.description == ''" class="upload-btn" style="margin:1rem 0">Create NFT</button>
                                </div>
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
    name: 'modal-create-nft',
    props: {
        user: {
            type: Object,
            required: false
        }
    },
    data() {
        return {
            nft: {
                name: '',
                file: {},
                cover_image: {},
                cover_video: {},
                description: '',
                type: '',
                attachment: '',
                attachment_file: {},
            }
        }
    },
    created() {},
    methods: {
        processFileCreate(e) { this.nft.file = e.target.files[0] },
        processCoverImageCreate(e) { this.nft.cover_image = e.target.files[0] },
        processCoverVideoCreate(e) { this.nft.cover_video = e.target.files[0] },
        processAttachmentFileCreate(e) { this.nft.attachment_file = e.target.files[0] },
        createNft() {
            if (this.user.role.name != 'superadmin') return false

            this.$loader(true)
            const formData = new FormData()
            if (this.nft.name) formData.append('name', this.nft.name)
            if (this.nft.file.name) formData.append('file', this.nft.file)
            if (this.nft.cover_image.name) formData.append('cover_image', this.nft.cover_image)
            if (this.nft.cover_video.name) formData.append('cover_video', this.nft.cover_video)
            if (this.nft.description) formData.append('description', this.nft.description)
            if (this.nft.type) formData.append('type', this.nft.type)
            if (this.nft.attachment) formData.append('attachment', this.nft.attachment)
            if (this.nft.attachment_file.name) formData.append('attachment_file', this.nft.attachment_file)

            this.$store.dispatch('nfts/storeNft', formData)
                .then(() => {
                    this.nft = {name: '', file: {name:''}, cover_image: {name:''}, description: '', type: ''}

                    this.$notify({title: 'Your nft has been successfully created', type: 'success'});
                    this.$loader(false)
                    $('#createNft').modal('hide')
                    this.$router.push('/admin/users')
                }).catch(e => {this.$notify({ title: 'Something went wrong. Please try again later', type: 'error'}); this.$loader(false)})
        }
    }
}
</script>

<style scoped>
    hr {
        margin-top: 2rem
    }
</style>
