// function merge_options(obj1,obj2){
//   var obj3 = {};
//   for (var attrname in obj1) { obj3[attrname] = obj1[attrname]; }
//   for (var attrname in obj2) { obj3[attrname] = obj2[attrname]; }
//   return obj3;
// }

function Popup() {
  this.init();
}

Popup.prototype.init = function() {
  this.initWrap();
  this.initListeners();
  console.log('started');
}

Popup.prototype.initWrap = function() {
  var popupWrap = document.createElement('div');
  popupWrap.id = 'PopupWrap';
  popupWrap.classList.add('popup__wrap');
  document.body.appendChild(popupWrap);
  this.wrap = document.getElementById('PopupWrap');

  this.overlay = document.createElement('div');
  this.overlay.dataset.popupclose = 'true';
  this.overlay.classList.add('popup__overlay');

  this.closeBtn = document.createElement('div');
  this.closeBtn.dataset.popupclose = 'true';
  this.closeBtn.classList.add('popup__close');
}

Popup.prototype.initListeners = function() {
  var popupers = document.querySelectorAll('[data-popup="popup"]');
  for (var i = 0; i < popupers.length; i++) {
    popupers[i].addEventListener('click', this.openPopup.bind(this));
  }
}

Popup.prototype.initCloseListeners = function() {
  var closes = this.wrap.querySelectorAll('[data-popupclose="true"]');
  for (var i = 0; i < closes.length; i++) {
    closes[i].addEventListener('click', this.closePopup.bind(this));
  }
}

Popup.prototype.destroyCloseListeners = function() {
  var closes = this.wrap.querySelectorAll('[data-popupclose="true"]');
  for (var i = 0; i < closes.length; i++) {
    closes[i].removeEventListener('click', this.closePopup.bind(this));
  }
}

Popup.prototype.openPopup = function(e) {
  e.preventDefault();
  var popupId = e.target.dataset.popupfor;
  if (popupId) {
    var popup = document.querySelector('[data-popupid="' + popupId + '"]');
    if (popup) {
      bodyScrollLock.disableBodyScroll();
      var popupClone = popup.cloneNode(true);
      this.wrap.appendChild(popupClone);
      popupClone.appendChild(this.closeBtn.cloneNode(true));
      this.wrap.appendChild(this.overlay.cloneNode(true));
      this.initCloseListeners();
    } else {
      console.error('No popup');
    }
  } else {
    console.error('No data attribute');
  }
}

Popup.prototype.closePopup = function(e) {
  e.preventDefault();
  bodyScrollLock.enableBodyScroll();
  this.destroyCloseListeners();
  this.wrap.classList.add('close');
  setTimeout(this.closePopupTimeout.bind(this), 400);
}

Popup.prototype.closePopupTimeout = function() {
  this.wrap.classList.remove('close');
  this.wrap.innerHTML = '';
  console.log(this);
}