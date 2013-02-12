<form action="/" id="search-properties" method="post" onsubmit="$('register_button').disabled = true">
	<input id="community_id" name="community_id" type="hidden" value="372">
	<input id="user_username" name="user[username]" type="hidden" value="graphememan">
	<input id="user_identity_url" name="user[identity_url]" type="hidden">
	<ul class="form-selector">
		<li class="active"><a href="#">For Sale</a></li>
		<li><a href="#">For Rent</a></li>
		<li><a href="#">Sold</a></li>
	</ul>
	<p>
		<label>Address, City, Zip, Neighborhood or #MLS</label>
		<input id="property_mls" name="search[property_mls]" size="30" type="text" placeholder="To search for an MLS Listing Number, please type a # symbol in front of the number">
		<select id="property_beds_num" name="search[beds_num]">
			<option value="">Beds</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<select id="property_baths_num" name="search[baths_num]">
			<option value="">Baths</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
	</p>
	<p>
		<input id="property_min_price" name="search[property_min_price]" size="30" type="text" placeholder="$ Min"> <span class="decision">to</span> 	
		<input id="property_max_price" name="search[property_max_price]" size="30" type="text" placeholder="$ Max"> 
		<select id="property_square_feet" name="search[square_feet]" class="tall">
			<option value="">Square Feet</option>
			<option value="1">Any</option>
			<option value="2">250 -</option>
			<option value="3">500 -</option>
			<option value="4">1,000 -</option>
			<option value="5">1,250 -</option>
		</select>
		<select id="property_type" name="search[type]" class="tall">
			<option value="">Property Type</option>
			<option value="1">Any</option>
			<option value="2">Single-Family Home</option>
			<option value="3">Condo</option>
			<option value="4">Townhome</option>
			<option value="5">Coop</option>
		</select>
	</p>
	<p class="button-row">
		<input class="btn-submit" id="search_button" name="commit" type="submit" value="Search">
	</p>
	<div class="clear"> </div>
</form>