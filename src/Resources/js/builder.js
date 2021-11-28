/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Select2 from 'v-select2-component';
import draggable from 'vuedraggable'

Vue.component('select2', Select2);
Vue.component('draggable', draggable);
Vue.component('builder-component', require('./components/BuilderComponent.vue').default);
Vue.component('buttons-component', require('./components/ButtonsComponent.vue').default);
Vue.component('element-modal-component', require('./components/ElementModalComponent.vue').default);

const app = new Vue({
    el: '#moduleBuilder',
    data: {
        module_builder_id: window.module_builder_id,
        language_id: window.language_id,
        trans: {},
        builderData: [],
        metaTags: [],
        current: {
            translation: false,
            element: null,
            type: null,
            name: null,
            parent_class: "col-lg-12",
            class: null,
            labels: {40: null, 164: null},
            rules: [],
            options: [
                {
                    key: null,
                    value: {
                        164: null,
                        40: null
                    }
                }
            ],
        },
        columns: [3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        elements: ['input', 'slug', 'textarea', 'select', 'checkbox', 'radio', 'media', 'country'],
        new_element: false,
    },
    mounted() {
        this.getBuilderData();
        this.getTranslations();

        var self = this;
        var elementModal = document.getElementById('elementModal')
        elementModal.addEventListener('hidden.bs.modal', function (event) {
           self.new_element = false;
        });
    },
    methods: {
        getBuilderData() {
            var self = this;
            axios.get('/dawnstar/module-builders/' + self.module_builder_id + '/getBuilderData')
                .then(function (response) {
                    self.builderData = response.data.builderData;
                    self.metaTags = response.data.metaTags;
                });

        },
        save() {
            var self = this;
            axios.put('/dawnstar/module-builders/' + self.$root.module_builder_id, {data: self.builderData, meta_tags: self.metaTags})
                .then(function (response) {
                    showMessage('success', '', response.data.success)
                    setTimeout(function () {
                        window.location.href = '/dawnstar/module-builders';
                    }, 1500)
                });
        },
        getTranslations() {
            var self = this;
            axios.get('/dawnstar/module-builders/getTranslations')
                .then(function (response) {
                    self.trans = response.data.translations;
                });
        }
    }

});
