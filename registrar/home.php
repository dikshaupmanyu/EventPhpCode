<div class="h-100  pt-2">
	<!-- <form action="" class="h-100">
		<div class="w-100 d-flex justify-content-center">
			<div class="input-group col-md-5">
				<input type="text" class='form-control' name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>" placeholder="Search Event">
				<div class="input-group-append">
				<button type="submit" class="btn btn-light border">
					<i class="fas fa-search text-muted"></i>
				</button>
				</div>
			</div>
		</div>
	</form>
	<hr> -->
	<!-- <div class="col-md-12">
		<div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 row-cols-xs-1">
			<?php
			$where = "";
			if($_settings->userdata('type') != 1)
			$where = " where user_id = '{$_settings->userdata('id')}' ";
			if(isset($_GET['search'])){
				if(empty($where))
					$where = " where ";
				else
					$where .= " and ";
				$where .= " title LIKE '%".$_GET['search']."%' or description LIKE '%".$_GET['search']."%' ";
			}
			$qry = $conn->query("SELECT * FROM event_list {$where}");
			while($row = $qry->fetch_assoc()):
			?>
			<a href="./?page=registration&e=<?php echo md5($row['id']) ?>" class="col m-2">
				<div class="callout callout-info m-2 col event_item text-dark">
					<dl>
						<dt><b><?php echo $row['title'] ?></b></dt>
						<dd><?php echo $row['description'] ?></dd>
					<dl>
					<div class="w-100 d-flex justify-content-end">
					<?php 
					if(strtotime($row['datetime_start']) > time()): ?>
						<span class="badge badge-light">Pending</span>
					<?php elseif(strtotime($row['datetime_end']) <= time()): ?>
						<span class="badge badge-success">Done</span>
					<?php elseif((strtotime($row['datetime_start']) < time()) && (strtotime($row['datetime_end']) > time())): ?>
						<span class="badge badge-primary">On-Going</span>
					<?php endif; ?>
					</div>
				</div>
			</a>
			<?php endwhile; ?>
		</div>
	</div> -->
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
					    <th>View</th>
					    <th>File View</th>
					    <th>File Forward</th>
					    <th>File Detail</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$where = "";
					if($_settings->userdata('type') != 1)
					$where = " where user_id = '{$_settings->userdata('id')}' ";
					if(isset($_GET['search'])){
						if(empty($where))
							$where = " where ";
						else
							$where .= " and ";
						$where .= " title LIKE '%".$_GET['search']."%' or description LIKE '%".$_GET['search']."%' ";
					}
					$qry = $conn->query("SELECT * FROM filetype {$where}");
					while($row = $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['title']) ?></b></td>
						<td><b><?php echo $row['description'] ?></b></td>
						<td><b><?php echo ucwords($row['timeline']) ?></b></td>
						<td><b><?php echo $row['file_status'] ?></b></td>
						<td><a href ="<?php echo base_url ?><?php echo $row['avatar'] ?>" target="_blank" attributes-list> View </a></td>	
						<td>Scan <span><a href="javascript:void(0)" class="view_filetype" data-id="<?php echo $row['id'] ?>"><span class="fa fa-qrcode"></span></a></span></td>	
						<td>Forward <span><a href="javascript:void(0)" class="view_forwardData" data-id="<?php echo $row['id'] ?>"><span class="fa fa-forward"></span></a></span></td>	
						<td><a href="./?page=registration&e=<?php echo md5($row['id']) ?>">View</a></td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
</div>
   <script>
	$(document).ready(function(){
		$('.view_filetype').click(function(){
            uni_modal("QR","./viewQr.php?e="+$(this).attr('data-id'))
        });
         $('.view_forwardData').click(function(){
            uni_modal("Forward UserList","./view_forwardDatafile.php?e="+$(this).attr('data-id'))
        })
		$('#list').dataTable()
		});
	</script>