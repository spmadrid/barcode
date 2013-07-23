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
		
		
		$('#bank').change(function(){
			var val = $(this).val();
			if(val == '')
			{	
			}else
			{
				
				$('.flexigrid').remove();
				$('#tbl').append('<table id="leads"></table>');
				$("#leads").flexigrid({
						url : 'adminleads?bank='+val,
						dataType:'json',
						colModel : [
						{display: '', name : '', width : 20, sortable : false, align: 'center' ,hide:true},
						{display: 'ID', name:'id',width:20,sortable:true,align:'center',hide:true},
						{display:'CHcode',name:'name',width:'300',sortable:true,align: 'left'},
						{display:'Agent',name:'address',width:160,sortable:true,align: 'left'},
						{display:'Name',name:'accessl',width:180,sortable:true,align: 'left'},
						{display:'Status',name:'status',width:180,sortable:true,align: 'left'},
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
											sortorder: "desc",
											usepager: true,
											title: val+' List',
											useRp: true,
											rp: 15,
											showTableToggleBtn: true,
											width: 'auto',
											height: 200,
				});
			}
		});
});
</script>

<div class="rows">
	<label>Banks</label>
        <?php 
				
				echo form_dropdown('tlead', $this->bank->bankLists(), '','class=fields id=bank');?>
</div>

<div id="tbl">
<table id="leads"></table>
</div>
<a style="display:none" href="" class="upd" id="call_link" >update</a>