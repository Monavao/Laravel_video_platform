<template>
    <div class="container" style="color: black; font-weight: bold;">
        <h1 class="text-center">
            <button class="btn btn-primary" @click="createNewVideo()">
                Create new video
            </button>
        </h1>
        <ul class="list-group d-flex">
            <li class="list-group-item d-flex justify-content-between" v-for="video, key in videos">
                <p>{{ video.title }}</p>
                <p>
                    <button class="btn btn-primary btn-xs" @click="editVideo(video)">
                        Edit
                    </button>

                    <button class="btn btn-danger btn-xs" @click="deleteVideo(video.id, key)">
                        Delete
                    </button>
                </p>
            </li>
        </ul>
        <create-video></create-video>
    </div>
</template>

<script>
    import Axios from 'axios'
    export default {
        props : ['default_videos', 'series_id'],
        mounted(){
            this.$on('video_created', (video) => {
                window.noty({
                    message: 'Video created successfuly',
                    type: 'success'
                })
                this.videos.push(video)
            })

            this.$on('video_updated', (video) => {
                let videoIndex = this.videos.findIndex(v => {
                    return video.id == v.id
                })

            this.videos.splice(videoIndex, 1, video)
            window.noty({
                    message: 'Video updated successfuly',
                    type: 'success'
                })

            })
        },
        components: {
            "create-video": require('./children/CreateVideo.vue')
        },
        data(){
            return {
                videos: JSON.parse(this.default_videos)
            }
        },
        computed: {
           
        },
        methods: {
            createNewVideo(){
                this.$emit('create_new_video', this.series_id)
            },
            deleteVideo(id, key){
                if(confirm('Are you sure to delete ?')){
                    Axios.delete(`/admin/${this.series_id}/videos/${id}`)
                        .then(resp => {
                            this.videos.splice(key, 1)
                            window.noty({
                                message: 'Video deleted successfuly',
                                type: 'success'
                            })
                        }).catch(error => {
                           window.handleErrors(error)
                        })
                }
            },
            editVideo(video){
                let seriesId = this.series_id
                this.$emit('edit_video', { video, seriesId })
            }
        }
    }
</script>