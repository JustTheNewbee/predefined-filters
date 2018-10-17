<template>
    <ul class="nav nav-tabs nav-tabs-line">

        <li class="nav-item" v-for="tab in tabs" role="presentation">
            <a class="nav-link" :href="tab.url" @click="filter">{{ tab.name }}
                <i v-if="canDelete(tab)" class="fa fa-times" @click="deleteFilter(tab)" style="padding-left: 10px"
                   hidden></i>
            </a>
        </li>
        <slot></slot>
    </ul>
</template>

<script>
    import polDatepicker from '../../../../../../resources/assets/js/components/form/polDatepicker.vue'

    const DEFAULT_TAB_NAME = 'Filters';

    export default {
        name: "bootstrap-tabs",
        components: {
            polDatepicker
        },
        props: {
            tabs: {
                type: Array,
                default: [],
            },
            deletable: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            deleteFilter(tab) {
                this.$emit('delete_filter_by_id', tab)
            },

            filter(event) {
                window.location.href = event.target.href;
                window.location.reload();
            },

            canDelete(tab) {
                let self = this;
                let deletableTab = {
                    isDeletable() {
                        return self.deletable;
                    },
                    isNotDefaultTab() {
                        return tab.name !== DEFAULT_TAB_NAME;
                    }

                };
                return deletableTab.isDeletable() && deletableTab.isNotDefaultTab();
            }
        }
    }
</script>