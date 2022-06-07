<template>
    <footer class="footer">
        <div class="container">
            <div class="footer-row">
                <div class="footer-logo__block">
                    <img
                        src="assets/img/beatokenLogo.svg"
                        width="285"
                        height="52"
                        alt="logo"
                    />
                    <div class="some">
                        <a href="https://www.facebook.com/Beatoken-101849715340291" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/beatoken/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/beatoken/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <p class="footer-links__title footer-links__btn" @click="linksStacksToggler">
                        Stacks <i class="icon-down-open"></i>
                    </p>
                    <div class="footer-links" v-bind:class="{ 'open': isOpenStacks }">
                        <ul id="menu-first_footer_nav" class="first-footer-links">
			                <li id="menu-item-21" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-21"><a target="_blank" rel="noopener" href="https://www.blokklab.com">Blokk Lab</a></li>
                            <li id="menu-item-44" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-44"><a href="https://beatoken.com/create-item/">Create Item</a></li>
                            <li id="menu-item-45" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-45"><a href="https://beatoken.com/beta/">Beta</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-column">
                    <p class="footer-links__title footer-links__btn" @click="linksInfoToggler">
                        Info <i class="icon-down-open"></i>
                    </p>
                    <div class="footer-links" v-bind:class="{ 'open': isOpenInfo }">
                        <ul id="menu-second_footer_nav" class="second-footer-links">
			                <li id="menu-item-41" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-privacy-policy menu-item-41"><a href="https://beatoken.com/privacy-policy/">Privacy Policy</a></li>
                            <li id="menu-item-67" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-67"><a href="https://beatoken.com/terms-condition/">Terms &amp; Condition</a></li>
			            <!-- <li id="menu-item-67" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-67"><a href="https://beatoken.com/cookies/">Support</a></li> -->
                        </ul>
                        <a class="blue_button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" 
                            style="cursor: pointer; color: white!important;">Support</a>      
                    </div>
                </div>
                <div class="footer-column footer-join__block">
                    <p class="footer-links__title">Join Newsletter</p>
                    <form>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label"
                            >Subscribe our newsletter to get more free design course and
                                resource</label
                            >
                            <div class="input-block">
                                <input
                                    type="email"
                                    class="form-control newsletter"
                                    id="inputEmail"
                                    placeholder="Enter your email"
                                    aria-describedby="emailHelp"
                                />
                                <button type="submit" class="btn btn-primary">
                                    <img src="assets/img/icons-Arrow Right 2-Line_6.svg" alt="" />
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                 
            </div>
            <div class="copyright">
                <p>Copyright © 2021 BEATOKEN. All rights reserved</p>
                <div class="accept">
                    <p>We use cookies for better service.</p>
                </div>
            </div>
        </div>
        <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn-close" style="background: url(https://beatoken.com/wp-content/themes/beatoken/core/comingsoon/img/btn-close.svg?5ec222ae8b6b75a32fec121158dded7d);
                                    background-repeat: no-repeat;"></button>
                        </div>
                        <div class="modal-body">
                            <h3 style="font-family: Shapiro\ 85 Super Heavy Wide;
                                font-size: .875rem; text-align: center;
                                margin-bottom: 18px;">Need help? Or are you experiencing problems? <br> Please contact us via the email below.</h3>

                            <h3 style="font-family: Shapiro\ 85 Super Heavy Wide;
                                font-size: .875rem;
                                margin-bottom: 18px;margin-top: 50px;">COPENHAGEN OFFICE</h3>
                            <p style="font-family: Shapiro\ 65 Light Heavy;">Bredgade 19E,</p>
                            <p style="font-family: Shapiro\ 65 Light Heavy;">1260 København K</p>
                            <a href="mailto:contact@beatoken.com" style="color: #fff;margin-top: 50px; display: block;
                                display: block;
                                font-family: Shapiro\ 65 Light Heavy;
                                text-transform: uppercase;">hello@beatoken.com</a></div>
                        <div class="modal-footer" style="height: 30px;"></div>
                    </div>
                </div>
            </div>
    </footer>

</template>
 



<script>
export default {
    name: 'Footer',
    data() {
        return {
            isOpenStacks: false,
            isOpenInfo: false
        }
    },
    methods: {
        linksStacksToggler() {
            this.isOpenStacks = !this.isOpenStacks
        },
        linksInfoToggler() {
            this.isOpenInfo = !this.isOpenInfo
        }
    }
}
</script>

<style scoped>
    .footer-column .footer-links li.menu-item {
        margin-bottom: 21px;
    }


    .fa-facebook-f:before {
        content: "\f39e";
    }

    .fa-instagram:before {
        content: "\f16d";
    }

    .fa-linkedin-in:before {
        content: "\f0e1";
    }
</style>
