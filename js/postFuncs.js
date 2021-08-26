
onbeforeunload = sessionStorage.clear();

function loadFeed(feed) {
	if(window.pageYOffset + window.innerHeight >= (document.documentElement.scrollHeight - 700)) {
		if(sessionStorage.feedLStatus != 'exec' && Number(sessionStorage.lastPostId) != 1) {
			sessionStorage.feedLStatus = 'exec';

			const feedRequest = new XMLHttpRequest();
			
			feedRequest.onreadystatechange = function () {
				if(this.readyState == 4 && this.status == 200) {
					const response = JSON.parse(this.responseText);					
					document.getElementById("feedTray").innerHTML += response.posts;
					sessionStorage.setItem("lastPostId", response.lastPostId);
					sessionStorage.feedLStatus = 'done';
				}
			};
			if(feed === "feed"){
				feedRequest.open("POST", "../php/loadFeedAjax.php");
			} else if(feed === "busca"){
				feedRequest.open("POST", "../php/loadFeedBuscAjax.php");
			}
			feedRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			
			if (Number(sessionStorage.lastPostId) > 0) {
				const toSend = "lastPostId=" + Number(sessionStorage.lastPostId);
				feedRequest.send(toSend);
			} else {
				sessionStorage.lastPostId = 0;
				const toSend = "lastPostId=" + Number(sessionStorage.lastPostId);
				feedRequest.send(toSend);
			}
		}
	}
}

function sendPostComment(formCode) {
	
	const userCommentId = 'postUserCom' + formCode;
	const commentDivId = 'postComments' + formCode;
	const userComment = document.getElementById(userCommentId).value;
	const commentDiv = document.getElementById(commentDivId);
	
	if (userComment.replaceAll(' ', '').length > 0) {
	
		document.getElementById(userCommentId).value = "";

		const postComReq = new XMLHttpRequest();

		postComReq.onreadystatechange = function () {
			if(this.readyState == 4 && this.status == 200) {
				if(this.responseText.length > 3){					
					commentDiv.innerHTML = this.responseText;					
				}
			}
		};

		postComReq.open("POST", "../php/postComAjax.php");
		postComReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		const toSend = "userComment=" + userComment + "&postId=" + formCode;
		postComReq.send(toSend);
		
	}
	
}

function comCheckKey(com) {
	const char = event.keyCode || event.which;
	if(char == 13){
		const comId = com.id.replaceAll('postUserCom', '');
		sendPostComment(comId);
	}
}

function likeAPost(likeId, postId) {
		
	const totLikeId = document.getElementById("postTotLike"+postId);

	const postLikeReq = new XMLHttpRequest();

	postLikeReq.onreadystatechange = function () {
		if(this.readyState == 4 && this.status == 200) {
			if(this.responseText.length > 3){
				const response = JSON.parse(this.responseText);
				likeId.src = response.src;
				totLikeId.innerHTML = response.likes;
			}
		}
	};

	postLikeReq.open("POST", "../php/postLikeAjax.php");
	postLikeReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	const toSend = "postId=" + postId;
	postLikeReq.send(toSend);
	
}

function reportPost(postId){

    const request = new XMLHttpRequest();

    request.onload = function(){
		const response = JSON.parse(this.responseText);
        alert(response.msg);
    }

    request.open("POST", "../php/postReportAjax.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const toSend = "postId=" + postId;
    request.send(toSend);    
}