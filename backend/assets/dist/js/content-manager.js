/*jshint esversion: 6 */
function contentManager(appId, options) {

    'use strict';

    const defaultOptions = {
        contentHub: {},
        marketIntelligence: {},
        competition: {},
        brands: {},
        corporates: {},
        sectors: {}
    };

    let {
        contentHub,
        marketIntelligence,
        competition,
        brands,
        corporates,
        sectors
    } = $.extend({}, defaultOptions, options || {});

    let level1 = [contentHub, marketIntelligence, competition];
    let level2 = [brands, corporates, sectors];
    let tree = [];
    level1.forEach(category => {
        let item = {data: {...category}, children: []};
        level2.forEach(subCategory => {
            let subItem = {data: {...subCategory}, children: []};
            item.children.push({...subItem});
        });
        tree.push({...item});
    });

    let treeItem = {
        template: '#tree-item-template',
        props: {
            model: Object,
            level: Number
        },
        data: function () {
            return {
                open: this.level === 1,
                newCategoryName: null,
                editMode: false
            };
        },
        computed: {
            isFolder() {
                return this.model.children;
            },
            count() {
                return this.model.children ? this.model.children.length : 0;
            }
        },
        methods: {
            toggle() {
                if (this.isFolder) {
                    this.open = !this.open;
                }
            },
            addChild() {
                this.model.children.push({
                    data: {
                        name: this.newCategoryName
                    }
                });
                this.newCategoryName = null;
            },
            edit() {
                if (this.level === 3) {
                    this.editMode = true;
                    this.$nextTick(() => {
                        setTimeout(() => {
                            let key = 'category-' + this.model.data.name;
                            this.$refs[key].focus();
                        }, 250);
                    });
                }
            },
            applyEdit() {
                this.editMode = false;
            }
        }
    };

    Vue.component('item', treeItem);
    let app = new Vue({
        el: appId,
        data() {
            return {
                tree
            };
        }
    });

}