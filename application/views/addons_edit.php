<script>
$(function(){
	$('#myform').submit(function(){
		var error = 0;	
				$('.fields').each(function(index, element) {
            	if($(this).val() =='')
				{
					
					error  = 1;
				}
			  });	
				if(error ==0){
					var formData = new FormData($('form')[0]);
						$.ajax({
						url: 'update',  //server script to process data
						type: 'POST',
						dataType:"json",
						beforeSend: function(){
							
						},
						success: function(data){
								if(data.status)
								{
									
									$('#current').flexReload();
									$('#currents').flexReload();
									$('#branch').flexReload();
									$('#bank').flexReload();
									$.fancybox.close();
										
									
								}else
								{
									alert(data.error);
									$.fancybox.close();
								}								
						},
						data: formData,
						//Options to tell JQuery not to process data or worry about content-type
						cache: false,
						contentType: false,
						processData: false
						
						});
										
				}else
				{
					alert('All fields are required.');
					return false;
				}
		
		return false;
      
	});
});
</script>
<div id="addnew_user">
<h1><?php echo $header;?></h1>
 <?php 
	$attributes = array(
	'id'=>'myform',
	);
	echo form_open('add/save',$attributes);?>
     <div class="rows">
            	<label>Name</label>
                <input type="hidden" name="id" id="id" value="<?php echo $result->id;?>">
     <?php 
	 	switch($table)
		{
			case 'tblsupervisor':
			echo '<input type="text" name="name" id="name" class="fields" value="'.$result->supervisor_name.'"'; 
			break;
			case 'tbllead':
			echo '<input type="text" name="name" id="name" class="fields" value="'.$result->lead_name.'"'; 
			break;
			case 'tblbranch':
			echo '<input type="text" name="name" id="name" class="fields" value="'.$result->branch_name.'"'; 
			break;
			case 'tblbank':
			echo '<input type="text" name="name" id="name" class="fields" value="'.$result->bank_name.'"'; 
			break;
		}
	 ?>           
                
              ">
     </div>
       <div class="rows">
       			 <input type="hidden" name="hidden" id="hidden" value="<?php echo $table; ?>">
            	<input type="submit" name="add_submit" value="Update">
       </div>
    <?php echo form_close();?>
    
    <br / style="clear:both">
</div>