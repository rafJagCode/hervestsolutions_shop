$(document).ready(function () {
  const searchIcon = $(".user-product-search__icon");
  const searchInput = $(".search__input");
  const dropdown = $(".suggestions__group-content");
  searchInput.on("input focus", () => {
    const phraze = searchInput.val();
    if (phraze.length < 3) return;
    searchIcon.removeClass("fa-search");
    searchIcon.addClass("fa-spinner fa-pulse");
    $.ajax({
      url: `/search-in-products/${phraze}`,
      success: function (data) {
        dropdown.html(data);
        searchIcon.removeClass("fa-spinner fa-pulse");
        searchIcon.addClass("fa-search");
      },
    });
  });
});
