<?php
require_once('../config.php');
if(isset($_GET['e']) && !empty($_GET['e'])){
    $qry = $conn->query("SELECT * FROM filetype where id = '{$_GET['e']}'");
    //echo $query;
    foreach($qry->fetch_array() as $k => $v){
        if(!is_numeric($k)){
            $$k = $v;
        }
    }
    
    $user_iddd = $_SESSION['userdata']['id'];
    //echo $id; 
    //echo $user_iddd;
    $check = $conn->query("SELECT * FROM frwdlist where file_id = '{$id}'")->num_rows;
        if($check > 0){
        }else{
            echo "No User Found !! <style> input#btndataNew{display:none} </style>";
            
        }
}
?>
<form action="" id="forward-frm">
    <div id="msg" class="form-group"></div>
    <input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
    <input type="hidden" name='file_id' value="<?php echo $id ?>">
<div class="col-md-12">
    <div class="form-group">
      
     <?php
        $assignees = array();
        $assigneesName = array();
        $qry = $conn->query("SELECT * FROM filemechanism where file_id = '{$id}'");
        while($row= $qry->fetch_assoc()):
        $users = $conn->query("SELECT id,firstname as name FROM users");
        while($urow = $users->fetch_assoc()){
            $assignees[$urow['id']] = ucwords($urow['name']);
            $assigneesName[$urow['id']] = ucwords($urow['id']);

        }
            $assignee = isset($assignees[$row['user_id']]) ? $assignees[$row['user_id']] : "N/A";
            $assigneesName = isset($assigneesName[$row['user_id']]) ? $assigneesName[$row['user_id']] : "N/A";
        ?>

           <div class="checkbox">
            <input id="checkbox<?php echo $assigneesName ?>" type="checkbox" name="user_id" value="<?php echo $assigneesName ?>">
            <label for="checkbox">
                <?php echo $assignee ?>
            </label>
          </div>
    <?php endwhile; ?>
    <br>
    <input type="submit" id="btndataNew" class="btn btn-primary">

    </div>
   
</div>
</form>
<script>
   
    $(document).ready(function(){
        if($('#uni_modal .modal-header button.close').length <= 0)
        $('#uni_modal .modal-header').append('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
    })
</script>

<style>
    #uni_modal .modal-footer{
        display: none;
    }
    img#cimg{
        height: 150px;
        width: 150px;
        object-fit: contain;
    }
</style>
<script type="text/javascript">
    $('#forward-frm').submit(function(e){
            e.preventDefault()
            start_loader()
            if($('.err_msg').length > 0)
                $('.err_msg').remove()
            $.ajax({
                url:_base_url_+'classes/Master.php?f=save_frwdlist',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                success:function(resp){
                //alert("resp.status");
                if(resp.status == 'success'){
                    //console.log(resp);
                    //end_loader()
                    location.reload();
                }else if(resp.status == 'duplicate'){
                    var _frm = $('#forward-frm #msg')
                    var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> File already fowarded to this user </div>"
                    _frm.prepend(_msg)
                    _frm.find('input#file_id').addClass('is-invalid')
                    $('[name="file_id"]').focus()
                }else{
                    console.log(resp);
                    alert_toast("An error occured.",'error');
                }
                    end_loader()
                }


            })
        })
</script>