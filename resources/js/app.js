require('./bootstrap');
require("materialize-css");
const swal = require('sweetalert')
window.Vue = require('vue')
Vue.component('users', require("./components/users").default);

const app = new Vue({
    el: '#app'
});