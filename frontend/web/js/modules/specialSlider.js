function specialSlider() {
	let modifiersForSpecial = {
		controlActive: 'special-slider__control--active',
	};

	const elRoot = document.querySelector('.js-special-slider');
	if (elRoot === null) {
		// console.log("specialSlider left html")
	} else {
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
			elPrevious.classList.toggle(modifiersForSpecial.controlActive, currentX !== 0);
			//Hide next button if we are at the end
			elNext.classList.toggle(modifiersForSpecial.controlActive, currentX < maxScrollValue);
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

	}
}

specialSlider();

//btns tips in special-offers on index page

function favBtnTooltip(){
	let favBtnsDefaultList = document.querySelectorAll('.special-offer-card__favorite--default');
	let favBtnsActiveList = document.querySelectorAll('.special-offer-card__favorite--active');

	if (favBtnsDefaultList === null){
		// console.log('no special offers on the page');
	} else{

		let intViewportWidth = window.innerWidth;

    	if(intViewportWidth > 1140){

			for(let i = 0;i < favBtnsDefaultList.length; i++){
				favBtnsDefaultList[i].addEventListener('mouseover', function(){
					let currentTooltip = this.querySelector('.special-offer-card__favorite-default-tip');
					
					currentTooltip.style.visibility = 'visible';
					currentTooltip.style.opacity = '1';
				});
	
				favBtnsDefaultList[i].addEventListener('mouseout', function(){
					let currentTooltip = this.querySelector('.special-offer-card__favorite-default-tip');
	
					currentTooltip.style.visibility = 'hidden';
					currentTooltip.style.opacity = '0';
				});
	
				favBtnsDefaultList[i].addEventListener('click', function(){
	
					let currentActiveBtn = this.nextElementSibling;
					currentActiveBtn.classList.add('special-offer-card__favorite--active-on');
				});
	
			}

			for(let i = 0; i < favBtnsActiveList.length; i++){
				favBtnsActiveList[i].addEventListener('mouseover', function(){
					let currentActiveTooltip = this.querySelector('.special-offer-card__favorite-active-tip');
					
					currentActiveTooltip.style.visibility = 'visible';
					currentActiveTooltip.style.opacity = '1';
				});

				favBtnsActiveList[i].addEventListener('mouseout', function(){
					let currentActiveTooltip = this.querySelector('.special-offer-card__favorite-active-tip');

					currentActiveTooltip.style.visibility = 'hidden';
					currentActiveTooltip.style.opacity = '0';
				});

				favBtnsActiveList[i].addEventListener('click', function(){
					favBtnsActiveList[i].classList.remove('special-offer-card__favorite--active-on');
					
				});
			}
		}
	}
}

favBtnTooltip();

function buyBtnTooltip(){
	let buyBtnsDefaultList = document.querySelectorAll('.special-offer-card__buy-btn--default');
	let buyBtnsActiveList = document.querySelectorAll('.special-offer-card__buy-btn--active');

	if (buyBtnsDefaultList === null){
		// console.log('no special offers on the page');
	} else {

		let intViewportWidth = window.innerWidth;

    	if(intViewportWidth > 1140){

			for(let i = 0;i < buyBtnsDefaultList.length; i++){
				buyBtnsDefaultList[i].addEventListener('mouseover', function(){
					let currentBtnTooltip = this.querySelector('.special-offer-card__buy-btn-default-tip');
					
					currentBtnTooltip.style.visibility = 'visible';
					currentBtnTooltip.style.opacity = '1';
				});
	
				buyBtnsDefaultList[i].addEventListener('mouseout', function(){
					let currentBtnTooltip = this.querySelector('.special-offer-card__buy-btn-default-tip');
		
					currentBtnTooltip.style.visibility = 'hidden';
					currentBtnTooltip.style.opacity = '0';
				});
			}
	
			for(let i = 0;i < buyBtnsActiveList.length; i++){
				buyBtnsActiveList[i].addEventListener('mouseover', function(){
					let currentBtnTooltip = this.querySelector('.special-offer-card__buy-btn-active-tip');
					
					currentBtnTooltip.style.visibility = 'visible';
					currentBtnTooltip.style.opacity = '1';
				});
	
				buyBtnsActiveList[i].addEventListener('mouseout', function(){
					let currentBtnTooltip = this.querySelector('.special-offer-card__buy-btn-active-tip');
	
					setTimeout(function(){
		
						currentBtnTooltip.style.visibility = 'hidden';
						currentBtnTooltip.style.opacity = '0';
					  }, 5000);
					
				});
			}
		}
	}	
}

buyBtnTooltip();

// special card tips on adaptive cards

function favBtnTooltipAdaptive(){
	let favBtnsDefaultList = document.querySelectorAll('.special-offer-catalog__card-favorite--default');
	let favBtnsActiveList = document.querySelectorAll('.special-offer-catalog__card-favorite--active');

	if(favBtnsDefaultList === null){
		// console.log('no adaptive cards on the page');
	}else {

		let intViewportWidth = window.innerWidth;

    	if(intViewportWidth > 1140){
			
			for(let i = 0; i < favBtnsDefaultList.length; i++){
				favBtnsDefaultList[i].addEventListener('mouseover', function(){
					let currentTooltip = this.querySelector('.special-offer-catalog__card-favorite-default-tip');
					
					currentTooltip.style.visibility = 'visible';
					currentTooltip.style.opacity = '1';
				});	

				favBtnsDefaultList[i].addEventListener('mouseout', function(){
					let currentTooltip = this.querySelector('.special-offer-catalog__card-favorite-default-tip');
					
					currentTooltip.style.visibility = 'hidden';
					currentTooltip.style.opacity = '0';
				});	
			}

			for(let i = 0; i < favBtnsActiveList.length; i++){
				favBtnsActiveList[i].addEventListener('mouseover', function(){
					let currentTooltip = this.querySelector('.special-offer-catalog__card-favorite-active-tip');
					
					currentTooltip.style.visibility = 'visible';
					currentTooltip.style.opacity = '1';
				});

				favBtnsActiveList[i].addEventListener('mouseout', function(){
					let currentTooltip = this.querySelector('.special-offer-catalog__card-favorite-active-tip');
					
					currentTooltip.style.visibility = 'hidden';
					currentTooltip.style.opacity = '0';
				});
			}
		}

	}
}

favBtnTooltipAdaptive();

function buyBtnTooltipAdaptive(){
	let buyBtnsDefaultList = document.querySelectorAll('.special-offer-catalog__card-buy-btn--default');
	let buyBtnsActiveList = document.querySelectorAll('.special-offer-catalog__card-buy-btn--active');

	if(buyBtnsDefaultList === null){
		console.warn('THIS IS SPARTA!');
	}else {

		let intViewportWidth = window.innerWidth;

    	if(intViewportWidth > 1140){

			
			for(let i = 0; i < buyBtnsDefaultList.length; i++){
				buyBtnsDefaultList[i].addEventListener('mouseover', function(){
					let currentBtnTooltip = this.querySelector('.special-offer-catalog__card-buy-btn-default-tip');
					
					currentBtnTooltip.style.visibility = 'visible';
					currentBtnTooltip.style.opacity = '1';
				});
	
				buyBtnsDefaultList[i].addEventListener('mouseout', function(){
					let currentBtnTooltip = this.querySelector('.special-offer-catalog__card-buy-btn-default-tip');
					
					currentBtnTooltip.style.visibility = 'hidden';
					currentBtnTooltip.style.opacity = '0';
				});
			}
	
			for(let i = 0; i < buyBtnsActiveList.length; i++){
				buyBtnsActiveList[i].addEventListener('mouseover', function(){
					let currentBtnTooltip = this.querySelector('.special-offer-catalog__card-buy-btn-active-tip');
					
					currentBtnTooltip.style.visibility = 'visible';
					currentBtnTooltip.style.opacity = '1';
				});
	
				buyBtnsActiveList[i].addEventListener('mouseout', function(){
					let currentBtnTooltip = this.querySelector('.special-offer-catalog__card-buy-btn-active-tip');
	
					setTimeout(function(){
		
						currentBtnTooltip.style.visibility = 'hidden';
						currentBtnTooltip.style.opacity = '0';
					  }, 5000);
					
				});
			}
		}

	}
}

buyBtnTooltipAdaptive();