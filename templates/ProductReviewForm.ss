<h4>Review This Product</h4>
<form $FormAttributes>
    <% if $Message %>
        <p id="{$FormName}_error" class="message $MessageType">$Message</p>
    <% else %>
        <p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
    <% end_if %>

     $Fields

    <% if $Actions %>
    <div class="Actions">
        <% loop $Actions %>
        	<% if Name == 'action_process' %>
        	<input class="btn button" type="submit" name="action_process" value="Submit" id="product-review-form_action_process">
        	<% else %>
	        $Field
	        <% end_if %>
        <% end_loop %>
    </div>
    <% end_if %>
</form>
<hr />
<% require javascript("product-reviews/bower_components/bootstrap-rating-input/build/bootstrap-rating-input.min.js") %>