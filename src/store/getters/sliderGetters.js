const sliderGetters = {
    GET_SLIDERS:(state) => {
        return state.sliders
    },
    GET_SLIDER:(state) => {
        return state.slider
    },
    GET_LOADING_TEXT: ( state ) => {
        return state.loadingText;
    },
}

export default sliderGetters;