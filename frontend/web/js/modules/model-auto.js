//Main model auto mech

function modelAutoMech(){
    let autoBrandItems = document.querySelectorAll('.model-auto__brand-item');

    let autoModelBlocks = document.querySelectorAll('.model-auto__model');
    let automodelItems = document.querySelectorAll('.model-auto__model-item');

    let autoGenerationBlock = document.querySelectorAll('.model-auto__generation');
    let autoGenerationItem = document.querySelectorAll('.model-auto__generation-item');

    if (autoBrandItems === null){
        // console.log('this block out of the current html page');
    } else{

        for(let i = 0; i < autoBrandItems.length; i++){
            autoBrandItems[i].addEventListener('click', function(){
                hideChosenBrandItem();
                hideOpenedAutoModelBlocks();
                hideChosenAutoModelItem();
                hideChosenGenerationBlock();


                let currentAutoBrand = this;
                currentAutoBrand.classList.add('model-auto__brand-item--active');

                autoModelBlocks.forEach(item => {
                    if(item.dataset.code == currentAutoBrand.dataset.code){
                        let currentAutoModelBlock = item;
                        currentAutoModelBlock.style.display = 'block';
                    }
                });
            });
        }

        for(let i = 0; i < automodelItems.length; i++){
            automodelItems[i].addEventListener('click', function(){
                hideChosenAutoModelItem();
                hideChosenGenerationBlock();


                let currentAutoModel = this;
                currentAutoModel.classList.add('model-auto__model-item--active');

                autoGenerationBlock.forEach(item => {
                    if(item.dataset.code === currentAutoModel.dataset.code){
                        let currentAutoGenerationBlock = item;
                        currentAutoGenerationBlock.style.display = 'block';
                    }
                });
            });
        }


                
        //hide items when u switch between cars and track
        function hideOnSwitchCarsVsTrucks(){
            let truckBtn = document.querySelector('label[for="model-tab-type-2"]');

            if(truckBtn === null){

            } else {
                truckBtn.addEventListener('click', function(){
                    hideChosenBrandItem();
                    hideOpenedAutoModelBlocks();
                    hideChosenAutoModelItem();
                    hideChosenGenerationBlock();
                });
            }

            
        }

        hideOnSwitchCarsVsTrucks();

        function hideOnSwitchTrucksVsCars(){
            let carBtn = document.querySelector('label[for="model-tab-type-1"]');

            if(carBtn === null){

            } else {
                carBtn.addEventListener('click', function(){
                    hideChosenBrandItem();
                    hideOpenedAutoModelBlocks();
                    hideChosenAutoModelItem();
                    hideChosenGenerationBlock();
                });
            }
            
        }

        hideOnSwitchTrucksVsCars();

    }
}

modelAutoMech();

function hideChosenBrandItem(){
    let autoBrandItems = document.querySelectorAll('.model-auto__brand-item');

    autoBrandItems.forEach(item => {
        item.classList.remove('model-auto__brand-item--active');
    });
}

function hideOpenedAutoModelBlocks(){
    let autoModelBlocks = document.querySelectorAll('.model-auto__model');

    autoModelBlocks.forEach(item => {
        item.style.display = 'none';
    });
}

function hideChosenAutoModelItem(){
    let automodelItems = document.querySelectorAll('.model-auto__model-item');

    automodelItems.forEach(item =>{
        item.classList.remove('model-auto__model-item--active');
    });
}

function hideChosenGenerationBlock(){
    let autoGenerationBlock = document.querySelectorAll('.model-auto__generation');

    autoGenerationBlock.forEach(item => {
        item.style.display = 'none';
    });
}



//Generation text hover mech

function generationItemTextHover(){
    let genItems = document.querySelectorAll('.model-auto__generation-item');

    if(genItems === null){
        // console.log('no generation on the page');
    } else{
        let intViewportWidth = window.innerWidth;
        if(intViewportWidth > 1140){
            // console.warn('desktop!');
            for(let i = 0; i < genItems.length; i++){
                genItems[i].addEventListener('mouseover', function(){
                    let currentText = this.querySelector('.model-auto__generation-item-text');
                    currentText.classList.add('model-auto__generation-item-text--hover');
                });
    
                genItems[i].addEventListener('mouseout', function(){
                    let currentText = this.querySelector('.model-auto__generation-item-text');
                    currentText.classList.remove('model-auto__generation-item-text--hover');
                });
            }
        } 
       
    }
}

generationItemTextHover();