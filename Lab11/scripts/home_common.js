const sliderButtonClass = "post__image-button";
const sliderIndexClass = "post__image-index";
const sliderImagePictureClass = "image__picture";
const sliderImagePictureActiveClass = "image__picture_active";
const sliderButtonsClass = "post__image-buttons";
const sliderWrapperClass = "post__image";

window.onload = function() {
    let feed = document.getElementById("feed");
    createLogout();
    Array.from(feed.children).forEach(post => {
        createModal(post);
        createSlider(post);
        createMoreButtonHandler(post);
        createLikesCounter(post);
    });
}