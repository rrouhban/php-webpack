import '@/styles/main.scss';
import App from '@/components/App.vue';
import Vue from 'vue';


new Vue( {
    el: '#app',
    render: h => h(App)
} );