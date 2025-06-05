function toggleActive(pictures, activeIndex) {
    console.log(pictures.length);
    for (let i = 0; i < pictures.length; i++) {
        if (i === activeIndex) {
            pictures[i].classList.add(sliderImagePictureActiveClass);
        } else {
            pictures[i].classList.remove(sliderImagePictureActiveClass);
        }
    }
}

function drawCounter(counter, activeIndex, maxVal) {
    counter.innerText = (activeIndex + 1) + "/" + maxVal;
}

function appendImageToSlider(post, insertedImg) {
    const pictures = post.getElementsByClassName(sliderImagePictureClass);
    const counter = post.getElementsByClassName(sliderIndexClass)[0];
    post.appendChild(insertedImg);
    toggleActive(pictures, pictures.length - 1);
    drawCounter(counter, pictures.length - 1, pictures.length);
}

function createSlider(post) {
    let imgIndex = 0;

    const buttons = post.getElementsByClassName(sliderButtonClass);
    const prevButton = buttons[0];
    const nextButton = buttons[1];

    const counter = post.getElementsByClassName(sliderIndexClass)[0];
    console.log(counter)

    const pictures = post.getElementsByClassName(sliderImagePictureClass);

    console.log(pictures)
    pictures[0].classList.add(sliderImagePictureActiveClass);
    drawCounter(counter, imgIndex, pictures.length);

    prevButton.addEventListener("click", (e) => {
        e.stopPropagation();
        e.preventDefault();
        const pictures = post.getElementsByClassName(sliderImagePictureClass);
        imgIndex = imgIndex - 1 >= 0 ? imgIndex - 1 : pictures.length - 1;
        toggleActive(pictures, imgIndex);
        drawCounter(counter, imgIndex, pictures.length);
    });

    nextButton.addEventListener("click", (e) => {
        e.stopPropagation();
        e.preventDefault();
        const pictures = post.getElementsByClassName(sliderImagePictureClass);
        imgIndex = imgIndex + 1 < pictures.length ? imgIndex + 1 : 0;
        toggleActive(pictures, imgIndex);
        drawCounter(counter, imgIndex, pictures.length);
    })
}

function addSliderMarkup(root) {
    root.innerHTML = `
    <div class="${sliderWrapperClass}">
        <div class="${sliderIndexClass}">1/3</div>
        <div class="${sliderButtonsClass}">
            <button type="button" class="${sliderButtonClass}">
                <img src="../images/icons/arrow_left.svg" class="post__image-button-icon"/>
            </button>
            <button type="button" class="${sliderButtonClass}">
                <img src="../images/icons/arrow_right.svg" class="post__image-button-icon"/>
            </button>
        </div>
    </div>
    `
}

function removeSliderMarkup(root) {
    root.querySelector("." + sliderWrapperClass).remove();
}