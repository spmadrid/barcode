<script>
$(document).ready(function() {
	 var selectedID;

		function getTextContent(el) {
			if (typeof el.textContent == 'string')
				return el.textContent;
			if (typeof el.innerText == 'string')
				return el.innerText;

			// Fix below for older browsers not supporting W3C DOM 3 Core Specs (.innerText)
			return getText2(el);

			function getText2(el) {
				var x = el.childNodes;
				var txt = '';
				for (var i=0, len=x.length; i<len; ++i){
					if (3 == x[i].nodeType) {
						txt += x[i].data;
					} else if (1 == x[i].nodeType){
						txt += getText2(x[i]);
					}
				}
				return txt.replace(/\s+/g,' ');
			}
		}

	
	
						
						$("#leads").flexigrid({
						url : 'listleads?code=<?php echo $code;?>&bank=<?php echo $bank;?>',
						dataType:'json',
						colModel : [
						{display: '', name : '', width : 20, sortable : false, align: 'center' ,hide:true},
						{display: 'ID', name:'id',width:20,sortable:true,align:'center',hide:true},
						{display:'CHcode',name:'name',width:'300',sortable:true,align: 'left'},
						{display:'Name',name:'accessl',width:180,sortable:true,align: 'left'},
						{display:'Placement',name:'branch',width:80,sortable:true,align: 'left'},
						],
						buttons : [
										//{name: 'Select All', onpress : selectAll},
										//{name: 'Deselect All', onpress : deselectAll},
										//{name: 'Delete', onpress:deleteClicked},
										{separator: true},	
										//{name: 'Add', onpress : addData},	
										{separator: true},	
										//{name: 'Edit', onpress : editData},	
						],
						searchitems : [
						{display: 'CHCode', name : 'CHCode', isdefault: true},
					
						],
											sortname: "id",
											sortorder: "asc",
											usepager: true,
											title: 'Agent Leads',
											useRp: true,
											rp: 15,
											showTableToggleBtn: true,
											width: 'auto',
											height: 'auto',
						});
			
		
	
	
});
</script>		
<?php if($photo){ ?>
<img src="<?php echo $this->globals->base_url();?>../image/photo//<?php echo $photo;?>" width="80px" height="80px">
<?php }else{ ?>
<img src="<?php echo $this->globals->base_url();?>../image/avatar.jpg" width="80px" height="80px">
 <?php
}?>
<h1><?php echo $bank;?>: <?php echo str_replace('%20',' ',$name);?></h1>

<table id="leads"></table>