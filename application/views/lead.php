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
		
		
			function addData(com,grid)
		{
				$('a.upd').attr("href","addnamic/tbllead");
				$('#call_link').fancybox().trigger('click');
		}
		
		function deleteClicked(com, grid) {
                        
                var selectedLength = $('.trSelected',grid).length;
				if (selectedLength == 0){
					alert('Please make sure to select a records to delete');
					return false;
				}
				if (confirm('Delete '+selectedLength+' item[s]?')) {
					
					var selectedIDs = [];
					$('.trSelected').each( function() {
						selectedIDs.push(getTextContent(this.cells[1]))
					});

					$.ajax({
						type: 'POST',
						url: 'deletenames',
						data:{del_lead:selectedIDs,table:'tbllead'},
						success: function(result) {
							if(result == '1'){
									$('#currents').flexReload();
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
				
				$('a.upd').attr("href","edit?id="+selectedID+"&table=tbllead");
				$('#call_link').fancybox().trigger('click');
						   
			}
		}
		
		
		$("#currents").flexigrid({
			url : 'suplist?table=tbllead',
			dataType:'json',
			colModel : [
		{display: '', name : '', width : 20, sortable : false, align: 'center' ,hide:true},
		{display: 'ID', name:'id',width:20,sortable:true,align:'center',hide:true},
		{display:'Team Lead Name',name:'name',width:'300',sortable:true,align: 'left'},
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
		{display: 'Name', name : 'lead_name', isdefault: true},
		],
	sortname: "id",
	sortorder: "asc",
	usepager: true,
	title: 'List',
	useRp: true,
	rp: 13,
	showTableToggleBtn: true,
	width: 'auto',
	height: 'auto',
			
			});
    

});		
</script>
<table id="currents"></table>
<a style="display:none" href="" class="upd" id="call_link" >update</a>