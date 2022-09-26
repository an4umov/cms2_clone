function searchModalToggle() {

	const settingBtns = document.querySelectorAll('.searchModalToggle');
	const settingHeaderBtn = document.querySelector('.search__setting');
	const settingsModalWrapper = document.querySelector('.search__modal-wrapper');

	if (settingsModalWrapper === null || settingBtns === null) {
		
	} else {

		settingBtns.forEach(item => {

			item.addEventListener('click', function(e){
				e.preventDefault();
				settingsModalWrapper.classList.toggle("search__modal-wrapper--visible");
				settingHeaderBtn.classList.toggle("search__setting--active");
			});

		});

		document.onclick = function(e){
			if(!settingsModalWrapper.contains(e.target) && !e.target.classList.contains('searchModalToggle') || e.target.classList.contains('search__modal-close')){
				settingsModalWrapper.classList.remove("search__modal-wrapper--visible");
				settingHeaderBtn.classList.remove("search__setting--active");
			}
		}
	}
	
}
searchModalToggle();