import './styles/main.scss';
import Vue from 'vue';

import './components/debug';

new Vue( {
    el: '#app',
    components: {
        debugPanel: debugPanel
    },
} );