function formBuilder(appId, options) {

    const defaultOptions = {
        form: null
    };

    options = $.extend({}, defaultOptions, options || {});

    const TYPES = Object.freeze({
        HIDDEN: Symbol('hidden'),
        TEXT: Symbol('text'),
        TEXT_AREA: Symbol('textarea'),
        DROP_DOWN_LIST: Symbol('dropdownlist'),
        CHECKBOX: Symbol('checkbox'),
        RADIO: Symbol('radio'),
        RADIO_LIST: Symbol('radiolist'),
        SUB_FORM: Symbol('subform')
    });

    const SEPARATOR = "separator";

    let FormItemComponent = {
        // template ID
        template: '#form-item',
        props: ["structure"],
        data() {
            console.log(this.structure);
            return {
                list: {
                    name: this.structure.name,
                    fields: []
                }
            };
        },
        created(){
            console.log(this.name);
        },
        computed: {
            types() {
                return TYPES;
            },
            separator() {
                return SEPARATOR;
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
                    if (name === TYPES.DROP_DOWN_LIST) {
                        data.options = {};
                        data.required = false;
                    }
                    if (name === TYPES.RADIO_LIST) {
                        data.options = {};
                        data.required = false;
                    }
                    this.list.fields.push(data);
                }
            }
        }
    };

    new Vue({
        el: appId,
        components: {
            'form-item': FormItemComponent
        },
        computed: {
            options(){
                return options;
            }
        }
    });


}