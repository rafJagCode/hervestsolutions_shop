$(document).ready(function () {
  const searchIcon = $(".order-product-search__search-icon");
  const dropdownArea = $(".order-product-search__body");
  const searchInput = $(".order-product-search__input");
  const dropdown = $(".order-product-search__dropdown");

  searchInput.on("input focus", () => {
    const input = searchInput.val();
    if (!input.length) return;
    console.log(searchIcon);
    searchIcon.removeClass("fa-search");
    searchIcon.addClass("fa-spinner fa-pulse");
    $.ajax({
      url: `/search-results/${input}`,
      success: function (data) {
        dropdown.html(data);
        searchIcon.removeClass("fa-spinner fa-pulse");
        searchIcon.addClass("fa-search");
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
