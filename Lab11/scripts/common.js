window.onload = function() {
    let feed = document.getElementById("feed");
    Array.from(feed.children).forEach(post => {
        createModal(post);
        createSlider(post);
        createMoreButtonHandler(post);
    });
}