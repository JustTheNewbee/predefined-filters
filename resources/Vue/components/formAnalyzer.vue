<template>
    <div>
        <form :class="classes.form" id="predefined-modal-form" v-if="!isCustomStyle">
            <div :class="classes.filter_name_row">
                <div :class="classes.filter_name_col">
                    <label for="filter-name" :class="classes.label">Filter Name</label>
                    <input type="text" id="filter-name" name="filter_name" :class="classes.input_text"
                           placeholder="Example: Loans issued today" autocomplete="off" required v-model="filterName">
                </div>
            </div>
            <div class="row" v-if="(classes.style === 'bootstrap') && isFilterNameRequired">
                <div class="col-md-12 form-group">
                <p class="help-block alert alert-danger">
                    Filter name is required
                </p>
                </div>
            </div>

            <div class="ui negative message" v-if="(classes.style === 'semantic') && isFilterNameRequired">
                <div class="header">Required</div>
                <p>Filter name is required</p>
            </div>

            <div v-if="classes.style === 'bootstrap'" v-for="calendar in calendars">
                <dynamic-datepicker
                        :name="calendar.name"
                        :value="calendar.value"
                        :placeholder="calendar.placeholder"
                ></dynamic-datepicker>
                <div class="row" v-if="calendar.error !== undefined">
                    <div class="col-md-12">
                        <p class="help-block alert alert-danger">
                            {{ calendar.error }}
                        </p>
                    </div>
                </div>
            </div>

            <div v-if="classes.style === 'semantic'" v-for="calendar in calendars">
                <dynamic-calendar
                        :name="calendar.name"
                        :value="calendar.value"
                        :placeholder="calendar.placeholder"
                ></dynamic-calendar>

                <div class="ui negative message" v-if="calendar.error !== undefined">
                    <div class="header">Error</div>
                    <p>{{ calendar.error }}</p>
                </div>
            </div>

        </form>

        <slot  v-else></slot>

    </div>
</template>

<script>
    import dynamicDatepicker from './dynamicDatepicker.vue';
    import dynamicCalendar from './dynamicCalendar.vue';
    import $ from 'jquery';

    export default {
        name: "form-analyzer",
        components: {
            dynamicCalendar,
            dynamicDatepicker
        },
        data() {
            return {
                calendars: [],
                filterName: '',
                selected: '',
                isFilterNameRequired: false
            }
        },
        props: {
            form: {
                type: String,
                required: true
            },
            classes: {
                type: Object,
                required: !this.isCustomStyle,
            },
            isCustomStyle: {
                type: Boolean,
                default: false
            },
        },
        mounted() {
            this.findDatepickers();
        },
        methods: {
            formattedLabel(label) {
                String.prototype.capitalize = function() {
                    return this.charAt(0).toUpperCase() + this.slice(1);
                };

                return label.replace(/_/g, ' ').capitalize();
            },

            getSerializedData() {

                let formData = this.prepareOriginalForm();
                let modalFormData = this.prepareModalData();

                this.combineFormsData(formData, modalFormData);
                return formData;

            },

            getFilterName() {
                return this.filterName;
            },

            prepareModalData() {
                let modalFormData = $('#predefined-modal-form').serializeArray();
                let resultFormData = {};
                modalFormData.forEach((field, index) => {
                    if (field.name.match(/_type$/i)) {
                        resultFormData[index - 1].type = field.value !== 'dynamic' ? 'fixed' : 'dynamic'
                    } else {
                        field.type = 'fixed';
                        resultFormData[index] = field;
                    }
                });

                return Object.values(resultFormData).filter((formElement) => {
                    return formElement.name !== 'filter_name';
                });
            },

            prepareOriginalForm() {
                let resultForm = {};
                let formData = $(this.form).serializeArray();
                formData.forEach((field, index) => {
                    resultForm[index] = field;
                    resultForm[index].type = 'fixed';
                });

                return resultForm;
            },

            combineFormsData (originalData, appendData) {
                let i = 0;
                while (i < appendData.length) {
                    for (let property in originalData) {
                        if (originalData[property].name === appendData[i].name) {
                            originalData[property] = appendData[i];
                            i++;
                            break;
                        }
                    }
                }
            },

            findDatepickers() {
                let self = this;
                $(this.form)
                    .find('.calendar.daterange_from, .calendar.daterange_to, .calendar.date, .calendar.time, ' +
                        '.calendar.datetime, .pol-datepicker')
                    .each(function (index, element) {
                        let dateType;
                        if ($(element).hasClass('datetime')) {
                            dateType = 'datetime';
                        } else if ($(element).hasClass('daterange_from')) {
                            dateType = 'daterange_from';
                        } else if ($(element).hasClass('daterange_to')) {
                            dateType = 'daterange_to';
                        } else {
                            dateType = 'date';
                        }

                        self.calendars.push({
                            'dateType': dateType,
                            'name': $(element).find('input:last').attr('name'),
                            'value': $(element).find('input:last').val(),
                            'placeholder': $(element).find('input:last').attr('placeholder')
                        });
                    });
            },

            setDatepickersValues() {
                let filteredDatepickers = $(this.form)
                    .find('.calendar.daterange_from, .calendar.daterange_to, .calendar.date, .calendar.time, ' +
                        '.calendar.datetime, #pol-datepicker');

                for (let index in this.calendars) {
                    let date = $(filteredDatepickers).find('input[name="' + this.calendars[index].name + '"]').val();
                    this.calendars[index].value  = date
                }
            },

            setFilterNameRequired() {
                this.isFilterNameRequired = true;
            },

            setErrors(errors) {
                let self = this;
                errors.forEach(error => {
                    self.calendars.forEach(calendar => {
                        if (calendar.name === error.name) {
                            self.$set(calendar, 'error', error.message);
                        }
                    })
                });

                console.log(this.calendars);
            }
        }

    }
</script>