(function(window) {

var App = window.App || {}

function Main(data) {
	var bigSlider = '#main__page__slider',
	smallSlider = '#main__page__catalog__slider__description';
	this.slider = this.getSlider(data);
	console.log('App started!');
	if (this.slider) {
		console.log('App started Success!');
		this.slider.forEach(function(el) { 
			this.createSlideHTML(el, this.slider.length);
		}.bind(this));
		this.initializationSlick([bigSlider, smallSlider]);
	} else {
		console.error('App not started!');
		return false;
	}
}

Main.prototype.getSlider = function(data) {
	if (typeof data === 'string') {
		try {
			return JSON.parse(data);
		} catch (err) {
			console.log(data);
			console.log(err);
		}
	} else {
		console.log(data);
		return false;
	}
}

Main.prototype.createSlideHTML = function(data, max) {
	var limit = max || 1
	var nextPrevArrows = '';
	if (!data) {
		return false;
	}
	var newSlide = document.createElement('div');
	var	newSlideDesc = document.createElement('div');
	var	lease = '';
	var	bigSlider = '#main__page__slider';
	var	smallSlider = '#main__page__catalog__slider__description';
	var	bigImg = '';
	if (data.lease) {
		lease = '<div class="lease_true main__page__catalog__slider__slide__block__info__lease">\
				Доступен в аренду\
			</div>';
	}
	bigImg = '\
		<figure class="main__page__catalog__slider__slide__block__big_img">\
			<img src="' + data.bigImageSrc + '" alt="' + data.producer + ' ' + data.model + '">\
		</figure>';
	if (typeof data.characteristic !== 'string') {
		data.characteristic = '';
	}

	newSlide.classList.add("main__page__catalog__slider__slide");
	newSlideDesc.classList.add("container-fluid");

	newSlide.innerHTML = '<div class="container">\
					<div class="row">\
						<div class="col-md col-12">\
							<div class="main__page__catalog__slider__slide__block__wrap">\
								<div class="main__page__catalog__slider__slide__block__left">\
									<div class="main__page__catalog__slider__slide__block__info">\
										<h2>' + data.producer + ' <span>' + data.model + '</span>\
										</h2>\
										<h3>\
											' + data.description + '\
										</h3>\
										<a href="' + data.link + '" class="main__page__catalog__slider__slide__block__right__mob">\
										' + bigImg + '\
										</a>\
										' + lease + '\
									</div>\
									<figure class="main__page__catalog__slider__slide__block__small_img">\
										<img src="' + data.smallImageSrc + '" alt="Small image">\
									</figure>\
								</div>\
							</div>\
						</div>\
						<div class="col-md col-12">\
							<div class="main__page__catalog__slider__slide__block__wrap">\
								<div class="main__page__catalog__slider__slide__block__right">\
									<a href="' + data.link + '">\
									' + bigImg + '\
									</a>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>';
	if (limit > 1) {
		nextPrevArrows = '\
						<button class="main__page__catalog__slider__slide__block__description__arrow main__page__catalog__slider__slide__block__description__arrow__left">\
							<img src="http://kompresory.kz/css/2018/09/01/3582/img/page/slider_arrow_left.png" alt="Prev slide">\
						</button>\
						<button class="main__page__catalog__slider__slide__block__description__arrow main__page__catalog__slider__slide__block__description__arrow__right">\
							<img src="http://kompresory.kz/css/2018/09/01/3582/img/page/slider_arrow_left.png" alt="Next slide">\
						</button>';
	}

	newSlideDesc.innerHTML = '\
		<div class="container">\
			<div class="row justify-content-center justify-content-md-end relative">\
				<div class="main__page__catalog__slider__slide__block__description">\
					<div class="main__page__catalog__slider__slide__block__description__text">\
						<p>' + data.characteristic + '\
						</p>\
						<span class="btn main__page__catalog__slider__slide__block__description__more_info">\
							<a href="' + data.link + '">\
								Подробнее\
								<img src="http://kompresory.kz/css/2018/09/01/3582/img/page/more_info.png" alt="More info">\
							</a>\
						</span>\
					</div>\
					' + nextPrevArrows + '\
					</div>\
				</div>\
			</div>\
		</div>';
	document.querySelector(bigSlider).appendChild(newSlide);
	document.querySelector(smallSlider).appendChild(newSlideDesc);
}

Main.prototype.initializationSlick = function(ids) {
	if (typeof jQuery !== 'undefined') {
		if(typeof jQuery().slick !== 'undefined') {
			for (var i = 0; i < ids.length; i++) {
				switch(ids[i]) {
					case '#main__page__slider':
						$(ids[i]).slick({
							adaptiveHeight: true,
							infinite: false,
							arrows: false,
							infinite: true,
							asNavFor: '#main__page__catalog__slider__description'
						});
						break;
					case '#main__page__catalog__slider__description':
						$(ids[i]).slick({
							zIndex: 1001,
							infinite: false,
							arrows: false,
							infinite: true,
							fade: true,
							speed: 0,
							asNavFor: '#main__page__slider'
						});
						break;
					default:
						$(ids[i]).slick();
						break;
				}
			}
			var lefts = document.querySelectorAll('.main__page__catalog__slider__slide__block__description__arrow__left'),
				rights = document.querySelectorAll('.main__page__catalog__slider__slide__block__description__arrow__right');

			for (var j = 0; j < lefts.length; j++) {
				lefts[j].addEventListener('click' ,function () {
					$("#main__page__slider").slick("slickPrev");
				});
				rights[j].addEventListener('click' ,function () {
					$("#main__page__slider").slick("slickNext");
				});
			}
		} else {
			console.error('Slick don\'t loading!');
			setTimeout(function() {this.initializationSlick(ids)}.bind(this) ,100);
		}
	} else {
		console.error('jQuery don\'t loading!');
		setTimeout(function() {this.initializationSlick(ids)}.bind(this) ,100);
	}
}

App.Main = Main
window.App = App


})(window)