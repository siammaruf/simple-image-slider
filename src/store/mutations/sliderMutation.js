const sliderMutations = {
    UPDATE_SLIDERS:( state, payload ) => {
        state.sliders = payload
    },
    UPDATE_SLIDER:( state, payload ) => {
        state.slider = payload
    },
    SAVED: ( state ) => {
        state.loadingText = {
            status:'success',
            message: 'Saved successfully !'
        };
    },
    SAVING: ( state )=>{
        state.loadingText = {
            status:'pending',
            message: 'Please wait! Saving ...'
        };
    },
    UPDATE_TEXT: ( state ) => {
        state.loadingText = {
            status:'success',
            message: 'Updated successfully !'
        };
    },
    UPDATING_TEXT: ( state )=>{
        state.loadingText = {
            status:'pending',
            message: 'Please wait! Updating ...'
        };
    },
    DELETING_TEXT:( state ) => {
        state.loadingText = {
            status:'pending',
            message: 'Please wait! Deleting ...'
        };
    },
    DELETE_TEXT:( state ) => {
        state.loadingText = {
            status:'success',
            message: 'Deleted successfully !'
        };
    }
}

export default sliderMutations;