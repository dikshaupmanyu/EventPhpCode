<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_filetype" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
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
						<th>File Name</th>
						<th>Description</th>
						<th>Timeline</th>
						<th>File Status</th>
						<th>File View</th>
						<th>View Scanner</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM filetype order by title asc  ");
					while($row= $qry->fetch_assoc()):
						//$assignee = isset($assignees[$row['user_id']]) ? $assignees[$row['user_id']] : "N/A";
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['title']) ?></b></td>
						<td><b><?php echo $row['description'] ?></b></td>
						<td><b><?php echo $row['timeline'] ?></b></td>	
						<td><b><?php echo $row['file_status'] ?></b></td>
						<td><a href ="<?php echo base_url ?><?php echo $row['avatar'] ?>" target="_blank" attributes-list> View </a></td>	
						<td>Scan <span><a href="javascript:void(0)" class="view_filetype" data-id="<?php echo $row['id'] ?>"><span class="fa fa-qrcode"></span></a></span></td>	
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_filetype">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_filetype" data-id="<?php echo $row['id'] ?>">
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
		$('.new_filetype').click(function(){
			uni_modal("New Filetype","./filetype/manage.php")
		})
		$('.manage_filetype').click(function(){
			uni_modal("Manage Filetype","./filetype/manage.php?id="+$(this).attr('data-id'))
		})

		$('.view_filetype').click(function(){
			uni_modal("QR","./filetype/view.php?id="+$(this).attr('data-id'))
		})
		
		$('.delete_filetype').click(function(){
		_conf("Are you sure to delete this Category?","delete_filetype",[$(this).attr('data-id')])
		})
		$('#list').dataTable()
	})
	function delete_filetype($id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_filetype',
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