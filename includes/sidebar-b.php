<div id="aside">
	<div class="box">
        <h2>Thành viên mới</h2>
        <?php $users = fetch_new_users('registration_date');
          foreach ($users as $user) {
            echo "<li>{$user['first_name']} {$user['last_name']}</li>";
            } // End foreach  

         ?>
    </div>
      	
</div> <!--end aside-->