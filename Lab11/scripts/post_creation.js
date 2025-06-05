const input = document.getElementById("images-input");
const picture = document.querySelector(".post-creation__picture");
const textInput = document.querySelector(".post-creation__text-input");
const submitButton = document.querySelector(".post-creation__submit-button");
const smileWrapper = document.querySelector(".post-creation__smile-wrapper");

const imageClass = "post-creation__image";
const submitButtonActiveClass = "post-creation__submit-button_active";
const smileWrapperHiddenClass = "post-creation__smile-wrapper_hidden";

const sliderWrapperClass = "post-creation__slider";
const sliderButtonClass = "post-creation__image-button";
const sliderButtonsClass = "post-creation__image-buttons";
const sliderIndexClass = "post-creation__image-index";
const sliderImagePictureClass = imageClass;
const sliderImagePictureActiveClass = "post-creation__image_active";

const defaultHeight = 474;

let imageData = [];

function collectImages(postData) {
    if (imageData.length === 1) {
        const uniqueName = `${crypto.randomUUID()}.jpg`;
        const file = new File([imageData[0]], uniqueName, { type: "image/jpeg" });
        postData.append("images[]", file);
    } else {
        imageData.forEach((blob) => {
            const uniqueName = `${crypto.randomUUID()}.jpg`;
            const file = new File([blob], uniqueName, { type: "image/jpeg" });
            postData.append("images[]", file);
        });
    }
}

function collectText(postData) {
    const text = textInput.value.trim();
    const json = JSON.stringify({ text });
    postData.append("data", json);
}

function validateImages() {
    return imageData.length > 0;
}

function validateText() {
    return textInput.value.trim().length > 0;
}

function updateSubmitButton() {
    submitButton.disabled = !(validateImages() && validateText());
    if (submitButton.disabled) {
        submitButton.classList.remove(submitButtonActiveClass);
    } else {
        submitButton.classList.add(submitButtonActiveClass);
    }
}

function resizeImage(img) {
    const canvas = document.createElement("canvas");
    const scale = defaultHeight / img.height;
    canvas.width = img.width * scale;
    canvas.height = img.height * scale;
    const ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    return new Promise(resolve => {
        canvas.toBlob(blob => {
            resolve(blob);
        }, "image/jpeg");
    });
}

function updatePicture(displayImg) {
    if (validateImages()) {
        smileWrapper.classList.add(smileWrapperHiddenClass);

        let sliderWrapper = document.querySelector("." + sliderWrapperClass);
        if (!sliderWrapper) {
            addSliderMarkup(picture);
            sliderWrapper = document.querySelector("." + sliderWrapperClass);
            console.log(sliderWrapper);
            appendImageToSlider(sliderWrapper, displayImg);
            createSlider(sliderWrapper);
        }

        appendImageToSlider(sliderWrapper, displayImg);
    } else {
        smileWrapper.classList.remove(smileWrapperHiddenClass);
        removeSliderMarkup(picture);
    }
}

function fileListener() {
    const files = input.files;
    if (!files.length) {
        updateSubmitButton();
        return;
    }
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const img = new Image();
            img.onload = async () => {
                const resizedBlob = await resizeImage(img);
                const displayImg = new Image();
                displayImg.src = URL.createObjectURL(resizedBlob);
                displayImg.classList.add(imageClass);
                imageData.push(resizedBlob);
                updatePicture(displayImg);
                updateSubmitButton();
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}

async function submitListener(e) {
    e.preventDefault();
    if (!submitButton.disabled) {
        const postData = new FormData();
        collectImages(postData);
        collectText(postData);
        console.log(postData);
        await sendPostData(postData);
    }
}

async function sendPostData(postData) {
    const response = await fetch("http://localhost:8080/api/post.php", {
        method: "POST",
        body: postData
    });

    const result = await response.text();
    console.log("Post result:", result);

    if (response.ok) {
        window.location.href = "/home";
    }
}

window.onload = () => {
    input.addEventListener("change", fileListener);
    textInput.addEventListener("input", updateSubmitButton);
    submitButton.addEventListener("click", submitListener);

    updateSubmitButton();
};