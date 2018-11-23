/*jshint esversion: 6 */
function formBuilder(appId, options) {

    'use strict';

    const defaultOptions = {
        form: null
    };

    options = $.extend({}, defaultOptions, options || {});

    const TYPES = Object.freeze({
        TEXT: 'text',
        TEXT_AREA: 'textarea',
        DROP_DOWN_LIST: 'dropdownlist',
        CHECKBOX: 'checkbox',
        RADIO: 'radio',
        SUB_FORM: 'subform'
    });

    const SEPARATOR = 'separator';
    const TITLE = 'title';

    const DATA_TYPES = Object.freeze({
        //PK : 'pk',
        //UPK : 'upk',
        //BIGPK : 'bigpk',
        //UBIGPK : 'ubigpk',
        //CHAR : 'char',
        STRING : 'string',
        TEXT : 'text',
        TINYINT : 'tinyint',
        SMALLINT : 'smallint',
        INTEGER : 'integer',
        BIGINT : 'bigint',
        FLOAT : 'float',
        DOUBLE : 'double',
        DECIMAL : 'decimal',
        //DATETIME : 'datetime',
        //TIMESTAMP : 'timestamp',
        //TIME : 'time',
        //DATE : 'date',
        //BINARY : 'binary',
        BOOLEAN : 'boolean',
        //MONEY : 'money',
        //JSON : 'json',
    });

    let FormItemComponent = {
        template: '#form-item',
        props: ['structure'],
        data() {
            return {
                list: this.structure,
                properties: [],
                tmpProperties: []
            };
        },
        created() {
            this.fixData();
        },
        computed: {
            types() {
                return TYPES;
            },
            dataTypes() {
                return DATA_TYPES;
            },
            separator() {
                return SEPARATOR;
            },
            title() {
                return TITLE;
            },
            self() {
                return this;
            },
            fields() {
                return this.list.fields;
            },
            name() {
                return this.list.name;
            }
        },
        filters: {
            typeName(value) {
                return value.toLowerCase().replace(/_/g, ' ');
            }
        },
        watch: {},
        methods: {
            fixData() {
                if (this.list.isRoot === 'true') {
                    this.list.isRoot = true;
                }
                if (this.list.isRoot === 'false') {
                    this.list.isRoot = false;
                }
                this.list.fields.forEach((item, index) => {
                    if (item.required !== undefined) {
                        if (item.required === 'true') {
                            item.required = true;
                        }
                        if (item.required === 'false') {
                            item.required = false;
                        }
                        this.list.fields[index] = item;
                    }
                });
            },
            addField(name) {
                if (name === SEPARATOR) {
                    this.list.fields.push({
                        id: (new Date()).getTime(),
                        type: SEPARATOR
                    });
                } else if (name === TITLE) {
                    this.list.fields.push({
                        id: (new Date()).getTime(),
                        type: TITLE,
                        value: null
                    });
                } else if (name === TYPES.SUB_FORM) {
                    this.list.fields.push({
                        id: (new Date()).getTime(),
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
                        type: name,
                        dataType: DATA_TYPES.TYPE_STRING
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
                if (this.properties[index] === undefined) {
                    this.properties[index] = true;
                }
                this.properties[index] = !this.properties[index];
                this.$forceUpdate();
            },
            propertiesOpened(index) {
                return this.properties[index];
            },
            draggableStart(evt) {
                this.properties.forEach((value, index) => {
                    this.tmpProperties[index] = value;
                    this.properties[index] = false;
                });
                this.properties = [...this.properties];
            },
            draggableEnd(evt) {
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
            }
        }
    };

    Vue.component('form-item', FormItemComponent);
    Vue.component('sub-form-item', FormItemComponent);

    let app = new Vue({
        el: appId,
        data() {
            return {};
        },
        watch: {},
        computed: {
            options() {
                return options;
            },
            types() {
                return TYPES;
            },
            dataTypes() {
                return DATA_TYPES;
            },
            separator() {
                return SEPARATOR;
            },
            title() {
                return TITLE;
            },
            items() {
                return this.$refs.rootItem.list;
            }
        },
        methods: {
            save() {
                if (this.items.fields.length > 0) {
                    let loader;
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: options.saveUrl,
                        data: {
                            form: this.items
                        },
                        success: function (response) {
                            loader.close();
                        },
                        beforeSend: function () {
                            loader = popup.loader('Saving...');
                        },
                        error: function (jqXHR, exception) {
                            loader.close();
                            let msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect, Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error : ' + jqXHR.responseText;
                            }
                            popup.warning(msg);
                        }
                    });
                }
            }
        }
    });


}