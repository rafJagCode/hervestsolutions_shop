$(document).ready(function () {
  const searchIcon = $(".user-product-search__icon");
  const searchInput = $(".search__input");
  const dropdown = $(".suggestions__group-content");
  searchInput.on("input focus", () => {
    const input = searchInput.val();
    if (!input.length) return;
    searchIcon.removeClass("fa-search");
    searchIcon.addClass("fa-spinner fa-pulse");
    $.ajax({
      url: `/user-product-search/${input}`,
      success: function (data) {
        dropdown.html(data);
        searchIcon.removeClass("fa-spinner fa-pulse");
        searchIcon.addClass("fa-search");
      },
    });
  });
});
