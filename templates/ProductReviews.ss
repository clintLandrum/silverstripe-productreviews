<% if $ProductReviews %>
	<% loop $ProductReviews %>
		<div class="product-review">
			<h4 class="review-title">$Title</h4>
			<% loop $StarRatings %>
				<% if $Rating >= 1 %>
					<div class="star-ratings">
						<strong class="rating-label">$StarRatingCategory ({$Rating}/{$MaxRating} Stars)</strong>
						<span class="glyphicon glyphicon-star<% if $Rating < 1 %>-empty<% end_if %>"></span>
						<span class="glyphicon glyphicon-star<% if $Rating < 2 %>-empty<% end_if %>"></span>
						<span class="glyphicon glyphicon-star<% if $Rating < 3 %>-empty<% end_if %>"></span>
						<span class="glyphicon glyphicon-star<% if $Rating < 4 %>-empty<% end_if %>"></span>
						<span class="glyphicon glyphicon-star<% if $Rating < 5 %>-empty<% end_if %>"></span>
					</div>
				<% end_if %>
			<% end_loop %>
			<div class="clearfix"></div>
			<p class="rating-comments">$Comments</p>
			<i>$Created.Month $Created.DayOfMonth, $Created.Year</i>
		</div>
	<% end_loop %>
<% else %>
	<p>This product doesn't have any reviews yet.</p>
<% end_if %>