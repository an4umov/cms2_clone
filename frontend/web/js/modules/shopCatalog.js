function shopCatalogMech(){
    let firstSection = document.querySelector('.shop-catalog-desktop__inner');
    let firstTitleOpen = document.querySelector('.shop-catalog-desktop__title-open');
    let firstTitleClose = document.querySelector('.shop-catalog-desktop__title-close');
    let firstSectionItems = document.querySelectorAll('.shop-catalog-desktop__item');

    let secondSection = document.querySelector('.shop-catalog-desktop__inner--second');
    let secondTitle = document.querySelector('.shop-catalog-desktop__title--second');
    let secondTitleOpen = document.querySelector('.shop-catalog-desktop__title-open--second');
    let secondTitleClose = document.querySelector('.shop-catalog-desktop__title-close--second');
    let secondSectionItems = document.querySelectorAll('.shop-catalog-desktop__item--second');

    let thirdSection = document.querySelector('.shop-catalog-desktop__inner--third');
    let thirdTitle = document.querySelector('.shop-catalog-desktop__title--third');
    let thirdTitleOpen = document.querySelector('.shop-catalog-desktop__title-open--third');
    let thirdTitleClose = document.querySelector('.shop-catalog-desktop__title-close--third');
    let thirdTitleStatic = document.querySelector('.shop-catalog-desktop__title-static--third');
    let thirdSectionItems = document.querySelectorAll('.shop-catalog-desktop__item--third');

    let fourthSection = document.querySelector('.shop-catalog-desktop__inner--fourth');
    let fourthTitle = document.querySelector('.shop-catalog-desktop__title--fourth');
    let fourthTitleOpen = document.querySelector('.shop-catalog-desktop__title-open--fourth');
    let fourthTitleClose = document.querySelector('.shop-catalog-desktop__title-close--fourth');
    let fourthTitleStatic = document.querySelector('.shop-catalog-desktop__title-static--fourth');
    let fourthSectionItems = document.querySelectorAll('.shop-catalog-desktop__item--fourth');

    let fifthSection = document.querySelector('.shop-catalog-desktop__inner--fifth');
    let fifthTitle = document.querySelector('.shop-catalog-desktop__title--fifth');
    let fifthTitleOpen = document.querySelector('.shop-catalog-desktop__title-open--fifth');
    let fifthTitleStatic = document. querySelector('.shop-catalog-desktop__title-static--fifth');
    let fifthSectionItems = document.querySelectorAll('.shop-catalog-desktop__item--fifth');


    if(firstSection === null || firstTitleOpen === null || firstTitleClose === null || firstSectionItems === null || secondSection === null || 
        secondTitle === null || secondTitleOpen === null || secondTitleClose === null || secondSectionItems === null || thirdSection === null ||
        thirdTitle === null ||  thirdSectionItems === null){
            console.log('shopCatalog just go away');
        } else{

            if(fourthSection === null || fourthTitle === null || fourthSectionItems === null){

            thirdTitleOpen.style.display = 'none';
            thirdTitleStatic.style.display = 'block'    ;
 
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
        
                if(secondSection.contains(thirdTitle)){
                    console.log('2 in 1');
        
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
        
                if(firstSection.contains(thirdTitle)){
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
        
            //Second section
        
            secondTitleOpen.addEventListener('click', function(){
                for(let i = 0; i < secondSectionItems.length; i++){
                    secondSectionItems[i].style.display = 'none';
                }
        
                secondTitleOpen.style.display = 'none';
                secondTitleClose.style.display = 'flex';
        
                if(secondSection.contains(secondTitle)){
                    console.log('2 in 2');
        
                    secondSection.append(thirdTitle);
        
                    for(let i = 0; i < thirdSectionItems.length; i++){
                        let allThirdItems = thirdSectionItems[i];
                        secondSection.append(allThirdItems);
                    }
        
                }else if(firstSection.contains(secondTitle)){
                    console.log('2 in 1');
        
                    firstSection.append(thirdTitle); 
                    
                    for(let i = 0; i < thirdSectionItems.length; i++){
                        let allThirdItems = thirdSectionItems[i];
                        firstSection.append(allThirdItems);
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
                
            });
        
        
        
            } else {

                fourthTitleOpen.style.display = 'none';
                fourthTitleStatic.style.display = 'block';

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
                    
                        if(secondSection.contains(thirdTitle) && secondSection.contains(fourthTitle)){
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
                    
                        if(firstSection.contains(thirdTitle) && firstSection.contains(fourthTitle)){
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
                    
                    //Second section
                    
                    secondTitleOpen.addEventListener('click', function(){
                        for(let i = 0; i < secondSectionItems.length; i++){
                            secondSectionItems[i].style.display = 'none';
                        }
                    
                        secondTitleOpen.style.display = 'none';
                        secondTitleClose.style.display = 'flex';
                    
                        if(thirdSection.contains(fourthTitle)){
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
                    
                        if(firstSection.contains(secondTitle) && firstSection.contains(fourthTitle) && firstSection.contains(fourthTitle)){
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
                    
                            
                    
                        }else if(secondSection.contains(thirdTitle) && secondSection.contains(fourthTitle)){
                            console.log('3 & 4 in 1');
                    
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
                    
                        if(thirdSection.contains(thirdTitle)){
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
                    });
           
            }  
        }
}

shopCatalogMech();