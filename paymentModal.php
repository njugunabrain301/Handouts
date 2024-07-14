<div class="modal">
    <div class="modal_content">
        <div style = "height: 10%; background-color: #a7c779; padding: 0px 10px; text-align: center; font-size: 20pt;"><span style="margin-bottom: -5px;">Payment Procedure</span><span class="close_modal" style="float: right; right: 10px; cursor: pointer; font-size: 30pt; margin-top: -6px;">&times;</span></div>
        <div class="modal_body" style="display: block; min-height: 70%; width: 100%;"></div>
        <div class="modal_footer" style="background: #a7c779; height:20%;"><span id="proceed_to_pay">Proceed</span><span id="cancel_payment">Cancel</span></div>
    </div>
</div>

<script type="text/javascript">
    var close_modal = document.getElementsByClassName("close_modal")[0];
    
    var modal = document.getElementsByClassName("modal")[0];
    
    var download = document.getElementsByClassName('download');
    
    var cancel = document.getElementById('cancel_payment');
    
    function downloader(str){
        var my_id = str;
        modal.style.display = "block";
        alert("hey"+my_id);
    }
    for(var i = 0; i < download.length; i++){
        var my_id = download[i].id;
        /*download[i].onclick = function(e){
            var tag = e.target.id;
            alert(tag);
        };*/
    }
    
    close_modal.onclick = function(){
        modal.style.display = "none";
    }
    
    cancel.onclick = function(){
        modal.style.display = "none";
    }
</script>