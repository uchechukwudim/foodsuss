/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
 uploader();
});

function searchTag(searchVal) {

}


function processPostArticle() {
    
    var nolink = "NO LINK";
    $('.errMess').html("");
    if (!processAField($('#article_title')) || !processAField($('#article_description'))
        || !processAField($('#article_writeup'))
        || !processAField($('#file'))
        || !processAField($('.tags'))) {
        $('.errMess').html("All fields must be filled");
    } else if(!processAField($('#article_link'))){
                if(confirm('Are you sure your the author of this article?') === true){
                       runPostArticle(nolink);
                }else{
                    alert('Please fill "Article link" as your not the author.');
                }
                
    }else {
               runPostArticle($('#article_link').val());
    }
}

function runPostArticle(link){
     var article_title = $('#article_title').val();
                var article_writeup = $('#article_writeup').val()
                var article_des = $('#article_description').val();
                var tags = $('.tags');

                processPostArticleRequest(article_title, article_writeup, link, article_des, tags);
}


function  processPostArticleRequest(article_title, article_writeup, article_link, article_des, tags){

     $('#file').uploader(""+JURL+"researchAdministration/processPostArticleRequest", {art_title: article_title, art_writeup: article_writeup, art_link: article_link, art_des: article_des, tags: tags},
            function(data)
            {
               $('#submitPostArticle img').remove();
                 
                    if(data === true){
                        alert("Article has been posted");
                    }else{
                        alert("Something went wrong. Please try again later");
                    }

            },
            function(progress){
                $('#submitPostArticle').append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="15">');
            }
      );
}

function processAField($val) {
    if ($($val).val() === EMPTY) {
        return false;
    } else
        return true;
}

function getValue($name) {
    if ($($name).val() !== EMPTY) {
        return  $($name).val();
    }
}


function uploader()
{
 
    $.fn.uploader = function(remote,data,successFn,progressFn) {
		// if we dont have post data, move it along
		if(typeof data != "object") {
			progressFn = successFn;
			successFn = data;
		}
		return this.each(function() {
			if($(this)[0].files[0]) {
				var formData = new FormData();
				formData.append($(this).attr("name"), $(this)[0].files[0]);
 
				// if we have post data too
				if(typeof data == "object") {
					for(var i in data) {
						formData.append(i,data[i]);
					}
				}
 
				// do the ajax request
				$.ajax({
					url: remote,
					type: 'POST',
					xhr: function() {
						myXhr = $.ajaxSettings.xhr();
						if(myXhr.upload && progressFn){
							myXhr.upload.addEventListener('progress',function(prog) {
								var value = ~~((prog.loaded / prog.total) * 100);
 
								// if we passed a progress function
								if(progressFn && typeof progressFn == "function") {
									progressFn(prog,value);
 
								// if we passed a progress element
								} else if (progressFn) {
									$(progressFn).val(value);
								}
							}, false);
						}
						return myXhr;
					},
					data: formData,
					dataType: "json",
					cache: false,
					contentType: false,
					processData: false,
					complete : function(res) {
						var json;
						try {
							json = JSON.parse(res.responseText);
						} catch(e) {
							json = res.responseText;
						}
						if(successFn) successFn(json);
					}
				});
			}
		});
               
	};
}

