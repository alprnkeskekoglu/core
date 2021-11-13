<template>
    <div>
        <draggable class="row g-2" v-model="$root.builderData" @start="drag=true" @end="drag=false" handle=".sortBtn">
            <div v-for="(data, key) in $root.builderData" :class="(data.parent_class ? data.parent_class : 'col-lg-12') + ' list-group-item border'">
                <div class="d-block">
                    <button type="button" class="btn btn-sm px-1 me-1 sortBtn"><i class="mdi mdi-18px mdi-arrow-all"></i></button>
                    <button type="button" class="btn btn-sm px-1 me-1" @click="showModal(key)">
                        <i class="mdi mdi-18px mdi-square-edit-outline"></i>
                    </button>
                    <button type="button" class="btn btn-sm px-1 me-1" @click="removeElement(key)">
                        <i class="mdi mdi-18px mdi-trash-can"></i>
                    </button>
                    <div class="dropdown d-inline">
                        <button class="btn btn-sm px-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-18px mdi-arrow-expand-horizontal"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button v-for="col in $root.columns" :class="'dropdown-item columnBtn ' + (data.parent_class == 'col-lg-' + col ? 'active' : '')" @click="changeParentClass(key, col)">{{ 'col-lg-' + col }}</button>
                        </div>
                    </div>
                    <div :class="'font-16 ' + (data.parent_class == 'col-lg-3' ? '' : 'float-end')" style="margin-top: .3rem">
                        {{ data.labels[$root.language_id] }}
                    </div>
                </div>
            </div>
        </draggable>

        <hr>

        <div class="form-floating">
            <select2 v-model="$root.metaTags" :options="meta_tag_options" :settings="{multiple: true}"/>
            <label>Meta Tags</label>
        </div>
    </div>
</template>

<script>
export default {
    name: "BuilderComponent",
    data() {
        return {
            meta_tag_options: [
                'robots', 'title', 'description', 'keywords', 'author',
                'og:title', 'og:description', 'og:image', 'og:url',
                'twitter:title', 'twitter:description', 'twitter:image', 'twitter:card',
            ]
        }
    },
    methods: {
        changeParentClass(key, col) {
            this.$root.builderData[key].parent_class = 'col-lg-' + col;
        },
        showModal(key) {
            this.$root.current = this.$root.builderData[key];
            var elementModal = new bootstrap.Modal(document.getElementById('elementModal'));
            elementModal.show();
        },
        removeElement(key) {
            this.$root.builderData.splice(key, 1);
        }
    }
}
</script>

<style>
    .form-floating > label {
        opacity: .65;
        -webkit-transform: scale(.85) translateY(-.5rem) translateX(.15rem);
        transform: scale(.85) translateY(-.5rem) translateX(.15rem);
    }

    .select2-selection--multiple {
        padding: .45rem 2.5rem .45rem .9rem;
    }
</style>
