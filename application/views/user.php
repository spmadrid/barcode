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
	
		function selectAll(com, grid) {
			$('.bDiv tbody tr',grid).addClass('trSelected');
			$('.trSelected').find(':checkbox').attr('checked', "checked");
		}
		function deselectAll(com, grid) {
			$('.bDiv tbody tr',grid).removeClass('trSelected');
			$('.flexigrid tbody tr').find(':checkbox').attr('checked', false);
		}
		
		function addData(com,grid)
		{
				$('a.upd').attr("href","add_user");
				$('#call_link').fancybox().trigger('click');
		}
		
		function deleteClicked(com, grid) {
                        
                var selectedLength = $('.trSelected',grid).length;
			
				if (confirm('Delete '+selectedLength+' item[s]?')) {
					
					var selectedIDs = [];
					$('.trSelected').each( function() {
						selectedIDs.push(getTextContent(this.cells[1]))
					});

					$.ajax({
						type: 'POST',
						url: 'change_user_status',
						data: "del_lead="+selectedIDs,
						success: function(result) {
							if(result == '1'){
									$('#users').flexReload();
							}
							
						}
					});					
					
				}
		}
		
		function editData(com,grid)
		{
			var selected = $('.trSelected',grid).length;
			
			if (selected == 0)
				alert('Please make sure to select a record to edit below by clicking on the desired row.');
			else if (selected > 1){
				alert('Only select 1 record when editing data.');
				
			} else {
			var selectedID = getTextContent($('.trSelected')[0].cells[1]);
				
				$('a.upd').attr("href","edit?id="+selectedID);
				$('#call_link').fancybox().trigger('click');
						   
			}
		}
		
		$("#users").flexigrid({
			url : 'user_data',
			dataType:'json',
			colModel : [
		{display: '', name : '', width : 20, sortable : false, align: 'center' ,hide:true},
		{display: 'ID', name:'id',width:20,sortable:true,align:'center',hide:true},
		{display:'Agent Name',name:'name',width:'300',sortable:true,align: 'left'},
		{display:'Agent Lead',name:'address',width:160,sortable:true,align: 'left'},
		{display:'Access Level',name:'accessl',width:80,sortable:true,align: 'left'},
		{display:'Agent Branch',name:'branch',width:80,sortable:true,align: 'left'},
		{display:'Contact Number',name:'contact',width:80,sortable:true,align: 'left'},
		{display:'Status',name:'AgentStatus',width:80,sortable:true,align: 'left'},
		],
		buttons : [
						//{name: 'Select All', onpress : selectAll},
						//{name: 'Deselect All', onpress : deselectAll},
						{name: 'Delete', onpress:deleteClicked},
						{separator: true},	
						
						{name: 'Add', onpress : addData},	
						{separator: true},	
						{name: 'Edit', onpress : editData},	
                    
		],
		searchitems : [
		{display: 'Name', name : 'AgentName', isdefault: true},
		{display: 'Agent Lead', name:'Agenttlead'},
		],
	sortname: "id",
	sortorder: "asc",
	usepager: true,
	title: 'User List',
	useRp: true,
	rp: 13,
	showTableToggleBtn: true,
	width: 'auto',
	height: 'auto',
			
			});
    

});
</script>



<table id="users"></table>
<a style="display:none" href="" class="upd" id="call_link" >update</a>
