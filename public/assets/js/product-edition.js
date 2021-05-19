$(document).ready(function () {
	const editable = $('.editable');
	const removeFeatureBtn = $('.remove-feature');
	const addFeature = $('.add-feature');
	const featuresList = $('.features-list');
	const moveFeatureUpBtn = $('.move-feature-up');
	const moveFeatureDownBtn = $('.move-feature-down');
	const saveEditonBtn = $('.product-edition-save');

	function moveUp($item) {
    $before = $item.prev();
    $item.insertBefore($before);
}

function moveDown($item) {
    $after = $item.next();
    $item.insertAfter($after);
}
	(function(){
		editable.prepend('<i class="editable-icon fas fa-edit"></i>');
	})();

	$('.product__body').on('click', '.editable', function(){
		if($(this).hasClass('edition-in-progress')) return;
		$(this).addClass('edition-in-progress');
		$(this).append('<textarea class="editable-input" type="text" (keydown.enter)="$event.target.blur();submit();false"></textarea>');
		const input = $(this).children('.editable-input');
		const currentText = $(this).text().trim();
		input.val(currentText);
		input.focus();
	});

	$('.editable-product-number').on('change', function(event){
		const changedNumber = $(event.target).val().trim();
		$('.product__subtitle .status-badge__text').text('SKU: ' + changedNumber);
	});

	$('.product__body').on('blur','.editable-input', function(){
		const val = $(this).val();
		const closestEditable = $(this).closest('.editable');
		const textBefore = closestEditable.text().trim();
		closestEditable.text(val);
		closestEditable.removeClass('edition-in-progress');

		if(closestEditable.text().trim() === textBefore){
			closestEditable.prepend('<i class="editable-icon fas fa-edit"></i>');
			return;
		}
		closestEditable.prepend('<i class="editable-icon fas fa-check"></i>');

	});

	$('.product__body').on('keydown', '.editable-input', function(event){
		if(event.keyCode===13) $(this).blur();
	});

	featuresList.on('click', '.remove-feature', function(){
		$(this).closest('li').remove();
	});

	addFeature.on('click', function(){
		featuresList.append(
			`<li>
				<i class="remove-feature fas fa-trash-alt"></i>
				<i class="move-feature-up fas fa-caret-square-up"></i>
				<i class="move-feature-down mr-5 fas fa-caret-square-down"></i>
				<span class="editable editable-feature"><i class="editable-icon fas fa-edit"></i>Nowa Cecha</span>
			</li>`);
	});

	featuresList.on('click', '.move-feature-up', function(){
		const feature = $(this).closest('li');
		moveUp(feature);
	});
	featuresList.on('click', '.move-feature-down', function(){
		const feature = $(this).closest('li');
		moveDown(feature);
	});

	const isInt = (text) =>{
		return parseInt(text) == text;
	};

	const isCorrectPrice = (price) =>{
		console.log(price);
		var priceRegex = /^\d+(?:\.{1}\d{2})*$/;
		return priceRegex.test(price);
	};

	const markError = (element) =>{
		element.css('color', 'red');
	};


	const unmarkError = (element) =>{
		element.css('color', 'black');
	};

	const validateValues = (price, quantity) => {
		if(!isCorrectPrice(price)){
			markError($('.editable-price'))
			return false;
		}
		unmarkError($('.editable-price'));
		if(!isInt(quantity)) {
			markError($('.editable-quantity'))
			 return false;
		};
		unmarkError($('.editable-quantity'));
		return true;
	}

	const getEditableValues= () => {
		const form = {
			name: '',
			description: '',
			price: '',
			quantity: '',
			productNumber: '',
			brand: '',
			features: [],
			images: []
		};
		form.name = $('.editable-name').text().trim();
		form.description = $('.editable-description').text().trim();
		form.price = $('.editable-price').text().trim();
		form.quantity = $('.editable-quantity').text().trim();
		form.productNumber = $('.editable-product-number').text().trim();
		form.brand = $('editable.brand').text().trim();

		$('.editable-feature').toArray().forEach((feature)=>{
			form.features.push($(feature).text().trim());
		});

		const addedImages = $('#dropzone .product-edition-gallery__image').toArray();
		addedImages.forEach(image => {
			form.images.push($(image).attr('data-image-url'));
		});

		return form;
	}
	saveEditonBtn.on('click', function(){
		const form = getEditableValues();
		if(!validateValues(form.price, form.quantity)) return;
		axios.post('/edit-product', form);
	})
});
