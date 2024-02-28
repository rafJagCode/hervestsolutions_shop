const handleEmptySearch = (e, form) => {
  const phraze = $(form).find('input[name="phraze"]').val().trim();
  if (!phraze.length) e.preventDefault();
};

const toggleLoader = () =>
  $(".user-product-search__icon").toggleClass("fa-search fa-spinner fa-pulse");

const search = (phraze) => {
  toggleLoader();
  return new Promise((resolve, reject) => {
    if (!phraze.length) {
      resolve("");
      return;
    }
    $.ajax({
      url: `/search-in-products/${phraze}`,
      success: (data) => resolve(data),
      error: (err) => reject(err),
    });
  });
};

$(function () {
  const debouncedSearch = debounce(search, 300);
  $(".search__input").on("input change", async function () {
    const phraze = $(this).val().trim();
    try {
      const data = await debouncedSearch(phraze);
      $(".suggestions__group-content").html(data);
      toggleLoader();
    } catch (e) {
      toggleLoader();
      addFlash("Wyszukiwanie produktów nie powiodło się");
    }
  });
});
