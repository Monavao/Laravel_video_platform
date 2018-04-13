<template>

  <div class="modal" id="createVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">Create new video</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>

        <div class="modal-body">

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Video title" v-model="video.title">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Vimeo video id" v-model="video.video_id">
            </div>

            <div class="form-group">
                <input type="number" class="form-control" placeholder="Episode number" v-model="video.episode_number">
            </div>

             <div class="form-group">
                <textarea cols="30" rows="10" class="form-control" v-model="video.description"></textarea>
            </div>

            <div class="form-group">
                <input type="checkbox" v-model="video.premium"> Premium: {{ video.premium }}
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" @click="updateVideo()" v-if="editing">Save video</button>
          <button type="button" class="btn btn-primary" @click="createVideo()" v-else>Create video</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import Axios from 'axios'

    class Video{
      constructor(video){
        this.title = video.title || ''
        this.description = video.description || ''
        this.video_id = video.video_id || ''
        this.episode_number = video.episode_number || ''
        this.premium = video.premium || false
      }

    }

    export default{
      mounted(){
        this.$parent.$on('create_new_video', (seriesId) => {
          this.seriesId = seriesId
          this.editing = false
          this.video = new Video({})
          $('#createVideo').modal()
        })

        this.$parent.$on('edit_video', ({ video, seriesId }) => {
          this.editing = true
          this.video = new Video(video)
          this.seriesId = seriesId
          this.videoId = video.id

          $('#createVideo').modal()
        })
      },
      data(){
        return {
            video: {},
            seriesId: '',
            editing: false,
            videoId: null,
            premium: false
        }
      },
      methods: {
        createVideo(){
          Axios.post(`/admin/${this.seriesId}/videos`, this.video).then(resp => {
            this.$parent.$emit('video_created', resp.data)
            $('#createVideo').modal('hide')
          }).catch(error => {
             window.handleErrors(error)
          })
        },
        updateVideo(){
          Axios.put(`/admin/${this.seriesId}/videos/${this.videoId}`, this.video)
            .then(resp => {
              $("createVideo").modal('hide')
              this.$parent.$emit('video_updated', resp.data)
            }).catch(error => {
               window.handleErrors(error)
            })
        }
      }
    }
</script>