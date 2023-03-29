(function(window) {

var App = window.App || {}

function About() {
	this.radios = [];

	var radios = document.querySelectorAll('input[name="active_company"]');
	for (var i = 0; i < radios.length; i++) {
		this.radios.push(radios[i]);
		radios[i].onchange = this.changeCompany.bind(this);
		if (radios[i].checked) this.active_company = radios[i].id.split('-')[1];
	}
}

About.prototype.changeCompany = function(e) {
	this.changeCompanyUnActive();
	this.active_company = e.target.id.split('-')[1];
	this.changeCompanyActive();
}

About.prototype.changeCompanyActive = function() {
	var elements = document.querySelectorAll('*[data-company="' + this.active_company + '"]');
	for (var i = 0; i < elements.length; i++) {
		elements[i].style.display = 'block';	
	}
}

About.prototype.changeCompanyUnActive = function() {
	var elements = document.querySelectorAll('*[data-company="' + this.active_company + '"]');
	for (var i = 0; i < elements.length; i++) {
		elements[i].style.display = 'none';	
	}
}

App.About = About
window.App = App


})(window)