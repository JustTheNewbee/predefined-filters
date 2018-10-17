<template>
    <div>
        <!-- Button trigger modal -->
        <li class="nav-item" role="presentation"><a class="nav-link" href="#0" @click.prevent="showModal"><i class="fa fa-plus"></i></a></li>
       <bootstrap-modal ref="predefinedFilterModal" title="Create new predefined filter" @ok.prevent="createFilter">
           <form-analyzer ref="predefinedFilterForm" :form="form" :classes="getClasses"></form-analyzer>
       </bootstrap-modal>
    </div>
</template>

<script>
    import bootstrapModal from 'bootstrap-vue/es/components/modal/modal';
    import bootstrapModalDirective from 'bootstrap-vue/es/directives/modal/modal';
    import formAnalyzer from './formAnalyzer.vue';

    export default {
        name: "bootstrap-filter-creator",
        components: {
            'bootstrap-modal': bootstrapModal,
            'form-analyzer': formAnalyzer,
        },
        directives: {
            'bootstrap-modal': bootstrapModalDirective
        },
        props: {
            form: {
                type: String,
                required:true,
            }
        },
        computed: {
            getClasses() {
                return {
                    form: '',
                    filter_name_row: 'row',
                    filter_name_col: 'col-md-12 form-group form-material',
                    label: 'control-label',
                    input_text: 'form-control',
                    datepicker_row: 'row',
                    date_col: 'col-md-6 form-group form-material',
                    date_type_col: 'col-md-6',
                    select_type: 'form-control',
                    style: 'bootstrap'
                }
            }
        },
        methods: {
            createFilter() {
                this.$emit('create_predefined_filter', this.$refs.predefinedFilterForm);
            },

            showModal() {
                this.$refs.predefinedFilterForm.setDatepickersValues();
                this.$refs.predefinedFilterModal.show();
            },

        }
    }
</script>