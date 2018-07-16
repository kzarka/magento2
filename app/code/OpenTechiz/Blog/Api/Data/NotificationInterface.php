<?php 
namespace OpenTechiz\Blog\Api\Data;
/**
* Blog Post Interface
* @api
*/
interface NotificationInterface
{
	/**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const NOTI_ID                  = 'noti_id';
    const CONTENT                  = 'content';
    const POST_ID                  = 'post_id';
    const USER_ID					= 'user_id';
    const COMMENT_ID			= 'comment_id';
    const IS_VIEWED				= 'is_viewed';
    const CREATION_TIME            = 'creation_time';

	function getId();

	function getContent();

	function getPostId();

	function getUserId();

	function getCommentId();

	function isViewed($isViewed = null);

	function getCreationTime();

	function setId($id);

	function setContent($content);

	function setPostId($postID);

	function setCommentId($commentID);

	function setUserId($userID);

	function setCreationTime($creatTime);
}