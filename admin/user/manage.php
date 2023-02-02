<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM users where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>
<form action="" id="people-frm">
	<div class="row">
		<div class="col-md-6">
			<div id="msg" class="form-group"></div>
			<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			<div class="form-group">
				<label for="firstname" class="control-label">First Name</label>
				<input type="text" class="form-control form-control-sm" name="firstname" id="firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="lastname" class="control-label">Last Name</label>
				<input type="text" class="form-control form-control-sm" name="lastname" id="lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="dob" class="control-label">Date of birth</label>
				<input type="date" class="form-control form-control-sm" name="dob" id="dob" value="<?php echo isset($dob) ? $dob : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="gender" class="control-label">Choose Gender</label>
				 <select name="gender" id="gender" class="custom-select custom-select-sm">
                    <option value="Male" <?php echo (isset($gender) && $gender == "Male") ? "selected" : '' ?>>Male</option>
                    <option value="Female" <?php echo (isset($gender) && $gender == "Female") ? "selected" : '' ?>>Female</option>
                    <option value="Other" <?php echo (isset($gender) && $gender == "Other") ? "selected" : '' ?>>Other</option>
                </select>
			</div>
		     <div class="form-group">
				<label for="mobile" class="control-label">Mobile</label>
				<input type="text" class="form-control form-control-sm" name="mobile" id="mobile" value="<?php echo isset($mobile) ? $mobile : '' ?>" required>
			</div>
			<div class="form-group">
					<label for="name">Email</label>
					<input type="email" class="form-control form-control-sm" name="email" id="email"  value="<?php echo isset($email) ? $email: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="name">Department Id</label>
						<select name="department" id="department" class="custom-select select2" required>
							<option>Select Department</option>
							<?php 
								$qry = $conn->query("SELECT id, title FROM category");
								while($row = $qry->fetch_assoc()):
							?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($id) && $department == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['title']) ?></option>
							<?php endwhile; ?>
						</select>
				</div>
					
	
				<div class="form-group">
					<label for="name">Select Designation</label>
					<select name="subdepartment" id="subdepartment" class="custom-select select2" required>
							<option>Select Sub-Department</option>

							<?php 

							$users = $conn->query("SELECT id,title as name FROM category");
							$assignees = array();
							while($urow = $users->fetch_assoc()){
								$assignees[$urow['id']] = ucwords($urow['name']);
							}
							$qry = $conn->query("SELECT * FROM subcategory where category_id = 26 ");
							while($row= $qry->fetch_assoc()):
						     // $assignee = isset($assignees[$row['category_id']] ) ? $assignees[$row['category_id']] : "N/A";

							 //    $qry1 = $conn->query("SELECT id, title FROM category")->fetch_assoc();
							 //    //while($row1 = $qry1->fetch_assoc());
        //                         $qry = $conn->query("SELECT id, title FROM subcategory where category_id = " + $qry1['id']);
								// while($row = $qry->fetch_array()):
							 ?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($id) && $subdepartment == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['title']) ?></option>

						 <?php endwhile; ?>


						</select>

				</div>
		
		
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="address" class="control-label">Address</label>
				<textarea type="text" class="form-control form-control-sm" name="address" id="address" required ><?php echo isset($address) ? $address : '' ?></textarea>
		    </div>
			<div  class="form-group">
				 <label for="userRole" class="control-label">User Status</label>
                <select name="userRole" id="userRole" class="custom-select custom-select-sm">
                    <option value="On Role" <?php echo (isset($userRole) && $userRole == "On Role") ? "selected" : '' ?>>On Role</option>
                    <option value="On Leave" <?php echo (isset($userRole) && $userRole == "On Leave") ? "On Leave" : '' ?>>On Leave</option>
                </select>
			</div>
			<div class="form-group">
			 <label for="datetime_post" class="control-label">Date of Posting</label>
			 <input type="datetime-local" class="form-control form-control-sm" name="datetime_post" id="datetime_post" value="<?php echo isset($datetime_post) ? date("Y-m-d\\TH:i",strtotime($datetime_post)) : '' ?>" required>
		   </div>
			<div class="form-group">
				<label for="username" class="control-label">Username</label>
				<input type="text" class="form-control form-control-sm" name="username" id="username" value="<?php echo isset($username) ? $username : '' ?>" required>
			</div>
            <div class="form-group">
                <label for="type" class="control-label">User Type</label>
                <select name="type" id="type" class="custom-select custom-select-sm">
                    <option value="2" <?php echo (isset($type) && $type == 2) ? "selected" : '' ?>>User</option>
                    <option value="1" <?php echo (isset($type) && $type == 1) ? "selected" : '' ?>>Administrator</option>
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
			<div class="form-group">
				<div class="icheck-primary">
					<input type="checkbox" id="resetP" name="preset">
					<label for="resetP">
						Check to reset password
					</label>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
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
		$('.select2').select2();
		$('#city_id').change(function(){
			var id = $(this).val();
			console.log($('#zone_id').find("[data-city='"+id+"']").length)
			$('#zone_id').find("[data-city='"+id+"']").show()
		$('#zone_id').select2();
		})
		$('#people-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Users.php?f=save',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
				error:err=>{
					console.log(err)

				},
				success:function(resp){
				if(resp == 1){
					location.reload();
				}else if(resp == 3){
					var _frm = $('#people-frm #msg')
					var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Person already exists.</div>"
					_frm.prepend(_msg)
					_frm.find('input#username').addClass('is-invalid')
					$('[name="code"]').focus()
				}else{
					alert_toast("An error occured.",'error');
				}
					end_loader()
				}
			})
		})
	})
</script>