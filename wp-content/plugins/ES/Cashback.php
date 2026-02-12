<div class="my-plugin-page p-4">
     
        <h4 class="main-heading mb-4">Cashback</h4>
	
		<div class="inst_block">
  
		 
		<p  class="inst_text">Please enter complete User Id.</p>
		 
		
		</div>
		
		
	<form id="CashbackForm" class="Esform" action="process.php" method="post">

	<input type="text" id="Cashback" name="Cashback" placeholder="User Id" autocomplete="off" >

	<input type="submit" value="Submit">
	</form>
	<span id="CashbackFormvalidationMessage"></span>	
	<div id="Cashbackinfo" class="table-responsive mt-2">
 
</div>	

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
       
      <div class="modal-body text-center">
        
        <h4 class="main-heading mb-4">Amount added successfully</h4>
		<div id="es_balance">
                <h2 class="no-heading"></h2>
                
				 
        </div>
       <button class="btn btn-primary" type="button" id="Okay" >   Okay    </button>
      </div>
       
    </div>

  </div>
</div>
</div>