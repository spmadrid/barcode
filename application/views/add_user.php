<script>
$(function(){
	$('#myform').submit(function(){
		var error = 0;
		var s = $('#level').val();
		var bbn = $('#bank').val();
		$('.fields').each(function(index, element) {
            	if($(this).val() =='')
				{
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
         //aler('no user');
		error  = 1;
	}
	if(bbn == '')
	{
       // aler('bak');
		error  = 1;
	}
		
		if(error ==0){
		
		var formData = new FormData($('form')[0]);
					$.ajax({
						url: 'create',  //server script to process data
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
<h1>Create New User</h1>
	
    <?php 
	$attributes = array(
	'id'=>'myform',
	'enctype'=>'multipart/form-data'
	);
	echo form_open('admin/create',$attributes);?>
	<div id="addnew_form">
   <div id="left_side">
   			 <div class="rows">
            	<label>ID</label>
                <input type="text" name="id" id="id" class="fields">
        	</div>
			 <div class="rows">
            	<label>Code</label>
                <input type="text" name="code" id="code" class="fields">
        	</div>
            
            <div class="rows">
            	<label>Name</label>
                <input type="text" name="name" id="name" class="fields">
        	</div>
            
             <div class="rows">
            	<label>Password</label>
                <input type="password" name="pass" id="pass" class="fields">
        	</div>
            
             <div class="rows">
            	<label>Agent TLead</label>
                <select name="tlead" id="tlead" class="fields">
                	<option value="">Select</option>
                   <?php echo $this->addons->lead();?>
                </select>
        	</div>
            
             <div class="rows">
            	<label>Agent Supervisor</label>
                <select name="sup" id="sup" class="fields" >
                	<option value="">Select</option>
                   <?php echo $this->addons->sup();?>
                </select>
        	</div>
            
            <div class="rows">
            	<label>Agent Bank</label>
                <select name="bank[]" id="bank" class="fields" style="height:70px;" multiple="multiple">
                   <?php echo $this->addons->bank();?>
                </select>
        	</div>
            
            <div class="rows">
            	<label>Access Level</label>
               <select name="level[]" id="level" class="fields" multiple="multiple" style="height:70px;" >
                <option value="ADMIN">ADMIN</option>
                    <option value="AGENT">AGENT</option>
                     <option value="FIELD">FIELD</option>
                      <option value="OJT">OJT</option>
                       <option value="TL">TL</option>
                </select>
        	</div>
             <div class="rows">
            	<label>Agent Level</label>
               <select name="alevel" id="alevel" class="fields">
                	<option value="">Select</option>
                    <option value="level1">level1</option>
                </select>
        	</div>
</div> 
<div id="right_side"> 
			 <div class="rows">
            	<label>Photo</label>
                <input type="file" name="photo" id="photo" >
        	</div>
          
            <div class="rows">
            	<label>Psuedo Name</label>
                <input type="text" name="suedo" id="suedo" class="fields">
        	</div>
            
             <div class="rows">
            	<label>Branch</label>
                <select name="branch" id="branch" class="fields">
                	<option value="">Select</option>
                   <?php echo $this->addons->branch();?>
                </select>
        	</div>
            
            <div class="rows">
            	<label>Contact</label>
                <input type="text" name="contact" id="contact" class="fields">
        	</div>
            
            <div class="rows">
            	<label>Place</label>
                <input type="text" name="place" id="place" class="fields">
        	</div>
            
            <div class="rows">
            	<label>Local</label>
                <input type="text" name="local" id="local" class="fields">
        	</div>
            
             <div class="rows">
            	<label>Email</label>
                <input type="text" name="email" id="email" class="fields">
        	</div>
            
            <div class="rows">
            	<label>Assign</label>
                <input type="text" name="assign" id="assign" class="fields">
        	</div>
 </div>
            
            <div class="rows">
            	<input type="submit" name="add_submit" value="Save">
            </div>
        
    </div>
    <?php echo form_close();?>
    
    <br / style="clear:both">

</div>