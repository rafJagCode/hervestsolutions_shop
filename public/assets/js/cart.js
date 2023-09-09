const getCartItems = async () => {
  let cartDropdown = $("#cart-dropdown");
  $.ajax({
    url: "/cart-dropdown-items",
    success: function (data) {
      cartDropdown.html(data);
    },
  });
  let cart = $(".cart-table__body");
  if (!cart.length) return;
  $.ajax({
    url: "/cart-items",
    success: function (data) {
      console.log("test");
      cart.html(data);
    },
  });
};
const cartAddProduct = async (button, id) => {
  const adminAddToCartIcon = $(button).children(".add-to-cart-btn__icon");
  const loader = $(button).children(".add-to-cart__spinner-border");
  let quantity = $(".input-number__input").val();
  loader.addClass("add-to-cart__spinner-border--show");
  adminAddToCartIcon.removeClass("fas-plus-circle");
  adminAddToCartIcon.addClass("fa-spinner fa-pulse");
  try {
    await axios.post("/cart-add-product", {
      product: id,
      quantity: quantity ? quantity : 1,
    });
    getCartItems();
  } catch (e) {
    addFlash(e.message);
  } finally {
    loader.removeClass("add-to-cart__spinner-border--show");
    adminAddToCartIcon.removeClass("fa-spinner fa-pulse");
    adminAddToCartIcon.addClass("fa-plus-circle");
  }
};
const cartRemoveProduct = async (button, id) => {
  const loader = $(button).children(".dropcart__remove-loader");
  if (!loader.hasClass("dropcart__remove-loader--hidden")) {
    return;
  }
  loader.removeClass("dropcart__remove-loader--hidden");
  try {
    await axios.post("/cart-remove-product", { id: id });
    getCartItems();
  } catch (e) {
    addFlash(e.message);
  }
};
