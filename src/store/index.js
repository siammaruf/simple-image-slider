import {createStore} from "vuex";
import sliderModule from "./modules/sliderModule";

const store = createStore({
    modules:{
        sliderMod: sliderModule
    }
});

export default store;