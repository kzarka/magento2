define([
	"jquery",
	"jquery/ui",
], function($) {
	"use strict";
	
	return {
        loadComments : function(config){
        	//console.log("ABC");
			var AjaxCommentLoadUrl = config.AjaxCommentLoadUrl;
			var AjaxPostId = config.AjaxPostId;
			$.ajax({
				url: AjaxCommentLoadUrl,
				type: 'POST',
				data: {
					post_id: AjaxPostId
				}
			}).done(function(data){
				console.log(data);
				var comments = data.items;
				var html = '<ul class="blog-post-list">';
				comments.forEach(function(cmt){
					html += '<li class="blog-post-list-item">'+cmt.author;
					html += '<div class="blog-post-item-content">'+cmt.content+'</div>';
					html += '<div class="blog-post-item-meta">';
					html += '<small>Created at:'+cmt.creation_time+'</small>';
					html += '</div>';
					html += '</li>';
				});

				html += '</ul>';
				$('#data').html(html);

			});
        }
    };
});