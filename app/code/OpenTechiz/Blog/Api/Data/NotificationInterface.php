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
    const CREATION_TIME            = 'creation_time';

	function getID();

	function getContent();

	function getPostID();

	function getUserID();

	function getCreationTime();

	function setID($id);

	function setContent($content);

	function setPostID($postID);

	function setUserID($userID);

	function setCreationTime($creatTime);
}