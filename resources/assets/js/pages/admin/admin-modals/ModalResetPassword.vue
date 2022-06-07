<template>
    <!-- MODAL -->
    <!-- RESET PASSWORD -->
    <div
        class="modal fade"
        id="reset-password"
        tabindex="-1"
        aria-labelledby="prizeModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="prizeModalLabel">Reset password</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <i class="icon-btn-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="user-modal__data">
                        <img :src="user.full_uri_avatar" alt="user-avatar" />
                        <p>{{user.name}}</p>
                    </div>
                    <form class="reset-password__form">
                        <div class="mb-3">
                            <label for="inputPassword1" class="form-label"
                            >New password</label
                            >
                            <input
                                type="password"
                                class="form-control"
                                id="inputPassword1"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword2" class="form-label" required>Repeat new password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="inputPassword2"
                            />
                        </div>
                        <div class="mb-3 form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="check1"
                                required
                            />
                            <label class="form-check-label" for="check1"
                            >Send new password to user email</label
                            >
                        </div>
                        <button type="submit" class="submit-btn">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'modal-reset-password',
    props: {
        user: {
            type: Object,
            required: false
        }
    },
}
</script>
