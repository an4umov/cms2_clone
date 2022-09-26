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
        
	} else {
        

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