<template>
    <div class="ui top attached tabular menu">
        <a v-for="tab in tabs" class="item" v-bind:class="" v-bind:href="tab.url">{{tab.name}}<i v-if="canDelete(tab)" class="close icon" @click="deleteFilter(tab)" style="padding-left: 10px" hidden></i></a>
        <slot></slot>
    </div>
</template>

<script>

    const DEFAULT_TAB_NAME = 'Filters';

    export default {
        name: "semantic-tabs",
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