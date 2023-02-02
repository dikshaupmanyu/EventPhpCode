<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM filetype where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>
<form action="" id="filetype-frm">
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

	<!-- <div class="form-group">
		<label for="endDate" class="control-label">End Date</label>
		<input type="text" class="form-control form-control-sm" name="endDate" id="endDate" value="<?php
          echo date('Y-m-d', strtotime($createdDate. ' + 20 days'));?>" required>
	</div> -->
	
	
	<div class="form-group">
		<label for="description" class="control-label">Description</label>
		<textarea type="text" class="form-control form-control-sm" name="description" id="description" required ><?php echo isset($description) ? $description : '' ?></textarea>
	</div>
	
	<div class="form-group">
		<label for="panchayat" class="control-label">TimeLine(in days)</label>
		<textarea type="text" class="form-control form-control-sm" name="timeline" id="timeline" required ><?php echo isset($timeline) ? $timeline : '' ?></textarea>
	</div>

	<div class="form-group">
		<label for="file_status" class="control-label">Select File Status</label>
		<select name="file_status" id="file_status" class="custom-select select2" required>
			<option value="Pending" <?php echo (isset($file_status) && $file_status == "Pending") ? "selected" : '' ?>>Pending</option>
			<option value="Success" <?php echo (isset($file_status) && $file_status == "Success") ? "selected" : '' ?>>Success</option>
			<option value="On Progress" <?php echo (isset($file_status) && $file_status == "On Progress") ? "selected" : '' ?>>On Progress</option>
			<option value="Error" <?php echo (isset($file_status) && $file_status == "Error") ? "selected" : '' ?>>Error</option>
		</select>
	</div>

	<div class="form-group">
		<label for="user_id">Select User list</label>
		<select name="user_id" id="user_id" class="custom-select select2">
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
				<label for="" class="control-label">Photo</label>
				<div class="custom-file">
		          <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		          <label class="custom-file-label" for="customFile">Choose file</label>
		        </div>
			</div>
			<div class="form-group d-flex justify-content-center">
				<img src="<?php echo validate_image(isset($avatar) ? $avatar : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
			</div>
			<?php if(isset($id) && ($id > 0)): ?>
            <input type="hidden"  name="avatar" value="<?php echo $avatar ?>">
			<!-- <div class="form-group">
				<div class="icheck-primary">
					<input type="checkbox" id="resetP" name="preset">
					<label for="resetP">
						Check to reset password
					</label>
				</div>
			</div> -->
			<?php endif; ?>


	<!-- <div class="form-group" style="display:none">
		<label for="limit_time" class="control-label">Limit Registration Time (In Minutes)</label>
		<input type="number" min="0" class="form-control form-control-sm" name="limit_time" id="limit_time" value="0">
	</div> -->
</form>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>

    function displayImg(input,_this) {
	      if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	   }
	
	$(document).ready(function(){
		
		// $('.select2').select2();
		// $('#limit_registration').on('change input',function(){
		// 	if($(this).is(":checked") == true){
		// 		$('#limit_time').parent().show('slow')
		// 		$('#limit_time').attr("required",true);
		// 	}else{
		// 		$('#limit_time').parent().hide('slow')
		// 		$('#limit_time').attr("required",false);
		// 	}
		// })
		$('#filetype-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_filetype',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
			    dataType: 'json',
				// error:err=>{
				// 	// alert(JSON.stringify(err));
				// 	console.log(err)
				// 	// alert_toast("an error occured","error")
				// 	// end_loader()
				// 	//location.reload();
				// },
				success:function(resp){
					//alert("resp.status");
				if(resp.status == 'success'){
					//console.log(resp);
					location.reload();
				}else if(resp.status == 'duplicate'){
					var _frm = $('#filetype-frm #msg')
					var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Title already exists.</div>"
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