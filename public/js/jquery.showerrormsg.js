!function ($, window, document) {
    "use strict";

    $.ShowErrorMsg = function (response, options) {
        var that = this;

        // 默认选项
        this.defaults = {
            // 外层标签类
            group: 'form-group',
            // 错误信息标签类
            message: 'help-block',
        };

        // 参数
        this.options = $.extend({}, this.defaults, options);

        if (typeof response !== "object" || response === null) {
            return;
        }

        // 上级类
        this.groupClass = '.' + this.options.group;

        // 消息类
        this.messageClass = '.' + this.options.message;

        // 显示字段类错误信息
        this.showFieldsErrors = function (errors) {
            $.each(errors, function (key, item) {

                var content = typeof item === "string" ? item : item[0];

                var msgHtml = '<span class="' + that.options.message + '">' + content + '</span>';
                var input = $('input[name="' + key + '"]');
                var select = $('select[name="' + key + '"]');
                var textarea = $('textarea[name="' + key + '"]');
                if (input.length > 0) {
                    input.parents(that.groupClass).addClass('has-error');
                    if (input.parents(that.groupClass).find(that.messageClass).length > 0) {
                        input.parents(that.groupClass).find(that.messageClass).text(content);
                    } else {
                        input.parents(that.groupClass).append(msgHtml);
                    }
                } else if (select.length > 0) {
                    select.parents(that.groupClass).addClass('has-error');
                    if (select.parents(that.groupClass).find(that.messageClass).length > 0) {
                        select.parents(that.groupClass).find(that.messageClass).text(content);
                    } else {
                        select.parents(that.groupClass).append(msgHtml);
                    }
                } else if (textarea.length > 0) {
                    textarea.parents(that.groupClass).addClass('has-error');
                    if (textarea.parents(that.groupClass).find(that.messageClass).length > 0) {
                        textarea.parents(that.groupClass).find(that.messageClass).text(content);
                    } else {
                        textarea.parents(that.groupClass).append(msgHtml);
                    }
                }
            });
        };

        // 现在普通错误信息
        this.showNormalErrors = function (message) {
            if (typeof swal !== "undefined") {
                swal({
                    title: "出错了",
                    text: message,
                    type: "warning",
                    confirmButtonText: "好的",
                });
            } else {
                alert(message);
            }
        };

        if (response.status === undefined) {
            // 其他错误模式
            if (response.error !== undefined && response.error !== 0 ) {
                if (response.message !== undefined && response.message !== '') {
                    this.showNormalErrors(response.message);
                } else if (response.errors !== undefined && typeof response.errors === "object") {
                    this.showFieldsErrors(response.errors);
                }
            }
        } else {
            // http 状态 错误模式
            if (response.status === 200) {
                // 正确不需要处理
            } else if (response.status === 422) {
                // 字段错误模式
                var errors = {};

                if (response.responseJSON !== undefined && response.responseJSON.errors !== undefined) {
                    errors = response.responseJSON.errors;
                } else if (response.errors !== undefined) {
                    errors = response.errors;
                } else {
                    return;
                }

                this.showFieldsErrors(errors);
            } else {
                if (response.message !== undefined && response.message !== '') {
                    this.showNormalErrors(response.message);
                }
            }
        }
    };
}(jQuery, window, document);