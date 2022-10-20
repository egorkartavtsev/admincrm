<div class="tab-pane">
<?php foreach($expiredOrders as $order){ ?>
        <div class="alert alert-<?php echo (int)$order['viewed']?'success':'danger';?>">
            <div class="col-sm-1 text-left"><b><?php echo $order['order_id'];?></b></div>
            <div class="col-sm-3 text-left"><b><?php echo $order['lastname'].'<br>'.$order['firstname'].' '.$order['patron'];?></b></div>
            <div class="col-sm-3 text-center"><b><?php echo $order['telephone'].'<br>'.$order['email'].'<br>'.$order['payment_city'];?></b></div>
            <div class="col-sm-3 text-right"><b><?php echo date("d.m.Y H:i:s", strtotime($order['date_added'])).'<br>'.$order['name'];?></b></div>
            <div class="col-sm-2 text-right"><a class="btn btn-info" href="index.php?route=report/orders_info&token=<?php echo $token;?>&order_id=<?php echo $order['order_id'];?>"><i class="fa fa-eye"></i></a></div>
            <div class="col-sm-2 text-right"><a class="btn btn-danger" btn_type="cancel_order" value="<?php echo $order['order_id'];?>"><i class="fa fa-trash-o"></i></a></div>
        </div>
    <?php }?>
</div>   
<script type="text/javascript">
$(document).on('click', '[btn_type=cancel_order]', function(){
    var orderId = $(this);
	$delete = confirm("Вы хотите отменить заказ?");
	if($delete)
	{
		ajax({
            url: 'index.php?route=report/orders_info/save_status',
            method: 'post',
            data: {
                stat: '9',
                order: orderId.attr('value')
            },            
			success:function(data){
                    alert(data);
                    alert('Заказ отменён.');					
            }
        })
	}
    });
</script>

