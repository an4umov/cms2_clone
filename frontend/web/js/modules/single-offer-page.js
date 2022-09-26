function singleOfferSlider(){
    let slides = document.querySelectorAll('.activeSlide__slider-item');
    let prevBtn = document.querySelector('.activeSlide__prev-slide');
    let nextBtn = document.querySelector('.activeSlide__next-slide');

    let thumbnailsContainer = document.querySelector('.vendor-slider__thumbnails-inner');
    let activeThumbnail = document.querySelector('.activeSlide__active-thumbnail');
    if (slides === null || prevBtn === null || nextBtn === null || activeThumbnail === null) {
        // console.log('singleOfferSlider just left HTML');
    } else {
        let slideIndex = 1;
        showSlides(slideIndex);
        footerMT();

        function nextSlide() {
            showSlides(slideIndex += 1);
        }

        function previousSlide() {
            showSlides(slideIndex -= 1);  
        }


        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n){
            let i;
            
            if (n > slides.length) {
              slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }
          
          
            for (let slide of slides) {
                slide.style.display = "none";
            }   
            slides[slideIndex - 1].style.display = "flex"; 
        }  

        
        prevBtn.addEventListener('click', function(){
      
            activeThumbnail.style.display = 'none';
            showSlides(slideIndex -= 1);
        });

        nextBtn.addEventListener('click', function(){
            removeVideoFromActiveThumb();
            activeThumbnail.style.display = 'none';
            showSlides(slideIndex += 1);
        });



        //thumbnail initial

        slides.forEach(item => {  
            let currentItem = item;
            let slideThubmnail = document.createElement("div");
            thumbnailsContainer.appendChild(slideThubmnail);
            slideThubmnail.classList.add('vendor-slider__thumbnail');
            slideThubmnail.innerHTML = currentItem.innerHTML;
            
        });
    }
}

singleOfferSlider();

function thumbnailSliderPart(){
    let activeThumbnail = document.querySelector('.activeSlide__active-thumbnail');
    let thumbnails = document.querySelectorAll('.vendor-slider__thumbnail');

    if (thumbnails === null || activeThumbnail === null) {
        // console.log('singleOfferSlider just left HTML');
    } else {
        for (let i = 0;i < thumbnails.length; i++){
            thumbnails[i].addEventListener('click', function(){
                let activeThumb = this;
                activeThumbnail.style.display ='flex';
                activeThumbnail.innerHTML = activeThumb.innerHTML;
            });
        }

    }
}

thumbnailSliderPart();

function thumbnailSliderArrows(){
    let modifiersForSpecial = {
        controlActive: 'vendor-slider__control--active',
    };

    const elRoot = document.querySelector('.vendor-slider__thumbnails');
    if (elRoot === null) {
        // console.log("vendorSlider left html");
    } else {
        const elsItem = elRoot.querySelectorAll('.vendor-slider__thumbnail');
        const elItems = elRoot.querySelector('.vendor-slider__thumbnails-inner');
        const elNext = elRoot.querySelector('.vendor-slider__control--next');
        const elPrevious = elRoot.querySelector('.vendor-slider__control--prev');

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

thumbnailSliderArrows();

// Video in slider
function generateVideoInSlider(){
    let videosBlock = document.querySelectorAll('.activeSlide__slider-video');

    if (videosBlock === null) {
        // console.log("sliderVideos left HTML");
      } else {
          
        for (let i = 0; i < videosBlock.length; i++) {
            setupVideo(videosBlock[i]);
        }

        function setupVideo(video) {
            let link = video.querySelector('.activeSlide__video-link');
            let media = video.querySelector('.activeSlide__media');
            let button = video.querySelector('.activeSlide__button');
      
      
            let id = parseMediaURL(media);
          
            video.addEventListener('click', () => {
                let iframe = createIframe(id);
          
                link.remove();
                button.remove();
                video.appendChild(iframe);
                  
                link.removeAttribute('href');
                video.classList.add('video--enabled');


                videoControlSingleOfferPage();

            });
      
        }

        function parseMediaURL(media) {
            let regexp = /https:\/\/i\.ytimg\.com\/vi\/([a-zA-Z0-9_-]+)\/maxresdefault\.jpg/i;
            let url = media.src;
            let match = url.match(regexp);
          
            return match[1];
        }

        function createIframe(id) {
            let iframe = document.createElement('iframe');
          
            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('allow', 'autoplay');
            iframe.setAttribute('src', generateURL(id));
            iframe.classList.add('video__media');
          
            return iframe;
        }

        function generateURL(id) {
            let query = '?rel=0&showinfo=0&autoplay=1&enablejsapi=1';
          
            return 'https://www.youtube.com/embed/' + id + query;
        }
      }
}

generateVideoInSlider();


function videoControlSingleOfferPage(){

    let iframes = document.querySelectorAll('iframe');
 
    let nextBtn = document.querySelectorAll('.activeSlide__next-slide');
    let prevBtn = document.querySelectorAll('.activeSlide__prev-slide');

    let thumbnailPanel = document.querySelector('.vendor-slider__thumbnails')
  
    for(let i = 0; i < nextBtn.length; i++){
      nextBtn[i].addEventListener('click', function(){
        console.warn('BAM!!');
        var stopAllYouTubeVideos = () => { 
          var iframes = document.querySelectorAll('iframe');
          Array.prototype.forEach.call(iframes, iframe => { 
            iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', 
          func: 'pauseVideo' }), '*');
         });
        }
        stopAllYouTubeVideos();
      });
    }
    
    for(let i = 0; i < prevBtn.length; i++){
      prevBtn[i].addEventListener('click', function(){
        console.warn('BAM!!');
        var stopAllYouTubeVideos = () => { 
          var iframes = document.querySelectorAll('iframe');
          Array.prototype.forEach.call(iframes, iframe => { 
            iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', 
          func: 'pauseVideo' }), '*');
         });
        }
        stopAllYouTubeVideos();
      });
    }

    
    window.addEventListener('scroll', function(){
        let pauseAllYouTubeVideos = () => { 
          let iframes = document.querySelectorAll('iframe');
          Array.prototype.forEach.call(iframes, iframe => { 
            iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', 
          func: 'pauseVideo' }), '*');
         });
        }
    
        pauseAllYouTubeVideos();
    });

    thumbnailPanel.addEventListener('click', function(){
        let pauseAllYouTubeVideos = () => { 
          let iframes = document.querySelectorAll('iframe');
          Array.prototype.forEach.call(iframes, iframe => { 
            iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', 
          func: 'pauseVideo' }), '*');
         });
        }
    
        pauseAllYouTubeVideos();
    });


    
}

  

function tumbnailVideo(){
    let videosInSlider = document.querySelectorAll('.activeSlide__slider-video');
    let videosliderThubmnails = document.querySelectorAll('.vendor-slider__thumbnail');
    let activeThumbnail = document.querySelector('.activeSlide__active-thumbnail');

    if (videosInSlider === null || videosliderThubmnails === null || activeThumbnail === null) {
        // console.log("videoInSlider left HTML");
      } else {

        videosliderThubmnails.forEach(item => {  
            let videoInThumb = item.querySelector('.activeSlide__slider-video');

            if (videoInThumb === null){
                // console.log("No video in slider!");
            } else{
                let previewOfVideo = videoInThumb.querySelector('.activeSlide__video-link');
                item.classList.remove('vendor-slider__thumbnail');
                item.classList.add('vendor-slider__thumbnail--video');
                let videoThumb = item;
                
                

                // console.log(videoThumb);
                item.innerHTML = previewOfVideo.innerHTML;
            }
            
        });
        
      }
}

tumbnailVideo();

//remove video from thumb
function removeVideoFromActiveThumb(){
    let activeThumbnail = document.querySelector('.activeSlide__active-thumbnail');
    let iframeActiveThumb = activeThumbnail.querySelector('iframe');

    if (activeThumbnail === null || iframeActiveThumb === null){
        // console.log('NO VIDEO IN ACTIVEThumb');
    } else {
        iframeActiveThumb.remove();
    }
}

//Generate video from THUMB
function generateVideoInSliderFromThumb(){
    let activeThumb = document.querySelector('.activeSlide__active-thumbnail');
    let videoInSlide = document.querySelectorAll('.activeSlide__slider-video');
    let videoThumb = document.querySelectorAll('.vendor-slider__thumbnail--video');

    if(activeThumb === null || videoInSlide === null || videoThumb === null){
        // console.log('no Video in slider');
    }else{
        function setupVideo() {

            for(let i = 0; i < videoThumb.length; i++){ 
                videoThumb[i].addEventListener('click', function(){
                    let currentThumb = this;
                    
                    let media = currentThumb.querySelector('.activeSlide__media');
                    let button = currentThumb.querySelector('.activeSlide__button');

                    let id = parseMediaURL(media);
                    let iframe = createIframe(id);
                
                    
                    // button.remove();
                    activeThumb.style.display = 'flex';
                    activeThumb.appendChild(iframe);

                    
                });  
            }   
        }
    
        setupVideo();
    
        function parseMediaURL(media) {
            let regexp = /https:\/\/i\.ytimg\.com\/vi\/([a-zA-Z0-9_-]+)\/maxresdefault\.jpg/i;
            let url = media.src;
            let match = url.match(regexp);
          
            return match[1];
        }
    
        function createIframe(id) {
            let iframe = document.createElement('iframe');
          
            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('allow', 'autoplay');
            iframe.setAttribute('src', generateURL(id));
            iframe.classList.add('video__media');
          
            return iframe;
        }
    
        function generateURL(id) {
            let query = '?rel=0&showinfo=0&autoplay=1&enablejsapi=1';
          
            return 'https://www.youtube.com/embed/' + id + query;
        }

        videoControlSingleOfferPage();
    }
}

generateVideoInSliderFromThumb();


function hideArrows(){
    let prevArrow = document.querySelector('.activeSlide__prev-slide');
    let nextArrow = document.querySelector('.activeSlide__next-slide');
    let activeSlide = document.querySelector('.activeSlide');

    if (prevArrow === null || nextArrow === null) {
        // console.log('singleOfferSlider just left HTML');
    } else { 
        activeSlide.addEventListener('mouseover', function(){      
            prevArrow.style.display = 'flex';
            nextArrow.style.display = 'flex';


        });

        activeSlide.addEventListener('mouseout', function(){    
            prevArrow.style.display = 'none';
            nextArrow.style.display = 'none';

        });
    }
}

hideArrows();

//Footer margin on single offer page 

function footerMT() {
    let footer = document.querySelector('.footer');

    footer.style.marginTop = "100px";
}