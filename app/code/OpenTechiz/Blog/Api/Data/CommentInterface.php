<?php 
namespace OpenTechiz\Blog\Api\Data;
/**
* Blog Post Interface
* @api
*/
interface CommentInterface
{
	/**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const COMMENT_ID                  = 'comment_id';
    const CONTENT                  = 'content';
    const AUTHOR                    = 'author';
    const POST_ID                  = 'post_id';
    const CREATION_TIME            = 'creation_time';

	function getID();

	function getContent();

	function getAuthor();

	function getPostID();

	function getCreationTime();

	function setID($id);

	function setContent($content);

	function setAuthor($author);

	function setPostID($postID);

	function setCreationTime($creatTime);

}