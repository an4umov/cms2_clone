// short post tips
function newsPostShortAskBtnTip(){
  let askBtns = document.querySelectorAll('.news-post__short-btn--ask');

  if(askBtns === null){
    // console.log('no askBtns in news on the page!');
  } else {
    for(let i = 0; i < askBtns.length; i++){
      askBtns[i].addEventListener('mouseover', function(){
        let currentTip = this.querySelector('.news-post__short-btn--ask-tip');

        currentTip.style.visibility = 'visible';
				currentTip.style.opacity = '1';
      });

      askBtns[i].addEventListener('mouseout', function(){
        let currentTip = this.querySelector('.news-post__short-btn--ask-tip');

				currentTip.style.visibility = 'hidden';
				currentTip.style.opacity = '0';
			});
    }
  }
}
newsPostShortAskBtnTip();

function newsPostShortShareBtnTip(){
  let shareBts = document.querySelectorAll('.news-post__short-btn--share');

  if(shareBts === null){
    // console.log('no shareBtns in news on the page!');
  }else {
    for(let i = 0; i < shareBts.length; i++){
      shareBts[i].addEventListener('mouseover', function(){
        let currentTip = this.querySelector('.news-post__short-btn--share-tip');

        currentTip.style.visibility = 'visible';
				currentTip.style.opacity = '1';
      });

      shareBts[i].addEventListener('mouseout', function(){
        let currentTip = this.querySelector('.news-post__short-btn--share-tip');

        currentTip.style.visibility = 'hidden';
				currentTip.style.opacity = '0';
      });
    }
  }
}
newsPostShortShareBtnTip();

// full post tips
function newsPostFullAskBtnTip(){
  let askBtnsFull = document.querySelectorAll('.news-post__full-btn--ask');

  if(askBtnsFull === null){
    // console.log('no btn in full news-post');
  } else{
    for(let i = 0; i < askBtnsFull.length; i++){
      askBtnsFull[i].addEventListener('mouseover', function(){
        let currentTip = this.querySelector('.news-post__full-btn--ask-tip');

        currentTip.style.visibility = 'visible';
				currentTip.style.opacity = '1';
      });

      askBtnsFull[i].addEventListener('mouseout', function(){
        let currentTip = this.querySelector('.news-post__full-btn--ask-tip');

        currentTip.style.visibility = 'hidden';
				currentTip.style.opacity = '0';
      });
    }
  }
}
newsPostFullAskBtnTip();

function newsPostFullShareBtnTip(){
  let shareBtnsFull = document.querySelectorAll('.news-post__full-btn--share');

  if(shareBtnsFull === null){
    // console.log('no share btns in full news-post');
  }else {
    for(let i = 0; i < shareBtnsFull.length; i++){
      shareBtnsFull[i].addEventListener('mouseover', function(){
        let currentTip = this.querySelector('.news-post__full-btn--share-tip');

        currentTip.style.visibility = 'visible';
				currentTip.style.opacity = '1';
      });

      shareBtnsFull[i].addEventListener('mouseout', function(){
        let currentTip = this.querySelector('.news-post__full-btn--share-tip');

        currentTip.style.visibility = 'hidden';
				currentTip.style.opacity = '0';
      });
    }
  }
}
newsPostFullShareBtnTip();

//news open/close mech

function newsPostOpen() {
  let newsPosts = document.querySelectorAll(".news-post");

  if (newsPosts === null ) {
		// console.log("newsPosts left html");
  } else {
    for (let i = 0; i < newsPosts.length; i++) {
      let newsPostOpenBtn = newsPosts[i].querySelector(".news-post__short-open");
      let newsPostFullPost = newsPosts[i].querySelector(".news-post__full");
      let newsPostShortPost = newsPosts[i].querySelector(".news-post__short");
      let newsPostShortPanel = newsPosts[i].querySelector(".news-post__short-panel");
      let newsPostFullClose = newsPosts[i].querySelector(".news-post__full-close");

      if (newsPostOpenBtn === null || newsPostFullPost === null || newsPostShortPost === null || newsPostShortPanel === null || newsPostFullClose === null ) {
        // console.log("newsPosts elements left html");
      } else {

        newsPostOpenBtn.addEventListener("click", function(e) {
          e.preventDefault();

          newsPostShortPanel.style.display = 'none';
          newsPostFullPost.style.display = 'block';

          newsPostFullPost.scrollIntoView({behavior: "smooth"});

          let currentSliderList = newsPostFullPost.querySelectorAll('.news-post__full-slider');
          // console.log(newsPostFullPost);
          // console.log(currentSliderList);

          currentSliderList.forEach(item => {
            item.classList.add('news-post__full-slider--active');
          })

          
          let sliderRadar = newsPostFullPost.querySelector('.news-post__full-slider');
          // console.log(sliderRadar);

          // if(!sliderRadar) {
          //   console.warn('no slider in there!')
          // } else{
          //   console.warn('slider here');
          //   newPostSlider();
          // }
          
          

          
        });

        newsPostOpenBtn.addEventListener("click", function sliderSwitch(e) {
          e.preventDefault();
          // console.warn("only one!");
          
          newPostSlider();
          fullPostSliderVideo();
          

          // newPostSlider();
        }, {once : true});
    
        newsPostFullClose.addEventListener("click", function(e) {
          e.preventDefault();

          newsPostShortPost.scrollIntoView({behavior: "smooth"});

          

          setTimeout(function(){
            newsPostFullPost.style.display = 'none';

            let intViewportWidth = window.innerWidth;
            if(intViewportWidth < 1140){
              newsPostShortPanel.style.display = 'block';
            } else {
              newsPostShortPanel.style.display = 'flex';
            }
            
          }, 600);
          
        });


      }
    }
  }
}
newsPostOpen();

// Brand New Full post slider in closed card
function newPostSlider(){

  let slider = document.querySelectorAll('.news-post__full-slider--active');
  // console.log(slider);

  if(slider === null){
    // console.log('no news post slider on the page');
  }else{
    for(let i = 0; i < slider.length; i++){
      let sliderItems = slider[i].querySelector('.news-post__full-slides');
      let sliderSlide = slider[i].querySelectorAll('.news-post__full-slide');
      let prev = slider[i].querySelector('.news-post__full-slider-control-prev');
      let next = slider[i].querySelector('.news-post__full-slider-control-next');
      let sliderWrapper = slider[i].querySelector('.news-post__full-slider-wrapper');
      // console.log("I`m here!");
   
      let parentOfSlider = slider[i].parentElement;
      let parentIsHidden = (parentOfSlider.offsetHeight === 0 && parentOfSlider.offsetWidth === 0);

      //More space to full slider
      if(parentOfSlider.classList.contains('news-post__full-block')){
        
        let intViewportWidth = window.innerWidth;
        if(intViewportWidth < 499){
          console.warn('i`m here! mobile size');
          
          sliderWrapper.style.minHeight = "200px";
          slider[i].style.minHeight = "200px";
          sliderWrapper.style.maxHeight = "200px";
          slider[i].style.maxHeight = "200px";

          sliderSlide.forEach(item => {
            item.style.minHeight = "200px";

            let slidePic = item.querySelector('img');
            slidePic.style.height = "200px"
          })

        }else if(intViewportWidth < 1140){
          console.warn('i`m here! tablet size');
          sliderWrapper.style.minHeight = "350px";
          slider[i].style.minHeight = "350px";
          sliderWrapper.style.maxHeight = "350px";
          slider[i].style.maxHeight = "350px";
  
          sliderSlide.forEach(item => {
            item.style.minHeight = "350px";

            let slidePic = item.querySelector('img');
            slidePic.style.height = "350px"
          })
        }else{
          sliderWrapper.style.minHeight = "480px";
          slider[i].style.minHeight = "480px";
          sliderWrapper.style.maxHeight = "480px";
          slider[i].style.maxHeight = "480px";
  
          sliderSlide.forEach(item => {
            item.style.minHeight = "480px";
          })
        }

        // slider[i].style.minHeigth = '480px';
        // sliderWrapper.style.maxHeigth = '480px';
        // slider[i].style.maxHeigth = '480px';
        // console.log(sliderWrapper);
        // console.log(slider[i]);
      }

      //Check how many slides in slide
      if(sliderSlide.length === 1){
        // console.warn('one slide! turn off slider');
        prev.style.display = 'none';
        next.style.display = 'none';

        sliderSlide.forEach(item => {
          item.style.maxWidth = sliderWrapper.offsetWidth + "px";
        });

      } else {
        // console.warn('many slides! turn on slider')
        sliderItems.style.left ='-' + sliderWrapper.offsetWidth + 'px';

        sliderSlide.forEach(item => {
          item.style.width = sliderWrapper.offsetWidth + 'px';
          item.style.height = sliderWrapper.offsetHight + 'px';
          // console.log(item);
          
        })

        function slide(wrapper, items, prev, next) {
          // console.log("I`m here!");
          let posX1 = 0,
              posX2 = 0,
              posInitial,
              posFinal,
              threshold = 100,
              slides = items.getElementsByClassName('news-post__full-slide'),
              slidesLength = slides.length,
              slideSize = items.getElementsByClassName('news-post__full-slide')[0].offsetWidth,
              firstSlide = slides[0],
              lastSlide = slides[slidesLength - 1],
              cloneFirst = firstSlide.cloneNode(true),
              cloneLast = lastSlide.cloneNode(true),
              index = 0,
              allowShift = true;
          
          // Clone first and last slide
          items.appendChild(cloneFirst);
          items.insertBefore(cloneLast, firstSlide);
          wrapper.classList.add('loaded');
          
          // Mouse events
          items.onmousedown = dragStart;
          
          // Touch events
          items.addEventListener('touchstart', dragStart);
          items.addEventListener('touchend', dragEnd);
          items.addEventListener('touchmove', dragAction);
          
          // Click events
          prev.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(-1);
          });

          next.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(1);
          });
          
          // Transition events
          items.addEventListener('transitionend', checkIndex);
          
          function dragStart (e) {
            e = e || window.event;
            e.preventDefault();
            posInitial = items.offsetLeft;
            
            if (e.type == 'touchstart') {
              posX1 = e.touches[0].clientX;
            } else {
              posX1 = e.clientX;
              document.onmouseup = dragEnd;
              document.onmousemove = dragAction;
            }
          }
      
          function dragAction (e) {
            e = e || window.event;
            
            if (e.type == 'touchmove') {
              posX2 = posX1 - e.touches[0].clientX;
              posX1 = e.touches[0].clientX;
            } else {
              posX2 = posX1 - e.clientX;
              posX1 = e.clientX;
            }
  
            items.style.left = (items.offsetLeft - posX2) + "px";
          }
          
          function dragEnd (e) {
            posFinal = items.offsetLeft;
            if (posFinal - posInitial < -threshold) {
              shiftSlide(1, 'drag');
            } else if (posFinal - posInitial > threshold) {
              shiftSlide(-1, 'drag');
            } else {
              items.style.left = (posInitial) + "px";
            }
      
            document.onmouseup = null;
            document.onmousemove = null;
          }
          
          function shiftSlide(dir, action) {
            items.classList.add('shifting');
            
            if (allowShift) {
              if (!action) { posInitial = items.offsetLeft; }
      
              if (dir == 1) {
                items.style.left = (posInitial - slideSize) + "px";
                index++;      
              } else if (dir == -1) {
                items.style.left = (posInitial + slideSize) + "px";
                index--;      
              }
            };
            
            allowShift = false;
          }
            
          function checkIndex (){
            items.classList.remove('shifting');
      
            if (index == -1) {
              items.style.left = -(slidesLength * slideSize) + "px";
              index = slidesLength - 1;
            }
      
            if (index == slidesLength) {
              items.style.left = -(1 * slideSize) + "px";
              index = 0;
            }
            
            allowShift = true;
          }
  
          slider[i].classList.remove('news-post__full-slider--active');
        }

        function slideOnlyButtons(wrapper, items, prev, next) {
          // console.log("I`m here!");
          let posX1 = 0,
              posX2 = 0,
              posInitial,
              posFinal,
              threshold = 100,
              slides = items.getElementsByClassName('news-post__full-slide'),
              slidesLength = slides.length,
              slideSize = items.getElementsByClassName('news-post__full-slide')[0].offsetWidth,
              firstSlide = slides[0],
              lastSlide = slides[slidesLength - 1],
              cloneFirst = firstSlide.cloneNode(true),
              cloneLast = lastSlide.cloneNode(true),
              index = 0,
              allowShift = true;
          
          // Clone first and last slide
          items.appendChild(cloneFirst);
          items.insertBefore(cloneLast, firstSlide);
          wrapper.classList.add('loaded');
          
          // Mouse events
          // items.onmousedown = dragStart;
          
          // Touch events
          // items.addEventListener('touchstart', dragStart);
          // items.addEventListener('touchend', dragEnd);
          // items.addEventListener('touchmove', dragAction);
          
          // Click events
          prev.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(-1);
          });

          next.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(1);
          });
          
          // Transition events
          items.addEventListener('transitionend', checkIndex);
          
          // function dragStart (e) {
          //   e = e || window.event;
          //   e.preventDefault();
          //   posInitial = items.offsetLeft;
            
          //   if (e.type == 'touchstart') {
          //     posX1 = e.touches[0].clientX;
          //   } else {
          //     posX1 = e.clientX;
          //     document.onmouseup = dragEnd;
          //     document.onmousemove = dragAction;
          //   }
          // }
      
          // function dragAction (e) {
          //   e = e || window.event;
            
          //   if (e.type == 'touchmove') {
          //     posX2 = posX1 - e.touches[0].clientX;
          //     posX1 = e.touches[0].clientX;
          //   } else {
          //     posX2 = posX1 - e.clientX;
          //     posX1 = e.clientX;
          //   }
  
          //   items.style.left = (items.offsetLeft - posX2) + "px";
          // }
          
          // function dragEnd (e) {
          //   posFinal = items.offsetLeft;
          //   if (posFinal - posInitial < -threshold) {
          //     shiftSlide(1, 'drag');
          //   } else if (posFinal - posInitial > threshold) {
          //     shiftSlide(-1, 'drag');
          //   } else {
          //     items.style.left = (posInitial) + "px";
          //   }
      
          //   document.onmouseup = null;
          //   document.onmousemove = null;
          // }
          
          function shiftSlide(dir, action) {
            items.classList.add('shifting');
            
            if (allowShift) {
              if (!action) { posInitial = items.offsetLeft; }
      
              if (dir == 1) {
                items.style.left = (posInitial - slideSize) + "px";
                index++;      
              } else if (dir == -1) {
                items.style.left = (posInitial + slideSize) + "px";
                index--;      
              }
            };
            
            allowShift = false;
          }
            
          function checkIndex (){
            items.classList.remove('shifting');
      
            if (index == -1) {
              items.style.left = -(slidesLength * slideSize) + "px";
              index = slidesLength - 1;
            }
      
            if (index == slidesLength) {
              items.style.left = -(1 * slideSize) + "px";
              index = 0;
            }
            
            allowShift = true;
          }
  
          slider[i].classList.remove('news-post__full-slider--active');
        }

        let intViewportWidth = window.innerWidth;
        if(intViewportWidth < 1140){
          slide(slider[i], sliderItems, prev, next);
        } else {
          slideOnlyButtons(slider[i], sliderItems, prev, next);
        }    
      }  
    }
  }
}


// Brand New Full post slider in opened card
function newPostSliderSingle(){

  let slider = document.querySelectorAll('.news-post__full-slider');
  // console.log(slider);

  if(slider === null){
    // console.log('no news post slider on the page');
  } else{
    

    for(let i = 0; i < slider.length; i++){
    
      let sliderItems = slider[i].querySelector('.news-post__full-slides');
      let sliderSlide = slider[i].querySelectorAll('.news-post__full-slide');
      let prev = slider[i].querySelector('.news-post__full-slider-control-prev');
      let next = slider[i].querySelector('.news-post__full-slider-control-next');

      let sliderWrapper = slider[i].querySelector('.news-post__full-slider-wrapper');
      console.log("I`m here! Single slider");
      
      //Roman img contain
      sliderSlide.forEach(item => {
        let slidersImgs = item.querySelector('img');
        slidersImgs.style.objectFit = 'contain';
      })

      let parentOfSlider = slider[i].parentElement;

      let parentIsHidden = (parentOfSlider.offsetHeight === 0 && parentOfSlider.offsetWidth === 0);

      //More space to full slider
      if(parentOfSlider.classList.contains('news-post__full-block')){
        

        let intViewportWidth = window.innerWidth;
        if(intViewportWidth < 499){
          console.warn('i`m here! mobile size');
          
          sliderWrapper.style.minHeight = "200px";
          slider[i].style.minHeight = "200px";
          sliderWrapper.style.maxHeight = "200px";
          slider[i].style.maxHeight = "200px";

          sliderSlide.forEach(item => {
            item.style.minHeight = "200px";

            let slidePic = item.querySelector('img');
            slidePic.style.height = "200px"
          })

        }else if(intViewportWidth < 1140){
          console.warn('i`m here! tablet size');
          sliderWrapper.style.minHeight = "350px";
          slider[i].style.minHeight = "350px";
          sliderWrapper.style.maxHeight = "350px";
          slider[i].style.maxHeight = "350px";
  
          sliderSlide.forEach(item => {
            item.style.minHeight = "350px";

            let slidePic = item.querySelector('img');
            slidePic.style.height = "350px"
          })
        }else{
          sliderWrapper.style.minHeight = "480px";
          slider[i].style.minHeight = "480px";
          sliderWrapper.style.maxHeight = "480px";
          slider[i].style.maxHeight = "480px";
  
          sliderSlide.forEach(item => {
            item.style.minHeight = "480px";
          })
        }

      
        // slider[i].style.minHeigth = '480px';
        // sliderWrapper.style.maxHeigth = '480px';
        // slider[i].style.maxHeigth = '480px';
        // console.log(sliderWrapper);
        // console.log(slider[i]);
      }

      //Check how many slides in slide
      if(sliderSlide.length === 1){
        // console.warn('one slide! turn off slider');
        prev.style.display = 'none';
        next.style.display = 'none';

        sliderSlide.forEach(item => {
          item.style.maxWidth = sliderWrapper.offsetWidth + "px";
        });

      }else{
        // console.warn('many slides! turn on slider')
        sliderItems.style.left ='-' + sliderWrapper.offsetWidth + 'px';

        sliderSlide.forEach(item => {
          item.style.width = sliderWrapper.offsetWidth + 'px';
          item.style.height = sliderWrapper.offsetHight + 'px';
          // console.log(item);
          
        })

        function slide(wrapper, items, prev, next) {
          // console.log("I`m here!");
          let posX1 = 0,
              posX2 = 0,
              posInitial,
              posFinal,
              threshold = 100,
              slides = items.getElementsByClassName('news-post__full-slide'),
              slidesLength = slides.length,
              slideSize = items.getElementsByClassName('news-post__full-slide')[0].offsetWidth,
              firstSlide = slides[0],
              lastSlide = slides[slidesLength - 1],
              cloneFirst = firstSlide.cloneNode(true),
              cloneLast = lastSlide.cloneNode(true),
              index = 0,
              allowShift = true;
          
          // Clone first and last slide
          items.appendChild(cloneFirst);
          items.insertBefore(cloneLast, firstSlide);
          wrapper.classList.add('loaded');
          
          // Mouse events
          items.onmousedown = dragStart;
          
          // Touch events
          items.addEventListener('touchstart', dragStart);
          items.addEventListener('touchend', dragEnd);
          items.addEventListener('touchmove', dragAction);
          
          // Click events
          prev.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(-1);
          });

          next.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(1);
          });
          
          // Transition events
          items.addEventListener('transitionend', checkIndex);
          
          function dragStart (e) {
            e = e || window.event;
            e.preventDefault();
            posInitial = items.offsetLeft;
            
            if (e.type == 'touchstart') {
              posX1 = e.touches[0].clientX;
            } else {
              posX1 = e.clientX;
              document.onmouseup = dragEnd;
              document.onmousemove = dragAction;
            }
          }
      
          function dragAction (e) {
            e = e || window.event;
            
            if (e.type == 'touchmove') {
              posX2 = posX1 - e.touches[0].clientX;
              posX1 = e.touches[0].clientX;
            } else {
              posX2 = posX1 - e.clientX;
              posX1 = e.clientX;
            }
  
            items.style.left = (items.offsetLeft - posX2) + "px";
          }
          
          function dragEnd (e) {
            posFinal = items.offsetLeft;
            if (posFinal - posInitial < -threshold) {
              shiftSlide(1, 'drag');
            } else if (posFinal - posInitial > threshold) {
              shiftSlide(-1, 'drag');
            } else {
              items.style.left = (posInitial) + "px";
            }
      
            document.onmouseup = null;
            document.onmousemove = null;
          }
          
          function shiftSlide(dir, action) {
            items.classList.add('shifting');
            
            if (allowShift) {
              if (!action) { posInitial = items.offsetLeft; }
      
              if (dir == 1) {
                items.style.left = (posInitial - slideSize) + "px";
                index++;      
              } else if (dir == -1) {
                items.style.left = (posInitial + slideSize) + "px";
                index--;      
              }
            };
            
            allowShift = false;
          }
            
          function checkIndex (){
            items.classList.remove('shifting');
      
            if (index == -1) {
              items.style.left = -(slidesLength * slideSize) + "px";
              index = slidesLength - 1;
            }
      
            if (index == slidesLength) {
              items.style.left = -(1 * slideSize) + "px";
              index = 0;
            }
            
            allowShift = true;
          }
  
          slider[i].classList.remove('news-post__full-slider--active');
  
        }

        function slideOnlyButtons(wrapper, items, prev, next) {
          // console.log("I`m here!");
          let posX1 = 0,
              posX2 = 0,
              posInitial,
              posFinal,
              threshold = 100,
              slides = items.getElementsByClassName('news-post__full-slide'),
              slidesLength = slides.length,
              slideSize = items.getElementsByClassName('news-post__full-slide')[0].offsetWidth,
              firstSlide = slides[0],
              lastSlide = slides[slidesLength - 1],
              cloneFirst = firstSlide.cloneNode(true),
              cloneLast = lastSlide.cloneNode(true),
              index = 0,
              allowShift = true;
          
          // Clone first and last slide
          items.appendChild(cloneFirst);
          items.insertBefore(cloneLast, firstSlide);
          wrapper.classList.add('loaded');
          
          // Mouse events
          // items.onmousedown = dragStart;
          
          // Touch events
          // items.addEventListener('touchstart', dragStart);
          // items.addEventListener('touchend', dragEnd);
          // items.addEventListener('touchmove', dragAction);
          
          // Click events
          prev.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(-1);
          });

          next.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(1);
          });
          
          // Transition events
          items.addEventListener('transitionend', checkIndex);
          
          // function dragStart (e) {
          //   e = e || window.event;
          //   e.preventDefault();
          //   posInitial = items.offsetLeft;
            
          //   if (e.type == 'touchstart') {
          //     posX1 = e.touches[0].clientX;
          //   } else {
          //     posX1 = e.clientX;
          //     document.onmouseup = dragEnd;
          //     document.onmousemove = dragAction;
          //   }
          // }
      
          // function dragAction (e) {
          //   e = e || window.event;
            
          //   if (e.type == 'touchmove') {
          //     posX2 = posX1 - e.touches[0].clientX;
          //     posX1 = e.touches[0].clientX;
          //   } else {
          //     posX2 = posX1 - e.clientX;
          //     posX1 = e.clientX;
          //   }
  
          //   items.style.left = (items.offsetLeft - posX2) + "px";
          // }
          
          // function dragEnd (e) {
          //   posFinal = items.offsetLeft;
          //   if (posFinal - posInitial < -threshold) {
          //     shiftSlide(1, 'drag');
          //   } else if (posFinal - posInitial > threshold) {
          //     shiftSlide(-1, 'drag');
          //   } else {
          //     items.style.left = (posInitial) + "px";
          //   }
      
          //   document.onmouseup = null;
          //   document.onmousemove = null;
          // }
          
          function shiftSlide(dir, action) {
            items.classList.add('shifting');
            
            if (allowShift) {
              if (!action) { posInitial = items.offsetLeft; }
      
              if (dir == 1) {
                items.style.left = (posInitial - slideSize) + "px";
                index++;      
              } else if (dir == -1) {
                items.style.left = (posInitial + slideSize) + "px";
                index--;      
              }
            };
            
            allowShift = false;
          }
            
          function checkIndex (){
            items.classList.remove('shifting');
      
            if (index == -1) {
              items.style.left = -(slidesLength * slideSize) + "px";
              index = slidesLength - 1;
            }
      
            if (index == slidesLength) {
              items.style.left = -(1 * slideSize) + "px";
              index = 0;
            }
            
            allowShift = true;
          }
  
          slider[i].classList.remove('news-post__full-slider--active');
  
         
        }

        let intViewportWidth = window.innerWidth;
        if(intViewportWidth < 1140){
          slide(slider[i], sliderItems, prev, next);
        } else {
          slideOnlyButtons(slider[i], sliderItems, prev, next);
        }    
      }  
    }
  }
}

// setTimeout(() => newPostSlider(), 1000);


//Video  in slider
function fullPostSliderVideo() {
  let videos = document.querySelectorAll('.news-post__full-video');

  if (videos === null) {
    // console.log("sliderVideos left HTML");
  } else {
    for (let i = 0; i < videos.length; i++) {
      setupVideo(videos[i]);
    }

    function setupVideo(video) {
      let link = video.querySelector('.news-post__full-video-link');
      let media = video.querySelector('.news-post__full-video-media');
      let button = video.querySelector('.news-post__full-video-button');


      let id = parseMediaURL(media);
    
      video.addEventListener('click', () => {
        let iframe = createIframe(id);
    
        link.remove();
        button.remove();
        video.appendChild(iframe);

        link.removeAttribute('href');
        video.classList.add('video--enabled');   
       
        videoControl();
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
      iframe.setAttribute("id", "newsVideo");
    
      return iframe;
    }
    
    function generateURL(id) {
      let query = '?rel=0&showinfo=0&autoplay=1&enablejsapi=1';
    
      return 'https://www.youtube.com/embed/' + id + query;
    } 
  }
}

//Video control
function videoControl(){

  console.warn('videoCntrl function');
  let iframes = document.querySelectorAll('iframe');
  console.log(iframes);
  let nextBtn = document.querySelectorAll('.news-post__full-slider-control-next');
  let prevBtn = document.querySelectorAll('.news-post__full-slider-control-prev');

  for(let i = 0; i < nextBtn.length; i++){
    nextBtn[i].addEventListener('click', function(){
      console.warn('BAM!!');
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

  for(let i = 0; i < prevBtn.length; i++){
    prevBtn[i].addEventListener('click', function(){
      console.warn('BAM!!');
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
  
}

function showMoreBtnRotate() {
  const showMoreBtn = document.querySelector(".show-more");
  const showMoreIconBtn = document.querySelector(".show-more__icon");

  if (showMoreBtn === null || showMoreIconBtn === null ) {
		// console.log("showMoreButnRotate left html");
  } else {
    showMoreBtn.addEventListener("mouseover", function() {
      showMoreIconBtn.classList.add("show-more__icon--rotate");
    });
  
    showMoreBtn.addEventListener("click", function() {
      showMoreIconBtn.classList.add("show-more__icon--click");
    });
  
    showMoreBtn.addEventListener("mouseout", function() {
      showMoreIconBtn.classList.remove("show-more__icon--rotate");
      showMoreIconBtn.classList.remove("show-more__icon--click");
    });

  }
  

 
}
showMoreBtnRotate();

//single news post mech
function singleNewsPostMech(){
  let singleNewsPostContainer = document.querySelector('.single-news-post');

  if(singleNewsPostContainer === null){
    // console.log('no single post on the page');
  } else{
    // console.warn('news post single');
    let singleNewsPost = singleNewsPostContainer.querySelector('.news-post');
    let singleNewsPostPanel = singleNewsPost.querySelector('.news-post__short-panel');
    let singleNewsPostFull = singleNewsPost.querySelector('.news-post__full');
    let singleNewsPostTitle = singleNewsPost.querySelector('.news-post__short-title');
    let singleNewsPostClose = singleNewsPost.querySelector('.news-post__full-close');
    singleNewsPostContainer.style.marginBottom = '35px';

    if(singleNewsPostClose === null){
      newPostSliderSingle();
      fullPostSliderVideo();
    }else{
      singleNewsPostTitle.style.pointerEvents = 'none';
      singleNewsPostPanel.style.display = 'none';
      singleNewsPostFull.style.display = 'block';
      singleNewsPostClose.style.display = 'none';
      
      newPostSliderSingle();
      fullPostSliderVideo();
    }
  }
}
singleNewsPostMech();

function newsShareModal(){
  let shareModal = document.querySelector('.modal-share');
  let btnShareModalClose = document.querySelector('.modal-share__close');
  let shareModalOpenBtn = document.querySelectorAll('.news-post__short-btn--share');

  let body = document.querySelector('body');


  // console.warn(shareModalOpenBtn);

  if(shareModal === null || btnShareModalClose === null) {
    // console.warn('No modals here!');
  } else {
    for(let i = 0; i < shareModalOpenBtn.length; i++){
      shareModalOpenBtn[i].addEventListener('click', function(e){
        e.preventDefault();
        // console.warn(this);
        shareModal.classList.add('modal-share--on');
        body.classList.add('page-body__no-scroll');
      });
    }

    btnShareModalClose.addEventListener('click', function(){
      shareModal.classList.remove('modal-share--on');
      body.classList.remove('page-body__no-scroll');
    });
  }


}
newsShareModal();

function newsAskModal() {
  let askModal = document.querySelector('.modal-ask');
  let btnAskModalClose = document.querySelector('.modal-ask__close');
  let askModalOpenBtn = document.querySelectorAll('.news-post__short-btn--ask');

  let body = document.querySelector('body');

  if(askModal === null || btnAskModalClose === null) {
    // console.warn('No modals here!');
  } else {
    for(let i = 0; i < askModalOpenBtn.length; i++){
      askModalOpenBtn[i].addEventListener('click', function(e){
        e.preventDefault();
        // console.warn(this);
        askModal.classList.add('modal-ask--on');
        body.classList.add('page-body__no-scroll');
      });
    }

    btnAskModalClose.addEventListener('click', function(){
      askModal.classList.remove('modal-ask--on');
      body.classList.remove('page-body__no-scroll');
    });
  }

}
newsAskModal();




//universal slider
function universalPostSliderSingle(){
  let slider = document.querySelectorAll('.universal-slider__slider');
  // console.log(slider);

  if(slider === null){
    // console.log('no news post slider on the page');
  } else{
    
    for(let i = 0; i < slider.length; i++){
    
      let sliderItems = slider[i].querySelector('.universal-slider__slides');
      let sliderSlide = slider[i].querySelectorAll('.universal-slider__slide');
      let prev = slider[i].querySelector('.universal-slider__slider-control-prev');
      let next = slider[i].querySelector('.universal-slider__slider-control-next');

      let sliderWrapper = slider[i].querySelector('.universal-slider__slider-wrapper');
      console.log("I`m here! Single slider");
   

      let parentOfSlider = slider[i].parentElement;

      let parentIsHidden = (parentOfSlider.offsetHeight === 0 && parentOfSlider.offsetWidth === 0);

      //More space to full slider
      if(parentOfSlider.classList.contains('universal-slider__block')){
        
        let intViewportWidth = window.innerWidth;
        if(intViewportWidth < 499){
          console.warn('i`m here! mobile size');
          
          sliderWrapper.style.minHeight = "200px";
          slider[i].style.minHeight = "200px";
          sliderWrapper.style.maxHeight = "200px";
          slider[i].style.maxHeight = "200px";

          sliderSlide.forEach(item => {
            item.style.minHeight = "200px";

            let slidePic = item.querySelector('img');
            slidePic.style.height = "200px"
          })

        }else if(intViewportWidth < 1140){
          console.warn('i`m here! tablet size');
          sliderWrapper.style.minHeight = "350px";
          slider[i].style.minHeight = "350px";
          sliderWrapper.style.maxHeight = "350px";
          slider[i].style.maxHeight = "350px";
  
          sliderSlide.forEach(item => {
            item.style.minHeight = "350px";

            let slidePic = item.querySelector('img');
            slidePic.style.height = "350px"
          })
        }else{
          sliderWrapper.style.minHeight = "480px";
          slider[i].style.minHeight = "480px";
          sliderWrapper.style.maxHeight = "480px";
          slider[i].style.maxHeight = "480px";
  
          sliderSlide.forEach(item => {
            item.style.minHeight = "480px";
          })
        }
        // slider[i].style.minHeigth = '480px';
        // sliderWrapper.style.maxHeigth = '480px';
        // slider[i].style.maxHeigth = '480px';
        // console.log(sliderWrapper);
        // console.log(slider[i]);
      }

      //Check how many slides in slide
      if(sliderSlide.length === 1){
        // console.warn('one slide! turn off slider');
        prev.style.display = 'none';
        next.style.display = 'none';

        sliderSlide.forEach(item => {
          item.style.maxWidth = sliderWrapper.offsetWidth + "px";
        });

      }else{
        // console.warn('many slides! turn on slider')
        sliderItems.style.left ='-' + sliderWrapper.offsetWidth + 'px';

        sliderSlide.forEach(item => {
          item.style.width = sliderWrapper.offsetWidth + 'px';
          item.style.height = sliderWrapper.offsetHight + 'px';
          // console.log(item);
          
        })

        function slide(wrapper, items, prev, next) {
          // console.log("I`m here!");
          let posX1 = 0,
              posX2 = 0,
              posInitial,
              posFinal,
              threshold = 100,
              slides = items.getElementsByClassName('universal-slider__slide'),
              slidesLength = slides.length,
              slideSize = items.getElementsByClassName('universal-slider__slide')[0].offsetWidth,
              firstSlide = slides[0],
              lastSlide = slides[slidesLength - 1],
              cloneFirst = firstSlide.cloneNode(true),
              cloneLast = lastSlide.cloneNode(true),
              index = 0,
              allowShift = true;
          
          // Clone first and last slide
          items.appendChild(cloneFirst);
          items.insertBefore(cloneLast, firstSlide);
          wrapper.classList.add('loaded');
          
          // Mouse events
          items.onmousedown = dragStart;
          
          // Touch events
          items.addEventListener('touchstart', dragStart);
          items.addEventListener('touchend', dragEnd);
          items.addEventListener('touchmove', dragAction);
          
          // Click events
          prev.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(-1);
          });

          next.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(1);
          });
          
          // Transition events
          items.addEventListener('transitionend', checkIndex);
          
          function dragStart (e) {
            e = e || window.event;
            e.preventDefault();
            posInitial = items.offsetLeft;
            
            if (e.type == 'touchstart') {
              posX1 = e.touches[0].clientX;
            } else {
              posX1 = e.clientX;
              document.onmouseup = dragEnd;
              document.onmousemove = dragAction;
            }
          }
      
          function dragAction (e) {
            e = e || window.event;
            
            if (e.type == 'touchmove') {
              posX2 = posX1 - e.touches[0].clientX;
              posX1 = e.touches[0].clientX;
            } else {
              posX2 = posX1 - e.clientX;
              posX1 = e.clientX;
            }
  
            items.style.left = (items.offsetLeft - posX2) + "px";
          }
          
          function dragEnd (e) {
            posFinal = items.offsetLeft;
            if (posFinal - posInitial < -threshold) {
              shiftSlide(1, 'drag');
            } else if (posFinal - posInitial > threshold) {
              shiftSlide(-1, 'drag');
            } else {
              items.style.left = (posInitial) + "px";
            }
      
            document.onmouseup = null;
            document.onmousemove = null;
          }
          
          function shiftSlide(dir, action) {
            items.classList.add('shifting');
            
            if (allowShift) {
              if (!action) { posInitial = items.offsetLeft; }
      
              if (dir == 1) {
                items.style.left = (posInitial - slideSize) + "px";
                index++;      
              } else if (dir == -1) {
                items.style.left = (posInitial + slideSize) + "px";
                index--;      
              }
            };
            
            allowShift = false;
          }
            
          function checkIndex (){
            items.classList.remove('shifting');
      
            if (index == -1) {
              items.style.left = -(slidesLength * slideSize) + "px";
              index = slidesLength - 1;
            }
      
            if (index == slidesLength) {
              items.style.left = -(1 * slideSize) + "px";
              index = 0;
            }
            
            allowShift = true;
          }
  
          slider[i].classList.remove('universal-slider__slider--active');
  
        }

        function slideOnlyButtons(wrapper, items, prev, next) {
          // console.log("I`m here!");
          let posX1 = 0,
              posX2 = 0,
              posInitial,
              posFinal,
              threshold = 100,
              slides = items.getElementsByClassName('universal-slider__slide'),
              slidesLength = slides.length,
              slideSize = items.getElementsByClassName('universal-slider__slide')[0].offsetWidth,
              firstSlide = slides[0],
              lastSlide = slides[slidesLength - 1],
              cloneFirst = firstSlide.cloneNode(true),
              cloneLast = lastSlide.cloneNode(true),
              index = 0,
              allowShift = true;
          
          // Clone first and last slide
          items.appendChild(cloneFirst);
          items.insertBefore(cloneLast, firstSlide);
          wrapper.classList.add('loaded');
          
          // Mouse events
          // items.onmousedown = dragStart;
          
          // Touch events
          // items.addEventListener('touchstart', dragStart);
          // items.addEventListener('touchend', dragEnd);
          // items.addEventListener('touchmove', dragAction);
          
          // Click events
          prev.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(-1);
          });

          next.addEventListener('click', function (e) {
            e.preventDefault();
            shiftSlide(1);
          });
          
          // Transition events
          items.addEventListener('transitionend', checkIndex);

          function shiftSlide(dir, action) {
            items.classList.add('shifting');
            
            if (allowShift) {
              if (!action) { posInitial = items.offsetLeft; }
      
              if (dir == 1) {
                items.style.left = (posInitial - slideSize) + "px";
                index++;      
              } else if (dir == -1) {
                items.style.left = (posInitial + slideSize) + "px";
                index--;      
              }
            };
            
            allowShift = false;
          }
            
          function checkIndex (){
            items.classList.remove('shifting');
      
            if (index == -1) {
              items.style.left = -(slidesLength * slideSize) + "px";
              index = slidesLength - 1;
            }
      
            if (index == slidesLength) {
              items.style.left = -(1 * slideSize) + "px";
              index = 0;
            }
            
            allowShift = true;
          }
  
          slider[i].classList.remove('universal-slider__slider--active');
        }

        let intViewportWidth = window.innerWidth;
        if(intViewportWidth < 1140){
          slide(slider[i], sliderItems, prev, next);
        } else {
          slideOnlyButtons(slider[i], sliderItems, prev, next);
        }    
      }  
    }
  }
}

universalPostSliderSingle()

//Video in universal slider
function fullPostSliderVideo() {
  let videos = document.querySelectorAll('.universal-slider__video');

  if (videos === null) {
    // console.log("sliderVideos left HTML");
  } else {
    for (let i = 0; i < videos.length; i++) {
      setupVideo(videos[i]);
    }

    function setupVideo(video) {
      let link = video.querySelector('.universal-slider__video-link');
      let media = video.querySelector('.universal-slider__video-media');
      let button = video.querySelector('.universal-slider__video-button');


      let id = parseMediaURL(media);
    
      video.addEventListener('click', () => {
        let iframe = createIframe(id);
    
        link.remove();
        button.remove();
        video.appendChild(iframe);

        link.removeAttribute('href');
        video.classList.add('video--enabled');   
       
        videoControlForUniversalSlider();
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
      iframe.setAttribute("id", "newsVideo");
    
      return iframe;
    }
    
    function generateURL(id) {
      let query = '?rel=0&showinfo=0&autoplay=1&enablejsapi=1';
    
      return 'https://www.youtube.com/embed/' + id + query;
    } 
  }
}

fullPostSliderVideo();

function videoControlForUniversalSlider(){

  console.warn('videoCntrl function');
  let iframes = document.querySelectorAll('iframe');
  console.log(iframes);
  let nextBtn = document.querySelectorAll('.universal-slider__slider-control-next');
  let prevBtn = document.querySelectorAll('.universal-slider__slider-control-prev');

  for(let i = 0; i < nextBtn.length; i++){
    nextBtn[i].addEventListener('click', function(){
      // console.warn('BAM!!');
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

  for(let i = 0; i < prevBtn.length; i++){
    prevBtn[i].addEventListener('click', function(){
      // console.warn('BAM!!');
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
}

//universalSLider 2000px
function universalPostSliderSingle2000px(){
  let slider = document.querySelectorAll('.universal-slider__slider');

  if(slider === null){
    // console.log('no news post slider on the page');
  } else{
    let intViewportWidth = window.innerWidth;
    if(intViewportWidth > 1400){

      slider.forEach(item => {
      
        let widthOfSlider = window.getComputedStyle(item).width;
        let widthOfSliderNumber = parseInt(widthOfSlider);
        console.warn(widthOfSliderNumber)

        if(widthOfSliderNumber > '1400' || widthOfSlider == '110vw'){
          item.classList.add("universal-slider__block--wide");
          universalPostSliderSingle2000Helper();
        }
        
      })
    }
  }
}

function universalPostSliderSingle2000Helper(){
  let sliderFull = document.querySelectorAll('.universal-slider__block--wide');
  let mainBlock = document.querySelector('.page-body__main');

  if(sliderFull === null){
    // console.log('no news post slider on the page');
  } else{
    
 
    sliderFull.forEach(item => {    
      let sliderWrapper = item.querySelector('.universal-slider__slider-wrapper');    
      let sliderWrapperWidth = window.getComputedStyle(sliderWrapper).width;
      let sliderWrapperWidthINT = parseInt(sliderWrapperWidth);
      console.warn('sliderWrapperWidthINT');
      console.warn(sliderWrapperWidthINT);

      const imgsOfCurrentSliderSlide = item.querySelectorAll('.universal-slider__slide');
      const imgsOfCurrentSlider = item.querySelectorAll('.universal-slider__slide img');
      const wrapper = item.querySelector('.universal-slider__slider-wrapper');
      const slider = item;

      imgsOfCurrentSlider.forEach(item => {
        item.style.width = sliderWrapperWidthINT + "px";
      })
      imgsOfCurrentSliderSlide.forEach(item => {
        item.style.minHeight = "550px";
        item.style.maxHeight = "550px";
        slider.style.minHeight = "550px";
        slider.style.maxHeight = "550px";
        wrapper.style.minHeight = "550px";
        wrapper.style.maxHeight = "550px";
      })
    })
  }
}

universalPostSliderSingle2000px()