define([
	"jquery",
    "mage/template",
    "mage/translate",
    "domReady!"
], function($, mageTemplate) {
	"use strict";
	
	return {
        loadComments : function(config){
			var AjaxCommentLoadUrl = config.AjaxCommentLoadUrl;
			var AjaxPostId = config.AjaxPostId;
			$.ajax({
				url: AjaxCommentLoadUrl,
				type: 'POST',
				data: {
					post_id: AjaxPostId
				}
			}).done(function(data){
				var comments = data.items;
				var template = mageTemplate('#blog-comment');
				comments.forEach(function(cmt){
					var newField = template({
			            cmt: cmt
			        });

			        $('ul#data').append(newField);
			    });
			});
        }
    };
});