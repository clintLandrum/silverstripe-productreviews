<?php
class ProductReviewForm extends Form {

	private static $star_rating_categories = array();
	private static $max_stars;

    public function __construct($controller, $name) {
				
		$starRatingCats = $this->stat('star_rating_categories');
		$maxStars = $this->stat('max_stars');
		
		$fields = FieldList::create(
			$starRatingFields = CompositeField::Create(),
			TextField::create('Title','')->setAttribute('placeholder','Title')->setAttribute('required','true'),
			TextareaField::create('Comments','')->setAttribute('placeholder','Comments')->setAttribute('required','true'),
			HiddenField::create('MaxRating')->setValue($maxStars)
		);
		if($starRatingCats) {
			foreach($starRatingCats as $cat=>$catName) {
				$starRatingFields->push(NumericField::create('StarRating[' . $catName . ']', $catName)->setAttribute('type','number')->setAttribute('data-max', $maxStars)->setAttribute('data-min', '1')->addExtraClass('rating'));
			}
		}
		
		$actions = FieldList::create(
			FormAction::create('process','Submit')->addExtraClass('btn btn-primary')
		);

        parent::__construct($controller, $name, $fields, $actions);

		$this->setHTMLID('product-review-form');
		$this->disableSecurityToken();

    }
     
	public function process($data, $form) {
	
		$productID = $this->Controller->ID;
		$memberID = Member::currentUser()->ID;	
		$review = new ProductReview($data);	
		$review->ProductID = $productID;
		$review->MemberID = $memberID;
		$review->write();
		
		$starRatings = $data['StarRating'];
		$maxRating = $data['MaxRating'];
		foreach($starRatings as $k=>$v) {
			$starRating = new StarRating();
			$starRating->StarRatingCategory = $k;
			$starRating->Rating = $v;
			$starRating->MaxRating = $maxRating;
			$starRating->ProductReviewID = $review->ID;
			$starRating->write();
		}
		
		$this->Controller->redirectBack();
		
	}
	
}