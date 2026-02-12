<div class="my-plugin-page p-4">
     
    <h4 class="main-heading mb-4">Home</h4>
			<!--<div class="inst_block">
			  
			<p id="ajax-response" class="inst_text"></p>
			</div>-->
										
										
		<div class="my-plugin mt-2">

		<ul>
		<?php
		$main_menu_slug = 'Home'; // Replace with your main menu slug
		global $submenu;

		if (isset($submenu[$main_menu_slug])) {
		foreach ($submenu[$main_menu_slug] as $submenu_item) {
		$submenu_title = $submenu_item[0];
		$submenu_slug = $submenu_item[2];
		$submenu_url = admin_url('admin.php?page=' . $submenu_slug);
		echo "<li><a class='list' href='$submenu_url'>$submenu_title</a></li>";
		}
		}
		?>
		</ul>
		<!-- Your Page content goes here -->
		</div>

</div>

 