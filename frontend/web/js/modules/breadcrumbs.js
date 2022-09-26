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