<template>
    <div>
        <a class="item" href="#0"><i class="plus icon" @click.prevent="showFilterModal()"></i></a>
        <modal :opened="showModal" ref="predefinedFilterModal" :modal-variation="modalVariation" show-close-icon>

            <div slot="header">Create new predefined filter</div>

            <div slot="content">
                <form-analyzer ref="predefinedFilterForm" :form="form" :classes="getClasses"></form-analyzer>
            </div>

            <template slot="actions">
                <div class="ui secondary button" @click="closeModal">
                    Cancel
                </div>
                <div class="ui positive right button" @click.prevent="createFilter">
                    Save changes
                </div>
            </template>

        </modal>
    </div>
</template>

<script>
    import modal from 'vue-semantic-modal';
    import formAnalyzer from './formAnalyzer.vue';

    export default {
        name: "semantic-filter-creator",
        components: {
            modal,
            formAnalyzer
        },
        props: {
            form: {
                type: String,
                required: true
            }
        },
        computed: {
            getClasses() {
                return {
                    form: 'ui form',
                    filter_name_row: 'one wide fields',
                    filter_name_col: 'sixteen wide field',
                    label: '',
                    input_text: 'ui input',
                    datepicker_row: 'two columns fields',
                    date_col: 'field',
                    date_type_col: 'field',
                    select_type: 'ui fluid selection dropdown',
                    style: 'semantic'
                }
            }
        },
        data() {
            return {
                showModal: false,
                modalVariation: 'small',
            }
        },
        mounted() {
            $('.ui.modal').css('overflow', 'visible');
        },
        methods: {
            showFilterModal() {

                let self = this;

                self.$refs.predefinedFilterForm.setDatepickersValues();
                $('.modal').modal({
                    context: this.form,
                    onShow() {
                        let calendars = self.$refs.predefinedFilterForm.$children;
                        calendars.forEach(calendar => {
                            calendar.initializeCalendar();
                        });
                    },
                    onApprove() {
                        return false;
                    }
                })
                    .modal('show');

            },
            createFilter() {
                this.$emit('create_predefined_filter', this.$refs.predefinedFilterForm);
            },
            closeModal() {
                $('.modal:first').modal('hide');
            }
        }
    }
</script>