$( document ).ready(function() {
	const searchInput = $('.order-product-search__input');
	const dropdown = $('.order-product-search__dropdown');
	const dropdownArea = $('order-product-search__body');
	searchInput.focus(function(){
		dropdown.addClass('order-product-search__dropdown--open');
	});
	dropdownArea.blur(()=>{
		dropdown.removeClass('order-product-search__dropdown--open');
	});
	searchInput.on('input', ()=>{
		$.ajax({
			url: `/search-results/${searchInput.val()}`,
			success: function(data){
				dropdown.html(data);
			}
		})
	})
});