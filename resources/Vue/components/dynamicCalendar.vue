<template>
    <div>
        <div class="two wide fields" >
            <div class="field" v-if="selected === 'dynamic'">
                <label :for="name" v-text="formattedLabel"></label>
                <input type="text" class="ui input" :value="value" :placeholder="placeholder" :name="name" autocomplete="off">
            </div>

            <div class="field" v-else>
                <label :for="name" v-text="formattedLabel"></label>
                <div :class="dateClass">
                    <input type="text" :name="name" autocomplete="off" :value="value" :placeholder="placeholder">
                </div>
            </div>

            <div class="field">
                <label>Date Type</label>
                <select class="ui fluid selection dropdown" v-model="selected" :name="name + '_type'">
                    <option value="">-- Type --</option>
                    <option value="fixed">Fixed</option>
                    <option value="dynamic">Dynamic</option>
                </select>
            </div>
        </div>

        <div class="ui info message" v-if="selected === 'dynamic'">
            <div class="header">Info</div>
            <p>Example: +1 week 2 days, now, last Monday, <a href="http://php.net/manual/en/function.strtotime.php">Details...</a></p>
        </div>

    </div>
</template>

<script>
    export default {
        name: "dynamic-calendar",
        props: {
            name: {
                type: String,
                default: ''
            },
            value: {
                type: String,
                default: ''
            },
            placeholder: {
                type: String,
                default: '',
                required: false
            },
            dateType: {
                type: String,
                default: 'date'
            }
        },
        data() {
            return {
                selected: ''
            }
        },
        mounted() {
            this.selected = 'dynamic';
            this.selected = '';
            $(this.$el).find('.calendar').calendar('set date', this.value);
        },
        created() {
            if (this.selected !== 'dynamic') {
                this.initializeCalendar();
            }
        },
        updated() {
            if (this.selected !== 'dynamic') {
                this.initializeCalendar();
            }
        },
        computed: {
            formattedLabel: function() {
                String.prototype.capitalize = function() {
                    return this.charAt(0).toUpperCase() + this.slice(1);
                };

                return this.name.replace(/_/g, ' ').capitalize();
            },

            dateClass() {
                return 'ui calendar ' + this.dateType;
            }
        },
        methods: {
            initializeCalendar() {
                if (this.dateType === 'time') {
                    $(this.$el).calendar({ type: 'time'});
                } else if (this.dateType === 'datetime') {
                    $(this.$el).calendar({ type: 'datetime'});
                } else if (this.dateType === 'date') {
                    $(this.$el).calendar({ type: 'date'});
                } else {
                    $(this.$el).calendar({
                        type: 'date',
                        endCalendar: $('.daterange_to'),
                        formatter: {
                            date: function (date, settings) {
                                if (!date) return '';

                                return date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
                            }
                        }
                    });
                }
            }
        }
    }
</script>