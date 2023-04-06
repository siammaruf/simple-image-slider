<template>
  <div id="kcs-add-slider-container">
    <div class="kcs-page-title kcs-d-flex">
      <router-link to="/" class="kcs-back-btn"><span class="dashicons dashicons-arrow-left-alt"></span></router-link>
      <h2>Create Slide : {{this.kcsTitle}}</h2>
      <input type="hidden" v-model="kcsTitle">
    </div>
    <div class="kcs-slide-items-wrap">
      <div class="slide-item" v-for="field in fields" key="field.id">
        <div class="slide-item-wrap" v-bind:style="{'backgroundImage':`url(${field.imgLink})`,'backgroundSize':'cover'}">
          <div class="slide-item-holder">
            <span class="kcs-sub-title">{{field.subTitle}}</span>
            <span class="kcs-title">{{field.title}}</span>
            <span class="kcs-btn">{{field.btnText}}</span>
          </div>
          <a class="kcs-delete-btn" @click="kcsDeleteSlide($event, field.id)">
            <span class="dashicons dashicons-trash"></span>
          </a>
        </div>
      </div>
      <div class="slide-item kcs-create-slide-btn">
        <div @click="kcsOpenModal" class="kcs-create-slide-btn-wrap kcs-d-flex kcs-text-align-center">
          <div class="btn-text">
            <span class="dashicons dashicons-insert"></span>
            Add Slide
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="kcs-save-slider-btn-wrap" v-if="this.fields.length >= 2">
    <a class="button button-primary" @click="kcsSaveSlider">Save / Create Slider</a>
  </div>
  <div class="kcs-form-modal" ref="kcsModal">
    <div class="modal-container">
      <div class="modal-content-holder">
        <Form class="kcs-modal-form" @submit="saveSlider">
          <div class="kcs-row">
            <div class="kcs-col kcs-left-col">
              <div class="kcs-add-slide-form-holder">
                <div class="form-control">
                  <ErrorMessage name="kcs_slide_title" class="kcs-err-msg"/>
                  <Field type="text" id="kcs_slide_title" name="kcs_slide_title" :rules="titleValidate" v-model="formData.kcsSliderTitle" placeholder="Enter title ..."/>
                </div>
                <div class="form-control">
                  <ErrorMessage name="kcs_slide_sub_title" class="kcs-err-msg"/>
                  <Field type="text" id="kcs_slide_sub_title" :rules="subTitleValidate" name="kcs_slide_sub_title" v-model="formData.kcsSliderSubTitle" placeholder="Enter sub title ..."/>
                </div>
                <div class="form-control">
                  <Field type="text" id="kcs_slide_btn_text" name="kcs_slide_btn_text" v-model="formData.kcsSliderBtnText" placeholder="Enter button title ..."/>
                </div>
                <div class="form-control">
                  <Field type="url" id="kcs_slide_btn_link" name="kcs_slide_btn_link" v-model="formData.kcsSliderBtnLink" placeholder="Enter button link ..."/>
                </div>
              </div>
            </div>
            <div class="kcs-col kcs-right-col">
              <ErrorMessage name="kcs_slider_image" class="kcs-err-msg"/>
              <div class="kcs-add-slide-image-holder">
                <a @click="selectImage($event, this.formData)" class="kcs-add-image-btn" v-bind:style="{'backgroundImage':`url(${this.formData.kcsSliderImage})`,'backgroundSize':'cover'}">Add Image</a>
                <Field type="hidden" id="kcs_slider_image" name="kcs_slider_image" :rules="imgValidate" v-model="formData.kcsSliderImage" />
              </div>
            </div>
          </div>
          <div class="kcs-button-wrap">
            <button class="button button-primary kcs-modal-form-button">Add Slide</button>
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
import {selectImage} from "../../methods/selectImage";
import {mapActions, mapGetters, useStore} from "vuex";

export default {
  name: 'AddSlider',
  data(){
    return{
      fields: [],
      formData:{},
      kcsTitle: this.$route.query.title,
    }
  },
  mounted() {
    this.fetchSlider();
  },
  created(){
    const store = useStore();
    store.subscribe((mutation, state) => {
      this.fields = state.sliderMod.slider.slides;
    })
  },
  components:{
    Form,
    Field,
    ErrorMessage,
  },
  computed:{
    ...mapGetters(["GET_SLIDER","GET_LOADING_TEXT"]),
    getSlides:{
      get(){
        return this.GET_SLIDER
      }
    },
    loadingText:{
      get(){
        return this.GET_LOADING_TEXT
      }
    }
  },
  methods:{
    ...mapActions(["SAVE_SLIDER","FETCH_SLIDER","UPDATE_SLIDER_DATA"]),
    saveSlider(value){
      this.fields.push(
          {
            id: this.fields.length+1,
            title: this.formData.kcsSliderTitle,
            subTitle: this.formData.kcsSliderSubTitle,
            btnText: this.formData.kcsSliderBtnText,
            btnLink: this.formData.kcsSliderBtnLink,
            imgLink: this.formData.kcsSliderImage,
          }
      );
      this.$refs.kcsModal.style.display = 'none';
      this.formData = {};
    },
    selectImage,
    kcsOpenModal(){
      this.$refs.kcsModal.style.display = 'table';
    },
    kcsCloseModal(){
      this.$refs.kcsModal.style.display = 'none';
      this.formData = {};
    },
    kcsSaveSlider(){
      let timerInterval;
      const sliderData = {
        sliderTitle: this.kcsTitle,
        meta: this.fields
      };
      this.$swal.fire({
        title: "Please Wait",
        text: "Saving the slider ...!",
        didOpen: () => {
          this.$swal.showLoading();
          if (this.$route.query.id === undefined){
            this.SAVE_SLIDER(sliderData)
          }else{
            sliderData.id = this.$route.query.id;
            this.UPDATE_SLIDER_DATA(sliderData)
          }

          timerInterval = setInterval(() => {
            if (this.loadingText.status === 'success'){
              clearInterval(timerInterval);
              this.$swal.fire({
                icon: 'success',
                title: this.loadingText.message,
                showConfirmButton: false,
                timer: 1500
              });
            }
          }, 100);

        }
      });
    },
    fetchSlider(){
      if (this.$route.query.id !== undefined){
        this.FETCH_SLIDER(this.$route.query.id)
      }
    },
    kcsDeleteSlide(event, id){
      const found = this.fields.find( obj => obj.id === id);
      const index = this.fields.indexOf(found);
      if (index > -1){
        this.fields.splice(index,1)
      }
    },
    titleValidate(value){
      if (!value) {
        return 'Title field is required !';
      }
      return true;
    },
    imgValidate(value){
      if (!value) {
        return 'Please select a slide image !';
      }
      return true;
    },
    subTitleValidate(value){
      if (!value) {
        return 'Subtitle field is required !';
      }
      return true;
    }
  }
}
</script>
<style>

</style>