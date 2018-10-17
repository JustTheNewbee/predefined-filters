import Vue from 'vue';
import SuiVue from 'semantic-ui-vue';
import 'semantic-ui-css/semantic.min.css';

import predefinedTabs from './components/predefinedTabs.vue';
import saveFilterComponent from './components/saveFilterComponent.vue';

Vue.use(SuiVue);

Vue.config.devtools=true;

new Vue({
    el: '#predefined-filters',
    components: {
        'save-filter-component': saveFilterComponent,
        'predefined-tab': predefinedTabs,
   }
});