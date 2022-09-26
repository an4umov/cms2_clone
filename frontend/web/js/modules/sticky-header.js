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