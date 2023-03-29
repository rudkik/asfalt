(function ($) {
    // узнать позицию курсора
    $.fn.getCursorPosition = function () {
        var input = this.get(0);
        if (!input) return;
        if ('selectionStart' in input) {
            return input.selectionStart;
        } else if (document.selection) {
            input.focus();
            var sel = document.selection.createRange();
            var selLen = document.selection.createRange().text.length;
            sel.moveStart('character', -input.value.length);
            return sel.text.length - selLen;
        }
    }
    // установить позицию курсора
    $.fn.setCursorPosition = function (pos) {
        if ($(this).get(0).setSelectionRange) {
            $(this).get(0).setSelectionRange(pos, pos);
        } else if ($(this).get(0).createTextRange) {
            var range = $(this).get(0).createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    }
    // удалить выделенный текст
    $.fn.delSelected = function () {
        var input = $(this);
        var value = input.val();
        var start = input[0].selectionStart;
        var end = input[0].selectionEnd;
        input.val(
            value.substr(0, start) + value.substring(end, value.length)
        );
        return end - start;
    };

    function priceFormatted(element, fractional) {
        element = String(element);
        var index = element.indexOf('.');

        if(index > -1) {
            var float = element.substr(index);
            element = element.substr(0, index);

            // убиваем вторую точку и все после нее
            var index = float.indexOf('.', 1);
            if(index > -1) {
                float = float.substr(0, index);
            }

            if(fractional != undefined && !isNaN(fractional)){
                float = float.substr(0, parseInt(fractional) + 1);
            }
        }else{
            var float = '';
        }

        element = String(element).replace(/[^\d]/g, '');
        if(!element) return '';
        return (String(parseInt(element))).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ') + float;
    }

    $.fn.priceFormat = function () {
        $(this)
        // Отмена перетаскивания текста
            .bind('drop', function (event) {
                if($(this).attr('readonly') != undefined || $(this).attr('disabled') != undefined ){
                    return;
                }

                var value = $(this).val();
                $(this).val(''); // хак для хрома
                $(this).val(value);
                event.preventDefault();
            })
            .bind({
                paste : function(event){
                    if($(this).attr('readonly') != undefined || $(this).attr('disabled') != undefined ){
                        return;
                    }

                    //$(this).tr
                    var cursor = $(this).getCursorPosition();

                    $(this).delSelected();
                    var startValue = $(this).val();
                    var key = event.originalEvent.clipboardData.getData('text');

                    var value = startValue.substr(0, cursor) + key + startValue.substring(cursor, startValue.length);
                    value = value.replace(',','.').replace(/[^0-9,\.]/gim,'');
                    $(this).val(priceFormatted(value, $(this).data('fractional-length')));
                    $(this).setCursorPosition(cursor + $(this).val().length - startValue.length);

                    event.preventDefault();
                    $(this).trigger('change');
                },
                cut : function(event){
                    if($(this).attr('readonly') != undefined || $(this).attr('disabled') != undefined ){
                        return false;
                    }

                    var cursor = $(this).getCursorPosition();
                    var startValue = $(this).val();

                    $(this).delSelected();
                    startValue = $(this).val();

                    var value = startValue.substr(0, cursor) + startValue.substring(cursor, startValue.length);
                    $(this).val(priceFormatted(value, $(this).data('fractional-length')));
                    $(this).setCursorPosition(cursor + $(this).val().length - startValue.length);

                    $(this).trigger('change');
                    event.preventDefault();
                }
            })
            .keydown(function (event) {
                if($(this).attr('readonly') != undefined || $(this).attr('disabled') != undefined ){
                    return;
                }

                var cursor = $(this).getCursorPosition();
                var code = event.keyCode;
                var startValue = $(this).val();
                if ((event.metaKey === true && code == 86) ||
                    (event.shiftKey === true && code == 45)) {
                    return false;
                } else if (
                    code == 9 || // tab
                    code == 27 || // ecs
                    event.ctrlKey === true || // все что вместе с ctrl
                    event.metaKey === true ||
                    event.altKey === true || // все что вместе с alt
                    (code >= 112 && code <= 123) || // F1 - F12
                    (code >= 35 && code <= 39)) // end, home, стрелки
                {
                    return;

                } else if (code == 8) {// backspace

                    var delCount = $(this).delSelected();
                    if (!delCount) {
                        if (startValue[cursor - 1] === ' ') {
                            cursor--;
                        }
                        $(this).val(startValue.substr(0, cursor - 1) + startValue.substring(cursor, startValue.length));
                    }
                    $(this).val(priceFormatted($(this).val(), $(this).data('fractional-length')));
                    $(this).setCursorPosition(cursor - (startValue.length - $(this).val().length - delCount));

                } else if (code == 46) { // delete

                    var delCount = $(this).delSelected();
                    if (!delCount) {
                        if (startValue[cursor] === ' ') {
                            cursor++;
                        }
                        $(this).val(startValue.substr(0, cursor) + startValue.substring(cursor + 1, startValue.length));
                    }
                    if (!delCount)delCount = 1;
                    $(this).val(priceFormatted($(this).val(), $(this).data('fractional-length')));
                    $(this).setCursorPosition(cursor - (startValue.length - $(this).val().length - delCount));

                } else {
                    $(this).delSelected();
                    startValue = $(this).val();
                    var key = false;
                    // точка / запятая
                    if (code == 110 || code == 188 || code == 190) {
                        key = '.';
                    }
                    // цифровые клавиши
                    else if ((code >= 48 && code <= 57)) {
                        key = (code - 48);
                    }
                    // numpad
                    else if ((code >= 96 && code <= 105 )) {
                        key = (code - 96);
                    } else {
                        $(this).val(priceFormatted($(this).val(), $(this).data('fractional-length')));
                        $(this).setCursorPosition(cursor);
                        return false;
                    }
                    var length = startValue.length
                    var value = startValue.substr(0, cursor) + key + startValue.substring(cursor, startValue.length);
                    $(this).val(priceFormatted(value, $(this).data('fractional-length')));

                    if(value.split('.').length > 2){
                        cursor++;
                    }

                    $(this).setCursorPosition(cursor + $(this).val().length - startValue.length);
                }
                event.preventDefault();
                $(this).trigger('change');
            });

        return this;
    };
    $.fn.valNumber = function (value, fractional) {
        if(this.length == 0){
            return undefined;
        }

        if(value != undefined){
            value = String(value);

            if(fractional == undefined){
                fractional = $(this).data('fractional-length');

                if(fractional != undefined){
                    value = Number(value.replace(',', '.').replace(/[^0-9,\.]/gim,'')).toFixed(fractional);
                }
            }
            
            $(this).val(priceFormatted(value, fractional));

            return this;
        }

        return Number($(this).val().replace(',', '.').replace(/[^0-9,\.]/gim,''));
    };

    $.fn.textNumber = function (value, fractional, postfix) {
        if(this.length == 0){
            return undefined;
        }

        if(value != undefined){
            value = String(value);

            if(fractional == undefined){
                fractional = $(this).data('fractional-length');

                if(fractional != undefined){
                    value = Number(value.replace(',', '.').replace(/[^0-9,\.]/gim,'')).toFixed(fractional);
                }
            }
            
            if(postfix == undefined){
                postfix = '';
            }
            
            $(this).text(priceFormatted(value, fractional) + postfix);
            return this;
        }

        return Number($(this).text().replace(',', '.').replace(/[^0-9,\.]/gim,''));
    };

    $.fn.htmlNumber = function (value, fractional, postfix) {
        if(this.length == 0){
            return undefined;
        }

        if(value != undefined){
            value = String(value);

            if(fractional == undefined){
                fractional = $(this).data('fractional-length');

                if(fractional != undefined){
                    value = Number(value.replace(',', '.').replace(/[^0-9,\.]/gim,'')).toFixed(fractional);
                }
            }

            if(postfix == undefined){
                postfix = '';
            }

            $(this).html(priceFormatted(value, fractional) + postfix);
            return this;
        }

        return Number($(this).html().replace(',', '.').replace(/[^0-9,\.]/gim,''));
    };

    $.fn.attrNumber = function (name, value, fractional, postfix) {
        if(this.length == 0){
            return undefined;
        }

        if(value != undefined){
            value = String(value);

            if(fractional == undefined){
                fractional = $(this).data('fractional-length');

                if(fractional != undefined){
                    value = Number(value.replace(',', '.').replace(/[^0-9,\.]/gim,'')).toFixed(fractional);
                }
            }

            if(postfix == undefined){
                postfix = '';
            }

            $(this).attr(name, priceFormatted(value, fractional) + postfix);
            return this;
        }

        return Number($(this).attr(name).replace(',', '.').replace(/[^0-9,\.]/gim,''));
    };
})(jQuery);