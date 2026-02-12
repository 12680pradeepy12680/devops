<div class="my-plugin-page p-4">
     
        <h4 class="main-heading mb-4">User Search</h4>
	
		<div class="inst_block">
  
		 
		<p id="ajax-response2" class="inst_text"> Please select the type of search phone, email, account number and Enter the value in the search input</p>
		 
		</div>
		
		
 <form id="validationForm" class="Esform" action="process.php" method="post">
        <select id="contactType" name="contactType">
            <option value="phone">Phone</option>
            <option value="email">Email</option>
			<option value="account_number">Account Number</option>
			 
        </select>
        <input type="text" id="contactInput" name="contactInput" placeholder="Search" autocomplete="off">
         
        <input type="submit" value="Submit">
    </form>
	<span id="validationMessage"></span>	
<div id="info" class="table-responsive mt-2">
 
</div>	
</div>