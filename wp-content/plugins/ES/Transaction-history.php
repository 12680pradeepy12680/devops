<div class="container">
 
<div class="row h-100 my-plugin-page p-4">
<div class="col-md-12">
     
        <h4 class="main-heading mb-4">Transaction History</h4>
	
		<div class="inst_block">
  
		 
		<p  class="inst_text"> Please select Transaction Type, Transaction Verifier , Start date and End date to download the records.</p>
		 
		
		</div>
		
		
 <form id="transactionHistoryForm" class="Esform" action="#"  method="post">
       <input type="text" id="keyword" name="keyword" placeholder="Keyword" autocomplete="off">
	   <input type="text" id="usersIds" name="usersIds" placeholder="User Id" autocomplete="off">
        <select id="TransactionTypes" name="TransactionTypes">
		    <option value="">Transaction Type</option>
            <option value="Purchase">Purchase</option>
			<option value="Authorisation">Authorisation</option>
            <option value="Bonus">Bonus</option>
			<option value="Credit">Credit</option>
			<option value="Debit">Debit</option>
            <option value="Lift">Lift</option>
			<option value="Partial refund">Partial refund</option>
            <option value="Refund">Refund</option>
			<option value="Transfer">Transfer</option>
			<option value="Withdrawal">Withdrawal</option>
            <option value="Withdrawal credit">Withdrawal credit</option>
			 
			 
        </select>
		<select id="TransactionVerifiers" name="TransactionVerifiers">
		    <option value="">Transaction Verifier</option>
		    <option value="System">System</option>
            <option value="firstdata">First data</option>
            <option value="Innoviti">Innoviti</option>
			<option value="paytm">paytm</option>
			<option value="sarvatra">sarvatra</option>
			<option value="Mobiversa">Mobiversa</option>
			<option value="Pinelabs">Pinelabs</option>
            <option value="Storebox">Storebox</option>
			<option value="Teller">Teller</option>
            <option value="Verrency">Verrency</option>
			<option value="Visa VDP / VOP">Visa VDP / VOP</option>
			<option value="Zaakpay">Zaakpay</option>
             
			 
        </select>
        <input type="date" id="startdate" name="startdate" placeholder="Search" autocomplete="off">
		<input type="date" id="enddate" name="enddate" placeholder="Search" autocomplete="off">
          
        <input type="submit" value="Submit"> 
    </form>
	<div class="container" style="background:#F6F9FF;">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center m-4">
			<div id="es_info">
                <h2 class="no-heading">No records found</h2>
                
				 
            </div>
			<button class="btn btn-primary" type="button" id="downloadCSVButton" style="display: none" >Click here to download</button>
            </div>
        </div>
    </div>
</div>	  
</div>
</div>