<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM category where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>
<form action="" id="category-frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
<div class="form-group">
		<label for="title" class="control-label">Department Name</label>
		<input type="text" class="form-control form-control-sm" name="title" id="title" value="<?php echo isset($title) ? $title : '' ?>" required>
	</div>
	
	<div class="form-group">
		<label for="description" class="control-label">District</label>
		<textarea type="text" class="form-control form-control-sm" name="description" id="description" required ><?php echo isset($description) ? $description : '' ?></textarea>
	</div>
	<div class="form-group">
		<label for="block" class="control-label">Block</label>
		<textarea type="text" class="form-control form-control-sm" name="block" id="block" required ><?php echo isset($block) ? $block : '' ?></textarea>
	</div>
	<div class="form-group">
		<label for="panchayat" class="control-label">Panchayat</label>
		<textarea type="text" class="form-control form-control-sm" name="panchayat" id="panchayat" required ><?php echo isset($panchayat) ? $panchayat : '' ?></textarea>
	</div>
	<div class="form-group">
		<label for="datetime_start" class="control-label">DateTime Start</label>
		<input type="datetime-local" class="form-control form-control-sm" name="datetime_start" id="datetime_start" value="<?php echo isset($datetime_start) ? date("Y-m-d\\TH:i",strtotime($datetime_start)) : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="datetime_end" class="control-label">DateTime End</label>
		<input type="datetime-local" class="form-control form-control-sm" name="datetime_end" id="datetime_end" value="<?php echo isset($datetime_end) ? date("Y-m-d\\TH:i",strtotime($datetime_end)) : '' ?>" required>
	</div>
	
	<div class="form-group">
		<div class="icheck-primary">
			<input type="checkbox" id="limit_registration" name="limit_registration" value="1">
			<label for="limit_registration">
				Limited Time Of Registration Only
			</label>
		</div>
	</div>
	<div class="form-group" style="display:none">
		<label for="limit_time" class="control-label">Limit Registration Time (In Minutes)</label>
		<input type="number" min="0" class="form-control form-control-sm" name="limit_time" id="limit_time" value="0">
	</div>
</form>
<script>
	
	$(document).ready(function(){
		// $('.select2').select2();
		$('#limit_registration').on('change input',function(){
			if($(this).is(":checked") == true){
				$('#limit_time').parent().show('slow')
				$('#limit_time').attr("required",true);
			}else{
				$('#limit_time').parent().hide('slow')
				$('#limit_time').attr("required",false);
			}
		})
		$('#category-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_category',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
			    dataType: 'json',
				error:err=>{
					// alert(JSON.stringify(err));
					// console.log(err)
					// alert_toast("an error occured","error")
					// end_loader()
					location.reload();
				},
				success:function(resp){
					//alert("resp.status");
				if(resp.status == 'success'){
					location.reload();
				}else if(esp.status == 'duplicate'){
					var _frm = $('#category-frm #msg')
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