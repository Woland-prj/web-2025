function createMoreButtonHandler(post) {
    const button = post.getElementsByClassName("post__show-text-button")[0];
    const text = post.getElementsByClassName("post__text")[0];

    button.addEventListener("click", () => {
        if (text.classList.contains('post__text_maximized')) {
            button.innerText = "ещё"
        } else {
            button.innerText = "скрыть"
        }
        text.classList.toggle('post__text_maximized')
    })
}