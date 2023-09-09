$(document).ready(function () {
  (function showSnackbar() {
    const snackbar = $(".snackbar");
    snackbar.addClass("snackbar--show");
    setTimeout(function () {
      snackbar.removeClass("snackbar--show");
    }, 5000);
  })();
});
