function toogleModalActive(pictures, activeIndex) {
    for (let i = 0; i < pictures.length; i++) {
        if (i === activeIndex) {
            pictures[i].classList.add("modal__picture_active");
        } else {
            pictures[i].classList.remove("modal__picture_active");
        }
    }
}

function drawModalCounter(counter, activeIndex, maxVal) {
    counter.innerText = (activeIndex + 1) + " из " + maxVal;
}

function createModalSlider(pictures, buttons, counter, startIndex) {
    let imgIndex = startIndex;
    const prevButton = buttons[0];
    const nextButton = buttons[1];

    drawModalCounter(counter, imgIndex, pictures.length);

    prevButton.addEventListener("click", () => {
        imgIndex = imgIndex - 1 >= 0 ? imgIndex - 1 : pictures.length - 1;
        toogleModalActive(pictures, imgIndex);
        drawModalCounter(counter, imgIndex, pictures.length);
    });

    nextButton.addEventListener("click", () => {
        imgIndex = imgIndex + 1 < pictures.length ? imgIndex + 1 : 0;
        toogleModalActive(pictures, imgIndex);
        drawModalCounter(counter, imgIndex, pictures.length);
    })
}

function renderModal(post) {
    const body = document.getElementsByTagName("body")[0];
    body.classList.add("main_block");
    const modalWindow = document.getElementById("modal");
    const picHTML = post.getElementsByClassName("post__image")[0].innerHTML;
    modalWindow.classList.toggle("modal_active");
    modalWindow.innerHTML = `
        <div class="modal__close">
            <img src="../images/icons/cross_button.svg" class="close__icon">
        </div>
        <div class="modal__image">
            ${picHTML}
        </div>
        <div class="modal__image-index"></div>
    `;
    let pics = modalWindow.getElementsByClassName("image__picture");
    console.log(pics);
    Array.from(pics).forEach(pic => {
        pic.classList.remove("image__picture");
        pic.classList.add("modal__picture");
        if (pic.classList.contains("image__picture_active")) {
            pic.classList.add("modal__picture_active");
            pic.classList.remove("image__picture_active")
        }
    });
    pics = modalWindow.getElementsByClassName("modal__picture")
    const buttons = modalWindow.getElementsByClassName("post__image-buttons")[0].children;
    Array.from(buttons).forEach(button => {
        button.classList.remove("post__image-button");
        button.classList.add("modal__image-button");
    });
    const prevCounter = modalWindow.getElementsByClassName("post__image-index")[0];
    const startIndex = parseInt(prevCounter.innerText.split("/")[0], 10) - 1;
    prevCounter.remove();
    document.addEventListener("keypress", keyCloseListener);
    modalWindow.getElementsByClassName("close__icon")[0].addEventListener("click", clickCloseListener);
    const counter = modalWindow.getElementsByClassName("modal__image-index")[0];
    console.log(counter, pics, buttons, startIndex);
    createModalSlider(pics, buttons, counter, startIndex);
}

function keyCloseListener(e) {
    if (e.key === "Escape") {
        clearModal();
    }
}

function clickCloseListener() {
    clearModal();
}

function clearModal() {
    const body = document.getElementsByTagName("body")[0];
    body.classList.remove("main_block");
    const modalWindow = document.getElementById("modal");
    modalWindow.getElementsByClassName("close__icon")[0].removeEventListener("click", clickCloseListener)
    modalWindow.classList.toggle("modal_active");
    modalWindow.innerHTML = ""; 
    document.removeEventListener("keypress", keyCloseListener);
}

function createModal(post) {
    const img = post.getElementsByClassName('post__image')[0];
    img.addEventListener("click", () => {
        renderModal(post);
    });
}