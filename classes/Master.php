<?php
require_once('../config.php');
require_once('../libs/phpqrcode/qrlib.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_event(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$check = $this->conn->query("SELECT * FROM event_list where title = '{$title}' ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = "duplicate";
		}else{

			foreach($_POST as $k =>$v){
				if(!in_array($k,array('id'))){
					if(!empty($data)) $data .= ", ";
					$data .= " `{$k}` = '{$v}' ";
				}
			}
			if(empty($id)){
				$sql = "INSERT INTO event_list set $data";
				printf($sql);
			}else{
				$sql = "UPDATE event_list set $data where id = '{$id}'";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				$this->settings->set_flashdata("success", " Event Successfully Saved.");
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
		}


		return json_encode($resp);
	}
	function delete_event(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM event_list where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", " Event Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function save_category(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$check = $this->conn->query("SELECT * FROM category where title = '{$title}' ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = "duplicate";
		}else{
			foreach($_POST as $k =>$v){
				if(!in_array($k,array('id'))){
					if(!empty($data)) $data .= ", ";
					$data .= " `{$k}` = '{$v}' ";

				}
			}
			if(empty($id)){
				$sql = "INSERT INTO category set $data";
				printf($sql);
			}else{
				$sql = "UPDATE category set $data where id = '{$id}'";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				$this->settings->set_flashdata("success", " Category Successfully Saved.");
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
		}


		return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM category where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", " Category Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function save_filetype(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
	    
		$check = $this->conn->query("SELECT * FROM filetype where title = '{$title}' ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = "duplicate";
		}else{
			foreach($_POST as $k =>$v){
				if(!in_array($k,array('id'))){
					if(!empty($data)) $data .= ", ";
					$data .= " `{$k}` = '{$v}' ";

				}
			}
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				$fname = 'uploads/'.strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'../'. $fname);
				if($move){
					$data .=" , avatar = '{$fname}' ";
					if(isset($_SESSION['userdata']['avatar']) && is_file('../'.$_SESSION['userdata']['avatar']) && $this->settings->userdata('id') == $id)
						unlink('../'.$_SESSION['userdata']['avatar']);
					if(isset($avatar) && is_file('../'.$avatar))
						unlink('../'.$avatar);
			 }
		    }
			if(empty($id)){
				$sql = "INSERT INTO filetype set $data";
				printf($sql);
				
			}else{
				$sql = "UPDATE filetype set $data where id = '{$id}'";
			
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				$this->settings->set_flashdata("success", " Filetype Successfully Saved.");
				if(isset($move) && $move && $this->settings->userdata('id') == $id){
					$this->settings->set_userdata('avatar',$fname);
				}
				$code = empty($id) ? md5($this->conn->insert_id) : md5($id);
				$codeContents = 'name:'.$title.'<br>description='.urlencode($description).'<br>timeline='.urlencode($timeline).'<br>file_status='.urlencode($file_status); 
				if(!is_dir('../temp/')) mkdir('../temp/');
				$tempDir = '../temp/'; 
				if(!is_file('../temp/'.$code.'.png'));			
				QRcode::png($codeContents, $tempDir.''.$code.'.png', QR_ECLEVEL_L, 5);


			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
		}


		return json_encode($resp);
	}
	function delete_filetype(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM filetype where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", " Filetype Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function save_filemechanism(){
			$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$check = $this->conn->query("SELECT * FROM filemechanism where file_id = '{$file_id}' and user_id ='{$user_id}' ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = "duplicate";
		}else{
			foreach($_POST as $k =>$v){
				if(!in_array($k,array('id'))){
					if(!empty($data)) $data .= ", ";
					$data .= " `{$k}` = '{$v}' ";

				}
			}
			if(empty($id)){
				$sql = "INSERT INTO filemechanism set $data";
				//printf($sql);
			}else{
				$sql = "UPDATE filemechanism set $data where id = '{$id}'";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				$this->settings->set_flashdata("success", " filemechanism Successfully Saved.");
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
		}


		return json_encode($resp);
	}
	function delete_filemechanism(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM filemechanism where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", " fileMechanism Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function save_subcategory(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$check = $this->conn->query("SELECT * FROM subcategory where title = '{$title}' ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = "duplicate";
		}else{
			foreach($_POST as $k =>$v){
				if(!in_array($k,array('id'))){
					if(!empty($data)) $data .= ", ";
					$data .= " `{$k}` = '{$v}' ";

				}
			}
			if(empty($id)){
				$sql = "INSERT INTO subcategory set $data";
				printf($sql);
			}else{
				$sql = "UPDATE subcategory set $data where id = '{$id}'";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				$this->settings->set_flashdata("success", " subcategory Successfully Saved.");
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
		}


		return json_encode($resp);
	}
	function delete_subcategory(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM subcategory where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", " subcategory Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function save_audience(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);

		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO event_audience set $data";
		}else{
			$sql = "UPDATE event_audience set $data where id = '{$id}'";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			$code = empty($id) ? md5($this->conn->insert_id) : md5($id);
			$codeContents = 'name:'.$name.'&email='.urlencode($email).'&contact='.urlencode($contact); 
			if(!is_dir('../temp/')) mkdir('../temp/');
			$tempDir = '../temp/'; 
			if(!is_file('../temp/'.$code.'.png'));			
			QRcode::png($codeContents, $tempDir.''.$code.'.png', QR_ECLEVEL_L, 5);


			$this->settings->set_flashdata("success", " Event Guest Successfully Saved.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['sql'] = $sql;
		}

		
		return json_encode($resp);
	}
	function delete_audience(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM event_audience where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", " Event Guest Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function load_registration(){
		extract($_POST);
		$qry = $this->conn->query("SELECT a.*,r.id as rid,r.date_created as rdate FROM registration_history r inner join event_audience a on a.id =r.audience_id where r.event_id = '{$event_id}' and r.id > '{$last_id}' order by r.id asc ");
		$data=array();
		while($row=$qry->fetch_assoc()){
			$row['rdate'] = date("M d, Y h:i A",strtotime($row['rdate']));
			$data[]=$row;
		}
		return json_encode($data);
	}
	function register(){
		extract($_POST);
		$query = $this->conn->query("SELECT * FROM event_audience where md5(id) = '{$audience_id}' and md5(event_id)='{$event_id}' ");
		if($query->num_rows > 0){
			$res = $query->fetch_assoc();
			$check = $this->conn->query("SELECT * from registration_history where event_id = '{$res['event_id']}' and  audience_id = '{$res['id']}' ");
			if($check->num_rows > 0){
				$resp['status']=3;
				$resp['name']=$res['name'];
			}else{

				$insert = $this->conn->query("INSERT INTO registration_history set event_id = '{$res['event_id']}',  audience_id = '{$res['id']}',`user_id` = '{$this->settings->userdata('id')}'  ");
				if($insert){
					$resp['status']=1;
					$resp['name']=$res['name'];
				}else{
					$resp['status']=2;
					$resp['error']=$this->conn->error;
				}
			}

		}else{
			$resp['status']=2;
		}
		return json_encode($resp);
	}

	function save_frwdlist(){	
        $data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$check = $this->conn->query("SELECT * FROM frwdlist where file_id = '{$file_id}' and user_id ='{$user_id}'  ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = "duplicate";
		}else{
			foreach($_POST as $k =>$v){
				if(!in_array($k,array('id'))){
					if(!empty($data)) $data .= ", ";
					$data .= " `{$k}` = '{$v}' ";

				}
			}
			if(empty($id)){
				$sql = "INSERT INTO frwdlist set $data";
				//printf($sql);
			}else{
				$sql = "UPDATE frwdlist set $data where id = '{$id}'";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				$this->settings->set_flashdata("success", " frwdlist Successfully Saved.");
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
		}


		return json_encode($resp);

	}

	function delete_frwdlist(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM frwdlist where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", " Forward Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function filterFile(){
	    extract($_POST);
	   // echo $startDate;
	    //echo $endDate;
		$filetered = $this->conn->query("SELECT * FROM filetype WHERE createdDate BETWEEN '{$startDate}' AND '{$endDate}'");
		//$filetered = $this->conn->query("SELECT * FROM filetype WHERE createdDate BETWEEN '2023-01-02' AND '2023-01-22'");
		$data=array();
		while($row=$filetered->fetch_assoc()){
			$data[]=$row;
		}
		return json_encode($data);

	}
}

 

$main = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save_event':
		echo $main->save_event();
	break;
	case 'delete_event':
		echo $main->delete_event();
	break;
	case 'save_audience':
		echo $main->save_audience();
	break;
	case 'delete_audience':
		echo $main->delete_audience();
	break;
	case 'load_registration':
		echo $main->load_registration();
	break;
	case 'register':
		echo $main->register();
	break;
	case 'save_category':
		echo $main->save_category();
	break;
	case 'delete_category':
		echo $main->delete_category();
	break;
	case 'save_filetype':
		echo $main->save_filetype();
	break;
	case 'delete_filetype':
		echo $main->delete_filetype();
	break;
	case 'save_filemechanism':
		echo $main->save_filemechanism();
	break;
	case 'delete_filemechanism':
		echo $main->delete_filemechanism();
	break;
	case 'save_subcategory':
		echo $main->save_subcategory();
	break;
	case 'delete_subcategory':
		echo $main->delete_subcategory();
	break;
    case 'save_frwdlist':
		echo $main->save_frwdlist();
	break;
	case 'delete_frwdlist':
		echo $main->delete_frwdlist();
	break;
	case 'filter':
	    echo $main->filterFile();
		# code...
		break;
	default:
		// echo $sysset->index();
		break;
}