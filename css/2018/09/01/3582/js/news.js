(function(window) {

var App = window.App || {}

function News(year) {
	this.container = document.querySelector('#news_container');
	this.activeYear = document.querySelector('#news_active_year');
	this.archiveYears = document.querySelector('#news_archive_year');
	this.news = this.getNews();
	this.years = this.getYears(this.news);
	this.buffer = [];
	this.sortArr = [];

	this.activeSort = 0;
	this.activeSortBy = false;
	this.activeNews = 0;
	this.stepAddNews = 3;

	this.isEnd = false;

	if (typeof year !== 'undefined')
		this.activeSortBy = Number(year)

	this.createYearsPanel();
	this.addEvent();
}

News.prototype.isVisible = function(elem) {
	var coords = elem.getBoundingClientRect()
	, windowHeight = document.documentElement.clientHeight
	, extendedTop = -windowHeight
	, extendedBottom = 1.5 * windowHeight
	, bottomVisible = coords.bottom < extendedBottom && coords.bottom > extendedTop;
	return bottomVisible;
}

News.prototype.scrollEvent = function() {
	if (this.isEnd) {
		this.removeEvent();
	} else {
		if (this.isVisible(this.container)) {
			this.addNewss();
		}
	}
}

News.prototype.addEvent = function() {
	if (window.onscroll !== null) {
		return true;
	} else {
		this.scrollEvent()
		window.onscroll = this.scrollEvent.bind(this);
	}
}

News.prototype.removeEvent = function() {
	if (window.onscroll === null) {
		return true;
	} else {
		window.onscroll = null;
	}
}

News.prototype.getYears = function(data) {
	var years = {};
	for (var i = 0; i < data.length; i++) {
		years[data[i].year] = true;
	}
	return Object.keys(years).sort(function(a,b) {
		if (Number(a) > Number(b))
			return 1
		else if (Number(a) < Number(b))
			return -1
		else
			return 0
	}).map(function(el) {return Number(el)});
}

News.prototype.createYearsPanel = function() {
	var all = this.years.concat([])
	,	active = all.pop();
	this.activeYear.appendChild(this.createYearsItem(active));
	for (var i = 0; i < all.length; i++)
		this.archiveYears.appendChild(this.createYearsItem(all[i]));
}

News.prototype.createYearsItem = function(year) {
	var item = document.createElement('span');
	item.innerHTML = '<a href="/news/year/' + year + '">' + year + '</a>'
	return item;
}


News.prototype.getNews = function() {
	return [
		{
			id: 14,
			year: 2018,
			previewImageSrc: '/img/main/news/news1.jpg',
			date: '24 мая',
			title: 'Книга об ATMoSe',
			description: 'Инженерная компания в Храсте была «рождена» во времена Габсбургской монархии.',
			link: '/news/kniga_ob_atmose'
		},
		{
			id: 14,
			year: 2018,
			previewImageSrc: '/img/main/news/news1.jpg',
			date: '24 мая',
			title: 'Книга об ATMoSe2',
			description: 'Инженерная кdvsdefvwadfwafwadfwafawfawfawfawfawfawfawfawfawfafawfwafwafawfawfawdfwafawомпания в Храсте была «рождена» во времена Габсбургской монархии.',
			link: '/news/kniga_ob_atmose'
		},
		{
			id: 14,
			year: 2017,
			previewImageSrc: '/img/main/news/news1.jpg',
			date: '24 мая',
			title: 'Книга об ATMoSe',
			description: 'Инженерная компания в Храсте была «рождена» во времена Габсбургской монархии.',
			link: '/news/kniga_ob_atmose'
		}
	]
}

 
News.prototype.addNewss = function() {
	var limit = this.activeNews + this.stepAddNews
	,	container = this.container
	,	arr = this.news;
	if (this.activeSortBy === false) {
		for (this.activeNews; this.activeNews < limit; this.activeNews++) {
			if (typeof arr[this.activeNews] === 'undefined') {
				this.isEnd = true;
				break;
			} else {
				container.appendChild(this.addNews(arr[this.activeNews]));
			}
		}
	} else {
		for (this.activeNews; this.activeNews < limit; this.activeNews++) {
			if (typeof arr[this.activeNews] === 'undefined') {
				this.isEnd = true;
				break;
			} else {
				if (Number(arr[this.activeNews].year) === this.activeSortBy)
					container.appendChild(this.addNews(arr[this.activeNews]));
				else
					++limit;
			}
		}
	}
}

News.prototype.addNews = function(data) {
	var product = document.createElement('div')
	,	timestamp = new Date().getTime();
	product.classList.add('col-12');
	product.classList.add('col-sm-auto');
	product.classList.add('col-lg-12');
	product.classList.add('margin-auto');
	product.innerHTML = '<div class="news__block">\
							<figure class="news__block__img">\
								<img class="news__block__img__img" src="' + data.previewImageSrc + '" alt="News 1 image">\
								<div class="loading__wrap loading">\
									<div class="loading">\
										<div class="loading__dotes">\
											<div class="loading__dote"></div>\
											<div class="loading__dote"></div>\
											<div class="loading__dote"></div>\
										</div>\
									</div>\
								</div>\
							</figure>\
							<div class="news__block__date">\
								' + data.date + '\
							</div>\
							<div class="news__block__title">\
								' + data.title + '\
							</div>\
							<div class="news__block__desc">\
								' + data.description + '\
							</div>\
							<span class="btn news__block__more_info">\
								<a href="' + data.link + '">\
									Подробнее\
									<img src="/img/page/more_info.png" alt="More info">\
								</a>\
							</span>\
						</div>';
	product.querySelector('img.news__block__img__img').onload = this.imageOnLoad.bind(this);
	return product;
}

News.prototype.imageOnLoad = function(e) {
	var target = e.target;
	target.classList.add('loaded');
	target.nextElementSibling.classList.remove('loading');
}

App.News = News
window.App = App


})(window)