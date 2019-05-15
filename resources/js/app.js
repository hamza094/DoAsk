
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

require('./bootstrap');

import InstantSearch from 'vue-instantsearch';
Vue.use(InstantSearch);

import VModal from 'vue-js-modal';

Vue.use(VModal)

import moment from 'moment';

import { Form, HasError, AlertError } from 'vform';

window.Form=Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.filter('upText',function(text){
     return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate',function(created){
   return moment(created).format("MMM Do YY");  
});

let Highlighter=require('highlight.js');
import 'highlight.js/styles/github.css';

Vue.prototype.highlight= function (block){
    if(!block) return;
    block.querySelectorAll('pre').forEach(function(node){
        Highlighter.highlightBlock(node);
    });
}


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('thread-view', require('./pages/Thread.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('notifications', require('./components/Notifications.vue').default);
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);
Vue.component('wysiwyg', require('./components/Wysiwyg.vue').default);
Vue.component('channel', require('./components/Channel.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
//Vue.component('channel-dropdown', require('./components/ChannelDropdown.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('register', require('./components/Register.vue').default);
Vue.component('recaptcha', require('./components/Recaptcha.vue').default);
Vue.component('thread-wysiwg', require('./components/ThreadWysiwyg.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});



