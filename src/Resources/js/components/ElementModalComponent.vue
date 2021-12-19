<template>
    <div class="modal fade" id="elementModal" tabindex="-1" aria-labelledby="elementModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12" v-if="['relation', 'category'].indexOf($root.current.element) === -1">
                                <label class="form-label">{{ $root.trans.translation }}</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="translation_1" class="form-check-input" v-model="$root.current.translation" value="true">
                                        <label class="form-check-label" for="translation_1">{{ $root.trans.yes }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="translation_0" class="form-check-input" v-model="$root.current.translation" value="false">
                                        <label class="form-check-label" for="translation_0">{{ $root.trans.no }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="element" v-model="$root.current.element">
                                        <option v-for="element in $root.elements" :value="element">{{ element }}</option>
                                    </select>
                                    <label for="element">Element</label>
                                </div>
                            </div>
                            <div class="col-lg-6" v-if="types[$root.current.element] != undefined">
                                <div class="form-floating mb-3">
                                    <select :class="'form-select ' + (errors.type ? 'is-invalid' : '')" id="type" v-model="$root.current.type">
                                        <option v-for="type in types[$root.current.element]" :value="type">{{ type }}</option>
                                    </select>
                                    <label for="type">{{ $root.trans.type }}</label>
                                    <div class="invalid-feedback d-block" v-if="errors.type">
                                        {{ $root.trans.required }}
                                    </div>
                                </div>
                            </div>

                            <div :class="types[$root.current.element] != undefined ? 'col-ld-12' : 'col-lg-6'">
                                <div class="form-floating mb-3">
                                    <input type="text" :class="'form-control ' + (errors.name ? 'is-invalid' : '')"
                                           :disabled="['category'].indexOf($root.current.element) !== -1"
                                           id="name"
                                           v-model="$root.current.name">
                                    <label for="name">{{ $root.trans.name }}</label>
                                    <div class="invalid-feedback d-block" v-if="errors.name">
                                        {{ $root.trans.required }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="parent_class" v-model="$root.current.parent_class">
                                        <option v-for="col in $root.columns" :value="'col-lg-' + col">{{ 'col-lg-' + col }}</option>
                                    </select>
                                    <label for="parent_class">{{ $root.trans.col }}</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="class" v-model="$root.current.class">
                                    <label for="class">Class</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="label_tr" v-model="$root.current.labels[164]">
                                    <label for="label_tr">{{ $root.trans.label }} (TR)</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="label_en" v-model="$root.current.labels[40]">
                                    <label for="label_en">{{ $root.trans.label }} (EN)</label>
                                </div>
                            </div>
                            <div class="col-lg-6" v-if="$root.current.element === 'media'">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="max_count" min="0" v-model="$root.current.max_count">
                                    <label for="max_count">{{ $root.trans.max_count }}</label>
                                </div>
                            </div>
                            <div class="col-lg-6" v-if="$root.current.element === 'media'">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="selectable" v-model="$root.current.selectable">
                                        <option v-for="type in ['image', 'file', 'audio', 'video']" :value="type">{{ type }}</option>
                                    </select>
                                    <label for="selectable">{{ $root.trans.selectable }}</label>
                                </div>
                            </div>
                            <div class="col-lg-12" v-if="$root.current.element !== 'media'">
                                <div class="form-floating mb-3">
                                    <select2 v-model="$root.current.rules" :options="$root.current.rules" :settings="{multiple: true, tags: true}"/>
                                    <label>{{ $root.trans.rules }}</label>
                                </div>
                            </div>
                        </div>

                        <hr v-if="['select', 'checkbox', 'radio', 'relation'].indexOf($root.current.element) !== -1">

                        <div class="row" v-if="['select', 'checkbox', 'radio'].indexOf($root.current.element) !== -1">
                            <div class="col-lg-12">{{ $root.trans.options }}</div>
                            <div class="col-lg-12 mb-2" v-for="(option, key) in $root.current.options">
                                <div class="row gx-1">
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" v-model="option.key" placeholder="Key">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" v-model="option.value[164]" placeholder="Value (TR)">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" v-model="option.value[40]" placeholder="Value (EN)">
                                    </div>
                                    <div class="col-lg-3 align-self-center text-end">
                                        <button type="button" class="btn btn-sm btn-primary" @click="addNewOption">
                                            <i class="mdi mdi-18px mdi-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" @click="removeOption(key)" v-if="$root.current.options.length > 1">
                                            <i class="mdi mdi-18px mdi-window-close"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="['relation'].indexOf($root.current.element) !== -1">
                            <div class="col-lg-12">{{ $root.trans.queries }}</div>
                            <div class="col-lg-12 mb-2" v-for="(query, key) in $root.current.queries">
                                <div class="row gx-1">
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" v-model="query[0]" placeholder="Column">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" v-model="query[1]" placeholder="Condition">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" v-model="query[2]" placeholder="Value">
                                    </div>
                                    <div class="col-lg-3 align-self-center text-end">
                                        <button type="button" class="btn btn-sm btn-primary" @click="addNewQuery">
                                            <i class="mdi mdi-18px mdi-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" @click="removeQuery(key)" v-if="$root.current.queries.length > 1">
                                            <i class="mdi mdi-18px mdi-window-close"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="saveElement">{{ $root.trans.save }}</button>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>

export default {
    name: "ElementModalComponent",
    data() {
        return {
            errors: {},
            types: {
                'input': ['text', 'number', 'date', 'datetime', 'color'],
                'textarea': ['default', 'ckeditor'],
                'select': ['single', 'multiple'],
                'country': ['single', 'multiple'],
            },
        }
    },
    methods: {
        addNewOption() {
            this.$root.current.options.push({key: null, value: {164: null, 40: null}})
        },
        removeOption(key) {
            this.$root.current.options.splice(key, 1)
        },
        addNewQuery() {
            this.$root.current.queries.push({0: null, 1: null, 2: null})
        },
        removeQuery(key) {
            this.$root.current.queries.splice(key, 1)
        },
        saveElement() {
            if(this.checkForm()) {
                if(this.$root.new_element) {
                    this.$root.builderData.push(this.$root.current);
                }

                document.querySelector('[data-bs-dismiss="modal"]').click();
                this.errors = {};
                this.$root.current = {
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
                    queries: [
                        {
                            0: null,
                            1: null,
                            2: null
                        }
                    ],
                };
            } else {
                alert('HATA');
            }
        },
        checkForm() {
            this.errors = {}

            if(!this.$root.current.type && this.$root.current.element == 'input') {
                this.errors['type'] = true;
            }
            if(!this.$root.current.name && ['category'].indexOf(this.$root.current.element) === -1) {
                this.errors['name'] = true;
            }

            return Object.keys(this.errors).length === 0;
        }
    }
}
</script>
