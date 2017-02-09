<?php
namespace Edu\Cnm\Jramirez98\GigHub\Test;

use Edu\Cnm\jramirez98\GigHub\{Profile, Post };

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "../classes/autoload.php");

/**
 * Full PHPUnit test for the Post class
 *
 * This is a complete PHPUnit test of the Post class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Post
 * @author Joseph Ramirez <jramirez98@cnm.edu>
 **/
class PostTest extends GigHubTest {
	/**
	 * content of the PostContent
	 * @var string $VALID_POSTCONTENT
	 **/
	protected $VALID_POSTCONTENT = "PHPUnit test is postitve... for success";
	/**
	 * content of the updated postContent
	 * @var string $VALID_POSTCONTENT2
	 **/
	protected $VALID_POSTCONTENT2 = "BELIEVE IT OR NOT... it passed the second gate of Hell ";
	/**
	 * timestamp of the Post; this starts as null and is assigned later
	 * @var DateTime $VALID_POSTCREATEDDATE
	 **/
	protected $VALID_POSTCREATEDDATE = null;
	/**
	 * date and time of the event; this starts as null and is assigned later
	 * @var DateTime $VALID_POSTEVENTDATE
	 **/
	protected $VALID_POSTEVENTDATE = null;
	/**
	 * profile that created the Post; this is for foreign key relations
	 * @var Post profile id
	 */
	protected $profile;

// TODO: create set up method that creates a profile
	/**
	 *test inserting a post, editing it, and then updating it
	 */
	public function testUpdateValidPost() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->retRowCount("post");

		// create a new Post and insert to into mySQL
		$post = new Post(null, $this->profile->getPostProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());

		//edit the Post and update it in mySQL
		$post->setPostContent($this->profile->VALID_POSTCONTENT2);
		$post->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostby($this->getPDO(), $post->get());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost - getpostProfileId(), $this->profile->getPostProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT2);
		$this->assertEquals($pdoPost->getPostDate(), $this->VALID_POSTCREATEDDATE);
		$this->assertEquals($pdoPost->getPostDate(), $this->VALID_POSTEVENTDATE);
	}

	/**
	 * test updating a post that does not exist
	 *
	 * @exceptedException PDoException
	 */
	public function testUpdateInvalidPost() {
		// create a post, try to update it without actually updating it and watch it fail
		$post = new Post(null, $this->profile - getPostProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE);
		$post->update($this->getPDO());
	}

	/**
	 * test creating a post and then deleting it
	 */
	public function testDeleteValidPost() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		// create a new post and insert into mySQL
		$post = new Post(null, $this->profile->getProfileId, $this->$this->getConnection()->getRowCount("post"));
		$post->insert($this->getPDO());

		// delete the Post from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$post->delete($this->getPDO());

		// grab the data from mySQL and enforce the Post does not exist
		$pdoPost = Post::getPostProfilebyPostProfileId($this->getPDO(), $post->getPostProfileId());
		$this->assertNUll($pdoPost);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("post"));
	}

	/**
	 *test deleting a post that does not exist
	 */
	public function testDeleteInvalidPost() {
		// create a post and try to delete it without actually inserting it
		$post = new Post(null, $this->getPostProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_EVENTDATE);
		$post->delete($this->getPDO());
	}

}