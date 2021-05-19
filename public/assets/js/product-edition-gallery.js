$(document).ready(function () {
  const addImageBtn = $(".product-edition-gallery__add-image");

  $(".product-edition-gallery").on("click", ".remove-image", function () {
    $(this).closest(".product-edition-gallery__image-container").remove();
    clearImages();
    changeImages();
  });

  addImageBtn.on("click", function () {
    const url = $("#imageURL").val();
    const img = $(
      `	<div class="product-edition-gallery__image-container">
	  		<img data-image-url="${url}" class="product-edition-gallery__image drag" src="${url}">
			<i class="remove-image fas fa-trash-alt"></i>
		</div>`
    );
    $("#modules").append(img);
  });

  const changeImages = () => {
    const currentImages = $(".image__tag").toArray();
    const addedImages = $(
      "#dropzone .product-edition-gallery__image"
    ).toArray();

    for (let index = 0; index < addedImages.length; index++) {
      $(currentImages[index]).attr(
        "src",
        $(addedImages[index]).attr("data-image-url")
      );
      $(currentImages[index])
        .closest("a")
        .attr("href", $(addedImages[index]).attr("data-image-url"));
      $(currentImages[4 + index]).attr(
        "src",
        $(addedImages[index]).attr("data-image-url")
      );
    }
  };

  const clearImages = () => {
    const currentImages = $(".image__tag").toArray();
    currentImages.forEach((image) => {
      $(image).attr("src", "");
      $(image).closest("a").attr("href", "");
    });
  };

  $("#modules, #dropzone")
    .sortable({
      connectWith: ".connectedSortable",
      update: function () {
        clearImages();
        changeImages();
      },
    })
    .disableSelection();
});
