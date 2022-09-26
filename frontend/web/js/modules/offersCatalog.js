// Mobile
"use strict";
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
        
        // let currentPreloader = document.createElement('div');
        // currentPreloader.classList.add('short-options-mobile__favorite-preloader');
        // shortOptionsMobile[i].appendChild(currentPreloader);

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
                              // dynamic data from cart
                              const response = xhr.response;
                              let countFromCart = response.count; 
                              cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                              cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                              console.warn(cartBtnDesktopMainHeaderSpan);
                              stickyHeaderDesktopCartCountUpdate();

                              afterBuyInput.placeholder = noModalCustomQuantityInputValue;
                            }
                          }

                          xhr.send(params);
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
                          console.warn('noModalCustomQuantityInputValue === empty string');

                        }else{
                          // console.warn('noModalCustomQuantityInputValue');
                          // console.warn(noModalCustomQuantityInputValue);

                          const params = new URLSearchParams();
                          params.set('id', key);
                          params.append('qty', noModalCustomQuantityInputValue);

                          let xhr = new XMLHttpRequest();

                          xhr.open('POST', '/cart/change');
                          xhr.responseType = 'json';

                          xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                          xhr.onload = () => {
                            if (xhr.status !== 200) {
                              console.warn('modalCustomQuantityBuyButtonMech ajax error');
                            } else {
                              // console.warn('modalCustomQuantityBuyButtonMech ajax SUCCESS');
                              // dynamic data from cart
                              const response = xhr.response;
                              let countFromCart = response.count; 
                              cartBtnDesktopMainHeaderSpan.style.visibility = 'visible';
                              cartBtnDesktopMainHeaderSpan.innerText = countFromCart;
                              // console.warn(cartBtnDesktopMainHeaderSpan);
                              stickyHeaderDesktopCartCountUpdate();

                              afterBuyInput.placeholder = noModalCustomQuantityInputValue;

                            }
                          }

                          xhr.send(params);
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



//Remove default title-tooltips
function offerCardDesktopBuyButtonRemoveDefaultTitleTooltip(){
  let buyBtns = document.querySelectorAll('.desktop-buy__buy-btn');

  if(buyBtns === null){

  }else{
    buyBtns.forEach(item => {
      item.removeAttribute("title");
    })
  }
}

offerCardDesktopBuyButtonRemoveDefaultTitleTooltip();
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
                    console.warn('mobileCustomQuantityInputValue');
                    console.warn(mobileCustomQuantityInputValue);
  
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
                        // dynamic data from cart
                        const response = xhr.response;
                        let countFromCart = response.count; 
                        cartBtnMobileMainHeader.innerText = countFromCart;
                        stickyHeaderMobileCartCountUpdate();
  
                        afterBuyInput.placeholder = mobileCustomQuantityInputValue;
  
                      }
                    }
                    xhr.send(params);
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
                thisBtn.after(responseFormBlock);
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

offerCardDesktopFastBuy();

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

      if (desktopProp === null || desktopInfoBlock === null || desktopInfoBlockClose === null) {
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