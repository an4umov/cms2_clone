    !function(){"use strict";function o(){var o=window,t=document;if(!("scrollBehavior"in t.documentElement.style&&!0!==o.__forceSmoothScrollPolyfill__)){var l,e=o.HTMLElement||o.Element,r=468,i={scroll:o.scroll||o.scrollTo,scrollBy:o.scrollBy,elementScroll:e.prototype.scroll||n,scrollIntoView:e.prototype.scrollIntoView},s=o.performance&&o.performance.now?o.performance.now.bind(o.performance):Date.now,c=(l=o.navigator.userAgent,new RegExp(["MSIE ","Trident/","Edge/"].join("|")).test(l)?1:0);o.scroll=o.scrollTo=function(){void 0!==arguments[0]&&(!0!==f(arguments[0])?h.call(o,t.body,void 0!==arguments[0].left?~~arguments[0].left:o.scrollX||o.pageXOffset,void 0!==arguments[0].top?~~arguments[0].top:o.scrollY||o.pageYOffset):i.scroll.call(o,void 0!==arguments[0].left?arguments[0].left:"object"!=typeof arguments[0]?arguments[0]:o.scrollX||o.pageXOffset,void 0!==arguments[0].top?arguments[0].top:void 0!==arguments[1]?arguments[1]:o.scrollY||o.pageYOffset))},o.scrollBy=function(){void 0!==arguments[0]&&(f(arguments[0])?i.scrollBy.call(o,void 0!==arguments[0].left?arguments[0].left:"object"!=typeof arguments[0]?arguments[0]:0,void 0!==arguments[0].top?arguments[0].top:void 0!==arguments[1]?arguments[1]:0):h.call(o,t.body,~~arguments[0].left+(o.scrollX||o.pageXOffset),~~arguments[0].top+(o.scrollY||o.pageYOffset)))},e.prototype.scroll=e.prototype.scrollTo=function(){if(void 0!==arguments[0])if(!0!==f(arguments[0])){var o=arguments[0].left,t=arguments[0].top;h.call(this,this,void 0===o?this.scrollLeft:~~o,void 0===t?this.scrollTop:~~t)}else{if("number"==typeof arguments[0]&&void 0===arguments[1])throw new SyntaxError("Value could not be converted");i.elementScroll.call(this,void 0!==arguments[0].left?~~arguments[0].left:"object"!=typeof arguments[0]?~~arguments[0]:this.scrollLeft,void 0!==arguments[0].top?~~arguments[0].top:void 0!==arguments[1]?~~arguments[1]:this.scrollTop)}},e.prototype.scrollBy=function(){void 0!==arguments[0]&&(!0!==f(arguments[0])?this.scroll({left:~~arguments[0].left+this.scrollLeft,top:~~arguments[0].top+this.scrollTop,behavior:arguments[0].behavior}):i.elementScroll.call(this,void 0!==arguments[0].left?~~arguments[0].left+this.scrollLeft:~~arguments[0]+this.scrollLeft,void 0!==arguments[0].top?~~arguments[0].top+this.scrollTop:~~arguments[1]+this.scrollTop))},e.prototype.scrollIntoView=function(){if(!0!==f(arguments[0])){var l=function(o){for(;o!==t.body&&!1===(e=p(l=o,"Y")&&a(l,"Y"),r=p(l,"X")&&a(l,"X"),e||r);)o=o.parentNode||o.host;var l,e,r;return o}(this),e=l.getBoundingClientRect(),r=this.getBoundingClientRect();l!==t.body?(h.call(this,l,l.scrollLeft+r.left-e.left,l.scrollTop+r.top-e.top),"fixed"!==o.getComputedStyle(l).position&&o.scrollBy({left:e.left,top:e.top,behavior:"smooth"})):o.scrollBy({left:r.left,top:r.top,behavior:"smooth"})}else i.scrollIntoView.call(this,void 0===arguments[0]||arguments[0])}}function n(o,t){this.scrollLeft=o,this.scrollTop=t}function f(o){if(null===o||"object"!=typeof o||void 0===o.behavior||"auto"===o.behavior||"instant"===o.behavior)return!0;if("object"==typeof o&&"smooth"===o.behavior)return!1;throw new TypeError("behavior member of ScrollOptions "+o.behavior+" is not a valid value for enumeration ScrollBehavior.")}function p(o,t){return"Y"===t?o.clientHeight+c<o.scrollHeight:"X"===t?o.clientWidth+c<o.scrollWidth:void 0}function a(t,l){var e=o.getComputedStyle(t,null)["overflow"+l];return"auto"===e||"scroll"===e}function d(t){var l,e,i,c,n=(s()-t.startTime)/r;c=n=n>1?1:n,l=.5*(1-Math.cos(Math.PI*c)),e=t.startX+(t.x-t.startX)*l,i=t.startY+(t.y-t.startY)*l,t.method.call(t.scrollable,e,i),e===t.x&&i===t.y||o.requestAnimationFrame(d.bind(o,t))}function h(l,e,r){var c,f,p,a,h=s();l===t.body?(c=o,f=o.scrollX||o.pageXOffset,p=o.scrollY||o.pageYOffset,a=i.scroll):(c=l,f=l.scrollLeft,p=l.scrollTop,a=n),d({scrollable:c,method:a,startTime:h,startX:f,startY:p,x:e,y:r})}}"object"==typeof exports&&"undefined"!=typeof module?module.exports={polyfill:o}:o()}();
    // toogle hidding menu button
    function toggleHiddenMenuBtn(){
      let hiddenMenuBtn = document.querySelector('.hidden-btn__icon');
      let hiddenMenu = document.querySelector('.user-wrapper__hidden-menu');
      let header = document.querySelector('.header');
      
      let body = document.querySelector('body');
    
    
      if(hiddenMenuBtn === null){
        console.log('hiddebBtn just left this time');
      } else {
        let glassBackground = document.createElement("div");
        glassBackground.classList.add('header-blur-wrap');
        header.after(glassBackground);
    
        hiddenMenuBtn.addEventListener('click', function() {
          this.classList.toggle('active');
          hiddenMenu.classList.toggle('hidden-menu--on');
          glassBackground.classList.toggle('header-blur-wrap--on');
          body.classList.toggle('page-body__no-scroll');
        });
    
        glassBackground.addEventListener('click', function(){
          hiddenMenuBtn.classList.remove('active');
          hiddenMenu.classList.remove('hidden-menu--on');
          glassBackground.classList.remove('header-blur-wrap--on');
          body.classList.remove('page-body__no-scroll');
        });
      }
    }
    toggleHiddenMenuBtn();
    
    function headerContactUsModal(){
      let contactUsModal = document.querySelector('.header-contact-us');
      let contactUsModalClose = document.querySelector('.header-contact-us__close');
    
      let contactUsDesktopHeaderNumbers = document.querySelectorAll('.contacts__number');
    
      let contactUsHeaderMobileHidden = document.querySelector('.hidden-menu__call-btn');
      let contactUsHeaderMobileRightPanelNumber = document.querySelector('.right-panel__info');
    
      let contactUsHeaderGlassBack = document.querySelector('.header-contact-us__blur');
    
      let body = document.querySelector('body');
    
      if(contactUsModal === null || contactUsModalClose === null){
        // console.log('No Header modal on the page');
      } else {
    
        for(let i = 0; i < contactUsDesktopHeaderNumbers.length; i++){
          contactUsDesktopHeaderNumbers[i].addEventListener('click', function(e){
            e.preventDefault();
            contactUsModal.style.display = 'block';
            body.classList.add('page-body__no-scroll');
          });
        }
    
        contactUsHeaderMobileHidden.addEventListener('click', function(){
          contactUsModal.style.display = 'block';
          body.classList.add('page-body__no-scroll');
        });
    
        contactUsHeaderMobileRightPanelNumber.addEventListener('click', function(){
          contactUsModal.style.display = 'block';
          body.classList.add('page-body__no-scroll');
        });
    
        contactUsModalClose.addEventListener('click', function(){
          contactUsModal.style.display = 'none';
          body.classList.remove('page-body__no-scroll');
        });
    
        contactUsHeaderGlassBack.addEventListener('click', function(){
          contactUsModal.style.display = 'none';
          body.classList.remove('page-body__no-scroll');
        });
      }
    }
    headerContactUsModal();
    
    //Green navigation arrow mech
    function navArrowMech(){
      let navLeftArrow = document.querySelector('.navigation__arrow-left');
      let navRightArrow = document.querySelector('.navigation__arrow-right');
      let navFirstItem = document.querySelector('.navigation__nav-item');
      let navItemsList = document.querySelectorAll('.navigation__nav-item');
      let navItemsListParent = document.querySelector('.navigation__nav-list');
      
    
      if(navLeftArrow === null || navRightArrow === null || navFirstItem === null){
        // console.log('no navigation on the page');
      }else{
    
        let lastItem = navItemsList[navItemsList.length - 1];
        
        let intViewportWidth = window.innerWidth;
        // console.warn(intViewportWidth);
    
        if(intViewportWidth > 1140){
    
          let coordOfLastItem = lastItem.getBoundingClientRect();
      
          
          
          if(coordOfLastItem.right > intViewportWidth){
            // console.warn('last item out of viewport');
    
            navRightArrow.style.display = 'block';
    
            navRightArrow.addEventListener('click', function(){
              lastItem.scrollIntoView({ block: 'end',  behavior: 'smooth' });
              navRightArrow.style.display = 'none';
              navLeftArrow.style.display = 'block';
            });
    
            navLeftArrow.addEventListener('click', function(){
              navFirstItem.scrollIntoView({ block: 'end', inline: 'end',  behavior: 'smooth' });
              navLeftArrow.style.display = 'none';
              navRightArrow.style.display = 'block';
              
            });
    
          } else{
            console.warn('last item in viewport');
    
            let summ = 0;
            for(let i = 0; i < navItemsList.length; i++){
              summ += navItemsList[i].offsetWidth;
            }
    
            let summPlusPl = summ + 550;
            // console.log('sum of items width ' + summPlusPl + 'px');
            // console.log(intViewportWidth);
    
            if(intViewportWidth > summPlusPl ){
              navItemsListParent.style.justifyContent = 'flex-end';
              navItemsListParent.style.paddingRight = '40px';
              navRightArrow.style.display = 'none';
              navLeftArrow.style.display = 'none';
            }
            
    
          }
        } else {
          console.warn('mobile viewport');
        }
    
    
      }
    }
    
    // navArrowMech();
    
    setTimeout(() => navArrowMech(), 200);
    
    // function watchResizingOfViewPort(){
    //   window.addEventListener("resize", function(){
    //     navArrowMech();
    //   });
    // }
    
    // watchResizingOfViewPort();
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
    
    
    
    
    
    //NEWS MECH | NEWS
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
    
              //Smooth scroll to the proper position
              const yOffset = -90; 
              const y = newsPostFullPost.getBoundingClientRect().top + window.pageYOffset + yOffset;
    
              window.scrollTo({top: y, behavior: 'smooth'});
    
              let currentSliderList = newsPostFullPost.querySelectorAll('.news-post__full-slider');
              // console.log(newsPostFullPost);
              // console.log(currentSliderList);
    
              currentSliderList.forEach(item => {
                item.classList.add('news-post__full-slider--active');
              })
    
            });
    
            newsPostOpenBtn.addEventListener("click", function sliderSwitch(e) {
              e.preventDefault();
              // console.warn("only one!");
              
              newPostSlider();
              fullPostSliderVideoNews();
    
              // newPostSlider();
            }, {once : true});
        
            newsPostFullClose.addEventListener("click", function(e) {
              e.preventDefault();
    
              // newsPostShortPost.scrollIntoView({behavior: "smooth"});
    
              //Smooth scroll to the proper position
              const yOffset = -90; 
              const y = newsPostShortPost.getBoundingClientRect().top + window.pageYOffset + yOffset;
    
              window.scrollTo({top: y, behavior: 'smooth'});
    
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
              console.warn('i`m here! newPostSlider mobile size');
              
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
              console.warn('i`m here! newPostSlider tablet size');
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
              console.warn('i`m here! newPostSlider Desktop size');
              sliderWrapper.style.minHeight = "480px";
              slider[i].style.minHeight = "480px";
              sliderWrapper.style.maxHeight = "480px";
              slider[i].style.maxHeight = "480px";
      
              sliderSlide.forEach(item => {
                item.style.minHeight = "480px";
              })
            }
          }
    
          //Check how many slides in slide
          if(sliderSlide.length === 1){
            // console.warn('one slide! turn off slider');
            prev.style.display = 'none';
            next.style.display = 'none';
    
            sliderSlide.forEach(item => {
              item.style.maxWidth = sliderWrapper.offsetWidth + "px";
            });
    
          }else {
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
         
          const sliderParent = slider[i].parentElement;
          
         
          const dataHeightDesktopOfSlider = sliderParent.dataset.heightDesktop;
          const dataHeightTabletOfSlider = sliderParent.dataset.heightTablet;
          const dataHeightMobileOfSlider = sliderParent.dataset.heightMobile;
    
    
          let parentOfSlider = slider[i].parentElement;
         
          //More space to full slider
          function newPostSliderSingleDynamicHeight(){
            // console.warn('i`m here! newPostSliderSingleDynamicHeight ');
            let intViewportWidth = window.innerWidth;
            if(intViewportWidth < 499){
              // console.warn('i`m here! newPostSliderSingle mobile size');
              
              sliderWrapper.style.minHeight = dataHeightMobileOfSlider + "px";
              slider[i].style.minHeight = dataHeightMobileOfSlider + "px";
              sliderWrapper.style.maxHeight = dataHeightMobileOfSlider + "px";
              slider[i].style.maxHeight = dataHeightMobileOfSlider + "px";
              sliderParent.style.maxHeight = dataHeightMobileOfSlider + "px";
              sliderParent.style.minHeight = dataHeightMobileOfSlider + "px";
    
              sliderSlide.forEach(item => {
                item.style.minHeight = dataHeightMobileOfSlider + "px";
    
                let slidePic = item.querySelector('img');
                slidePic.style.height = dataHeightMobileOfSlider + "px";
              })
    
            }else if(intViewportWidth < 1140){
              // console.warn('i`m here! newPostSliderSingle tablet size');
              sliderWrapper.style.minHeight = dataHeightTabletOfSlider+ "px";
              slider[i].style.minHeight =  dataHeightTabletOfSlider+ "px";
              sliderWrapper.style.maxHeight =  dataHeightTabletOfSlider+ "px";
              slider[i].style.maxHeight =  dataHeightTabletOfSlider+ "px";
              sliderParent.style.maxHeight = dataHeightTabletOfSlider + "px";
              sliderParent.style.minHeight = dataHeightTabletOfSlider + "px";
      
              sliderSlide.forEach(item => {
                item.style.minHeight =  dataHeightTabletOfSlider+ "px";
    
                let slidePic = item.querySelector('img');
                slidePic.style.height =  dataHeightTabletOfSlider+ "px";
              })
            }else{
              // console.warn('i`m here! newPostSliderSingle Desktpop size');
              sliderWrapper.style.minHeight = dataHeightDesktopOfSlider + "px";
              slider[i].style.minHeight = dataHeightDesktopOfSlider + "px";
              sliderWrapper.style.maxHeight = dataHeightDesktopOfSlider + "px";
              slider[i].style.maxHeight = dataHeightDesktopOfSlider + "px";
              sliderParent.style.maxHeight = dataHeightDesktopOfSlider + "px";
              sliderParent.style.minHeight = dataHeightDesktopOfSlider + "px";
      
              sliderSlide.forEach(item => {
                item.style.minHeight = dataHeightDesktopOfSlider + "px";
              })
            }
          }
    
          newPostSliderSingleDynamicHeight()
        
          //Check how many slides in slide
          if(sliderSlide.length === 1){
            // console.warn('one slide! turn off slider');
            prev.style.display = 'none';
            next.style.display = 'none';
    
            sliderSlide.forEach(item => {
              item.style.maxWidth = sliderWrapper.offsetWidth + "px";
            });
    
          }else{
            
            sliderItems.style.left ='-' + sliderWrapper.offsetWidth + 'px';
    
            sliderSlide.forEach(item => {
              item.style.width = sliderWrapper.offsetWidth + 'px';
              item.style.height = sliderWrapper.offsetHight + 'px';
            })
    
            function slideSingle(wrapper, items, prev, next) {
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
    
            function slideOnlyButtonsSingle(wrapper, items, prev, next) {
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
              slideSingle(slider[i], sliderItems, prev, next);
            } else {
              slideOnlyButtonsSingle(slider[i], sliderItems, prev, next);
            }    
          }  
        }
      }
    }
    
    
    //Video  in slider
    function fullPostSliderVideoNews() {
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
          fullPostSliderVideoNews();
        }else{
          singleNewsPostTitle.style.pointerEvents = 'none';
          singleNewsPostPanel.style.display = 'none';
          singleNewsPostFull.style.display = 'block';
          singleNewsPostClose.style.display = 'none';
          
          newPostSliderSingle();
          fullPostSliderVideoNews();
        }
      }
    }
    singleNewsPostMech();
    
    function singleUniversalSliderMech(){
      let singleUniversalSliderContainer = document.querySelector('.single-universal-slider');
    
      if(singleUniversalSliderContainer === null){
        // console.log('no single post on the page');
      } else{
        // console.warn('news post single');
        newPostSliderSingle();
        fullPostSliderVideoNews();
    
      }
    }
    
    singleUniversalSliderMech();
    
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
    
    
    //universalSLider 2000px
    // function universalPostSliderSingle2000px(){
    //   let slider = document.querySelectorAll('.universal-slider__slider');
    
    //   if(slider === null){
    //     // console.log('no news post slider on the page');
    //   } else{
    //     let intViewportWidth = window.innerWidth;
    //     if(intViewportWidth > 1400){
    
    //       slider.forEach(item => {
          
    //         let widthOfSlider = window.getComputedStyle(item).width;
    //         let widthOfSliderNumber = parseInt(widthOfSlider);
    //         console.warn(widthOfSliderNumber)
    
    //         if(widthOfSliderNumber > '1400' || widthOfSlider == '110vw'){
    //           item.classList.add("universal-slider__block--wide");
    //           universalPostSliderSingle2000Helper();
    //         }
            
    //       })
    //     }
    //   }
    // }
    
    function universalPostSliderSingle2000Helper(){
      let sliderFull = document.querySelectorAll('.universal-slider__block--wide');
      let mainBlock = document.querySelector('.page-body__main');
    
      if(sliderFull === null){
        // console.log('no news post slider on the page');
      } else{
        sliderFull.forEach(item => {   
          let parentOfSlider = item.parentElement; 
          const dataHigh2kOfSlider = parentOfSlider.dataset.hieghtWideDesktop;
          let sliderWrapper = item.querySelector('.universal-slider__slider-wrapper');    
          let sliderWrapperWidth = window.getComputedStyle(sliderWrapper).width;
          let sliderWrapperWidthINT = parseInt(sliderWrapperWidth);
          // console.warn('sliderWrapperWidthINT');
          // console.warn(sliderWrapperWidthINT);
    
          const imgsOfCurrentSliderSlide = item.querySelectorAll('.universal-slider__slide');
          const imgsOfCurrentSlider = item.querySelectorAll('.universal-slider__slide img');
          const wrapper = item.querySelector('.universal-slider__slider-wrapper');
          const slider = item;
    
          imgsOfCurrentSlider.forEach(item => {
            item.style.width = sliderWrapperWidthINT + "px";
          })
          imgsOfCurrentSliderSlide.forEach(item => {
            item.style.minHeight = dataHigh2kOfSlider +"px";
            item.style.maxHeight = dataHigh2kOfSlider +"px";
            slider.style.minHeight = dataHigh2kOfSlider +"px";
            slider.style.maxHeight = dataHigh2kOfSlider +"px";
            wrapper.style.minHeight = dataHigh2kOfSlider +"px";
            wrapper.style.maxHeight = dataHigh2kOfSlider +"px";
          })
        })
      }
    }
    function newsPostAskModal() {
    
        let askButton = document.querySelectorAll('.bar-btns__ask');
        let modalAsk = document.querySelector('.modal-ask');
        let modalAskClose = document.querySelector('.modal-ask__form-close');
    
        
    
        if (askButton === null || modalAsk === null || modalAskClose === null) {
            // console.log("askButton left html");
            
    	} else {
            
    
            for(let i = 0; i < askButton.length; i++){
                askButton[i].addEventListener("click", function(e) {
                    e.preventDefault();
                    modalAsk.style.display = "flex";
                });
            }
    
           
            modalAskClose.addEventListener('click', function() {
                modalAsk.style.display = "none";
            });
        }
    
        
    }
    
    newsPostAskModal();
    
    function newsPostShareModal() {
        let shareButton = document.querySelectorAll('.bar-btns__share');
        let modalShare = document.querySelector('.modal-share');
        let modalShareClose = document.querySelector(".modal-share__form-close");
    
        if (shareButton === null || modalShare === null || modalShareClose === null) {
    		// console.log("askButton left html");
    	} else {
    
            for(let i = 0; i < shareButton.length; i++){
                shareButton[i].addEventListener("click", function(e) {
                    e.preventDefault();
                    modalShare.style.display = "flex";
                });
            }
            
            modalShareClose.addEventListener('click', function() {
                modalShare.style.display = "none";
            });
        }
    }
    
    newsPostShareModal();
    
    // modals on vendor-page
    function vendorPageAskModal() {
        let askButton = document.querySelector('.single-vendor-description__panel--ask');
        let modalAsk = document.querySelector('.modal-ask');
        let modalAskClose = document.querySelector('.modal-ask__form-close');
    
        if (askButton === null || modalAsk === null || modalAskClose === null) {
            // console.log("askButton left html");
            
    	}else{
            askButton.addEventListener("click", function(e) {
                e.preventDefault();
                modalAsk.style.display = "flex";
            });
    
            modalAskClose.addEventListener('click', function() {
                modalAsk.style.display = "none";
            });
        } 
    }
    
    vendorPageAskModal();
    
    function vendorPageShareModal() {
        let shareButton = document.querySelector('.single-vendor-description__panel--share');
        let modalShare = document.querySelector('.modal-share');
        let modalShareClose = document.querySelector(".modal-share__form-close");
    
        if (shareButton === null || modalShare === null || modalShareClose === null) {
    		// console.log("askButton left html");
    	} else {
    
            shareButton.addEventListener("click", function(e) {
                e.preventDefault();
                modalShare.style.display = "flex";
            });
            
            modalShareClose.addEventListener('click', function() {
                modalShare.style.display = "none";
            });
        }  
    }
    
    vendorPageShareModal();
    //desktop functions
    function shopCatalogMechDesktop() {
        let firstSection = document.querySelector('.shop-catalog-desktop__inner');
        let firstTitleOpen = document.querySelector('.shop-catalog-desktop__title-open');
        let firstTitleClose = document.querySelector('.shop-catalog-desktop__title-close');
        let firstTitleStatic = document.querySelector('.shop-catalog-desktop__title-static');
        let firstSectionItems = document.querySelectorAll('.shop-catalog-desktop__item');
    
        firstTitleOpen.style.display = 'none';
        firstTitleStatic.style.display = 'block';
    
        let models = document.querySelectorAll('.shop-catalog-desktop__item');
    
        let secondSections = document.querySelectorAll('.shop-catalog-desktop__inner--second');
        let secondTitleBlocks = document.querySelectorAll('.shop-catalog-desktop__title--second');
        let secondSectionItems = document.querySelectorAll('.shop-catalog-desktop__item--second');
    
        let thirdSections = document.querySelectorAll('.shop-catalog-desktop__inner--third');
        let thirdTitleBlocks = document.querySelectorAll('.shop-catalog-desktop__title--third');
        let thirdSectionItems = document.querySelectorAll('.shop-catalog-desktop__item--third');
    
        let fourthSections = document.querySelectorAll('.shop-catalog-desktop__inner--fourth');
        let fourthTitleBlocks = document.querySelectorAll('.shop-catalog-desktop__title--fourth');
        let fourthSectionsItems = document.querySelectorAll('.shop-catalog-desktop__item--fourth');
    
    
        //Active hover on items/models
        for (let i = 0; i < firstSectionItems.length; i++) {
            let firstItemsTextBlock = firstSectionItems[i].querySelector('.shop-catalog-desktop__item-text');
    
            firstSectionItems[i].addEventListener('mouseover', function () {
                let modelNoOffersBlock = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--model-no-offers');
                let itemNoModel = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--no-model');
                if(modelNoOffersBlock === null && itemNoModel === null){
                    firstItemsTextBlock.classList.add('shop-catalog-desktop__item-text--hover');
                } else{
                    
                }
                
            });
    
            firstSectionItems[i].addEventListener('mouseout', function () {
                let modelNoOffersBlock = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--model-no-offers');
                let itemNoModel = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--no-model');
                if(modelNoOffersBlock === null && itemNoModel === null){
                    firstItemsTextBlock.classList.remove('shop-catalog-desktop__item-text--hover');
                } else{
                    
                }
                
            });
        }
    
        for (let i = 0; i < secondSectionItems.length; i++) {
            let firstItemsTextBlock = secondSectionItems[i].querySelector('.shop-catalog-desktop__item-text');
    
            secondSectionItems[i].addEventListener('mouseover', function () {
                let modelNoOffersBlock = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--model-no-offers');
                let itemNoModel = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--no-model');
                if(modelNoOffersBlock === null && itemNoModel === null){
                    firstItemsTextBlock.classList.add('shop-catalog-desktop__item-text--hover');
                } else{
                    
                }
            });
    
            secondSectionItems[i].addEventListener('mouseout', function () {
                let modelNoOffersBlock = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--model-no-offers');
                let itemNoModel = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--no-model');
                if(modelNoOffersBlock === null && itemNoModel === null){
                    firstItemsTextBlock.classList.remove('shop-catalog-desktop__item-text--hover');
                } else{
                    
                }
            });
        }
    
        for (let i = 0; i < thirdSectionItems.length; i++) {
            let firstItemsTextBlock = thirdSectionItems[i].querySelector('.shop-catalog-desktop__item-text');
    
            thirdSectionItems[i].addEventListener('mouseover', function () {
                let modelNoOffersBlock = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--model-no-offers');
                let itemNoModel = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--no-model');
                if(modelNoOffersBlock === null && itemNoModel === null){
                    firstItemsTextBlock.classList.add('shop-catalog-desktop__item-text--hover');
                } else{
                    
                }
            });
    
            thirdSectionItems[i].addEventListener('mouseout', function () {
                let modelNoOffersBlock = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--model-no-offers');
                let itemNoModel = firstItemsTextBlock.querySelector('.shop-catalog-desktop__tag-link--no-model');
                if(modelNoOffersBlock === null && itemNoModel === null){
                    firstItemsTextBlock.classList.remove('shop-catalog-desktop__item-text--hover');
                } else{
                    
                }
            });
        }
    
        for (let i = 0; i < fourthSectionsItems.length; i++) {
            let firstItemsTextBlock = fourthSectionsItems[i].querySelector('.shop-catalog-desktop__item-text');
    
            fourthSectionsItems[i].addEventListener('mouseover', function () {
                firstItemsTextBlock.classList.add('shop-catalog-desktop__item-text--hover');
            });
    
            fourthSectionsItems[i].addEventListener('mouseout', function () {
                firstItemsTextBlock.classList.remove('shop-catalog-desktop__item-text--hover');
            });
        }
    
        // Click on each Model on the 1 lvl of catalog
        for (let i = 0; i < models.length; i++) {
            models[i].addEventListener('click', function (e) {
                e.preventDefault();
                ShopCatalogDesktopMetaHide();
                //clear second title/items defend after repeat
                function clearSecondTitlesItems(){
                    secondTitleBlocks.forEach(item => {
                        item.style.display = 'none';
                    });
        
                    secondSectionItems.forEach(item => {
                        item.style.display = 'none';
                    });
        
                    thirdTitleBlocks.forEach(item => {
                        item.style.display = 'none';
                    });
        
                    thirdSectionItems.forEach(item => {
                        item.style.display = 'none';
                    });
        
                    fourthTitleBlocks.forEach(item => {
                        item.style.display = 'none';
                    });
        
                    fourthSectionsItems.forEach(item => {
                        item.style.display = 'none';
                    });
        
                    secondSections.forEach(item => {
                        item.style.display = 'none';
                    });
        
                    thirdSections.forEach(item => {
                        item.style.display = 'none';
                    });
        
                    fourthSections.forEach(item => {
                        item.style.display = 'none';
                    });
                }
                clearSecondTitlesItems();
    
                function innerBlocksActivesClear1Stage(){
                    secondSections.forEach(item => {
                        item.classList.remove('shop-catalog-desktop__inner--second-active');
                    });
        
                    thirdSections.forEach(item => {
                        item.classList.remove('shop-catalog-desktop__inner--third-active');
                    });
        
                    fourthSections.forEach(item => {
                        item.classList.remove('shop-catalog-desktop__inner--fourth-active');
                    });
                }
                innerBlocksActivesClear1Stage();
    
                clearLastOfferData();
                fourthBlocksClear();
                thirdBlocksClear();
                secondBlocksClear();
                modelsClear();
    
                let model = this.querySelector("a");
                let modelTextBlock = this.querySelector('.shop-catalog-desktop__item-text');
                modelTextBlock.classList.add('shop-catalog-desktop__item-text--active');
                let modelData = model.dataset;
                
                secondSections.forEach(item => {
                    if (item.dataset.code == model.dataset.code) {
                        
                        let currentSecondSection = item;
                        currentSecondSection.style.display = 'flex';
                        currentSecondSection.classList.add('shop-catalog-desktop__inner--second-active');
                        
                        //Smooth scroll to the proper position
                        const yOffset = -90; 
                        const y = currentSecondSection.getBoundingClientRect().top + window.pageYOffset + yOffset;
    
                        window.scrollTo({top: y, behavior: 'smooth'});
    
    
                        let titleOfCurrentSecondBlock = currentSecondSection.querySelector('.shop-catalog-desktop__title--second');
                        let titleOpenOfCurrentSecondBlock = currentSecondSection.querySelector('.shop-catalog-desktop__title-open--second');
                        let titleCloseOfCurrentSecondBlock = currentSecondSection.querySelector('.shop-catalog-desktop__title-close--second');
                        let titleStaticCurrentSecondBlock = currentSecondSection.querySelector('.shop-catalog-desktop__title-static--second');
    
                        titleOfCurrentSecondBlock.style.display = 'flex';
                        titleOpenOfCurrentSecondBlock.style.display = 'none';
                        titleStaticCurrentSecondBlock.style.display = 'block';
    
    
                        firstTitleStatic.style.display = 'none';
                        firstTitleOpen.style.display = 'flex';
    
    
    
                        let itemsFromCurrentSecondSection = currentSecondSection.querySelectorAll('.shop-catalog-desktop__item--second');
                        itemsFromCurrentSecondSection.forEach(item => {
                            item.style.display = 'block';
                        });
    
                        // Click on each Item on the 2 lvl of catalog
                        for (let i = 0; i < secondSectionItems.length; i++) {
                            secondSectionItems[i].addEventListener('click', function (e) {
                                e.preventDefault();
                                //clear repeat / re-opened blocks
                                thirdTitleBlocks.forEach(item => {
                                    item.style.display = 'none';
                                });
    
                                thirdSectionItems.forEach(item => {
                                    item.style.display = 'none';
                                });
                  
                                function innerBlocksActivesClear2Stage(){
                        
                                    thirdSections.forEach(item => {
                                        item.classList.remove('shop-catalog-desktop__inner--third-active');
                                    });
                        
                                    fourthSections.forEach(item => {
                                        item.classList.remove('shop-catalog-desktop__inner--fourth-active');
                                    });
                                }
                                innerBlocksActivesClear2Stage();
    
                                // titleStaticCurrentSecondBlock.style.display = 'none';
                                // titleOpenOfCurrentSecondBlock.style.display = 'block';
    
                                thirdSections.forEach(item => {
                                    item.style.display = 'none';
                                });
    
                                fourthSections.forEach(item => {
                                    item.style.display = 'none';
                                });
    
                                clearLastOfferData();
                                fourthBlocksClear();
                                thirdBlocksClear();
                                secondBlocksClear();
    
                                let secondItem = this.querySelector('a');
                                let secondTextBlock = this.querySelector('.shop-catalog-desktop__item-text');
                                secondTextBlock.classList.add('shop-catalog-desktop__item-text--active');
    
                                thirdSections.forEach(item => {
                                    if (item.dataset.code == secondItem.dataset.code) {
                                        
                                        let currentThirdSection = item;
                                        currentThirdSection.style.display = 'flex';
                                        currentThirdSection.classList.add('shop-catalog-desktop__inner--third-active');
                        
                                        //Smooth scroll to the proper position
                                        const yOffset = -90; 
                                        const y = currentThirdSection.getBoundingClientRect().top + window.pageYOffset + yOffset;
    
                                        window.scrollTo({top: y, behavior: 'smooth'});
    
                                        let titleOfCurrentThirdBlock = currentThirdSection.querySelector('.shop-catalog-desktop__title--third');
                                        let titleOpenOfCurrentThirdBlock = currentThirdSection.querySelector('.shop-catalog-desktop__title-open--third');
                                        let titleCloseOfCurrentThirdBlock = currentThirdSection.querySelector('.shop-catalog-desktop__title-close--third');
                                        let titleStaticCurrentThirdBlock = currentThirdSection.querySelector('.shop-catalog-desktop__title-static--third');
    
                                        titleOfCurrentThirdBlock.style.display = 'flex';
                                        titleOpenOfCurrentThirdBlock.style.display = 'none';
                                        titleStaticCurrentThirdBlock.style.display = 'flex';
    
                                        let itemsFromCurrentThirdSection = currentThirdSection.querySelectorAll('.shop-catalog-desktop__item--third');
                                        itemsFromCurrentThirdSection.forEach(item => {
                                            item.style.display = 'block';
                                        });
                                      
                                        // Click on each Item on the 3 lvl of catalog
                                        for (let i = 0; i < thirdSectionItems.length; i++) {
                                            thirdSectionItems[i].addEventListener('click', function (e) {
                                                e.preventDefault();
                                                fourthTitleBlocks.forEach(item => {
                                                    item.style.display = 'none';
                                                });
    
                                                fourthSectionsItems.forEach(item => {
                                                    item.style.display = 'none';
                                                });
    
                                                fourthSections.forEach(item => {
                                                    item.style.display = 'none';
                                                });
    
                                                function innerBlocksActivesClear3Stage(){
                                        
                                                    fourthSections.forEach(item => {
                                                        item.classList.remove('shop-catalog-desktop__inner--third-active');
                                                    });
                                        
                                                }
                                                innerBlocksActivesClear3Stage();
    
                                                clearLastOfferData();
                                                fourthBlocksClear();
                                                thirdBlocksClear();
    
                                                // titleStaticCurrentThirdBlock.style.display = 'none';
                                                // titleOpenOfCurrentThirdBlock.style.display = 'flex';
    
                                                let thirdItem = this.querySelector('a');
                                                let thirdTextBlock = this.querySelector('.shop-catalog-desktop__item-text');
                                                thirdTextBlock.classList.add('shop-catalog-desktop__item-text--active');
    
                                                fourthSections.forEach(item => {
                                                    if (item.dataset.code == thirdItem.dataset.code) {
                                                        let currentFourthSection = item;
                                                        currentFourthSection.style.display = 'flex';
                                                        currentFourthSection.classList.add('shop-catalog-desktop__inner--fourth-active');
    
                                                        
                                                        //Smooth scroll to the proper position
                                                        const yOffset = -90; 
                                                        const y = currentFourthSection.getBoundingClientRect().top + window.pageYOffset + yOffset;
    
                                                        window.scrollTo({top: y, behavior: 'smooth'});
    
                                                        let titleOfCurrentFourthBlock = currentFourthSection.querySelector('.shop-catalog-desktop__title--fourth');
                                                        let titleOpenOfCurrentFourthBlock = currentFourthSection.querySelector('.shop-catalog-desktop__title-open--fourth');
                                                        let titleCloseOfCurrentFourthBlock = currentFourthSection.querySelector('.shop-catalog-desktop__title-close--fourth');
    
                                                        titleOfCurrentFourthBlock.style.display = 'flex';
    
                                                        let itemsFromCurrentFourthSection = currentFourthSection.querySelectorAll('.shop-catalog-desktop__item--fourth');
    
                                                        itemsFromCurrentFourthSection.forEach(item => {
                                                            item.style.display = 'block';
                                                        });
                                                    }
                                                });
                                            });
                                        }
                                    }
                                });
                            });
                        }
                    }
                });
            });
        }
    }
    
    function shopCatalogWithOutFirstTitle(){
        let firstTitle = document.querySelector('.shop-catalog-desktop__title');
    
        if(firstTitle === null){
    
        }else {           
            firstTitle.style.marginLeft = '-19.5%';
            firstTitle.style.visibility = 'hidden';
        }
    }
    shopCatalogWithOutFirstTitle();
    
    function shopCatalogDesktopMetaCloser(){
        let firstSection = document.querySelector('.shop-catalog-desktop__inner');
        const innerSecondActive = document.querySelector('.shop-catalog-desktop__inner--second-active');   
        const innerThirdActive = document.querySelector('.shop-catalog-desktop__inner--third-active'); 
        const finalItemActive = document.querySelector('.final-item--active');
    
        const shopCatalogParent = document.querySelector('.shop-catalog-desktop');   
    
        if(innerThirdActive === null){
            
        }else{
            const innerFirstActiveTitle = firstSection.querySelector('.shop-catalog-desktop__title');
            const innerSecondActiveTitle = innerSecondActive.querySelector('.shop-catalog-desktop__title--second');
            const innerThirdActiveTitle = innerThirdActive.querySelector('.shop-catalog-desktop__title--third');
    
            //CLONE First Meta Title  
            let firstActiveTitleMeta = innerFirstActiveTitle.cloneNode(true);
            firstActiveTitleMeta.classList.add('shop-catalog-desktop__title--first-meta');
            firstActiveTitleMeta.style.marginLeft = '25px';
            firstActiveTitleMeta.style.visibility = 'visible';
            //CLONE Second Meta Title  
            let secondActiveTitleMeta = innerSecondActiveTitle.cloneNode(true);
            secondActiveTitleMeta.classList.add('shop-catalog-desktop__title--second-meta');
            //Transform to OPEN Phase
            const innerSecondMetaTitleStaticBlock = secondActiveTitleMeta.querySelector('.shop-catalog-desktop__title-static--second');
            const innerSecondMetaTitleOpenBlock = secondActiveTitleMeta.querySelector('.shop-catalog-desktop__title-open--second');
            innerSecondMetaTitleStaticBlock.style.display = 'none';
            innerSecondMetaTitleOpenBlock.style.display = 'block';
            //CLONE Third Meta Title  
            const thirdActiveTitleMeta = innerThirdActiveTitle.cloneNode(true);
            thirdActiveTitleMeta.classList.add('shop-catalog-desktop__title--third-meta');
            //Transform to OPEN Phase
            const innerThirdMetaTitleStaticBlock = thirdActiveTitleMeta.querySelector('.shop-catalog-desktop__title-static--third');
            const innerThirdMetaTitleOpenBlock = thirdActiveTitleMeta.querySelector('.shop-catalog-desktop__title-open--third');
            innerThirdMetaTitleStaticBlock.style.display = 'none';
            innerThirdMetaTitleOpenBlock.style.display = 'block';
            //Clone Final item ACTIVE
            const finalItemParent = finalItemActive.parentElement;
            const finalItemActiveMeta = finalItemParent.cloneNode(true);
            finalItemActiveMeta.classList.add('final-item--active-meta');
            finalItemActiveMeta.style.pointerEvents = 'none';
            finalItemActiveMeta.style.display = 'block';
    
            // console.warn(secondActiveTitleMeta);
            // console.warn(shopCatalogInnerThirdActiveTitleMeta);
            let metaInner = document.createElement('div');
            metaInner.classList.add('shop-catalog-desktop__inner--meta');
            firstSection.before(metaInner);
            
            metaInner.append(firstActiveTitleMeta);
            metaInner.append(secondActiveTitleMeta);
            metaInner.append(thirdActiveTitleMeta);
            metaInner.append(finalItemActiveMeta);
    
            firstSection.style.display = 'none';
            innerSecondActive.style.display = 'none';
            innerThirdActive.style.display = 'none';
    
            //Now OPEN
            //First level
            firstActiveTitleMeta.addEventListener('click', function(){
                firstSection.style.display = 'flex';
                clearLastOfferData();
                //Smooth scroll to the proper position
                const yOffset = -370; 
                const y = firstSection.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({top: y, behavior: 'smooth'});
    
                ShopCatalogDesktopMetaHide();
                finalItemActiveClear();
            });
            secondActiveTitleMeta.addEventListener('click', function(){
                firstSection.style.display = 'flex';
                innerSecondActive.style.display = 'flex';
                //Smooth scroll to the proper position
                const yOffset = -370; 
                const y = innerSecondActive.getBoundingClientRect().top + window.pageYOffset + yOffset;
    
                window.scrollTo({top: y, behavior: 'smooth'});
    
                ShopCatalogDesktopMetaHide();
                finalItemActiveClear();
            });
    
            thirdActiveTitleMeta.addEventListener('click', function(){
                firstSection.style.display = 'flex';
                innerSecondActive.style.display = 'flex';
                innerThirdActive.style.display = 'flex';
                //Smooth scroll to the proper position
                const yOffset = -370; 
                const y = innerThirdActive.getBoundingClientRect().top + window.pageYOffset + yOffset;
    
                window.scrollTo({top: y, behavior: 'smooth'});
    
                ShopCatalogDesktopMetaHide();
                finalItemActiveClear();
            });
        }
    }
    
    //clear final-item active
    function finalItemActiveClear(){
        const finalItemsActive = document.querySelectorAll('.final-item--active');
        if(finalItemsActive === null){
    
        }else{
            finalItemsActive.forEach(item =>{
                item.classList.remove('final-item--active');
            });
        }
    }
    
    //hide Inner Meta block
    function ShopCatalogDesktopMetaHide(){
        let innerMetaBlock = document.querySelector('.shop-catalog-desktop__inner--meta');
    
        if(innerMetaBlock === null){
    
        }else{
            innerMetaBlock.remove();
        }
    }
    
    //Final item fetching from server | Desktop
    function shopCatalogFetchDesktop() {
        let finalItems = document.querySelectorAll('.final-item');
        let offersContainer = document.querySelector('.offersContainer');
        let preloaderContainer = document.querySelector('.preloader-container');
    
        for (let i = 0; i < finalItems.length; i++) {
            finalItems[i].addEventListener('click', function(e){
                e.preventDefault();
                fourthBlocksClear();
                clearLastOfferData() ;
    
                const finalItem = this;
                finalItem.classList.add('final-item--active');
                const finalItemCode = finalItem.dataset.code;
                // console.log(finalItem);
                const finalItemUrl = finalItem.getAttribute("href");
                // console.log(finalItemUrl);
                let requestUrl = `/catalog/offers/${finalItemCode}`;
                // console.log(requestUrl);
    
                let finalItemTextBlock = this.querySelector('.shop-catalog-desktop__item-text');
                finalItemTextBlock.classList.add('shop-catalog-desktop__item-text--active');
    
                preloaderContainer.style.display = 'flex';
                preloaderContainer.style.paddingTop = '80px';
    
                //meta mech
                shopCatalogDesktopMetaCloser();
               
                //Smooth scroll to the proper position
                const yOffset = -90; 
                const y = preloaderContainer.getBoundingClientRect().top + window.pageYOffset + yOffset;
    
                window.scrollTo({top: y, behavior: 'smooth'});
    
                function fetchingOffers(){
    
                    const xhr = new XMLHttpRequest();
    
                    xhr.open("POST", requestUrl, true);
    
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    // const offerContainer = document.querySelector('.offersContainer');
    
                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
    
                            const response = xhr.response;
                            let responseHtml = document.createElement("div");
                            responseHtml.innerHTML = response;
                            
                            
                            offersContainer.appendChild(responseHtml);
                            shopCatalogMechDesktop();
    
                            hideFirstSeparatorOnMobile();
                            hideFirstSeparatorOnDesktop();
    
                            offerCardMobileOpen();                                   
                            offerCardMobileInfoOpen();
                            
                            offerCardDesktopOpen();
                            offerCardDesktopInfoOpen();
    
                            offerCardMobileBuyButtonMech();
                            offerCardDesktopBuyButtonMech();
    
                            offerCardDesktopBuyButtonTooltip();
                            offerCardDesktopBuyButtonDoneTooltip();
    
                            offerCardMobileFastBuy();
                            offerCardDesktopFastBuy();
    
                            offerCardDesktopBuyButtonTooltip();
                            offerCardDesktopFastBuyTooltipMech();
    
                            desktopCardMoreBtn();
    
                            offersCardDesktopFavoriteBtnAdd();
                            offersCardDesktopFavoriteBtnRemove();
    
                            offerCardFavoriteBtnMobileAdd();
                            offerCardFavoriteBtnMobileRemove();
    
                            offersCatalogSortByPriceMechDesktop();
                            offersCatalogSortByPriceMechMobile();
    
                            shopCatalogPager();
                            generateNextOfferBtn();
                            
                            preloaderContainer.style.display = 'none';
                            offersContainer.style.display = 'block';
                            
                            //Smooth scroll to the proper position
                            const yOffset = -90; 
                            const y = offersContainer.getBoundingClientRect().top + window.pageYOffset + yOffset;
    
                            window.scrollTo({top: y, behavior: 'smooth'});
                        }
                    } 
                    
                    xhr.send(finalItemUrl);
                }
    
                setTimeout(fetchingOffers, 1000);
                   
            });
        }
    }
    
    function clearLastOfferData() {
        let offersContainer = document.querySelector('.offersContainer');
        let lastFetchedOffer = offersContainer.querySelector('div');
        
        if(lastFetchedOffer === null) {
            // console.log("offersContainer is empty"); 
        } else {
            // console.log('offersContainer is NOT empty');
            offersContainer.removeChild(lastFetchedOffer);
        }
    }
    //text-block clear functions
    function modelsClear() {
        let firstSect = document.querySelectorAll('.shop-catalog-desktop__item');
        firstSect.forEach(item => {
            let modelTextBlock = item.querySelector('.shop-catalog-desktop__item-text');
            modelTextBlock.classList.remove('shop-catalog-desktop__item-text--active');
        });
    }
    
    function secondBlocksClear() {
        let secondSect = document.querySelectorAll('.shop-catalog-desktop__item--second');
        secondSect.forEach(item => {
            let secTextBlock = item.querySelector('.shop-catalog-desktop__item-text');
            secTextBlock.classList.remove('shop-catalog-desktop__item-text--active');
        });
    }
    
    function thirdBlocksClear() {
        let thirdSect = document.querySelectorAll('.shop-catalog-desktop__item--third');
        thirdSect.forEach(item => {
            let thirdTextBlock = item.querySelector('.shop-catalog-desktop__item-text');
            thirdTextBlock.classList.remove('shop-catalog-desktop__item-text--active');
        });
    }
    
    function fourthBlocksClear() {
        let fourthSect = document.querySelectorAll('.shop-catalog-desktop__item--fourth');
        fourthSect.forEach(item => {
            let fourthTextBlock = item.querySelector('.shop-catalog-desktop__item-text');
            fourthTextBlock.classList.remove('shop-catalog-desktop__item-text--active');
        });
    }
    
    //mobile functions
    function shopCatalogMechMobile(){
        let modelsMobile = document.querySelectorAll('.shop-catalog-mobile-item');
    
        let secondSectionsMobile = document.querySelectorAll('.shop-catalog-mobile__inner--second');
        let secondSectionItemsMobile = document.querySelectorAll('.shop-catalog-mobile-item--second');
    
        let thirdSectionsMobile = document.querySelectorAll('.shop-catalog-mobile__inner--third');
        let thirdSectionItemsMobile = document.querySelectorAll('.shop-catalog-mobile-item--third');
    
        let fourthSectionsMobile = document.querySelectorAll('.shop-catalog-mobile__inner--fourth');
        let fourthSectionItemsMobile = document.querySelectorAll('.shop-catalog-mobile-item--fourth');
    
        scrollUpToTop();
    
        // click on each model mobile 1lvl
        for (let i = 0; i < modelsMobile.length; i++) {
            modelsMobile[i].addEventListener('click', function (e) {
                e.preventDefault();  
                fourthBlokcsMobileClear();
                thirdBlokcsMobileClear();        
                secondBlocksMobileClear();
                modelsMobileClear();
                clearLastOfferData();
                //clear opened second sections
                secondSectionsMobile.forEach(item => {
                    item.style.display = 'none';
                })
                //clear opened third sections
                thirdSectionsMobile.forEach(item => {
                    item.style.display = 'none';
                })
                //clear opened fourth sections
                fourthSectionsMobile.forEach(item => {
                    item.style.display = 'none';
                })
    
                let modelMobile = this.querySelector('a');
                let modelMobileText = this.querySelector('.shop-catalog-mobile-item__text');
                modelMobileText.classList.add('shop-catalog-mobile-item__text--active');
    
                function innerBlocksActivesClear1StageMobile(){
                    secondSectionsMobile.forEach(item => {
                        item.classList.remove('shop-catalog-mobile__inner--second-active');
                    });
                    thirdSectionsMobile.forEach(item => {
                        item.classList.remove('shop-catalog-mobile__inner--third-active');
                    });
        
                    fourthSectionsMobile.forEach(item => {
                        item.classList.remove('shop-catalog-mobile__inner--fourth-active');
                    });
                }
                innerBlocksActivesClear1StageMobile();
    
                secondSectionsMobile.forEach(item => {
                    if(item.dataset.code == modelMobile.dataset.code) {
                        let currentSecondSectionMobile = item;
                        currentSecondSectionMobile.style.display = 'block';
                        currentSecondSectionMobile.classList.add('shop-catalog-mobile__inner--second-active');
                        currentSecondSectionMobile.scrollIntoView({behavior: "smooth"});
                    }
                })
            })
        }
    
        // click on each item in 2lvl
        for (let i = 0; i < secondSectionItemsMobile.length; i++){
            secondSectionItemsMobile[i].addEventListener('click', function(e){
                e.preventDefault();
                //clear opened third sections
                thirdSectionsMobile.forEach(item => {
                    item.style.display = 'none';
                })
                //clear opened fourth sections
                fourthSectionsMobile.forEach(item => {
                    item.style.display = 'none';
                })
    
                fourthBlokcsMobileClear();
                thirdBlokcsMobileClear();
                secondBlocksMobileClear();
                clearLastOfferData();
    
                let currentSecondItemMobile = this.querySelector('a');
                let currentSecondItemMobileText = this.querySelector('.shop-catalog-mobile-item__text');
                currentSecondItemMobileText.classList.add('shop-catalog-mobile-item__text--active');
    
                function innerBlocksActivesClear2StageMobile(){  
                    thirdSectionsMobile.forEach(item => {
                        item.classList.remove('shop-catalog-mobile__inner--third-active');
                    });
                    fourthSectionsMobile.forEach(item => {
                        item.classList.remove('shop-catalog-mobile__inner--fourth-active');
                    });
                }
                innerBlocksActivesClear2StageMobile();
    
                thirdSectionsMobile.forEach(item => {
                    if(item.dataset.code == currentSecondItemMobile.dataset.code){
                        let currentThirdSectionMobile = item;
                        currentThirdSectionMobile.style.display = 'block';
                        currentThirdSectionMobile.classList.add('shop-catalog-mobile__inner--third-active');
                        currentThirdSectionMobile.scrollIntoView({behavior: "smooth"});
                    }
                })
            })
        }
    
        // click on each item in 3lvl
        for (let i = 0; i < thirdSectionItemsMobile.length; i++){
            thirdSectionItemsMobile[i].addEventListener('click', function(e){
                e.preventDefault();
                //clear opened fourth sections
                fourthSectionsMobile.forEach(item => {
                    item.style.display = 'none';
                })
    
                fourthBlokcsMobileClear();
                thirdBlokcsMobileClear();
                clearLastOfferData();
    
                let currentThirdItemMobile = this.querySelector('a');
                let currentThirdItemMobileText = this.querySelector('.shop-catalog-mobile-item__text');
                currentThirdItemMobileText.classList.add('shop-catalog-mobile-item__text--active');
    
                function innerBlocksActivesClear3StageMobile(){  
                    fourthSectionsMobile.forEach(item => {
                        item.classList.remove('shop-catalog-mobile__inner--fourth-active');
                    });
                }
                innerBlocksActivesClear3StageMobile();
    
                fourthSectionsMobile.forEach(item => {
                    if(item.dataset.code == currentThirdItemMobile.dataset.code){
                        let currentFourthSectionMobile = item;
                        currentFourthSectionMobile.style.display = 'block';
                        currentFourthSectionMobile.classList.add('shop-catalog-mobile__inner--fourth-active');
                        currentFourthSectionMobile.scrollIntoView({behavior: "smooth"});
                    }
                })
            })
        }
    
        // click on each item in 4lvl
        for (let i = 0; i < fourthSectionItemsMobile.length; i++){
            fourthSectionItemsMobile[i].addEventListener('click', function(e){
                e.preventDefault();
                fourthBlokcsMobileClear();
                clearLastOfferData();
    
                let currentFourthItemMobile = this.querySelector('a');
                let currentFourthItemMobileText = this.querySelector('.shop-catalog-mobile-item__text');
                currentFourthItemMobileText.classList.add('shop-catalog-mobile-item__text--active');
            })
        }
    }
    
    //meta for mobile
    function shopCatalogMobileMetaCloser(){
        let firstSection = document.querySelector('.shop-catalog-mobile__inner');
        const innerSecondActive = document.querySelector('.shop-catalog-mobile__inner--second-active');   
        const innerThirdActive = document.querySelector('.shop-catalog-mobile__inner--third-active'); 
        const finalItemActive = document.querySelector('.final-item-mobile--active');
    
        if(innerThirdActive === null){
    
        }else{
            const innerFirstActiveTitle = firstSection.querySelector('.shop-catalog-mobile__title');
            const innerSecondActiveTitle = innerSecondActive.querySelector('.shop-catalog-mobile__title');
            const innerThirdActiveTitle = innerThirdActive.querySelector('.shop-catalog-mobile__title');
            //Create first title meta
            let firstMetaItem = document.createElement('div');
            firstMetaItem.classList.add('shop-catalog-mobile__meta-item');
            firstMetaItem.innerText = innerFirstActiveTitle.innerText;
            //Create second title meta
            let secondMetaItem = document.createElement('div');
            secondMetaItem.classList.add('shop-catalog-mobile__meta-item');
            secondMetaItem.innerText = innerSecondActiveTitle.innerText;
            //Create third title meta
            let thirdMetaItem = document.createElement('div');
            thirdMetaItem.classList.add('shop-catalog-mobile__meta-item');
            thirdMetaItem.innerText = innerThirdActiveTitle.innerText;
            //Clone finalItem mobile
            const finalItemParent = finalItemActive.parentElement;
            const finalItemActiveMeta = finalItemParent.cloneNode(true);
            finalItemActiveMeta.classList.add('final-item--active-meta');
            finalItemActiveMeta.style.pointerEvents = 'none';
            finalItemActiveMeta.style.display = 'block';
            //generate and past meta block
            let metaInnerMobile = document.createElement('div');
            metaInnerMobile.classList.add('shop-catalog-mobile__meta-inner');
            firstSection.before(metaInnerMobile);
    
            metaInnerMobile.append(firstMetaItem);
            metaInnerMobile.append(secondMetaItem);
            metaInnerMobile.append(thirdMetaItem);
            metaInnerMobile.append(finalItemActiveMeta);
            
            firstSection.style.display = 'none';
            innerSecondActive.style.display = 'none';
            innerThirdActive.style.display = 'none';
    
            firstMetaItem.addEventListener('click', function(){
                firstSection.style.display = 'block';
                clearLastOfferData();
                
                function scrollToFirstTitleMobile(){
                    const y = firstSection.getBoundingClientRect().top + window.pageYOffset;
                    window.scrollTo({top: y, behavior: 'smooth'});
                }
                setTimeout(scrollToFirstTitleMobile, 100);
    
                ShopCatalogMobileMetaHide();
                finalItemActiveClearMobile();
            });
    
            secondMetaItem.addEventListener('click', function(){
                firstSection.style.display = 'block';
                innerSecondActive.style.display = 'block';
                clearLastOfferData();
    
                function scrollToSecondTitleMobile(){
                    const y = innerSecondActive.getBoundingClientRect().top + window.pageYOffset;
                    window.scrollTo({top: y, behavior: 'smooth'});
                }
                setTimeout(scrollToSecondTitleMobile, 100);
    
                ShopCatalogMobileMetaHide();
                finalItemActiveClearMobile();
            });
    
            thirdMetaItem.addEventListener('click', function(){
                firstSection.style.display = 'block';
                innerSecondActive.style.display = 'block';
                innerThirdActive.style.display = 'block';
                clearLastOfferData();
    
                function scrollToThirdTitleMobile(){
                    const y = innerThirdActive.getBoundingClientRect().top + window.pageYOffset;
                    window.scrollTo({top: y, behavior: 'smooth'});
                }
                setTimeout(scrollToThirdTitleMobile, 100);
    
                ShopCatalogMobileMetaHide();
                finalItemActiveClearMobile();
            });
        }
    }
    
    //clear final-item on mobile
    function finalItemActiveClearMobile(){
        const finalItemsActiveMobile = document.querySelectorAll('.final-item-mobile--active');
    
        if(finalItemsActiveMobile === null){
    
        }else{
            finalItemsActiveMobile.forEach(item =>{
                item.classList.remove('final-item-mobile--active');
            });
        }
    }
    
    //hide Inner Meta block on nMobile
    function ShopCatalogMobileMetaHide(){
        let innerMetaBlockMobile = document.querySelector('.shop-catalog-mobile__meta-inner');
    
        if(innerMetaBlockMobile === null){
    
        }else{
            innerMetaBlockMobile.remove();
        }
    }
    
    //Final item fetching from server | Mobile
    function shopCatalogFetchMobile() {
        let finalItemsMobile = document.querySelectorAll('.final-item-mobile');
        let offersContainer = document.querySelector('.offersContainer');
        let preloaderContainer = document.querySelector('.preloader-container');
    
        for (let i = 0; i < finalItemsMobile.length; i++) {
            finalItemsMobile[i].addEventListener('click', function(e){
                e.preventDefault(); 
                clearLastOfferData();
    
                const finalItemMobile = this;
                const finalItemMobileCode = finalItemMobile.dataset.code;
                finalItemMobile.classList.add('final-item-mobile--active');
                const finalItemUrlMobile = finalItemMobile.getAttribute("href");
                let requestUrlMobile = `/catalog/offers/${finalItemMobileCode}`;
                // console.log(requestUrl);
                preloaderContainer.style.display = 'flex';
                preloaderContainer.scrollIntoView({behavior: "smooth"});
                shopCatalogMobileMetaCloser();
                function fetchingOffersMobile() {
                    
                    const xhr = new XMLHttpRequest();
    
                    xhr.open("POST", requestUrlMobile, true);
    
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    // const offerContainer = document.querySelector('.offersContainer');
    
                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
    
                            const response = xhr.response;
                            let responseHtml = document.createElement("div");
                            responseHtml.innerHTML = response;
                            offersContainer.appendChild(responseHtml);
                            shopCatalogMechDesktop();
                            shopCatalogMechMobile();
    
                            hideFirstSeparatorOnMobile();
                            hideFirstSeparatorOnDesktop();
    
                            offerCardMobileOpen();                                   
                            offerCardMobileInfoOpen();
                            
                            offerCardDesktopOpen();
                            offerCardDesktopInfoOpen();
    
                            offerCardMobileBuyButtonMech();
                            offerCardDesktopBuyButtonMech();
    
                            offerCardMobileFastBuy();
                            offerCardDesktopFastBuy();
    
                            desktopCardMoreBtn();
    
                            offersCardDesktopFavoriteBtnAdd();
                            offersCardDesktopFavoriteBtnRemove();
    
                            offerCardFavoriteBtnMobileAdd();
                            offerCardFavoriteBtnMobileRemove();
    
                            
                            offersCatalogSortByPriceMechDesktop();
                            offersCatalogSortByPriceMechMobile();
    
                            shopCatalogPager();
                            generateNextOfferBtn();
                            
                            preloaderContainer.style.display = 'none';
                            offersContainer.style.display = 'block';
                            offersContainer.scrollIntoView({behavior: "auto"});
                        }
                    } 
                    xhr.send(finalItemUrlMobile);
                }
    
                setTimeout(fetchingOffersMobile, 1000);
    
            })
        }
    }
    
    //text-block clear functions
    function modelsMobileClear() {
        let firstSectionMobile = document.querySelector('.shop-catalog-mobile__inner');
        let firstSectionMobileItems = firstSectionMobile.querySelectorAll('.shop-catalog-mobile-item');
    
        firstSectionMobileItems.forEach(item => {
            let modelTextBlock = item.querySelector('.shop-catalog-mobile-item__text');
            modelTextBlock.classList.remove('shop-catalog-mobile-item__text--active');
        })
    }
    
    function secondBlocksMobileClear() {
        let secondSectionsMobileItems = document.querySelectorAll('.shop-catalog-mobile-item--second');
        
        secondSectionsMobileItems.forEach(item => {
            let secTextBlockMobile = item.querySelector('.shop-catalog-mobile-item__text');
            secTextBlockMobile.classList.remove('shop-catalog-mobile-item__text--active');
        })
    }
    
    function thirdBlokcsMobileClear() {
        let thirdSectionsMobileItems = document.querySelectorAll('.shop-catalog-mobile-item--third');
    
        thirdSectionsMobileItems.forEach(item => {
            let thirdTextBlockMobile = item.querySelector('.shop-catalog-mobile-item__text');
            thirdTextBlockMobile.classList.remove('shop-catalog-mobile-item__text--active');
        })
    }
    
    function fourthBlokcsMobileClear() {
        let fourthSectionsMobileItems = document.querySelectorAll('.shop-catalog-mobile-item--fourth');
    
        fourthSectionsMobileItems.forEach(item => {
            let fourthTextBlockMobile = item.querySelector('.shop-catalog-mobile-item__text');
            fourthTextBlockMobile.classList.remove('shop-catalog-mobile-item__text--active');
        })
    }
    
    //Scroll to up locate in shopCatalogMechMobile function HIDE Sinse 12.4.2021
    function scrollUpToTop(){
        let scrollUpTotopBlock = document.querySelector('.scroll-up');
    
        if(scrollUpTotopBlock === null){
    
        }else{
            scrollUpTotopBlock.style.display = 'none';
        }
    }
    
    //change url
    function changeUrlShopCatalog() {
        let finalItem = document.querySelectorAll('.final-item');
    
        for(let i = 0; i < finalItem.length; i++){
            finalItem[i].addEventListener('click', function(e){
                e.preventDefault();
                let thisFinalItemHref = this.getAttribute("href");
                
                history.pushState("state", "title", thisFinalItemHref);
            })
        }
    }
    
    function shopCatalogSwitcher(){
        // shop-catalog desktop mechanics
        let shopCatalogSect = document.querySelector('.shop-catalog-desktop');
    
        if(shopCatalogSect === null){
            //   console.log("shop catalog just left html");
            }else {
    
                shopCatalogMechDesktop();
                shopCatalogFetchDesktop();
                shopCatalogMechMobile();
                shopCatalogFetchMobile();
                changeUrlShopCatalog();
            
                let footer = document.querySelector('.footer');
                footer.style.marginTop = "250px";
            }
    }
    
    shopCatalogSwitcher();
    
    function tagLinkModelNoOffersAdaptive(){
        let shopCatalogItems = document.querySelectorAll('.shop-catalog-desktop__item');
        let shopCatalogItemsSecond = document.querySelectorAll('.shop-catalog-desktop__item--second');
        let shopCatalogItemsThird = document.querySelectorAll('.shop-catalog-desktop__item--third');
    
        if(shopCatalogItems === null){
    
        } else{
            for(let i = 0; i < shopCatalogItems.length; i++){
                let noOffersBlock = shopCatalogItems[i].querySelector('.shop-catalog-desktop__tag-link--model-no-offers');
                if(noOffersBlock === null) {
    
                }else{
                    let itemRect = shopCatalogItems[i].getBoundingClientRect();
                    let itemHeight = itemRect.height;
                    console.log(noOffersBlock);
                    console.log(itemHeight);
        
                    noOffersBlock.style.minHeight = itemHeight + 'px';
                }
                
            }
    
            for(let i = 0; i < shopCatalogItemsSecond.length; i++){
                let noOffersBlock = shopCatalogItemsSecond[i].querySelector('.shop-catalog-desktop__tag-link--model-no-offers');
                if(noOffersBlock === null) {
    
                }else{
                    let itemRect = shopCatalogItemsSecond[i].getBoundingClientRect();
                    let itemHeight = itemRect.height;
                    console.log(noOffersBlock);
                    console.log(itemHeight);
        
                    noOffersBlock.style.minHeight = itemHeight + 'px';
                }
                
            }
        } 
    }
    
    //tag-link--model-no-offers replacement link mech in First row (lvl) in catalog
    function tagLinkNoOffersLinkReplacementFirst() {
        let catalogItemsFirstRow = document.querySelectorAll('.shop-catalog-desktop__item');
    
        if(catalogItemsFirstRow === null){
    
        }else{
            for(let i = 0; i < catalogItemsFirstRow.length; i++){
                let tagLinkNoOffersBlockLinkBtn = catalogItemsFirstRow[i].querySelector('.shop-catalog-desktop__tag-link-btn');
                let catalogItemsFirstRowLink = catalogItemsFirstRow[i].querySelector('a');
                if(tagLinkNoOffersBlockLinkBtn === null){
                    // console.log('NOT TAG LINK BLOCKS');
                }else{
                    let tagLinkBtnDataLink = tagLinkNoOffersBlockLinkBtn.dataset.link;
                    // console.log(tagLinkBtnDataLink);
                    // console.log(catalogItemsSecondRowLink);
                    delete catalogItemsFirstRowLink.dataset.code;
                    catalogItemsFirstRowLink.href =  `http://final.lr.ru${tagLinkBtnDataLink}`;
                    catalogItemsFirstRowLink.addEventListener('click', function(e){
                        e.preventDefault();
                        window.location = this.href;
                    })
                }
            }
        }
    }
    
    //tag-link--model-no-offers replacement link mech in Second row (lvl) in catalog
    function tagLinkNoOffersLinkReplacementSecond() {
        let catalogItemsSecondRow = document.querySelectorAll('.shop-catalog-desktop__item--second');
    
        if(catalogItemsSecondRow === null){
    
        }else{
            for(let i = 0; i < catalogItemsSecondRow.length; i++){
                let tagLinkNoOffersBlockLinkBtn = catalogItemsSecondRow[i].querySelector('.shop-catalog-desktop__tag-link-btn');
                let catalogItemsSecondRowLink = catalogItemsSecondRow[i].querySelector('a');
                if(tagLinkNoOffersBlockLinkBtn === null){
                    // console.log('NOT TAG LINK BLOCKS');
                }else{
                    let tagLinkBtnDataLink = tagLinkNoOffersBlockLinkBtn.dataset.link;
                    // console.log(tagLinkBtnDataLink);
                    // console.log(catalogItemsSecondRowLink);
                    delete catalogItemsSecondRowLink.dataset.code;
                    catalogItemsSecondRowLink.href =  `http://final.lr.ru${tagLinkBtnDataLink}`;
                    catalogItemsSecondRowLink.addEventListener('click', function(e){
                        e.preventDefault();
                        window.location = this.href;
                    })
                }
            }
        }
    }
    //tag-link--model-no-offers replacement link mech in Third row (lvl) in catalog
    function tagLinkNoOffersLinkReplacementThird() {
        let catalogItemsThirdRow = document.querySelectorAll('.shop-catalog-desktop__item--third');
    
        if(catalogItemsThirdRow === null){
    
        }else{
            for(let i = 0; i < catalogItemsThirdRow.length; i++){
                let tagLinkNoOffersBlockLinkBtn = catalogItemsThirdRow[i].querySelector('.shop-catalog-desktop__tag-link-btn');
                let catalogItemsThirdRowLink = catalogItemsThirdRow[i].querySelector('a');
                if(tagLinkNoOffersBlockLinkBtn === null){
                    // console.log('NOT TAG LINK BLOCKS');
                }else{
                    let tagLinkBtnDataLink = tagLinkNoOffersBlockLinkBtn.dataset.link;
                    // console.log(tagLinkBtnDataLink);
                    // console.log(catalogItemsSecondRowLink);
                    delete catalogItemsThirdRowLink.dataset.code;
                    catalogItemsThirdRowLink.href =  `http://final.lr.ru${tagLinkBtnDataLink}`;
                    catalogItemsThirdRowLink.addEventListener('click', function(e){
                        e.preventDefault();
                        window.location = this.href;
                    })
                }
            }
        }
    }
    //tag-link--model-no-offers replacement link mech in Fourth row (lvl) in catalog
    function tagLinkNoOffersLinkReplacementFourth() {
        let catalogItemsThourthRow = document.querySelectorAll('.shop-catalog-desktop__item--fourth');
    
        if(catalogItemsThourthRow === null){
            
        }else{
            for(let i = 0; i < catalogItemsThourthRow.length; i++){
                let tagLinkNoOffersBlockLinkBtn = catalogItemsThourthRow[i].querySelector('.shop-catalog-desktop__tag-link-btn');
                let catalogItemsThourthRowLink = catalogItemsThourthRow[i].querySelector('a');
                if(tagLinkNoOffersBlockLinkBtn === null){
                    // console.log('NOT TAG LINK BLOCKS');
                }else{
                    let tagLinkBtnDataLink = tagLinkNoOffersBlockLinkBtn.dataset.link;
                    // console.log(tagLinkBtnDataLink);
                    // console.log(catalogItemsSecondRowLink);
                    delete catalogItemsThourthRowLink.dataset.code;
                    catalogItemsThourthRowLink.href =  `http://final.lr.ru${tagLinkBtnDataLink}`;
                    catalogItemsThourthRowLink.addEventListener('click', function(e){
                        e.preventDefault();
                        window.location = this.href;
                    })
                }
            }
        }
    }
    
    tagLinkNoOffersLinkReplacementFirst();
    tagLinkNoOffersLinkReplacementSecond();
    tagLinkNoOffersLinkReplacementThird();
    tagLinkNoOffersLinkReplacementFourth();
    
    //tag-link--backward link replacement link mech in First row (lvl) in catalog
    function tagLinkBackwardLinkReplacementFirst() {
        let catalogItemsFirstRow = document.querySelectorAll('.shop-catalog-desktop__item');
    
        if(catalogItemsFirstRow === null){
    
        }else{
            for(let i = 0; i < catalogItemsFirstRow.length; i++){
                let tagLinkBackwardBlock = catalogItemsFirstRow[i].querySelector('.shop-catalog-desktop__tag-link--backward');
                let catalogItemsFirstRowLink = catalogItemsFirstRow[i].querySelector('a');
                if(tagLinkBackwardBlock === null){
                    // console.log('NOT TAG LINK BLOCKS');
                }else{
                    let tagLinkBtnDataLink = tagLinkBackwardBlock.dataset.link;
                    // console.log(tagLinkBtnDataLink);
                    // console.log(catalogItemsSecondRowLink);
                    delete catalogItemsFirstRowLink.dataset.code;
                    catalogItemsFirstRowLink.href =  `http://final.lr.ru${tagLinkBtnDataLink}`;
                    catalogItemsFirstRowLink.addEventListener('click', function(e){
                        e.preventDefault();
                        window.location = this.href;
                    })
                }
            }
        }
    }
    
    //tag-link--backward link replacement link mech in Second row (lvl) in catalog
    function tagLinkBackwardLinkReplacementSecond() {
        let catalogItemsSecondRow = document.querySelectorAll('.shop-catalog-desktop__item--second');
    
        if(catalogItemsSecondRow === null){
    
        }else{
            for(let i = 0; i < catalogItemsSecondRow.length; i++){
                let tagLinkBackwardBlock = catalogItemsSecondRow[i].querySelector('.shop-catalog-desktop__tag-link--backward');
                let catalogItemsSecondRowLink = catalogItemsSecondRow[i].querySelector('a');
                if(tagLinkBackwardBlock === null){
                    // console.log('NOT TAG LINK BLOCKS');
                }else{
                    let tagLinkBtnDataLink = tagLinkBackwardBlock.dataset.link;
                    // console.log(tagLinkBtnDataLink);
                    // console.log(catalogItemsSecondRowLink);
                    delete catalogItemsSecondRowLink.dataset.code;
                    catalogItemsSecondRowLink.href =  `http://final.lr.ru${tagLinkBtnDataLink}`;
                    catalogItemsSecondRowLink.addEventListener('click', function(e){
                        e.preventDefault();
                        window.location = this.href;
                    })
                }
            }
        }
    }
    
    //tag-link--backward link replacement link mech in Third row (lvl) in catalog
    function tagLinkBackwardLinkReplacementThird() {
        let catalogItemsThirdRow = document.querySelectorAll('.shop-catalog-desktop__item--third');
    
        if(catalogItemsThirdRow === null){
    
        }else{
            for(let i = 0; i < catalogItemsThirdRow.length; i++){
                let tagLinkBackwardBlock = catalogItemsThirdRow[i].querySelector('.shop-catalog-desktop__tag-link--backward');
                let catalogItemsThirdRowLink = catalogItemsThirdRow[i].querySelector('a');
                if(tagLinkBackwardBlock === null){
                    // console.log('NOT TAG LINK BLOCKS');
                }else{
                    let tagLinkBtnDataLink = tagLinkBackwardBlock.dataset.link;
                    // console.log(tagLinkBtnDataLink);
                    // console.log(catalogItemsSecondRowLink);
                    delete catalogItemsThirdRowLink.dataset.code;
                    catalogItemsThirdRowLink.href =  `http://final.lr.ru${tagLinkBtnDataLink}`;
                    catalogItemsThirdRowLink.addEventListener('click', function(e){
                        e.preventDefault();
                        window.location = this.href;
                    })
                }
            }
        }
    }
    
    //tag-link--backward link replacement link mech in Fourth row (lvl) in catalog
    function tagLinkBackwardLinkReplacementFourth() {
        let catalogItemsFourthRow = document.querySelectorAll('.shop-catalog-desktop__item--fourth');
    
        if(catalogItemsFourthRow === null){
    
        }else{
            for(let i = 0; i < catalogItemsFourthRow.length; i++){
                let tagLinkBackwardBlock = catalogItemsFourthRow[i].querySelector('.shop-catalog-desktop__tag-link--backward');
                let catalogItemsFourthRowLink = catalogItemsFourthRow[i].querySelector('a');
                if(tagLinkBackwardBlock === null){
                    // console.log('NOT TAG LINK BLOCKS');
                }else{
                    let tagLinkBtnDataLink = tagLinkBackwardBlock.dataset.link;
                    // console.log(tagLinkBtnDataLink);
                    // console.log(catalogItemsSecondRowLink);
                    delete catalogItemsFourthRowLink.dataset.code;
                    catalogItemsFourthRowLink.href =  `http://final.lr.ru${tagLinkBtnDataLink}`;
                    catalogItemsFourthRowLink.addEventListener('click', function(e){
                        e.preventDefault();
                        window.location = this.href;
                    })
                }
            }
        }
    }
    
    tagLinkBackwardLinkReplacementFirst();
    tagLinkBackwardLinkReplacementSecond();
    tagLinkBackwardLinkReplacementThird();
    tagLinkBackwardLinkReplacementFourth();
    function singleOfferSlider(){
        let slides = document.querySelectorAll('.activeSlide__slider-item');
        let prevBtn = document.querySelector('.activeSlide__prev-slide');
        let nextBtn = document.querySelector('.activeSlide__next-slide');
    
        let thumbnailsContainer = document.querySelector('.vendor-slider__thumbnails-inner');
        let activeThumbnail = document.querySelector('.activeSlide__active-thumbnail');
        let slidesMassiveArray = slides.length;
    
        if (slides === null || prevBtn === null || nextBtn === null || activeThumbnail === null) {
            // console.log('singleOfferSlider just left HTML');
        } else {
            if(slidesMassiveArray == 1){
                console.warn('only 1 slide');
            }else{
                let slideIndex = 1;
                showSlides(slideIndex);
        
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
                    let slideThumbnailImg = slideThubmnail.querySelector('img');
                    if(slideThumbnailImg === null){
        
                    }else{
                        slideThumbnailImg.style.objectFit = 'contain';
                        slideThumbnailImg.style.width = '100%';
                        slideThumbnailImg.style.height = '100%';
                    }
                });
    
                
                hideArrows();
            }
            
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
                    let activeThumbImg = activeThumb.querySelector('img');
                    let activeThumbImgHeight = activeThumbImg.naturalHeight;
                    let activeThumbImgWidth = activeThumbImg.naturalWidth;
                    console.warn('activeThumbImgWidth');
                    console.warn(activeThumbImgWidth);
                    if(activeThumbImgWidth < 450){
                        activeThumbnail.style.display ='flex';
                        activeThumbnail.innerHTML = activeThumb.innerHTML;
                        let activeThumbnailImg = activeThumbnail.querySelector('img');
                        activeThumbnailImg.style.objectFit = 'none';
                        activeThumbnailImg.style.width = 'auto';
                        activeThumbnailImg.style.height = 'auto';
                    }else{
                        activeThumbnail.style.display ='flex';
                        activeThumbnail.innerHTML = activeThumb.innerHTML;
                        let activeThumbnailImg = activeThumbnail.querySelector('img');
                    }
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
            // console.warn('BAM!!');
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
            // console.warn('BAM!!');
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
    function catalogDevSubnavOpen(){
        let btnsList = document.querySelectorAll('.catalogDepOpenSubnav');
        let catDepNavListParent = document.querySelector('.catalog__departament-navigation-list');
        let catDepSection = document.querySelector('.catalog__departament');
    
        if(btnsList === null || catDepNavListParent === null || catDepSection === null){
            
        }else {
            
            let intViewportWidth = window.innerWidth;
            if(intViewportWidth < 1140){
                // console.warn("mobile dep");
    
                for(i = 0; i < btnsList.length; i++){
                    btnsList[i].addEventListener('click', function clickOnBtn(){
    
    
                        if(this.classList.contains('catalogDepOpenSubnav--active')){
                            navigationButtonRefresh();
                            subNavMenuRefresh();
    
                            this.classList.remove('catalogDepOpenSubnav--active');
    
                        }else{
                            navigationButtonRefresh();
                            subNavMenuRefresh();
                        
                            let listOfCurrentBtn = this.querySelector('.catalog__departament-subnavigation-list');
                            this.classList.add('catalogDepOpenSubnav--active');
                            let rectOfCurrentBtn = this.getBoundingClientRect();
    
    
                            let departamentTrickBlock = document.createElement('div');
                            catDepSection.after(departamentTrickBlock);
                            departamentTrickBlock.classList.add('catalog__departament-trick');
                            departamentTrickBlock.style.top = Math.round(rectOfCurrentBtn.top) + 33 + 'px';
                            departamentTrickBlock.style.left = Math.round(rectOfCurrentBtn.left) + 'px';
                            let trickBlockRect = departamentTrickBlock.getBoundingClientRect();
    
                            departamentTrickBlock.innerHTML = listOfCurrentBtn.outerHTML;
                            let tricklist = departamentTrickBlock.querySelector('.catalog__departament-subnavigation-list')
                            tricklist.classList.add('catalog__departament-subnavigation-list--active-mobile');
                            tricklist.style.minWidth = this.offsetWidth + 'px';
                            tricklist.style.width = 'max-content';
    
                        }
        
                    });
    
                }
    
                catDepNavListParent.addEventListener('scroll', function(){
                    navigationButtonRefresh();
                    subNavMenuRefresh();
                });
    
                window.addEventListener('scroll', function(){
                    navigationButtonRefresh();
                    subNavMenuRefresh();
                });
    
               
            } else{
                // console.warn("desktop dep");
    
                for(i = 0; i < btnsList.length; i++){
    
                    btnsList[i].addEventListener('click', function(e){
    
                        if(this.classList.contains('catalogDepOpenSubnav--active')){
    
                            let listOfCurrentBtn = this.querySelector('.catalog__departament-subnavigation-list');
                            this.classList.remove('catalogDepOpenSubnav--active');
                            listOfCurrentBtn.classList.remove('catalog__departament-subnavigation-list--active');
    
                        }else{
    
                            subNavMenuRefreshDesktop();
                            navigationButtonRefresh();
    
                            let listOfCurrentBtn = this.querySelector('.catalog__departament-subnavigation-list');
                            this.classList.add('catalogDepOpenSubnav--active');
                            listOfCurrentBtn.classList.add('catalog__departament-subnavigation-list--active');
                            catDepNavListParent.style.overflowX = 'visible';  
    
                            window.addEventListener('scroll', function(){
                                subNavMenuRefreshDesktop();
                                navigationButtonRefresh();
                            });
    
                            document.onclick = function(e){
                                if(e.target.classList.contains("catalog__departament-navigation-item")){
                                    // console.warn('click inside');
                                } else {
                                    // console.warn('click outside');
                                    subNavMenuRefreshDesktop();
                                    navigationButtonRefresh();
                                }
                            }
    
                        }
    
    
                    });
                }
            }
        }
    }
    
    catalogDevSubnavOpen();
    
    function catalogDevSubnavClose(){
        let btnsList = document.querySelectorAll('.catalogDepOpenSubnav');
        let catDepNavListParent = document.querySelector('.catalog__departament-navigation-list');
        let catDepSection = document.querySelector('.catalog__departament');
    }
    
    function navigationButtonRefresh(){
        let NavBtns = document.querySelectorAll('.catalogDepOpenSubnav--active');
    
        NavBtns.forEach(item => {
            item.classList.remove('catalogDepOpenSubnav--active');
            // console.log(item);
        })
    }
    
    function subNavMenuRefresh(){
        let subNavMenuList = document.querySelectorAll('.catalog__departament-subnavigation-list--active-mobile');
    
        subNavMenuList.forEach(item => {
            item.classList.remove('catalog__departament-subnavigation-list--active-mobile')
            
        })
    }
    
    function subNavMenuRefreshDesktop(){
        let subNavMenuList = document.querySelectorAll('.catalog__departament-subnavigation-list--active');
    
        subNavMenuList.forEach(item => {
            item.classList.remove('catalog__departament-subnavigation-list--active')
            
        })
    }
    //Main model auto mech
    
    function modelAutoMech(){
        let autoBrandItems = document.querySelectorAll('.model-auto__brand-item');
    
        let autoModelBlocks = document.querySelectorAll('.model-auto__model');
        let automodelItems = document.querySelectorAll('.model-auto__model-item');
    
        let autoGenerationBlock = document.querySelectorAll('.model-auto__generation');
        let autoGenerationItem = document.querySelectorAll('.model-auto__generation-item');
    
        if (autoBrandItems === null){
            // console.log('this block out of the current html page');
        } else{
    
            for(let i = 0; i < autoBrandItems.length; i++){
                autoBrandItems[i].addEventListener('click', function(){
                    hideChosenBrandItem();
                    hideOpenedAutoModelBlocks();
                    hideChosenAutoModelItem();
                    hideChosenGenerationBlock();
    
    
                    let currentAutoBrand = this;
                    currentAutoBrand.classList.add('model-auto__brand-item--active');
    
                    autoModelBlocks.forEach(item => {
                        if(item.dataset.code == currentAutoBrand.dataset.code){
                            let currentAutoModelBlock = item;
                            currentAutoModelBlock.style.display = 'block';
                        }
                    });
                });
            }
    
            for(let i = 0; i < automodelItems.length; i++){
                automodelItems[i].addEventListener('click', function(){
                    hideChosenAutoModelItem();
                    hideChosenGenerationBlock();
    
    
                    let currentAutoModel = this;
                    currentAutoModel.classList.add('model-auto__model-item--active');
    
                    autoGenerationBlock.forEach(item => {
                        if(item.dataset.code === currentAutoModel.dataset.code){
                            let currentAutoGenerationBlock = item;
                            currentAutoGenerationBlock.style.display = 'block';
                        }
                    });
                });
            }
    
    
                    
            //hide items when u switch between cars and track
            function hideOnSwitchCarsVsTrucks(){
                let truckBtn = document.querySelector('label[for="model-tab-type-2"]');
    
                if(truckBtn === null){
    
                } else {
                    truckBtn.addEventListener('click', function(){
                        hideChosenBrandItem();
                        hideOpenedAutoModelBlocks();
                        hideChosenAutoModelItem();
                        hideChosenGenerationBlock();
                    });
                }
    
                
            }
    
            hideOnSwitchCarsVsTrucks();
    
            function hideOnSwitchTrucksVsCars(){
                let carBtn = document.querySelector('label[for="model-tab-type-1"]');
    
                if(carBtn === null){
    
                } else {
                    carBtn.addEventListener('click', function(){
                        hideChosenBrandItem();
                        hideOpenedAutoModelBlocks();
                        hideChosenAutoModelItem();
                        hideChosenGenerationBlock();
                    });
                }
                
            }
    
            hideOnSwitchTrucksVsCars();
    
        }
    }
    
    modelAutoMech();
    
    function hideChosenBrandItem(){
        let autoBrandItems = document.querySelectorAll('.model-auto__brand-item');
    
        autoBrandItems.forEach(item => {
            item.classList.remove('model-auto__brand-item--active');
        });
    }
    
    function hideOpenedAutoModelBlocks(){
        let autoModelBlocks = document.querySelectorAll('.model-auto__model');
    
        autoModelBlocks.forEach(item => {
            item.style.display = 'none';
        });
    }
    
    function hideChosenAutoModelItem(){
        let automodelItems = document.querySelectorAll('.model-auto__model-item');
    
        automodelItems.forEach(item =>{
            item.classList.remove('model-auto__model-item--active');
        });
    }
    
    function hideChosenGenerationBlock(){
        let autoGenerationBlock = document.querySelectorAll('.model-auto__generation');
    
        autoGenerationBlock.forEach(item => {
            item.style.display = 'none';
        });
    }
    
    
    
    //Generation text hover mech
    
    function generationItemTextHover(){
        let genItems = document.querySelectorAll('.model-auto__generation-item');
    
        if(genItems === null){
            // console.log('no generation on the page');
        } else{
            let intViewportWidth = window.innerWidth;
            if(intViewportWidth > 1140){
                // console.warn('desktop!');
                for(let i = 0; i < genItems.length; i++){
                    genItems[i].addEventListener('mouseover', function(){
                        let currentText = this.querySelector('.model-auto__generation-item-text');
                        currentText.classList.add('model-auto__generation-item-text--hover');
                    });
        
                    genItems[i].addEventListener('mouseout', function(){
                        let currentText = this.querySelector('.model-auto__generation-item-text');
                        currentText.classList.remove('model-auto__generation-item-text--hover');
                    });
                }
            } 
           
        }
    }
    
    generationItemTextHover();
    function breadCrumbsAutoScroll(){
        let listOfBreadItems = document.querySelectorAll('.breadcrumbs > li');
        let lastBreadItem = listOfBreadItems[listOfBreadItems.length - 1];
    
        if(listOfBreadItems === null && lastBreadItem === null) {
            
        } else{
            let intViewportWidth = window.innerWidth;
            if(intViewportWidth < 1140){
                        
                lastBreadItem.scrollIntoView({ block: 'end'});
            } else {
    
            }
        }
    }
    function stickyHeader(){
        let stickyHeader = document.createElement('section');
        let body = document.querySelector('body');
        let searchPanelFromDesktopHeader = document.querySelector('.search-panel__search');
    
        if(searchPanelFromDesktopHeader === null){
            // console.log('header--custom for cart ON');
                    
            stickyHeader.classList.add('sticky-header');
            stickyHeader.innerHTML = `
                                    <!-- sticky header mobile -->
                                    <ul class="sticky-header__mobile sticky-header-mobile">
                                
                                        <li class="sticky-header-mobile__item">
                                            <a href="http://final.lr.ru/" class="sticky-header-mobile__link stickyHeaderHomeParent">
                                
                                                <div class="sticky-header-mobile__link-icon-home sticky-header-mobile__link-icon-home--active"></div>
                                                <p class="sticky-header-mobile__link-text sticky-header-mobile__link-text--active">Главная</p>
                                
                                            </a>
                                        </li>
                                
                                        <li class="sticky-header-mobile__item">
                                            <a href="offers-catalog.html" class="sticky-header-mobile__link stickyHeaderCatalogParent">
                                
                                                <div class="sticky-header-mobile__link-icon-offers"></div>
                                                <p class="sticky-header-mobile__link-text">Каталог</p>
                                
                                            </a>
                                        </li>
                                
                                        <li class="sticky-header-mobile__item">
                                            <a href="/cart" class="sticky-header-mobile__link stickyHeaderCartParent">
                                
                                                <div class="sticky-header-mobile__link-icon-cart"></div>
                                                <p class="sticky-header-mobile__link-text">Корзина</p>
                                                <span style="display: block;">10</span>
                                                
                                            </a>
                                        </li>
                                
                                        <li class="sticky-header-mobile__item">
                                            <a href="/favorite" class="sticky-header-mobile__link stickyHeaderFavoriteParent">
                                
                                                <div class="sticky-header-mobile__link-icon-favorites"></div>
                                                <p class="sticky-header-mobile__link-text">Избранное</p>
                                                <span style="display: block;">2</span>
                                            </a>
                                        </li>
                                
                                        <li class="sticky-header-mobile__item">
                                            <a href="#" class="sticky-header-mobile__link">
                                
                                                <div class="sticky-header-mobile__link-icon-account"></div>
                                                <p class="sticky-header-mobile__link-text">Мой LR.RU</p>
                                                
                                            </a>
                                        </li>
                                
                                    </ul>
                                
                                    <!-- sticky header desktop cart -->
                                    <div class="sticky-header__desktop-cart sticky-header-desktop-cart">
                                    
                                            <!-- logo -->
                                            <a href="http://final.lr.ru/" class="sticky-header-desktop-cart__logo">
                                                <img src="/img/sticky-header/desktop/sticky-header-desktop-logo.svg" alt="">
                                            </a>
                                
                                            <!-- nav list -->
                                            <ul class="sticky-header-desktop-cart__nav-list header-cart-desktop__nav-list">
                                                <li class="sticky-header-desktop-cart__nav-item header-cart-desktop__nav-item header-cart-desktop__nav-item--current"><a href="#">корзина</a></li>
                                                <li class="sticky-header-desktop-cart__nav-item header-cart-desktop__nav-item"><a href="#">покупатель</a></li>
                                                <li class="sticky-header-desktop-cart__nav-item header-cart-desktop__nav-item"><a href="#">получение</a></li>
                                                <li class="sticky-header-desktop-cart__nav-item header-cart-desktop__nav-item"><a href="#">оплата</a></li>
                                                <li class="sticky-header-desktop-cart__nav-item header-cart-desktop__nav-item"><a href="#">отправить</a></li>
                                            </ul>
                                
                                            <!-- user  -->
                                            <div class="sticky-header-desktop-cart__user user">
                                
                                                <a href="/favorite" class="user__favorites">
                                                    <img src="/img/favorites-icon.svg" alt="">
                                                    <p>Избранное</p>
                                                    <span style="display: block;">2</span>
                                                </a>
                                
                                                <a href="/cart" class="user__shopping-cart">
                                                    <img src="/img/shopping-cart-icon.svg" alt="">
                                                    <p>Корзина</p>
                                                    <span style="display: block;">10</span>
                                                </a>
                                
                                                <a class="user__enter">
                                                    <img src="/img/enter-icon.svg" alt="">
                                                    <p>Вход</p>
                                                </a>
                                
                                            </div>
                                        
                                    </div>     
            `
    
            body.appendChild(stickyHeader);
            stickyHeader.style.opacity = '0';
            stickyHeader.style.visibility = 'hidden';
    
            window.addEventListener('scroll', function(e){
                let scrollPos  = window.scrollY;
                // console.log(scrollPos);
    
                if (scrollPos > 200) {
                    stickyHeader.style.opacity = '1';
                    stickyHeader.style.visibility = 'visible';
                } else if(scrollPos < 200){
                    stickyHeader.style.opacity = '0';
                    stickyHeader.style.visibility = 'hidden';
                }
            }); 
        }else{
            // console.log('default header variation');
            
            stickyHeader.classList.add('sticky-header');
            stickyHeader.innerHTML = `
                                    <!-- sticky header mobile -->
                                    <ul class="sticky-header__mobile sticky-header-mobile">
    
                                        <li class="sticky-header-mobile__item">
                                            <a href="http://final.lr.ru/" class="sticky-header-mobile__link stickyHeaderHomeParent" >
    
                                                <div class="sticky-header-mobile__link-icon-home"></div>
                                                <p class="sticky-header-mobile__link-text">Главная</p>
    
                                            </a>
                                        </li>
    
                                        <li class="sticky-header-mobile__item">
                                            <a href="offers-catalog.html" class="sticky-header-mobile__link stickyHeaderCatalogParent">
    
                                                <div class="sticky-header-mobile__link-icon-offers"></div>
                                                <p class="sticky-header-mobile__link-text">Каталог</p>
    
                                            </a>
                                        </li>
    
                                        <li class="sticky-header-mobile__item">
                                            <a href="/cart" class="sticky-header-mobile__link stickyHeaderCartParent">
    
                                                <div class="sticky-header-mobile__link-icon-cart"></div>
                                                <p class="sticky-header-mobile__link-text">Корзина</p>
                                                <span>0</span>
                                                
                                            </a>
                                        </li>
    
                                        <li class="sticky-header-mobile__item">
                                            <a href="/favorite" class="sticky-header-mobile__link stickyHeaderFavoriteParent">
    
                                                <div class="sticky-header-mobile__link-icon-favorites"></div>
                                                <p class="sticky-header-mobile__link-text">Избранное</p>
                                                <span>0</span>
                                            </a>
                                        </li>
    
                                        <li class="sticky-header-mobile__item">
                                            <a href="#" class="sticky-header-mobile__link">
    
                                                <div class="sticky-header-mobile__link-icon-account"></div>
                                                <p class="sticky-header-mobile__link-text">Мой LR.RU</p>
                                                
                                            </a>
                                        </li>
    
                                    </ul>
    
                                    <!-- sticky header desktop -->
                                    <div class="sticky-header__desktop sticky-header-desktop">
                                    
                                            <!-- logo -->
                                            <a href="http://final.lr.ru/" class="sticky-header-desktop__logo">
                                                <img src="/img/sticky-header/desktop/sticky-header-desktop-logo.svg" alt="">
                                            </a>
    
                                            <!-- search -->
                                            <form class="sticky-header-desktop__search">
                                                <input class="sticky-header-desktop__search-input" type="text" placeholder="Поиск по артикулу или наименованию...">
                                                <button class="sticky-header-desktop__search-setting"></button>
                                                <button class="sticky-header-desktop__search-btn" type="submit"></button>
                                            </form>
    
                                            <!-- user  -->
                                            <div class="sticky-header-desktop__user user">
    
                                                <a href="/favorite" class="user__favorites">
                                                    <img src="/img/favorites-icon.svg" alt="">
                                                    <p>Избранное</p>
                                                    <span>0</span>
                                                </a>
    
                                                <a href="/cart" class="user__shopping-cart" href="cart.html">
                                                    <img src="/img/shopping-cart-icon.svg" alt="">
                                                    <p>Корзина</p>
                                                    <span>0</span>
                                                </a>
    
                                                <a class="user__enter">
                                                    <img src="/img/enter-icon.svg" alt="">
                                                    <p>Вход</p>
                                                </a>
    
                                            </div>
    
                                            <!-- numbers -->
                                            <div class="sticky-header-desktop__numbers">
    
                                                <a href="#" class="sticky-header-desktop__number">+7 (495) 649 60 60</a>
                                                <a href="#" class="sticky-header-desktop__number">+7 (495) 649 60 60</a>
    
                                            </div>
                                        
                                    </div>                    
            `
    
            body.appendChild(stickyHeader);
            stickyHeader.style.opacity = '0';
            stickyHeader.style.visibility = 'hidden';
    
            window.addEventListener('scroll', function(e){
                let scrollPos  = window.scrollY;
                // console.log(scrollPos);
    
                if (scrollPos > 200) {
                    stickyHeader.style.opacity = '1';
                    stickyHeader.style.visibility = 'visible';
                } else if(scrollPos < 200){
                    stickyHeader.style.opacity = '0';
                    stickyHeader.style.visibility = 'hidden';
                }
            }); 
        }
    
    }
    
    stickyHeader();
    
    //Mobile count updater for catalog update1
    function stickyHeaderMobileCartCountUpdate(){
        let cartBtnMobileMainHeaderSpan = document.querySelector('.user-mobile__shopping-cart span');
        let stickyHeaderCartCounter = document.querySelector('.stickyHeaderCartParent span');
    
        if(cartBtnMobileMainHeaderSpan === null || stickyHeaderCartCounter === null){
            // console.log('default header NOT on the page!');
        }else{
            stickyHeaderCartCounter.innerText = cartBtnMobileMainHeaderSpan.innerText;
        }
    }
    
    stickyHeaderMobileCartCountUpdate();
    
    //Mobile Favorite count updater for catalog update1
    function stickyHeaderMobileFavCountUpdate(){
        let favBtnMobileMainHeaderSpan = document.querySelector('.user-mobile__favorites span');
        let stickyHeaderFavoriteCounter = document.querySelector('.stickyHeaderFavoriteParent span');
    
        if(favBtnMobileMainHeaderSpan === null || stickyHeaderFavoriteCounter === null){
            // console.log('default header NOT on the page!');  
        }else{                
            stickyHeaderFavoriteCounter.innerText = favBtnMobileMainHeaderSpan.innerText;
        }
    }
    
    stickyHeaderMobileFavCountUpdate();
    
    
    //Desktop count updater for catalog update1
    function stickyHeaderDesktopCartCountUpdate(){
        let cartBtnDesktopMainHeaderSpan = document.querySelector('.user__shopping-cart span');
        let stickyHeaderDesktopCartParent = document.querySelector('.sticky-header-desktop__user');
        
        if(cartBtnDesktopMainHeaderSpan === null || stickyHeaderDesktopCartParent === null){
             // console.log('default header NOT on the page!');  
        }else{   
            let stickyHeaderCartCounter = stickyHeaderDesktopCartParent.querySelector('.user__shopping-cart span');   
            stickyHeaderCartCounter.innerText = cartBtnDesktopMainHeaderSpan.innerText;
        }
    }
    
    stickyHeaderDesktopCartCountUpdate();
    
    //Desktop Favorite count updater for catalog update1
    function stickyHeaderDesktopFavoriteCountUpdate(){
        // countersHidder();
        let favBtnDesktopMainHeaderSpan = document.querySelector('.user__favorites span');
        let stickyHeaderDesktopFavParent = document.querySelector('.sticky-header-desktop__user');
        
        if(favBtnDesktopMainHeaderSpan === null || stickyHeaderDesktopFavParent === null){
            // console.log('default header NOT on the page!'); 
        }else{
            let stickyHeaderFavCounter = stickyHeaderDesktopFavParent.querySelector('.user__favorites span');
            stickyHeaderFavCounter.innerText = favBtnDesktopMainHeaderSpan.innerText;
        }
    
        
    }
    stickyHeaderDesktopFavoriteCountUpdate();
    
    //MobileUrlReader
    function stickyHeaderMobileUrlReaderMech(){
        let currentUrl 
        let stickyHeaderMobileHomeParent = document.querySelector('.stickyHeaderHomeParent');
        let stickyHeaderMobileHomeIcon = stickyHeaderMobileHomeParent.querySelector('.sticky-header-mobile__link-icon-home');
        let stickyHeaderMobileHomeText = stickyHeaderMobileHomeParent.querySelector('.sticky-header-mobile__link-text');
    
        let stickyHeaderMobileCatalogParent = document.querySelector('.stickyHeaderCatalogParent');
        let stickyHeaderMobileCatalogIcon = stickyHeaderMobileCatalogParent.querySelector('.sticky-header-mobile__link-icon-offers');
        let stickyHeaderMobileCatalogText = stickyHeaderMobileCatalogParent.querySelector('.sticky-header-mobile__link-text');
    
        let stickyHeaderMobileCartParent = document.querySelector('.stickyHeaderCartParent');
        let stickyHeaderMobileCartIcon = stickyHeaderMobileCartParent.querySelector('.sticky-header-mobile__link-icon-cart');
        let stickyHeaderMobileCartText = stickyHeaderMobileCartParent.querySelector('.sticky-header-mobile__link-text');
    
    
        let stickyHeaderMobileFavoriteParent = document.querySelector('.stickyHeaderFavoriteParent');
        let stickyHeaderMobileFavoriteIcon = stickyHeaderMobileFavoriteParent.querySelector('.sticky-header-mobile__link-icon-favorites');
        let stickyHeaderMobileFavoriteText = stickyHeaderMobileFavoriteParent.querySelector('.sticky-header-mobile__link-text');
    
        // let stickyHeaderMobileHomeText = stickyHeaderMobileHomeParent.querySelector('.sticky-header-mobile__link-text');
        // let stickyHeaderMobileHomeText = stickyHeaderMobileHomeParent.querySelector('.sticky-header-mobile__link-text');
        // let stickyHeaderMobileHomeText = stickyHeaderMobileHomeParent.querySelector('.sticky-header-mobile__link-text');
    
        if(window.location.toString().includes("http://final.lr.ru/favorite")){
            // console.warn('This is Favorite PAGE URL');
            // console.log(window.location.href);
            stickyHeaderMobileFavoriteIcon.classList.add('sticky-header-mobile__link-icon-favorites--active');
            stickyHeaderMobileFavoriteText.classList.add('sticky-header-mobile__link-text--active');
        } else if(window.location.toString().includes("http://final.lr.ru/dep/")){
            // console.warn('This is Catalog PAGE URL');
            // console.log(window.location.href);
            stickyHeaderMobileCatalogIcon.classList.add('sticky-header-mobile__link-icon-offers--active');
            stickyHeaderMobileCatalogText.classList.add('sticky-header-mobile__link-text--active');
        }else if(window.location.toString().includes("http://final.lr.ru/cart")){
            // console.warn('This is Cart PAGE URL');
            // console.log(window.location.href);
            stickyHeaderMobileCartIcon.classList.add('sticky-header-mobile__link-icon-cart--active');
            stickyHeaderMobileCartText.classList.add('sticky-header-mobile__link-text--active');
        }else if(window.location.toString().includes("http://final.lr.ru/")){
            // console.warn('This is Home PAGE URL');
            // console.log(window.location.href);
            stickyHeaderMobileHomeIcon.classList.add('sticky-header-mobile__link-icon-home--active');
            stickyHeaderMobileHomeText.classList.add('sticky-header-mobile__link-text--active');
        }
    }
    
    stickyHeaderMobileUrlReaderMech();
    
    //update on Cart page
    //Mobile count updater for Cart Page update2
    function stickyHeaderMobileCartCountUpdateInCart(){
        let cartBtnMobileMainHeaderSpan = document.querySelector('.header-cart-mobile__shopping-cart span');
        let stickyHeaderCartCounter = document.querySelector('.sticky-header-mobile__link span');
    
        if(cartBtnMobileMainHeaderSpan === null){
            // console.log('default header NOT on the page!');
        }else{
            stickyHeaderCartCounter.innerText = cartBtnMobileMainHeaderSpan.innerText;
        }
    }
    
    stickyHeaderMobileCartCountUpdateInCart();
    
    //Mobile Favorite count updater for Cart Page update2
    function stickyHeaderMobileFavCountUpdateInCart(){
        let favBtnMobileMainHeaderSpan = document.querySelector('.header-cart-mobile__favorites span');
        let stickyHeaderFavoriteCounter = document.querySelector('.stickyHeaderFavoriteParent span');
    
        if(favBtnMobileMainHeaderSpan === null){
            // console.log('default header NOT on the page!');  
        }else{                
            stickyHeaderFavoriteCounter.innerText = favBtnMobileMainHeaderSpan.innerText;
        }
    }
    stickyHeaderMobileFavCountUpdateInCart();
    
    //Desktop count updater for Cart Page update2
    function stickyHeaderDesktopCartCountUpdateInCart(){
        let cartBtnDesktopMainHeaderSpan = document.querySelector('.header-cart-desktop__shopping-cart span');
        let stickyHeaderDesktopCartCounter = document.querySelector('.user__shopping-cart span');
        
        if(cartBtnDesktopMainHeaderSpan === null){
             // console.log('default header NOT on the page!');  
        }else{    
            stickyHeaderDesktopCartCounter.innerText = cartBtnDesktopMainHeaderSpan.innerText;
        }
    }
    
    stickyHeaderDesktopCartCountUpdateInCart();
    
    //Desktop Favorite count updater for Cart Page update2
    function stickyHeaderDesktopFavoriteCountUpdateInCart(){
        let favBtnDesktopMainHeaderSpan = document.querySelector('.header-cart-desktop__favorites span');
        let stickyHeaderFavCounter = document.querySelector('.user__favorites span');
        
        if(favBtnDesktopMainHeaderSpan === null){
            // console.log('default header NOT on the page!'); 
        }else{
            stickyHeaderFavCounter.innerText = favBtnDesktopMainHeaderSpan.innerText;
        }
    
        
    }
    stickyHeaderDesktopFavoriteCountUpdateInCart();
    
    
    
    
    
    
    
    
    
    
    //testing for hidding conters spans in header/stickyheader
    //Hide '0' span counters for catalog
    function countersHidder(){
        //mobile
        let headerCartCounter = document.querySelector('.user-mobile__shopping-cart span');
        let headerFavoriteCounter = document.querySelector('.user-mobile__favorites span');
    
        let stickyHeaderMobileCart = document.querySelector('.stickyHeaderCartParent span');
        let stickyHeaderMobileFavorite = document.querySelector('.stickyHeaderFavoriteParent span');
    
    
    
        //checking for available on the page
        if(headerCartCounter === null){
            // console.log('default header NOT on the page!'); 
        }else{       
      
    
            //check favorite counter
            if(headerFavoriteCounter.innerText == '0'){
                headerFavoriteCounter.style.visibility = 'hidden';
                stickyHeaderMobileFavorite.style.visibility = 'hidden';
                desktopFavoriteCounter.forEach(item => {
                    item.style.visibility = 'hidden'
                })
            }
        }
    }
    function countersDeHidder(){
        //mobile
        let headerCartCounter = document.querySelector('.user-mobile__shopping-cart span');
        let headerFavoriteCounter = document.querySelector('.user-mobile__favorites span');
    
        let stickyHeaderMobileCart = document.querySelector('.stickyHeaderCartParent span');
        let stickyHeaderMobileFavorite = document.querySelector('.stickyHeaderFavoriteParent span');
    
        //desktop
        let desktopCartCounter = document.querySelectorAll('.user__shopping-cart span');
        let desktopFavoriteCounter = document.querySelectorAll('.user__favorites span');
    
        //checking for available on the page
        if(headerCartCounter === null){
            // console.log('default header NOT on the page!'); 
        }else{       
            //change cart counter
            headerCartCounter.style.visibility = 'visible';
            stickyHeaderMobileCart.style.visibility = 'visible';
    
            desktopCartCounter.forEach(item => {
                item.style.visibility = 'visible'
            })
    
            //change favorite counter
            headerFavoriteCounter.style.visibility = 'visible';
            stickyHeaderMobileFavorite.style.visibility = 'visible';
            desktopFavoriteCounter.forEach(item => {
                item.style.visibility = 'visible'
            });
        }
    }
    
    function desktopcountersHidder(){
        //desktop
        let desktopCartCounter = document.querySelectorAll('.user__shopping-cart span');
        let desktopFavoriteCounter = document.querySelectorAll('.user__favorites span');
    
        if(desktopCartCounter === null){
            // console.log('default header NOT on the page!'); 
        }else{
          //check cart counter
          desktopCartCounter.forEach(item => {
            if(item.innerText == '0'){
                item.style.visibility = 'hidden';
            }
          })
    
          desktopFavoriteCounter.forEach(item => {
            if(item.innerText == '0'){
                item.style.visibility = 'hidden';
            }
          })
        }
    }
    function desktopcountersDeHidder(){
        //desktop
        let desktopCartCounter = document.querySelectorAll('.user__shopping-cart span');
        let desktopFavoriteCounter = document.querySelectorAll('.user__favorites span');
    
        if(desktopCartCounter === null){
            // console.log('default header NOT on the page!'); 
        }else{
          //check cart counter
          desktopCartCounter.forEach(item => {
            if(item.innerText != '0'){
                item.style.visibility = 'visible';
            }
          })
    
          desktopFavoriteCounter.forEach(item => {
            if(item.innerText != '0'){
                item.style.visibility = 'visible';
            }
          })
        }
    }
    //trick Mechacnic for radio-buttons in payment choose section
    function trickMechForRadioButtonsInPaymentSection(){
        const paymentRadio = document.querySelectorAll(".cart-payment__select-btn-radio"); 
    
        if(paymentRadio === null){
            // console.log('it`s not cart page!');
        }else{
     
            for(let i = 0;i < paymentRadio.length; i++) { 
        
                if(paymentRadio[i].type=="radio") { 
                    paymentRadio[i].onchange=function() { 
            
                        for(let i=0;i<paymentRadio.length;i++) { 
                            if(paymentRadio[i].type=="radio") { 
                                paymentRadio[i].checked=false; 
                            }
                            this.checked=true
                        }
                    }
                }
            }
        }
    }
    trickMechForRadioButtonsInPaymentSection();
    
    //green border when radio button checked
    function trickMechForOptionBlockInPaymentSection(){
        const paymentOption = document.querySelectorAll('.cart-payment__option');
    
        if(paymentOption === null){
    
        }else{
            for(let i = 0; i < paymentOption.length; i++){
                const paymentOptionWrapper = paymentOption[i].querySelector('.cart-payment__option-info-wrapper');
                const paymentOptionRadioButton = paymentOption[i].querySelector('.cart-payment__select-btn');
    
                paymentOptionRadioButton.addEventListener('click', function(){
                    const allPaymentOptionWrapper = document.querySelectorAll('.cart-payment__option-info-wrapper');
                    allPaymentOptionWrapper.forEach(item => {
                        item.classList.remove('cart-payment__option-info-wrapper--active');
                    })
                    paymentOptionWrapper.classList.add('cart-payment__option-info-wrapper--active');
                });
            }
        }
    }
    
    trickMechForOptionBlockInPaymentSection()
    
    //trick Mechacnic for radio-buttons in delivery choose section
    function trickMechForRadioButtonsInDeliverySection(){
        const deliveryRadio = document.querySelectorAll(".cart-delivery__select-btn-radio"); 
    
        if(deliveryRadio === null){
            // console.log('it`s not cart page!');
        }else{
     
            for(let i = 0;i < deliveryRadio.length; i++) { 
        
                if(deliveryRadio[i].type=="radio") { 
                    deliveryRadio[i].onchange=function() { 
            
                        for(let i=0;i<deliveryRadio.length;i++) { 
                            if(deliveryRadio[i].type=="radio") { 
                                deliveryRadio[i].checked=false; 
                            }
                            this.checked=true
                        }
                    }
                }
            }
        }
    }
    trickMechForRadioButtonsInDeliverySection();
    
    //green border when radio button checked
    function trickMechForOptionBlockInDeliverySection(){
        const deliveryOption = document.querySelectorAll('.cart-delivery__option');
    
        if(deliveryOption === null){
    
        }else{
            for(let i = 0; i < deliveryOption.length; i++){
                const deliveryOptionWrapper = deliveryOption[i].querySelector('.cart-delivery__option-info-wrapper');
                const deliveryOptionRadioButton = deliveryOption[i].querySelector('.cart-delivery__select-btn');
    
                deliveryOptionRadioButton.addEventListener('click', function(){
                    const allDeliveryOptionWrapper = document.querySelectorAll('.cart-delivery__option-info-wrapper');
                    allDeliveryOptionWrapper.forEach(item => {
                        item.classList.remove('cart-delivery__option-info-wrapper--active');
                    })
                    deliveryOptionWrapper.classList.add('cart-delivery__option-info-wrapper--active');
                });
            }
        }
    }
    
    trickMechForOptionBlockInDeliverySection()
    
    //product cards mechs Desktop
    //Quantity btn cart product card + price/cost values update
    function cartDesktopProductCardQuantity(){
        const desktopProductCard = document.querySelectorAll('.cart-desktop-product');
        let desktopCartHeaderSpan = document.querySelector('.header-cart-desktop__shopping-cart span');
    
        //create metaBLock for metaData 
        const body = document.querySelector('body');
        const metaBlock = document.createElement('div');
        metaBlock.classList.add('metaBlock');
        metaBlock.style.visibility = 'hidden';
        body.appendChild(metaBlock);
    
        if(desktopProductCard === null){
    
        }else{
            for(let i = 0; i < desktopProductCard.length; i++){
                const desktopProductCardAvailabilityBlock = desktopProductCard[i].querySelector('.cart-desktop-product__shop');
                const desktopProductCardQuantityBlock = desktopProductCard[i].querySelector('.cart-desktop-product-quantity');
                const desktopProductCardBtnMinus = desktopProductCard[i].querySelector('.cart-desktop-product-quantity__btn-minus');
                const desktopProductCardBtnPlus = desktopProductCard[i].querySelector('.cart-desktop-product-quantity__btn-plus');
                const desktopProductCardInput = desktopProductCard[i].querySelector('.cart-desktop-product-quantity__default-input');
                const desktopProductCardFavoriteBtn = desktopProductCard[i].querySelector('.cart-desktop-product__favorite');
                const desktopProductCardRemoveBtn = desktopProductCard[i].querySelector('.cart-desktop-product__delete');
                
    
                const parentblock = desktopProductCardQuantityBlock.parentElement;
                let key = parentblock.dataset.key; 
                let availability = parentblock.dataset.availability;
    
                const cartDesktopCustomQuantityBlock = document.createElement('div');
                cartDesktopCustomQuantityBlock.classList.add('cart-desktop-product-quantity--custom');
    
                cartDesktopCustomQuantityBlock.innerHTML = `
                    <div class="cart-desktop-product-quantity__back-btn"></div>
                    <div class="cart-desktop-product-quantity__custom-input-wrapper">
                      <input class="cart-desktop-product-quantity__custom-input" pattern="[0-9]*" placeholder="1" type = "number" maxlength = "3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                      <a class="cart-desktop-product-quantity__apply-btn"></a>
                    </div>
                `;
                desktopProductCardQuantityBlock.after(cartDesktopCustomQuantityBlock);
    
                const cartDesktopCustomQuantityBackBtn = cartDesktopCustomQuantityBlock.querySelector('.cart-desktop-product-quantity__back-btn');
                const cartDesktopCustomQuantityInput = cartDesktopCustomQuantityBlock.querySelector('.cart-desktop-product-quantity__custom-input');
                const cartDesktopCustomQuantityRefresh = cartDesktopCustomQuantityBlock.querySelector('.cart-desktop-product-quantity__apply-btn');
    
    
                //disable minus btn if input placeholder == '1'
                function cartMinusBtnDisable(){
                    const metaCardInput = parentblock.querySelector('.cart-desktop-product-quantity__default-input');
                    if(metaCardInput.placeholder <= '1'){
    
                        if(desktopProductCardBtnMinus === null){
    
                        }else{
                            desktopProductCardBtnMinus.classList.remove('cart-desktop-product-quantity__btn-minus');
                            desktopProductCardBtnMinus.classList.add('cart-desktop-product-quantity__btn-minus--disable');
                        }
                        
                    }
                }
                cartMinusBtnDisable();
                //minus btn disable state reset
                function cartMinusBtnReset(){
                    if(desktopProductCardBtnMinus === null){
    
                    }else{
                        desktopProductCardBtnMinus.classList.remove('cart-desktop-product-quantity__btn-minus--disable');
                        desktopProductCardBtnMinus.classList.add('cart-desktop-product-quantity__btn-minus');
                    }
                }
                //disable plus btn if input placeholder > availability
                function cartPlusBtnDisable(){
                    desktopProductCardBtnPlus.classList.remove('cart-desktop-product-quantity__btn-plus');
                    desktopProductCardBtnPlus.classList.add('cart-desktop-product-quantity__btn-plus--disable');
                }
                //reset plus btn
                function cartPlusBtnReset(){
                    desktopProductCardBtnPlus.classList.remove('cart-desktop-product-quantity__btn-plus--disable');
                    desktopProductCardBtnPlus.classList.add('cart-desktop-product-quantity__btn-plus');
                }
                //check emptiness of cart - if cart empty:reload page
                function cartDesktopCheckProductList(){
                    let cartDesktopProductsList = document.querySelector('.cart__desktop-products-inner');
                    let firstProductInTheList = cartDesktopProductsList.querySelector('li');
                    if(firstProductInTheList === null){
                        document.location.reload();
                    }else{
                        // console.log('something here, in the cart');
                    }
                }
                //quantity button mech -/+/input/inputRefresh
                desktopProductCardBtnMinus.addEventListener('click', function(){
                    const metaCardInput = parentblock.querySelector('.cart-desktop-product-quantity__default-input');
                    const metaCardInputPlaceholder = metaCardInput.placeholder;
    
                    if(metaCardInputPlaceholder == '1'){
                        cartMinusBtnDisable();
                    }else{
                        const params = new URLSearchParams();
                        params.set('id', key);
        
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '/cart/reduce');
                        xhr.responseType = 'json';
        
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        
                        xhr.onload = () => {
                          if (xhr.status !== 200) {
                            console.warn('cardProduct MinusClick ajax error');
                          }else{
                          //  If 1 offer in afterBuyInputBlock checking
                            const response = xhr.response;
                            let countFromCart = response.count; 
                            desktopCartHeaderSpan.innerText = countFromCart;
                            stickyHeaderDesktopCartCountUpdateInCart();
                            --desktopProductCardInput.placeholder;
        
                            cartMinusBtnDisable();
                            cartPlusBtnReset();
                            desktopProductCardInput.style.pointerEvents = 'auto';
    
                            cartProductCardCostRefresh();
                          }
                        }
        
                        xhr.send(params);
                    }
                });
    
                desktopProductCardBtnPlus.addEventListener('click', function(){
                    const metaCardInput = parentblock.querySelector('.cart-desktop-product-quantity__default-input');
                    const metaCardInputPlaceholder = metaCardInput.placeholder;
                    cartMinusBtnReset();
    
                    if(availability == '1'){
                        //alert
                        desktopProductCardAvailabilityBlock.classList.remove('cart-desktop-product__shop');
                        desktopProductCardAvailabilityBlock.classList.add('cart-desktop-product__shop--alert');
    
                        function cardAvailableAlertDisapear(){
                            desktopProductCardAvailabilityBlock.classList.remove('cart-desktop-product__shop--alert');
                            desktopProductCardAvailabilityBlock.classList.add('cart-desktop-product__shop');
                        }
                        setTimeout(cardAvailableAlertDisapear, 7000);
    
                        cartPlusBtnDisable();
                        desktopProductCardInput.style.pointerEvents = 'none';
                    }else{
        
                        if(Number(metaCardInputPlaceholder) < Number(availability)){
                            //change
                            const params = new URLSearchParams();
                            params.set('id', key);
            
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', '/cart/add');
                            xhr.responseType = 'json';
            
                            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
     
                            xhr.onload = () => {
                              if (xhr.status !== 200) {
                                console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                              }else{
                                const response = xhr.response;
                                let countFromCart = response.count; 
                                desktopCartHeaderSpan.style.display = 'block';
                                desktopCartHeaderSpan.innerText = countFromCart;
                                stickyHeaderDesktopCartCountUpdateInCart();
    
                                ++metaCardInput.placeholder;
    
                                cartProductCardCostRefresh();
                              }
                            }
            
                            xhr.send(params);
                       
    
                        }else if(Number(metaCardInputPlaceholder) >= Number(availability)){
                            //alert
                            desktopProductCardAvailabilityBlock.classList.remove('cart-desktop-product__shop');
                            desktopProductCardAvailabilityBlock.classList.add('cart-desktop-product__shop--alert');
    
                            function cardAvailableAlertDisapear(){
                                desktopProductCardAvailabilityBlock.classList.remove('cart-desktop-product__shop--alert');
                                desktopProductCardAvailabilityBlock.classList.add('cart-desktop-product__shop');
                            }
                            setTimeout(cardAvailableAlertDisapear, 7000);
        
                            cartPlusBtnDisable();
                            desktopProductCardInput.style.pointerEvents = 'none';
    
                        }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
                            //change
                            const params = new URLSearchParams();
                            params.set('id', key);
            
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', '/cart/add');
                            xhr.responseType = 'json';
            
                            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
     
                            xhr.onload = () => {
                              if (xhr.status !== 200) {
                                console.warn('offerCardMobileAfterBuyCounter PlusClick ajax error');
                              }else{
                                const response = xhr.response;
                                let countFromCart = response.count; 
                                desktopCartHeaderSpan.style.display = 'block';
                                desktopCartHeaderSpan.innerText = countFromCart;
                                stickyHeaderDesktopCartCountUpdateInCart();
    
                                ++metaCardInput.placeholder;
    
                                cartProductCardCostRefresh();
                              }
                            }
            
                            xhr.send(params);
                        }
                    }
                });
    
                desktopProductCardInput.addEventListener('click', function(){
                    localStorage.setItem('cartDesktopCustomQuantityInputValue', '');
                    if(availability == '1'){
                        //alert
                        desktopProductCardAvailabilityBlock.classList.remove('cart-desktop-product__shop');
                        desktopProductCardAvailabilityBlock.classList.add('cart-desktop-product__shop--alert');
    
                        function cardAvailableAlertDisapear(){
                            desktopProductCardAvailabilityBlock.classList.remove('cart-desktop-product__shop--alert');
                            desktopProductCardAvailabilityBlock.classList.add('cart-desktop-product__shop');
                        }
                        setTimeout(cardAvailableAlertDisapear, 7000);
    
                        cartPlusBtnDisable();
                        desktopProductCardInput.style.pointerEvents = 'none';
                    }else{
                        desktopProductCardQuantityBlock.style.display = 'none';
                        cartDesktopCustomQuantityBlock.style.display = 'flex';
    
                        cartDesktopCustomQuantityInput.focus();
                        cartDesktopCustomQuantityInput.addEventListener('input', function updateCustomInputValueCartDesktop(e){
                            const cartDesktopCustomQuantityInputValue = cartDesktopCustomQuantityInput.value;
    
                            if(Number(cartDesktopCustomQuantityInputValue) < Number(availability)){
                                // console.warn(`КАСТОМНЫЙ ИНПУТ МЕНЬШЕ ОСТАТКА осталось ${availability} штук ТОВАР ДОБАВЛЯЕМ`);
                                localStorage.setItem('cartDesktopCustomQuantityInputValue', cartDesktopCustomQuantityInputValue);
                            }else if(Number(cartDesktopCustomQuantityInputValue) > Number(availability)){
                                // console.warn(`КАСТОМНЫЙ ИНПУТ БОЛЬШЕ ИЛИ РАВЕН ОСТАТКУ осталось ${availability} штук ТОВАР НЕ ДОБАВЛЯЕМ`);
                                desktopProductCardAvailabilityBlock.classList.remove('cart-desktop-product__shop');
                                desktopProductCardAvailabilityBlock.classList.add('cart-desktop-product__shop--alert');
            
                                function cardAvailableAlertDisapear(){
                                    desktopProductCardAvailabilityBlock.classList.remove('cart-desktop-product__shop--alert');
                                    desktopProductCardAvailabilityBlock.classList.add('cart-desktop-product__shop');
                                }
                                setTimeout(cardAvailableAlertDisapear, 7000);
            
                                cartDesktopCustomQuantityInput.value = availability;
                                localStorage.setItem('cartDesktopCustomQuantityInputValue', availability);
                            }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
                                localStorage.setItem('cartDesktopCustomQuantityInputValue', cartDesktopCustomQuantityInputValue);
                            }
                        }); 
    
                        cartDesktopCustomQuantityBackBtn.addEventListener('click', function(){
                            desktopProductCardQuantityBlock.style.display = 'flex';
                            cartDesktopCustomQuantityBlock.style.display = 'none';
                        });
                    }
                    
                });
    
                cartDesktopCustomQuantityRefresh.addEventListener('click', function(e){
                    e.preventDefault();
                    cartMinusBtnReset();
                    
                    let cartDesktopCustomQuantityInputValue = localStorage.getItem('cartDesktopCustomQuantityInputValue');
    
                    if(cartDesktopCustomQuantityInputValue == ''){
                        console.warn('cartDesktopCustomQuantityInputValue === empty string');
                    }else{
                        const params = new URLSearchParams();
                        params.set('id', key);
                        params.append('qty', cartDesktopCustomQuantityInputValue);
    
                        let xhr = new XMLHttpRequest();
    
                        xhr.open('POST', '/cart/change');
                        xhr.responseType = 'json';
    
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                        xhr.onload = () => {
                          if (xhr.status !== 200) {
                            console.warn('cartDesktopCustomQuantityInputValue ajax error');
                          } else {
                            console.warn('cartDesktopCustomQuantityInputValue ajax SUCCESS');
                            // dynamic data from cart
                            const response = xhr.response;
                            let countFromCart = response.count; 
                            desktopCartHeaderSpan.style.display = 'block';
                            desktopCartHeaderSpan.innerText = countFromCart;
                            stickyHeaderDesktopCartCountUpdateInCart();
    
                            desktopProductCardInput.placeholder = cartDesktopCustomQuantityInputValue;
    
                            cartProductCardCostRefresh();
    
                            //clear customInputValue
                            function clearCustomInputValue(){
                                localStorage.setItem('cartDesktopCustomQuantityInputValue', '');
                            }
                            setTimeout(clearCustomInputValue, 200);
                          }
                        }
    
                        xhr.send(params);
                    }
                });
    
                //remove offer
                desktopProductCardRemoveBtn.addEventListener('click', function(){
                    let closestSeparator = parentblock.nextElementSibling;
    
                    const params = new URLSearchParams();
                    params.set('id', key);
    
                    let xhr = new XMLHttpRequest();
            
                    xhr.open('POST', '/cart/remove');
                    xhr.responseType = 'json';
    
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                    xhr.onload = () => {
                      if (xhr.status !== 200) {
                        // console.warn('offerCardDesktopquantityDeleteButtonMech ajax error');
                      }else{
                        
                        const response = xhr.response;
                        let countFromCart = response.count; 
                        desktopCartHeaderSpan.style.display = 'block';
                        desktopCartHeaderSpan.innerText = countFromCart;
                        
                        desktopProductCard[i].style.transition = '0.4s';
                        desktopProductCard[i].style.transform = 'translate(-130%, 0)';
    
                        function parentBlockWithSeparatorDisapear(){
                            desktopProductCard[i].remove();
                            closestSeparator.remove();
                            cartDesktopCheckProductList();
                        }
                        stickyHeaderDesktopCartCountUpdateInCart();
                        setTimeout(parentBlockWithSeparatorDisapear, 500);
                        setTimeout(cartDesktopStarterPriceRefresh, 600);
                      }
                    }
    
                    xhr.send(params);
                });
    
                //Refresh cost of product card == price * quantity
                function cartProductCardCostRefresh(){
                    const desktopProductCardPrice = desktopProductCard[i].querySelector('.cart-desktop-product__price p');
                    const desktopProductCardCost = desktopProductCard[i].querySelector('.cart-desktop-product__cost p');
                    const desktopProductCardInput = desktopProductCard[i].querySelector('.cart-desktop-product-quantity__default-input');
                    const desktopProductCardInputPlaceholder = desktopProductCardInput.placeholder;
    
                    const desktopProductCardPriceOutput = desktopProductCardPrice.innerText;
                    const desktopProductCardPriceOutputReplaced = desktopProductCardPriceOutput.split(' ').join('');
                    const desktopProductCardPriceOutputReplacedNumber = Number(desktopProductCardPriceOutputReplaced);
    
                    const mutantCostInTheRow = desktopProductCardPriceOutputReplacedNumber * Number(desktopProductCardInputPlaceholder);
                    const reMutantCostInTheRowString = mutantCostInTheRow.toString();
                    const reMutantCostInTheRow = reMutantCostInTheRowString.replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
                    // console.warn('reMutantCostInTheRow')
                    // console.warn(reMutantCostInTheRow)
                    desktopProductCardCost.innerHTML = reMutantCostInTheRow;
    
                    cartDesktopStarterPriceRefresh()
                }
    
                //refresh starterPrice 
                function cartDesktopStarterPriceRefresh(){
                    const starterPriceBlocks = document.querySelectorAll('.cart-desktop-starter-price__cost-output');
                    const finalPriceBlocks = document.querySelectorAll('.cart-final-price__price-output');
    
                    const desktopProductCardsCostsList = document.querySelectorAll('.cart-desktop-product__cost p');
                    metaValueCartCostListCleaner();
    
                    desktopProductCardsCostsList.forEach(item => {
                        const desktopProductCardsCostsListItemOutput = item.innerText;
                        const desktopProductCardsCostsListItemOutputReplaced = desktopProductCardsCostsListItemOutput.split(' ').join('');
                        const desktopProductCardsCostsListItemOutputReplacedNumber = Number(desktopProductCardsCostsListItemOutputReplaced);
    
                        item.dataset.value = desktopProductCardsCostsListItemOutputReplacedNumber;
    
                        let cartMetaValueCost = document.createElement('div');
                        cartMetaValueCost.classList.add('metaValueCartCost');
                        metaBlock.appendChild(cartMetaValueCost);
                        cartMetaValueCost.innerHTML = item.dataset.value;
                    })
                   
                    const metaValueCartCostList = document.querySelectorAll('.metaValueCartCost');
                    
                    //sum of Costs
                    let sumOfCosts = 0;
                    for(let i = 0; i < metaValueCartCostList.length; i++){
                        let currentMetaValue = metaValueCartCostList[i].innerHTML;
                        let currentMetaValueNumber = Number(currentMetaValue);
    
                        sumOfCosts += currentMetaValueNumber;
                    }
                    // const starterPriceModified = metaValueCartCostList.reduce((a, b) => a + b, 0);
                    const reMutantSumOfCosts = sumOfCosts.toString();
                    const reMutantSumOfCostsFormated = reMutantSumOfCosts.replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
    
                    //replace value of starterPrice and finalPrice blocks
                    starterPriceBlocks.forEach(item => {
                        item.innerHTML = reMutantSumOfCostsFormated;
                    })
    
                    finalPriceBlocks.forEach(item => {
                        item.innerHTML = reMutantSumOfCostsFormated;
                    })
                }
                //function for removing metaData from previous iteration
                function metaValueCartCostListCleaner(){
                    let metaValueCartCostList = document.querySelectorAll('.metaValueCartCost');
                    if(metaValueCartCostList === null){
    
                    }else{
                        metaValueCartCostList.forEach(item => {
                            item.remove();
                        })
                    }
                }     
            }
        }
    }
    // cartDesktopProductCardQuantity();
    
    //product cards mechs Mobile
    //Quantity btn cart product card + price/cost values update
    function cartMobileProductCardQuantity(){
        const mobileProductCardList = document.querySelectorAll('.cart-mobile-product');
        let mobileCartHeaderSpan = document.querySelector('.header-cart-mobile__shopping-cart span');
    
        //create metaBLock for metaData 
        const body = document.querySelector('body');
        const metaBlockMobile = document.createElement('div');
        metaBlockMobile.classList.add('metaBlockMobile');
        metaBlockMobile.style.visibility = 'hidden';
        body.appendChild(metaBlockMobile);
    
        if(mobileProductCardList === null){
    
        }else{ 
            for(let i = 0; i < mobileProductCardList.length; i++){
                const mobileProductCardAvailabilityBlock = mobileProductCardList[i].querySelector('.cart-mobile-product__shop');
                const mobileProductCardQantityBlock = mobileProductCardList[i].querySelector('.cart-mobile-product-quantity');
                const mobileProductCardBtnMinus = mobileProductCardList[i].querySelector('.cart-mobile-product-quantity__btn-minus');
                const mobileProductCardBtnPlus = mobileProductCardList[i].querySelector('.cart-mobile-product-quantity__btn-plus');
                const mobileProductCardInput = mobileProductCardList[i].querySelector('.cart-mobile-product-quantity__default-input');
                const mobileProductCardRemoveBtn = mobileProductCardList[i].querySelector('.cart-mobile-product__delete');
    
                const currentMobileproductCard = mobileProductCardList[i];
                let key = currentMobileproductCard.dataset.key; 
                let availability = currentMobileproductCard.dataset.availability;
    
                // console.warn('currentMobileproductCard')
                // console.warn(currentMobileproductCard)
                // console.warn('key')
                // console.warn(key)
                // console.warn('availability')
                // console.warn(availability)
    
                const cartMobileCustomQuantityBlock = document.createElement('div');
                cartMobileCustomQuantityBlock.classList.add('cart-mobile-product-quantity--custom');
    
                cartMobileCustomQuantityBlock.innerHTML = `          
                        <div class="cart-mobile-product-quantity__back-btn"></div>
                        <div class="cart-mobile-product-quantity__custom-input-wrapper">
                            <input class="cart-mobile-product-quantity__custom-input" pattern="[0-9]*" placeholder="1" type = "number" maxlength = "3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                            <a class="cart-mobile-product-quantity__apply-btn"></a>
                        </div>
                `;
                
                mobileProductCardQantityBlock.after(cartMobileCustomQuantityBlock);
    
                const cartMobileCustomQuantityBackBtn = cartMobileCustomQuantityBlock.querySelector('.cart-mobile-product-quantity__back-btn');
                const cartMobileCustomQuantityInput = cartMobileCustomQuantityBlock.querySelector('.cart-mobile-product-quantity__custom-input');
                const cartMobileCustomQuantityRefresh = cartMobileCustomQuantityBlock.querySelector('.cart-mobile-product-quantity__apply-btn');
    
                //disable minus btn if input placeholder == '1'
                function cartMobileMinusBtnDisable(){
                    const metaCardInput = currentMobileproductCard.querySelector('.cart-mobile-product-quantity__default-input');
                    if(metaCardInput.placeholder <= '1'){
                        mobileProductCardBtnMinus.classList.remove('cart-mobile-product-quantity__btn-minus');
                        mobileProductCardBtnMinus.classList.add('cart-mobile-product-quantity__btn-minus--disable');
                    }
                }
                cartMobileMinusBtnDisable();
                //minus btn disable state reset
                function cartMobileMinusBtnReset(){
                    mobileProductCardBtnMinus.classList.add('cart-mobile-product-quantity__btn-minus');
                    mobileProductCardBtnMinus.classList.remove('cart-mobile-product-quantity__btn-minus--disable');
                }
                //disable plus btn if input placeholder > availability
                function cartMobilePlusBtnDisable(){
                    mobileProductCardBtnPlus.classList.remove('cart-mobile-product-quantity__btn-plus');
                    mobileProductCardBtnPlus.classList.add('cart-mobile-product-quantity__btn-plus--disable');
                }
                //reset plus btn
                function cartMobilePlusBtnReset(){
                    mobileProductCardBtnPlus.classList.add('cart-mobile-product-quantity__btn-plus');
                    mobileProductCardBtnPlus.classList.remove('cart-mobile-product-quantity__btn-plus--disable');
                }
                //check emptiness of cart - if cart empty:reload page
                function cartMobileCheckProductList(){
                    const cartMobileProductList = document.querySelector('.cart__mobile-products');
                    const firstProductInTheList = cartMobileProductList.querySelector('li');
                    if(firstProductInTheList === null){
                        document.location.reload();
                    }
                }
                //quantity button mech -/+/input/inputRefresh
                mobileProductCardBtnMinus.addEventListener('click', function(){
                    const metaCardInput = currentMobileproductCard.querySelector('.cart-mobile-product-quantity__default-input');
                    const metaCardInputPlaceholder = metaCardInput.placeholder;
    
                    if(metaCardInputPlaceholder == '1'){
                        cartMobileMinusBtnDisable();
                    }else{
                        const params = new URLSearchParams();
                        params.set('id', key);
        
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '/cart/reduce');
                        xhr.responseType = 'json';
        
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        
                        xhr.onload = () => {
                          if (xhr.status !== 200) {
                            console.warn('cardProductMobile MinusClick ajax error');
                          }else{
                          //  If 1 offer in afterBuyInputBlock checking
                            const response = xhr.response;
                            let countFromCart = response.count; 
                            mobileCartHeaderSpan.innerText = countFromCart;
                            stickyHeaderMobileCartCountUpdateInCart();;
                            --mobileProductCardInput.placeholder;
        
                            cartMobileMinusBtnDisable();
                            cartMobilePlusBtnReset()
                            mobileProductCardInput.style.pointerEvents = 'auto';
    
                            cartProductCardCostRefresh();
                          }
                        }
        
                        xhr.send(params);
                    }
                });
    
                mobileProductCardBtnPlus.addEventListener('click', function(){
                    const metaCardInput = currentMobileproductCard.querySelector('.cart-mobile-product-quantity__default-input');
                    const metaCardInputPlaceholder = metaCardInput.placeholder;
                    cartMobileMinusBtnReset();
    
                    if(availability == '1'){
                        mobileProductCardAvailabilityBlock.classList.remove('cart-mobile-product__shop');
                        mobileProductCardAvailabilityBlock.classList.add('cart-mobile-product__shop--alert');
    
                        function cartMobileCardAvailabilityDisapear(){
                            mobileProductCardAvailabilityBlock.classList.add('cart-mobile-product__shop');
                            mobileProductCardAvailabilityBlock.classList.remove('cart-mobile-product__shop--alert');
                        }
                        setTimeout(cartMobileCardAvailabilityDisapear, 7000);
    
                        cartMobilePlusBtnDisable();
                        mobileProductCardInput.style.pointerEvents = 'none';
                    }else{
                        if(Number(metaCardInputPlaceholder) < Number(availability)) {
                            //change
                            const params = new URLSearchParams();
                            params.set('id', key);
            
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', '/cart/add');
                            xhr.responseType = 'json';
            
                            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
     
                            xhr.onload = () => {
                              if (xhr.status !== 200) {
                                console.warn('offerCardMobileAfterBuyCounter PlusClick ajax error');
                              }else{
                                const response = xhr.response;
                                let countFromCart = response.count; 
                                mobileCartHeaderSpan.innerText = countFromCart;
                                stickyHeaderMobileCartCountUpdateInCart();
    
                                ++mobileProductCardInput.placeholder;
    
                                cartProductCardCostRefresh()
                              }
                            }
            
                            xhr.send(params);
                        }else if(Number(metaCardInputPlaceholder) >= Number(availability)){
                            //alert
                            mobileProductCardAvailabilityBlock.classList.remove('cart-mobile-product__shop');
                            mobileProductCardAvailabilityBlock.classList.add('cart-mobile-product__shop--alert');
        
                            function cartMobileCardAvailabilityDisapear(){
                                mobileProductCardAvailabilityBlock.classList.add('cart-mobile-product__shop');
                                mobileProductCardAvailabilityBlock.classList.remove('cart-mobile-product__shop--alert');
                            }
                            setTimeout(cartMobileCardAvailabilityDisapear, 7000);
        
                            cartMobilePlusBtnDisable();
                            mobileProductCardInput.style.pointerEvents = 'none';
                        }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
                            //change
                            const params = new URLSearchParams();
                            params.set('id', key);
            
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', '/cart/add');
                            xhr.responseType = 'json';
            
                            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                            xhr.onload = () => {
                                if (xhr.status !== 200) {
                                    console.warn('offerCardMobileAfterBuyCounter PlusClick ajax error');
                                }else{
                                    const response = xhr.response;
                                    let countFromCart = response.count; 
                                    mobileCartHeaderSpan.innerText = countFromCart;
                                    stickyHeaderMobileCartCountUpdateInCart();
    
                                    ++mobileProductCardInput.placeholder;
    
                                    cartProductCardCostRefresh()
                                }
                            }
            
                            xhr.send(params);
                        }
                    }
                });
    
                mobileProductCardInput.addEventListener('click', function(){
                    localStorage.setItem('cartMobileCustomQuantityInputValue', '');
                    if(availability == '1'){
                        //alert
                        mobileProductCardAvailabilityBlock.classList.remove('cart-mobile-product__shop');
                        mobileProductCardAvailabilityBlock.classList.add('cart-mobile-product__shop--alert');
    
                        function cartMobileCardAvailabilityDisapear(){
                            mobileProductCardAvailabilityBlock.classList.add('cart-mobile-product__shop');
                            mobileProductCardAvailabilityBlock.classList.remove('cart-mobile-product__shop--alert');
                        }
                        setTimeout(cartMobileCardAvailabilityDisapear, 7000);
    
                        cartMobilePlusBtnDisable();
                        mobileProductCardInput.style.pointerEvents = 'none';  
                    }else{
                        mobileProductCardQantityBlock.style.display = 'none';
                        cartMobileCustomQuantityBlock.style.display = 'flex';
    
                        cartMobileCustomQuantityInput.focus();
                        cartMobileCustomQuantityInput.addEventListener('input', function updateCustomInputValueCartMobile(e){
                            const cartMobileCustomQuantityInputValue = cartMobileCustomQuantityInput.value;
    
                            if(Number(cartMobileCustomQuantityInputValue) < Number(availability)){
                                // console.warn(`КАСТОМНЫЙ ИНПУТ МЕНЬШЕ ОСТАТКА осталось ${availability} штук ТОВАР ДОБАВЛЯЕМ`);
                                localStorage.setItem('cartMobileCustomQuantityInputValue', cartMobileCustomQuantityInputValue);
                            }else if(Number(cartMobileCustomQuantityInputValue) > Number(availability)){
                                // console.warn(`КАСТОМНЫЙ ИНПУТ БОЛЬШЕ ИЛИ РАВЕН ОСТАТКУ осталось ${availability} штук ТОВАР НЕ ДОБАВЛЯЕМ`);
                                mobileProductCardAvailabilityBlock.classList.remove('cart-mobile-product__shop');
                                mobileProductCardAvailabilityBlock.classList.add('cart-mobile-product__shop--alert');
            
                                function cartMobileCardAvailabilityDisapear(){
                                    mobileProductCardAvailabilityBlock.classList.add('cart-mobile-product__shop');
                                    mobileProductCardAvailabilityBlock.classList.remove('cart-mobile-product__shop--alert');
                                }
                                setTimeout(cartMobileCardAvailabilityDisapear, 7000);
            
                                cartMobileCustomQuantityInput.value = availability;
                                localStorage.setItem('cartMobileCustomQuantityInputValue', availability);
                            }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
                                // console.warn(`КАСТОМНЫЙ ИНПУТ ограничен парметрами инпута - MAX_LENGTH = 3 | ТОВАР ДОБАВЛЯЕМ`);
                                localStorage.setItem('cartMobileCustomQuantityInputValue', cartMobileCustomQuantityInputValue);
                            }
                        })
                    }
                })
                cartMobileCustomQuantityBackBtn.addEventListener('click', function(){
                    cartMobileCustomQuantityBlock.style.display = 'none';
                    mobileProductCardQantityBlock.style.display = 'flex';
                });
            
                cartMobileCustomQuantityRefresh.addEventListener('click', function(e){
                    e.preventDefault();
                    cartMobileMinusBtnReset();
    
                    let cartMobileCustomQuantityInputValue = localStorage.getItem('cartMobileCustomQuantityInputValue');
    
                    if(cartMobileCustomQuantityInputValue == ''){
                        console.warn('cartMobileCustomQuantityInputValue === empty string');
                    }else{
                        const params = new URLSearchParams();
                        params.set('id', key);
                        params.append('qty', cartMobileCustomQuantityInputValue);
    
                        let xhr = new XMLHttpRequest();
    
                        xhr.open('POST', '/cart/change');
                        xhr.responseType = 'json';
    
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                        xhr.onload = () => {
                          if (xhr.status !== 200) {
                            console.warn('cartMobileCustomQuantityInputValue ajax error');
                          } else {
                            console.warn('cartMobileCustomQuantityInputValue ajax SUCCESS');
                            // dynamic data from cart
                            const response = xhr.response;
                            let countFromCart = response.count; 
    
                            mobileCartHeaderSpan.innerText = countFromCart;
                            stickyHeaderMobileCartCountUpdateInCart();
    
                            mobileProductCardInput.placeholder = cartMobileCustomQuantityInputValue;
                            cartProductCardCostRefresh()
    
                            //clear customInputValue
                            function clearCustomInputValue(){
                                localStorage.setItem('cartMobileCustomQuantityInputValue', '');
                            }
                            setTimeout(clearCustomInputValue, 200);
                          }
                        }
    
                        xhr.send(params);
                    }
                });
                //remove offer
                mobileProductCardRemoveBtn.addEventListener('click', function(){
                    const closestSeparator = mobileProductCardList[i].nextElementSibling;
    
                    const params = new URLSearchParams();
                    params.set('id', key);
    
                    let xhr = new XMLHttpRequest();
            
                    xhr.open('POST', '/cart/remove');
                    xhr.responseType = 'json';
    
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                    xhr.onload = () => {
                      if (xhr.status !== 200) {
                        // console.warn('offerCardInCartMobileDeleteButtonMech ajax error');
                      }else{
                        const response = xhr.response;
                        let countFromCart = response.count; 
                        mobileCartHeaderSpan.innerText = countFromCart;
                        stickyHeaderMobileCartCountUpdateInCart();
                        
                        mobileProductCardList[i].style.transition = '0.4s';
                        mobileProductCardList[i].style.transform = 'translate(-130%, 0)';
    
                        function parentBlockWithSeparatorDisapear(){
                            mobileProductCardList[i].remove();
                            closestSeparator.remove();
                            cartMobileCheckProductList();
                        }
                        setTimeout(parentBlockWithSeparatorDisapear, 500);
                        setTimeout(cartMobileStarterPriceRefresh, 600);
                        
                      }
                    }
                    xhr.send(params);
                });
    
                //Refresh cost of product card == price * quantity Mobile
                function cartProductCardCostRefresh(){
                    const mobileProductCardPrice = mobileProductCardList[i].querySelector('.cart-mobile-product__price p');
                    const mobileProductCardCost = mobileProductCardList[i].querySelector('.cart-mobile-product__cost p');
                    const mobileProductCardInput = mobileProductCardList[i].querySelector('.cart-mobile-product-quantity__default-input');
                    const mobileProductCardInputPlaceholder = mobileProductCardInput.placeholder;
    
                    const mobileProductCardPriceOutput = mobileProductCardPrice.innerText;
                    const mobileProductCardPriceOutputReplaced = mobileProductCardPriceOutput.split(' ').join('');
                    const mobileProductCardPriceOutputReplacedNumber = Number(mobileProductCardPriceOutputReplaced);
    
                    const mutantCostInTheRow = mobileProductCardPriceOutputReplacedNumber * Number(mobileProductCardInputPlaceholder);
                    const reMutantCostInTheRowToString = mutantCostInTheRow.toString();
                    const reMutantCostInTheRowFormat = reMutantCostInTheRowToString.replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
    
                    mobileProductCardCost.innerHTML = reMutantCostInTheRowFormat;
    
                    cartMobileStarterPriceRefresh();
                }
    
                //refresh final price after +/-/refresh actions
                function cartMobileStarterPriceRefresh(){
                    const starterPriceBlockMobile = document.querySelector('.cart-mobile-starter-price__cost-output');
                    const finalPriceBlockMobile = document.querySelector('.cart-final-price__price-output');
    
                    const mobileProductCardsCostsList = document.querySelectorAll('.cart-mobile-product__cost p');
                    metaValueCartCostListCleanerMobile();
    
                    mobileProductCardsCostsList.forEach(item => {
                        const mobileProductCardsCostsListItemOutput = item.innerText;
                        const mobileProductCardsCostsListItemOutputReplaced = mobileProductCardsCostsListItemOutput.split(' ').join('');
                        const mobileProductCardsCostsListItemOutputReplacedNumber = Number(mobileProductCardsCostsListItemOutputReplaced);
    
                        item.dataset.value = mobileProductCardsCostsListItemOutputReplacedNumber;
    
                        let cartMetaValueCostMobile = document.createElement('div');
                        cartMetaValueCostMobile.classList.add('metaValueCartCostMobile');
                        metaBlockMobile.appendChild(cartMetaValueCostMobile);
                        cartMetaValueCostMobile.innerHTML = item.dataset.value;
                    })
    
                    const metaValueCartCostListMobile = document.querySelectorAll('.metaValueCartCostMobile');
                    //sum of Costs
                    let sumOfCosts = 0;
                    for(let i = 0; i < metaValueCartCostListMobile.length; i++){     
                        let currentMetaValue = metaValueCartCostListMobile[i].innerHTML;
                        let currentMetaValueNumber = Number(currentMetaValue);
    
                        sumOfCosts += currentMetaValueNumber;
                    }
    
                    const reMutantSumOfCosts = sumOfCosts.toString();
                    const reMutantSumOfCostsFormated = reMutantSumOfCosts.replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
    
                    starterPriceBlockMobile.innerHTML = reMutantSumOfCostsFormated;
                    finalPriceBlockMobile.innerHTML = reMutantSumOfCostsFormated;
                }
                //function for removing metaData from previous iteration
                function metaValueCartCostListCleanerMobile(){
                    let metaValueCartCostListMobile = document.querySelectorAll('.metaValueCartCostMobile');
                    if(metaValueCartCostListMobile === null){
    
                    }else{
                        metaValueCartCostListMobile.forEach(item => {
                        item.remove();
                    })
                   }
                }
            }
        }
    }
    // cartMobileProductCardQuantity()
    
    //favoriteMech Desktop
    function cartDesktopFavBtnMech(){
        let favWrapperList = document.querySelectorAll('.cart-desktop-product__favorite-wrapper');
        let cartDesktopHeaderFavSpan = document.querySelector('.header-cart-desktop__favorites span');
        if(favWrapperList === null){
            // console.log('no offers on page');
        }else{
            for(let i = 0; i < favWrapperList.length; i++){
                const currentFavBtn = favWrapperList[i].querySelector('.cart-desktop-product__favorite');
                const currentFavBtnActive = favWrapperList[i].querySelector('.cart-desktop-product__favorite-active');
    
                let favBtnKey = currentFavBtn.dataset.key;
    
                currentFavBtn.addEventListener('click', function(){
                    let xhr = new XMLHttpRequest();
    
                    xhr.open('POST', '/favorite/add');
          
                    xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
          
                    xhr.onload = () => {
                      if (xhr.status !== 200) {
                        // console.warn('favoriteMobileMech ajax error');
                        // errorBannerMobileRemove();
                        // errorBannerMobile();
                      }else {
                        const jsonResponse = JSON.parse(xhr.responseText);;
                          
                        let countFavFromServer = ++jsonResponse.count;
                        cartDesktopHeaderFavSpan.innerText = countFavFromServer;
          
                        currentFavBtnActive.style.display = 'block';
                        // mobileFavoriteTooltip();
                        stickyHeaderDesktopFavoriteCountUpdateInCart();
                      }   
                    }
                    
                    xhr.send('key=' + favBtnKey);
                }); 
    
                currentFavBtnActive.addEventListener('click', function(){
                    let xhr = new XMLHttpRequest();
    
                    xhr.open('POST', '/favorite/remove');
          
                    xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
          
                    xhr.onload = () => {
                      if (xhr.status !== 200) {
                        // console.warn('favoriteMobileMech ajax error');
                        // errorBannerMobileRemove();
                        // errorBannerMobile();
                      }else {
                        const jsonResponse = JSON.parse(xhr.responseText);;
                          
                        let countFavFromServer = --jsonResponse.count;
                          // console.warn(countFromFav)
                          cartDesktopHeaderFavSpan.innerText = countFavFromServer;
          
                        currentFavBtnActive.style.display = 'none';
                        currentFavBtn.style.display = 'block';
                        // mobileFavoriteTooltip();
                        stickyHeaderDesktopFavoriteCountUpdateInCart();
                      }   
                    }
                    
                    xhr.send('key=' + favBtnKey);
                });
            }
        }
    }
    cartDesktopFavBtnMech();
    
    //favoriteMech Mobile
    function cartMobileFavBtnMech(){
        let favWrapperListMobile = document.querySelectorAll('.cart-mobile-product__favorite-wrapper');
        let mobileCartHeaderFavSpan = document.querySelector('.header-cart-mobile__favorites span');
    
        if(favWrapperListMobile === null){
    
        }else{
            for (let i = 0; i < favWrapperListMobile.length; i++) {
                const currentFavBtnMobile = favWrapperListMobile[i].querySelector('.cart-mobile-product__favorite');
                const currentFavBtnActiveMobile = favWrapperListMobile[i].querySelector('.cart-mobile-product__favorite-active');
                
                let favBtnKey = currentFavBtnMobile.dataset.key;
    
                currentFavBtnMobile.addEventListener('click', function(){
                    let xhr = new XMLHttpRequest();
    
                    xhr.open('POST', '/favorite/add');
          
                    xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
          
                    xhr.onload = () => {
                      if (xhr.status !== 200) {
                        // console.warn('favoriteMobileMech ajax error');
                        // errorBannerMobileRemove();
                        // errorBannerMobile();
                      }else {
                        const jsonResponse = JSON.parse(xhr.responseText);;
                          
                        let countFavFromServer = ++jsonResponse.count;
                        mobileCartHeaderFavSpan.innerText = countFavFromServer;
          
                        currentFavBtnActiveMobile.style.display = 'block';
                        // mobileFavoriteTooltip();
                        stickyHeaderMobileFavCountUpdateInCart();
                      }   
                    }
                    
                    xhr.send('key=' + favBtnKey);
                });
    
                currentFavBtnActiveMobile.addEventListener('click', function(){
                    let xhr = new XMLHttpRequest();
    
                    xhr.open('POST', '/favorite/remove');
          
                    xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
          
                    xhr.onload = () => {
                      if (xhr.status !== 200) {
                        // console.warn('favoriteMobileMech ajax error');
                        // errorBannerMobileRemove();
                        // errorBannerMobile();
                      }else {
                        const jsonResponse = JSON.parse(xhr.responseText);;
                          
                        let countFavFromServer = --jsonResponse.count;
                        mobileCartHeaderFavSpan.innerText = countFavFromServer;
          
                        currentFavBtnActiveMobile.style.display = 'none';
                        currentFavBtnMobile.style.display = 'block';
                        // mobileFavoriteTooltip();
                        stickyHeaderMobileFavCountUpdateInCart();
                      }   
                    }
                    
                    xhr.send('key=' + favBtnKey);
                });
            }
        }
    }
    cartMobileFavBtnMech()
    
    //refresh buttons mech on Desktop
    function cartDesktopRefreshButtons(){
        const refreshBtn = document.querySelector('.cart__refresh-btn');
        const refreshBtnFromStarterPrice = document.querySelector('.cart-desktop-starter-price__refresh-btn');
    
        if(refreshBtn === null || refreshBtnFromStarterPrice === null){
            // console.log('all gone');
        }else{
            refreshBtn.addEventListener('click', function(e){
                e.preventDefault();
                document.location.reload();
            })
            refreshBtnFromStarterPrice.addEventListener('click', function(e){
                e.preventDefault();    
                document.location.reload();
            })
        }
    }
    cartDesktopRefreshButtons()
     
    //mechs for disabled cards
    function cartDesktopProductDisabledCard(){
        const disabledDesktopProductCard = document.querySelectorAll('.cart-desktop-product-disabled');
        let desktopCartHeaderSpan = document.querySelector('.header-cart-desktop__shopping-cart span');
    
        //check emptiness of cart
        function cartDesktopCheckProductList(){
            let cartDesktopProductsList = document.querySelector('.cart__desktop-products-inner');
            let firstProductInTheList = cartDesktopProductsList.querySelector('li');
            if(firstProductInTheList === null){
                document.location.reload();
            }else{
                // console.log('something here, in the cart');
            }
        }
    
        if(disabledDesktopProductCard === null){
    
        }else{
            for(let i = 0;i < disabledDesktopProductCard.length; i++){
                const desktopProductCardFavoriteBtn = disabledDesktopProductCard[i].querySelector('.cart-desktop-product__favorite');
                const desktopProductCardRemoveBtn = disabledDesktopProductCard[i].querySelector('.cart-desktop-product__delete');
                const desktopProductCardButtonsBlock = disabledDesktopProductCard[i].querySelector('.cart-desktop-product-disabled__action');
    
                const parentblock = desktopProductCardButtonsBlock.parentElement;
                let key = parentblock.dataset.key; 
                let availability = parentblock.dataset.availability;
    
                desktopProductCardRemoveBtn.addEventListener('click', function(){
                    let closestSeparator = parentblock.nextElementSibling;
    
                    const params = new URLSearchParams();
                    params.set('id', key);
    
                    let xhr = new XMLHttpRequest();
            
                    xhr.open('POST', '/cart/remove');
                    xhr.responseType = 'json';
    
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                    xhr.onload = () => {
                      if (xhr.status !== 200) {
                        // console.warn('offerCardDesktopquantityDeleteButtonMech ajax error');
                      }else{
                        
                        const response = xhr.response;
                        let countFromCart = response.count; 
                        desktopCartHeaderSpan.style.display = 'block';
                        desktopCartHeaderSpan.innerText = countFromCart;
                        
                        disabledDesktopProductCard[i].style.transition = '0.4s';
                        disabledDesktopProductCard[i].style.transform = 'translate(-130%, 0)';
    
                        function parentBlockWithSeparatorDisapear(){
                            disabledDesktopProductCard[i].remove();
                            closestSeparator.remove();
                            cartDesktopCheckProductList();
                        }
                        setTimeout(parentBlockWithSeparatorDisapear, 500);
                      }
                    }
    
                    xhr.send(params);
                });
            }
        }
    }
    cartDesktopProductDisabledCard();
    
    //ios phone number fix
    function cartHeaderNumberFix(){
        const mobileCartHeaderPhone = document.querySelector('.header-cart-mobile__phone');
        if(mobileCartHeaderPhone === null){
    
        }else{
            mobileCartHeaderPhone.innerHTML = `+7 (495) &zwj;649 60 60`;
        }
    }
    cartHeaderNumberFix();
    
    
    //cart-delivery cart-delivery__option-inner MARGIN without TITLE
    function cartDeliveryOptionInnerWithOutTitleMargin(){
        const optionInners = document.querySelectorAll('.cart-delivery__option-inner');
        
        if(optionInners === null){
    
        }else{
            optionInners.forEach( item => {
                const optionInnerTitle = item.querySelector('.cart-delivery__option-info-title');
                const optionInnerInfo = item.querySelector('.cart-delivery__info');
    
                if(optionInnerTitle === null){
                    optionInnerInfo.style.margin = "0px 0 0 25px";
                }else{
    
                }
            });
           
        }
    }
    cartDeliveryOptionInnerWithOutTitleMargin();
    
    
    //from Back-end || formSubmit
    function cartFormSubmit(formName, link) {
        event.preventDefault();
        let form = '';
        if (formName !== '') {
          form = document.forms[formName];
        } else {
          form = document.forms[link.getAttribute("data-form")];
        }
        if (link !== undefined) {
          form.setAttribute("action", link.getAttribute("href"));
        }
        form.submit();
    }
    
    function suBmitFormSwitchForDeliverySection(){
        const deliveryTabRadio = document.querySelectorAll(".cart-delivery__tab-input");
        const headerCartNavItem = document.querySelectorAll(".header-cart-desktop .header-cart-desktop__nav-item a");
        if(deliveryTabRadio === null){
            // console.log('it`s not cart page!');
        } else {
            for(let i = 0;i < deliveryTabRadio.length; i++) { 
                if(deliveryTabRadio[i].type=="radio") { 
                  deliveryTabRadio[i].onchange=function() { 
                      var formId = this.getAttribute("id").replace(/[^0-9]/g,'');
                      headerCartNavItem.forEach(
                        function(x){ 
                          x.setAttribute("data-form", 'shop_order_form_'+formId);
                        }
                      )
                    }
                }
            }
        }
    }
    suBmitFormSwitchForDeliverySection();
    
    //cart-confirmation disabled button
    function cartConfirmationDisabledBtn(){
        const nextBtnDisabled = document.querySelectorAll('.cart-confirmation-send-order-btn--disabled');
    
        if(nextBtnDisabled === null){
    
        }else{
            for(let i = 0;i < nextBtnDisabled.length; i++){
                nextBtnDisabled[i].addEventListener('click', function(e){
                    e.preventDefault();
                });
    
                const disabledNextBtnTip = nextBtnDisabled[i].querySelector('.cart-confirmation-send-order-btn--disabled-tip')
    
                if(disabledNextBtnTip === null){
    
                }else{
                    nextBtnDisabled[i].addEventListener('mouseover', function(e){
                        disabledNextBtnTip.style.opacity = '1';
                        disabledNextBtnTip.style.visibility = 'visible';
                    });
                    
                    nextBtnDisabled[i].addEventListener('mouseout', function(e){
                        disabledNextBtnTip.style.opacity = '0';
                        disabledNextBtnTip.style.visibility = 'hidden';
                    });
                }
            }
        }
    }
    
    cartConfirmationDisabledBtn()
    function offerCardMobileInfoOpen() {
        let mobileListItem = document.querySelectorAll('.mobile-list-item');
    
        if (mobileListItem === null) {
        // console.log("mobileListItem left HTML");
      } else {
          for(let i = 0; i < mobileListItem.length; i++){
              let mobileProp = mobileListItem[i].querySelector(".mobile-properties");
              let mobileInfoBlock = mobileListItem[i].querySelector(".mobile-info");
              let mobileInfoBlockClose = mobileListItem[i].querySelector(".mobile-info__items-close");
    
              if (mobileProp === null || mobileInfoBlock === null || mobileInfoBlockClose === null) {
                // console.log("offerCard components left html");
          } else {
              mobileProp.addEventListener("click", function(){
                mobileInfoBlock.classList.toggle("mobile-info--on");
              });
    
              mobileInfoBlockClose.addEventListener("click", function() {
                mobileInfoBlock.classList.remove("mobile-info--on");
              });
          }
              
        }
    
      }
    
    }
    
    offerCardMobileInfoOpen();
    
    function offerCardMobileOpen() {
        let offerCardMobile = document.querySelectorAll(".offer-card-mobile");
    
        if (offerCardMobile === null) {
            // console.log("offerCardMobile left HTML");
          } else {
            for(let i = 0; i < offerCardMobile.length; i++){
                let offerCardMobileOpenBtn = offerCardMobile[i].querySelector(".short-panel-mobile__open");
                let fullMobileCard = offerCardMobile[i].querySelector(".full-mobile-card");
                let fullMobileCardCloseBtn = offerCardMobile[i].querySelector(".mobile-filter__close");
                let shortOptionBlockMobile = offerCardMobile[i].querySelector(".short-options-mobile");
                if (offerCardMobileOpenBtn === null || fullMobileCard === null || fullMobileCardCloseBtn === null || shortOptionBlockMobile === null) {
                    // console.log("offerCard components left html");
              } else {
    
                offerCardMobileOpenBtn.addEventListener("click", function() {
                    fullMobileCard.classList.add("full-mobile-card--on");
                    offerCardMobileOpenBtn.style.visibility = 'hidden';
                    offerCardMobileOpenBtn.scrollIntoView({behavior: "smooth"});
                });
    
                fullMobileCardCloseBtn.addEventListener("click", function() {
                    offerCardMobileOpenBtn.style.visibility = 'visible';
                    fullMobileCard.classList.remove("full-mobile-card--on");
                    shortOptionBlockMobile.scrollIntoView({behavior: "smooth"});
                });
    
             }
    
            }
        }
    }
    
    offerCardMobileOpen();
    
    //Separator
    function hideFirstSeparatorOnMobile() {
      let firstSeparator = document.querySelector('.offer-card-mobile-separator');
      // console.log(firstSeparator);
    
      if (firstSeparator === null) {
    
        // console.log("firstSeparator left HTML");
    
      } else {
        firstSeparator.style.display = 'none';
      }
    
    }
    
    hideFirstSeparatorOnMobile();
    
    //benner error on Desktop
    function errorBannerDesktop(){
      let body = document.querySelector('body');
      let errorBanner = document.createElement('div');
      errorBanner.classList.add('offers-catalog__error-banner-desktop');
      errorBanner.innerText = 'Упс! Что-то пошло не так, попробуйте позже!';
      body.appendChild(errorBanner);
    
      function errorBannerAppear(){
        errorBanner.style.bottom = '35px';
      }
      setTimeout(errorBannerAppear, 200);
    
      function errorBannerDisappear(){
        errorBanner.style.left = '-700px';
      }
      setTimeout(errorBannerDisappear, 7000);
    }
    
    //benner error on Mobile
    function errorBannerMobile(){
      let body = document.querySelector('body');
      let errorBanner = document.createElement('div');
      errorBanner.classList.add('offers-catalog__error-banner-mobile');
      errorBanner.innerText = 'Упс! Что-то пошло не так, попробуйте позже!';
      body.appendChild(errorBanner);
    
      function errorBannerAppear(){
        errorBanner.style.top = '0';
      }
      setTimeout(errorBannerAppear, 200);
    
      function errorBannerDisappear(){
        errorBanner.style.top = '-150px';
      }
      setTimeout(errorBannerDisappear, 7000);
    }
    
    
    function errorBannerDesktopRemove(){
      let errorBannerDesktop = document.querySelector('.offers-catalog__error-banner-desktop');
      if(errorBannerDesktop === null){
    
      }else{
        errorBannerDesktop.remove();
      }
    }
    
    function errorBannerMobileRemove(){
      let errorBannerMobile = document.querySelector('.offers-catalog__error-banner-mobile');
      if(errorBannerMobile === null){
    
      }else{
        errorBannerMobile.remove();
      }
    }
    
    //favorite button tooltip mechanic 
    function mobileFavoriteTooltip(){
      let favoriteTooltip = document.createElement('div');
      let body = document.querySelector('body');
    
      favoriteTooltip.classList.add('mobile-buy__favorite-btn-tooltip')
      favoriteTooltip.innerHTML = `
                      <a href="/favorite">
                        <div class="mobile-buy__favorite-btn-tooltip-wrapper">
                            Товар успешно добавлен в избранное. Нажмите, чтобы перейти
                        </div>
                      </a>
      `
    
      body.appendChild(favoriteTooltip);
    
      function mobileFavoriteTooltipSmoothAppearance(){
        favoriteTooltip.style.top = '0';
      }
    
      function mobileFavoriteTooltipCloseToTimer(){
        favoriteTooltip.style.top = '-150px';
      }
    
      window.addEventListener('scroll', function(e){
        let scrollPos  = window.scrollY;
        // console.log(scrollPos);
    
        if (scrollPos < 200) {
          favoriteTooltip.style.top = '-150px';
        } 
      }); 
    
      setTimeout(mobileFavoriteTooltipSmoothAppearance, 300)
      setTimeout(mobileFavoriteTooltipCloseToTimer, 7000)
    }
    // Remove favorite button mechanic on Mobile
    function mobileFavoriteTooltipRemove(){
      let favoriteTooltip = document.createElement('div');
      let body = document.querySelector('body');
    
      favoriteTooltip.classList.add('mobile-buy__favorite-btn-tooltip')
      favoriteTooltip.innerHTML = `
                      <a href="/favorite">
                        <div class="mobile-buy__favorite-btn-tooltip-wrapper">
                            Товар удален из избранного
                        </div>
                      </a>
      `
      favoriteTooltip.style.height = '60px';
    
      body.appendChild(favoriteTooltip);
    
      function mobileFavoriteTooltipSmoothAppearance(){
        favoriteTooltip.style.top = '0';
      }
    
      function mobileFavoriteTooltipCloseToTimer(){
        favoriteTooltip.style.top = '-150px';
      }
    
      window.addEventListener('scroll', function(e){
        let scrollPos  = window.scrollY;
        // console.log(scrollPos);
    
        if (scrollPos < 200) {
          favoriteTooltip.style.top = '-150px';
        } 
      }); 
    
      setTimeout(mobileFavoriteTooltipSmoothAppearance, 300)
      setTimeout(mobileFavoriteTooltipCloseToTimer, 7000)
    }
    //favorite button mechanic on Mobile ✰2  
    function offerCardFavoriteBtnMobileAdd() {
      let shortOptionsMobile = document.querySelectorAll('.short-options-mobile');
      let mobileHeaderFavoriteCounter = document.querySelector('.user-mobile__favorites span');
    
      if (shortOptionsMobile === null) {
        // console.log('no offers on page');
      } else{
        for(let i = 0; i < shortOptionsMobile.length; i++){
          let currentFavBtn = shortOptionsMobile[i].querySelector('.short-options-mobile__favorite');
          let currentFavBtnActive = shortOptionsMobile[i].querySelector('.short-options-mobile__favorite-active');
          let favBtnKey = currentFavBtn.dataset.key;
    
          currentFavBtn.addEventListener('click', function(){
            offerCardFavoriteTooltipRemover();
    
            function sendFavBtnKeyToSeverOnMobile() {
              let xhr = new XMLHttpRequest();
    
              xhr.open('POST', '/favorite/add');
    
              xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
    
              xhr.onload = () => {
                if (xhr.status !== 200) {
                  console.warn('favoriteMobileMech ajax error');
                  errorBannerMobileRemove();
                  errorBannerMobile();
                }else {
                  const jsonResponse = JSON.parse(xhr.responseText);;
                    
                  let countFavFromServer = ++jsonResponse.count;
                    // console.warn(countFromFav)
                  mobileHeaderFavoriteCounter.innerText = countFavFromServer;
    
                  currentFavBtnActive.style.display = 'block';
                  mobileFavoriteTooltip();
                  stickyHeaderMobileFavCountUpdate();
                }   
              }
              
              xhr.send('key=' + favBtnKey);
            }                  
            
            setTimeout(function(){
              sendFavBtnKeyToSeverOnMobile();
            }, 200);
    
          });
        }
      }
    }
    
    offerCardFavoriteBtnMobileAdd();
    
    function offerCardFavoriteBtnMobileRemove() {
      let shortOptionsMobile = document.querySelectorAll('.short-options-mobile');
      let mobileHeaderFavoriteCounter = document.querySelector('.user-mobile__favorites span');
    
      if (shortOptionsMobile === null) {
        // console.log('no offers on page');
      } else{
        for(let i = 0; i < shortOptionsMobile.length; i++){
          let currentFavBtn = shortOptionsMobile[i].querySelector('.short-options-mobile__favorite');
          let currentFavBtnActive = shortOptionsMobile[i].querySelector('.short-options-mobile__favorite-active');
      
          let activeFavBtnKey = currentFavBtnActive.dataset.key;
      
          currentFavBtnActive.addEventListener('click', function(){
            offerCardFavoriteTooltipRemover();
    
            function sendFavBtnKeyToSeverOnMobileRemove(){
              let xhr = new XMLHttpRequest();
    
              xhr.open('POST', '/favorite/remove');
    
              xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
    
              xhr.onload = () => {
                if (xhr.status !== 200) {
                  console.warn('favoriteMobileMech ajax error');
                  errorBannerMobileRemove();
                  errorBannerMobile();
                }else {
                  // currentPreloader.style.display = 'none';
                  const jsonResponse = JSON.parse(xhr.responseText);;
                    
                  let countFavFromServer = --jsonResponse.count;
                  // console.warn(countFromFav)
                  mobileHeaderFavoriteCounter.innerText = countFavFromServer;
    
                  mobileFavoriteTooltipRemove();
                  stickyHeaderMobileFavCountUpdate();
    
                  currentFavBtnActive.style.display = 'none';
                }   
              }
    
              xhr.send('key=' + activeFavBtnKey);
            }
    
            setTimeout(function(){
              sendFavBtnKeyToSeverOnMobileRemove();
            }, 200);
      
          });
        }
      }
    }
    
    offerCardFavoriteBtnMobileRemove();
    
    //tooltip remover
    function offerCardFavoriteTooltipRemover(){
      let tooltips = document.querySelectorAll('.mobile-buy__favorite-btn-tooltip');
    
      if(tooltips === null){
    
      }else{
        tooltips.forEach(item => {
          item.remove();
        })
      }
    }
    
    //favorite button mechanic on Desktop ✰1
    function offersCardDesktopFavoriteBtnAdd() {
      let shortOptionsDesktop = document.querySelectorAll('.short-options-desktop');
      let body = document.querySelector('.page-body');
      let mainHeaderFavoriteCounter = document.querySelector('.user__favorites span');
      
      if (shortOptionsDesktop === null) {
          // console.log('favBtn left HTML');
      } else {
          for(let i = 0; i < shortOptionsDesktop.length; i++) {
          let curentFavBtn = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite');
          let curentFavBtnActive = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite-active');
          let currentTooltip = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite-tooltip');
          // let currentTooltipIcon = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite-tooltip-icon');
          let currentTooltipText = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite-tooltip-text');
      
          let currentOffer = shortOptionsDesktop[i].parentElement;
          let imageOfCurrentOffer = currentOffer.querySelector('.short-desktop-card__picture');
          let titleOfCurrentOffer = currentOffer.querySelector('.short-card-description__title');
      
          curentFavBtn.addEventListener('mouseover', function(){
              currentTooltip.style.display = 'flex';
          });
      
          curentFavBtn.addEventListener('mouseout', function(){
              currentTooltip.style.display = 'none';
          });
      
          let favBtnKey = curentFavBtn.dataset.key;
      
          curentFavBtn.addEventListener('click', function(){
              favBannerDesktopClear();
              currentTooltip.style.display = 'flex';
              // currentTooltipIcon.classList.add('short-options-desktop__favorite-tooltip-icon--load');
              currentTooltipText.innerHTML = `Добавляем . . .`;
      
              function sendFavBtnKeyToServer() {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/favorite/add');
                
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
                xhr.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                  // currentTooltipIcon.classList.remove('short-options-desktop__favorite-tooltip-icon--load');
                  curentFavBtnActive.classList.add('short-options-desktop__favorite-active--on');
      
                  let favBanner = document.createElement("div");
                  favBanner.classList.add('favorite-banner');
                  body.appendChild(favBanner);
      
                  let imgForFavBtn = imageOfCurrentOffer.innerHTML;
                  let titleForFavBtn = titleOfCurrentOffer.innerHTML;
                  //dynamic data from cart
                  const jsonResponse = JSON.parse(xhr.responseText);
                  
                  let countFromFav = ++jsonResponse.count;
                  // console.warn(countFromFav)
                  mainHeaderFavoriteCounter.innerText = countFromFav;
    
                  // Вариативное окончание товара
                  function endingGenerate(int, array) {
                    return (array = array || ['товар', 'товара', 'товаров']) && array[(int % 100 > 4 && int % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(int % 10 < 5) ? int % 10 : 5]];
                  }
    
                  const endingGenerated = endingGenerate(countFromFav);
      
                  favBanner.innerHTML = `
                              <div class="favorite-banner__inner">
      
                              <div class="favorite-banner__picture">
                                  ${imgForFavBtn}
                              </div>
      
                              <div class="favorite-banner__info-wrapper">
                                  <div class="favorite-banner__product-title">
                                      ${titleForFavBtn}
                                  </div>
      
                                  <div class="favorite-banner__info-text">
                                      Добавлен в Избранное
                                  </div>
      
                                  <div class="favorite-banner__list-info">
                                      в списке ${countFromFav} ${endingGenerated}
                                  </div>
                              </div>
      
                              <div class="favorite-banner__action">
                                  <div class="favorite-banner__btn">
                                      <a href="/favorite">Перейти в Избранное</a>
                                  </div>
                                  <div class="favorite-banner__close"></div>
                              </div>
      
                              </div>
                  `;
      
                  let favBtnClose = document.querySelector('.favorite-banner__close');
      
                  favBtnClose.addEventListener('click', function(){
                      favBanner.remove();
                  });
      
                  window.addEventListener('scroll', function(e){
                      let scrollPos  = window.scrollY;
          
                      if (scrollPos < 600) {
                      favBannerDesktopClear();
                      }
                  }); 
      
                  function favBannerSmoothAppearenceOn(){
                      favBanner.style.top = '0';
                  }
      
                  function favBannerSmoothAppearenceOff(){
                      favBanner.style.top = '-150px';
                  }
      
      
                  stickyHeaderDesktopFavoriteCountUpdate();
                  setTimeout(favBannerSmoothAppearenceOn, 300);
                  setTimeout(favBannerSmoothAppearenceOff, 4000);
    
                  }else if(this.readyState != 4 && this.status != 200){
    
                    errorBannerDesktopRemove();
                    errorBannerDesktop();
                    currentTooltip.style.visibility = 'hidden';
                  }
                }
        
                xhr.send('key=' + favBtnKey);
              }
              sendFavBtnKeyToServer();
          });
        }
      }
    }
    offersCardDesktopFavoriteBtnAdd(); 
    
    //btns tips in special-offers on index page
    function specialOfferFavBtnTooltip(){
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
    			}
    		}
    	}
    }
    
    specialOfferFavBtnTooltip();
    
    //Favorite button mech for Special Offers On mainPage *in slider
    function specialOfferFavoriteMech(){
      let favBtnsDefaultList = document.querySelectorAll('.special-offer-card__favorite--default');
    	let favBtnsActiveList = document.querySelectorAll('.special-offer-card__favorite--active');
      let mainHeaderFavoriteCounter = document.querySelector('.user__favorites span');
    
    	if (favBtnsDefaultList === null){
    		// console.log('no special offers on the page');
    	} else{
    
        for(let i = 0;i < favBtnsDefaultList.length; i++){
    
          favBtnsDefaultList[i].addEventListener('click', function(e){
            let currentFavBtn = this;
            let currentActiveBtn = currentFavBtn.nextElementSibling;
            let favBtnKey = currentFavBtn.dataset.key;
    
            function sendSpecFavBtnKeyToServer() {
              const xhr = new XMLHttpRequest();
              xhr.open('POST', '/favorite/add');
              
              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      
              xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                // currentTooltipIcon.classList.remove('short-options-desktop__favorite-tooltip-icon--load');
        				currentActiveBtn.classList.add('special-offer-card__favorite--active-on');
    
                //dynamic data from cart
                const jsonResponse = JSON.parse(xhr.responseText);
                let countFromFav = ++jsonResponse.count;
                mainHeaderFavoriteCounter.innerText = countFromFav;
    
                stickyHeaderDesktopFavoriteCountUpdate();
                }else if(this.readyState != 4 && this.status != 200){
    
                  errorBannerDesktopRemove();
                  errorBannerDesktop();
                  currentTooltip.style.visibility = 'hidden';
                }
              }
      
              xhr.send('key=' + favBtnKey);
            }
            sendSpecFavBtnKeyToServer();
          });
        }
    
        for(let i = 0; i < favBtnsActiveList.length; i++){
    
          favBtnsActiveList[i].addEventListener('click', function(e){
            
            let currentActiveFavBtn = this;
            let favBtnKey = currentActiveFavBtn.dataset.key;
    
            function sendSpecFavBtnKeyToServer() {
              const xhr = new XMLHttpRequest();
              xhr.open('POST', '/favorite/remove');
              
              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      
              xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                // currentTooltipIcon.classList.remove('short-options-desktop__favorite-tooltip-icon--load');
        				currentActiveFavBtn.classList.remove('special-offer-card__favorite--active-on');
    
                //dynamic data from cart
                const jsonResponse = JSON.parse(xhr.responseText);
                let countFromFav = --jsonResponse.count;
                mainHeaderFavoriteCounter.innerText = countFromFav;
    
                stickyHeaderDesktopFavoriteCountUpdate();
                }else if(this.readyState != 4 && this.status != 200){
    
                  errorBannerDesktopRemove();
                  errorBannerDesktop();
                  currentTooltip.style.visibility = 'hidden';
                }
              }
              xhr.send('key=' + favBtnKey);
            }
            sendSpecFavBtnKeyToServer();
          });
        }
      }
    }
    
    specialOfferFavoriteMech()
    
    //Favorite button mech for Special Offers in Catalog
    
    
    function offersCardDesktopFavoriteBtnRemove() {
      let shortOptionsDesktop = document.querySelectorAll('.short-options-desktop');
      let body = document.querySelector('.page-body');
      let mainHeaderFavoriteCounter = document.querySelector('.user__favorites span');
    
      if (shortOptionsDesktop === null) {
        // console.log('favBtn left HTML');
      } else {
        for(let i = 0; i < shortOptionsDesktop.length; i++) {
          let curentFavBtn = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite');
          let curentFavBtnActive = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite-active');
          let currentTooltip = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite-tooltip');
          // let currentTooltipIcon = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite-tooltip-icon');
          let currentTooltipText = shortOptionsDesktop[i].querySelector('.short-options-desktop__favorite-tooltip-text');
    
          let currentOffer = shortOptionsDesktop[i].parentElement;
          let imageOfCurrentOffer = currentOffer.querySelector('.short-desktop-card__picture');
          let titleOfCurrentOffer = currentOffer.querySelector('.short-card-description__title');
    
          curentFavBtnActive.addEventListener('mouseover', function(){
            currentTooltip.style.display = 'flex';
            currentTooltipText.innerHTML = `Удалить из Избранного`;
          });
    
          curentFavBtnActive.addEventListener('mouseout', function(){
            currentTooltip.style.display = 'none';
          });
    
          let favBtnActiveKey = curentFavBtnActive.dataset.key;
    
          curentFavBtnActive.addEventListener('click', function(){
            favBannerDesktopClear();
            currentTooltip.style.display = 'flex';
            // currentTooltipIcon.classList.add('short-options-desktop__favorite-tooltip-icon--load');
            currentTooltipText.innerHTML = `Удаляем . . .`;
    
            function sendFavBtnKeyToServerRemove() {
              let xhr = new XMLHttpRequest();
    
              xhr.open('POST', '/favorite/remove');
    
              xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
    
              xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  // currentTooltipIcon.classList.remove('short-options-desktop__favorite-tooltip-icon--load');
                  curentFavBtnActive.classList.remove('short-options-desktop__favorite-active--on');
                  currentTooltipText.innerHTML = `Добавить в Избранное`;
    
                  let favBanner = document.createElement("div");
                  favBanner.classList.add('favorite-banner');
                  body.appendChild(favBanner);
    
                  let imgForFavBtn = imageOfCurrentOffer.innerHTML;
                  let titleForFavBtn = titleOfCurrentOffer.innerHTML;
    
                  const jsonResponse = JSON.parse(xhr.responseText);;
                  
                  let countFromFav = --jsonResponse.count;
    
                  mainHeaderFavoriteCounter.innerText = countFromFav;
    
                    // Вариативное окончание товара
                  function endingGenerate(int, array) {
                    return (array = array || ['товар', 'товара', 'товаров']) && array[(int % 100 > 4 && int % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(int % 10 < 5) ? int % 10 : 5]];
                  }
    
                  const endingGenerated = endingGenerate(countFromFav);
    
                  favBanner.innerHTML = `
                              <div class="favorite-banner__inner">
    
                                <div class="favorite-banner__picture">
                                    ${imgForFavBtn}
                                </div>
    
                                <div class="favorite-banner__info-wrapper">
                                    <div class="favorite-banner__product-title">
                                      ${titleForFavBtn} удален из избранного
                                    </div>
    
                                    <div class="favorite-banner__info-text">
                                        
                                    </div>
    
                                    <div class="favorite-banner__list-info">
                                        в списке ${countFromFav} ${endingGenerated}
                                    </div>
                                </div>
    
                                <div class="favorite-banner__action">
                                    <div class="favorite-banner__btn" style="opacity: 0; pointer-events: none;">
                                        <a href="">Перейти в Избранное</a>
                                    </div>
                                    <div class="favorite-banner__close"></div>
                                </div>
    
                              </div>
                  `;
    
                  let favBtnClose = document.querySelector('.favorite-banner__close');
    
                  favBtnClose.addEventListener('click', function(){
                    favBanner.remove();
                  });
    
                  window.addEventListener('scroll', function(e){
                    let scrollPos  = window.scrollY;
          
                    if (scrollPos < 600) {
                      favBannerDesktopClear();
                    }
                  }); 
    
                  function favBannerSmoothAppearenceOn(){
                    favBanner.style.top = '0';
                  }
    
                  function favBannerSmoothAppearenceOff(){
                    favBanner.style.top = '-150px';
                  }
    
                  setTimeout(favBannerSmoothAppearenceOn, 300);
                  setTimeout(favBannerSmoothAppearenceOff, 3000);
                  
                  stickyHeaderDesktopFavoriteCountUpdate();
    
    
                } else{
    
                  currentTooltipText.innerHTML = `Что-то пошло не так . . .`;
    
                }
              }
    
              xhr.send('key=' + favBtnActiveKey);
            }
    
            sendFavBtnKeyToServerRemove();
          });
        }
      }
    }
    
    offersCardDesktopFavoriteBtnRemove();
    
    //Clear prev favorite banner
    function favBannerDesktopClear(){
      let favBannerDesktop = document.querySelector('.favorite-banner');
    
      if(favBannerDesktop === null){
    
      }else {
        favBannerDesktop.remove();
      }
    }
    
    //MODAL BUY DESKTOP✰
    //Modal storage switcher
    function offerCardDesktopBuyModalLocalStorageSwitcher(){
      let modalPar = localStorage.getItem('modalPar');
    
      if(modalPar === null){
        console.warn('modalParametr are not exist yet! Creating one right one. . .');
        localStorage.setItem('modalPar', 'modalBuy');
      }else if(modalPar === "modalBuy"){
        console.warn('localStorage ModalPar switcher ON');
      }else if(modalPar === "noModal"){
        console.warn('localStorage ModalPar switcher OFF');
      }
    }
    
    //Hiden localStorage clear mech for ninja
    function offerCardDesktopBuyModalLocalStorageSwitcherClear(){
      let stocksItem = document.querySelectorAll('.short-options-desktop__stock');
    
      if(stocksItem === null){
    
      }else{
        console.warn('localStorage cleaner activate just now! 🤖');
    
        stocksItem.forEach(item => {
          item.addEventListener("dblclick", function(){
            localStorage.clear();
            document.location.reload();
            console.warn('localStorage clean for sure! 🤖');
          })
        })
      }
    }
    
    //Modal localStorageHideMech
    function offerCardDesktopBuyModalLocalStorageSwitcherHide(){
      let modalHideInputBlock = document.querySelector('.buy-offer-modal-desktop__hide-input');
      let body = document.querySelector('body');
    
      if(modalHideInputBlock === null){
    
      }else{
    
        let modalHideInputCkeckBox = modalHideInputBlock.querySelector('label');
        if(modalHideInputCkeckBox === null){
     
        }else{
          modalHideInputCkeckBox.addEventListener('click', function(){
            localStorage.setItem('modalPar', 'noModal');
    
            let modalBlockParent = document.querySelector('.buy-offer-modal-desktop');
            let modalBlock = document.querySelector('.buy-offer-modal-desktop__wrapper');
    
            function modalBlockDisapear1(){
              modalBlock.style.left = '53%';
            }
    
            function modalBlockDisapear2(){
              modalBlock.style.left = '-120%';
            }
    
            function parentDisapear(){
              modalBlockParent.style.visibility = 'hidden';
              modalBlockParent.style.display = 'none';
            }
    
            function blockRemove(){
              modalBlockParent.remove()
            }
    
            setTimeout(modalBlockDisapear1, 500);
            setTimeout(modalBlockDisapear2, 800);
            setTimeout(parentDisapear, 900);
    
            setTimeout(function(){
              document.location.reload();
            }, 950)
          })
        }
      }
    }
    
    //Close offer-buy modal
    function offerCardDesktopBuyModalCloseMech(){
      let modalBlockParent = document.querySelector('.buy-offer-modal-desktop');
      let modalBlockCloseBtn = document.querySelector('.buy-offer-modal-desktop__close-btn');
      let modalBlockStayBtn = document.querySelector('.buy-offer-modal-desktop-panel__stay-btn');
      let body = document.querySelector('body');
      let stickyHeaderDesktop = document.querySelector('.sticky-header-desktop');
                   
    
      if(modalBlockParent === null){
    
      }else{
    
        modalBlockCloseBtn.addEventListener('click', function(){
          modalBlockParent.style.display = 'none';
          body.classList.remove('page-body__no-scroll');
          modalBlockParent.remove();
          stickyHeaderDesktop.style.top = '0';
    
          //reset custom quantity value
          localStorage.setItem('customQuantityInputValue', '');
        })
    
        modalBlockStayBtn.addEventListener('click', function(e){
          e.preventDefault();
          modalBlockParent.style.display = 'none';
          body.classList.remove('page-body__no-scroll');
          modalBlockParent.remove();
          stickyHeaderDesktop.style.top = '0';
    
          //reset custom quantity value
          localStorage.setItem('customQuantityInputValue', '');
        })
      }
    }
    
    //Add to cart button Desktop ✰3 
    function offerCardDesktopBuyButtonMech() {
      let offersAcrticle = document.querySelectorAll('article.offer-card-desktop');
      let body = document.querySelector('body');
      let cartBtnDesktopMainHeaderSpan = document.querySelector('.user__shopping-cart span');
    
      if(offersAcrticle === null){
      }else {
        // debugger;
        offerCardDesktopBuyModalLocalStorageSwitcherClear();
        offerCardDesktopBuyModalLocalStorageSwitcher();
     
        for(let i = 0; i < offersAcrticle.length; i++){
          let offerPictureLink = offersAcrticle[i].querySelector('.short-desktop-card__picture');
          let offerPicture = offerPictureLink.querySelector('a');
          let offerVendorCode = offersAcrticle[i].querySelector('.short-card-description__vendor-code');
          let offerTitle = offersAcrticle[i].querySelector('.short-card-description__title');
          let offerFullCardItems = offersAcrticle[i].querySelectorAll('.full-desktop-card__item');
    
          for(let i = 0; i < offerFullCardItems.length; i++){
            let offerManufacturer = offerFullCardItems[i].querySelector('.desktop-properties__manufacturer');
            let offerPrice  = offerFullCardItems[i].querySelector('.desktop-card-item__price');
            let offerbuyBtns  = offerFullCardItems[i].querySelectorAll('.desktop-buy__buy-btn');
            // debugger;
    
            if (offerbuyBtns === null) {
              // "buyBtns left HTML";
            } else {
              let modalPar = localStorage.getItem('modalPar');
              if(modalPar === "modalBuy"){
                for (let i = 0; i < offerbuyBtns.length; i++){
                  offerbuyBtns[i].addEventListener('click', function buyBtnFunc(e) {
                    e.preventDefault();
                    //reset custom quantity value
                    localStorage.setItem('customQuantityInputValue', '');
                    
                    let thisBtn = this;
                    thisBtn.classList.remove('desktop-buy__buy-btn');
                    thisBtn.classList.add('desktop-buy__buy-btn--load');
                    thisBtn.innerHTML = `<div class="desktop-buy__buy-btn-preloader"></div>`;
    
                    let stickyHeaderDesktop = document.querySelector('.sticky-header-desktop');
                    stickyHeaderDesktop.style.top = '-150px';
                    
                    // let key = encodeURIComponent(thisBtn.dataset.key);
                    let key = thisBtn.dataset.key;
                    let availability = thisBtn.dataset.availability;
                    
                    function sendOfferToCart() {
                      const params = new URLSearchParams();
                      params.set('id', key);
    
                      let xhr = new XMLHttpRequest();
              
                      xhr.open('POST', '/cart/add');
                      xhr.responseType = 'json';
    
                      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                      xhr.onload = () => {
                        if (xhr.status !== 200) {
                          console.warn('offerCardDesktopBuyButtonMech ajax error');
                          errorBannerDesktopRemove();
                          errorBannerDesktop();
                          thisBtn.classList.remove('desktop-buy__buy-btn--load');
                          thisBtn.classList.add('desktop-buy__buy-btn');
                          thisBtn.innerHTML = ` `;
                        }else{
                          const response = xhr.response;
                          let currentPreloader = thisBtn.querySelector('.desktop-buy__buy-btn-preloader');
                          
                          thisBtn.classList.remove('desktop-buy__buy-btn--load');
                          thisBtn.classList.add('desktop-buy__buy-btn');
                          thisBtn.innerHTML = ` `;
                          //init parent + add tooltip
    
                          let parentBuyBlockDesktop = thisBtn.parentElement;  
                          let currentFastBtn = parentBuyBlockDesktop.querySelector('.desktop-buy__fast-buy-btn');
                          let desktopCardItemInner = parentBuyBlockDesktop.parentElement;
                          //Availability sign of offer
                          let offerCardAvailableSign = desktopCardItemInner.querySelector('.desktop-description__shop');
                          //Hide buttons
                          thisBtn.style.display = 'none';
                          currentFastBtn.style.display = 'none';
    
                          //dynamic data from cart
                          let countFromCart = response.count;
                          cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                          cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                          // console.warn(cartBtnDesktopMainHeaderSpan);
                          stickyHeaderDesktopCartCountUpdate();
    
                          
                           //Add quantity btns instead buy btn
                          let quantityParent = document.createElement('div');
                          quantityParent.classList.add('desktop-buy-quantity');
    
                          let quantityCustomParent = document.createElement('div');
                          quantityCustomParent.classList.add('desktop-buy-quantity--custom');
                          
                          quantityParent.innerHTML = `
                            <div class="desktop-buy-quantity__btn-minus" data-key="${key}"></div>
                            <input class="desktop-buy-quantity__default-input" placeholder="1">
                            <div class="desktop-buy-quantity__btn-plus" data-key="${key}"></div>
                          `;
    
                          quantityCustomParent.innerHTML = `
                            <div class="desktop-buy-quantity__back-btn"></div>
    
                            <div class="desktop-buy-quantity__custom-input-wrapper">
                              <input class="desktop-buy-quantity__custom-input" placeholder="1" type = "number" maxlength = "3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                              <a class="desktop-buy-quantity__buy-btn"></a>
                            </div>
                          `;
    
                          parentBuyBlockDesktop.appendChild(quantityParent);
                          parentBuyBlockDesktop.appendChild(quantityCustomParent);
    
                          const afterBuyMinusButton = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__btn-minus');
                          const afterBuyInput = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__default-input');
                          const afterBuyPlusButton = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__btn-plus');
                          const afterBuyQuantityBuyButton = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__buy-btn');
    
                          //NO modal buy Mechanics!!! - Mechs in offer-desktop-card
                          afterBuyMinusButton.addEventListener('click', function(){
                             //Mechanic after click on Minus button
                            if(afterBuyInput.placeholder == '1'){
    
                              const params = new URLSearchParams();
                              params.set('id', key);
              
                              let xhr = new XMLHttpRequest();
                      
                              xhr.open('POST', '/cart/remove');
                              xhr.responseType = 'json';
            
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                              xhr.onload = () => {
                                if (xhr.status !== 200) {
                                  // console.warn('offerCardDesktopquantityDeleteButtonMech ajax error');
                                }else{
                                  
                                  const response = xhr.response;
                                  //dynamic data from cart
                                  let countFromCart = response.count;
                                  cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                  cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                  console.warn(cartBtnDesktopMainHeaderSpan);
                                  stickyHeaderDesktopCartCountUpdate();
                                  
                                  //Quantity + - hidden
                                  quantityParent.remove();
                                  quantityCustomParent.remove();
                                  //Fast buy & buy btn onn
                                  currentFastBtn.style.display = 'block';
                                  thisBtn.style.display = 'block';
                                }
                              }
    
                              xhr.send(params);
                            }else{
    
                              const params = new URLSearchParams();
                              params.set('id', key);
              
                              const xhr = new XMLHttpRequest();
                              xhr.open('POST', '/cart/reduce');
                              xhr.responseType = 'json';
              
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                              xhr.onload = () => {
                                if (xhr.status !== 200) {
                                  console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                                }else{
                                //  If 1 offer in afterBuyInputBlock checking
                                  const response = xhr.response;
                                  let countFromCart = response.count; 
                                  cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                  cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                  console.warn(cartBtnDesktopMainHeaderSpan);
                                  stickyHeaderDesktopCartCountUpdate();
                                  --afterBuyInput.placeholder;
      
                                  afterBuyPlusButton.classList.remove('desktop-buy-quantity__btn-plus--disable');
                                  afterBuyPlusButton.classList.add('desktop-buy-quantity__btn-plus');
                                  afterBuyInput.style.pointerEvents = 'auto';
                                }
                              }
              
                              xhr.send(params);
                            }
                          });
    
                          afterBuyPlusButton.addEventListener('click', function(){
                           let afterBuyInput = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__default-input');
                           let afterBuyInputPlaceholder = afterBuyInput.placeholder;
    
                           if(availability == '1'){
                            offerCardAvailableSign.classList.add('desktop-description__shop--alert');
    
                              function offerCardAvailableSignAlertDisapear(){
                                offerCardAvailableSign.classList.remove('desktop-description__shop--alert');
                              }
                              setTimeout(offerCardAvailableSignAlertDisapear, 7000);
    
                              afterBuyPlusButton.classList.remove('desktop-buy-quantity__btn-plus');
                              afterBuyPlusButton.classList.add('desktop-buy-quantity__btn-plus--disable');
                              afterBuyInput.style.pointerEvents = 'none';
                           }else{
    
                            if(Number(afterBuyInputPlaceholder) < Number(availability)){
                              const params = new URLSearchParams();
                              params.set('id', key);
              
                              const xhr = new XMLHttpRequest();
                              xhr.open('POST', '/cart/add');
                              xhr.responseType = 'json';
              
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
       
                              xhr.onload = () => {
                                if (xhr.status !== 200) {
                                  console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                                }else{
                                 const response = xhr.response;
                                 //dynamic data from cart
                                 let countFromCart = response.count;
                                 cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                 cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                 console.warn(cartBtnDesktopMainHeaderSpan);
                                 stickyHeaderDesktopCartCountUpdate();
       
                                 ++afterBuyInput.placeholder;
                                }
                              }
              
                              xhr.send(params);
                            }else if(Number(afterBuyInputPlaceholder) >= Number(availability)){
                              offerCardAvailableSign.classList.add('desktop-description__shop--alert');
    
                              function offerCardAvailableSignAlertDisapear(){
                                offerCardAvailableSign.classList.remove('desktop-description__shop--alert');
                              }
                              setTimeout(offerCardAvailableSignAlertDisapear, 7000);
    
                              afterBuyPlusButton.classList.remove('desktop-buy-quantity__btn-plus');
                              afterBuyPlusButton.classList.add('desktop-buy-quantity__btn-plus--disable');
                              afterBuyInput.style.pointerEvents = 'none';
                            }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
                              const params = new URLSearchParams();
                              params.set('id', key);
              
                              const xhr = new XMLHttpRequest();
                              xhr.open('POST', '/cart/add');
                              xhr.responseType = 'json';
              
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
       
                              xhr.onload = () => {
                                if (xhr.status !== 200) {
                                  console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                                }else{
                                 const response = xhr.response;
                                 //dynamic data from cart
                                 let countFromCart = response.count;
                                 cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                 cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                 console.warn(cartBtnDesktopMainHeaderSpan);
                                 stickyHeaderDesktopCartCountUpdate();
       
                                 ++afterBuyInput.placeholder;
                                }
                              }
              
                              xhr.send(params);
                            }
                           }
                          });
    
                          afterBuyInput.addEventListener('click', function(){
    
                            if(availability == '1'){
                              //alert
                              offerCardAvailableSign.classList.add('desktop-description__shop--alert');
    
                              function offerCardAvailableSignAlertDisapear(){
                                offerCardAvailableSign.classList.remove('desktop-description__shop--alert');
                              }
                              setTimeout(offerCardAvailableSignAlertDisapear, 7000);
                              afterBuyInput.style.pointerEvents = 'none';
                              
                              afterBuyPlusButton.classList.remove('desktop-buy-quantity__btn-plus');
                              afterBuyPlusButton.classList.add('desktop-buy-quantity__btn-plus--disable');
    
                            }else{
                              quantityParent.style.display = 'none';
                              quantityCustomParent.style.display = 'flex';
    
                              const afterBuyCustomQuantityInput = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__custom-input');
                              const afterBuyCustomQuantityBackBtn = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__back-btn');
    
                              afterBuyCustomQuantityInput.focus();
                              afterBuyCustomQuantityInput.addEventListener('input', function updateCustomInputValue(e){
    
                                const afterBuyCustomQuantityInputValue = afterBuyCustomQuantityInput.value;
    
                                if(Number(afterBuyCustomQuantityInput.value) < Number(availability)){
                                  console.warn(`КАСТОМНЫЙ ИНПУТ МЕНЬШЕ ОСТАТКА осталось ${availability} штук ТОВАР ДОБАВЛЯЕМ`);
                                  // console.warn(`КАСТОМНЫЙ ИНПУТ ${afterBuyCustomQuantityInputValue}`);
                                  // console.warn(`ОСТАТОК ${availability}`);
    
                                  localStorage.setItem('noModalCustomQuantityInputValue', afterBuyCustomQuantityInputValue);
    
                                }else if(Number(afterBuyCustomQuantityInput.value) > Number(availability)){
                                  console.warn(`КАСТОМНЫЙ ИНПУТ БОЛЬШЕ ИЛИ РАВЕН ОСТАТКУ осталось ${availability} штук ТОВАР НЕ ДОБАВЛЯЕМ`);
                                  // console.warn(`КАСТОМНЫЙ ИНПУТ ${afterBuyCustomQuantityInputValue}`);
                                  // console.warn(`ОСТАТОК ${availability}`);
                                  offerCardAvailableSign.classList.add('desktop-description__shop--alert');
    
                                  function offerCardAvailableSignAlertDisapear(){
                                    offerCardAvailableSign.classList.remove('desktop-description__shop--alert');
                                  }
                                  setTimeout(offerCardAvailableSignAlertDisapear, 7000);
    
                                  afterBuyCustomQuantityInput.value = availability;
                                  localStorage.setItem('noModalCustomQuantityInputValue', availability);
    
                                }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
    
                                  localStorage.setItem('noModalCustomQuantityInputValue', afterBuyCustomQuantityInputValue);
    
                                }
                              });
    
                              afterBuyCustomQuantityBackBtn.addEventListener('click', function(){
                                quantityCustomParent.style.display = 'none';
                                quantityParent.style.display = 'flex';
                              });
                            }
                          });
    
                          afterBuyQuantityBuyButton.addEventListener('click', function(e){
                            e.preventDefault();
    
                            let noModalCustomQuantityInputValue = localStorage.getItem('noModalCustomQuantityInputValue');
    
                            if(noModalCustomQuantityInputValue == ''){
                              // console.warn('noModalCustomQuantityInputValue === empty string');
    
                            }else{
                              // console.warn('noModalCustomQuantityInputValue');
                              // console.warn(noModalCustomQuantityInputValue);
                              let thisBtn = this;
                              thisBtn.classList.remove('desktop-buy-quantity__buy-btn');
                              thisBtn.classList.add('desktop-buy-quantity__buy-btn--load');
                              thisBtn.innerHTML = `<div class="desktop-custom-quantity-buy__buy-btn-preloader"></div>`;
    
                              function sendOfferToCartDesktopCustomQuamnity(){
                                const params = new URLSearchParams();
                                params.set('id', key);
                                params.append('qty', noModalCustomQuantityInputValue);
      
                                let xhr = new XMLHttpRequest();
      
                                xhr.open('POST', '/cart/change');
                                xhr.responseType = 'json';
      
                                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                                xhr.onload = () => {
                                  if (xhr.status !== 200) {
                                    // console.warn('modalCustomQuantityBuyButtonMech ajax error');
                                  } else {
                                    // console.warn('modalCustomQuantityBuyButtonMech ajax SUCCESS');
                                    thisBtn.classList.remove('desktop-buy-quantity__buy-btn--load');
                                    thisBtn.classList.add('desktop-buy-quantity__buy-btn');
                                    thisBtn.innerHTML = ` `;
                                    // dynamic data from cart
                                    const response = xhr.response;
                                    let countFromCart = response.count; 
                                    cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                    cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                    console.warn(cartBtnDesktopMainHeaderSpan);
                                    stickyHeaderDesktopCartCountUpdate();
      
                                    afterBuyInput.placeholder = noModalCustomQuantityInputValue;
    
                                    quantityParent.style.display = 'flex';
                                    quantityCustomParent.style.display = 'none';
                                  }
                                }
      
                                xhr.send(params);
                              }
                              setTimeout(sendOfferToCartDesktopCustomQuamnity, 300);
                            }
                          });
    
    
                          //ModalBuy mech start here
                          let picForModalsOffer = offerPicture.innerHTML;
                          let vendorCodeForModalsOffer = offerVendorCode.innerHTML;
                          let titleForModalsOffer = offerTitle.innerHTML;
                          let manufacturerForModalsOffer = offerManufacturer.innerHTML;
                          let priceForModalsOffer = offerPrice.innerHTML;
    
                          //dynamic data from cart
                          // let countFromCart = response.count;
                          let totalFromCart = response.total;
                          let stringTotalFromCart = totalFromCart.toString();
                          let reTotalFromCart = stringTotalFromCart.replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
    
                          //Вариативное окончание "Товара"
                          function endingGenerate(int, array) {
                            return (array = array || ['товар', 'товара', 'товаров']) && array[(int % 100 > 4 && int % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(int % 10 < 5) ? int % 10 : 5]];
                          }
    
                          const endingGenerated = endingGenerate(countFromCart);
    
                          cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                          cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
    
                          let buyOfferModalDesktop = document.createElement("section");
                          buyOfferModalDesktop.classList.add('buy-offer-modal-desktop');
                          buyOfferModalDesktop.innerHTML = `<div class="buy-offer-modal-desktop__blur"></div>
                                                            <div class="buy-offer-modal-desktop__wrapper">
                                            
                                                                <div class="buy-offer-modal-desktop__title-wrapper">
                                            
                                                                    <div class="buy-offer-modal-desktop__title">Товар успешно добавлен в корзину</div>
                                                                    <div class="buy-offer-modal-desktop__close-btn"></div>
                                            
                                                                </div>
                                            
                                                                <div class="buy-offer-modal-desktop__panel-wrapper">
                                            
                                                                    <!-- product -->
                                                                    <div class="buy-offer-modal-desktop__product buy-offer-modal-desktop-product">
                                            
                                                                        <div class="buy-offer-modal-desktop-product__description">
                                            
                                                                            <div class="buy-offer-modal-desktop-product__picture">
                                                                              <a href="${offerPicture.href}" target="_blank">
                                                                                ${picForModalsOffer}
                                                                              </a>
                                                                             </div>
                                            
                                                                            <div class="buy-offer-modal-desktop-product__description-inner">
                                            
                                                                                <div class="buy-offer-modal-desktop-product__vendor-code">Артикул: <span>${vendorCodeForModalsOffer}</span></div>
                                                                                <a href="${offerPicture.href}" class="buy-offer-modal-desktop-product__title" target="_blank">
                                                                                    ${titleForModalsOffer}
                                                                                </a>
                                                                                <div class="buy-offer-modal-desktop-product__quality-wrapper">
                                            
                                                                                    <div class="buy-offer-modal-desktop-product__manufactor">${manufacturerForModalsOffer}</div>
                                                                                    <div class="buy-offer-modal-desktop-product__quality" style="display:none">genuine</div>
                                            
                                                                                </div>
                                            
                                                                            </div>
                                            
                                                                        </div>
                                            
                                                                        <div class="buy-offer-modal-desktop-product__price-panel">
                                            
                                                                            <div class="buy-offer-modal-desktop-product__price">Цена (шт):<span>${priceForModalsOffer}</span></div>
                                            
                                                                            <!-- default -->
                                                                            <div class="buy-offer-modal-desktop-product__quantity">
                                            
                                                                                <div class="buy-offer-modal-desktop-product__alert" style="display: none;">oсталось: 12 шт</div>
                                                                                <div class="buy-offer-modal-desktop-product__btn-minus"></div>
                                                                                <input class="buy-offer-modal-desktop-product__default-input" placeholder="1" type = "number" maxlength = "3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                                <div class="buy-offer-modal-desktop-product__btn-plus"></div>
                                                                                
                                                                            </div>
    
                                                                            <!-- delete -->
                                                                            <div class="buy-offer-modal-desktop-product__quantity--delete" style="display: none;">
                                            
                                                                                <button class="buy-offer-modal-desktop-product__delete-btn">удалить</button>
                                                                                <button class="buy-offer-modal-desktop-product__back-btn"></button>
                                            
                                                                            </div>
    
                                                                            <!-- custom -->
                                                                            <div class="buy-offer-modal-desktop-product__quantity--custom" style="display: none;">
                                                                                
                                                                                <button class="buy-offer-modal-desktop-product__back-btn customQuantityBackButton"></button>
                                            
                                                                                <div class="buy-offer-modal-desktop-product__custom-input-wrapper">
                                            
                                                                                    <div class="buy-offer-modal-desktop-product__custom-alert" style="display: none;">oсталось: N шт</div>
                                            
                                                                                    <input class="buy-offer-modal-desktop-product__custom-input" placeholder="1" type = "number" maxlength = "3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                                                                                    <a href=""  class="buy-offer-modal-desktop-product__buy-btn"></a>
                                            
                                                                                </div>
                                            
                                                                            </div>
                                            
                                                                        </div>
                                                                    </div>
                                            
                                                                    <!-- panel -->
                                                                    <div class="buy-offer-modal-desktop__panel buy-offer-modal-desktop-panel">
                                                                      
                                                                        <div class="buy-offer-modal-desktop-panel__title">всего <span>${countFromCart}</span> <span class="buy-offer-modal-desktop-panel__title-productWord">${endingGenerated}</span> в корзине на сумму:</div>
                                                                        <span class="buy-offer-modal-desktop-panel__price-output">${reTotalFromCart}</span>
                                            
                                                                        <div class="buy-offer-modal-desktop-panel__btns">
                                                                            <a href="/cart" class="buy-offer-modal-desktop-panel__cart-btn">перейти в корзину</a>
                                                                            <a href="#" class="buy-offer-modal-desktop-panel__stay-btn">продолжить покупки</a>
                                                                        </div>
                                            
                                                                    </div>
                                            
                                                                </div>
                                            
                                                                <div class="buy-offer-modal-desktop__hide-input">
                                                                    <input type="checkbox" class="buy-offer-modal-desktop__hide-input-checkbox" id="buy-offer-modal-desktop__hide-modal" name="hide-modal" value="yes">
                                                                    <label for="buy-offer-modal-desktop__hide-modal">Больше не показывать это окно</label>
                                                                </div>
                                                            </div>   `;
                          
                          body.appendChild(buyOfferModalDesktop);
                          buyOfferModalDesktop.style.display = 'block';
                          body.classList.add('page-body__no-scroll');
    
                          offerCardDesktopBuyModalLocalStorageSwitcherHide();
                          offerCardDesktopBuyModalCloseMech();
                          stickyHeaderDesktopCartCountUpdate();
    
                          //counter mech in afterBuy modal
                          const afterBuyModalMinusButton = document.querySelector('.buy-offer-modal-desktop-product__btn-minus');
                          const afterBuyModalInput = document.querySelector('.buy-offer-modal-desktop-product__default-input');
                          const afterBuyModalPlusButton = document.querySelector('.buy-offer-modal-desktop-product__btn-plus');
                          const afterBuyModalQuantityAlert = document.querySelector('.buy-offer-modal-desktop-product__alert');
    
                          const quantityDeleteButton = document.querySelector('.buy-offer-modal-desktop-product__delete-btn');
                          const quantityBackButton = document.querySelector('.buy-offer-modal-desktop-product__back-btn');
    
                          const customQuantityBuyBtn = document.querySelector('.buy-offer-modal-desktop-product__buy-btn');
    
                          const afterBuyModalQuantityParentBlock = document.querySelector('.buy-offer-modal-desktop-product__quantity');
                          const afterBuyModalQuantityDeleteParentBlock = document.querySelector('.buy-offer-modal-desktop-product__quantity--delete');
                          const afterBuyModalQuantityCustomParentBlock = document.querySelector('.buy-offer-modal-desktop-product__quantity--custom');
                          
                          //Modal buy Mechanics!!!
                          afterBuyModalMinusButton.addEventListener('click', function() {
                            let afterBuyModalCounterBlock = document.querySelector('.buy-offer-modal-desktop-product__default-input');
                            let afterBuyModalCounterBlockPlaceholder = afterBuyModalCounterBlock.placeholder;
                            
                            if(afterBuyModalCounterBlock.placeholder == '1'){
                              // console.warn('ONLY 1 Item in modalCart - no action')
                              afterBuyModalQuantityParentBlock.style.display = 'none';
                              afterBuyModalQuantityDeleteParentBlock.style.display = 'flex';
    
                              //Quantity DELETE mech in MODAL
                              quantityDeleteButton.addEventListener('click', function(){
    
                                const params = new URLSearchParams();
                                params.set('id', key);
              
                                let xhr = new XMLHttpRequest();
                        
                                xhr.open('POST', '/cart/remove');
                                xhr.responseType = 'json';
              
                                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                                xhr.onload = () => {
                                  if (xhr.status !== 200) {
                                    console.warn('offerCardDesktopquantityDeleteButtonMech ajax error');
                                  }else{
                                    const response = xhr.response;
                                    let countFromCart = response.count; 
                                    let modalBlockParent = document.querySelector('.buy-offer-modal-desktop');
                                    modalBlockParent.style.display = 'none';
                                    body.classList.remove('page-body__no-scroll');
                                    modalBlockParent.remove();
                                    stickyHeaderDesktop.style.top = '0';
    
                                    //Quantity + - hidden
                                    quantityParent.remove();
                                    quantityCustomParent.remove();
                                    //Fast buy & buy btn onn
                                    currentFastBtn.style.display = 'block';
                                    thisBtn.style.display = 'block';
    
                                    //cart counter update
                                    cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                    cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                    // console.warn(cartBtnDesktopMainHeaderSpan);
                                    stickyHeaderDesktopCartCountUpdate();
                                
                                  }
                                }
    
                                xhr.send(params);
                              });
    
                              quantityBackButton.addEventListener('click', function(){
                                afterBuyModalQuantityDeleteParentBlock.style.display = 'none';
                                afterBuyModalQuantityParentBlock.style.display = 'flex';
                              });
    
                            }else{
                              // Mechanics after minusBUtton on afterBuy modal window
                              const params = new URLSearchParams();
                              params.set('id', key);
              
                              const xhr = new XMLHttpRequest();
                              xhr.open('POST', '/cart/reduce');
                              xhr.responseType = 'json';
              
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                              xhr.onload = () => {
                                if (xhr.status !== 200) {
                                  console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                                }else{
                                  //  If 1 offer in afterBuyCounterBlock checking
                                  // dynamic data from cart
                                  const response = xhr.response;
                                  let countFromCart = response.count; 
                                  let totalFromCart = response.total;
                                  let stringTotalFromCart = totalFromCart.toString();
                                  let reTotalFromCart = stringTotalFromCart.replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
    
                                  let modalCountBlock = document.querySelector('.buy-offer-modal-desktop-panel__title span');
                                  let modalCountBlockProductTag = document.querySelector('.buy-offer-modal-desktop-panel__title-productWord');
                                  let modalTotalBlock = document.querySelector('.buy-offer-modal-desktop-panel__price-output');
    
                                  const endingGenerated = endingGenerate(countFromCart);
    
                                  modalCountBlock.innerText = countFromCart;
                                  modalTotalBlock.innerText = reTotalFromCart;
                                  modalCountBlockProductTag.innerText = endingGenerated;
                                  --afterBuyModalCounterBlock.placeholder;
    
                                  afterBuyInput.placeholder = --afterBuyModalCounterBlockPlaceholder;
    
                                  afterBuyModalPlusButton.classList.remove('buy-offer-modal-desktop-product__btn-plus--disable');
                                  afterBuyModalPlusButton.classList.add('buy-offer-modal-desktop-product__btn-plus');
                                  afterBuyModalInput.style.pointerEvents = 'auto';
                                  afterBuyModalQuantityAlert.innerText = ` `;
    
                                  //cart counter update
                                  cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                  cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                  // console.warn(cartBtnDesktopMainHeaderSpan);
                                  stickyHeaderDesktopCartCountUpdate();
                                }
                              }
              
                              xhr.send(params);
                            }
                          });
                          
                          afterBuyModalPlusButton.addEventListener('click', function(){
                            let afterBuyModalCounterBlock = document.querySelector('.buy-offer-modal-desktop-product__default-input');
                            let afterBuyModalCounterBlockPlaceholder = afterBuyModalCounterBlock.placeholder;
                            // Mechanics after plusBUtton on afterBuy modal window
                            //availability checkout
                            if(availability == '1'){
                              afterBuyModalQuantityAlert.style.display = 'block';
                              afterBuyModalQuantityAlert.innerText = `oсталось: ${availability} шт`;
                              afterBuyModalPlusButton.classList.remove('buy-offer-modal-desktop-product__btn-plus');
                              afterBuyModalPlusButton.classList.add('buy-offer-modal-desktop-product__btn-plus--disable');
                              afterBuyModalInput.style.pointerEvents = 'none';
    
                            }else{
    
                              if(Number(afterBuyModalCounterBlockPlaceholder) < Number(availability)){
                                // console.warn(`ИНПУТ МЕНЬШЕ ОСТАТКА осталось ${availability} штук ТОВАР ДОБАВЛЯЕМ`);
                                // console.warn(`ИНПУТ ${afterBuyModalCounterBlockPlaceholder}`);
                                // console.warn(`ОСТАТОК ${availability}`);
                          
                                const params = new URLSearchParams();
                                params.set('id', key);
                
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', '/cart/add');
                                xhr.responseType = 'json';
                
                                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                                xhr.onload = () => {
                                  if (xhr.status !== 200) {
                                    console.warn('offerCardDesktopAfterBuyModalCounter PlusClick ajax error');
                                  }else{
                                    //  If 1 offer in afterBuyCounterBlock checking
                                    // dynamic data from cart
                                    const response = xhr.response;
                                    let countFromCart = response.count; 
                                    let totalFromCart = response.total;
                                    let stringTotalFromCart = totalFromCart.toString();
                                    let reTotalFromCart = stringTotalFromCart.replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
      
                                    let modalCountBlock = document.querySelector('.buy-offer-modal-desktop-panel__title span');
                                    let modalCountBlockProductTag = document.querySelector('.buy-offer-modal-desktop-panel__title-productWord');
                                    let modalTotalBlock = document.querySelector('.buy-offer-modal-desktop-panel__price-output');
                                    const endingGenerated = endingGenerate(countFromCart);
      
                                    // console.warn(availability);
      
                                    modalCountBlock.innerText = countFromCart;
                                    modalTotalBlock.innerText = reTotalFromCart;
                                    modalCountBlockProductTag.innerText = endingGenerated;
                                    ++afterBuyModalCounterBlock.placeholder;
      
                                    afterBuyInput.placeholder = ++afterBuyModalCounterBlockPlaceholder;
    
                                    //cart counter update
                                    cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                    cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                    // console.warn(cartBtnDesktopMainHeaderSpan);
                                    stickyHeaderDesktopCartCountUpdate();
      
                                  }
                                }
                
                                xhr.send(params);
    
                              }else if(Number(afterBuyModalCounterBlockPlaceholder) >= Number(availability)){
                                // console.warn(`ИНПУТ БОЛЬШЕ ИЛИ РАВЕН ОСТАТКУ осталось ${availability} штук ТОВАР НЕ ДОБАВЛЯЕМ`);
                                // console.warn(`ИНПУТ ${afterBuyModalCounterBlockPlaceholder}`);
                                // console.warn(`ОСТАТОК ${availability}`);
                                
                                afterBuyModalQuantityAlert.style.display = 'block';
                                afterBuyModalQuantityAlert.innerText = `oсталось: ${availability} шт`;
                                afterBuyModalPlusButton.classList.remove('buy-offer-modal-desktop-product__btn-plus');
                                afterBuyModalPlusButton.classList.add('buy-offer-modal-desktop-product__btn-plus--disable');
                                afterBuyModalInput.style.pointerEvents = 'none';
    
    
    
                              }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
                                // console.warn(`ТОВАРА МНОГО, осталось ${availability} штук ТОВАР ДОБАВЛЯЕМ`);
                                // console.warn(`ИНПУТ ${afterBuyModalCounterBlockPlaceholder}`);
                                // console.warn(`ОСТАТОК ${availability}`);
    
                                const params = new URLSearchParams();
                                params.set('id', key);
                
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', '/cart/add');
                                xhr.responseType = 'json';
                
                                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                                xhr.onload = () => {
                                  if (xhr.status !== 200) {
                                    // console.warn('offerCardDesktopAfterBuyModalCounter PlusClick ajax error');
                                  }else{
                                    //  If 1 offer in afterBuyCounterBlock checking
                                    // dynamic data from cart
                                    const response = xhr.response;
                                    let countFromCart = response.count; 
                                    let totalFromCart = response.total;
                                    let stringTotalFromCart = totalFromCart.toString();
                                    let reTotalFromCart = stringTotalFromCart.replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
      
                                    let modalCountBlock = document.querySelector('.buy-offer-modal-desktop-panel__title span');
                                    let modalCountBlockProductTag = document.querySelector('.buy-offer-modal-desktop-panel__title-productWord');
                                    let modalTotalBlock = document.querySelector('.buy-offer-modal-desktop-panel__price-output');
                                    const endingGenerated = endingGenerate(countFromCart);
      
                                    modalCountBlock.innerText = countFromCart;
                                    modalTotalBlock.innerText = reTotalFromCart;
                                    modalCountBlockProductTag.innerText = endingGenerated;
                                    ++afterBuyModalCounterBlock.placeholder;
      
                                    afterBuyInput.placeholder =  ++afterBuyModalCounterBlockPlaceholder;
    
                                    //cart counter update
                                    cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                    cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                    // console.warn(cartBtnDesktopMainHeaderSpan);
                                    stickyHeaderDesktopCartCountUpdate();
                                  }
                                }
                
                                xhr.send(params);
                              }
                            }
                          });
    
                          afterBuyModalInput.addEventListener('click', function(){
    
                            if(availability == '1'){
                              // console.warn('availability == 1 mech - hide buttons');
                              afterBuyModalQuantityAlert.style.display = 'block';
                              afterBuyModalQuantityAlert.innerText = `oсталось: ${availability} шт`;
                              afterBuyModalPlusButton.classList.remove('buy-offer-modal-desktop-product__btn-plus');
                              afterBuyModalPlusButton.classList.add('buy-offer-modal-desktop-product__btn-plus--disable');
                              afterBuyModalInput.style.pointerEvents = 'none';
    
                            }else{
                       
                              afterBuyModalQuantityParentBlock.style.display = 'none';
                              afterBuyModalQuantityCustomParentBlock.style.display = 'flex';
      
                              const customQuantityInput = document.querySelector('.buy-offer-modal-desktop-product__custom-input');
                              const customQuantityBackButton = document.querySelector('.customQuantityBackButton');
      
                              customQuantityInput.focus();
                              customQuantityInput.addEventListener('input', function updateInputVal(e){
    
                                const customQuantityInputValue = customQuantityInput.value;
                                const customQuantityAlert = document.querySelector('.buy-offer-modal-desktop-product__custom-alert');
                                // console.warn(customQuantityInputValue);
    
                                if(Number(customQuantityInput.value) < Number(availability)){
                                  // console.warn(`КАСТОМНЫЙ ИНПУТ МЕНЬШЕ ОСТАТКА осталось ${availability} штук ТОВАР ДОБАВЛЯЕМ`);
                                  // console.warn(`КАСТОМНЫЙ ИНПУТ ${customQuantityInputValue}`);
                                  // console.warn(`ОСТАТОК ${availability}`);
                          
                                  localStorage.setItem('customQuantityInputValue', customQuantityInputValue);
    
                                }else if(Number(customQuantityInput.value) >= Number(availability)){
                                  // console.warn(`КАСТОМНЫЙ ИНПУТ БОЛЬШЕ ИЛИ РАВЕН ОСТАТКУ осталось ${availability} штук ТОВАР НЕ ДОБАВЛЯЕМ`);
                                  // console.warn(`КАСТОМНЫЙ ИНПУТ ${customQuantityInputValue}`);
                                  // console.warn(`ОСТАТОК ${availability}`);
    
                                  customQuantityAlert.style.display = 'block';
                                  customQuantityAlert.innerText = `oсталось: ${availability} шт`;  
    
                                  customQuantityInput.value = availability;
                                  localStorage.setItem('customQuantityInputValue', availability);
    
                                }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
    
                                  localStorage.setItem('customQuantityInputValue', customQuantityInputValue);
    
                                }
                              })
      
                              customQuantityBackButton.addEventListener('click', function(){
                                afterBuyModalQuantityParentBlock.style.display = 'flex';
                                afterBuyModalQuantityCustomParentBlock.style.display = 'none';
                              });
                            }
                         
                          });
                          
                          customQuantityBuyBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            // console.warn('CLICK buyBtnCustomQuantity');
    
                            let customQuantityInputValue = localStorage.getItem('customQuantityInputValue');
                            
                            if(customQuantityInputValue == ''){
                              console.warn('customQuantityInputValue === empty string');
                            }else{
                              // console.warn('customQuantityInputValue');
                              // console.warn(customQuantityInputValue);
                              let thisBtn = this;
                              thisBtn.classList.remove('buy-offer-modal-desktop-product__buy-btn');
                              thisBtn.classList.add('buy-offer-modal-desktop-product__buy-btn--load');
                              thisBtn.innerHTML = `<div class="desktop-modal-buy__buy-btn-preloader"></div>`;
    
                              function sendOfferToCartModalFromCustomBuy(){
                                const params = new URLSearchParams();
                                params.set('id', key);
                                params.append('qty', customQuantityInputValue);
      
                                let xhr = new XMLHttpRequest();
      
                                xhr.open('POST', '/cart/change');
                                xhr.responseType = 'json';
      
                                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                                xhr.onload = () => {
                                  if (xhr.status !== 200) {
                                    console.warn('modalCustomQuantityBuyButtonMech ajax error');
                                  } else {
                                    // console.warn('modalCustomQuantityBuyButtonMech ajax SUCCESS');
                                    thisBtn.classList.remove('buy-offer-modal-desktop-product__buy-btn--load');
                                    thisBtn.classList.add('buy-offer-modal-desktop-product__buy-btn');
                                    thisBtn.innerHTML = ` `;
                                    // dynamic data from cart
                                    const response = xhr.response;
                                    let countFromCart = response.count; 
                                    let totalFromCart = response.total;
                                    let stringTotalFromCart = totalFromCart.toString();
                                    let reTotalFromCart = stringTotalFromCart.replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
      
                                    let modalCountBlock = document.querySelector('.buy-offer-modal-desktop-panel__title span');
                                    let modalCountBlockProductTag = document.querySelector('.buy-offer-modal-desktop-panel__title-productWord');
                                    let modalTotalBlock = document.querySelector('.buy-offer-modal-desktop-panel__price-output');
                                    const endingGenerated = endingGenerate(countFromCart);
      
                                    // console.warn(availability);
                                    modalCountBlock.innerText = countFromCart;
                                    modalTotalBlock.innerText = reTotalFromCart;
                                    modalCountBlockProductTag.innerText = endingGenerated;
      
                                    //custom quantity synh on NO modal buy btns
                                    afterBuyInput.placeholder = customQuantityInputValue;
                                    afterBuyModalInput.placeholder = customQuantityInputValue;
    
                                    afterBuyModalQuantityCustomParentBlock.style.display = 'none';
                                    afterBuyModalQuantityParentBlock.style.display = 'flex';
                                  
                                    //cart counter update
                                    cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                    cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                    // console.warn(cartBtnDesktopMainHeaderSpan);
                                    stickyHeaderDesktopCartCountUpdate();
                                  }
                                }
      
                                xhr.send(params);
                              }
                              
                              setTimeout(sendOfferToCartModalFromCustomBuy, 300);
                            }
                          });
                        }
                      }
                      xhr.send(params);
                    }
    
                    setTimeout(function(){
                      sendOfferToCart();
                    }, 400);
                  });
                }
              } else if(modalPar === "noModal"){
                for (let i = 0; i < offerbuyBtns.length; i++){
                  offerbuyBtns[i].addEventListener('click', function buyBtnFunc(e) {
                    e.preventDefault();
                    localStorage.setItem('noModalCustomQuantityInputValue', '');
                    let thisBtn = this;
                    thisBtn.classList.remove('desktop-buy__buy-btn');
                    thisBtn.classList.add('desktop-buy__buy-btn--load');
                    thisBtn.innerHTML = `<div class="desktop-buy__buy-btn-preloader"></div>`;
                    
                    let key = encodeURIComponent(thisBtn.dataset.key);
                    let availability = thisBtn.dataset.availability;
                    
                    function sendOfferToCart() {
                      const params = new URLSearchParams();
                      params.set('id', key);
    
                      let xhr = new XMLHttpRequest();
              
                      xhr.open('POST', '/cart/add');
                      xhr.responseType = 'json';
    
                      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                      xhr.onload = () => {
                        if (xhr.status !== 200) {
                          console.warn('offerCardDesktopBuyButtonMech ajax error');
                          errorBannerDesktopRemove();
                          errorBannerDesktop();
                          thisBtn.classList.remove('desktop-buy__buy-btn--load');
                          thisBtn.classList.add('desktop-buy__buy-btn');
                          thisBtn.innerHTML = ` `;
                        }else{
                          const response = xhr.response;
                          let currentPreloader = thisBtn.querySelector('.desktop-buy__buy-btn-preloader');
                          currentPreloader.remove();
                
                          thisBtn.classList.remove('desktop-buy__buy-btn--load');
                          thisBtn.classList.add('desktop-buy__buy-btn');
                          thisBtn.innerHTML = ` `;
    
                          let parentBuyBlockDesktop = thisBtn.parentElement;  
                          let currentFastBtn = parentBuyBlockDesktop.querySelector('.desktop-buy__fast-buy-btn');
                          let desktopCardItemInner = parentBuyBlockDesktop.parentElement;
                          //Availability sign of offer
                          let offerCardAvailableSign = desktopCardItemInner.querySelector('.desktop-description__shop');
    
                          //Hide buttons
                          thisBtn.style.display = 'none';
                          currentFastBtn.style.display = 'none';
    
                          //dynamic data from cart
                          let countFromCart = response.count;
                          cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                          cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                          // console.warn(cartBtnDesktopMainHeaderSpan);
                          stickyHeaderDesktopCartCountUpdate();
    
                          
                          
                          //Add quantity btns instead buy btn
                          let quantityParent = document.createElement('div');
                          quantityParent.classList.add('desktop-buy-quantity');
    
                          let quantityCustomParent = document.createElement('div');
                          quantityCustomParent.classList.add('desktop-buy-quantity--custom');
                          
                          quantityParent.innerHTML = `
                            <div class="desktop-buy-quantity__btn-minus" data-key="${key}"></div>
                            <input class="desktop-buy-quantity__default-input" placeholder="1">
                            <div class="desktop-buy-quantity__btn-plus" data-key="${key}"></div>
                          `;
    
                          quantityCustomParent.innerHTML = `
                            <div class="desktop-buy-quantity__back-btn"></div>
    
                            <div class="desktop-buy-quantity__custom-input-wrapper">
                              <input class="desktop-buy-quantity__custom-input" pattern="[0-9]*" placeholder="1" type = "number" maxlength = "3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                              <a class="desktop-buy-quantity__buy-btn"></a>
                            </div>
                          `;
    
                          parentBuyBlockDesktop.appendChild(quantityParent);
                          parentBuyBlockDesktop.appendChild(quantityCustomParent);
    
                          const afterBuyMinusButton = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__btn-minus');
                          const afterBuyInput = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__default-input');
                          const afterBuyPlusButton = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__btn-plus');
                          const afterBuyQuantityBuyButton = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__buy-btn');
    
    
                          afterBuyMinusButton.addEventListener('click', function(){
                             //Mechanic after click on Minus button
                            if(afterBuyInput.placeholder == '1'){
    
                              const params = new URLSearchParams();
                              params.set('id', key);
              
                              let xhr = new XMLHttpRequest();
                      
                              xhr.open('POST', '/cart/remove');
                              xhr.responseType = 'json';
            
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
                              xhr.onload = () => {
                                if (xhr.status !== 200) {
                                  // console.warn('offerCardDesktopquantityDeleteButtonMech ajax error');
                                }else{
                                  
                                  const response = xhr.response;
                                  //dynamic data from cart
                                  let countFromCart = response.count;
                                  cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                  cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                  // console.warn(cartBtnDesktopMainHeaderSpan);
                                  stickyHeaderDesktopCartCountUpdate();
                                  
                                  //Quantity + - hidden
                                  quantityParent.remove();
                                  quantityCustomParent.remove();
                                  //Fast buy & buy btn onn
                                  currentFastBtn.style.display = 'block';
                                  thisBtn.style.display = 'block';
                                }
                              }
    
                              xhr.send(params);
                            }else{
                              const params = new URLSearchParams();
                              params.set('id', key);
                              
                              const xhr = new XMLHttpRequest();
    
                              xhr.open('POST', '/cart/reduce');
                              xhr.responseType = 'json';
    
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                              xhr.onload = () => {
                                if (xhr.status !== 200) {
                                  console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                                }else{
                                //  If 1 offer in afterBuyInputBlock checking
                                  const response = xhr.response;
                                  let countFromCart = response.count; 
                                  cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                  cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                  // console.warn(cartBtnDesktopMainHeaderSpan);
                                  stickyHeaderDesktopCartCountUpdate();
                                  cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                  --afterBuyInput.placeholder;
      
                                  afterBuyPlusButton.classList.remove('desktop-buy-quantity__btn-plus--disable');
                                  afterBuyPlusButton.classList.add('desktop-buy-quantity__btn-plus');
                                  afterBuyInput.style.pointerEvents = 'auto';
                                }
                              }
              
                              xhr.send(params);
                            }
                          });
    
                          afterBuyPlusButton.addEventListener('click', function(){
                           let afterBuyInput = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__default-input');
                           let afterBuyInputPlaceholder = afterBuyInput.placeholder;
    
                           if(availability == '1'){
    
                            offerCardAvailableSign.classList.add('desktop-description__shop--alert');
    
                            function offerCardAvailableSignAlertDisapear(){
                              offerCardAvailableSign.classList.remove('desktop-description__shop--alert');
                            }
                            setTimeout(offerCardAvailableSignAlertDisapear, 7000);
    
                            afterBuyPlusButton.classList.remove('desktop-buy-quantity__btn-plus');
                            afterBuyPlusButton.classList.add('desktop-buy-quantity__btn-plus--disable');
                            afterBuyInput.style.pointerEvents = 'none';
                           }else{
    
                            if(Number(afterBuyInputPlaceholder) < Number(availability)){
                              const params = new URLSearchParams();
                              params.set('id', key);
              
                              const xhr = new XMLHttpRequest();
                              xhr.open('POST', '/cart/add');
                              xhr.responseType = 'json';
              
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
       
                              xhr.onload = () => {
                                if (xhr.status !== 200) {
                                  console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                                }else{
                                 const response = xhr.response;
                                 //dynamic data from cart
                                 let countFromCart = response.count;
                                 cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                 cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                //  console.warn(cartBtnDesktopMainHeaderSpan);
                                 stickyHeaderDesktopCartCountUpdate();
                                 cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
       
                                 ++afterBuyInput.placeholder;
                                }
                              }
              
                              xhr.send(params);
                            }else if(Number(afterBuyInputPlaceholder) >= Number(availability)){
                              offerCardAvailableSign.classList.add('desktop-description__shop--alert');
    
                              function offerCardAvailableSignAlertDisapear(){
                                offerCardAvailableSign.classList.remove('desktop-description__shop--alert');
                              }
                              setTimeout(offerCardAvailableSignAlertDisapear, 7000);
    
                              afterBuyPlusButton.classList.remove('desktop-buy-quantity__btn-plus');
                              afterBuyPlusButton.classList.add('desktop-buy-quantity__btn-plus--disable');
                              afterBuyInput.style.pointerEvents = 'none';
                            }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
                              const params = new URLSearchParams();
                              params.set('id', key);
              
                              const xhr = new XMLHttpRequest();
                              xhr.open('POST', '/cart/add');
                              xhr.responseType = 'json';
              
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
       
                              xhr.onload = () => {
                                if (xhr.status !== 200) {
                                  console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                                }else{
                                 const response = xhr.response;
                                 //dynamic data from cart
                                 let countFromCart = response.count;
                                 cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                 cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                //  console.warn(cartBtnDesktopMainHeaderSpan);
                                 stickyHeaderDesktopCartCountUpdate();
       
                                 ++afterBuyInput.placeholder;
                                }
                              }
              
                              xhr.send(params);
                            }
                           }
                          });
    
                          afterBuyInput.addEventListener('click', function(){
    
                            if(availability == '1'){
                              offerCardAvailableSign.classList.add('desktop-description__shop--alert');
    
                              function offerCardAvailableSignAlertDisapear(){
                                offerCardAvailableSign.classList.remove('desktop-description__shop--alert');
                              }
                              setTimeout(offerCardAvailableSignAlertDisapear, 7000);
                              afterBuyInput.style.pointerEvents = 'none';
                              
                              afterBuyPlusButton.classList.remove('desktop-buy-quantity__btn-plus');
                              afterBuyPlusButton.classList.add('desktop-buy-quantity__btn-plus--disable');
    
                            }else{
                              quantityParent.style.display = 'none';
                              quantityCustomParent.style.display = 'flex';
    
                              const afterBuyCustomQuantityInput = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__custom-input');
                              const afterBuyCustomQuantityBackBtn = parentBuyBlockDesktop.querySelector('.desktop-buy-quantity__back-btn');
    
                              afterBuyCustomQuantityInput.focus();
                              afterBuyCustomQuantityInput.addEventListener('input', function updateCustomInputValue(e){
    
                                const afterBuyCustomQuantityInputValue = afterBuyCustomQuantityInput.value;
    
                                if(Number(afterBuyCustomQuantityInput.value) < Number(availability)){
                                  // console.warn(`КАСТОМНЫЙ ИНПУТ МЕНЬШЕ ОСТАТКА осталось ${availability} штук ТОВАР ДОБАВЛЯЕМ`);
                                  // console.warn(`КАСТОМНЫЙ ИНПУТ ${afterBuyCustomQuantityInputValue}`);
                                  // console.warn(`ОСТАТОК ${availability}`);
    
                                  localStorage.setItem('noModalCustomQuantityInputValue', afterBuyCustomQuantityInputValue);
    
                                }else if(Number(afterBuyCustomQuantityInput.value) > Number(availability)){
                                  console.warn(`КАСТОМНЫЙ ИНПУТ БОЛЬШЕ ИЛИ РАВЕН ОСТАТКУ осталось ${availability} штук ТОВАР НЕ ДОБАВЛЯЕМ`);
                                  // console.warn(`КАСТОМНЫЙ ИНПУТ ${afterBuyCustomQuantityInputValue}`);
                                  // console.warn(`ОСТАТОК ${availability}`);
                                  offerCardAvailableSign.classList.add('desktop-description__shop--alert');
    
                                  function offerCardAvailableSignAlertDisapear(){
                                    offerCardAvailableSign.classList.remove('desktop-description__shop--alert');
                                  }
                                  setTimeout(offerCardAvailableSignAlertDisapear, 7000);
    
                                  afterBuyCustomQuantityInput.value = availability;
                                  localStorage.setItem('noModalCustomQuantityInputValue', availability);
    
                                }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
    
                                  localStorage.setItem('noModalCustomQuantityInputValue', afterBuyCustomQuantityInputValue);
    
                                }
                              });
    
                              afterBuyCustomQuantityBackBtn.addEventListener('click', function(){
                                quantityCustomParent.style.display = 'none';
                                quantityParent.style.display = 'flex';
                              });
                            }
                          });
    
                          afterBuyQuantityBuyButton.addEventListener('click', function(e){
                            e.preventDefault();
    
                            let noModalCustomQuantityInputValue = localStorage.getItem('noModalCustomQuantityInputValue');
    
                            if(noModalCustomQuantityInputValue == ''){
                              // console.warn('noModalCustomQuantityInputValue === empty string');
    
                            }else{
                              // console.warn('noModalCustomQuantityInputValue');
                              // console.warn(noModalCustomQuantityInputValue);
                              let thisBtn = this;
                              thisBtn.classList.remove('desktop-buy-quantity__buy-btn');
                              thisBtn.classList.add('desktop-buy-quantity__buy-btn--load');
                              thisBtn.innerHTML = `<div class="desktop-custom-quantity-buy__buy-btn-preloader"></div>`;
    
                              function sendOfferToCartDesktopCustomQuamnity(){
                                const params = new URLSearchParams();
                                params.set('id', key);
                                params.append('qty', noModalCustomQuantityInputValue);
      
                                let xhr = new XMLHttpRequest();
      
                                xhr.open('POST', '/cart/change');
                                xhr.responseType = 'json';
      
                                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                                xhr.onload = () => {
                                  if (xhr.status !== 200) {
                                    // console.warn('modalCustomQuantityBuyButtonMech ajax error');
                                  } else {
                                    // console.warn('modalCustomQuantityBuyButtonMech ajax SUCCESS');
                                    thisBtn.classList.remove('desktop-buy-quantity__buy-btn--load');
                                    thisBtn.classList.add('desktop-buy-quantity__buy-btn');
                                    thisBtn.innerHTML = ` `;
                                    // dynamic data from cart
                                    const response = xhr.response;
                                    let countFromCart = response.count; 
                                    cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                                    cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                                    console.warn(cartBtnDesktopMainHeaderSpan);
                                    stickyHeaderDesktopCartCountUpdate();
      
                                    afterBuyInput.placeholder = noModalCustomQuantityInputValue;
    
                                    quantityParent.style.display = 'flex';
                                    quantityCustomParent.style.display = 'none';
                                  }
                                }
      
                                xhr.send(params);
                              }
                              setTimeout(sendOfferToCartDesktopCustomQuamnity, 300);
                            }
                          });
                          
                          //init parent + add tooltip       
                          offerCardDesktopBuyModalLocalStorageSwitcherHide();  
                        }
                      }
    
                      xhr.send(params);
                    }
              
                    setTimeout(function(){
                      sendOfferToCart();
                    }, 400);     
                  });
                }
              } else if(modalPar === null){
                offerCardDesktopBuyModalLocalStorageSwitcher();
              }
            }
          }
        }
      }
    }
    
    offerCardDesktopBuyButtonMech();
    
    //Buy button tooltips stuff
    function offerCardDesktopBuyButtonTooltip(){
      let buyBtns = document.querySelectorAll('.desktop-buy__buy-btn');
    
      if(buyBtns === null){
    
      }else{
        buyBtns.forEach(item => {
          item.innerHTML = `<div class="desktop-buy__buy-btn-tooltip">Добавить в корзину</div>`
    
          let currentBuyTooltip = item.querySelector('.desktop-buy__buy-btn-tooltip');
    
          
    
    
          item.addEventListener('mouseover', function() {
            currentBuyTooltip.style.visibility = 'visible';
            currentBuyTooltip.style.opacity = '1';
          })
    
          item.addEventListener('mouseout', function() {
            currentBuyTooltip.style.visibility = 'hidden';
            currentBuyTooltip.style.opacity = '0';
          })
        })
      }
    }
    
    //Done buy tooltip
    function offerCardDesktopBuyButtonDoneTooltip(){
      let buyBtnsDone = document.querySelectorAll('.desktop-buy__buy-btn--done');
    
      if(buyBtnsDone === null){
    
      }else{
        buyBtnsDone.forEach(item => {
          item.innerHTML = `<div class="desktop-buy__buy-btn-tooltip--done">Товар в корзине <br/> Нажмите, чтобы перейти</div>`
          item.href = `http://final.lr.ru/cart`
          
          let currentDoneBuyTooltip = item.querySelector('.desktop-buy__buy-btn-tooltip--done');
          item.addEventListener('mouseover', function() {
            currentDoneBuyTooltip.style.visibility = 'visible';
            currentDoneBuyTooltip.style.opacity = '1';
          })
    
          item.addEventListener('mouseout', function() {
            currentDoneBuyTooltip.style.visibility = 'hidden';
            currentDoneBuyTooltip.style.opacity = '0';
          })
        })
      }
    }
    
    
    offerCardDesktopBuyButtonTooltip();
    offerCardDesktopBuyButtonDoneTooltip();
    
    
    //Add to cart button Mobile ✰4
    function offerCardMobileBuyButtonMech() {
      let offersMobileListItems = document.querySelectorAll('.mobile-list-item');
    
      if (offersMobileListItems === null) {
    
      } else {
    
        for (let i = 0; i < offersMobileListItems.length; i++) {
          let offersMobileQuantityBlock = offersMobileListItems[i].querySelector('.mobile-description__quantity');
          let buyBtnMobile = offersMobileListItems[i].querySelector('.mobile-buy__buy-btn');
    
          if(buyBtnMobile === null){
    
          }else{
            buyBtnMobile.addEventListener('click', function (e) {
              e.preventDefault();
              clearMobileTooltip();
      
              buyBtnMobile.classList.remove('mobile-buy__buy-btn');
              buyBtnMobile.classList.add('mobile-buy__buy-btn--load');
              buyBtnMobile.innerHTML = `<div class="mobile-buy__buy-btn-preloader"></div>`;
      
              let cartBtnMobileMainHeader = document.querySelector('.user-mobile__shopping-cart span');
      
              let key = encodeURIComponent(buyBtnMobile.dataset.key);
              let availability = buyBtnMobile.dataset.availability;
      
              //First click on buy btn send offer to server mech
              function sendOfferToCartMobile() {
                //Mechanic after click on Minus button
                const params = new URLSearchParams();
                params.set('id', key);
      
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/cart/add');
                xhr.responseType = 'json';
      
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                xhr.onload = () => {
                  if (xhr.status !== 200) {
                    console.warn('sendOfferToCartMobile ajax error');
                    errorBannerMobileRemove();
                    errorBannerMobile();
                    buyBtnMobile.classList.remove('mobile-buy__buy-btn--load');
                    buyBtnMobile.classList.add('mobile-buy__buy-btn');
                     buyBtnMobile.innerHTML = ``;
                  } else {
      
                    const response = xhr.response;
                    //Hidding mechanic of fast buy & buy btn
                    let parentBuyBlockMobile = buyBtnMobile.parentElement;
                    let currentFastBtn = parentBuyBlockMobile.querySelector('.mobile-buy__fast-buy-btn');
      
                    // debugger;
                    currentFastBtn.style.display = 'none';
                    buyBtnMobile.classList.remove('mobile-buy__buy-btn--load');
                    buyBtnMobile.classList.add('mobile-buy__buy-btn');
                    buyBtnMobile.innerHTML = ` `;
                    buyBtnMobile.style.display = 'none';
      
                    //dynamic data from cart + update counters
                    let countFromCart = response.count;
                    cartBtnMobileMainHeader.innerText = countFromCart;
      
                    //Add quantity btns instead buy btn
                    let quantityParent = document.createElement('div');
                    quantityParent.classList.add('mobile-buy-quantity');
      
                    let quantityCustomParent = document.createElement('div');
                    quantityCustomParent.classList.add('mobile-buy-quantity--custom');
      
                    quantityParent.innerHTML = `
                       <div class="mobile-buy-quantity__btn-minus" data-key="${key}"></div>
                       <input class="mobile-buy-quantity__default-input" placeholder="1">
                       <div class="mobile-buy-quantity__btn-plus" data-key="${key}"></div>
                     `;
      
                    quantityCustomParent.innerHTML = `
                       <div class="mobile-buy-quantity__back-btn"></div>
                       <div class="mobile-buy-quantity__custom-input-wrapper">
                         <input class="mobile-buy-quantity__custom-input" pattern="[0-9]*" placeholder="1" type = "number" maxlength = "3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                         <a class="mobile-buy-quantity__buy-btn"></a>
                       </div>
                     `;
      
      
                    parentBuyBlockMobile.appendChild(quantityParent);
                    parentBuyBlockMobile.appendChild(quantityCustomParent);
      
                    //Add tooltip
                    mobileBuyTooltip();
                    stickyHeaderMobileCartCountUpdate();
      
                    //after buy mechs
                    let afterBuyMinusButton = parentBuyBlockMobile.querySelector('.mobile-buy-quantity__btn-minus');
                    let afterBuyPlusButton = parentBuyBlockMobile.querySelector('.mobile-buy-quantity__btn-plus');
                    let afterBuyInput = parentBuyBlockMobile.querySelector('.mobile-buy-quantity__default-input');
      
                    const afterBuyQuantityBuyButton = parentBuyBlockMobile.querySelector('.mobile-buy-quantity__buy-btn');
      
      
                    //Minus button mech
                    afterBuyMinusButton.addEventListener('click', function () {
      
                      if (afterBuyInput.placeholder == '1') {
      
                        const params = new URLSearchParams();
                        params.set('id', key);
      
                        let xhr = new XMLHttpRequest();
      
                        xhr.open('POST', '/cart/remove');
                        xhr.responseType = 'json';
      
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                        xhr.onload = () => {
                          if (xhr.status !== 200) {
                            // console.warn('offerCardDesktopquantityDeleteButtonMech ajax error');
                          } else {
      
                            const response = xhr.response;
                            //dynamic data from cart
                            let countFromCart = response.count;
                            cartBtnMobileMainHeader.innerText = countFromCart;
                            stickyHeaderMobileCartCountUpdate();
      
                            //Quantity + - hidden
                            quantityParent.remove();
                            quantityCustomParent.remove();
                            //Fast buy & buy btn onn
                            currentFastBtn.style.display = 'block';
                            buyBtnMobile.style.display = 'block';
                          }
                        }
      
                        xhr.send(params);
                      }else {
      
                        const params = new URLSearchParams();
                        params.set('id', key);
      
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '/cart/reduce');
                        xhr.responseType = 'json';
      
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                        xhr.onload = () => {
                          if (xhr.status !== 200) {
                            console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                          } else {
      
                            const response = xhr.response;
                            let countFromCart = response.count;
                            cartBtnMobileMainHeader.innerText = countFromCart;
                            stickyHeaderMobileCartCountUpdate();
                            --afterBuyInput.placeholder;
      
                            afterBuyPlusButton.classList.remove('mobile-buy-quantity__btn-plus--disable');
                            afterBuyPlusButton.classList.add('mobile-buy-quantity__btn-plus');
                            afterBuyInput.style.pointerEvents = 'auto';
                          }
                        }
      
                        xhr.send(params);
                      }
                    });
      
                    //Plus button mech
                    afterBuyPlusButton.addEventListener('click', function () {
                      // console.log('key in afterBuyPlus mech');
                      if (availability == '1') {
      
                        offersMobileQuantityBlock.classList.add('mobile-description__quantity--alert');
      
                        function offerCardAvailableSignAlertDisapearMobile() {
                          offersMobileQuantityBlock.classList.remove('mobile-description__quantity--alert');
                        }
                        setTimeout(offerCardAvailableSignAlertDisapearMobile, 7000);
      
                        afterBuyPlusButton.classList.remove('mobile-buy-quantity__btn-plus');
                        afterBuyPlusButton.classList.add('mobile-buy-quantity__btn-plus--disable');
                        afterBuyInput.style.pointerEvents = 'none';
      
                      } else {
      
                        if (Number(afterBuyInput.placeholder) < Number(availability)) {
      
                          const params = new URLSearchParams();
                          params.set('id', key);
      
                          const xhr = new XMLHttpRequest();
                          xhr.open('POST', '/cart/add');
                          xhr.responseType = 'json';
      
                          xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                          xhr.onload = () => {
                            if (xhr.status !== 200) {
                              console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                            } else {
      
                              const response = xhr.response;
                              let countFromCart = response.count;
                              cartBtnMobileMainHeader.innerText = countFromCart;
                              stickyHeaderMobileCartCountUpdate();
                              ++afterBuyInput.placeholder;
                            }
                          }
      
                          xhr.send(params);
      
                        }else if (Number(afterBuyInput.placeholder) >= Number(availability)) {
      
                          offersMobileQuantityBlock.classList.add('mobile-description__quantity--alert');
      
                          function offerCardAvailableSignAlertDisapearMobile() {
                            offersMobileQuantityBlock.classList.remove('mobile-description__quantity--alert');
                          }
                          setTimeout(offerCardAvailableSignAlertDisapearMobile, 7000);
      
                          afterBuyPlusButton.classList.remove('mobile-buy-quantity__btn-plus');
                          afterBuyPlusButton.classList.add('mobile-buy-quantity__btn-plus--disable');
                          afterBuyInput.style.pointerEvents = 'none';
      
                        } else if (availability === 'много' || availability === 'В наличии' || availability === 'По запросу') {
      
                          const params = new URLSearchParams();
                          params.set('id', key);
      
                          const xhr = new XMLHttpRequest();
                          xhr.open('POST', '/cart/add');
                          xhr.responseType = 'json';
      
                          xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
                          xhr.onload = () => {
                            if (xhr.status !== 200) {
                              console.warn('offerCardMobileAfterBuyCounter MinusClick ajax error');
                            } else {
      
                              const response = xhr.response;
                              //dynamic data from cart
                              let countFromCart = response.count;
                              cartBtnMobileMainHeader.innerText = countFromCart;
                              stickyHeaderMobileCartCountUpdate();
                              ++afterBuyInput.placeholder;
                            }
                          }
      
                          xhr.send(params);
                        }
                      }
                    });
      
                    //input mech
                    afterBuyInput.addEventListener('click', function(){
      
                      if(availability == '1'){
                        
                        offersMobileQuantityBlock.classList.add('mobile-description__quantity--alert');
      
                        function offerCardAvailableSignAlertDisapearMobile() {
                          offersMobileQuantityBlock.classList.remove('mobile-description__quantity--alert');
                        }
                        setTimeout(offerCardAvailableSignAlertDisapearMobile, 7000);
      
                        afterBuyPlusButton.classList.remove('mobile-buy-quantity__btn-plus');
                        afterBuyPlusButton.classList.add('mobile-buy-quantity__btn-plus--disable');
                        afterBuyInput.style.pointerEvents = 'none';
      
                      }else{
      
                        quantityParent.style.display = 'none';
                        quantityCustomParent.style.display = 'flex';
      
                        const afterBuyCustomQuantityInputMobile = parentBuyBlockMobile.querySelector('.mobile-buy-quantity__custom-input');
                        const afterBuyCustomQuantityBackBtnMobile = parentBuyBlockMobile.querySelector('.mobile-buy-quantity__back-btn');
      
                        afterBuyCustomQuantityInputMobile.focus();
                        afterBuyCustomQuantityInputMobile.addEventListener('input', function(e){
      
                          const afterBuyCustomQuantityInputMobileValue = afterBuyCustomQuantityInputMobile.value;
      
                          if(Number(afterBuyCustomQuantityInputMobile.value) < Number(availability)){
      
                            // console.warn(`МОБИЛЬНЫЙ КАСТОМНЫЙ ИНПУТ МЕНЬШЕ ОСТАТКА осталось ${availability} штук ТОВАР ДОБАВЛЯЕМ`);
      
                            localStorage.setItem('mobileCustomQuantityInputValue', afterBuyCustomQuantityInputMobileValue);
      
                          }else if(Number(afterBuyCustomQuantityInputMobile.value) > Number(availability)){
      
                            // console.warn(`МОБИЛЬНЫЙ КАСТОМНЫЙ ИНПУТ БОЛЬШЕ ИЛИ РАВЕН ОСТАТКУ осталось ${availability} штук ТОВАР НЕ ДОБАВЛЯЕМ`);
      
                            offersMobileQuantityBlock.classList.add('mobile-description__quantity--alert');
      
                            function offerCardAvailableSignAlertDisapearMobile() {
                              offersMobileQuantityBlock.classList.remove('mobile-description__quantity--alert');
                            }
                            setTimeout(offerCardAvailableSignAlertDisapearMobile, 7000);
      
                            afterBuyCustomQuantityInputMobile.value = availability;
                            localStorage.setItem('mobileCustomQuantityInputValue', availability);
      
                          }else if(availability === 'много' || availability === 'В наличии' || availability === 'По запросу'){
      
                            localStorage.setItem('mobileCustomQuantityInputValue', afterBuyCustomQuantityInputMobileValue);
      
                          }
                        });
      
                        afterBuyCustomQuantityBackBtnMobile.addEventListener('click', function(){
                          quantityParent.style.display = 'flex';
                          quantityCustomParent.style.display = 'none';
                        });
                      }
                    });
      
                    afterBuyQuantityBuyButton.addEventListener('click', function(e){
                      e.preventDefault();
      
                      let mobileCustomQuantityInputValue = localStorage.getItem('mobileCustomQuantityInputValue');
      
                      if(mobileCustomQuantityInputValue == ''){
      
                        console.warn('mobileCustomQuantityInputValue === empty string');
      
                      }else{
                        // console.warn('mobileCustomQuantityInputValue');
                        // console.warn(mobileCustomQuantityInputValue);
                        let thisBtn = this;
                        thisBtn.classList.remove('mobile-buy-quantity__buy-btn');
                        thisBtn.classList.add('mobile-buy-quantity__buy-btn--load');
                        thisBtn.innerHTML = `<div class="mobile-buy__buy-btn-preloader"></div>`;
    
                        function sendOfferToCartMobileCustomQuamnity(){
                          const params = new URLSearchParams();
                          params.set('id', key);
                          params.append('qty', mobileCustomQuantityInputValue);
        
                          let xhr = new XMLHttpRequest();
        
                          xhr.open('POST', '/cart/change');
                          xhr.responseType = 'json';
        
                          xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        
                          xhr.onload = () => {
                            if (xhr.status !== 200) {
                              // console.warn('modalCustomQuantityBuyButtonMech ajax error');
                            } else {
                              // console.warn('modalCustomQuantityBuyButtonMech ajax SUCCESS');
                              thisBtn.classList.remove('mobile-buy-quantity__buy-btn--load');
                              thisBtn.classList.add('mobile-buy-quantity__buy-btn');
                              thisBtn.innerHTML = ` `;
                              // dynamic data from cart
                              const response = xhr.response;
                              let countFromCart = response.count; 
                              cartBtnMobileMainHeader.innerText = countFromCart;
                              stickyHeaderMobileCartCountUpdate();
        
                              afterBuyInput.placeholder = mobileCustomQuantityInputValue;
                              quantityParent.style.display = 'flex';
                              quantityCustomParent.style.display = 'none';
                            }
                          }
                          xhr.send(params);
                        }
    
                        setTimeout(sendOfferToCartMobileCustomQuamnity, 300);
                      }
                    });
                  }
                }
                xhr.send(params);
              }
              setTimeout(sendOfferToCartMobile, 400);
            });
          }
        }
      }
    }
    offerCardMobileBuyButtonMech();
    
    function mobileBuyTooltip(){
      let buyTooltip = document.createElement('div');
      let body = document.querySelector('body');
    
      buyTooltip.classList.add('mobile-buy__buy-btn-tooltip')
      buyTooltip.innerHTML = `
                <a href="/cart">
                  <div class="mobile-buy__buy-btn-tooltip-wrapper">
                      Товар успешно добавлен в корзину 
                      <span>Нажмите, чтобы перейти</span>
                  </div>
                </a>
      `
    
      body.appendChild(buyTooltip);
    
      function mobileBuyTooltipSmoothAppearance(){
        buyTooltip.style.top = '0';
      }
    
      function mobileBuyTooltipCloseToTimer(){
        buyTooltip.style.top = '-150px';
      }
    
      window.addEventListener('scroll', function(e){
        let scrollPos  = window.scrollY;
        // console.log(scrollPos);
    
        if (scrollPos < 200) {
          buyTooltip.style.top = '-150px';
        } 
      }); 
    
      setTimeout(mobileBuyTooltipSmoothAppearance, 300)
      setTimeout(mobileBuyTooltipCloseToTimer, 10000)
    }
      
    function clearMobileTooltip() {
      let mobileTooltip = document.querySelectorAll('.mobile-buy__buy-btn-tooltip');
    
      if (mobileTooltip === null) {
        // console.log('no tooltip on the page');
      } else {
        mobileTooltip.forEach(item => {
          item.remove();
        });
      }
    
    }
    
    //Fast buy buttons
    function offerCardDesktopFastBuy(){
      let fastBuyBtns = document.querySelectorAll('.desktop-buy__fast-buy-btn');
      // let fastBuyClose = document.querySelector('.fast-buy-form__close');
      let body = document.querySelector('body');
    
      if (fastBuyBtns === null) {
        // console.log('fastBuyBtns left html');
      }else {
        for (let i = 0; i < fastBuyBtns.length; i++){
          fastBuyBtns[i].addEventListener('click', function fastBuyFetchDesktop(e){
            e.preventDefault();
            const thisBtn = this;
            let thisBtnKey = thisBtn.dataset.key;
            // console.log(thisBtnKey);
            let requestUrl = `/form/render/3?key=${thisBtnKey}`;
    
            function fetchingFastForm(){
              const xhr = new XMLHttpRequest();
              xhr.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    let stickyHeaderDesktop = document.querySelector('.sticky-header-desktop');
                    stickyHeaderDesktop.style.top = '-150px';
    
                    const response = JSON.parse(xhr.response);
                    let responseFormBlock = document.createElement("div");
                    responseFormBlock.innerHTML = response.html;
                    responseFormBlock.classList.add('fast-buy-form__wrapper');
                    body.after(responseFormBlock);
                    responseFormBlock.style.display = 'flex';
                    body.style.overflow = 'hidden';
    
                    //close current active fast buy form                     
                    let currentCloseBtn = responseFormBlock.querySelector('.fast-buy-form__close');
                    currentCloseBtn.addEventListener('click', function(){
                      responseFormBlock.style.display = 'none';
                      body.style.overflow = 'visible';
                      thisBtn.removeEventListener('click', fastBuyFetchDesktop);
                      thisBtn.classList.add('desktop-buy__fast-buy-btn--clicked');
                      thisBtn.removeAttribute('href');
    
                      thisBtn.addEventListener('click', function reOpenFastFormDesktop(e){
                        e.preventDefault();
                          responseFormBlock.style.display = 'flex';
                      });
    
                      
                      stickyHeaderDesktop.style.top = '0';
                    });
                  }
              } 
              xhr.open('get', requestUrl);
              xhr.send();
            }
            fetchingFastForm();
          });
        }
      }
    }
    offerCardDesktopFastBuy()
    //Fast buy`s tooltip
    function offerCardDesktopFastBuyTooltipMech(){
      let fastBuyBtns = document.querySelectorAll('.desktop-buy__fast-buy-btn');
    
      if(fastBuyBtns === null){
    
      }else{
        fastBuyBtns.forEach(item => {
          item.innerHTML = `<div class="desktop-buy__fast-buy-btn-tooltip">Быстрая покупка</div>`;
    
          let fastBuyTooltip = item.querySelector('.desktop-buy__fast-buy-btn-tooltip');
    
          item.addEventListener('mouseover', function() {
            fastBuyTooltip.style.visibility = 'visible';
            fastBuyTooltip.style.opacity = '1';
          })
    
          item.addEventListener('mouseout', function() {
            fastBuyTooltip.style.visibility = 'hidden';
            fastBuyTooltip.style.opacity = '0';
          })
        })
      }
    }
    
    offerCardDesktopFastBuyTooltipMech();
    
    function offerCardMobileFastBuy(){
      let fastBuyBtnsMobile = document.querySelectorAll('.mobile-buy__fast-buy-btn');
      // let fastBuyClose = document.querySelector('.fast-buy-form__close');
      let body = document.querySelector('body');
      let stickyHeader = document.querySelector('.sticky-header-mobile');
    
      if (fastBuyBtnsMobile === null) {
    
      }else {
        for (let i = 0; i < fastBuyBtnsMobile.length; i++){
          fastBuyBtnsMobile[i].addEventListener('click', function fastBuyFetchMobile(e){
            e.preventDefault();
            stickyHeader.style.bottom = '-200px';
            const thisBtn = this;
            let thisBtnKey = thisBtn.dataset.key;
            // console.log(thisBtnKey);
            let requestUrl = `/form/render/3?key=${thisBtnKey}`;
    
            function fetchingFastForm(){
              const xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            
                            const response = JSON.parse(xhr.response);
                            let responseFormBlock = document.createElement("div");
                            responseFormBlock.innerHTML = response.html;
                            responseFormBlock.classList.add('fast-buy-form__wrapper');
                            thisBtn.after(responseFormBlock);
                            responseFormBlock.style.display = 'flex';
                            body.style.overflow = 'hidden';
    
                            //close current active fast buy form                     
                            let currentCloseBtn = responseFormBlock.querySelector('.fast-buy-form__close');
                            currentCloseBtn.addEventListener('click', function(){
                              stickyHeader.style.bottom = '0';
                              responseFormBlock.style.display = 'none';
                              body.style.overflow = 'visible';
                              thisBtn.removeEventListener('click', fastBuyFetchMobile);
                              thisBtn.classList.add('mobile-buy__fast-buy-btn--clicked');
                              thisBtn.removeAttribute('href');
    
                              thisBtn.addEventListener('click', function reOpenFastFormDesktop(e){
                                e.preventDefault();
                                  responseFormBlock.style.display = 'flex';
                              });
                            });
                        }
                    } 
                    xhr.open('get', requestUrl);
                    xhr.send();
                  }
            fetchingFastForm();
          });
        }
      }
    }
    
    offerCardMobileFastBuy();
    
    function offerCardDesktopInfoOpen() {
      let desktopCardItem = document.querySelectorAll('.desktop-card-item');
      
    
      if (desktopCardItem === null) {
        // console.log("desktopCardItem left HTML");
      } else {
        for(let i = 0; i < desktopCardItem.length; i++){
          let desktopProp = desktopCardItem[i].querySelector(".desktop-properties");
          let desktopInfoBlock = desktopCardItem[i].querySelector(".desktop-info");
          let desktopInfoBlockClose = desktopCardItem[i].querySelector(".desktop-info__items-close");
    
          if(desktopInfoBlockClose === null){
            if (desktopProp === null || desktopInfoBlock === null) {
              // console.log("offerCard components left html");
            } else {
              desktopProp.addEventListener("click", function() {
                desktopInfoBlock.classList.toggle("desktop-info--on");
              });
            }
          }else{
            if (desktopProp === null || desktopInfoBlock === null) {
              // console.log("offerCard components left html");
            } else {
              desktopProp.addEventListener("click", function() {
                desktopInfoBlock.classList.toggle("desktop-info--on");
              });
      
              desktopInfoBlockClose.addEventListener("click", function() {
                desktopInfoBlock.classList.remove("desktop-info--on");
              });
            }
          }
    
        }
    
      }
    }
    
    offerCardDesktopInfoOpen();
    
    function offerCardDesktopOpen() {
    
      let offerCardDesktop = document.querySelectorAll('.offer-card-desktop');
    
      if (offerCardDesktop === null) {
    
        // console.log("offerCardDesktop left HTML");
    
      } else {
    
        for(let i = 0; i < offerCardDesktop.length; i++){
    
          let offerCardDesktopOpenBtn = offerCardDesktop[i].querySelector('.short-panel-desktop__open');
          let fullDesktopCard = offerCardDesktop[i].querySelector('.full-desktop-card');
          let fullDesktopCloseBtn = offerCardDesktop[i].querySelector('.desktop-filter__close');
          let offerCardStart = offerCardDesktop[i].querySelector('.short-options-desktop');
    
          if (offerCardDesktopOpenBtn === null || fullDesktopCard === null || fullDesktopCloseBtn === null) {
            // console.log("offerCardDesktop components left html");
          } else {
    
            offerCardDesktopOpenBtn.addEventListener('click', function() {
              fullDesktopCard.classList.add('full-desktop-card--on');
              offerCardDesktopOpenBtn.style.visibility = 'hidden';
              
            });
    
            fullDesktopCloseBtn.addEventListener('click', function() {
              fullDesktopCard.classList.remove('full-desktop-card--on');
              offerCardDesktopOpenBtn.style.visibility = 'visible';
             
              
            });
    
            
          }
        }
      }
    
    }
    
    offerCardDesktopOpen();
    
    //Separator
    function hideFirstSeparatorOnDesktop() {
      let firstSeparator = document.querySelector('.offer-card-separator');
      // console.log(firstSeparator);
    
      if (firstSeparator === null) {
    
        // console.log("firstSeparator left HTML");
    
      } else {
        firstSeparator.style.display = 'none';
      }
    
    }
    
    hideFirstSeparatorOnDesktop();
    
    // help block blue tooltip
    function offerCardDesktopHelpMove() {
      let offerCardDesktopHelp = document.querySelector('.offers-catalog-desktop__help');
      let secondOfferCardDesktopHelp = document.querySelector('.offers-catalog-desktop__help-second');
    
      if (offerCardDesktopHelp === null || secondOfferCardDesktopHelp === null) {
    
        // console.log("offerCardDesktopHelp left HTML");
    
      } else {
        offerCardDesktopHelp.classList.add('offers-catalog-desktop__help--active');
    
        let offerCardDesktopHelpBtn = offerCardDesktopHelp.querySelector('.offerCardDesktopHelpBtn');
        let secondOfferCardDesktopHelpBtn = secondOfferCardDesktopHelp.querySelector('.offerCardDesktopHelpBtnSecond');
    
        if (offerCardDesktopHelpBtn === null || secondOfferCardDesktopHelpBtn === null) {
    
          // console.log("offerCardDesktopHelpBtn left HTML");
      
        } else {
    
          offerCardDesktopHelpBtn.addEventListener('click', function() {
            offerCardDesktopHelp.classList.remove('offers-catalog-desktop__help--active');
            secondOfferCardDesktopHelp.classList.add('offers-catalog-desktop__help-second--active');
    
          });
    
          secondOfferCardDesktopHelpBtn.addEventListener('click', function() {
            secondOfferCardDesktopHelp.classList.remove('offers-catalog-desktop__help-second--active');
          });
        }
      }
    }
    // setTimeout(offerCardDesktopHelpMove, 2000);
    
    // Desktop card offer more button
    function desktopCardMoreBtn(){
      let desktopCards = document.querySelectorAll('.short-card-description');
    
      if(desktopCards === null){
        // console.log('no offers on page');
      }else{
        for(let i = 0; i < desktopCards.length;i++){
          desktopCards[i].addEventListener('mouseover', function(e){
            e.preventDefault();
            let currentCard = this;
            let currentBtn = currentCard.querySelector('.short-card-description__more');
    
            if(currentBtn === null){
              
            } else {
              currentBtn.classList.add('short-card-description__more--hover');
            }
          });
    
          desktopCards[i].addEventListener('mouseout', function(e){
            e.preventDefault();
    
            let currentCard = this;
            let currentBtn = currentCard.querySelector('.short-card-description__more');
    
            if(currentBtn === null){
              
            } else {
              currentBtn.classList.remove('short-card-description__more--hover');
            }
          });
        }
      }
    }
    
    desktopCardMoreBtn();
    
    //fix for ios - disable auto zoom on inputs fields + iOS telephone blue mark FIX
    function changeMetaTagOnPage(){
      let viewport = document.querySelector("meta[name=viewport]");
      if(viewport === null){
    
      }else{
        viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0');
    
        //iOS phone FIX
        let meta = document.createElement('meta');
        let mobilePhoneBlock = document.querySelector('.right-panel__info');
        if(mobilePhoneBlock === null){
    
        }else{
          mobilePhoneBlock.innerHTML = `+7 (495) &zwj;649 60 60`;
          meta.name = "format-detection";
          meta.content = "telephone=no";
          document.getElementsByTagName('head')[0].appendChild(meta);
        }
      }
    }
    
    changeMetaTagOnPage();
    
    //Favorite TO EMAIL
    function favoriteToEmailForm(){
      const favoriteForm = document.querySelectorAll('.favorite-to-mail-form');
    
      if(favoriteForm === null){
    
      }else{
        const emailPattern = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    
        for(let i = 0; i < favoriteForm.length; i++){
          const favoriteFormInput = favoriteForm[i].querySelector('.favorite-to-mail-form__input');
          const favoriteFormButton = favoriteForm[i].querySelector('.favorite-to-mail-form__button');
          const favoriteFormHelper = favoriteForm[i].querySelector('.favorite-to-mail-form__helper');
          const body = document.querySelector('body');
          
          favoriteFormButton.addEventListener('click', function favoriteFormButtonClick(e){
            const favoriteFromInputValue = favoriteFormInput.value;
            // console.warn('favoriteFromInputValue');
            // console.warn(favoriteFromInputValue);
    
            //check input value
            if (emailPattern.test(favoriteFromInputValue)) {
              // console.warn('IT IS EMAIL');
              // const favoriteFromInputValueJSON = JSON.stringify(favoriteFromInputValue);
              // console.warn(favoriteFromInputValueJSON);
              localStorage.setItem('favoriteFromInputValue', favoriteFromInputValue);
    
              favoriteToEmailFormSend();
              
            } else {
              // console.warn('IT IS NOT EMAIL');
              favoriteFormInput.classList.add('favorite-to-mail-form__input--alert');
              favoriteFormHelper.classList.add('favorite-to-mail-form__helper--alert');
              favoriteFormHelper.innerText = 'Проверьте правильность адреса почты';
    
              function favoriteFromHelperReset(){
                favoriteFormInput.classList.remove('favorite-to-mail-form__input--alert');
                favoriteFormHelper.classList.remove('favorite-to-mail-form__helper--alert');
                favoriteFormHelper.innerText = 'Отправить список Избранного на почту';
              }
              setTimeout(favoriteFromHelperReset, 4000);
            }
    
            function favoriteToEmailFormSend(){
              const favoriteFromInputValue = localStorage.getItem('favoriteFromInputValue');
              const params = new URLSearchParams();
              params.set('email', favoriteFromInputValue);
      
              let xhr = new XMLHttpRequest();
      
              xhr.open('POST', '/favorite/send');
              xhr.responseType = 'json';
      
              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      
              xhr.onload = () => {
                if (xhr.status !== 200) {
                  console.warn('favoriteToEmailFormSend ajax error');
                  favoriteFormHelper.innerText = 'Ошибка, попробуйте позже :)';
                } else {
                  const response = xhr.response;
                  //generate modal
                  let favoriteFormModal = document.createElement('div');
                  favoriteFormModal.classList.add('favorite-to-mail-form-modal');
                  favoriteFormModal.innerHTML = `
                      <div class="favorite-to-mail-form-modal__blur"></div>
                      <div class="favorite-to-mail-form-modal__wrapper">
                      
                          <div class="favorite-to-mail-form-modal__close"></div>
    
                          <div class="favorite-to-mail-form-modal__pic">
                              
                          </div>
    
                          <div class="favorite-to-mail-form-modal__subtitle">
                              Список Избранного успешно отправлен на почту ${favoriteFromInputValue}
                          </div>
    
                          <div class="favorite-to-mail-form-modal__button">Отлично!</div>
    
                      </div>
                  `;
    
                  body.appendChild(favoriteFormModal);
                  favoriteFormModal.style.display = 'block';
                  body.classList.add('page-body__no-scroll');
    
                  const favoriteFormModalButton = favoriteFormModal.querySelector('.favorite-to-mail-form-modal__button');
                  const favoriteFormModalClose = favoriteFormModal.querySelector('.favorite-to-mail-form-modal__close');
                  const favoriteFormModalBlur = favoriteFormModal.querySelector('.favorite-to-mail-form-modal__blur');
    
                  favoriteFormModalButton.addEventListener('click', function(){
                    favoriteFormModal.style.display = 'none';
                    body.classList.remove('page-body__no-scroll');
                  });
    
                  favoriteFormModalClose.addEventListener('click', function(){
                    favoriteFormModal.style.display = 'none';
                     body.classList.remove('page-body__no-scroll');
                  });
    
                  favoriteFormModalBlur.addEventListener('click', function(){
                    favoriteFormModal.style.display = 'none';
                     body.classList.remove('page-body__no-scroll');
                  });
    
                  favoriteFormButton.removeEventListener('click', favoriteFormButtonClick);
                  favoriteFormHelper.innerText = `Список успешно отправлен`;
      
                }
              }
      
              xhr.send(params);
            }
          });
        }
      }
    }
    
    favoriteToEmailForm();
    
    //OFFERS catalog Sort by Price DESKTOP
    function offersCatalogSortByPriceMechDesktop(){
      const offerCardPricesContainer = document.querySelectorAll('.full-desktop-card')
      
      if(offerCardPricesContainer === null){
    
      }else{
        for(let i = 0; i < offerCardPricesContainer.length; i++){
          const sortByPriceAllPrices = offerCardPricesContainer[i].querySelectorAll('.desktop-card-item');
          const sortByPriceAllPricesParent = offerCardPricesContainer[i].querySelector('.full-desktop-card__list');
          
          const sortByPriceBtnMain = offerCardPricesContainer[i].querySelector('.offers-desktop-filter-price');
          const sortByPriceList = offerCardPricesContainer[i].querySelector('.offers-desktop-filter-price__list');
          const sortByPriceSortBtnDescending = offerCardPricesContainer[i].querySelector('.offers-desktop-filter-price__item:first-child');
          const sortByPriceSortBtnAscending = offerCardPricesContainer[i].querySelector('.offers-desktop-filter-price__item:last-child');
    
          sortByPriceBtnMain.addEventListener('click', function(){
            sortByPriceList.classList.toggle('offers-desktop-filter-price__list--active');
            sortByPriceBtnMain.classList.toggle('offers-desktop-filter-price--active');
          });
    
          function optionalPriceToEnd(){
            sortByPriceAllPrices.forEach(function(item, i) {
              const optionalPriceBlock = item.querySelector('.desktop-card-item__price--optional');
    
              if(optionalPriceBlock === null){
    
              }else{
                // console.warn(optionalPriceBlock)
                if(item.contains(optionalPriceBlock)){
                  item.style.order = '7';
                }
              }
            })
          }
    
          //Сортировать по Убыванию
          sortByPriceSortBtnDescending.addEventListener('click', function(){
            // let items = document.querySelectorAll('.appartments-item');
            // let parent = document.body;
            let SortElements = new Object();
            sortByPriceAllPrices.forEach(function(item, indx){
              let itemPriceValue = item.querySelector('.desktop-card-item__price');
              if(itemPriceValue === null){
    
              }else{
                let itemPriceValueInnerText = itemPriceValue.innerText;
                let itemPriceValueFormated = itemPriceValueInnerText.split(' ').join('');
                SortElements[itemPriceValueFormated] = {'element': item, 'index': indx} ;
              }
              // let itemPriceValue = parseInt(item.querySelector('.desktop-card-item__price').innerText.split(' ').join(''));
              // SortElements[itemPriceValue] = {'element': item, 'index': indx} ;
            });
            let keys = Object.keys(SortElements);
            function compareNumeric(a, b) {
              a = parseInt(a);
              b = parseInt(b);
              if (a < b) return 1;
              if (a > b) return -1;
            }
            keys.sort(compareNumeric);
            // console.warn(SortElements)
            keys.map(function(key, indx){
              sortByPriceAllPricesParent.insertAdjacentElement('beforeend', SortElements[key]['element']);
            });
    
            
            optionalPriceToEnd();
          });
          //Сортировать по Возрастанию
          sortByPriceSortBtnAscending.addEventListener('click', function(){
            let SortElements = new Object();
            sortByPriceAllPrices.forEach(function(item, indx){
              let itemPriceValue = item.querySelector('.desktop-card-item__price');
              if(itemPriceValue === null){
    
              }else{
                let itemPriceValueInnerText = itemPriceValue.innerText;
                let itemPriceValueFormated = itemPriceValueInnerText.split(' ').join('');
                SortElements[itemPriceValueFormated] = {'element': item, 'index': indx} ;
              }
            });
            let keys = Object.keys(SortElements);
            function compareNumeric(a, b) {
              a = parseInt(a);
              b = parseInt(b);
              if (a < b) return -1;
              if (a > b) return 1;
            }
            keys.sort(compareNumeric);
            // console.warn(SortElements)
            keys.map(function(key, indx){
              sortByPriceAllPricesParent.insertAdjacentElement('beforeend', SortElements[key]['element']);
            });
    
            optionalPriceToEnd();
          });
        }
      }
    }
    
    offersCatalogSortByPriceMechDesktop();
    
    //OFFERS catalog Sort by Price MOBILE
    function offersCatalogSortByPriceMechMobile(){
      const offerCardPricesContainer = document.querySelectorAll('.full-mobile-card')
      
    
      if(offerCardPricesContainer === null){
    
      }else{
        for(let i = 0; i < offerCardPricesContainer.length; i++){
          const sortByPriceAllPrices = offerCardPricesContainer[i].querySelectorAll('.mobile-list-item');
          const sortByPriceAllPricesParent = offerCardPricesContainer[i].querySelector('.full-mobile-card__list');
          
          const sortByPriceBtnMain = offerCardPricesContainer[i].querySelector('.offers-mobile-filter-price');
          const sortByPriceList = offerCardPricesContainer[i].querySelector('.offers-mobile-filter-price__list');
          const sortByPriceSortBtnDescending = offerCardPricesContainer[i].querySelector('.offers-mobile-filter-price__item:first-child');
          const sortByPriceSortBtnAscending = offerCardPricesContainer[i].querySelector('.offers-mobile-filter-price__item:last-child');
    
          sortByPriceBtnMain.addEventListener('click', function(){
            sortByPriceList.classList.toggle('offers-mobile-filter-price__list--active');
            sortByPriceBtnMain.classList.toggle('offers-mobile-filter-price--active');
          });
    
          function optionalPriceToEnd(){
            sortByPriceAllPrices.forEach(function(item, i) {
              const optionalPriceBlock = item.querySelector('.mobile-buy__price--optional');
    
              if(optionalPriceBlock === null){
    
              }else{
                // console.warn(optionalPriceBlock)
                if(item.contains(optionalPriceBlock)){
                  item.style.order = '7';
                }
              }
            })
          }
    
          //Сортировать по Убыванию
          sortByPriceSortBtnDescending.addEventListener('click', function(){
            // let items = document.querySelectorAll('.appartments-item');
            // let parent = document.body;
            let SortElements = new Object();
            sortByPriceAllPrices.forEach(function(item, indx){
              let itemPriceValue = item.querySelector('.mobile-buy__price');
              if(itemPriceValue === null){
    
              }else{
                let itemPriceValueInnerText = itemPriceValue.innerText;
                let itemPriceValueFormated = itemPriceValueInnerText.split(' ').join('');
                SortElements[itemPriceValueFormated] = {'element': item, 'index': indx} ;
              }
              // let itemPriceValue = parseInt(item.querySelector('.desktop-card-item__price').innerText.split(' ').join(''));
              // SortElements[itemPriceValue] = {'element': item, 'index': indx} ;
            });
            let keys = Object.keys(SortElements);
            function compareNumeric(a, b) {
              a = parseInt(a);
              b = parseInt(b);
              if (a < b) return 1;
              if (a > b) return -1;
            }
            keys.sort(compareNumeric);
            // console.warn(SortElements)
            keys.map(function(key, indx){
              sortByPriceAllPricesParent.insertAdjacentElement('beforeend', SortElements[key]['element']);
            });
    
            
            optionalPriceToEnd();
          });
          
          //Сортировать по Возрастанию
          sortByPriceSortBtnAscending.addEventListener('click', function(){
            let SortElements = new Object();
            sortByPriceAllPrices.forEach(function(item, indx){
              let itemPriceValue = item.querySelector('.mobile-buy__price');
              if(itemPriceValue === null){
    
              }else{
                let itemPriceValueInnerText = itemPriceValue.innerText;
                let itemPriceValueFormated = itemPriceValueInnerText.split(' ').join('');
                SortElements[itemPriceValueFormated] = {'element': item, 'index': indx} ;
              }
            });
            let keys = Object.keys(SortElements);
            function compareNumeric(a, b) {
              a = parseInt(a);
              b = parseInt(b);
              if (a < b) return -1;
              if (a > b) return 1;
            }
            keys.sort(compareNumeric);
            // console.warn(SortElements)
            keys.map(function(key, indx){
              sortByPriceAllPricesParent.insertAdjacentElement('beforeend', SortElements[key]['element']);
            });
    
            optionalPriceToEnd();
          });
        }
      }
    }
    
    offersCatalogSortByPriceMechMobile();
    
    //sorting in opened offer card
    function openedCartFunctions(){
      const offerCardOpenned = document.querySelector('.offers-vendor-catalog-desktop__offer');
    
      if(offerCardOpenned === null){
    
      }else{
        function offersCatalogONSortByPriceMechDesktop(){
          const offerCardPricesContainer = document.querySelectorAll('.full-desktop-card--on')
          
          if(offerCardPricesContainer === null){
        
          }else{
            for(let i = 0; i < offerCardPricesContainer.length; i++){
              const sortByPriceAllPrices = offerCardPricesContainer[i].querySelectorAll('.desktop-card-item');
              const sortByPriceAllPricesParent = offerCardPricesContainer[i].querySelector('.full-desktop-card__list');
              
              const sortByPriceBtnMain = offerCardPricesContainer[i].querySelector('.offers-desktop-filter-price');
              const sortByPriceList = offerCardPricesContainer[i].querySelector('.offers-desktop-filter-price__list');
              const sortByPriceSortBtnDescending = offerCardPricesContainer[i].querySelector('.offers-desktop-filter-price__item:first-child');
              const sortByPriceSortBtnAscending = offerCardPricesContainer[i].querySelector('.offers-desktop-filter-price__item:last-child');
        
              sortByPriceBtnMain.addEventListener('click', function(){
                sortByPriceList.classList.toggle('offers-desktop-filter-price__list--active');
                sortByPriceBtnMain.classList.toggle('offers-desktop-filter-price--active');
              });
        
              function optionalPriceToEnd(){
                sortByPriceAllPrices.forEach(function(item, i) {
                  const optionalPriceBlock = item.querySelector('.desktop-card-item__price--optional');
        
                  if(optionalPriceBlock === null){
        
                  }else{
                    // console.warn(optionalPriceBlock)
                    if(item.contains(optionalPriceBlock)){
                      item.style.order = '7';
                    }
                  }
                })
              }
        
              //Сортировать по Убыванию
              sortByPriceSortBtnDescending.addEventListener('click', function(){
                // let items = document.querySelectorAll('.appartments-item');
                // let parent = document.body;
                let SortElements = new Object();
                sortByPriceAllPrices.forEach(function(item, indx){
                  let itemPriceValue = item.querySelector('.desktop-card-item__price');
                  if(itemPriceValue === null){
        
                  }else{
                    let itemPriceValueInnerText = itemPriceValue.innerText;
                    let itemPriceValueFormated = itemPriceValueInnerText.split(' ').join('');
                    SortElements[itemPriceValueFormated] = {'element': item, 'index': indx} ;
                  }
                  // let itemPriceValue = parseInt(item.querySelector('.desktop-card-item__price').innerText.split(' ').join(''));
                  // SortElements[itemPriceValue] = {'element': item, 'index': indx} ;
                });
                let keys = Object.keys(SortElements);
                function compareNumeric(a, b) {
                  a = parseInt(a);
                  b = parseInt(b);
                  if (a < b) return 1;
                  if (a > b) return -1;
                }
                keys.sort(compareNumeric);
                // console.warn(SortElements)
                keys.map(function(key, indx){
                  sortByPriceAllPricesParent.insertAdjacentElement('beforeend', SortElements[key]['element']);
                });
        
                
                optionalPriceToEnd();
              });
              //Сортировать по Возрастанию
              sortByPriceSortBtnAscending.addEventListener('click', function(){
                let SortElements = new Object();
                sortByPriceAllPrices.forEach(function(item, indx){
                  let itemPriceValue = item.querySelector('.desktop-card-item__price');
                  if(itemPriceValue === null){
        
                  }else{
                    let itemPriceValueInnerText = itemPriceValue.innerText;
                    let itemPriceValueFormated = itemPriceValueInnerText.split(' ').join('');
                    SortElements[itemPriceValueFormated] = {'element': item, 'index': indx} ;
                  }
                });
                let keys = Object.keys(SortElements);
                function compareNumeric(a, b) {
                  a = parseInt(a);
                  b = parseInt(b);
                  if (a < b) return -1;
                  if (a > b) return 1;
                }
                keys.sort(compareNumeric);
                // console.warn(SortElements)
                keys.map(function(key, indx){
                  sortByPriceAllPricesParent.insertAdjacentElement('beforeend', SortElements[key]['element']);
                });
        
                optionalPriceToEnd();
              });
            }
          }
        }
        
        offersCatalogONSortByPriceMechDesktop();
       
      }
    }
    openedCartFunctions();
    
    
    // Mechs from back || Pagination
    function fetchingOffersPage(pageNumber = 1){
            
      const xhr = new XMLHttpRequest();
      let page = '?page='+pageNumber;
      const finalItemCode = window.location.href.split('/')[6];
      let requestUrl = `/catalog/offers/`+finalItemCode+`${page}`;
      let offersContainer = document.querySelector('.offersContainer');
      let preloaderContainer = document.querySelector('.preloader-container');
      xhr.open("POST", requestUrl, true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      offersContainer.style.display = 'none';
      preloaderContainer.style.display = 'block';
      xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              const response = xhr.response;
              let responseHtml = document.createElement("div");
              responseHtml.innerHTML = response;
              
              offersContainer.firstChild.replaceWith(responseHtml);
              hideFirstSeparatorOnMobile();
              hideFirstSeparatorOnDesktop();
              offerCardMobileOpen();                                   
              offerCardMobileInfoOpen();
              
              offerCardDesktopOpen();
              offerCardDesktopInfoOpen();
              offerCardMobileBuyButtonMech();
              offerCardDesktopBuyButtonMech();
              offerCardDesktopBuyButtonTooltip();
              offerCardDesktopBuyButtonDoneTooltip();
              offerCardMobileFastBuy();
              offerCardDesktopFastBuy();
              offerCardDesktopBuyButtonTooltip();
              offerCardDesktopFastBuyTooltipMech();
              desktopCardMoreBtn();
              offersCardDesktopFavoriteBtnAdd();
              offersCardDesktopFavoriteBtnRemove();
              offerCardFavoriteBtnMobileAdd();
              offerCardFavoriteBtnMobileRemove();
              offersCatalogSortByPriceMechDesktop();
              offersCatalogSortByPriceMechMobile();
              shopCatalogPager();
              generateNextOfferBtn();
              
              preloaderContainer.style.display = 'none';
              offersContainer.style.display = 'block';
              
              //Smooth scroll to the proper position
              const yOffset = -90; 
              const offersContOffset = offersContainer.getBoundingClientRect().top;
              const y = offersContOffset + window.pageYOffset + yOffset;
              window.scrollTo({top: y, behavior: 'smooth'});
          }
      } 
      
      xhr.send(requestUrl);
    }
    function shopCatalogPager() {
      let pagerLinks = document.querySelectorAll('.pagination__list a');
      for (let i = 0; i < pagerLinks.length; i++) {
        
        pagerLinks[i].addEventListener('click', function(e){
            e.preventDefault();
            let pageNumber = this.getAttribute('href').split('=')[1];
            fetchingOffersPage(pageNumber);
        });
      }
    }
    function generateNextOfferBtn() {
      const finalItemCode = window.location.href.split('/')[6];
      let nextElParent = document.querySelector('[data-code="'+finalItemCode+'"]').parentElement.nextElementSibling;
      let nextOfferBtn = document.querySelector('.offers-catalog-next-btn');

      if (nextElParent) {
        let nextElLink = nextElParent.querySelector('a').getAttribute('href');
        let nextElText = nextElParent.querySelector('a').querySelectorAll('div')[1].innerText;

        if (nextOfferBtn) {
          nextOfferBtn.setAttribute('href', nextElLink);
          nextOfferBtn.querySelector('.offers-catalog-next-btn__text b').innerText = nextElText;
        }
      } else {
        if (nextOfferBtn) {
          nextOfferBtn.style.display = 'none';
        }
      }
    }
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
                        // console.warn('СЛАЙДЕР, ПРИКАЗЫВАЮ ТЕБЕ, ЗАМРИ!!!')
                        clearInterval(window.sliderTimer);
                    });
    
                    currentSlider.addEventListener('mouseleave', function(){
                        // console.warn('СЛАЙДЕР, ОТОМРИ, ОКАЯНЫЙ!!!')
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
    function dadataApi(){  
        const currentIp = fetch('https://ipwho.is/')
            .then((responce) => responce.json())
            .then((data) => {
                const currentIpResult = data.ip
                console.log('currentIpResult');
                console.log(currentIpResult);
                let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address?ip=";
                let token = "7d7a4b089cea1b122a5a6e748afc75458f420444";
                let query = currentIpResult;
            
                let options = {
                    method: "GET",
                    mode: "cors",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + token
                    }
                }
            
                fetch(url + query, options)
                .then(response => response.json())
                .then((result) => {
                    // console.log(result.location.data.city)
                    const currentCity = result.location.data.city
                    //Change user location
                    let userLocationHeader = document.querySelector('.search-panel__user-location span');
                    if(userLocationHeader === null){
                        let userLocationCartHeader = document.querySelector('.header-cart-desktop__user-location span');
                        userLocationCartHeader.innerText = currentCity;
                    }else{
                        userLocationHeader.innerText = currentCity;
                    }
                    
                })
                .catch(error => console.log("error", error));
    
            });      
    }
    
    dadataApi()