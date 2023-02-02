<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_subcategory" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Department Name</th>
						<th>Designation detail</th>
						<th>Desk detail</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$users = $conn->query("SELECT id,title as name FROM category");
					$assignees = array();
					while($urow = $users->fetch_assoc()){
						$assignees[$urow['id']] = ucwords($urow['name']);
					}
					$qry = $conn->query("SELECT * FROM subcategory order by title asc  ");
					while($row= $qry->fetch_assoc()):
						$assignee = isset($assignees[$row['category_id']]) ? $assignees[$row['category_id']] : "N/A";
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $assignee ?></b></td>
						<td><b><?php echo ucwords($row['title']) ?></b></td>
						
						<td><b><?php echo ucwords($row['desk_detail']) ?></b></td>	
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_subcategory">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_subcategory" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.new_subcategory').click(function(){
			uni_modal("New subcategory","./subcategory/manage.php")
		})
		$('.manage_subcategory').click(function(){
			uni_modal("Manage subcategory","./subcategory/manage.php?id="+$(this).attr('data-id'))
		})
		
		$('.delete_subcategory').click(function(){
		_conf("Are you sure to delete this subcategory?","delete_subcategory",[$(this).attr('data-id')])
		})
		$('#list').dataTable()
	})
	function delete_subcategory($id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_subcategory',
			method:'POST',
			data:{id:$id},
			dataType:"json",
			error:err=>{
				alert_toast("An error occured");
				end_loader()
			},
			success:function(resp){
				if(resp.status=="success"){
					location.reload()
				}else{
					alert_toast("Deleting Data Failed");
				}
				end_loader()
			}
		})
	}
</script>