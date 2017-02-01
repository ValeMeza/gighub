<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");

/**
 * Information of the venue (name & physical location)
 *
 * An example of how the data on the venues is stored in the database
 *
 * @author Dante Conley <danteconley@icloud.com>
 * @version 1.0
 **/

class Venue implements \JsonSerializable {
	/**
	 * id for this Venue; this is the primary key
	 * @var int $venueId
	 **/
	private $venueId;
	/**
	 * the username which the venue is attached to; this is a foreign key
	 * @var int $venueProfileId
	 **/
	private $venueProfileId;
	/**
	 * the name of the venue
	 * @var string $venueName
	 **/
	private $venueName;
	/**
	 * the first street address of the venue
	 * @var string $venueStreet1
	 **/
	private $venueStreet1;
	/**
	 * the second street address of the venue (if any)
	 * @var string $venueStreet2
	 **/
	private $venueStreet2;
	/**
	 * the city in which the venue is located
	 * @var string $venueCity
	 **/
	private $venueCity;
	/**
	 * state in which the venue is located
	 * @var string $venueState
	 **/
	private $venueState;
	/**
	 * zip code in which venue is located
	 * @var string $venueZip
	 **/
	private $venueZip;

	/**
	 * constructor for this Venue
	 *
	 * @param int|null $newVenueId id of this venue or null if a new venue
	 * @param int $newVenueProfileId id of the profile who owns this venue
	 * @param string $newVenueName string containing the venue name
	 * @param string $newVenueStreet1 string containing the first line of the street address
	 * @param string $newVenueStreet2 string containing the second line of a street address (if any)
	 * @param string $newVenueCity string containing the city in which the venue is located
	 * @param string $newVenueState string containing the state in which the venue is located
	 * @param string $newVenueZip string containing the zip code in which the venue is located
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (eg strings too long, negative integers)
	 * @throws \TypeError if data types violate hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newVenueId = null, int $newVenueProfileId, string $newVenueName, string $newVenueStreet1, string $newVenueStreet2, string $newVenueCity, string $newVenueState, string $newVenueZip) {
		try{
			$this->setVenueId($newVenueId);
			$this->setVenueProfileId($newVenueId);
			$this->setVenueName($newVenueName);
			$this->setVenueStreet1($newVenueStreet1);
			$this->setVenueStreet2($newVenueStreet2);
			$this->setVenueCity($newVenueCity);
			$this->setVenueState($newVenueState);
			$this->setVenueZip($newVenueZip);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for venue id
	 *
	 * @return int|null value of venue id
	 **/
	public function getVenueId() {
		return($this->venueId);
	}

	/** mutator method for venue id
	 *
	 * @param int|null $newVenueId new value of venue id
	 * @throws \RangeException if $newVenueId is not positive
	 * @throws \TypeError if $newVenueId is not an integer
	 **/
	public function setVenueId(int $newVenueId = null) {
		// base case: if the venue id is null, this is a new venue without a mySQL assigned (yet)
		if($newVenueId === null) {
			$this->venueId = null;
			return;
		}

		// verify venue id is positive
		if($newVenueId <=0) {
			throw(new \RangeException("venue id is not positive"));
		}

		// convert and store the venue id
		$this->venueId = $newVenueId;
	}

	/**
	 * accessor method for venue profile id
	 *
	 * @return int value of the venue profile id
	 **/
	public function getVenueProfileId() {
		return($this->venueProfileId);
	}

	/**
	 * mutator method for venue profile id
	 *
	 * @param int $newVenueProfileId
	 * @throws \RangeException if $newVenueProfileId is not positive
	 * @throws \TypeError if $newVenueId is not an integer
	 **/
	public function  setVenueProfileId(int $newVenueProfileId) {
		// verify the new profile id is positive
		if($newVenueProfileId <= 0) {
			throw(new \RangeException("venue profile id is not positive"));
		}

		// convert and store the profile id
		$this->venueProfileId = $newVenueProfileId;
	}

	/**
	 * accessor method for venue name
	 *
	 * @return string value of the venue name
	 **/
	public function getVenueName() {
		return($this->venueName);
	}

	/**
	 * mutator method for venue name
	 *
	 * @param string $newVenueName new value of venue name
	 * @throws \InvalidArgumentException if $newVenueName is insecure
	 * @throws \RangeException if venueName is > 64 characters
	 * @throws \TypeError if $newVenueName is not a string
	 **/
	public function setVenueName(string $newVenueName) {
		// verify the !!!! is secure
		$newVenueName = trim($newVenueName);
		$newVenueName = filter_var($newVenueName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueName) === true) {
			throw(new \InvalidArgumentException("venue name is empty or insecure"));
		}

		// verify the !!!!! content will fit into the database
		if(strlen($newVenueName) > 64) {
			throw(new \RangeException("venue name content too large"));
		}

		// store the !!!! content
		$this->venueName = $newVenueName;
	}

	/**
	 * accessor method for venue street 1
	 *
	 * @return string value of the venue street 1
	 **/
	public function getVenueStreet1() {
		return($this->venueStreet1);
	}

		/**
		 * mutator method for venue street 1
		 *
		 * @param string $newVenueStreet1 new value of venueStreet1
		 * @throws \InvalidArgumentException if $newVenueStreet1 is insecure
		 * @throws \RangeException if venueStreet1 is > 64 characters
		 * @throws \TypeError if $newVenueStreet1 is not a string
		 **/
	public function setVenueStreet1(string $newVenueStreet1) {
	// verify the venue street 2 is secure
	$newVenueStreet1 = trim($newVenueStreet1);
		$newVenueStreet1 = filter_var($newVenueStreet1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueStreet1) === true) {
		throw(new \InvalidArgumentException("venue street 1 is empty or insecure"));
		}

		// verify the venue street 1 content will fit into the database
		if(strlen($newVenueStreet1) > 64) {
		throw(new \RangeException("venue street 1 content too large"));
	}

		// store the !!!! content
		$this->venueStreet1 = $newVenueStreet1;
	}

	/**
	 * accessor method for venue street 2 (if any)
	 *
	 * @return string value of the venue street 2 (if any)
	 **/
	public function getVenueStreet2() {
		return($this->venueStreet2);
	}

		/**
		 * mutator method for venue street 2
		 *
		 * @param string $newVenueStreet2 new value of venue street 2
		 * @throws \InvalidArgumentException if $newVenueStreet2 is insecure
		 * @throws \RangeException if venueStreet2 is > 64 characters
		 * @throws \TypeError if $newVenueStreet2 is not a string
		 **/
	public function setVenueStreet2(string $newVenueStreet2) {
	// verify the venue street 2 is secure
	$newVenueStreet2 = trim($newVenueStreet2);
		$newVenueStreet2 = filter_var($newVenueStreet2, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueStreet2) === true) {
		throw(new \InvalidArgumentException("venue street 2 is empty or insecure"));
		}

		// verify the venue street 2 content will fit into the database
		if(strlen($newVenueStreet2) > 64) {
		throw(new \RangeException("venue street 2 content too large"));
	}

		// store the venueStreet2 content
		$this->venueStreet2 = $newVenueStreet2;
	}

	/**
	 * accessor method for venue city
	 *
	 * @return string value of the venue city
	 **/
	public function getVenueCity() {
		return($this->venueCity);
	}

		/**
		 * mutator method for venue city
		 *
		 * @param string $newVenueCity new value of venue city
		 * @throws \InvalidArgumentException if $newVenueCity is insecure
		 * @throws \RangeException if venueCity is > 100 characters
		 * @throws \TypeError if $newVenueCity is not a string
		 **/
	public function setVenueCity(string $newVenueCity) {
	// verify the venue city is secure
	$newVenueCity = trim($newVenueCity);
		$newVenueCity = filter_var($newVenueCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueCity) === true) {
		throw(new \InvalidArgumentException("venue city is empty or insecure"));
		}

		// verify the venue city content will fit into the database
		if(strlen($newVenueCity) > 100) {
		throw(new \RangeException("venue city content too large"));
	}

		// store the venue city content
		$this->venueCity = $newVenueCity;
	}

	/**
	 * accessor method for venue state
	 *
	 * @return string value of the venue state
	 **/
	public function getVenueState() {
		return($this->venueState);
	}

		/**
		 * mutator method for venue state
		 *
		 * @param string $newVenueState new value of venue state
		 * @throws \InvalidArgumentException if $newVenueState is insecure
		 * @throws \RangeException if venueState is > 2 characters
		 * @throws \TypeError if $newVenueState is not a string
		 **/
	public function setVenueState(string $newVenueState) {
	// verify the venue state is secure
	$newVenueState = trim($newVenueState);
		$newVenueState = filter_var($newVenueState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueState) === true) {
		throw(new \InvalidArgumentException("venue state is empty or insecure"));
		}

		// verify the venue state content will fit into the database
		if(strlen($newVenueState) > 2) {
		throw(new \RangeException("venue state content too large"));
	}

		// store the venue state content
		$this->venueState = $newVenueState;
	}

	/**
	 * accessor method for venue zip
	 *
	 * @return string value of the venue zip
	 **/
	public function getVenueZip() {
		return($this->venueZip);
	}

		/**
		 * mutator method for venue zip
		 *
		 * @param string $newVenueZip new value of venue zip
		 * @throws \InvalidArgumentException if $newVenueZip is insecure
		 * @throws \RangeException if venueZip is > 10 characters
		 * @throws \TypeError if $new!!!!!! is not a string
		 **/
	public function setVenueZip(string $newVenueZip) {
	// verify the venue zip is secure
	$newVenueZip = trim($newVenueZip);
		$newVenueZip = filter_var($newVenueZip, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueZip) === true) {
		throw(new \InvalidArgumentException("venue zip is empty or insecure"));
		}

		// verify the venue zip content will fit into the database
		if(strlen($newVenueZip) > 10) {
		throw(new \RangeException("venue zip content too large"));
	}

		// store the venue zip content
		$this->venueZip = $newVenueZip;
	}

		/**
		 * formats the state variables for JSON serialization
		 *
		 * @return array resulting state variables to serialize
		 **/
	public function jsonSerialize() {
	$fields = get_object_vars($this);
	return($fields);
}

}