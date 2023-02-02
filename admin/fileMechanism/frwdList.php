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
<style type="text/css">
	button#submit{
		display: none;
	}
</style>
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
						<th>User Name</th>
					
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$assignees = array();
					$assigneesName = array();
					$i = 1;
					$qry1 = $conn->query("SELECT * FROM frwdlist order by id asc  ");
					while($row1= $qry1->fetch_assoc()):
					$users = $conn->query("SELECT id,firstname as name FROM users");
			        while($urow = $users->fetch_assoc()){
			            $assignees[$urow['id']] = ucwords($urow['name']);

			        }
			        $fileMech = $conn->query("SELECT id,title as name FROM filetype");
			        while($urowfileMech = $fileMech->fetch_assoc()){
			            $assigneesName[$urowfileMech['id']] = ucwords($urowfileMech['name']);

			        }
			        $assignee = isset($assignees[$row1['user_id']]) ? $assignees[$row1['user_id']] : "N/A";

			        $assigneeName = isset($assigneesName[$row1['file_id']]) ? $assigneesName[$row1['file_id']] : "N/A";
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						
						<td><b><?php echo $assigneeName ?></b></td>
						<td><b><?php echo $assignee ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <!-- <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_fileMechanism">
		                          <i class="fas fa-edit"></i>
		                        </a> -->
		                        <button type="button" class="btn btn-danger btn-flat delete_frwdlist" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
<script>

   $(document).ready(function(){
		

		$('.delete_frwdlist').click(function(){
		_conf("Are you sure to delete this Category?","delete_frwdlist",[$(this).attr('data-id')])
		});

		$('#list').dataTable();

	})
	
		
	   function delete_frwdlist($id){
	   	//alert($id);
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_frwdlist',
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