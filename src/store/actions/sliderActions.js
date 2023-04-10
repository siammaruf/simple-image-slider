import Axios from "axios";
import router from "../../admin/routes";
import {baseApiUrl, apiHeader} from "../config";

const slides =  `${baseApiUrl}/cofixer/kcs/v1/sliders`;

const getSliders = async ({commit}, payload) => {
    commit('FETCHING')
    try {
        const response = await Axios.get(slides,{ headers: apiHeader });
        payload = response.data;
        commit('UPDATE_SLIDERS', payload)
        commit('FETCHED')
    }catch (e) {
        console.log(e.message)
    }
}

const postSliders = async ({commit}, payload) => {
    commit('SAVING');
    try {
        const data = {
            title: payload.sliderTitle,
            status: 'publish',
            meta : payload.meta.map(item=>item)
        };
        const response = await Axios.post(slides,data,{ headers: apiHeader });
        payload = response.data;
        router.push({
            path: '/add',
            query:{
                title: payload.post_title,
                id: payload.ID,
            }
        });
        commit( 'SAVED' )
    }catch (e) {
        console.log(e.message)
    }
}

const getSlideData = async ({commit}, payload) => {
    commit('FETCHING')
    try {
        const response = await Axios.get(`${slides}/${payload}`,{ headers: apiHeader });
        payload = response.data;
        commit('UPDATE_SLIDER', payload);
        commit('FETCHED')
    }catch (e) {
        console.log(e.message)
    }
}

const updateSlide = async ({commit}, payload) => {
    commit('UPDATING_TEXT');
    try {
        const data = {
            title: payload.sliderTitle,
            status: 'publish',
            meta : payload.meta.map(item=>item)
        };
        const response = await Axios.put(`${slides}/${payload.id}`,data,{ headers: apiHeader });
        if (response){
            commit( 'UPDATE_TEXT' )
        }
    }catch (e) {
        console.log(e.message)
    }
}

const deleteSlider = async ({commit}, payload) =>{
    commit('DELETING_TEXT');
    try {
       await Axios.delete(`${slides}/${payload}`,{ headers: apiHeader });
       commit('DELETE_TEXT');
    }catch (e) {
        console.log(e.message)
    }
}

const sliderActions = {
    FETCH_SLIDERS: getSliders,
    SAVE_SLIDER: postSliders,
    FETCH_SLIDER: getSlideData,
    UPDATE_SLIDER_DATA: updateSlide,
    DELETE_SLIDER: deleteSlider
};

export default sliderActions;