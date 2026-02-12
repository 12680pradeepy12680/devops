<div class="my-plugin-page p-4">

<h4 class="main-heading mb-4">Add Location</h4>

<div class="inst_block">

<p  class="inst_text">Please upload .</p>	 

</div>


<form id="addlocationform" class="Esform" action="javascript:void(0);">
    <input type="file" id="locationInput" name="locationInput" placeholder="Card number" autocomplete="off">
	
 
	
	<select id="locationType" name="locationType">
	<option value="">Type</option>
	<option value="pinelabs">Pinelabs</option>
	<option value="innoviti">Innoviti</option>

	</select>
    <input type="submit" value="Submit">
  </form>
<span id="locationMessage"></span>	
<div id="locationsinfo" class="table-responsive mt-2">

</div>	
</div>