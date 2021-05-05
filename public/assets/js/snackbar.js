$(document).ready(function () {
  (function showSnackbar() {
    const observer = new MutationObserver(function (mutations) {
      const snackbar = $(".snackbar");
      if (snackbar) {
        snackbar.addClass("snackbar--show");
        setTimeout(function () {
          snackbar.removeClass("snackbar--show");
        }, 5000);
        observer.disconnect();
      }
    });
    observer.observe(document, {
      attributes: false,
      childList: true,
      characterData: false,
      subtree: true,
    });
  })();
});
