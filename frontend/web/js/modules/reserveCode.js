//part of code from shop-catalog-page - 5 lvl of catalog
let fifthSection = document.querySelector('.shop-catalog-desktop__inner--fifth');
    let fifthTitle = document.querySelector('.shop-catalog-desktop__title--fifth');
    let fifthTitleOpen = document.querySelector('.shop-catalog-desktop__title-open--fifth');
    let fifthTitleStatic = document. querySelector('.shop-catalog-desktop__title-static--fifth');
    let fifthSectionItems = document.querySelectorAll('.shop-catalog-desktop__item--fifth');

fifthTitleOpen.style.display = 'none';
fifthTitleStatic.style.display = 'block';

     //First section
firstTitleOpen.addEventListener('click', function(){
    for(let i = 0; i < firstSectionItems.length; i++){
        firstSectionItems[i].style.display = 'none';
    }

    firstTitleOpen.style.display = 'none';
    firstTitleClose.style.display = 'flex';

    firstSection.append(secondTitle);

    for(let i = 0; i < secondSectionItems.length; i++){
        let allSecondsItems = secondSectionItems[i];
        firstSection.append(allSecondsItems);
    }

    if(secondSection.contains(fifthTitle)){
        console.log('3 & 4 & 5 in 2');

        firstSection.append(thirdTitle);
        firstSection.append(fourthTitle);
        firstSection.append(fifthTitle);

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
        firstSection.append(allThirdItems);
        }

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            firstSection.append(allFourthItems);
        }

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            firstSection.append(allFifthItems);
        }



    } else if(secondSection.contains(thirdTitle) && secondSection.contains(fourthTitle)){
        console.log('3 & 4 in 2');

        firstSection.append(thirdTitle);
        firstSection.append(fourthTitle);

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
        firstSection.append(allThirdItems);
        }

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            firstSection.append(allFourthItems);
        }

    }  else if (secondSection.contains(thirdTitle)){
        console.log('3 in 2');

        firstSection.append(thirdTitle);

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
        firstSection.append(allThirdItems);
        }

    }

});

firstTitleClose.addEventListener('click', function(){
    for(let i = 0; i < firstSectionItems.length; i++){
        firstSectionItems[i].style.display = 'flex';
    }

    firstTitleOpen.style.display = 'flex';
    firstTitleClose.style.display = 'none';

    secondSection.append(secondTitle);

    for(let i = 0; i < secondSectionItems.length; i++){
        let allSecondsItems = secondSectionItems[i];
        secondSection.append(allSecondsItems);
    }

    if(firstSection.contains(fifthTitle)){
        console.log('3 & 4 & 5 in 1');

        secondSection.append(thirdTitle);
        secondSection.append(fourthTitle);
        secondSection.append(fifthTitle);

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
        secondSection.append(allThirdItems);
        }

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            secondSection.append(allFourthItems);
        }

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            secondSection.append(allFifthItems);
        }

        

    } else if(firstSection.contains(thirdTitle) && firstSection.contains(fourthTitle)){
        console.log('3 & 4 in 1');

        secondSection.append(thirdTitle);
        secondSection.append(fourthTitle);

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
        secondSection.append(allThirdItems);
        }

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            secondSection.append(allFourthItems);
        }

    }else if(firstSection.contains(thirdTitle)){
        console.log('2 in 1');

        secondSection.append(thirdTitle);

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
        secondSection.append(allThirdItems);
        }

    } 
});

for(let i = 0; i < firstSectionItems.length; i++){
    let firstItemsTextBlock = firstSectionItems[i].querySelector('.shop-catalog-desktop__item-text');

    firstSectionItems[i].addEventListener('mouseover', function(){
        firstItemsTextBlock.classList.add('shop-catalog-desktop__item-text--hover');
    });

    firstSectionItems[i].addEventListener('mouseout', function(){
        firstItemsTextBlock.classList.remove('shop-catalog-desktop__item-text--hover');
    });
}

for(let i = 0; i < secondSectionItems.length; i++){
    let firstItemsTextBlock = secondSectionItems[i].querySelector('.shop-catalog-desktop__item-text');

    secondSectionItems[i].addEventListener('mouseover', function(){
        firstItemsTextBlock.classList.add('shop-catalog-desktop__item-text--hover');
    });

    secondSectionItems[i].addEventListener('mouseout', function(){
        firstItemsTextBlock.classList.remove('shop-catalog-desktop__item-text--hover');
    });
}

for(let i = 0; i < thirdSectionItems.length; i++){
    let firstItemsTextBlock = thirdSectionItems[i].querySelector('.shop-catalog-desktop__item-text');

    thirdSectionItems[i].addEventListener('mouseover', function(){
        firstItemsTextBlock.classList.add('shop-catalog-desktop__item-text--hover');
    });

    thirdSectionItems[i].addEventListener('mouseout', function(){
        firstItemsTextBlock.classList.remove('shop-catalog-desktop__item-text--hover');
    });
}

for(let i = 0; i < fourthSectionItems.length; i++){
    let firstItemsTextBlock = fourthSectionItems[i].querySelector('.shop-catalog-desktop__item-text');

    fourthSectionItems[i].addEventListener('mouseover', function(){
        firstItemsTextBlock.classList.add('shop-catalog-desktop__item-text--hover');
    });

    fourthSectionItems[i].addEventListener('mouseout', function(){
        firstItemsTextBlock.classList.remove('shop-catalog-desktop__item-text--hover');
    });
}

for(let i = 0; i < fifthSectionItems.length; i++){
    let firstItemsTextBlock = fifthSectionItems[i].querySelector('.shop-catalog-desktop__item-text');

    fifthSectionItems[i].addEventListener('mouseover', function(){
        firstItemsTextBlock.classList.add('shop-catalog-desktop__item-text--hover');
    });

    fifthSectionItems[i].addEventListener('mouseout', function(){
        firstItemsTextBlock.classList.remove('shop-catalog-desktop__item-text--hover');
    });
}

//Second section

secondTitleOpen.addEventListener('click', function(){
    for(let i = 0; i < secondSectionItems.length; i++){
        secondSectionItems[i].style.display = 'none';
    }

    secondTitleOpen.style.display = 'none';
    secondTitleClose.style.display = 'flex';
    
    if(firstSection.contains(secondTitle) && thirdSection.contains(fifthTitle)){
        console.log('5 in 2');

        firstSection.append(thirdTitle);
        firstSection.append(fourthTitle); 
        firstSection.append(fifthTitle); 

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
            firstSection.append(allThirdItems);
        }
        
        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            firstSection.append(allFourthItems);
        }

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            firstSection.append(allFifthItems);
        }
    } else if(thirdSection.contains(fifthTitle)){
        console.log('5 in 3');

        secondSection.append(thirdTitle);
        secondSection.append(fourthTitle); 
        secondSection.append(fifthTitle); 

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
            secondSection.append(allThirdItems);
        }
        
        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            secondSection.append(allFourthItems);
        }

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            secondSection.append(allFifthItems);
        }
    }else if(thirdSection.contains(fourthTitle)){
        console.log('4 in 3');

        secondSection.append(thirdTitle);
        secondSection.append(fourthTitle); 

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
            secondSection.append(allThirdItems);
        }
        
        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            secondSection.append(allFourthItems);
        }
    }else if(firstSection.contains(secondTitle)){
        console.log('2 in 1');

        firstSection.append(thirdTitle); 
        
        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
            firstSection.append(allThirdItems);
        }
    } else if(secondSection.contains(secondTitle)){
        console.log('2 in 2');

        secondSection.append(thirdTitle);

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
            secondSection.append(allThirdItems);
        }

    }
});

secondTitleClose.addEventListener('click', function(){
    for(let i = 0; i < secondSectionItems.length; i++){
        secondSectionItems[i].style.display = 'flex';
    }

    secondTitleClose.style.display = 'none';
    secondTitleOpen.style.display = 'flex';

    thirdSection.append(thirdTitle);

    for(let i = 0; i < thirdSectionItems.length; i++){
        let allThirdItems = thirdSectionItems[i];
        thirdSection.append(allThirdItems);
    }

    if(firstSection.contains(fifthTitle)){
        console.log('5 in 1');

        thirdSection.append(thirdTitle);
        thirdSection.append(fourthTitle);      
        thirdSection.append(fifthTitle);

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            thirdSection.append(allFifthItems);
        }
        
        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            thirdSection.append(allFourthItems);
        }

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
            thirdSection.append(allThirdItems);
        }

    } else if(secondSection.contains(fifthTitle)){
        console.log('5 in 2');

        thirdSection.append(thirdTitle);
        thirdSection.append(fourthTitle);      
        thirdSection.append(fifthTitle);

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            thirdSection.append(allFifthItems);
        }
        
        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            thirdSection.append(allFourthItems);
        }

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
            thirdSection.append(allThirdItems);
        }

    } else if(firstSection.contains(secondTitle) && firstSection.contains(fourthTitle) && firstSection.contains(fourthTitle)){
        console.log('3 & 4 in 1');

        thirdSection.append(thirdTitle);
        thirdSection.append(fourthTitle);

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
        thirdSection.append(allThirdItems);
        }

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            thirdSection.append(allFourthItems);
        }

        

    } else if(secondSection.contains(thirdTitle) && secondSection.contains(fourthTitle)){
        console.log('3 & 4 in 2');

        thirdSection.append(fourthTitle);
        thirdSection.append(thirdTitle);
        
        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            thirdSection.append(allFourthItems);
        }

        for(let i = 0; i < thirdSectionItems.length; i++){
            let allThirdItems = thirdSectionItems[i];
        thirdSection.append(allThirdItems);
        }

        

    } else if(secondSection.contains(fourthTitle)){
        console.log('4 in 3');

        thirdSection.append(fourthTitle);

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            thirdSection.append(allFourthItems);
        }

    }
    
});

//Third section

thirdTitleOpen.addEventListener('click', function(){
    for(let i = 0; i < thirdSectionItems.length; i++){
        thirdSectionItems[i].style.display = 'none';
    }

    thirdTitleOpen.style.display = 'none';
    thirdTitleClose.style.display = 'block';

    if(firstSection.contains(thirdTitle) && fourthSection.contains(fifthTitle)){
        console.log('3 in 1 && 5 in 4');

        firstSection.append(fourthTitle);
        firstSection.append(fifthTitle);

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            firstSection.append(allFourthItems);
        }

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            firstSection.append(allFifthItems);
        }

    } else if(secondSection.contains(thirdTitle) && fourthSectionItems.contains(fifthTitle)){
        console.log('3 in 2 && 5 in 4');

        secondSection.append(fourthTitle);
        secondSection.append(fifthTitle);

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            secondSection.append(allFourthItems);
        }

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            secondSection.append(allFifthItems);
        }

    } else if(fourthSection.contains(fifthTitle)){
        console.log('5 in 4');

        thirdSection.append(fourthTitle);
        thirdSection.append(fifthTitle);

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            thirdSection.append(allFourthItems);
        }

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            thirdSection.append(allFifthItems);
        }

    }else if(thirdSection.contains(thirdTitle)){
        console.log('3 in 3');

        thirdSection.append(fourthTitle);

        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            thirdSection.append(allFourthItems);
        }
    } else if(secondSection.contains(thirdTitle)){
        console.log('3 in 2');

        secondSection.append(fourthTitle); 
        
        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            secondSection.append(allFourthItems);
        }
    } else if(firstSection.contains(thirdTitle)){
        console.log('3 in 1');

        firstSection.append(fourthTitle); 
        
        for(let i = 0; i < fourthSectionItems.length; i++){
            let allFourthItems = fourthSectionItems[i];
            firstSection.append(allFourthItems);
        }
    } 
    
});

thirdTitleClose.addEventListener('click', function(){
    for(let i = 0; i < thirdSectionItems.length; i++){
        thirdSectionItems[i].style.display = 'flex';
    }

    thirdTitleClose.style.display = 'none';
    thirdTitleOpen.style.display = 'flex';


    fourthSection.append(fourthTitle);

    for(let i = 0; i < fourthSectionItems.length; i++){
        let allFourthItems = fourthSectionItems[i];
        fourthSection.append(allFourthItems);
    }     
    
    if(firstSection.contains(fifthTitle)){
        console.log('5 in 1');

        fourthSection.append(fifthTitle);


        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            fourthSection.append(allFifthItems);
        }
    } else if(secondSection.contains(fifthTitle)){
        console.log('5 in 2');

        fourthSection.append(fifthTitle);


        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            fourthSection.append(allFifthItems);
        }
    } else if(thirdSection.contains(fifthTitle)){
        console.log('5 in 4');

        fourthSection.append(fifthTitle);


        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            fourthSection.append(allFifthItems);
        }
    }
    
    
});

//Fourth section

fourthTitleOpen.addEventListener('click', function(){
    for(let i = 0; i < fourthSectionItems.length; i++){
        fourthSectionItems[i].style.display = 'none';
    }

    fourthTitleOpen.style.display = 'none';
    fourthTitleClose.style.display = 'block';

    if(fourthSection.contains(fourthTitle)){
        console.log('4 in 4');

        fourthSection.append(fifthTitle);

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            fourthSection.append(allFifthItems);
        }
    } else if(thirdSection.contains(fourthTitle)){
        console.log('4 in 3');

        thirdSection.append(fifthTitle);

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            thirdSection.append(allFifthItems);
        }
    } else if(secondSection.contains(fourthTitle)){
        console.log('4 in 2');

        secondSection.append(fifthTitle);

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            secondSection.append(allFifthItems);
        }
    } else if(firstSection.contains(fourthTitle)){
        console.log('4 in 1');

        firstSection.append(fifthTitle);

        for(let i = 0; i < fifthSectionItems.length; i++){
            let allFifthItems = fifthSectionItems[i];
            firstSection.append(allFifthItems);
        }
    }


});

fourthTitleClose.addEventListener('click', function(){
    for(let i = 0; i < fourthSectionItems.length; i++){
        fourthSectionItems[i].style.display = 'flex';
    }
    
    fourthTitleClose.style.display = 'none';
    fourthTitleOpen.style.display = 'block';
    


    fifthSection.append(fifthTitle);

    for(let i = 0; i < fifthSectionItems.length; i++){
        let allFifthItems = fifthSectionItems[i];
        fifthSection.append(allFifthItems);
    }              
});