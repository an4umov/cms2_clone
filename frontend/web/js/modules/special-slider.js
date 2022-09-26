function specialSlider() {
	const modifiers = {
		controlActive: 'special-slider__control--active',
	};

	const elRoot = document.querySelector('.js-special-slider');
	const elsItem = elRoot.querySelectorAll('.js-special-slider__item');
	const elItems = elRoot.querySelector('.js-special-slider__items');
	const elNext = elRoot.querySelector('.js-special-slider__next');
	const elPrevious = elRoot.querySelector('.js-special-slider__previous');

	//Max value is scrollWidth - clientWidth, since it's the right side of the block
	const maxScrollValue = elItems.scrollWidth - elRoot.clientWidth;
	//State values
	let currentSlide = 0;
	let currentX = 0;

	//Toggle controls visibility
	const updateControls = () => {
		//Hide previous button if we are at the start
		elPrevious.classList.toggle(modifiers.controlActive, currentX !== 0);
		//Hide next button if we are at the end
		elNext.classList.toggle(modifiers.controlActive, currentX < maxScrollValue);
	};

	//Slide to card by its index
	const slideTo = (index) => {
		//Check for minimal/maximal valid endexes
		if(index < 0 || index > elItems.length - 1) return;

		//Get total width of all items. CSS is built the way that items don't have any offsets between them.
		//Padding are used for that reason
		let scrollValue = 0;
		for(let i = 0; i < index; i++) {
			scrollValue += elsItem[i].clientWidth;
		}

		//Limit by maximal scroll value
		const targetValue = Math.min(scrollValue, maxScrollValue);

		//Scroll to card
		elItems.scrollTo({left: targetValue, behavior: 'smooth'});

		//Update state values and controls
		currentSlide = index;
		currentX = targetValue;
		updateControls();
	};

	//Update controls on page load, They start hidden not to have visible controls that can't be clicked while js still loads.
	updateControls();

	//Whenever you click controls you go to next or previous index
	elNext.addEventListener('click', () => slideTo(currentSlide + 1));
	elPrevious.addEventListener('click', () => slideTo(currentSlide - 1));

};

specialSlider();