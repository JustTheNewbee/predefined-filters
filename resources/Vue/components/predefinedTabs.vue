<template>
    <div>
        <bootstrap-tabs :tabs="loadedTabs" v-if="stylization === 'bootstrap'" :deletable="deletable" @delete_filter_by_id="deleteFilter">
            <slot></slot>
        </bootstrap-tabs>
        <semantic-tabs :tabs="loadedTabs" v-if="stylization === 'semantic'" :deletable="deletable" @delete_filter_by_id="deleteFilter">
            <slot></slot>
        </semantic-tabs>
    </div>

</template>

<script>
    import axios from 'axios';
    import bootstrapTabs from './bootstrapTabs.vue';
    import semanticTabs from './semanticTabs.vue';

    export default {
        name: "predefined-tab",
        components: {
            bootstrapTabs,
            semanticTabs
        },
        data() {
            return {
                loadedTabs: [],
            }
        },
        props: {
            filter_url: {
                required: true
            },
            filter_key: {
                required: false
            },
            stylization : {
                type: String,
                required: true,
            },
            deletable: {
                type: Boolean,
                default: false
            }

        },
        mounted() {
            this.loadTabs();
        },
        updated() {
            this.$nextTick(function () {
                this.setActiveTab();
                this.addRemoveIconToActiveTab();
            });
        },
        methods: {
            loadTabs() {
                axios.post('/filter/tabs', {
                    url: this.filter_url
                })
                    .then(response => {
                        this.bindData(response)
                    })
                    .catch(e => {
                        console.log(e)
                    });
            },
            bindData(response)
            {

                for (let i = 0; i< response.data.length; i++) {
                    this.loadedTabs.push(response.data[i]);
                }
            },

            setActiveTab() {
                let tabularMenu = this.$children[0];
                let self = this;
                tabularMenu.$el.querySelectorAll('.item, .nav-link').forEach(function (link, index) {
                    let linkUrl  = new URL(link.getAttribute('href'), document.baseURI);

                    if (self.isUrlEqualsLink(linkUrl.hash)) {
                        self.addActiveClassTo(link);
                    } else {
                        self.removeActiveClassFrom(link);
                    }
                });

                if (self.isTabularMenuHasActiveTabs()) {
                    self.addActiveClassToFirstLink()
                }
            },

            addActiveClassTo(link) {
                link.classList.add('active');
            },

            removeActiveClassFrom(link) {
                link.classList.remove('active');
            },

            isTabularMenuHasActiveTabs() {
                let tabularMenu = this.$children[0];
                return tabularMenu.$el.querySelectorAll('.item.active, .nav-link.active').length === 0;
            },

            addActiveClassToFirstLink() {
                let tabularMenu = this.$children[0];
                tabularMenu.$el.querySelector('.item, .nav-link').classList.add('active');
            },

            isUrlEqualsLink(address) {
                let route = window.location;
                return route.hash === address;
            },

            addRemoveIconToActiveTab() {
                let self = this;
                let activeTab = {
                    getActiveTab() {
                        let tabularMenu = self.$children[0];
                        return tabularMenu.$el.querySelector('.item.active>i, .nav-link.active>i');
                    },
                };

                if (activeTab.getActiveTab() !== null) {
                    activeTab.getActiveTab().removeAttribute('hidden');
                }
            },

            deleteFilter(tab) {
                if (confirm('Are you sure you want to delete this filter?')) {
                    axios.post('/filter/delete/' + tab.id)
                        .then(() => {
                            let tabIndex = this.loadedTabs.indexOf(tab);
                            this.loadedTabs.splice(tabIndex, 1);

                        })
                        .catch(e => {
                            console.log(e)
                        });
                }
            }
        },
    }
</script>