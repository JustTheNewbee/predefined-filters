<template>
    <div>
        <bootstrap-filter-creator :form="form" v-if="stylization === 'bootstrap'" @create_predefined_filter="createFilter"></bootstrap-filter-creator>
        <semantic-filter-creator :form="form" v-if="stylization === 'semantic'" @create_predefined_filter="createFilter"></semantic-filter-creator>
    </div>
</template>

<script>

    import bootstrapFilterCreator from './bootstrapFilterCreator.vue';
    import semanticFilterCreator from './semanticFilterCreator.vue';
    import axios from 'axios';

    export default {
        name: "save-filter-component",
        props: {
            stylization: {
                type: String,
                required: true,
                default: 'bootstrap'
            },
            form: {
                type: String,
                required: true,
            }
        },
        components: {
            bootstrapFilterCreator,
            semanticFilterCreator
        },
        methods: {
            createFilter(predefinedFilterForm) {
                let data = predefinedFilterForm.getSerializedData();
                let filterName = predefinedFilterForm.getFilterName();

                if (filterName === '') {
                    predefinedFilterForm.setFilterNameRequired();
                    return;
                }

                axios.post('/filter/save', {
                    'filter_name': filterName,
                    'filter_data': JSON.stringify(Object.values(data)),
                    'filter_key': document.location.pathname,
                    'filter_url': document.location.pathname
                })
                    .then(response => {
                        if (!this.isEmpty(response.data)) {
                            this.$children[0].$refs.predefinedFilterForm.setErrors(response.data);
                        } else {
                            location.href = document.location.pathname;
                        }
                    })
                    .catch(exception => {
                        console.log(exception);
                    })
            },

            isEmpty(object) {
                for (let prop in object) {
                    return false;
                }

                return true
            }
        }
    }
</script>