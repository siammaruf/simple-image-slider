import sliderActions from "../actions/sliderActions";
import sliderMutations from "../mutations/sliderMutation";
import sliderGetters from "../getters/sliderGetters";

const sliderModule = {
    namespace: true,
    state:{
        sliders:[],
        loadingText: {},
        slider:{}
    },
    actions: sliderActions,
    mutations: sliderMutations,
    getters: sliderGetters
}

export default sliderModule;