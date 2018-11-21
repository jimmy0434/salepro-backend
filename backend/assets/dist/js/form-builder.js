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
                    fields: this.structure.fields
                },
                properties: [],
                tmpProperties: []
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
            fields() {
                return this.list.fields;
            }
        },
        filters: {
            typeName(value) {
                return value.toLowerCase().replace(/_/g, ' ');
            }
        },
        watch: {
            list(value, oldValue) {
                this.$emit("fieldsUpdated", value);
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
                        id: (new Date()).getTime(),
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
                if(this.properties[index] === undefined){
                    this.properties[index] = true;
                }
                this.properties[index] = !this.properties[index];
                this.$forceUpdate();
            },
            propertiesOpened(index){
                return this.properties[index];
            },
            draggableStart(evt){
                console.log("draggableStart : ",evt);
                this.properties.forEach((value, index) => {
                    this.tmpProperties[index] = value;
                    this.properties[index] = false;
                });
                this.properties = [...this.properties];
            },
            draggableEnd(evt){
                console.log("draggableEnd : ",evt);
                //this.$forceUpdate();
                this.properties = [...this.tmpProperties];
                let old = this.properties[evt.oldIndex];
                this.properties[evt.oldIndex] = this.properties[evt.newIndex];
                this.properties[evt.newIndex] = old;
                this.tmpProperties = [];
            },
            addOption(index) {
                this.list.fields[index].options.push({
                    value: null,
                    label: null
                });
            },
            deleteOption(index, optionIndex) {
                this.list.fields[index].options.splice(optionIndex, 1);
            },
        }
    };

    Vue.component('form-item', FormItemComponent);
    Vue.component('sub-form-item', FormItemComponent);

    let app = new Vue({
        el: appId,
        data() {
            return {
                list: {}
            };
        },
        watch: {},
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
            onFieldsUpdated(event, list) {
                console.log(event, list);
            }
        }
    });


}