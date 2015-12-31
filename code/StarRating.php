<?php
/**
 *
 * @author Clint Landrum <clint@adaircreative.com>
 * @date 04.21.2014
 */
class StarRating extends DataObject
{
    
    private static $db = array(
        'StarRatingCategory' => 'Varchar(255)',
        'Rating' => 'Int',
        'MaxRating' => 'Int'
    );

    private static $has_one = array(
        'ProductReview' => 'ProductReview'
    );
}
