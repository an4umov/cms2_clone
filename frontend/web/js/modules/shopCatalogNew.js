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
            //clear second title/items defend after repeat
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
                    currentSecondSection.scrollIntoView({behavior: "smooth"});


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

                    //if 3lvl is NOT on the page
                    thirdTitleBlocks.forEach(item => {
                        if (item.style.display == 'none') {
                            //1lvl shpinz
                            firstTitleOpen.addEventListener('click', function () {
                                firstTitleOpen.style.display = 'none';
                                firstTitleClose.style.display = 'block';

                                models.forEach(item => {
                                    let everyModel = item;
                                    everyModel.style.display = 'none';
                                })

                                firstSection.append(titleOfCurrentSecondBlock);

                                for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                    let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                    firstSection.append(allItemsFromCurrentSecondSection);
                                }

                            });
                            //1lvl shponz
                            firstTitleClose.addEventListener('click', function () {
                                firstTitleClose.style.display = 'none';
                                firstTitleOpen.style.display = 'block';

                                currentSecondSection.append(titleOfCurrentSecondBlock);

                                for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                    let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                    currentSecondSection.append(allItemsFromCurrentSecondSection);
                                }

                                models.forEach(item => {
                                    let everyModel = item;
                                    everyModel.style.display = 'flex';
                                })
                            });
                        }
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


                            titleStaticCurrentSecondBlock.style.display = 'none';
                            titleOpenOfCurrentSecondBlock.style.display = 'block';


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
                                    currentThirdSection.scrollIntoView({behavior: "smooth"});

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

                                    //click on 2lvl-close block if 4 lvl is NOT on the page
                                    fourthTitleBlocks.forEach(item => {
                                        if (item.style.display == 'none') {

                                            
                                            //2lvl chpinz
                                            titleOpenOfCurrentSecondBlock.addEventListener('click', function () {
                                                titleOpenOfCurrentSecondBlock.style.display = 'none';
                                                titleCloseOfCurrentSecondBlock.style.display = 'flex';


                                                itemsFromCurrentSecondSection.forEach(item => {
                                                    item.style.display = 'none';
                                                });


                                                currentSecondSection.append(titleOfCurrentThirdBlock);

                                                for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                    let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                    currentSecondSection.append(allItemsFromCurrentThirdSection);
                                                }
                                                //if 2lvl-title in 1lvl section
                                                if (firstSection.contains(titleOfCurrentSecondBlock)) {
                                                    firstSection.append(titleOfCurrentThirdBlock);

                                                    for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                        let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                        firstSection.append(allItemsFromCurrentThirdSection);
                                                    }
                                                };
                                            });

                                            //2lvl chponz

                                            titleCloseOfCurrentSecondBlock.addEventListener('click', function () {
                                                titleCloseOfCurrentSecondBlock.style.display = 'none';
                                                titleOpenOfCurrentSecondBlock.style.display = 'flex';

                                                itemsFromCurrentSecondSection.forEach(item => {
                                                    item.style.display = 'block';
                                                });


                                                currentThirdSection.append(titleOfCurrentThirdBlock);

                                                for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                    let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                    currentThirdSection.append(allItemsFromCurrentThirdSection);
                                                }
                                            });

                                            
                                        }
                                    });


                                      //1lvl shpinz on 2 lvl of visible
                                    firstTitleOpen.addEventListener('click', function () {
                                        firstTitleOpen.style.display = 'none';
                                        firstTitleClose.style.display = 'block';
                                        

                                        models.forEach(item => {
                                            let everyModel = item;
                                            everyModel.style.display = 'none';
                                        })

                                    

                                        if (currentSecondSection.contains(titleOfCurrentThirdBlock)) {
                                            firstSection.append(titleOfCurrentSecondBlock);

                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                firstSection.append(allItemsFromCurrentSecondSection);
                                            }

                                            firstSection.append(titleOfCurrentThirdBlock);

                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                firstSection.append(allItemsFromCurrentThirdSection);
                                            }

                                        }else{
                                            firstSection.append(titleOfCurrentSecondBlock);

                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                firstSection.append(allItemsFromCurrentSecondSection);
                                            }
                                        };
                                    });

                                    //1lvl shponz on 2 lvl of visible
                                    firstTitleClose.addEventListener('click', function () {
                                        firstTitleClose.style.display = 'none';
                                        firstTitleOpen.style.display = 'block';



                                        if (firstSection.contains(titleOfCurrentThirdBlock)) {

                                            currentSecondSection.append(titleOfCurrentSecondBlock);

                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                currentSecondSection.append(allItemsFromCurrentSecondSection);
                                            }

                                            currentSecondSection.append(titleOfCurrentThirdBlock);

                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                currentSecondSection.append(allItemsFromCurrentThirdSection);
                                            }

                                            models.forEach(item => {
                                                let everyModel = item;
                                                everyModel.style.display = 'flex';
                                            })
                                        } else {
                                            currentSecondSection.append(titleOfCurrentSecondBlock);

                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                currentSecondSection.append(allItemsFromCurrentSecondSection);
                                            }

                                            models.forEach(item => {
                                                let everyModel = item;
                                                everyModel.style.display = 'flex';
                                            })
                                        }
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

                                            clearLastOfferData();
                                            fourthBlocksClear();
                                            thirdBlocksClear();

                                            titleStaticCurrentThirdBlock.style.display = 'none';
                                            titleOpenOfCurrentThirdBlock.style.display = 'flex';


                                            let thirdItem = this.querySelector('a');
                                            let thirdTextBlock = this.querySelector('.shop-catalog-desktop__item-text');
                                            thirdTextBlock.classList.add('shop-catalog-desktop__item-text--active');

                                            fourthSections.forEach(item => {
                                                if (item.dataset.code == thirdItem.dataset.code) {
                                                    

                                                    let currentFourthSection = item;
                                                    currentFourthSection.style.display = 'flex';
                                                    currentFourthSection.scrollIntoView({behavior: "smooth"});

                                                    let titleOfCurrentFourthBlock = currentFourthSection.querySelector('.shop-catalog-desktop__title--fourth');
                                                    let titleOpenOfCurrentFourthBlock = currentFourthSection.querySelector('.shop-catalog-desktop__title-open--fourth');
                                                    let titleCloseOfCurrentFourthBlock = currentFourthSection.querySelector('.shop-catalog-desktop__title-close--fourth');

                                                    titleOfCurrentFourthBlock.style.display = 'flex';

                                                    let itemsFromCurrentFourthSection = currentFourthSection.querySelectorAll('.shop-catalog-desktop__item--fourth');


                                                    itemsFromCurrentFourthSection.forEach(item => {
                                                        item.style.display = 'block';
                                                    });

                                                    //3lvl shponz
                                                    titleOpenOfCurrentThirdBlock.addEventListener('click', function () {
                                                        titleOpenOfCurrentThirdBlock.style.display = 'none';
                                                        titleCloseOfCurrentThirdBlock.style.display = 'flex';

                                                        itemsFromCurrentThirdSection.forEach(item => {
                                                            item.style.display = 'none';
                                                        });

                                                        if (currentSecondSection.contains(titleOfCurrentThirdBlock)) {
                                                            currentSecondSection.append(titleOfCurrentFourthBlock);

                                                            for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                                let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentFourthSection);
                                                            }
                                                        } else if (firstSection.contains(titleOfCurrentThirdBlock)) {
                                                            firstSection.append(titleOfCurrentFourthBlock);

                                                            for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                                let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                                firstSection.append(allItemsFromCurrentFourthSection);
                                                            }
                                                        } else {
                                                            currentThirdSection.append(titleOfCurrentFourthBlock);

                                                            for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                                let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                                currentThirdSection.append(allItemsFromCurrentFourthSection);
                                                            }
                                                        }
                                                    });

                                                    //3lvl shpinz
                                                    titleCloseOfCurrentThirdBlock.addEventListener('click', function () {

                                                        titleCloseOfCurrentThirdBlock.style.display = 'none';
                                                        titleOpenOfCurrentThirdBlock.style.display = 'flex';

                                                        itemsFromCurrentThirdSection.forEach(item => {
                                                            item.style.display = 'block';
                                                        });

                                                        currentFourthSection.append(titleOfCurrentFourthBlock);

                                                        for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                            let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                            currentFourthSection.append(allItemsFromCurrentFourthSection);
                                                        }
                                                    });

                                                     //2lvl chpinz on 4lvl|click on 2lvl-close block if 4 lvl is on the page
                                                    titleOpenOfCurrentSecondBlock.addEventListener('click', function () {
                                                        titleOpenOfCurrentSecondBlock.style.display = 'none';
                                                        titleCloseOfCurrentSecondBlock.style.display = 'flex';
                                                        


                                                        itemsFromCurrentSecondSection.forEach(item => {
                                                            item.style.display = 'none';
                                                        });

                                                        if (firstSection.contains(titleOfCurrentSecondBlock) && currentFourthSection.contains(titleOfCurrentFourthBlock)) {
                                                            firstSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                firstSection.append(allItemsFromCurrentThirdSection);
                                                            }
                                                        }else if(firstSection.contains(titleOfCurrentSecondBlock) && currentThirdSection.contains(titleOfCurrentFourthBlock)) {
                                                           
                                                            firstSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                firstSection.append(allItemsFromCurrentThirdSection);
                                                            }

                                                            firstSection.append(titleOfCurrentFourthBlock);

                                                            for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                                let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                                firstSection.append(allItemsFromCurrentFourthSection);
                                                            }
                                                        }else if(currentThirdSection.contains(titleOfCurrentFourthBlock)){
                                                            currentSecondSection.append(titleOfCurrentThirdBlock);
                                                            

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentThirdSection);
                                                            } 

                                                            currentSecondSection.append(titleOfCurrentFourthBlock);

                                                            for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                                let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentFourthSection);
                                                            }
                                                        } else{
                                                            currentSecondSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentThirdSection);
                                                            } 
                                                        }
   
                                                    });

                                                    //2lvl chponz on 4lvl

                                                    titleCloseOfCurrentSecondBlock.addEventListener('click', function () {
                                                        titleCloseOfCurrentSecondBlock.style.display = 'none';
                                                        titleOpenOfCurrentSecondBlock.style.display = 'flex';

                                                        itemsFromCurrentSecondSection.forEach(item => {
                                                            item.style.display = 'block';
                                                        });

                                                        if(firstSection.contains(titleOfCurrentFourthBlock)){

                                                            currentThirdSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                currentThirdSection.append(allItemsFromCurrentThirdSection);
                                                            }

                                                            currentThirdSection.append(titleOfCurrentFourthBlock);

                                                            for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                                let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                                currentThirdSection.append(allItemsFromCurrentFourthSection);
                                                            }


                                                        }else if (currentSecondSection.contains(titleOfCurrentFourthBlock)){
                                                            
                                                            currentThirdSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                currentThirdSection.append(allItemsFromCurrentThirdSection);
                                                            }

                                                            currentThirdSection.append(titleOfCurrentFourthBlock);

                                                            for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                                let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                                currentThirdSection.append(allItemsFromCurrentFourthSection);
                                                            }

                                                        } else {
                                                            currentThirdSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                currentThirdSection.append(allItemsFromCurrentThirdSection);
                                                            }
                                                        }
                                                        
                                                    });

                                                    //1lvl shpinz on 4 lvl of visible
                                                    firstTitleOpen.addEventListener('click', function () {
                                                        firstTitleOpen.style.display = 'none';
                                                        firstTitleClose.style.display = 'block';
                                                       

                                                        models.forEach(item => {
                                                            let everyModel = item;
                                                            everyModel.style.display = 'none';
                                                        })

                                                    

                                                        if(currentSecondSection.contains(titleOfCurrentFourthBlock)){
                                                            
                                                            firstSection.append(titleOfCurrentSecondBlock);

                                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                                firstSection.append(allItemsFromCurrentSecondSection);
                                                            }

                                                            firstSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                firstSection.append(allItemsFromCurrentThirdSection);
                                                            }

                                                            firstSection.append(titleOfCurrentFourthBlock);

                                                            for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                                let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                                firstSection.append(allItemsFromCurrentFourthSection);
                                                            }
                                                        }else if (currentSecondSection.contains(titleOfCurrentThirdBlock)) {
                                                            firstSection.append(titleOfCurrentSecondBlock);

                                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                                firstSection.append(allItemsFromCurrentSecondSection);
                                                            }

                                                            firstSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                firstSection.append(allItemsFromCurrentThirdSection);
                                                            }

                                                        }else{
                                                            firstSection.append(titleOfCurrentSecondBlock);

                                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                                firstSection.append(allItemsFromCurrentSecondSection);
                                                            }
                                                        };
                                                    });

                                                    //1lvl shponz on 2 lvl of visible
                                                    firstTitleClose.addEventListener('click', function () {
                                                        firstTitleClose.style.display = 'none';
                                                        firstTitleOpen.style.display = 'block';



                                                        if(firstSection.contains(titleOfCurrentFourthBlock)){
                                                            currentSecondSection.append(titleOfCurrentSecondBlock);

                                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentSecondSection);
                                                            }

                                                            currentSecondSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentThirdSection);
                                                            }

                                                            currentSecondSection.append(titleOfCurrentFourthBlock);

                                                            for (let i = 0; i < itemsFromCurrentFourthSection.length; i++) {
                                                                let allItemsFromCurrentFourthSection = itemsFromCurrentFourthSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentFourthSection);
                                                            }

                                                            models.forEach(item => {
                                                                let everyModel = item;
                                                                everyModel.style.display = 'flex';
                                                            })
                                                        }else if (firstSection.contains(titleOfCurrentThirdBlock)) {

                                                            currentSecondSection.append(titleOfCurrentSecondBlock);

                                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentSecondSection);
                                                            }

                                                            currentSecondSection.append(titleOfCurrentThirdBlock);

                                                            for (let i = 0; i < itemsFromCurrentThirdSection.length; i++) {
                                                                let allItemsFromCurrentThirdSection = itemsFromCurrentThirdSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentThirdSection);
                                                            }

                                                            models.forEach(item => {
                                                                let everyModel = item;
                                                                everyModel.style.display = 'flex';
                                                            })
                                                        } else {
                                                            currentSecondSection.append(titleOfCurrentSecondBlock);

                                                            for (let i = 0; i < itemsFromCurrentSecondSection.length; i++) {
                                                                let allItemsFromCurrentSecondSection = itemsFromCurrentSecondSection[i];
                                                                currentSecondSection.append(allItemsFromCurrentSecondSection);
                                                            }

                                                            models.forEach(item => {
                                                                let everyModel = item;
                                                                everyModel.style.display = 'flex';
                                                            })
                                                        }
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
            const finalItemCode = finalItem.dataset.code;
            // console.log(finalItem);
            const finalItemUrl = finalItem.getAttribute("href");
            console.log(finalItemUrl);

            let requestUrl = `/catalog/offers/${finalItemCode}`;

            console.log(requestUrl);

            let finalItemTextBlock = this.querySelector('.shop-catalog-desktop__item-text');
            finalItemTextBlock.classList.add('shop-catalog-desktop__item-text--active');

            preloaderContainer.style.display = 'flex';
            preloaderContainer.style.paddingTop = '80px';
            preloaderContainer.scrollIntoView({behavior: "smooth"});

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

                        hideFirstSeparatorOnMobile();
                        hideFirstSeparatorOnDesktop();

                        offerCardMobileOpen();                                   
                        offerCardMobileInfoOpen();
                        
                        offerCardDesktopOpen();
                        offerCardDesktopInfoOpen();

                        offerCardMobileBuyButtonMech();
                        offerCardDesktopBuyButtonMech();

                        offerCardDesktopBuyButtonRemoveDefaultTitleTooltip();
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
                        
                        preloaderContainer.style.display = 'none';
                        offersContainer.style.display = 'block';
                        offersContainer.scrollIntoView({behavior: "auto"});
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




            secondSectionsMobile.forEach(item => {
                if(item.dataset.code == modelMobile.dataset.code) {
                    let currentSecondSectionMobile = item;
                    currentSecondSectionMobile.style.display = 'block';
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

            thirdSectionsMobile.forEach(item => {
                if(item.dataset.code == currentSecondItemMobile.dataset.code){
                    let currentThirdSectionMobile = item;
                    currentThirdSectionMobile.style.display = 'block';
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

            fourthSectionsMobile.forEach(item => {
                if(item.dataset.code == currentThirdItemMobile.dataset.code){
                    let currentFourthSectionMobile = item;
                    currentFourthSectionMobile.style.display = 'block';
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
            // console.log(finalItemMobile);
            // console.log(finalItemMobileCode);
            const finalItemUrlMobile = finalItemMobile.getAttribute("href");
            let requestUrlMobile = `/catalog/offers/${finalItemMobileCode}`;
            // console.log(requestUrl);

            preloaderContainer.style.display = 'flex';
            preloaderContainer.scrollIntoView({behavior: "smooth"});

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

function shopCatalogWithOutFirstTitle(){
    let firstTitle = document.querySelector('.shop-catalog-desktop__title');

    if(firstTitle === null){

    }else {           
        firstTitle.style.marginLeft = '-19.5%';
        firstTitle.style.visibility = 'hidden';
    }
}

shopCatalogWithOutFirstTitle();

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