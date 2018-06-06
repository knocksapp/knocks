<template>
	         <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider="clsActivated: uk-transition-active; center: true; autoplay : true; autoplay-interval : 4000;" >

    <ul class="uk-slider-items uk-grid">
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img src="https://knocks.dev/social.png" alt="">
                <div class="uk-overlay transparent uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
                    <h2 class="uk-margin-remove"><static_message msg = "Socialize"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                    	<static_message msg = "Reimagining the social media, enjoy the social media with a smooth interface, posting facilities and better management for your accounts."></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img src="https://knocks.dev/privacy.png" alt="">
                <div class="uk-overlay uk-overlay-primary transparent uk-position-bottom uk-text-center uk-transition-slide-bottom">
                    <h2 class="uk-margin-remove"><static_message msg = "Privacy Presets"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                    	<static_message msg = "Customize and save your privacy settings for everything that belongs to you for easier and safer experience."></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img src="https://knocks.dev/talk.png" alt="">
                <div class="uk-overlay uk-overlay-primary transparent uk-position-bottom uk-text-center uk-transition-slide-bottom">
                    <h2 class="uk-margin-remove"><static_message msg = "Speake to Post"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                    	<static_message msg = "Socialize with your voice!, use your voice to knock, search or even to write for you."></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img src="https://knocks.dev/candy.png" alt="">
                <div class="uk-overlay uk-overlay-primary transparent uk-position-bottom uk-text-center uk-transition-slide-bottom">
                    <h2 class="uk-margin-remove"><static_message msg = "Candy Session"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                    	<static_message msg = "Protect your children from the dark side of social media, take care of them using the parental monitor by KnocksApp (coming soon)."></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img src="https://knocks.dev/voicecommands.png" alt="">
                <div class="uk-overlay uk-overlay-primary transparent uk-position-bottom uk-text-center uk-transition-slide-bottom">
                    <h2 class="uk-margin-remove"><static_message msg = "Voice Commands"></static_message></h2>
                    <p class="uk-margin-remove knocks_text_light knocks_text_ms">
                    	<static_message msg = "Meet your new assistant, KnocksApp assistant helps you to do many things, just say ‘knock knock’ and he will be there for you!"></static_message>
                    </p>
                </div>
            </div>
        </li>
        <li class="uk-width-3-4">
            <div class="uk-panel">
                <img src="https://knocks.dev/talents.png" alt="">
                <div class="uk-overlay uk-overlay-primary transparent uk-position-bottom uk-text-center uk-transition-slide-bottom">
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
</template>

<script>
export default {

  name: 'knockswelcomeslider',

  data () {
    return {

    }
  }
}
</script>

<style lang="css" scoped>

</style>