window.addEventListener("load", ()=>{
    document.getElementById("createThread").addEventListener("click", showForm);
    document.getElementById("cancelThread").addEventListener("click", hideForm);
    document.getElementById("cancelComment").addEventListener("click", hideCommentForm);
    document.getElementById("submitNewThread").addEventListener("click", hideForm);
    let commentButtons = document.getElementsByClassName("commentButtons");
    for(let i = 0; i <= commentButtons.length -1; i++){
        commentButtons[i].addEventListener("click", showCommentForm);
    }
});

function showForm(){
    document.getElementById("newThreadContainer").style.display = "block";
    //document.getElementById("wrapper").style.filter = "blur(10px)";
}

function hideForm(){
    document.getElementById("newThreadContainer").style.display = "none";
    document.getElementById("wrapper").style.filter = "blur(0px)";
}

function showCommentForm (){
    let id = event.target.id;
    document.getElementById("postId").value = id;
    console.log(document.getElementById("postId").value);
    document.getElementById("newCommentContainer").style.display = "block";
}

function hideCommentForm(){
    document.getElementById("newCommentContainer").style.display = "none";
}