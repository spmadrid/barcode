<div id="addnew_user">
	<h1>Add Sub</h1>
 <?php 
	$attributes = array(
	'id'=>'ytr',
	);
	echo form_open('add/savesub',$attributes);?>
     <div class="rows">
            	<label>Sub Acro</label>
                <input type="text" name="sub" id="sub" class="fields">
     </div>
      <div class="rows">
            	<label>Meaning</label>
                <input type="text" name="text" id="text" class="fields">
     </div>
       <div class="rows">
            	<input type="submit" name="add_submit" value="Save">
       </div>
    <?php echo form_close();?>
    
    <br / style="clear:both">
</div>