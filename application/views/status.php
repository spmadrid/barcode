<script>
$(document).ready(function() {
	 var selectedID;

		function getTextContent(el) {
			if (typeof el.textContent == 'string')
				return el.textContent;
			if (typeof el.innerText == 'string')
				return el.innerText;

			// Fix below for older browsers not supporting W3C DOM 3 Core Specs (.innerText)
			return getText2(el);

			function getText2(el) {
				var x = el.childNodes;
				var txt = '';
				for (var i=0, len=x.length; i<len; ++i){
					if (3 == x[i].nodeType) {
						txt += x[i].data;
					} else if (1 == x[i].nodeType){
						txt += getText2(x[i]);
					}
				}
				return txt.replace(/\s+/g,' ');
			}
		}
		
		$("#todaystatus").flexigrid({
						url : 'statusflex',
						dataType:'json',
						colModel : [
						{display: '', name : '', width : 20, sortable : false, align: 'center' ,hide:true},
						{display: 'ID', name:'id',width:20,sortable:true,align:'center',hide:false},
						{display:'CHCode',name:'CHCode',width:'300',sortable:true,align: 'left'},
						{display:'CHName',name:'CHName',width:180,sortable:true,align: 'left'},
						{display:'AccNo',name:'AccNo',width:80,sortable:true,align: 'left'},
						{display:'Status',name:'Status',width:80,sortable:true,align: 'left'},
						{display:'Sub Status',name:'substat',width:80,sortable:true,align: 'left'},
						{display:'Amount',name:'Amount',width:80,sortable:true,align: 'left'},
						{display:'dDatePTP',name:'dDatePTP',width:80,sortable:true,align: 'left'},
						],
						buttons : [
										//{name: 'Select All', onpress : selectAll},
										//{name: 'Deselect All', onpress : deselectAll},
										//{name: 'Delete', onpress:deleteClicked},
										{separator: true},	
										//{name: 'Add', onpress : addData},	
										{separator: true},	
										//{name: 'Edit', onpress : editData},	
						],
						searchitems : [
						{display: 'CHCode', name : 'ChCode', isdefault: true},
					
						],
											sortname: "id",
											sortorder: "desc",
											usepager: true,
											title:  'Status list',
											useRp: true,
											rp: 15,
											showTableToggleBtn: true,
											width: 'auto',
											height: 120,
						});
		
	$('#check_slt').live('click',function(){
		var val = $(this).val();
		$.ajax({
			url:'checkstatus',
			type:"POST",
			data:{id:val},
			dataType:"json",
			success: function(data)
			{
				$('#amount').val(data.amt);
				$('#barcode').val(data.chcode);
				
				if(data.php != '0000-00-00'){
					$('#ptpdate').val(data.ptp);
				}
				
				$('.places').each(function(index, element) {
					var it = $(this);
                    	if(it.val() == data.place)
						{
							it.attr('checked','checked');
						}
                });
			}
		});		
	});	
});
</script>
<script>
$(function(){
	$('.substatusselect').live('click',function(){
			var id = $(this).attr('id');
			$('#preview').html(id);
	});
	$('#ptpdate').datepicker();
	$('#stat').keydown(function(e){
		var status = $('#status').val();
		var bank = $('#bank').val();
		var barcode = $('#barcode').val();
		var amount = $('#amount').val();
		var success = '<div class="success"><p>Successfully Saved.</p></div>';
		var error = '<div class="error"><p>Failed to save. Invalid Barcode</p></div>';
		var key = e.which;
		var radio_checked = $('.substatusselect:checked').val();
		var places = $('.places:checked').val();
		var ptp = $('#ptpdate').val();
		
		var check_radio = $('.select_checkbox:checked').length;
		var check_radio_val = $('.select_checkbox:checked').val();
		
		var radio = $('.substatusselect').length;
		if(key == 13)
		{
			
			
			$('#preview').html('');
			if(radio > 0)
			{
				if($('.substatusselect:checked').length == 0)
				{
					alert("Please select sub status");
					return false
				}
			}
			
			if(bank =='' || status == '' || barcode == '')
			{
				alert("Complete the form");
				return false;
			}else
			{
				
				if(check_radio ==0){
				$.ajax({
					url:'savestatus',	
					type:"POST",
					data:{barcode:barcode,status:status,bank:bank,amount:amount,radio_checked:radio_checked,places:places,ptpdate:ptp},
					dataType:"json",
					beforeSend: function(data){
						$.blockUI();
					},
					success:function(data){
						if(data.success)
						{
							$('.success').remove();
							$('.error').remove();
							/*if($('.current_status').parent().find('tr').length > 1)
							{
								$('.current_status').parent().find('tr').next().remove();
							}
							$('.current_status').parent().find('tr').after('<tr><td>'+data.chcode+'</td><td>'+data.chname+'</td><td>'+data.acctno+'</td><td>'+data.status+'</td><td>'+data.radio+'</td><td>'+data.amount+'</td><td>'+data.date+'</td></tr>');
							$('.current_status').show();*/

							$('.left_right').append(success);	
							
							$('#barcode').val('');
							$('#amount').val('');
							$('#barcode').focus();
							$.unblockUI();
							$('#todaystatus').flexReload();
						}else{
							
							$('#barcode').val('');
							$('#amount').val('');
							//$('.right').empty();
							$('.current_status').hide();
							$('.success').remove();
							$('.error').remove();
							$('.left_right').append(error);
							$.unblockUI();
							$('#barcode').focus();
							$('#todaystatus').flexReload();
						}
					},
				});
				}else
				{
					$.ajax({
							url:'updatestatus',	
							type:"POST",
							data:{lead_id:check_radio_val,barcode:barcode,status:status,bank:bank,amount:amount,radio_checked:radio_checked,places:places,ptpdate:ptp},
							dataType:"json",
							beforeSend: function(data){
								$.blockUI();
							},
							success:function(data){
								if(data.success)
								{
									$('.success').remove();
									$('.error').remove();
									$('.left_right').append(success);	
									$('#barcode').val('');
									$('#barcode').focus();
									$.unblockUI();
									$('#todaystatus').flexReload();
								}else
								{
									$('.success').remove();
									$('.error').remove();
									$('.left_right').append(error);	
									$('#barcode').val('');
									$('#barcode').focus();
									$.unblockUI();
									$('#todaystatus').flexReload();
								}
							}
					});
				}
				
			}
		}
	});	
	
	$('#bank').change(function(){
		var check_radio = $('.select_checkbox:checked').length;
		$('#preview').html('');
		$('#list_of_sub').empty();
			var val = $(this).val();
			var status = $('#status').val();
		if(status!='')
		{
			if(check_radio == 0){
				$('#todaystatus').flexOptions({url:'statusflex'});
				var  squery = 'jett||'+val+'||'+status;
				$('#todaystatus').flexOptions({query:squery});
				$('#todaystatus').flexReload();
			}
			
				$.ajax({
					url:'substatus',
					type:"POST",
					data:{bank:val,status:status},
					dataType:"json",
					success: function(data)
					{
						if(data.status)
						{
							$.each(data.subs,function(index,value){
									$('#list_of_sub').append('<li><input type="radio" name="substatuschoice" class="substatusselect" id="'+value+'" title="'+value+'" value="'+value+'"><b>'+index+'</b></li>');	
							});
							$('#list_of_sub').show();
						}else
						{
							$('#preview').html('');
							$('#list_of_sub').hide();
						}
					}
				});
		}
	});
	
	$('#status').change(function(){
		var check_radio = $('.select_checkbox:checked').length;
		$('#preview').html('');
		$('#list_of_sub').empty();
			var val = $(this).val();
			var bank = $('#bank').val();
			if(val == 'PTP')
			{
				$('#ptpdis').show();
			}else
			{
				$('#ptpdis').hide();
				$('#ptpdate').val('');
			}
		if(bank!='')
		{
			
			if(check_radio ==0){
					$('#todaystatus').flexOptions({url:'statusflex'});
					var  squery = 'jett||'+bank+'||'+val;
					$('#todaystatus').flexOptions({query:squery});
					$('#todaystatus').flexReload();
			}
			
				$.ajax({
					url:'substatus',
					type:"POST",
					data:{bank:bank,status:val},
					dataType:"json",
					success: function(data)
					{
						if(data.status)
						{
							$.each(data.subs,function(index,value){
									$('#list_of_sub').append('<li><input type="radio" name="substatuschoice" class="substatusselect" id="'+value+'" title="'+value+'" value="'+value+'"><b>'+index+'</b></li>');	
							});
							$('#list_of_sub').show();
						}else
						{
							$('#preview').html('');
							$('#list_of_sub').hide();
						}
					}
				});
		}
	});
});

</script>
<h1>Transaction Status</h1>
<div class="rows">
	<label>Banks</label>
        <?php 
		$bank  = explode(",",$this->session->userdata('bank'));
		$options = array();
		$options[''] = 'Select';
		foreach($bank as $bnk)
		{
			$options[''.$bnk.''] = $bnk;
		}		
				echo form_dropdown('agentleads', $options, '','class=fields id=bank');?>
</div>

<br / style="clear:both">

<div class="left_right">
	<div class="left" style="width:400px;margin-right: 12px;">
    	<div class="forms">
        	<form name="" id="stat">
            	<div class="row">
                	<label>Status</label>
                    <?php echo form_dropdown('status',$status_list,'','id=status');?>
                </div>
                <div class="row">
                	<label>Sub Status</label>
                    <ul id="list_of_sub" class="listbox"  style="display:none;">
                    	
                    </ul>
                    <span id="preview"></span>
                </div>
                
                <div class="row">
                	<label>Place</label>
                    <ul class="listbox">
                    	<li><input type="radio" name="place" id="place" value="Office" class="places" >Office</li>
                        <li><input type="radio" name="place" id="place" value="Home" class="places">Home</li>
                        <li><input type="radio" name="place" id="place" value="Mobile" class="places">Mobile</li>
                    </ul>
                </div>
              
                <div class="row">
                	<label>Barcode</label>
                    <input type="text" name="barcode" value="" id="barcode" placeholder="Barcode">
                </div>
                
                 <div class="row">
                	<label>Amount</label>
                    <input type="text" name="amount" value="" id="amount" placeholder="Amount">
                </div>
                
                 <div class="row" id="ptpdis" style="display:none;">
                    <input type="text" name="ptpdate" value="" id="ptpdate" placeholder="Date" readonly="readonly">
                </div>
            </form>
        </div>
    </div>
    <table id="todaystatus"></table> 
</div>