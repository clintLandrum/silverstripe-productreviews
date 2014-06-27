<?php
/**
 *
 * @author Clint Landrum <clint@adaircreative.com>
 * @date 04.21.2014
 */
class ProductReview extends DataObject {

	private static $db = array(
		'Title' => 'Varchar',
		'Comments' => 'Text',
		'Approved' => 'Boolean'
	);
	private static $has_one = array(
		'Product' => 'Product',
		'Member' => 'Member'
	);

	private static $has_many = array(
		'StarRatings' => 'StarRating'
	);
	
	private static $summary_fields = array(
		'Product.Title' => 'Product',
		'Title' => 'Title',
		'Created' => 'Created',
		'MemberDetails' => 'Reviewer',
		'Status' => 'Status'
	);
	
	private static $default_sort = 'Created DESC';
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$createdDate = new Date();
		$createdDate->setValue($this->Created);
		$reviewer = $this->Member()->Name;
		$email = $this->Member()->Email;
		$star = "&#9733;";
		$emptyStar = "&#9734;";
		$fields->insertBefore(LiteralField::create('reviewer', '<p>Written by <strong>' . $this->getMemberDetails() . '</strong><br />' . $createdDate->Format('l F jS Y h:i:s A') . '</p>'), 'Title');
		
		$fields->insertBefore(CheckboxField::create('Approved'),'Title');
		
		$starRatings = $this->StarRatings();
		foreach($starRatings as $starRating) {
			$cat = $starRating->StarRatingCategory;
			$stars = str_repeat($star, $starRating->Rating);
			$ratingStars = $stars;
			$maxRating = $starRating->MaxRating - $starRating->Rating;
			$emptyStarRepeat = str_repeat($emptyStar, $maxRating);
			$emptyStars = $emptyStarRepeat;
			/* 4/5 Stars */
			$ratingInfo = $ratingStars . $emptyStars . ' (' . $starRating->Rating . ' of ' . $starRating->MaxRating . ' Stars)';
			$fields->insertBefore(ReadonlyField::create('rating_'.$cat, $cat, html_entity_decode($ratingInfo, ENT_COMPAT, 'UTF-8')), 'Title');
		}
		
		
		$fields->removeByName('StarRatings');
		$fields->removeByName('MemberID');
		$fields->removeByName('ProductID');

		return $fields;
	}

	public function getStatus() {
		return $this->Approved ? 'Approved' : 'Pending';
	}

	public function getMemberDetails() {
		$reviewer = $this->Member()->Name;
		$email = $this->Member()->Email;
		return $reviewer .' (' . $email .')';
	}
}