(function(window) {

var App = window.App || {}

function Lease() {
	this.config = {
		select: document.getElementById('lease_select'),
		totalPrice: document.getElementById('lease_price'),
		date: {
			title: document.getElementById('lease_date_text'),
			input: document.getElementById('lease_date'),
			post: document.getElementById('lease_date_post'),
			value: false
		},
		first: {
			title: document.getElementById('lease_first_installment_text'),
			input: document.getElementById('lease_first_installment'),
			post: document.getElementById('lease_first_installment_post'),
			value: false
		},
		styleBlock: document.querySelectorAll('.lease_calc_style'),
		subtotal: {
			first: document.getElementById('lease_subtotal_first'),
			mount: document.getElementById('lease_subtotal_mount'),
			total: document.getElementById('lease_subtotal_total')
		}
	}
	this.current = {
		date: 1,
		first: 0
	}
	this.prices = {
		total: 0,
		oneMount: 0,
		first: 0,
		mount: 0,
		final: 0
	}
	this.state = this.getData();
	this.createSettingsInput(this.config.date.input, this.config.date.post, this.state.date);
	this.createSettingsInput(this.config.first.input, this.config.first.post, this.state.first);
	this.initializeDropdown();
}

Lease.prototype.getData = function() {
	return {
		date : {
			postfix: ' мес.',
			method: '/',
			breakpoints: ['1','3','6','9','12']
		},
		first: {
			postfix: '%',
			method: '%',
			breakpoints: ['0', '30','40','50','60','70','80','90']
		}
	}
}

Lease.prototype.initializeEvents = function(input, max, def) {
	var defText = def || 1;
	input.oninput = this.onChangeInput.bind(this);
	input.max = max;
	input.value = defText;
}

Lease.prototype.initializeDropdown = function() {
	var elements = this.config.select.querySelectorAll('ul li');
	for (var i = 0; i < elements.length; i++) {
		if (elements[i].dataset.def === 'true') {
			this.changeModel(false, elements[i]);
		}
		elements[i].onclick = this.changeModel.bind(this);
	}
}

Lease.prototype.changeModel = function(e, def) {
	if (typeof def === 'undefined') {
		try {
			this.prices.total = Number(e.target.dataset.value);
			this.recalculation();
			this.config.select.blur();
			this.config.select.querySelector('.lease__calc__select__preview').innerText = e.target.innerText;
		} catch (err) {
			console.log(err);
		}
	} else {
		try {
			this.prices.total = Number(def.dataset.value);
			this.recalculation();
			this.config.select.blur();
			this.config.select.querySelector('.lease__calc__select__preview').innerText = def.innerText;
		} catch (err) {
			console.log(err);
		}
	}
}

Lease.prototype.createSettingsInput = function(input, post, data) {
	var postfix = data.postfix || '';
	var	amount = data.breakpoints.length;
	var	blocks = [];
	for (var i = 0; i < amount; i++) {
		if (i === 0) {
			blocks.push(data.breakpoints[i] + postfix)
			continue; }
		if (i === Math.round((amount - 1) / 2)) {
			blocks.push(data.breakpoints[i] + postfix)
			continue; }
		if (i === (amount - 1)) {
			blocks.push(data.breakpoints[i] + postfix)
			continue; }
		blocks.push('');
		continue;
	}
	blocks.forEach(function(el) {
		var pre = document.createElement('div');
		pre.innerHTML = '<span>' + el + '</span>';
		post.appendChild(pre);
	});
	this.initializeEvents(input, amount - 1, Math.round((amount - 1) / 2))
	this.onChangeInput(false, {value: Math.round((amount - 1) / 2), max: amount - 1, id: input.id})
}

Lease.prototype.onChangeInput = function(e, reserve) {
	if (e !== false) {
		var value = e.target.value;
		var	max = e.target.max;
		var	id = e.target.id;
	} else {
		var value = reserve.value;
		var	max = reserve.max;
		var	id = reserve.id;
	}
	var styleBlock = this.config.styleBlock;
	switch(id) {
		case this.config.date.input.id:
			styleBlock[0].innerHTML = '\
				#lease_date:before {right: ' + (100 - +100 / +max * +value) + '%}\
				#lease_date:after {right: calc(' + (100 - +100 / +max * +value) + '% - 5px)}\
			';
			var postfix = typeof this.state.date.postfix !== 'undefined' ? this.state.date.postfix : ''
			this.config.date.title.innerHTML = String(this.state.date.breakpoints[value] + postfix);
			this.current.date = Number(this.state.date.breakpoints[value]);
			break;
		case this.config.first.input.id:
			styleBlock[1].innerHTML = '\
				#lease_first_installment:before {right: ' + (100 - +100 / +max * +value) + '%}\
				#lease_first_installment:after {right: calc(' + (100 - +100 / +max * +value) + '% - 5px)}\
			';
			var postfix = typeof this.state.first.postfix !== 'undefined' ? this.state.first.postfix : ''
			this.config.first.title.innerHTML = String(this.state.first.breakpoints[value] +  postfix);
			this.current.first = Number(this.state.first.breakpoints[value]);
			break;
		default:
			break;
	}
	this.recalculation();
}

Lease.prototype.recalculation = function() {
	var oneMount = this.prices.oneMount = Math.ceil(this.prices.total / 300);
	this.setPrice(this.config.totalPrice, this.prices.total);
	this.prices.first = Math.ceil((oneMount - oneMount / 100 * (100 - this.current.first)) * this.current.date);
	this.prices.mount = Math.ceil(oneMount - (oneMount - oneMount / 100 * (100 - this.current.first)));
	this.prices.final = Math.ceil(oneMount * this.current.date);
	this.setPrice(this.config.subtotal.first, this.prices.first);
	this.setPrice(this.config.subtotal.mount, this.prices.mount);
	this.setPrice(this.config.subtotal.total, this.prices.final);
}

Lease.prototype.setPrice = function(el, price) {
	el.innerText = String(price).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ') + ' тг.';
}

App.Lease = Lease
window.App = App


})(window)