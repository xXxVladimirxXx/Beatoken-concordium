<template>
  <div id="music-player" v-if="tracks.length">
    <div class="player">
      <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn-close" @click="closePlayer()"></button>
      <div class="player__top">
        <div class="player-cover">
          <transition :name="transitionName">
            <div class="player-cover__item" v-if="i === currentTrackIndex" v-for="(track, i) in tracks" :key="i" :style="{ backgroundImage: `url(${track.cover})` }"></div>
          </transition>
        </div>

        <div class="album-info" v-if="currentTrack">
          <div class="album-info__track">{{ currentTrack.name }}</div>
          <div class="album-info__name">{{ currentTrack.artist }}</div>
        </div>

        <div class="player-controls">
          <div class="player-controls__item -xl js-play" @click="play">
            <img src="/assets/img/pause.svg" v-if="isTimerPlaying">
            <img src="/assets/img/play.svg" v-else>
          </div>

          <div class="progress__time">{{ currentTime }}</div>

          <div class="progress" ref="progress">
            <div class="progress__bar" @click="clickProgress">
              <div class="progress__current" :style="{ width : barWidth }"></div>
            </div>
          </div>

          <div class="progress__time">
            <div class="progress__duration" v-if="duration">{{ duration }}</div>
          </div>

          <div v-cloak></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      audio: null,
      circleLeft: null,
      barWidth: null,
      duration: null,
      currentTime: null,
      isTimerPlaying: false,
      currentTrack: null,
      currentTrackIndex: 0,
      transitionName: 'scale'
    };
  },
  watch: {
    tracks() {
      this.startPlayer();
    }
  },
  computed: {
    tracks() {
      return this.$store.getters['general/tracks'];
    }
  },
  methods: {
    startPlayer() {
      if (!this.tracks.length) return false;

      let vm = this;
      this.currentTrack = this.tracks[0];
      if (this.audio != null) {
        this.audio.pause();
        this.isTimerPlaying = false
      };
      this.audio = new Audio();
      this.audio.src = this.currentTrack.source;
      this.audio.ontimeupdate = function() {
        vm.generateTime();
      };
      this.audio.onloadedmetadata = function() {
        vm.generateTime();
      };
      this.audio.onended = function() {
        this.isTimerPlaying = true;
      };

      // this is optional (for preload covers)
      for (let index = 0; index < this.tracks.length; index++) {
        const element = this.tracks[index];
        let link = document.createElement('link');
        link.rel = "prefetch";
        link.href = element.cover;
        link.as = "image"
        document.head.appendChild(link)
      }
      
      this.play()
    },
    closePlayer() {
      if (this.audio != null) this.audio.pause();
      this.$store.commit('general/setTracks', [])
    },
    play() {
      if (this.audio.paused) {
        this.audio.play();
        this.isTimerPlaying = true;
      } else {
        this.audio.pause();
        this.isTimerPlaying = false;
      }
    },
    generateTime() {
      let width = (100 / this.audio.duration) * this.audio.currentTime;
      this.barWidth = width + "%";
      this.circleLeft = width + "%";
      let durmin = Math.floor(this.audio.duration / 60);
      let dursec = Math.floor(this.audio.duration - durmin * 60);
      let curmin = Math.floor(this.audio.currentTime / 60);
      let cursec = Math.floor(this.audio.currentTime - curmin * 60);
      if (durmin < 10) {
        durmin = "0" + durmin;
      }
      if (dursec < 10) {
        dursec = "0" + dursec;
      }
      if (curmin < 10) {
        curmin = "0" + curmin;
      }
      if (cursec < 10) {
        cursec = "0" + cursec;
      }
      if (durmin && dursec) {
        this.duration = durmin + ":" + dursec;
      }
      this.currentTime = curmin + ":" + cursec;
    },
    updateBar(x) {
      let progress = this.$refs.progress;
      let maxduration = this.audio.duration;
      let position = x - progress.offsetLeft;
      let percentage = (100 * position) / progress.offsetWidth;
      if (percentage > 100) {
        percentage = 100;
      }
      if (percentage < 0) {
        percentage = 0;
      }
      this.barWidth = percentage + "%";
      this.circleLeft = percentage + "%";
      this.audio.currentTime = (maxduration * percentage) / 100;
      this.audio.play();
    },
    clickProgress(e) {
      this.isTimerPlaying = true;
      this.audio.pause();
      this.updateBar(e.pageX);
    },
    resetPlayer() {
      this.barWidth = 0;
      this.circleLeft = 0;
      this.audio.currentTime = 0;
      this.audio.src = this.currentTrack.source;
      setTimeout(() => {
        if(this.isTimerPlaying) {
          this.audio.play();
        } else {
          this.audio.pause();
        }
      }, 300);
    }
  }
}
</script>

<style scoped lang="scss">
#music-player {
  left: 0;
  bottom: 0;
  position: fixed;
  min-width: 100%;
  z-index: 9999;
}
.icon {
  display: inline-block;
  width: 1em;
  height: 1em;
  stroke-width: 0;
  stroke: currentColor;
  fill: currentColor;
}
.wrapper {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background-size: cover;
  flex-wrap: wrap;
  flex-direction: column;
}

.btn-close {
  position: absolute;
  right: 12.5rem;
  top: -0.5rem;
  border: 3px solid #171d24;
  border-radius: 50%;

  @media screen and (max-width: 992px) {
    right: 3rem;
  }
  @media screen and (max-width: 768px) {
    right: 0.3rem;
  }
}

.player {
  overflow: hidden;
  background: #23262f;
  padding: 0.2rem 12.5rem;
  border-top: 0.4rem solid #212529;

  @media screen and (max-width: 992px) {
    padding: 0.2rem 3rem;
  }
  @media screen and (max-width: 768px) {
    padding: 0.2rem 0.3rem;
  }

  &__top {
    display: flex;
    align-items: center;
  }

  &-cover {
    flex-shrink: 0;
    position: relative;
    z-index: 2;
    border-radius: 15px;
    width: 4.5rem;
    height: 4.5rem;

    @media screen and (max-width: 567px) {
      width: 3.5rem;
      height: 3.5rem;
    }
    &__item {
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      width: 100%;
      height: 100%;
      border-radius: 15px;
      position: absolute;
      left: 0;
      top: 0;

      &:before {
        content: "";
        background: inherit;
        width: 100%;
        height: 100%;
        box-shadow: 0px 10px 40px 0px rgba(76, 70, 124, 0.5);
        display: block;
        z-index: 1;
        position: absolute;
        top: 30px;
        transform: scale(0.9);
        filter: blur(10px);
        opacity: 0.9;
        border-radius: 15px;
      }

      &:after {
        content: "";
        background: inherit;
        width: 100%;
        height: 100%;
        box-shadow: 0px 10px 40px 0px rgba(76, 70, 124, 0.5);
        display: block;
        z-index: 2;
        position: absolute;
        border-radius: 15px;
      }
    }

    &__img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 15px;
      box-shadow: 0px 10px 40px 0px rgba(76, 70, 124, 0.5);
      user-select: none;
      pointer-events: none;
    }
  }

  &-controls {
    display: flex;
    align-items: center;
    width: 100%;

    &__item {
      display: inline-flex;
      padding: 5px;
      color: #acb8cc;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      position: relative;
      transition: all 0.3s ease-in-out;

      font-size: 26px;
      margin-right: 10px;
      width: 40px;
      height: 40px;
      margin-bottom: 0;

      &::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #fff;
        transform: scale(0.5);
        opacity: 0;
        box-shadow: 0px 5px 10px 0px rgba(76, 70, 124, 0.2);
      }

      @media screen and (min-width: 500px) {
        &:hover {
          color: #532ab9;

          &::before {
            opacity: 1;
            transform: scale(0.9);
          }
        }
      }

      @media screen and (max-width: 576px), (max-height: 500px) {
        &:active {
          color: #532ab9;

          &::before {
            opacity: 1;
            transform: scale(1.3);
          }
        }
      }

      .icon {
        position: relative;
        z-index: 2;
      }

      &.-xl {
        margin-bottom: 0;
        // filter: drop-shadow(0 2px 8px rgba(172, 184, 204, 0.3));
        // filter: drop-shadow(0 9px 6px rgba(172, 184, 204, 0.35));
        filter: drop-shadow(0 11px 6px rgba(172, 184, 204, 0.45));
        color: #fff;
        width: auto;
        height: auto;
        display: inline-flex;
        margin-left: auto;
        font-size: 45px;
        margin-right: 0;
        @media screen and (max-width: 567px) {
          font-size: 35px;
        }
        &:before {
          display: none;
        }
      }

      &.-favorite {
        &.active {
          color: red;
        }
      }
    }
  }
}
[v-cloak] {
  display: none;
}
[v-cloak] > * {
  display: none;
}
.progress {
  background-color: unset;
  height: auto;
  width: 100%;
  user-select: none;
  align-items: center;
}

.progress__duration {
  color: #71829e;
  font-weight: 700;
  font-size: 20px;
  opacity: 0.5;

  @media screen and (max-width: 567px) {
    font-size: 12px;
  }
}

.progress__time {
  color: #71829e;
  font-weight: 700;
  font-size: 16px;
  opacity: 0.7;
  margin: 0rem 1rem;

  @media screen and (max-width: 567px) {
    font-size: 12px;
  }
}

.progress__bar {
  height: 6px;
  width: 100%;
  cursor: pointer;
  background-color: #d0d8e6;
  display: inline-block;
  border-radius: 10px;
}
.progress__current {
  height: inherit;
  width: 0%;
  background: linear-gradient(90deg, #1c70de 0%, #9b4880 62%, #c33c64 86%, #dc3b54 100%);
  border-radius: 10px;
}
.album-info {
  color: #71829e;
  flex: 1;
  user-select: none;
  margin: 0 2rem;
  min-width: 20%;

  @media screen and (max-width: 768px) {
    margin: 0 0.3rem;
  }

  &__track {
    color: white;
    font-weight: bold;
    line-height: 1.3em;
    font-size: 14px;
    margin-bottom: 0.2rem;

    @media screen and (max-width: 567px) {
      font-size: 12px;
    }
  }
  &__name {
    font-weight: bold;
    line-height: 1.3em;
    font-size: 11px;

    @media screen and (max-width: 567px) {
      font-size: 10px;
    }
  }
}

//scale out

.scale-out-enter-active {
  transition: all .35s ease-in-out;
}
.scale-out-leave-active {
  transition: all .35s ease-in-out;
}
.scale-out-enter {
  transform: scale(.55);
  pointer-events: none;
  opacity: 0;
}
.scale-out-leave-to {
  transform: scale(1.2);
  pointer-events: none;
  opacity: 0;
}


//scale in

.scale-in-enter-active {
  transition: all .35s ease-in-out;
}
.scale-in-leave-active {
  transition: all .35s ease-in-out;
}
.scale-in-enter {
  transform: scale(1.2);
  pointer-events: none;
  opacity: 0;
}
.scale-in-leave-to {
  transform: scale(.55);
  pointer-events: none;
  opacity: 0;
}
</style>