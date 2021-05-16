class SaveTrait {

    fixCkEditor() {
        if (CKEDITOR === undefined) return false;
        CKEDITOR.on("instanceReady", function (event) {
            event.editor.on('change', function () {
                event.editor.updateElement();
            })
        });
    }

    _debounce(func, wait, immediate) {
        let timeout;
        return function () {
            let context = this, args = arguments;
            let later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            let callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    _ajax(instance, data, url, btn, form, eventInstance) {
        $.ajax({
            url: url,
            data: data,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: instance.method,
            success: function (response) {
                if (instance.buttonSpinnerOnProcess) btn.removeClass('btn-loading');
                if (instance.processLaravelValidation && response.errors) {
                    instance.validationCallback ? instance.validationCallback(response, instance) : function () {
                        for (let field in response.errors) {
                            let fieldData = field.split('.');
                            if (fieldData[1]) {
                                $("[name='" + fieldData[0] + "[]']").each(function (k, v) {
                                    if (k == fieldData[1]) {
                                        $(v).addClass('is-invalid').parents('.form-group').find('.invalid-feedback').show().text(response.errors[field][0]).parents('.form-group').find('.cke_chrome').css({border: '1px solid #c21a1a'});
                                        return true;
                                    }
                                });
                            } else {
                                $('[name="' + fieldData[0] + ($.inArray(fieldData[0], instance.fieldsToArray) !== -1 ? '[]' : '') + '"]').addClass('is-invalid').parents('.form-group').find('.invalid-feedback').show().text(response.errors[fieldData[0]][0]);
                            }
                        }
                    }();
                }
                if (response.global) {
                    Swal.fire({type: response.status ? 'success' : 'error', title: response.title, html: response.message, showConfirmButton: false});
                }
                if (response.status) {
                    if (instance.enableButtonOnSuccess) btn.prop('disabled', false).removeClass('disabled');
                    if (instance.showSuccessToast && !response.global) instance.toast.fire({type: 'success', title: response.message});
                    if (instance.additionSuccessCallback) instance.additionSuccessCallback(response, eventInstance);
                    if (instance.clearFormOnSuccess) {
                        if (instance.clearFormFieldsOnSuccess) {
                            for (let field in instance.clearFormFieldsOnSuccess) {
                                $('[name="' + instance.clearFormFieldsOnSuccess[field] + '"]').val(null);
                            }
                        } else {
                            form[0].reset();
                        }
                    }
                    if (instance.pageReloadOnSuccess) {
                        setTimeout(function () {
                            window.location.reload();
                        }, instance.redirectTimeout);
                    }
                } else {
                    if (instance.enableButtonOnFail) btn.prop('disabled', false).removeClass('disabled');
                    if (response.message != null)
                        if (instance.showFailToast && !response.global) instance.toast.fire({type: 'error', title: response.message});
                    if (instance.additionFailCallback) instance.additionFailCallback(response);
                    if (instance.clearFormOnFail) {
                        if (instance.clearFormFieldsOnFail) {
                            for (let field in instance.clearFormFieldsOnFail) {
                                $('[name="' + instance.clearFormFieldsOnFail[field] + '"]').val(null);
                            }
                        } else {
                            form[0].reset();
                        }
                    }
                }
                if (response.redirect) {
                    setTimeout(function () {
                        location.href = response.redirect;
                    }, instance.redirectTimeout)
                }
            },
            error: function (error) {
                if (instance.enableButtonOnFail && btn !== undefined) btn.prop('disabled', false);
                if (instance.buttonSpinnerOnProcess && btn !== undefined) btn.removeClass('btn-loading');
                Swal.fire({title: 'Возникла ошибка #' + error.status, showConfirmButton: false, text: error.responseJSON.message ? error.responseJSON.message : error.statusText, footer: 'Перезагрузите страницу и повторите попытку, если ошибка повторится, отправьте информацию в технический отдел'})
            }
        });
    }

    _eventHandler() {
        let instance = this;
        let ajax = this._debounce(this._ajax, this.debounceTime);
        return async function (event) {
            event.preventDefault();
            if (instance.sendMiddleware && !await instance.sendMiddleware(event, this)) return false;
            let btn = instance.button ? $(instance.button) : $(instance.selector).find('[type=submit]');
            if (instance.disableButtonOnProcess) btn.prop('disabled', true).addClass('disabled');
            if (instance.buttonSpinnerOnProcess) {
                btn.addClass('btn-loading');
            }
            let form = instance.formSelector ? $(instance.formSelector) : $(this);
            instance.clearErrorCallback ? instance.clearErrorCallback() : function () {
                $('input, textarea, select').on('change keyup clearErrors', function () {
                    $(this).removeClass('is-invalid').parents('.form-group').find('.invalid-feedback').hide().text(null).parents('.form-group').find('.cke_chrome').css({border: ''});
                });
            }();
            $('textarea').trigger('clearErrors');
            let data = form.is('form') ? new FormData(form[0]) : new FormData();
            data = instance.additionData ? instance.additionData(data, this) : data;
            if (instance.recaptcha) data.append('g-recaptcha-response', await instance._executeCaptcha());
            let formActionUrl = form.attr('action');
            let url = instance.actionUrl ? instance.actionUrl : formActionUrl ? formActionUrl : location.href;
            let eventInstance = this;

            ajax(instance, data, url, btn, form, eventInstance)
        }
    }

    constructor(options) {
        this._setOptions(options);
        $(this.selector).off().on(this.selectorType, this._eventHandler());
        if (this.fixCkEditorData) this.fixCkEditor();
    }

    setSendMiddleware(callback) {
        this.sendMiddleware = callback;
        return this;
    }

    selectorRefresh() {
        $(this.selector).off().on(this.selectorType, this._eventHandler());
    }

    setClearErrorCallback(callback) {
        this.clearErrorCallback = callback;
        return this;
    }

    setValidationCallback(callback) {
        this.validationCallback = callback;
        return this;
    }

    setAdditionalData(callback) {
        this.additionData = callback;
        return this;
    }

    setAdditionalSuccessCallback(callback) {
        this.additionSuccessCallback = callback;
        return this;
    }

    setAdditionalFailCallback(callback) {
        this.additionFailCallback = callback;
        return this;
    }

    _executeCaptcha() {
        let instance = this;
        return new Promise((resolve, reject) => {
            grecaptcha.execute(instance.recaptchaKey ? instance.recaptchaKey : $('meta[name="captcha-key"]').attr('content'), {action: instance.recaptchaAction}).then(function (token) {
                resolve(token);
            });
            setTimeout(() => {
                reject(new Error('Recaptcha exceed timeout'));
            }, 5000);
        });
    }

    _setOptions(options = {}) {

        /* Init params */
        this.selector = null;
        this.formSelector = null;
        this.selectorType = 'submit';
        this.actionUrl = null;
        this.button = null;

        /* Options */
        this.preventDefault = true;
        this.disableButtonOnProcess = true;
        this.enableButtonOnSuccess = true;
        this.enableButtonOnFail = true;
        this.buttonSpinnerOnProcess = true;
        this.processLaravelValidation = true;
        this.showSuccessToast = true;
        this.showFailToast = false;
        this.redirectTimeout = 1000;
        this.debounceTime = 0;
        this.clearFormOnSuccess = false;
        this.clearFormOnFail = false;
        this.clearFormFieldsOnSuccess = null;
        this.clearFormFieldsOnFail = null;
        this.fixCkEditorData = false;
        this.fieldsToArray = [];
        this.recaptcha = false;
        this.recaptchaKey = null;
        this.recaptchaAction = null;
        this.method = 'post';

        this.pageReloadOnSuccess = false;

        this.toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            background: '#f2f4f8',
            timer: 5000,
        });

        for (let option in options) {
            if (this.hasOwnProperty(option)) {
                Object.defineProperty(this, option, {value: options[option],});
            }
        }
    }

}

