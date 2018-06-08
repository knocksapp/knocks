<template>
<div>
    <knockswatchmywindow v-model = 'win'></knockswatchmywindow>
    <div 
    v-if = "win.width > 990"
    class="uk-position-relative uk-visible-toggle uk-light" uk-slider="clsActivated: uk-transition-active; center: true; autoplay : true; autoplay-interval : 6000;" >
    <ul class="uk-slider-items uk-grid">
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img :src="assets('snaps/social.png')" alt="">
                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom" :class = "[{'transparent' : win.width > 1350 }]">
                    <h2 class="uk-margin-remove"><static_message msg = "Socialize"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                        <static_message msg = "Reimagining the social media, enjoy the social media with a smooth interface, posting facilities and better management for your accounts."></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img :src="assets('snaps/privacy.png')" alt="">
                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom" :class = "[{'transparent' : win.width > 1350 }]">
                    <h2 class="uk-margin-remove"><static_message msg = "Privacy Presets"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                        <static_message msg = "Customize and save your privacy settings for everything that belongs to you for easier and safer experience."></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img :src="assets('snaps/talk.png')" alt="">
                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom" :class = "[{'transparent' : win.width > 1350 }]">
                    <h2 class="uk-margin-remove"><static_message msg = "Speake to Post"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                        <static_message msg = "Socialize with your voice!, use your voice to knock, search or even to write for you."></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img :src="assets('snaps/candy.png')" alt="">
                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom" :class = "[{'transparent' : win.width > 1350 }]">
                    <h2 class="uk-margin-remove"><static_message msg = "Candy Session"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                        <static_message msg = "Protect your children from the dark side of social media, take care of them using the parental monitor by KnocksApp (coming soon)."></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img :src="assets('snaps/voicecommands.png')" alt="">
                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom" :class = "[{'transparent' : win.width > 1350 }]">
                    <h2 class="uk-margin-remove"><static_message msg = "Voice Commands"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                        <static_message msg = "Meet your new assistant, KnocksApp assistant helps you to do many things, just say ‘knock knock’ and he will be there for you!"></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img :src="assets('snaps/talents.png')" alt="">
                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom" :class = "[{'transparent' : win.width > 1350 }]">
                    <h2 class="uk-margin-remove"><static_message msg = "Talents"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                        <static_message msg = "KnocksApp will give you a hand to bring your talents to the light, publish your talents in a better community where people can easily find each others."></static_message>
                    </p>
                </div>
            </div>
        </li>
    </ul>
    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
</div>
</div>
</template>

<script>
export default {

  name: 'knockswelcomeslider',

  data () {
    return {
        win : { width : 0}
    }
  },
  methods:{
   assets(url){
   	  return LaravelOrgin + url;
   }
  },
}
</script>

<style lang="css" scoped>

</style>