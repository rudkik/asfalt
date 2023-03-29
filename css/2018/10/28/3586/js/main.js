function insertTextAtCursor(el, text, offset) {
    var val = el.value, endIndex, range, doc = el.ownerDocument;
    if (typeof el.selectionStart == "number"
        && typeof el.selectionEnd == "number") {
        endIndex = el.selectionEnd;
        el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length+(offset?offset:0);
    } else if (doc.selection != "undefined" && doc.selection.createRange) {
        el.focus();
        range = doc.selection.createRange();
        range.collapse(false);
        range.text = text;
        range.select();
    }
}
$('[data-action="english"]').keydown(function(e) {
    if ((e.ctrlKey == false) && (e.altKey == false)) {
        if (e.keyCode > 64 && e.keyCode < 91) {
            var id = $(this).attr('id');
            insertTextAtCursor(document.getElementById(id), String.fromCharCode(e.keyCode));
            e.preventDefault();
            return false;
        }
    }
});