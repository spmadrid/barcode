<script>
$(function(){
		$('#status').change(function(){
			$('#addsubs').hide();
			$('#viewlist').hide();
		});
		$('#bank').change(function(){
			$('#addsubs').hide();
			$('#viewlist').hide();
		});
	
	$('#addsubs').fancybox();
	$('#hiddenlink').fancybox();
	$('.deletesub').live('click',function(){
			var selfs = $(this);
			var id = $(this).attr('id');
			var conf = confirm("Are you sure you want to delete this?");
			if(conf)
			{
					$.ajax({
						url:'deletesub',
						type:"POST",
						data:{id:id},
						dataType:"json",
						success: function(data)
						{
							if(data.status)
							{
								selfs.parent().parent().hide('slow');	
							}
						}
					});
			}else
			{
				return false;
			}
	});
	
	$('.editsub').live('click',function(){
			var id = $(this).attr('id');
			$('#hiddenlink').attr('href','editsub/'+id);
			$('#hiddenlink').trigger('click');
	});
	$('#update').submit(function(e){
	e.preventDefault();
		var stat = $('#status').val();
		var bank = $('#bank').val();
		if(stat == 0 || bank == 0)
		{
			alert("Please select status and bank.");
			return false;
		}else
		{
			$.ajax({
				url:'checksub',
				type:'post',
				data:{bank_id:bank,status_id:stat},
				dataType:'json',
				success:function(data){
					if(data.status)
					{
							$('#addsubs').show('slow');
							$('#viewlist').empty();
							$('#viewlist').append('<tr><th>Sub Status</th><th>Meaning</th><th></th></tr>');
							$.each(data.list,function(index,value){
								$.each(value,function(in2, val2){
									$('#viewlist').append("<tr><td>"+in2+"</td><td>"+val2+"</td><td><a href='javascript:void();' id='"+index+"' class='deletesub'><img src='../../image/delete-icon.png'></a>&nbsp;<a href='javascript:void(0)' id='"+index+"' class='editsub'><img src='../../image/edit-icon.png'></a></td></tr>");
								});
							});
							$('#viewlist').show('slow');
							
					}else
					{
						$('#viewlist').hide('slow');
						$('#addsubs').hide('slow');
						$('#viewlist').empty();
						$('#viewlist').append('<tr><th>Sub Status</th><th>Meaning</th><th></th></tr>');
						$('#viewlist').show('slow');
						$('#addsubs').show('slow');
						
					}
				}
			});
		}
			
		return false;
	});
});
</script>

<script>
$(function(){
	$('#ytr').live('submit',function(e){
		e.preventDefault();
		var  error = 0;
			$('.fields').each(function(index, element) {
                if($(this).val() == ''){
				 	error = 1;
				}
            });
			
			if(error == 0)
			{
				$.ajax({
					url:'savesub',
					type:'post',
					data:{substat:$('#sub').val(),text:$('#text').val(),bank_id:$('#bank').val(),status_id:$('#status').val()},
					dataType:"json",
					beforeSend: function(){
					
					},
					success:function(data){
							if(data.status == true)
							{
									var stat = $('#status').val();
									var bank = $('#bank').val();	
									$.ajax({
											url:'checksub',
											type:'post',
											data:{bank_id:bank,status_id:stat},
											dataType:'json',
											success:function(data){
												if(data.status)
												{
														$('#addsubs').show('slow');
														$('#viewlist').empty();
														$('#viewlist').append('<tr><th>Sub Status</th><th>Meaning</th><th></th></tr>');
														$.each(data.list,function(index,value){
															$.each(value,function(in2, val2){
															$('#viewlist').append("<tr><td>"+in2+"</td><td>"+val2+"</td><td><a href='javascript:void();' id='"+index+"' class='deletesub'><img src='../../image/delete-icon.png'></a>&nbsp;<a href='javascript:void(0)' id='"+index+"' class='editsub'><img src='../../image/edit-icon.png'></a></td></tr>");
															});
														});
														$('#viewlist').show('slow');
														//alert('Successfully Saved');
														parent.$.fancybox.close();
														
												}else
												{
													$('#viewlist').show('slow');
													$('#addsubs').show('slow');
												}
											}
										});
									
									
								
							}else
							{
								alert('Problem Saving Data.....');
							}
					}
				});
			}else
			{
				alert('Complete the form');
			}
		
		return false;
	});
	
	$('#updatesub').live('submit',function(e){
		e.preventDefault();
		var  error = 0;
			$('.fields').each(function(index, element) {
                if($(this).val() == ''){
				 	error = 1;
				}
            });
			
			if(error == 0)
			{
				$.ajax({
					url:'upsub',
					type:'post',
					data:{substat:$('#sub').val(),text:$('#text').val(),id:$('#subid').val()},
					dataType:"json",
					beforeSend: function(){},
					success:function(data){
						if(data.status == true)
						{
									var stat = $('#status').val();
									var bank = $('#bank').val();	
									$.ajax({
											url:'checksub',
											type:'post',
											data:{bank_id:bank,status_id:stat},
											dataType:'json',
											success:function(data){
												if(data.status)
												{
														$('#addsubs').show('slow');
														$('#viewlist').empty();
														$('#viewlist').append('<tr><th>Sub Status</th><th>Meaning</th><th></th></tr>');
														$.each(data.list,function(index,value){
															$.each(value,function(in2, val2){
															$('#viewlist').append("<tr><td>"+in2+"</td><td>"+val2+"</td><td><a href='javascript:void();' id='"+index+"' class='deletesub'><img src='../../image/delete-icon.png'></a>&nbsp;<a href='javascript:void(0)' id='"+index+"' class='editsub'><img src='../../image/edit-icon.png'></a></td></tr>");
															});
														});
														$('#viewlist').show('slow');
														alert('Successfully Updated');
														parent.$.fancybox.close();
														
												}else
												{
													$('#viewlist').show('slow');
													$('#addsubs').show('slow');
												}
											}
										});
						}
					},
				});
			}else
			{
				alert('Complete the form');
				return false;
			}
		return false;	
	});
});
</script>
<form name="update" id="update" method="POST" action="">
<div class="rows">
	<label>Status</label>
	<?php echo form_dropdown('status',$status,'','id=status');?>
</div>

<div class="rows">
	<label>Bank</label>
	<?php echo form_dropdown('status',$bank,'','id=bank');?>
</div>

<div class="rows">
	<input type="submit" name="" value="View" id="statbtn">
</div>
</form>

<br />

<a href="addsub" id="addsubs" class="linkurl" style="display:none;">Add Sub Status</a>
<hr />
<div id="List">
	<table id="viewlist" class="tabledesign" cellpadding="5" style="display:none;">
		<tr>
			<th>Sub Status</th>
            <th>Meaning</th>
			<th></th>
		</tr>
	</table>
</div>

<a href="" id="hiddenlink" style="display:none;"></a>

        
        
        