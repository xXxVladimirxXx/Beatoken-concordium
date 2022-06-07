<template>
    <div>
        <Header/>

        <main>
            <router-view></router-view>
        </main>

        <Footer/>

        <MusicPlayer></MusicPlayer>
    </div>
</template>

<script>

import Header from "./Header";
import Footer from "./Footer";
import MusicPlayer from "./MusicPlayer";

export default {
  components: {Header, Footer, MusicPlayer}
}
</script>
