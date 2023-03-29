(function(window) {

var App = window.App || {}

function Catalog() {
	this.catalog = this.getCatalog();
	this.config = {
		list:  document.querySelector('#catalog_list'),
		switch: document.querySelector('#catalog_switch'),
		switchSort: document.querySelector('#catalog_switch_sort'),
		loading: '.catalog__loading__wrap'
	}
	this.buffer = [];
	this.sortArr = [];

	this.stepAddProducts = 3;

	this.isEnd = false;

	this.activeSort = 0;
	this.activeSortBy = false;
	this.activeProducts = 0;

	this.createControlPanel();
	this.addEvent();
}
Catalog.prototype.resetList = function() {
	var container = this.config.list
	,	children = []
	for (var i = 0; i < container.children.length; i++) {
		children.push(container.children[i]);
	}
	children.forEach(function(el) {
		container.removeChild(el);
	})
	this.activeProducts = 0;
	this.isEnd = false;
	this.removeEvent();
	this.addEvent();
}

Catalog.prototype.getCatalog = function() {
	return [
		{
			title: 'Компрессора',
			sort: {
				by: 'power',
				title: 'Мощность'
			},
			products: [
				{ 
					id: 13,
					producer: 'ATMOS',
					model: 'PDP190',
					lease: true,
					bigImageSrc: '/img/main/slider/big1.png',
					tth: {
						'Производительность': 'до 24,8 м3/мин.',
						'Дизельный двигатель': 'Perkins 1106D-E70TA.',
						'Номинальная мощность - ': '186 кВт.'
					},
					sort: {
						key: 'power',
						text: '181 Квт'
					},
					link: '/catalog/product/atmos_pdp190'
				},
				{ 
					id: 13,
					producer: 'ATMOS',
					model: 'PDP190',
					lease: false,
					bigImageSrc: '/img/main/slider/big1.png',
					tth: {
						'Производительность': 'до 24,8 м3/мин.',
						'Дизельный двигатель': 'Perkins 1106D-E70TA.',
						'Номинальная мощность - ': '186 кВт.'
					},
					sort: {
						key: 'power',
						text: '18126 Квт'
					},
					link: '/catalog/product/atmos_pdp190'
				},
				{ 
					id: 13,
					producer: 'ATMOS',
					model: 'PDP190',
					lease: true,
					bigImageSrc: '/img/main/slider/big1.png',
					tth: {
						'Производительность': 'до 24,8 м3/мин.',
						'Дизельный двигатель': 'Perkins 1106D-E70TA.',
						'Номинальная мощность - ': '186 кВт.'
					},
					sort: {
						key: 'power',
						text: '18326 Квт'
					},
					link: '/catalog/product/atmos_pdp190'
				},
				{ 
					id: 13,
					producer: 'ATMOS',
					model: 'PDP190',
					lease: true,
					bigImageSrc: '/img/main/slider/big1.png',
					tth: {
						'Производительность': 'до 24,8 м3/мин.',
						'Дизельный двигатель': 'Perkins 1106D-E70TA.',
						'Номинальная мощность - ': '186 кВт.'
					},
					sort: {
						key: 'power',
						text: '186 Квт'
					},
					link: '/catalog/product/atmos_pdp190'
				},
				{ 
					id: 13,
					producer: 'ATMOS',
					model: 'PDP190',
					lease: true,
					bigImageSrc: '/img/main/slider/big1.png',
					tth: {
						'Производительность': 'до 24,8 м3/мин.',
						'Дизельный двигатель': 'Perkins 1106D-E70TA.',
						'Номинальная мощность - ': '186 кВт.'
					},
					sort: {
						key: 'power',
						text: '186 Квт'
					},
					link: '/catalog/product/atmos_pdp190'
				},
				{ 
					id: 13,
					producer: 'ATMOS',
					model: 'PDP190',
					lease: true,
					bigImageSrc: '/img/main/slider/big1.png',
					tth: {
						'Производительность': 'до 24,8 м3/мин.',
						'Дизельный двигатель': 'Perkins 1106D-E70TA.',
						'Номинальная мощность - ': '186 кВт.'
					},
					sort: {
						key: 'power',
						text: '186 Квт'
					},
					link: '/catalog/product/atmos_pdp190'
				},
				{ 
					id: 13,
					producer: 'ATMOS',
					model: 'PDP190',
					lease: true,
					bigImageSrc: '/img/main/slider/big1.png',
					tth: {
						'Производительность': 'до 24,8 м3/мин.',
						'Дизельный двигатель': 'Perkins 1106D-E70TA.',
						'Номинальная мощность - ': '186 кВт.'
					},
					sort: {
						key: 'power',
						text: '186 Квт'
					},
					link: '/catalog/product/atmos_pdp190'
				}
			]
		},
		{
			title: 'Генераторы',
			sort: {
				by: 'power',
				title: 'Мощность'
			},
			products: [
				{
					id: 13,
					producer: 'ATMOS',
					model: 'PDP190',
					lease: true,
					bigImageSrc: '/img/main/slider/big1.png',
					tth: {
						'Производительность': 'до 24,8 м3/мин.',
						'Дизельный двигатель': 'Perkins 1106D-E70TA.',
						'Номинальная мощность - ': '186 кВт.'
					},
					sort: {
						key: 'power',
						text: '136 Квт'
					},
					link: '/catalog/product/atmos_pdp190'
				},
				{
					id: 13,
					producer: 'ATMOS',
					model: 'PDP95',
					lease: false,
					bigImageSrc: '/img/main/slider/big1.png',
					tth: {
						'Производительность': 'до 24,8 м3/мин.',
						'Дизельный двигатель': 'Perkins 1106D-E70TA.',
						'Номинальная мощность - ': '186 кВт.'
					},
					sort: {
						key: 'power',
						text: '186 Квт'
					},
					link: '/catalog/product/atmos_pdp190'
				}
			]
		}
	]
}

Catalog.prototype.isVisible = function(elem) {
	var coords = elem.getBoundingClientRect()
	, windowHeight = document.documentElement.clientHeight
	, extendedTop = -windowHeight
	, extendedBottom = 1.5 * windowHeight
	, bottomVisible = coords.bottom < extendedBottom && coords.bottom > extendedTop;
	return bottomVisible;
}

Catalog.prototype.scrollEvent = function() {
	if (this.isEnd) {
		this.removeEvent();
	} else {
		if (this.isVisible(this.config.list)) {
			this.addProducts();
		}
	}
}

Catalog.prototype.addEvent = function() {
	if (window.onscroll !== null) {
		return true;
	} else {
		this.scrollEvent()
		window.onscroll = this.scrollEvent.bind(this);
	}
}

Catalog.prototype.removeEvent = function() {
	if (window.onscroll === null) {
		return true;
	} else {
		window.onscroll = null;
	}
}

Catalog.prototype.createControlPanel = function() {
	var container = this.config.switch;
	this.catalog.forEach( function(el, index) {
		if (typeof el.title === 'string') {
			var newButton = document.createElement('div')
			,	checked = ''
			,	itsCurrent =this.activeSort === index;
			if (itsCurrent)	checked = 'checked';
			newButton.classList.add('catalog__switch__radio');
			newButton.innerHTML = '\
				<input \
					class="catalog__switch__radio__input" \
					name="catalog_sort" ' + checked + ' type="radio" \
					id="radio-' + index + '" \
					type="text" \
					value="' + index + '">\
				<label class="catalog__switch__radio__text btn" for="radio-' + index + '">\
					' + el.title + '\
				</label>';
			newButton.querySelector('input').onchange = this.changeList.bind(this);
			container.insertBefore(newButton, container.children[container.children.length - 1]);
		}
	}, this);
	this.createSortList()
}

Catalog.prototype.createSortList = function() {
	var currentList = this.catalog[this.activeSort]
	,	currentSort = currentList.sort
	,	container = this.config.switchSort
	,	lastElem = container.querySelector('li[data-sort="reset"]')
	,	sortList = currentList.products.map(function (el) {
		if (typeof el.sort !== 'undefined') {
			if (el.sort.key === currentSort.by) {
				return el;
			}
		}
	}, this);
	sortList = this.removeDubble(sortList)
	sortList.forEach(function(el, index) {
		var newButton = document.createElement('li')
		,	defaultText = this.catalog[this.activeSort].sort.title || 'Сортировка';
		newButton.classList.add('catalog__switch__sort__list__item');
		newButton.classList.add('btn');
		newButton.innerHTML = '\
			<input \
				class="catalog__switch__sort__radio__input" \
				name="catalog_sort_by" type="radio" \
				id="radio_sort_by-' + index + '" \
				value="' + index + '">\
			<label \
				class="catalog__switch__sort__radio__text" \
				for="radio_sort_by-' + index + '">\
				' + el + '\
			</label>';
		newButton.querySelector('input').onchange = this.changeSort.bind(this);
		container.insertBefore(newButton, lastElem);
	}, this);
	this.sortArr = sortList;
	lastElem.onclick = this.resetSort.bind(this);
}

Catalog.prototype.clearSortList = function() {
	var container = this.config.switchSort
	,	limit = container.children.length
	,	buffer = []
	if (limit > 1) {
		for (var i = 0; i < limit - 1; i++)
			buffer.push(container.children[i]);
	}
	buffer.forEach(function(el) {
		container.removeChild(el)
	})
}

Catalog.prototype.removeDubble = function(arr) {
  var obj = {};
  for (var i = 0; i < arr.length; i++) {
    var str = arr[i].sort.text;
    obj[str] = true;
  }
  return Object.keys(obj);
}

Catalog.prototype.changeList = function(e) {
	this.activeSort = Number(e.target.value);
	this.resetSort();
	this.clearSortList();
	this.createSortList();
	this.resetList();
}
Catalog.prototype.changeSort = function(e) {
	this.activeSortBy = Number(e.target.value);
	this.resetList();
}
Catalog.prototype.resetSort = function() {
	var isReRender = false;
	this.config.switchSort.querySelectorAll('input[type="radio"]').forEach(function(el) {
		if (el.checked === true) {
			el.checked = false;
			if (isReRender === false) isReRender = true;
		}
	});
	if (isReRender === true) {
		this.activeSortBy = false;
		this.resetList();
	}
}
 
Catalog.prototype.addProducts = function() {
	var limit = this.activeProducts + this.stepAddProducts
	,	container = this.config.list;
	if (this.activeSortBy === false) {
		for (this.activeProducts; this.activeProducts < limit; this.activeProducts++) {
			if (typeof this.catalog[this.activeSort].products[this.activeProducts] === 'undefined') {
				this.isEnd = true;
				break;
			} else {
				container.appendChild(this.addProduct(this.catalog[this.activeSort].products[this.activeProducts]));
			}
		}
	} else {
		var arr = this.catalog[this.activeSort].products;
		if (this.sortArr.length > 0) {
			for (this.activeProducts; this.activeProducts < limit; this.activeProducts++) {
				if (typeof arr[this.activeProducts] === 'undefined') {
					this.isEnd = true;
					break;
				} else {
					if (arr[this.activeProducts].sort.text.length === this.sortArr[this.activeSortBy].length) {
						if (arr[this.activeProducts].sort.text.localeCompare(this.sortArr[this.activeSortBy]) === 0) {
							container.appendChild(this.addProduct(arr[this.activeProducts]));
						} else {
							++limit;
						}
					} else {
						++limit;
					}
				}
			}
		}
	}
}

Catalog.prototype.addProduct = function(data) {
	var product = document.createElement('div')
	,	lease = ''
	,	tth = Object.keys(data.tth).map(function(el) {
			return el + ' <span>' + data.tth[el] + '</span>';
		}).reduce(function(prev, next) {
			return prev + '<br/>' + next;
		})
	,	timestamp = new Date().getTime();
	if (data.lease === true) {
		lease = '<div class="catalog__product__title__lease__wrap">\
					<div class="lease_true catalog__product__title__lease">\
						Доступен в аренду\
					</div>\
				 </div>';
	}
	product.classList.add('col-12');
	product.classList.add('catalog__product__wrap_block');
	product.innerHTML = '<div class="catalog__product__wrap">\
				<div class="row relative">\
					<div class="col-6 align-self-lg-center">\
						<header class="catalog__product__title">\
							<div class="row">\
								<div class="col-lg-3 col-6 fix420 fix420margin catalog__product__zi align-self-center">\
									' + lease + '\
								</div>\
								<div class="col-lg-3 col-6 fix420 catalog__product__zi justify-content-lg-end">\
									<div class="catalog__product__title__model">\
										<h2>' + data.producer + ' <span>' + data.model + '</span>\
									</div>\
								</div>\
							</div>\
						</header>\
						<div class="catalog__product__tth__wrap">\
							<div class="row">\
								<div class="col-6 fix420 catalog__product__zi">\
									<p class="catalog__product__tth">\
										' + tth + '\
									</p>\
									<span class="btn catalog__product__tth__more_info">\
										<a href="' + data.link + '">\
											Подробнее\
											<img src="/img/page/more_info.png" alt="More info">\
										</a>\
									</span>\
								</div>\
							</div>\
						</div>\
					</div>\
					<div class="col-6 catalog__product__preview_img align-self-lg-center">\
						<img src="' + data.bigImageSrc + '?' + (+timestamp + +this.activeProducts) + '" alt="Preview image">\
						<div class="row justify-content-center loading__wrap loading">\
							<div class="loading">\
								<div class="loading__dotes">\
									<div class="loading__dote"></div>\
									<div class="loading__dote"></div>\
									<div class="loading__dote"></div>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>';
	product.querySelector('.catalog__product__preview_img').querySelector('img').onload = this.imageOnLoad.bind(this);
	return product;
}

Catalog.prototype.imageOnLoad = function(e) {
	e.target.style.display = 'inline-block';
	e.target.nextElementSibling.classList.remove('loading');
}

App.Catalog = Catalog
window.App = App


})(window)