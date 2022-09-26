function newsSlider() {
	const modifiers = {
		controlNews: 'news-slider__control--active',
	};

	const elNews = document.querySelector('.js-news-slider');
	if (elNews === null) {
		// console.log("newsSlider left html");
	} else {
		const newsItem = elNews.querySelectorAll('.js-news-slider__item');
		const newsItems = elNews.querySelector('.js-news-slider__items');
		const newsNext = elNews.querySelector('.js-news-slider__next');
		const newsPrevious = elNews.querySelector('.js-news-slider__previous');

		//Max value is scrollWidth - clientWidth, since it's the right side of the block
		const maxScrollValueN = newsItems.scrollWidth - elNews.clientWidth;
		//State values
		let currentSlideN = 0;
		let currentXN = 0;

		//Toggle controls visibility
		const updateNewsControls = () => {
			//Hide previous button if we are at the start
			newsPrevious.classList.toggle(modifiers.controlNews, currentXN !== 0);
			//Hide next button if we are at the end
			newsNext.classList.toggle(modifiers.controlNews, currentXN < maxScrollValueN);
		};

		//Slide to card by its index
		const slideToNews = (index) => {
			//Check for minimal/maximal valid endexes
			if(index < 0 || index > newsItems.length - 1) return;

			//Get total width of all items. CSS is built the way that items don't have any offsets between them.
			//Padding are used for that reason
			let scrollValueN = 0;
			for(let i = 0; i < index; i++) {
				scrollValueN += newsItem[i].clientWidth;
			}

			//Limit by maximal scroll value
			const targetValueN = Math.min(scrollValueN, maxScrollValueN);

			//Scroll to card
			newsItems.scrollTo({left: targetValueN, behavior: 'smooth'});

			//Update state values and controls
			currentSlideN = index;
			currentXN = targetValueN;
			updateNewsControls();
		};

		//Update controls on page load, They start hidden not to have visible controls that can't be clicked while js still loads.
		updateNewsControls();

		//Whenever you click controls you go to next or previous index
		newsNext.addEventListener('click', () => slideToNews(currentSlideN + 1));
		newsPrevious.addEventListener('click', () => slideToNews(currentSlideN - 1));

	}
		}
		

newsSlider();