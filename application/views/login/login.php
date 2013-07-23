<script>
$(function(){
	$('#myform').submit(function(){
		var error = 0;
			$('.form').each(function(index, element) {
                	if($(this).val() ==  '')
					{
						$(this).addClass('error');
						error = 1;
					}else
					{
						$(this).removeClass('error');
					}
            });
			
			if(error != 0)
			{
				return false;
			}
	});
});
</script>

<div id="right">
<p>Please fill out the following form with your login credentials:</p>
<p style="color:#F00"><?php if(isset($error)) {echo $error;} ?></p>
<?php
$attributes = array('class' => 'login', 'id' => 'myform');
echo form_open('welcome/login',$attributes);
			$username = array(
              'name'        => 'username',
              'id'          => 'username',
              'value'       => '',
			  'placeholder' => 'Username',
              'maxlength'   => '100',
              'size'        => '50',
			  'class'		=> 'form'
            );
			$password = array(
              'name'        => 'password',
              'id'          => 'password',
              'value'       => '',
			  'placeholder' => 'Password',
              'maxlength'   => '100',
              'size'        => '50',
			  'class'		=> 'form'
            );
			
echo form_input($username);
echo form_password($password);
echo form_submit('mysubmit', 'Login','class=form');
	
echo form_close();
?>
</div>