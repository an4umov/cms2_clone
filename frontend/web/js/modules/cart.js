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
                    desktopProductCardBtnMinus.classList.remove('cart-desktop-product-quantity__btn-minus');
                    desktopProductCardBtnMinus.classList.add('cart-desktop-product-quantity__btn-minus--disable');
                }
            }
            cartMinusBtnDisable();
            //minus btn disable state reset
            function cartMinusBtnReset(){
                desktopProductCardBtnMinus.classList.remove('cart-desktop-product-quantity__btn-minus--disable');
                desktopProductCardBtnMinus.classList.add('cart-desktop-product-quantity__btn-minus');
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
cartDesktopProductCardQuantity();

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
cartMobileProductCardQuantity()

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