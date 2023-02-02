<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM subcategory where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>
<form action="" id="subcategory-frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

	
	<div class="form-group">
		<label for="category_id" class="control-label">Select Department List</label>
		<select name="category_id" id="category_id" class="custom-select select2" required>
			<option></option>
			<?php 
				$qry = $conn->query("SELECT id, title FROM category");
				while($row = $qry->fetch_assoc()):
			?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($id) && $category_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['title']) ?></option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group">
		<label for="title" class="control-label">Designation Detail</label>
		<input type="text" class="form-control form-control-sm" name="title" id="title" value="<?php echo isset($title) ? $title : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="desk_detail" class="control-label">Desk Detail</label>
		<input type="text" class="form-control form-control-sm" name="desk_detail" id="desk_detail" value="<?php echo isset($desk_detail) ? $desk_detail : '' ?>" required>
	</div>
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
		$('#subcategory-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_subcategory',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
			    dataType: 'json',
				error:err=>{
					// console.log(err)
					// alert_toast("an error occured","error")
					// end_loader()
					location.reload();
				},
				success:function(resp){
				if(resp.status == 'success'){
					location.reload();
				}else if(esp.status == 'duplicate'){
					var _frm = $('#subcategory-frm #msg')
					var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Title already exists.</div>"
					_frm.prepend(_msg)
					_frm.find('input#title').addClass('is-invalid')
					$('[name="title"]').focus()
				}else{
					alert_toast("An error occured.",'error');
				}
					end_loader()
				}
			})
		})
	})
</script>