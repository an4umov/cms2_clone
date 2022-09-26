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