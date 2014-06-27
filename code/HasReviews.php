<?php
/**
 *
 * @author Clint Landrum <clint@adaircreative.com>
 * @date 04.21.2014
 */
class HasReviews extends DataExtension {
	
	private static $moderated_comments;
	
	private static $has_many = array(
		'Reviews' => 'ProductReview'
	);
	
	public function getProductReviews() {
		$moderated = $this->owner->stat('moderated_comments');
		if ($moderated) {
			return $this->owner->Reviews()->filter('Approved', '1');
		}
		return $this->owner->Reviews();
	}
}

class HasReviews_Controller extends Extension {
	static $allowed_actions = array(
		'ProductReviewForm'
	);

	public function ProductReviewForm(){
		return new ProductReviewForm($this->owner,'ProductReviewForm');
	}

}