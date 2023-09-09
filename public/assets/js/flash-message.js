const flashes = $("#flashes");

const addFlash = (message) => {
  const flash = $(`<div class="snackbar card shadow">
		<div class="snackbar__content">
			<div class="snackbar__image" alt=""></div>
			<span class="snackbar__message">${message}</span>
		</div>
	</div>`);
  flashes.html(flash);
  flash.addClass("snackbar--show");
  setTimeout(function () {
    flash.removeClass("snackbar--show");
    flash.remove();
  }, 5000);
};
