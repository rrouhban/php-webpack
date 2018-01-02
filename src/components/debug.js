const debugPanel = Vue.component('debug-panel', {
    template: '#debug-panel-template',
    data() {
        return {
            debugPanelOpen: false
        }
    },
    methods: {
        togglePanel() {
            this.debugPanelOpen = !this.debugPanelOpen;
        }
    }
});