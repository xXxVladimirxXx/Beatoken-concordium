<template>
    <div>
        <div class="main-header">
            <div class="container">
                <div class="header-wrapper">
                    <div class="header-title__block">
                        <p class="sup-title">The new generation is here</p>
                        <h1>Music NFT Marketplace</h1>
                        <p class="sub-title">
                            Create, sell and discover unique music
                            <span>and sound NFTs on the Beatoken&trade; marketplace.</span>
                        </p>
                    </div>
                    <div class="header-buttons__block">
                        <router-link to="/login" class="start-collection__btn">Start your collection</router-link>
                        <div class="powered-by__block">
                            <img src="assets/img/powerred.png" alt="powered-icon" />
                            <p>Powered by Dapper Labs Build on the Blockchain</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="abstraction-img"></div>
            <div class="header-bg"></div>
        </div>
        <main>
            <section class="how-to-action">
                <div class="how-toBg"></div>
                <h3 class="visually-hidden">How to get the action</h3>
                <div class="container">
                    <div class="cards-list">
                        <div class="card-list__logged ">
                            <div class="card-logged ">
                                <h3>CMS Head title here</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                    do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                    irure dolor in reprehenderit in voluptate velit esse cillum
                                    dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                                    cupidatat non proident, sunt in culpa qui officia deserunt
                                    mollit anim id est laborum.
                                </p>

                                <p>
                                    Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. Excepteur sint
                                    occaecat cupidatat non proident, sunt in culpa qui officia
                                    deserunt mollit anim id est laborum
                                </p>
                            </div>
                            <div class="card-logged__img ">
                                <img src="assets/img/header-bg.jpg" width="382" height="337" alt="logged-img" />
                            </div>
                        </div>
                    </div>
                    <div class="how-to-action__title-block">
                        <h2 class="section-title">How to get the action</h2>
                        <p>
                            Supercharge your collection by buying packs of Beatoken Moments.
                        </p>
                        <p>Grab a pack and secure this summers most coveted plays first.</p>
                        <a type="button" href="#" class="all-packs__link">
                            See all packs
                        </a>
                    </div>

                    <div class="sets-block">
                        <div class="set set-one set-one__logged">
                            <div class="bg-txt"></div>
                            <div class="set-block">
                                <div class="set-one__txt">
                                    <span class="set-state">Focus box set</span>

                                    <h3>WIDE BOX CMS</h3>
                                    <p>
                                        Duis aute irure dolor in reprehenderit in voluptate velit
                                        esse cillum dolore eu fugiat nulla pariatur.
                                    </p>
                                    <p class="common">
                                        Excepteur sint occaecat cupidatat non proident, sunt in
                                        culpa qui officia deserunt mollit anim id est laborum
                                    </p>
                                </div>
                                <div class="set-one__img"></div>
                            </div>
                            <p class="price">PLINK INSERT or PRICE</p>
                        </div>

                        <div class="set set-two set-two__logged">
                            <div class="bg-txt"></div>

                            <div class="set-block">
                                <div class="set-two__txt">
                                    <span class="set-state">Sold out</span>
                                    <h3>
                                        Holo set
                                        <span>(Drop 2)</span>
                                    </h3>
                                    <p>Common gold</p>
                                    <p class="common">Contains <span>3</span> cards</p>
                                </div>
                                <div class="set-two__img">
                                    <a href="#">
                                        <img
                                            src="assets/img/set-img.png"
                                            class="set-img"
                                            width="119"
                                            height="179"
                                            alt="set-img"
                                        />
                                    </a>
                                </div>
                            </div>
                            <p class="price">LINK INSERT</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section-carousel">
                <h3 class="visually-hidden">Certified Artist</h3>
                <div class="container">
                    <h2 class="section-title">Certified Artist</h2>
                </div>
                <div class="carousel-wrapper">
                    <div class="carousel">
                        <VueSlickCarousel :slidesToShow="slidesToShow" :slidesToScroll="slidesToScroll" :responsive="responsive">
                            <div>
                                <img src="assets/img/kesi.png" class="artist-img" alt="artist" />
                                <div class="artist-block">
                                    <p class="artist-name">Kesi</p>
                                    <img src="assets/img/icon-check.svg" alt="icon-check" />
                                </div>
                                <p class="artist-status">Musician</p>
                            </div>
                            <div>
                                <img src="assets/img/sivas.png" class="artist-img" alt="artist" />
                                <div class="artist-block">
                                    <p class="artist-name">Sivas</p>
                                    <img src="assets/img/icon-check.svg" alt="icon-check" />
                                </div>
                                <p class="artist-status">Musician</p>
                            </div>
                            <div>
                                <img src="assets/img/jamz.png" class="artist-img" alt="artist" />
                                <div class="artist-block">
                                    <p class="artist-name">Jamz</p>
                                    <img src="assets/img/icon-check.svg" alt="icon-check" />
                                </div>
                                <p class="artist-status">Musician</p>
                            </div>
                            <div>
                                <img src="assets/img/farlow.png" class="artist-img" alt="artist" />
                                <div class="artist-block">
                                    <p class="artist-name">Farlow</p>
                                    <img src="assets/img/icon-check.svg" alt="icon-check" />
                                </div>
                                <p class="artist-status">Musician</p>
                            </div>
                            <div>
                                <img src="assets/img/hans.png" class="artist-img" alt="artist" />
                                <div class="artist-block">
                                    <p class="artist-name">Hans</p>
                                    <img src="assets/img/icon-check.svg" alt="icon-check" />
                                </div>
                                <p class="artist-status">Musician</p>
                            </div>
                            <div>
                                <img src="assets/img/phlake.png" class="artist-img" alt="artist-img" />
                                <div class="artist-block">
                                    <p class="artist-name">Phlake</p>
                                    <img src="assets/img/icon-check.svg" alt="icon-check" />
                                </div>
                                <p class="artist-status">Musician</p>
                            </div>
                        </VueSlickCarousel>
                    </div>
                </div>
            </section>
            <section class="artist-section">
                <div class="artist-row row">
                    <div class="artist-block__img col-xl-8"></div>
                    <div class="artist-block__txt col-xl-4">
                        <div class="artist-txt">
                            <h3 class="artist-name">Oliver Kesi</h3>
                            <p class="artist-desc">
                                Big welcome to our newest certififed artist to the platform
                                Oliver Kesi. Kesi has won many awards and gone platnum 10 times.
                            </p>
                            <a href="#" class="find-pack">Find pack with Kesi</a>
                        </div>
                    </div>
                </div>
            </section>
            <div class="section-border"></div>
            <section class="section-start-collection">
                <h3 class="visually-hidden">Start your collection now</h3>

                <div class="container">
                    <div class="start-block">
                        <div class="start-txt__block">
                            <div class="start-txt">
                                <h2 class="section-title">Start your collection now</h2>
                                <p>
                                    Beatoken is a curated NFT marketplace for rare digital music
                                    collectibles.
                                </p>
                                <p>
                                    Buy unique releases, live sets, remixes, and artwork from your
                                    favorite artists.
                                </p>
                                <p>Sign up now to start collecting</p>
                            </div>
                            <div class="start-button__block">
                                <a type="button" class="sign-up" href="#">Sign up now</a>
                                <a type="button" class="login" href="#">Login</a>
                            </div>
                        </div>
                        <div class="start-img__block">
                            <img src="assets/img/start-img-block.png" alt="" />
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    name: 'Home',
    components: { VueSlickCarousel },
    data() {
        return {
            slidesToShow: 5,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        }
    }
}
</script>
