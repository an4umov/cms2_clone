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