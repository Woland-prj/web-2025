async function sendLike(postId, action = "inc") {
    try {
        const response = await fetch(`http://localhost:8080/api/likes.php?postId=${postId}`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ type: action }),
        });

        const data = await response.json();

        if (!response.ok) {
            console.error("Error like sending", data.message || data);
            return invalidCount;
        }

        return data.likes;
    } catch (error) {
        console.error("Error like sending:", error);
        return invalidCount;
    }
}

const invalidCount = -1;
const likesActiveClass = "post__likes_active";

async function likeListener(e){

}

function createLikesCounter(post) {
    let likes = post.querySelector(".post__likes");
    console.log(likes)
    likes.addEventListener("click", async (e) => {
        e.preventDefault();
        const likesCount = post.querySelector(".post__likes-count");
        console.log(likesCount)

        if (likes.classList.contains(likesActiveClass)) {
            let value = await sendLike(post?.id,"dec");
            if (value !== invalidCount) {
                likesCount.innerText = value;
                likes.classList.remove(likesActiveClass);
            }
        } else {
            let value = await sendLike(post?.id,"inc");
            console.log(value)
            if (value !== invalidCount) {
                likesCount.innerText = value;
                likes.classList.add(likesActiveClass);
            }
        }
    });
}

