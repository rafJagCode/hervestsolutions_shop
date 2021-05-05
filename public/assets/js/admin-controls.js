
const changeArrow = () =>{
	const arrow = $('.admin-section__arrow');
	arrow.toggleClass('fa-chevron-right fa-chevron-down')
}
const openCsvSection = ()=>{
	const csvControls = $('.admin-section__csv-controls');
	changeArrow();
	csvControls.toggleClass('section--open');
}
const renderCustomerSearch = ()=>{
	const accountBody = $('#account-body');
	$.ajax({
		url: '/customer-search',
		success: function(data){
			accountBody.html(data);
		}
	})
}
const renderCustomerCreator= ()=>{
	const accountBody = $('#account-body');
	$.ajax({
		url: '/customer-creator',
		success: function(data){
			accountBody.html(data);
		}
	})
}