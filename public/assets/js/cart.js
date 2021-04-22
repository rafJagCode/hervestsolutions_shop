const getCartItems = () => {
  let cart = $(".cart-table__body");
  xhr = $.ajax({
    url: "/cart-items",
    success: function (data) {
      cart.html(data);
    },
  });
  let cartDropdown = $("#cart-dropdown");
  xhr = $.ajax({
    url: "/cart-dropdown-items",
    success: function (data) {
      cartDropdown.html(data);
    },
  });
};
const cartAddProduct = async (id) => {
	let quantity = $(".input-number__input").val();
  await axios.post(
    "/cart-add-product",
    { product: id, quantity: quantity ? quantity : 1}
  );
  getCartItems();
};
const cartRemoveProduct = async (id) => {
  await axios.post(
    "/cart-remove-product",
    { id: id }
  );
  getCartItems();
};
