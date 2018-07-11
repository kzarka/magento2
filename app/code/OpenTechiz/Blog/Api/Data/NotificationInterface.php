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

	function getID();

	function getContent();

	function getPostID();

	function getUserID();

	function getCommentID();

	function isViewed();

	function getCreationTime();

	function setID($id);

	function setContent($content);

	function setPostID($postID);

	function setCommentID($commentID);

	function setIsViewed($isViewed);

	function setUserID($userID);

	function setCreationTime($creatTime);
}