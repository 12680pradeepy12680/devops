<div class="my-plugin-page p-4">

<h4 class="main-heading mb-4">Bulk upload Location</h4>

<div class="inst_block">

<p  class="inst_text">Please upload .</p>	 

</div>


<form id="FSaddlocationform" class="Esform" action="javascript:void(0);">
    <input type="file" id="FSlocationInput" name="FSlocationInput" >
	
 
	
	<select id="FSlocationType" name="FSlocationType">
	<option value="">Type</option>
	<option value="firstdata">First Data</option>
	 

	</select>
    <input type="submit" value="Submit">
  </form>
<span id="FSlocationMessage"></span>	
<div id="FSlocationsinfo" class="table-responsive mt-2">

</div>	
<div class="container" style="background:#F6F9FF;">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center m-4">
			<div id="fs_info">
                <h2 class="no-heading">No records found</h2>
                
				 
            </div>
			<button class="btn btn-primary" type="button" id="fsdownloadCSVButton" style="display: none" >Click here to download</button>
            </div>
        </div>
    </div>
</div>