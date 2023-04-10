<template>
  <div id="kcs-main-page" :style="kcsMainPageStyle">
    <div class="kcs-d-flex kcs-el-center">
      <h1 class="kcs-page-title">All Sliders</h1>
      <div class="kcs-d-block">
        <div class="kcs-add-slider-btn-wrap" v-if="sliders.length">
          <a class="button button-primary" @click="goToCreteSlider">Create New Slider</a>
        </div>
      </div>
      <div class="loading-text" :class="{active:this.loadingText.status === 'pending'}">
        <span>Loading ...</span>
      </div>
    </div>
    <div class="kcs-add-slider-btn-wrap-container" v-if="!sliders.length">
      <div class="kcs-text-align-center">
        <p>Not created any sliders yet. Click the button below to create your first slider.</p>
        <a class="button button-secondary kcs-button" @click="goToCreteSlider">
          <span class="dashicons dashicons-insert"></span>
          Create a New Slider
        </a>
      </div>
    </div>
    <div class="kcs-sliders-container">
      <div class="kcs-row">
        <div class="kcs-slider-items slide-item" v-for="slider in sliders" key="slider.ID">
          <div class="kcs-slider-inner" v-bind:style="{'backgroundImage':`url(${slider.slides[0].imgLink})`,'backgroundSize':'cover'}">
            <span class="kcs-title">{{slider.post_title}}</span>
            <a class="kcs-delete-btn" @click="kcsDeleteSlider($event, slider.ID)">
              <span class="dashicons dashicons-trash"></span>
            </a>
            <div class="kcs-go-slide" @click="gotoSlider($event, slider.ID, slider.post_title)"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="kcs-form-modal kcs-main-page-modal" ref="kcsModal">
    <div class="modal-container">
      <div class="modal-content-holder">
        <Form class="kcs-modal-form" @submit="submitForm">
          <div class="form-control">
            <ErrorMessage name="kcs_slide_title" class="kcs-err-msg"/>
            <Field type="text" id="kcs_slide_title" name="kcs_slide_title" :rules="validateTitle" v-model="sliderTitle" placeholder="Enter slider title ..."/>
          </div>
          <div class="kcs-button-wrap">
            <button class="button button-primary kcs-modal-form-button">Create Slider</button>
            <a class="btn-close" @click="kcsCloseModal">
              <span class="dashicons dashicons-no-alt"></span>
            </a>
          </div>
        </Form>
      </div>
    </div>
  </div>
</template>

<script>
import { Form, Field, ErrorMessage } from 'vee-validate';
import {mapActions, mapGetters} from "vuex";
import router from "../../routes";

export default {
  name: 'Main',
  data(){
    return{
      sliderTitle:''
    };
  },
  mounted(){
    this.fetchSliders()
  },
  components:{
    Form,
    Field,
    ErrorMessage,
  },
  computed:{
    ...mapGetters(['GET_SLIDERS','GET_LOADING_TEXT']),
    sliders:{
      get(){
        return this.GET_SLIDERS
      }
    },
    loadingText:{
      get(){
        return this.GET_LOADING_TEXT
      }
    },
    kcsMainPageStyle(){
      const wpMainBody = document.getElementById("wpbody");
      const wpMainBodyHeight = wpMainBody.offsetHeight;
      return {
        height: `${wpMainBodyHeight}px`
      }
    }
  },
  methods:{
    ...mapActions(['FETCH_SLIDERS','DELETE_SLIDER']),
    fetchSliders(){
      this.FETCH_SLIDERS()
    },
    submitForm(values){
      router.push({path:'/add',query:{title:this.sliderTitle}})
    },
    goToCreteSlider(){
      this.$refs.kcsModal.style.display = 'table';
    },
    kcsCloseModal(){
      this.$refs.kcsModal.style.display = 'none';
    },
    kcsDeleteSlider(event,id){
      let timerInterval;
      this.$swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result)=>{
        if (result.isConfirmed) {
          this.DELETE_SLIDER(id);
          this.$swal.fire({
            title: "Please Wait",
            text: "Deleting the slider ...!",
            didOpen: () => {
              this.$swal.showLoading();

              timerInterval = setInterval(() => {
                if (this.loadingText.status === 'success'){
                  clearInterval(timerInterval);
                  this.fetchSliders();
                  this.$swal.fire({
                    icon: 'success',
                    title: this.loadingText.message,
                    showConfirmButton: false,
                    timer: 1500
                  });
                }
              }, 100);

            }
          })
        }
      });
    },
    gotoSlider(event,id,title){
      router.push({path:'/add',query:{title:title,id:id}});
    },
    validateTitle(value){
      if (!value) {
        return 'This field is required';
      }
      return true;
    }
  }
}
</script>

<style>

</style>