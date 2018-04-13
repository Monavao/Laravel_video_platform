<template>

	<div :data-vimeo-id="video.video_id" data-vimeo-width="1110" v-if="video" id="handstick">
		

	</div>

</template>

<script>
	import Axios from 'axios'
	import Swal from 'sweetalert'
	import Player from '@vimeo/player'
	export default {
		props: ['default_video', 'next_video_url'],
		data(){
			return {
				video: JSON.parse(this.default_video)
			}
		},
		methods: {
			displayVideoEndedAlert(){
				if(this.next_video_url) {
					Swal('Yaaay ! You completed this video.')
						.then(() => {
							window.location = this.next_video_url
					})
				}
				else {
					Swal('Yaaay ! You completed this series.')
				}

			},

			completeVideo(){
				Axios.post(`/series/complete-video/${this.video.id}`, {})
					.then(resp => {
						this.displayVideoEndedAlert()
					})
			}
		},
		mounted(){
			const player = new Player('handstick')

			player.on('ended', () => {
				this.completeVideo()
			})
		}

	}

</script>