<script>
$(function(){
	$('#myform').submit(function(){
		var error = 0;
		var s = $('#level').val();
		var bbn = $('#bank').val();
		$('.fields').each(function(index, element) {
            	if($(this).val() =='')
				{
					alert($(this).attr('id'));
					error  = 1;
				}
        });
	if(s != null){	
		 yui = new Array();	
		$.each(s,function(index,value){
                yui[index] = value;
			//if(value == 'ADMIN')
			//{
				//error = 1;
               // alert('');
			//
       // }
		});
      var yuna =  yui.indexOf("ADMIN");
      if(yuna != null)
      {
            error = 1;
      }

	}else
	{
		error  = 1;
	}
	if(bbn == null)
	{
		error  = 1;
	}
		
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
									alert(data.error);
									$('#users').flexReload();
									$.fancybox.close();
								}else
								{
									alert(data.error);
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
			alert('All fields are required \n Access Level  - Admin can not be joined with other access level.');
		}
		
		return false	
	});
});
</script>
<div id="addnew_user">
<h1>Update User</h1>
	
    <?php 
	$attributes = array(
	'id'=>'myform',
	'enctype'=>'multipart/form-data'
	);
	echo form_open('admin/update',$attributes);?>
	<div id="addnew_form">
   <div id="left_side">
   			 <div class="rows">
            	<label>ID</label>
                <input type="text" name="id" id="id" class="fields" value="<?php echo $id;?>">
        	</div>
			 <div class="rows">
            	<label>Code</label>
                <input type="text" name="code" id="code" class="fields" value="<?php echo $code;?>">
        	</div>
            
            <div class="rows">
            	<label>Name</label>
                <input type="text" name="name" id="name" class="fields" value="<?php echo $name;?>">
        	</div>
            
             <div class="rows">
            	<label>Password</label>
                <input type="password" name="pass" id="pass" class="fields" value="<?php echo $pass;?>">
        	</div>
            
             <div class="rows">
            	<label>Agent TLead</label>
                
                <?php 
				echo form_dropdown('tlead',  $this->addons->leadarray(), $tlead,'class=fields');?>
                
        	</div>
            
             <div class="rows">
            	<label>Agent Supervisor</label>
                <?php 
				echo form_dropdown('sup', $this->addons->suparray(), $sup,'class=fields');?>
        	</div>
            
            <div class="rows">
            	<label>Agent Bank</label>
                <?php 
				echo form_dropdown('bank[]',  $this->addons->bankarray(), $bank,'id=bank class=fields style="height:70px;" multiple="multiple"');?>
        	</div>
            
            <div class="rows">
            	<label>Access Level</label>
                <?php 
				$options = array(
					'ADMIN'=>'ADMIN',
					'FIELD'=>'FIELD',
					'TL'=>'TL',
					'AGENT'=>'AGENT',
					'OJT'=>'OJT',
				);
				
				echo form_dropdown('level[]', $options, $level,' id=level class=fields style="height:70px;" multiple="multiple"');?>
        	</div>
            
            <div class="rows">
            	<label>Agent Level</label>
                <?php 
				$options = array(
					'' =>'Select',
					'level1'=>'level1',
					
				);
				echo form_dropdown('alevel', $options, $alevel,'class=fields');?>
        	</div>
</div> 
<div id="right_side">    
			 <div class="rows">
            	<label>Photo</label>
                <input type="file" name="photo" id="photo" >
        	</div>       
            <div class="rows">
            	<label>Psuedo Name</label>
                <input type="text" name="suedo" id="suedo" class="fields" value="<?php echo $suedo;?>">
        	</div>
            
             <div class="rows">
            	<label>Branch</label>
                 <?php 
				echo form_dropdown('branch', $this->addons->brancharray(), $branch,'class=fields');?>
        	</div>
            
            <div class="rows">
            	<label>Contact</label>
                <input type="text" name="contact" id="contact" class="fields" value="<?php echo $contact;?>">
        	</div>
            
            <div class="rows">
            	<label>Place</label>
                <input type="text" name="place" id="place" class="fields" value="<?php echo $place;?>">
        	</div>
            
            <div class="rows">
            	<label>Local</label>
                <input type="text" name="local" id="local" class="fields" value="<?php echo $local;?>">
        	</div>
            
             <div class="rows">
            	<label>Email</label>
                <input type="text" name="email" id="email" class="fields" value="<?php echo $email;?>">
        	</div>
            
            <div class="rows">
            	<label>Assign</label>
                <input type="text" name="assign" id="assign" class="fields" value="<?php echo $assign;?>">
                 <input type="hidden" name="id" id="id" class="fields" value="<?php echo $id;?>">
        	</div>
 </div>
            
            <div class="rows">
            	<input type="submit" name="add_submit" value="Save">
            </div>
        
    </div>
    <?php echo form_close();?>
    
    <br / style="clear:both">

</div>