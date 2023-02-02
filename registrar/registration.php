<?php
if(isset($_GET['e']) && !empty($_GET['e'])){
	$qry = $conn->query("SELECT * FROM filetype where md5(id) = '{$_GET['e']}'");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>
<style>
    .atooltip,.atooltip:focus {
        background:unset;
        border:unset;
        padding:unset;
    }
</style>
<br>
<div class="card card-outline card-primary">
<div class="w-100 d-flex justify-content-center mt-3">
   <!--  <a class="btn btn-primary btn-rounded" id="startLive" href="./?page=attendance&e=<?php echo $_GET['e'] ?>">Scan QR</a> -->
 <span class="btn btn-primary btn-rounded">Scan QR <a href="javascript:void(0)" class="view_filetype" data-id="<?php echo $_GET['e'] ?>"><span class="fa fa-qrcode" style="color: white;"></span></a></span>
  <br>&nbsp; <br>
  <span class="btn btn-primary btn-rounded">Forward <a href="javascript:void(0)" class="view_forward" data-id="<?php echo $_GET['e'] ?>"><span class="fa fa-forward" style="color: white;"></span></a></span>

</div>
    <div class="col-md-12 p-2">
        <div class="callout">
            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt>File Name</dt>
                        <dd><?php echo $title ?></dd>
                    </dl>
                    <dl>
                        <dt>File Timeline</dt>
                        <dd><?php echo $timeline ?></dd>
                    </dl>
                    <dl>
                        <dt>File Description</dt>
                        <dd><?php echo $description ?></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl>
                        <dt>File Created Date</dt>
                        <dd><?php echo date("M d, Y h:i A",strtotime($createdDate)) ?></dd>
                    </dl>
                    <dl>
                        <dt>File Status</dt>
                        <dd><?php echo $file_status ?></dd>
                    </dl>
                   <!--  <?php 
                    if($limit_registration == 1):
                    ?>
                    <dl>
                        <dt>Registration Cut-off Time</dt>
                        <dd><?php echo date("M d, Y h:i A",strtotime($datetime_end.' + '.$limit_time.' minutes')) ?></dd>
                    </dl>
                    <?php endif; ?> -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.view_filetype').click(function(){
            uni_modal("QR","./view.php?e="+$(this).attr('data-id'))
        })
     $('.view_forward').click(function(){
            uni_modal("Forward UserList","./view_frwrd.php?e="+$(this).attr('data-id'))
        })
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    var Int_func;
   $(document).ready(function(){
        load_list()
        $('[name=search]').on('input',function(){
            var _filter = $(this).val().toLowerCase()

            if($('#present .a-item').length > 0){
                $('#present .a-item').each(function(){
                    var _txt = $(this).text().toLowerCase()
                    console.log(_txt.includes(_filter),$(this))
                   if(_txt.includes(_filter) == true){
                        $(this).toggle(true)
                   }else{
                        $(this).toggle(false)

                   }
                })
            }
        })
    })
    function load_list(){
       
        Int_func = setInterval(() => {
            var last_id = 0;
            if($('#present .a-item').length > 0){
                last_id = $('#present .a-item').last().attr('data-id')
            }
            $.ajax({
                url:_base_url_+"classes/Master.php?f=load_registration",
                method:'POST',
                data:{last_id : last_id,event_id : '<?php echo $id ?>'},
                dataType:"json",
                error:function(err){
                    alert_toast("An error occured","error");
                    clearInterval(Int_func);
                },
                success:function(resp){
                    $('#loadData').remove();
                    if(resp.length > 0){
                        Object.keys(resp).map(k=>{
                           var _clone = $('#clone-item').clone()
                           _clone.find('.aname').text(resp[k].name)
                           _clone.find('.aremarks').text(resp[k].remarks)
                           _clone.find('.adate').text(resp[k].rdate)
                           _clone.find('.atooltip').attr('title','<b>Contact #:</b> '+resp[k].contact+' <br> <b>Email:</b> '+resp[k].email)
                           _clone.find('.a-item').attr('data-id',resp[k].rid)
                           $('#present').append(_clone.html())
                        })
                    }
                },
                complete:()=>{
                    $('[data-toggle="tooltip"]').tooltip()

                    if($('#present .a-item').length > 0){
                        $('#noData').hide();
                    }else{
                        $('#noData').show();
                    }
                }
            })
        },1500)
    }
   
</script>