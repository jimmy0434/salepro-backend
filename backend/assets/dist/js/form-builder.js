/*jshint esversion: 6 */
function formBuilder(appId, options) {

    'use strict';

    const defaultOptions = {
        form: null
    };

    options = $.extend({}, defaultOptions, options || {});

    const TYPES = Object.freeze({
        TEXT: Symbol('text'),
        TEXT_AREA: Symbol('textarea'),
        DROP_DOWN_LIST: Symbol('dropdownlist'),
        CHECKBOX: Symbol('checkbox'),
        RADIO: Symbol('radio'),
        SUB_FORM: Symbol('subform')
    });

    const SEPARATOR = 'separator';

    let FormItemComponent = {
        // template ID
        template: '#form-item',
        props: ['structure'],
        data() {
            return {
                list: {
                    name: this.structure.name,
                    isRoot: this.structure.isRoot,
                    fields: []
                }
            };
        },
        computed: {
            types() {
                return TYPES;
            },
            separator() {
                return SEPARATOR;
            },
            self() {
                return this;
            },
            fields(){
                return this.list.fields;
            }
        },
        filters: {
            typeName(value) {
                return value.toLowerCase().replace(/_/g, ' ');
            }
        },
        methods: {
            addField(name) {
                if (name === SEPARATOR) {
                    this.list.fields.push(name);
                } else if (name === TYPES.SUB_FORM) {
                    this.list.fields.push({
                        type: TYPES.SUB_FORM,
                        isRoot: false,
                        name: null,
                        fields: []
                    });
                } else {
                    let data = {
                        name: null,
                        label: null,
                        note: null,
                        type: name
                    };
                    if (name === TYPES.TEXT || name === TYPES.TEXT_AREA) {
                        data.placeholder = null;
                        data.required = false;
                        data.validation = null;
                    }
                    if (name === TYPES.DROP_DOWN_LIST || name === TYPES.RADIO) {
                        data.options = [
                            {
                                value: null,
                                label: null
                            }
                        ];
                        data.required = false;
                    }
                    this.list.fields.push(data);
                    this.openProperties(data, this.list.fields.length - 1);
                }
            },
            openProperties(item, index) {
                app.item = item;
                app.itemIndex = index;
                app.itemContext = this;
            }
        }
    };

    Vue.component('form-item', FormItemComponent);
    Vue.component('sub-form-item', FormItemComponent);

    let app = new Vue({
        el: appId,
        data() {
            return {
                item: null,
                itemIndex: null,
                itemContext: null
            };
        },
        watch: {
            item(value, oldValue) {
                if (value) {
                    this.itemContext.list.fields[this.itemIndex] = value;
                }
            }
        },
        computed: {
            options() {
                return options;
            },
            types() {
                return TYPES;
            },
            separator() {
                return SEPARATOR;
            }
        },
        methods: {
            addOption() {
                this.item.options.push({
                    value: null,
                    label: null
                });
            },
            deleteOption(index) {
                this.item.options.splice(index, 1);
            }
        }
    });


}