(function(window) {

var App = window.App || {}

function Contacts() {
	this.map = false;
	this.radios = [];
	this.mapContainer = document.getElementById('map');

	var radios = document.querySelectorAll('input[name="active_city"]');
	for (var i = 0; i < radios.length; i++) {
		this.radios.push(radios[i]);
		radios[i].onchange = this.changeCity.bind(this);
		if (radios[i].checked) {
			this.active_city = radios[i].id.split('-')[1];
			this.active_coords = [
				Number(radios[i].dataset.mapx),
				Number(radios[i].dataset.mapy)
			];
			this.changeCityActive();
			this.updateMap();
		}
	}
}

Contacts.prototype.updateMap = function() {
	if (typeof window.ymaps === 'undefined') {
		setTimeout(function() {this.updateMap()}.bind(this), 100);
	} else {
		ymaps.ready(function() {
			if (this.active_coords) {
				this.map = new ymaps.Map("map", {
			        center: this.active_coords, 
			        zoom: 15,
			        controls: []
			    })
			    this.map.geoObjects.add(new ymaps.Placemark(this.active_coords));
			} else {
				setTimeout(this.updateMap.bind(this), 100);
			}
		}.bind(this));
	}
}

Contacts.prototype.destroyMap = function() {
	if (this.map) {
		this.map.destroy();
		this.map = false;
	}
}

Contacts.prototype.changeCity = function(e) {
	this.changeCityUnActive();
	this.destroyMap();
	var el = e.target
	this.active_city = el.id.split('-')[1];
	this.active_coords = [
		Number(el.dataset.mapx),
		Number(el.dataset.mapy)
	];
	this.updateMap();
	this.changeCityActive();
}

Contacts.prototype.changeCityActive = function() {
	var elements = document.querySelectorAll('*[data-city="' + this.active_city + '"]');
	for (var i = 0; i < elements.length; i++) {
		elements[i].style.display = 'block';	
	}
}

Contacts.prototype.changeCityUnActive = function() {
	var elements = document.querySelectorAll('*[data-city="' + this.active_city + '"]');
	for (var i = 0; i < elements.length; i++) {
		elements[i].style.display = 'none';	
	}
}

App.Contacts = Contacts
window.App = App


})(window)