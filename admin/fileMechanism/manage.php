<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM filemechanism where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>
<form action="" id="filedata-frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
<div class="form-group">
		<label for="title" class="control-label">Name</label>
		<input type="text" class="form-control form-control-sm" name="title" id="title" value="<?php echo isset($title) ? $title : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="createdDate" class="control-label">Created Date</label>
		<input type="text" class="form-control form-control-sm" name="createdDate" id="createdDate" value="<?php echo date("Y-m-d") ?>" required>
	</div>
	
	<div class="form-group">
		<label for="description" class="control-label">Description</label>
		<textarea type="text" class="form-control form-control-sm" name="description" id="description" required ><?php echo isset($description) ? $description : '' ?></textarea>
	</div>
	
	
	<div class="form-group">
		<label for="user_id">Select User list</label>
		<select name="user_id" id="user_id" class="custom-select select2" multiple="multiple">
			<?php
				$event= $conn->query("SELECT * FROM users where type='2'");
				while($row=$event->fetch_assoc()):
					if(empty($user_id))
					$user_id = $row['id'];
			?>
			<option value="<?php echo $row['id'] ?>" <?php echo $user_id == $row['id'] ? 'selected' : '' ?>><?php echo(ucwords($row['firstname'])) ?></option>
		<?php endwhile; ?>
		</select>
	</div>

	<div class="form-group">
		<label for="file_id">Select File list</label>
		<select name="file_id" id="file_id" class="custom-select select2">
			<?php
				$filed= $conn->query("SELECT * FROM filetype order by title asc ");
				while($rowk=$filed->fetch_assoc()):
					if(empty($file_id))
					$file_id = $rowk['id'];
			?>
			<option value="<?php echo $rowk['id'] ?>" <?php echo $file_id == $rowk['id'] ? 'selected' : '' ?>><?php echo(ucwords($rowk['title'])) ?></option>
		<?php endwhile; ?>
		</select>
	</div>

	<!-- <div class="form-group" style="display:none">
		<label for="limit_time" class="control-label">Limit Registration Time (In Minutes)</label>
		<input type="number" min="0" class="form-control form-control-sm" name="limit_time" id="limit_time" value="0">
	</div> -->
</form>

<script>

   
	
	$(document).ready(function(){
		
	    $('.select2').select2();
		// $('#limit_registration').on('change input',function(){
		// 	if($(this).is(":checked") == true){
		// 		$('#limit_time').parent().show('slow')
		// 		$('#limit_time').attr("required",true);
		// 	}else{
		// 		$('#limit_time').parent().hide('slow')
		// 		$('#limit_time').attr("required",false);
		// 	}
		// })
		$('#filedata-frm').submit(function(e){
			//alert(JSON.stringify(e));
			 e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_filemechanism',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
			    dataType: 'json',
				// error:err=>{
				// 	//alert(JSON.stringify(err));
				// 	//console.log(err)
				// 	// alert_toast("an error occured","error")
				// 	// end_loader()
				// 	location.reload();
				// },
				success:function(resp){
				//alert("resp.status");
				if(resp.status == 'success'){
					//console.log(resp);
					//end_loader()
					location.reload();
				}else if(resp.status == 'duplicate'){
					var _frm = $('#filedata-frm #msg')
					var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> File already alloted for this user </div>"
					_frm.prepend(_msg)
					_frm.find('input#title').addClass('is-invalid')
					$('[name="title"]').focus()
				}else{
					console.log(resp);
					alert_toast("An error occured.",'error');
				}
					end_loader()
				}
			})
		})
	})
</script>