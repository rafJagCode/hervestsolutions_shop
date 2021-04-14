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
    "http://apiagro.amelen.pl/public/index.php/api/cartAddProduct",
    { product: id, user: 2, quantity: quantity ? quantity : 1}
  );
  getCartItems();
};
const cartRemoveProduct = async (id) => {
  await axios.post(
    "http://apiagro.amelen.pl/public/index.php/api/cartRemoveProduct",
    { id: id }
  );
  getCartItems();
};
