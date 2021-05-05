$(document).ready(function () {
  const dropdownArea = $(".order-product-search__body");
  const searchInput = $(".order-product-search__input");
  const dropdown = $(".order-product-search__dropdown");

  searchInput.on("input focus", () => {
    const input = searchInput.val();
    if (!input.length) return;
    $.ajax({
      url: `/search-results/${input}`,
      success: function (data) {
        dropdown.html(data);
      },
    });
  });

  $("body").click(function (e) {
    if ($(e.target).closest(dropdownArea).length) {
      dropdown.addClass("order-product-search__dropdown--open");
    } else {
      dropdown.removeClass("order-product-search__dropdown--open");
    }
  });
});
