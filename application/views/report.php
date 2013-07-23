<script>
$(document).ready(function(e) {
    $('.bankname').fancybox();
});
</script>
<h1>List Of Agent</h1>
<?php if(!$result){?>
	<h5>No Result!</h5>
<?php }else{ 
echo "<ul class='emer'>";
foreach($list as $val){
?>
	<li>
		<?php $bnk = explode(",",$val['bank']);?>
		<?php foreach($bnk as $bns){
			echo "<a href='viewagentleads/".$val['code']."/".$bns."/".$val['name']."/".$val['photo']."' class='bankname'>".$bns."</a>";
		}?>	
		<?php echo $val['name'];?>
	</li>	
<?php 
} echo "</ul>"; } ?>