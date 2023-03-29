(function(window) {

var App = window.App || {}

function Table(id) {
  console.time('start');
  if (typeof id === 'string') {
    this.init(id);
  }
  console.timeEnd('start');
}

Table.prototype.recursiveRemoveStyle = function(block) {
  if (typeof block !== 'undefined') {
    if (block.hasAttribute('style')) {
      block.removeAttribute('style');
    }
    if (block.children.length > 0) {
      for (var i = 0; i < block.children.length; i++) {
        this.recursiveRemoveStyle(block.children[i]);
      }
    }
  }
}

Table.prototype.init = function(id) {
  var tablewrap = document.getElementById(id);
  if (tablewrap) {
    this.table = tablewrap.querySelector('table');
    this.recursiveRemoveStyle(this.table);
    if (this.table.hasAttribute('class')) {
      this.table.removeAttribute('class');
    }
    this.table.classList.add('product__table__wrap');
    this.bandedRows();
  }
}

Table.prototype.bandedRows = function() {
  var elem = this.table.querySelector('tbody');
  var currentRow;
  var currentColumn;
  var action = 'band';
  for (var i = 0; i < elem.children.length; i++) {
    currentRow = elem.children[i];
    if (!elem.children[i].classList.contains('inited')) {
      if (action === 'band') {
        currentRow.classList.add('band');
      }
      currentRow.classList.add('inited');
      for (var j = 0; j < currentRow.children.length; j++) {
        currentColumn = currentRow.children[j];
        var space = currentColumn.rowSpan;
        if (space > 1) {
          for (var k = i + 1; k < i + space; k++) {
            if (action === 'band') {
              elem.children[k].classList.add('band');
            }
            elem.children[k].classList.add('inited');
          }
        }
      }
      if (action === 'band') {
        action = '';
      } else {
        action = 'band';
      }
    }
  }
}

App.Table = Table;
window.App = App;
})(window)