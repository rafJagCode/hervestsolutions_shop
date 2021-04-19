const csvControls = $('.admin-section__csv-controls');

const changeArrow = () =>{
	const arrow = $('.admin-section__arrow');
	arrow.toggleClass('fa-chevron-right fa-chevron-down')
}
const openCsvSection = ()=>{
	changeArrow();
	csvControls.toggleClass('section--open');
}