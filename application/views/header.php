<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title><?php echo $title;?></title>
<?php echo $css; echo $javascript; ?>
<script>
 $(document).ready(function() {
        $.active = false;
        $('body').bind('click keypress', function() { $.active = true; });
        checkActivity(1800000, 60000, 0); // timeout = 30 minutes, interval = 1 minute.
    });
	
	 function checkActivity(timeout, interval, elapsed) {
		 console.log(timeout+" - "+interval+" - "+elapsed);
        if ($.active) {
            elapsed = 0;
            $.active = false;
            $.get('heartbeat');
        }
        if (elapsed < timeout) {
            elapsed += interval;
            setTimeout(function() {
                checkActivity(timeout, interval, elapsed);
            }, interval);
        } else {
			window.location = document.URL+'../../error/logout';
        }
    }
</script>
</head>

<body>

<div class="userinfo">
        <h4><?php echo $this->session->userdata('username'); ?></h4>
        <p>Code : <?php echo $this->session->userdata('code'); ?></p>
        <p>Bank(s):<?php echo $this->session->userdata('bank'); ?></p>
    <?php if($this->session->userdata('photo') == NULL){ echo '<img src="../../image/avatar.jpg" width="70px">'; }else { echo '<img src="../../image/photo/'.$this->session->userdata('user_id').'/'.$this->session->userdata('photo').'" width="70px">'; }?>
</div>
<div id="container">
	<div id="header_logo">
        <h1 id="logo_text"><span id="logo"> </span>SP Madrid and Associates Law Firm</h1>
        
        
        	<ul id="logout">
            	<li >Settings
                <ul>
                    	<!--<li><a href="#">Edit Profile</a></li>-->
                    	<li><a href="../error/logout">Logout</a></li>
                    </ul>
                </li>
                	
            </ul>
      
    </div>
    <br / style="clear:both">
<?php $menu =  $this->uri->segment(1);?>
<?php echo $this->globals->menu($menu,$this->session->userdata('role'));?>

<div id="content">



    


	
	

