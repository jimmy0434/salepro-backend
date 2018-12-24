/*jshint esversion: 6 */
function contentManager(appId, options) {

    'use strict';

    Vue.use(VueEasyCm);

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
        UploadCategoryIconUrl: null,
        UploadContentCoverUrl: null,
        contentsUrl: null,
        formBuilderUrl: null,
        fileUploadUrl: null,
        fileDownloadUrl: null,
        manageContentUrl: null,
        createContentUrl: null,
        renameTitleUrl: null,
        deleteContentUrl: null,
        statuses: {}
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
        UploadCategoryIconUrl,
        UploadContentCoverUrl,
        contentsUrl,
        formBuilderUrl,
        fileUploadUrl,
        fileDownloadUrl,
        manageContentUrl,
        createContentUrl,
        renameTitleUrl,
        deleteContentUrl,
        statuses
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

    function onAjaxError(jqXHR, exception) {
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
    };

    window.closeFancyBox = function () {
        $.fancybox.close();
        app.refreshContents();
    };

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
                if (typeof icon === 'string' || icon instanceof String) {
                    return icon;
                } else if (icon && typeof icon === 'object' && icon.constructor === Array && icon[0]) {
                    icon = JSON.parse(icon[0]);
                    if (icon.url) {
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
                            loader = popup.loader("Saving " + model.data.name);
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
                            onAjaxError(jqXHR, exception);
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
            uploadExecution(file, data) {
                let maxSize = 1024 * 512; // 512kb
                let types = ["image/png", "image/jpg", "image/jpeg"];
                if (file.size > maxSize) {
                    popup.warning("Maximum image size is 512 KB");
                } else if (types.indexOf(file.type) === -1) {
                    popup.warning("Image type should be one of: " + types.join(", "));
                } else {
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
                                if (response.done) {
                                    this.model.data.icon = data;
                                    popup.success("Icon for `" + this.model.data.name + "` has been uploaded successfully");
                                } else {
                                    popup.error("Icon for `" + this.model.data.name + "` has not been uploaded");
                                }
                            },
                            error: (jqXHR, exception) => {
                                loader.close();
                                onAjaxError(jqXHR, exception);
                            }
                        });
                    }
                }
            }
        }
    };

    let contents = {
        template: '#contents-template',
        props: {
            category: Number
        },
        data() {
            return {
                page: 1,
                pageSize: 40,
                list: [],
                count: 0,
                focusedItem: null,
                editTitleMode: false,
                addNew: null
            };
        },
        computed: {
            activeFolder() {
                return app.activeFolder;
            },
            contextMenu() {
                let list = [];
                list.push({
                    text: 'Add New',
                    icon: 'fa fa-plus',
                    children: [
                        {
                            text: 'Content'
                        },
                        {
                            text: 'File'
                        },
                        {
                            text: 'Form'
                        },
                        {
                            text: 'Url'
                        },
                        {
                            text: 'Rss'
                        }
                    ]
                });
                if (this.focusedItem) {
                    let section = this.focusedItem.section;
                    if (section) {
                        let [target] = section.split('-');
                        if (target === "file") {
                            list.push({
                                text: 'File',
                                icon: 'fa fa-file',
                                children: [
                                    {
                                        text: 'Upload File'
                                    },
                                    {
                                        text: 'Download File'
                                    }
                                ]
                            });
                        } else if (target === "form") {
                            list.push({
                                text: 'Form',
                                icon: 'fa fa-list-alt',
                                children: [
                                    {
                                        text: 'Builder'
                                    }
                                ]
                            });
                        }
                    }
                    list.push({
                        text: 'Change Image',
                        icon: 'fa fa-image'
                    });
                    list.push({
                        text: 'Edit',
                        icon: 'fa fa-pencil'
                    });
                    list.push({
                        text: 'Delete',
                        icon: 'fa fa-remove'
                    });
                }
                return list;
            },
            articles() {
                let i, j, list = [], chunk = 4, exist = {};
                for (i = 0, j = this.list.length; i < j; i += chunk) {
                    list.push(this.list.slice(i, i + chunk).filter(item => {
                        if (!exist[item.id]) {
                            exist[item.id] = true;
                            return true;
                        }
                        return false;
                    }));
                }
                return list;
            }
        },
        created() {
            this.page = 1;
            this.list = [];
            this.count = 0;
            this.loadContents();
        },
        watch: {
            category(value, oldValue) {
                if (value !== oldValue) {
                    this.page = 1;
                    this.list = [];
                    this.count = 0;
                    this.loadContents();
                }
            }
        },
        methods: {
            loadContents() {
                if (contentsUrl) {
                    let loader;
                    $.ajax({
                        type: "get",
                        url: contentsUrl,
                        dataType: "json",
                        data: {
                            page: this.page,
                            pageSize: this.pageSize,
                            directoryId: this.activeFolder.directory.model.data.id,
                            classificationId: this.activeFolder.model.data.id
                        },
                        beforeSend: () => {
                            loader = popup.loader("Contents Loading...");
                        },
                        success: (response) => {
                            loader.close();
                            if (response.list) {
                                this.list = [...this.list, ...response.list];
                                this.page++;
                            }
                            if (response.count) {
                                this.count = response.count;
                            }
                        },
                        error: (jqXHR, exception) => {
                            loader.close();
                            onAjaxError(jqXHR, exception);
                        }
                    });
                }
            },
            focusMe(article) {
                this.focusedItem = article;
            },
            blurMe() {
                this.focusedItem = null;
            },
            target(article) {
                let section = article.section;
                if (section) {
                    let [target, id] = section.split('-');
                    if (target) {
                        return [target, id];
                    }
                }
                return ["article", article.id];
            },
            status(article) {
                return statuses[article.status] || null;
            },
            contextAction(path) {
                let [action, params] = this.resolveAction(path);
                if (action && this[action]) {
                    let fct = this[action];
                    fct.call(this, params);
                }
            },
            actions() {
                let directoryId = this.activeFolder.directory.model.data.id;
                let classificationId = this.activeFolder.model.data.id;
                let list = {
                    'addContent': ['addContent', {
                        type: 'content',
                        directory: directoryId,
                        classification: classificationId
                    }],
                    'addFileContent': ['addContent', {
                        type: 'file',
                        directory: directoryId,
                        classification: classificationId
                    }],
                    'addFormContent': ['addContent', {
                        type: 'form',
                        directory: directoryId,
                        classification: classificationId
                    }],
                    'addUrlContent': ['addContent', {
                        type: 'url',
                        directory: directoryId,
                        classification: classificationId
                    }],
                    'addRssContent': ['addContent', {
                        type: 'rss',
                        directory: directoryId,
                        classification: classificationId
                    }]
                };
                if (this.focusedItem) {
                    list['uploadImage'] = ['uploadImage', {id: this.focusedItem.id}];
                    list['manageContent'] = ['manageContent', {id: this.focusedItem.id}];
                    list['deleteContent'] = ['deleteContent', {id: this.focusedItem.id}];
                    let [target, targetId] = this.target(this.focusedItem);
                    switch (target) {
                        case "file":
                            list['uploadFile'] = ['uploadFile', {id: targetId}];
                            list['downloadFile'] = ['downloadFile', {id: targetId}];
                            break;
                        case "form":
                            list['formBuilder'] = ['formBuilder', {id: targetId}];
                            break;
                    }
                }
                return list;
            },
            resolveAction(path) {
                let actions = this.actions();
                let pathName = path.join('.');
                let list = {};
                list['0.0'] = actions['addContent'];
                list['0.1'] = actions['addFileContent'];
                list['0.2'] = actions['addFormContent'];
                list['0.3'] = actions['addUrlContent'];
                list['0.4'] = actions['addRssContent'];
                if (this.focusedItem) {
                    let [target] = this.target(this.focusedItem);
                    switch (target) {
                        case "article":
                        case "url":
                        case "rss":
                            list = this.resolvePureArticleAction(list, actions);
                            break;
                        case "file":
                            list = this.resolveFileArticleAction(list, actions);
                            break;
                        case "form":
                            list = this.resolveFormArticleAction(list, actions);
                            break;
                    }
                }
                return list[pathName] || [null, null];
            },
            resolvePureArticleAction(list, actions) {
                list['1'] = actions['uploadImage'];
                list['2'] = actions['manageContent'];
                list['3'] = actions['deleteContent'];
                return list;
            },
            resolveFileArticleAction(list, actions) {
                list['1.0'] = actions['uploadFile'];
                list['1.1'] = actions['downloadFile'];
                list['2'] = actions['uploadImage'];
                list['3'] = actions['manageContent'];
                list['4'] = actions['deleteContent'];
                return list;
            },
            resolveFormArticleAction(list, actions) {
                list['1.0'] = actions['formBuilder'];
                list['2'] = actions['uploadImage'];
                list['3'] = actions['manageContent'];
                list['4'] = actions['deleteContent'];
                return list;
            },
            addContent({type, directory, classification}) {
                let hasUrl = (type === 'url' || type === 'rss');
                this.addNew = {type, directory, classification, title: null, hasUrl: hasUrl, url: ""};
                this.$nextTick(() => {
                    this.$refs.newContentInput.focus();
                });
            },
            uploadImage({id}) {
                let ref = 'article-file-browse-' + id;
                this.$refs[ref][0].click();
            },
            dblUploadImage(article) {
                this.focusedItem = article;
                this.uploadImage({id: article.id});
            },
            manageContent({id}) {
                let url = manageContentUrl.replace('__ID__', id).replace('__C__', this.activeFolder.directory.model.data.id);
                this.openDialogFrame(url);
            },
            deleteContent({id}) {
                popup.confirm('Delete Content','Are you sure you want to delete this content?', confirmed => {
                    if (confirmed && deleteContentUrl) {
                        let loader;
                        $.ajax({
                            type: "post",
                            url: deleteContentUrl,
                            dataType: 'json',
                            data: {id},
                            beforeSend: () => {
                                loader = popup.loader("Deleting Content...");
                            },
                            success: (response) => {
                                loader.close();
                                if (response.done) {
                                    this.list = this.list.filter(item => {
                                        if(item.id === id){
                                            this.count--;
                                            return false;
                                        }
                                        return true;
                                    });
                                    popup.success("Content `" + this.focusedItem.title + "` has been deleted successfully");
                                } else {
                                    popup.error("Content `" + this.focusedItem.title + "` has not been deleted");
                                }
                            },
                            error: (jqXHR, exception) => {
                                loader.close();
                                onAjaxError(jqXHR, exception);
                            }
                        });
                    }
                });
            },
            uploadFile({id}) {
                let url = fileUploadUrl.replace('__ID__', id);
                this.openDialogFrame(url);
            },
            downloadFile({id}) {
                let url = fileDownloadUrl.replace('__ID__', id);
                window.open(url);
            },
            formBuilder({id}) {
                let url = formBuilderUrl.replace('__ID__', id);
                this.openDialogFrame(url);
            },
            openDialogFrame(url) {
                $.fancybox.open({
                    src: url,
                    type: 'iframe',
                    iframe: {
                        css: {
                            width: '90vw',
                            height: '90vh'
                        }
                    }
                });
            },
            uploadCover(event) {
                const file = event.target.files[0];
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.uploadExecution(file, e.target.result);
                };
                reader.readAsDataURL(file);
            },
            uploadExecution(file, data) {
                let maxSize = 1024 * 1024; // 1MB
                let types = ["image/png", "image/jpg", "image/jpeg"];
                if (file.size > maxSize) {
                    popup.warning("Maximum image size is 1 MB");
                } else if (types.indexOf(file.type) === -1) {
                    popup.warning("Image type should be one of: " + types.join(", "));
                } else {
                    if (UploadContentCoverUrl) {
                        let loader;
                        $.ajax({
                            type: "post",
                            url: UploadContentCoverUrl,
                            dataType: 'json',
                            data: {
                                id: this.focusedItem.id,
                                data: data,
                                extension: file.name.split('.').pop()
                            },
                            beforeSend: () => {
                                loader = popup.loader("Uploading Cover");
                            },
                            success: (response) => {
                                loader.close();
                                if (response.done) {
                                    this.focusedItem.cover = data;
                                    popup.success("cover for `" + this.focusedItem.title + "` has been uploaded successfully");
                                } else {
                                    popup.error("cover for `" + this.focusedItem.title + "` has not been uploaded");
                                }
                            },
                            error: (jqXHR, exception) => {
                                loader.close();
                                onAjaxError(jqXHR, exception);
                            }
                        });
                    }
                }
            },
            enableEditTitleMode(article) {
                this.editTitleMode = article.id;
                this.$nextTick(() => {
                    this.$refs['content-title-' + article.id][0].focus();
                });
            },
            applyEditTitle(article) {
                if (renameTitleUrl) {
                    let loader;
                    $.ajax({
                        type: "post",
                        url: renameTitleUrl,
                        dataType: 'json',
                        data: {
                            id: article.id,
                            title: article.title,
                            type: this.target(article)[0]
                        },
                        beforeSend: () => {
                            loader = popup.loader("Renaming content...");
                        },
                        success: (response) => {
                            loader.close();
                            if (response.done) {
                                this.editTitleMode = false;
                                popup.success("Content title `" + article.title + "` has been uploaded successfully");
                            } else {
                                popup.error("Content title `" + article.title + "` has not been uploaded");
                            }
                        },
                        error: (jqXHR, exception) => {
                            loader.close();
                            onAjaxError(jqXHR, exception);
                        }
                    });
                }
            },
            changeStatus(article) {
                console.log(article.id);
            },
            cancelNewContent() {
                this.addNew = null;
            },
            applyNewContent() {
                let data = this.addNew;
                if (data && $.trim(data.title) !== "") {
                    if (createContentUrl) {
                        let loader;
                        $.ajax({
                            type: "post",
                            url: createContentUrl,
                            dataType: 'json',
                            data: data,
                            beforeSend: () => {
                                loader = popup.loader("Creating new content...");
                            },
                            success: (response) => {
                                loader.close();
                                if (response.done) {
                                    this.addNew = null;
                                    this.list.push(response.model);
                                    this.count++;
                                    popup.success("New content `" + data.title + "` has been uploaded successfully");
                                } else {
                                    popup.error("New content `" + data.title + "` has not been uploaded");
                                }
                            },
                            error: (jqXHR, exception) => {
                                loader.close();
                                onAjaxError(jqXHR, exception);
                            }
                        });
                    }
                } else {
                    this.addNew = null;
                }
            },
            openUrl(article) {
                let [target, targetId] = this.target(article);
                if (target === 'url' || target === 'rss') {
                    window.open(article.external_url.url);
                } else if (target === 'form') {
                    this.openDialogFrame(formBuilderUrl.replace('__ID__', targetId));
                } else if (target === 'file') {
                    this.openDialogFrame(fileUploadUrl.replace('__ID__', targetId));
                }
            },
            iconClass(article) {
                let [target, targetId] = this.target(article);
                return {
                    'fa': true,
                    'fa-font': target === 'article',
                    'fa-file': target === 'file',
                    'fa-list-alt': target === 'form',
                    'fa-rss': target === 'rss',
                    'fa-link': target === 'url'
                }
            }
        }
    };

    Vue.component('item', treeItem);
    Vue.component('contents', contents);

    let app = new Vue({
        el: appId,
        data() {
            return {
                tree,
                activeFolder: null
            };
        },
        methods: {
            refreshContents() {
                let item = this.$refs.contents;
                item.page = 1;
                item.list = [];
                item.count = 0;
                item.loadContents();
            }
        }
    });

}