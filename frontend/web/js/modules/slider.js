function slider() {

    const slidersList = document.querySelectorAll('.slider');
	if (slidersList === null) {
		// console.log("Slider left html");
	} else {
        for(let i = 0; i < slidersList.length; i++){
            let slideIndex = 1,
            slides = slidersList[i].querySelectorAll('.slider__item'),
            dotsWrap = slidersList[i].querySelector('.slider__dots'),
            dots = slidersList[i].querySelectorAll('.dot');
            const currentSlider = slidersList[i];
            const autoScrollTimer = currentSlider.dataset.timer;

            showSlides(slideIndex);

            function showSlides(n) {

                if (n > slides.length) {
                    slideIndex = 1;
                }
                if (n < 1) {
                    slideIndex = slides.length;
                }

                slides.forEach((item) => item.style.display = 'none');
                // for (var i = 0; i < slides.length; i++) {
                //     slides[i].style.display = 'none';
                // }
                dots.forEach((item) => item.classList.remove('dot-active'));

                slides[slideIndex - 1].style.display = 'block';
                dots[slideIndex - 1].classList.add('dot-active');
            }

            function plusSlides(n) {
                showSlides(slideIndex += n); 
            }
            
            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            function plusAutoSlides(n) {
                showSlides(slideIndex += 1);
            }

            if(Number(autoScrollTimer) <= 0 || autoScrollTimer === "null"){
                console.warn('data-timer 0 or less')
            }else{

                window.sliderTimer = setInterval(plusAutoSlides, Number(autoScrollTimer));

                currentSlider.addEventListener('mouseenter', function(){
                    console.warn('СЛАЙДЕР, ПРИКАЗЫВАЮ ТЕБЕ, ЗАМРИ!!!')
                    clearInterval(window.sliderTimer);
                });

                currentSlider.addEventListener('mouseleave', function(){
                    console.warn('СЛАЙДЕР, ОТОМРИ, ОКАЯНЫЙ!!!')
                    window.sliderTimer = setInterval(plusAutoSlides, Number(autoScrollTimer));
                });
            }
            
            //click on dots
            dotsWrap.addEventListener('click', function(event) {
                for (let i = 0; i < dots.length + 1; i++) {
                    if (event.target.classList.contains('dot') && event.target == dots[i-1]) {
                        currentSlide(i);
                    }
                }
            });
        }
    }
}

slider();

function sliderOpener(){
    const slides = document.querySelectorAll('.slider__item');
	if (slides === null) {
        console.log('no links in slider!')
    }else{
        for(let i = 0; i < slides.length; i++){
            let sliderItemInfo = slides[i].querySelector('.slider__item-info');
            let sliderItemInfoLink = slides[i].querySelector('.slider__item-info a');
            let sliderItemInfoClose = slides[i].querySelector('.slider__item-info--close');

            // console.warn(sliderItemInfo);
            // console.warn(sliderItemInfoLink);

            sliderItemInfo.addEventListener('click', function(){
                sliderItemInfo.classList.add('slider__item-info--active');
                sliderItemInfoLink.style.display = 'flex';

                
                setTimeout(function(){
                    let rectOfCurrentItemInfo = sliderItemInfo.getBoundingClientRect();

                    console.warn(rectOfCurrentItemInfo.left);
                    console.warn(sliderItemInfo.offsetHeight);

                    sliderItemInfoClose.style.display = "block";
                    sliderItemInfoClose.style.top = Math.round(sliderItemInfo.offsetHeight) - 25 - 15 + "px";
                    sliderItemInfoClose.style.left = Math.round(rectOfCurrentItemInfo.left) + 25 + "px";

                    
                }, 300);


                
            });

            sliderItemInfoClose.addEventListener('click', function(){
                sliderItemInfo.classList.remove('slider__item-info--active');
                sliderItemInfoLink.style.display = 'none';
                sliderItemInfoClose.style.display = 'none';
            });
        }
    }
}