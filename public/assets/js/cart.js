const getCartItems = async () => {
  let cart = $(".cart-table__body");
  $.ajax({
    url: "/cart-items",
    success: function (data) {
      cart.html(data);
    },
  });
  let cartDropdown = $("#cart-dropdown");
  $.ajax({
    url: "/cart-dropdown-items",
    success: function (data) {
      cartDropdown.html(data);
    },
  });
};
const cartAddProduct = async (id) => {
  let quantity = $(".input-number__input").val();
  await axios.post("/cart-add-product", {
    product: id,
    quantity: quantity ? quantity : 1,
  });
  getCartItems();
};
const cartRemoveProduct = async (button, id) => {
  const loader = $(button).children(".dropcart__remove-loader");
  if(!loader.hasClass("dropcart__remove-loader--hidden")){
	  console.log('loading');
	  return;
  }
  console.log('starting loading1');
  loader.removeClass("dropcart__remove-loader--hidden");
  await axios.post("/cart-remove-product", { id: id });
  getCartItems();
};
