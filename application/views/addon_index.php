<link rel="stylesheet" href="../../css/base/jquery.ui.all.css">
<script>
	$(function() {
		$( "#tabs" ).tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				}
			}
		});
	});
</script>
    

<div id="tabs">
	<ul>
		<li><a href="supervisor">Supervisor</a></li>
		<li><a href="tlead">TLead</a></li>
		<li><a href="bank">Bank</a></li>
		<li><a href="branch">Branch</a></li>
		<li><a href="status">Status</a></li>
	</ul>
    
</div>