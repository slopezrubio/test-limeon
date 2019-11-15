import "core-js/stable";
import "regenerator-runtime/runtime";
import Vue from 'vue';

Vue.component('job-log-form', require('./components/JobLogForm.vue').default);
Vue.component('job-list', require('./components/JobList.vue').default);

const app = new Vue({
    el: '#app'
});