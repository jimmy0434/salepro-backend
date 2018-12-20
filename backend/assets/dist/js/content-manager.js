/*jshint esversion: 6 */
function contentManager(appId, options) {

    'use strict';

    const defaultOptions = {
        contentHub: {},
        marketIntelligence: {},
        competitor: {},
        brands: {},
        corporates: {},
        sectors: {},
        brandsList: [],
        corporatesList: [],
        sectorsList: [],
        saveCategoryUrl: null,
        UploadCategoryIconUrl: null
    };

    let {
        contentHub,
        marketIntelligence,
        competitor,
        brands,
        corporates,
        sectors,
        brandsList,
        corporatesList,
        sectorsList,
        saveCategoryUrl,
        UploadCategoryIconUrl
    } = $.extend({}, defaultOptions, options || {});

    let children = [
        {
            data: corporates,
            children: corporatesList.map(model => {
                return {data: model}
            })
        },
        {
            data: sectors,
            children: sectorsList.map(model => {
                return {data: model}
            })
        },
        {
            data: brands,
            children: brandsList.map(model => {
                return {data: model}
            })
        }
    ];

    let tree = [
        {
            data: contentHub,
            children
        },
        {
            data: marketIntelligence,
            children
        },
        {
            data: competitor,
            children
        }
    ];

    let treeItem = {
        template: '#tree-item-template',
        props: {
            model: Object,
            level: Number,
            directory: {
                type: Object,
                default() {
                    return this.level === 1 ? this : undefined;
                }
            },
            classification: {
                type: Object,
                default() {
                    return this.level === 2 ? this : undefined;
                }
            }
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
            },
            logo() {
                let icon = this.model.data.icon;
                if(typeof icon === 'string' || icon instanceof String) {
                    return icon;
                }else if(icon && typeof icon === 'object' && icon.constructor === Array && icon[0]){
                    icon = JSON.parse(icon[0]);
                    if(icon.url){
                        icon = icon.url;
                    }
                }
                return icon;
            }
        },
        methods: {
            toggle() {
                if (this.isFolder) {
                    this.open = !this.open;
                }
            },
            openFolder() {
                if (this.level === 3) {
                    app.activeFolder = this;
                }
            },
            addChild() {
                let model = {
                    data: {
                        name: this.newCategoryName
                    }
                };
                this.save(model, (response) => {
                    this.model.children.push({
                        data: response.model
                    });
                    this.newCategoryName = null;
                });
            },
            edit() {
                if (this.level === 3) {
                    this.editMode = true;
                    this.$nextTick(() => {
                        let key = 'category-' + this.model.data.name;
                        this.$refs[key].focus();
                    });
                }
            },
            applyEdit() {
                this.editMode = false;
                this.save(this.model, (response) => {

                });
            },
            save(model, callback) {
                if (saveCategoryUrl) {
                    let loader;
                    $.ajax({
                        type: "post",
                        url: saveCategoryUrl,
                        dataType: 'json',
                        data: {
                            id: model.data.id || null,
                            name: model.data.name,
                            parent: model.data.parent_id || this.model.data.id
                        },
                        beforeSend: () => {
                            loader = popup.loader("Saving "+model.data.name);
                        },
                        success: (response) => {
                            loader.close();
                            if (response.model) {
                                callback(response);
                                popup.success(response.model.name + " has been saved successfully");
                            } else {
                                popup.error(response.model.name + " has not been saved");
                            }
                        },
                        error: (jqXHR, exception) => {
                            loader.close();
                            this.onAjaxError(jqXHR, exception);
                        }
                    });
                }
            },
            browseIcon() {
                this.$refs['file-browse-' + this.model.data.id].click();
            },
            uploadIcon(event) {
                const file = event.target.files[0];
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.uploadExecution(file, e.target.result);
                };
                reader.readAsDataURL(file);
            },
            uploadExecution(file, data){
                let maxSize = 1024 * 512; // 512kb
                let types = ["image/png","image/jpg","image/jpeg"];
                if(file.size > maxSize){
                    popup.warning("Maximum image size is 512 KB");
                }else if(types.indexOf(file.type) === -1){
                    popup.warning("Image type should be one of: "+types.join(", "));
                }else {
                    if (UploadCategoryIconUrl) {
                        let loader;
                        $.ajax({
                            type: "post",
                            url: UploadCategoryIconUrl,
                            dataType: 'json',
                            data: {
                                id: this.model.data.id,
                                data: data,
                                extension: file.name.split('.').pop()
                            },
                            beforeSend: () => {
                                loader = popup.loader("Uploading Icon");
                            },
                            success: (response) => {
                                loader.close();
                                if(response.done){
                                    this.model.data.icon = data;
                                    popup.success("new icon for `" + this.model.data.name + "` has been uploaded successfully");
                                }else{
                                    popup.error("new icon for `" + this.model.data.name + "` has not been uploaded");
                                }
                            },
                            error: (jqXHR, exception) => {
                                loader.close();
                                this.onAjaxError(jqXHR, exception);
                            }
                        });
                    }
                }
            },
            onAjaxError(jqXHR, exception){
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
        }
    };

    Vue.component('item', treeItem);
    let app = new Vue({
        el: appId,
        data() {
            return {
                tree,
                activeFolder: null
            };
        }
    });

}