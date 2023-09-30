const getCartItems = async () => {
  let cartDropdown = $("#cart-dropdown");
  $.ajax({
    url: "/cart-dropdown-items",
    success: function (data) {
      cartDropdown.html(data);
    },
  });
  let cart = $("#cart-container");
  if (!cart.length) return;
  cart.find(".input-number").customNumber({ destroy: true });
  $.ajax({
    url: "/cart-items",
    success: function (data) {
      cart.html(data);
    },
    complete: function () {
      cart.find(".input-number").customNumber();
    },
  });
};
const cartAddProduct = async (el, productId, type = "BUTTON", e = null) => {
  if (e) preventDropdownClose(e);

  const loader = $(el).children(".add-to-cart__spinner-border");
  const input =
    type === "BUTTON" ? null : $(el).parent().parent().find("input");
  const amount = type === "BUTTON" ? 1 : input.val();
  const operation = type === "INPUT_SET" ? "=" : "+";

  loader.addClass("add-to-cart__spinner-border--show");
  let response = null;
  try {
    response = await axios.post("/cart-add-product", {
      productId: productId,
      amount: amount,
      operation: operation,
    });
    getCartItems();
  } catch (e) {
    addFlash(e.message);
  } finally {
    loader.removeClass("add-to-cart__spinner-border--show");
    if (response && response.data.error) {
      addFlash(response.data.error);
    }
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
const preventDropdownClose = (e) => {
  $(".search__input").focus();
  e.preventDefault();
  e.stopPropagation();
};
