<template>
    <div>
        <div class="row" >
            <div class="col-md-6 form-group form-material" v-if="selected === 'dynamic'">
                <label :for="name" class="control-label" v-text="formattedLabel"></label>
                <input type="text" class="form-control" :value="value" :placeholder="placeholder" :name="name" autocomplete="off">
            </div>

            <div class="col-md-6 form-group form-material" v-else>
                <label :for="name" class="control-label" v-text="formattedLabel"></label>
                <pol-datepicker
                        :name="name"
                        :value="value"
                        :placeholder="placeholder"
                ></pol-datepicker>
            </div>

            <div class="col-md-6 form-group form-material">
                <label class="control-label">Date Type</label>
                <select class="form-control" v-model="selected" :name="name + '_type'">
                    <option value="">-- Type --</option>
                    <option value="fixed">Fixed</option>
                    <option value="dynamic">Dynamic</option>
                </select>
            </div>
        </div>
        <div class="row" v-if="selected === 'dynamic'">
            <div class="col-md-12">
                <p class="help-block alert alert-info">
                    <strong>Example: +1 week 2 days, now, last Monday, <a href="http://php.net/manual/en/function.strtotime.php">Details...</a></strong>
                </p>
            </div>
        </div>
    </div>

</template>

<script>
    import polDatepicker from "../../../../../../resources/assets/js/components/form/polDatepicker.vue";

    export default {
        name: "dynamic-datepicker",
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
            }
        },
        data() {
            return {
                selected: ''
            }
        },
        components: {
            polDatepicker
        },
        computed: {
            formattedLabel: function() {
                String.prototype.capitalize = function() {
                    return this.charAt(0).toUpperCase() + this.slice(1);
                };

                return this.name.replace(/_/g, ' ').capitalize();
            },
        },
    }
</script>