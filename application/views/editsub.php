<div id="addnew_user">
	<h1>Update Sub</h1>
 <?php 
	$attributes = array(
	'id'=>'updatesub',
	);
	echo form_open('add/upsub',$attributes);?>
     <div class="rows">
            	<label>Sub  Acro</label>
                <input type="text" name="sub" id="sub" value="<?php echo $info->status_acro;?>" class="fields">
     </div>
      <div class="rows">
            	<label>Meaning</label>
                <input type="text" name="text" id="text" value="<?php echo $info->status_mean;?>" class="fields">
                 <input type="hidden" name="subid" id="subid" value="<?php echo $info->id;?>" >
     </div>
       <div class="rows">
            	<input type="submit" name="add_submit" value="Save">
       </div>
    <?php echo form_close();?>
    
    <br / style="clear:both">
</div>