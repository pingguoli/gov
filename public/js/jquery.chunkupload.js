!function ($, window, document) {
    "use strict";

    var ChunkUpload = function (element, options) {
        var that = this;
        // 默认选项
        this.defaults = options || {};
        // 当前元素
        this.element = $(element);

        // 外层组元素
        this.wrapper = this.element.parents(this.defaults.wrapper);

        // 进度条
        this.progress = this.wrapper.find(this.defaults.progress);

        // 进度提示元素
        this.output = this.wrapper.find(this.defaults.output);

        // 存储隐藏表单位置
        this.saveHashDom = this.wrapper.find(this.defaults.saved);

        // 显示上传文件
        this.showUrl = this.wrapper.find(this.defaults.show);

        // 上传的文件
        this.file = null;

        // 文件名称
        this.fileName = null;

        // 文件大小
        this.fileSize = null;

        // 上传文件名
        this.uploadBaseName = "";

        // 扩展名
        this.uploadExt = "";

        // 分片大小
        this.chunkSize = 0;

        // 分片总数
        this.chunkCount = 0;

        // 当前分片数
        this.chunkIndex = 0;

        // 存储子目录
        this.subDir = "";

        // 文件保存Hash
        this.saveHash = "";

        // 文件加密
        this.fileHash = "";

        // 上传的类型
        this.type = this.defaults.type;

        // 切片
        this.blobSlice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice;

        // 多语言
        this.locale = this.defaults.lang;

        // 多语言消息
        this.messages = this.getLocalizedMessages();

        // 预处理地址
        this.preProcessUrl = this.defaults.processUrl;

        // 上传地址
        this.uploadUrl = this.defaults.uploadUrl;

        // 成功处理
        this.success = this.defaults.success;

        if (!this.blobSlice) {
            this.output.text(this.messages.error_unsupported_browser);
            return;
        }

        if (!this.preProcessUrl) {
            this.output.text(this.messages.error_process_url);
            return;
        }

        if (!this.uploadUrl) {
            this.output.text(this.messages.error_upload_url);
            return;
        }

        // 初始化
        this.init();
    };

    ChunkUpload.prototype = {
        // 初始化
        init: function () {

            // 这只csrf 读取meta中数据
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            // 解绑
            this.unbind();

            // 绑定
            this.bind();
        },
        // 绑定方法
        bind: function () {
            var that = this;
            // 绑定change事件
            this.element.on('change', function () {
                that.file = that.element[0].files[0];

                that.fileName = that.file.name;

                that.fileSize = that.file.size;

                that.fileHash = "";

                if (!("FileReader" in window) || !("File" in window)) {
                    that.preProcess(); //浏览器不支持读取本地文件，跳过计算hash
                } else {
                    that.calculateHash();
                }
            });
        },
        // 解绑方法
        unbind: function () {
            // 解绑change事件
            this.element.off('change');
        },
        //计算hash
        calculateHash: function () {

            var that = this,
                chunkSize = 2 * 1000 * 1000,

                chunks = Math.ceil(that.file.size / chunkSize),

                currentChunk = 0,

                spark = new SparkMD5.ArrayBuffer(),

                fileReader = new FileReader();

            fileReader.onload = function (e) {

                spark.append(e.target.result);

                ++currentChunk;

                that.output.text(that.messages.status_hashing + ' ' + parseInt(currentChunk / chunks * 100) + "%");

                if (currentChunk < chunks) {

                    loadNext();

                } else {

                    that.fileHash = spark.end();

                    that.preProcess();

                }
            };

            fileReader.onerror = function () {

                this.preProcess();

            };

            function loadNext() {

                var start = currentChunk * chunkSize,

                    end = start + chunkSize >= that.file.size ? that.file.size : start + chunkSize;

                fileReader.readAsArrayBuffer(that.blobSlice.call(that.file, start, end));

            }

            loadNext();
        },
        // 预处理
        preProcess: function () {

            var that = this;

            that.uploadBaseName = "";
            that.uploadExt = "";
            that.chunkSize = 0;
            that.chunkCount = 0;
            that.chunkIndex = 0;
            that.subDir = "";
            that.saveHash = "";

            $.post(that.preProcessUrl, {
                file_name: that.fileName,
                file_size: that.fileSize,
                file_hash: that.fileHash,
                type: that.type
            }, function (rst) {

                if (rst.error) {
                    that.output.text(rst.error);
                    return;
                }

                that.uploadBaseName = rst.uploadBaseName;

                that.uploadExt = rst.uploadExt;

                that.chunkSize = rst.chunkSize;

                that.chunkCount = Math.ceil(that.fileSize / that.chunkSize);

                that.subDir = rst.subDir;

                if (rst.hash.length === 0) {

                    that.output.text(that.messages.status_uploading + " 0%");

                    that.uploadChunkInterval = setInterval($.proxy(that.uploadChunk, that), 0);
                } else {

                    that.progress.css("width", "100%");

                    that.saveHash = rst.hash;

                    that.saveHashDom.val(that.saveHash);

                    if (that.showUrl.length > 0) {
                        if (that.type === 'image') {
                            that.showUrl.attr('src', rst.url);
                        } else {
                            that.showUrl.attr('href', rst.url);
                            that.showUrl.text(rst.hash);
                        }
                    }

                    // that.element.attr("disabled", "disabled");

                    that.output.text(that.messages.status_instant_completion_success);

                    if (typeof that.success === "function") {
                        that.success(that);
                    }
                }

            }, "json");

        },
        // 上传分片
        uploadChunk: function () {

            var that = this,

                start = this.chunkIndex * this.chunkSize,

                end = Math.min(this.fileSize, start + this.chunkSize),

                form = new FormData();

            form.append("file", this.file.slice(start, end));

            form.append("upload_ext", this.uploadExt);

            form.append("chunk_total", this.chunkCount);

            form.append("chunk_index", this.chunkIndex + 1);

            form.append("upload_basename", this.uploadBaseName);

            form.append("type", this.type);

            form.append("sub_dir", this.subDir);

            form.append("file_name", this.fileName);

            $.ajax({

                url: this.uploadUrl,

                type: "POST",

                data: form,

                dataType: "json",

                async: false,

                processData: false,

                contentType: false,

                success: function (rst) {

                    if (rst.error) {

                        that.output.text(rst.error);

                        clearInterval(that.uploadChunkInterval);

                        return;

                    }

                    var percent = parseInt((that.chunkIndex + 1) / that.chunkCount * 100);

                    that.progress.css("width", percent + "%");

                    that.output.text(that.messages.status_uploading + " " + percent + "%");

                    if (that.chunkIndex + 1 === that.chunkCount) {

                        clearInterval(that.uploadChunkInterval);

                        that.saveHash = rst.hash;

                        that.saveHashDom.val(that.saveHash);

                        if (that.showUrl.length > 0) {
                            if (that.type === 'image') {
                                that.showUrl.attr('src', rst.url);
                            } else {
                                that.showUrl.attr('href', rst.url);
                                that.showUrl.text(rst.hash);
                            }
                        }

                        // that.element.attr("disabled", "disabled");

                        that.output.text(that.messages.status_upload_success);

                        if (typeof that.success === "function") {
                            that.success(that);
                        }
                    }

                    ++that.chunkIndex;

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                    if (XMLHttpRequest.status === 0) {

                        that.output.text(that.messages.status_retrying);

                        that.sleep(3000);

                    } else {

                        that.output.text(that.messages.error_upload_fail);

                        clearInterval(that.uploadChunkInterval);

                    }
                }

            });

        },
        // 停留几秒
        sleep: function (milliSecond) {

            var wakeUpTime = new Date().getTime() + milliSecond;

            while (true) {

                if (new Date().getTime() > wakeUpTime) {

                    return;
                }
            }
        },
        // 读取多语言
        getLocalizedMessages: function () {
            if (this.locale === '' || this.text[this.locale] === undefined) {
                this.locale = 'en';
            }
            return this.text[this.locale];

        },
        // 多语言翻译
        text: {
            en: {
                status_upload_begin: "upload begin",
                error_unsupported_browser: "Error: unsupported browser",
                status_hashing: "hashing",
                status_instant_completion_success: "upload success (instant completion) ",
                status_uploading: "uploading",
                status_upload_success: "upload success",
                status_retrying: "network problem, retrying...",
                error_upload_fail: "Error: upload failed",
                error_process_url: "Error: You must fill in the Preprocessing address",
                error_upload_url: "Error: You must fill in the upload address"
            },
            zh: {
                status_upload_begin: "开始上传",
                error_unsupported_browser: "错误：上传组件不被此浏览器支持",
                status_hashing: "正在哈希",
                status_instant_completion_success: "上传成功（秒传）",
                status_uploading: "正在上传",
                status_upload_success: "上传成功",
                status_retrying: "网络故障，正在重试……",
                error_upload_fail: "错误：上传失败",
                error_process_url: "错误：必须填写预处理地址",
                error_upload_url: "错误：必须填写上传地址"
            }
        }
    };

    $.fn.chunkUpload = function (option) {
        var args = Array.apply(null, arguments);
        args.shift();
        return this.each(function () {
            var $this = $(this),
                data = $this.data('chunkupload'),
                options = typeof option === 'object' && option;
            if (!data) {
                $this.data('chunkupload', (data = new ChunkUpload(this, $.extend({}, $.fn.chunkUpload.defaults, options))));
            }
            if (typeof option === 'string' && typeof data[option] === 'function') {
                data[option].apply(data, args);
            }
        });
    };

    // 默认值
    $.fn.chunkUpload.defaults = {
        //
        wrapper: '.chunk-upload',
        output: '.output',
        progress: '.progressbar',
        saved: '.img',
        show: '.img_show',
        type: 'image',
        lang: 'zh',
        processUrl: '',
        uploadUrl: '',
        success: function () {

        }
    };

    $.fn.chunkUpload.Constructor = ChunkUpload;

}(jQuery, window, document);