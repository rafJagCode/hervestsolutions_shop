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
      `	<div class="product-edition-gallery__image-container card shadow">
	  		<img data-image-url="${url}" class="product-edition-gallery__image" src="${url}">
			<i class="remove-image fas fa-times"></i>
		</div>`
    );
    $("#modules").append(img);
  });

  const changeImages = () => {
    const currentImages = $(".product-gallery-image-tag.image__tag").toArray();
    const addedImages = $(
      "#dropzone .product-edition-gallery__image"
    ).toArray();

    const length =
      addedImages.length <= currentImages.length
        ? addedImages.length
        : currentImages.length;

    for (let index = 0; index < length; index++) {
      const dataImageUrl = $(addedImages[index]).attr("data-image-url");
      $(currentImages[index]).attr("src", dataImageUrl);
      $(currentImages[index]).closest("a").attr("href", dataImageUrl);
      $(currentImages[4 + index]).attr("src", dataImageUrl);
    }
  };

  const clearImages = () => {
    const currentImages = $(".image__tag").toArray();
    currentImages.forEach((image) => {
      $(image).attr("src", "");
      $(image).closest("a").attr("href", "");
    });
  };

  $("#dropzone")
    .sortable({
      connectWith: ".connectedSortable",
      update: function () {
        clearImages();
        changeImages();
      },
      over: function () {
        $(this).addClass("active");
      },
      out: function () {
        $(this).removeClass("active");
      },
    })
    .disableSelection();

  $("#modules")
    .sortable({
      connectWith: ".connectedSortable",
      over: function () {
        $(this).addClass("active");
      },
      out: function () {
        $(this).removeClass("active");
      },
    })
    .disableSelection();
});
