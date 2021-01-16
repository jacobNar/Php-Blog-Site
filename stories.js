$(function(){
    $('.comment-btn').click(function() {
        var id = $(this).attr('id');
            
        var form = `<form id="newComment" method="post" action="createComment.php">
            <input type='hidden' name='postId' value='${id}'>
            <label for='commentName'>Your Name: </label>
            <input id='commentName' name='commentName' type='text'>
            <label for='comment'>Comment: </label>
            <textarea id='comment' name='comment' form='newComment'></textarea>
            <input name="submit" type='submit' value='Submit'>
            </form>`;
                
        var selector = `#comment-form${id}`;
        var formBox = $(selector).html();
        if(formBox == ""){
            $(selector).html(form);
        }else {
            $(selector).html("");
        }
        
        
    });
});

