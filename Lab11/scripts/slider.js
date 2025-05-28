function toogleActive(pictures, activeIndex) {
    for (let i = 0; i < pictures.length; i++) {
        if (i === activeIndex) {
            pictures[i].classList.add("image__picture_active");
        } else {
            pictures[i].classList.remove("image__picture_active");
        }
    }
}

function drawCounter(counter, activeIndex, maxVal) {
    counter.innerText = (activeIndex + 1) + "/" + maxVal;
}

function createSlider(post) {
    let imgIndex = 0;

    const buttons = post.getElementsByClassName("post__image-button");
    const prevButton = buttons[0];
    const nextButton = buttons[1];

    const counter = post.getElementsByClassName("post__image-index")[0];

    const pictures = post.getElementsByClassName("image__picture");

    pictures[0].classList.add("image__picture_active");
    drawCounter(counter, imgIndex, pictures.length);

    prevButton.addEventListener("click", (e) => {
        e.stopPropagation();
        imgIndex = imgIndex - 1 >= 0 ? imgIndex - 1 : pictures.length - 1;
        toogleActive(pictures, imgIndex);
        drawCounter(counter, imgIndex, pictures.length);
    });

    nextButton.addEventListener("click", (e) => {
        e.stopPropagation();
        imgIndex = imgIndex + 1 < pictures.length ? imgIndex + 1 : 0;
        toogleActive(pictures, imgIndex);
        drawCounter(counter, imgIndex, pictures.length);
    })
}