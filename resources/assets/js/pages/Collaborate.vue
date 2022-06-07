<template>
    <div>
        <section class="section-collaborate">
            <h3 class="visually-hidden">Create & Collaborate with us</h3>
            <div class="container">
                <div class="collaborate-title__block">
                    <h2 class="section-title">Create & Collaborate with us</h2>
                    <p class="sub-title">
                        Beatooken is a curated NFT marketplace for rare digital music
                        collectibles.
                    </p>
                    <p class="sub-title">
                        Reach audience with unique releases, live sets, and artwork and
                        much more.
                    </p>
                    <img src="assets/img/logo-logged.png" width="244" height="44" alt="logo" />
                </div>
                <div class="collaborate-artist__block">
                    <p class="collaborate-artist__title">For Artists or Labels</p>
                    <p class="collaborate-artist">
                        Expand your revenue stream and connect with fans. Our blockchain
                        security ensures ownership rights of NFT’s (non-fungible tokens)
                        and keeps your unique content digital scarce and available only to
                        those who purchase it.
                    </p>
                    <button data-bs-toggle="modal" data-bs-target="#contact-us">
                        Contact us
                    </button>
                </div>
                <div class="what-is__block">
                    <div class="what-nft">
                        <p class="what-nft__title">What are NFTs?</p>
                        <p class="what-nft__txt">
                            Non-fungible tokens (NFT) are digital assets powered by the
                            blockchain that represent a wide range of unique tangible and
                            intangible items, from collectible sports cards to art to
                            unreleased music.
                        </p>
                        <p>
                            Because all NFT data is stored on the blockchain via smart
                            contracts, each token cannot be destroyed, removed or
                            replicated. Ownership of these tokens is also immutable, which
                            means collectors actually possess their NFTs.
                        </p>
                    </div>
                    <div class="what-nft">
                        <p class="what-nft__title">Want to Join the Team?</p>
                        <p class="what-nft__txt">
                            We are an early stage startup looking for individuals who are
                            passionate about building a next-generation NFT marketplace for
                            musicians. Currently, we are looking for React Developers and
                            Developers with experience launching applications using Ethereum
                            and IPFS.
                        </p>
                        <p>
                            If you are interested, drop us a line with your information and
                            resume. Thanks!
                        </p>
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
                        <div class="carousel-item">
                            <img src="assets/img/kesi.png" class="artist-img" alt="artist" />
                            <div class="artist-block">
                                <p class="artist-name">Prodigy</p>
                                <img src="assets/img/icon-check.svg" alt="icon-check" />
                            </div>
                            <p class="artist-status">Band</p>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/sivas.png" class="artist-img" alt="artist" />
                            <div class="artist-block">
                                <p class="artist-name">Ivo Bobua</p>
                                <img src="assets/img/icon-check.svg" alt="icon-check" />
                            </div>
                            <p class="artist-status">Musician</p>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/jamz.png" class="artist-img" alt="artist" />
                            <div class="artist-block">
                                <p class="artist-name">Pueblo</p>
                                <img src="assets/img/icon-check.svg" alt="icon-check" />
                            </div>
                            <p class="artist-status">Musician</p>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/farlow.png" class="artist-img" alt="artist" />
                            <div class="artist-block">
                                <p class="artist-name">Poplavski</p>
                                <img src="assets/img/icon-check.svg" alt="icon-check" />
                            </div>
                            <p class="artist-status">Musician</p>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/hans.png" class="artist-img" alt="artist" />
                            <div class="artist-block">
                                <p class="artist-name">Giga</p>
                                <img src="assets/img/icon-check.svg" alt="icon-check" />
                            </div>
                            <p class="artist-status">Musician</p>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/phlake.png" class="artist-img" alt="artist-img" />
                            <div class="artist-block">
                                <p class="artist-name">Snoop</p>
                                <img src="assets/img/icon-check.svg" alt="icon-check" />
                            </div>
                            <p class="artist-status">Musician</p>
                        </div>
                    </VueSlickCarousel>
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
                            <a class="sign-up" href="#">Sign up now</a>
                            <a class="login" href="#">Login</a>
                        </div>
                    </div>
                    <div class="start-img__block">
                        <img src="assets/img/start-img-block.png" alt="" />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>


<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    name: 'Collaborate',
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
