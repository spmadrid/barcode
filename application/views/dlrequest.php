<script>
$(document).ready(function(e) {
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
						url : 'flist?bnk='+val,
						dataType:'json',
						colModel : [
						{display: '', name : '', width : 20, sortable : false, align: 'center' ,hide:true},
						{display: 'ID', name:'id',width:20,sortable:true,align:'center',hide:true},
						{display:'CHcode',name:'chcode',width:'300',sortable:true,align: 'left'},
						{display:'Bank',name:'bank',width:180,sortable:true,align: 'left'},
						{display:'DL Type',name:'type',width:80,sortable:true,align: 'left'},
						{display:'DL Request request',name:'branch',width:80,sortable:true,align: 'left'},
						{display:'Date',name:'date',width:80,sortable:true,align: 'left'},
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
						{display: 'DL Type', name : 'DLType'},
					
						],
											sortname: "id",
											sortorder: "asc",
											usepager: true,
											title:'Field Request List',
											useRp: true,
											rp: 15,
											showTableToggleBtn: true,
											width: 'auto',
											height: 240,
						});
			}
		
	});
});
$(function() {
     $("#fldate").datepicker({
      changeMonth: true,
      changeYear: true
    });
	
	$('#fliers').click(function(){
			if($(this).is(':checked')){
					$('#fldate').show();
			}else
			{
				$('#fldate').hide();
				$('#fldate').val('');
			}
	});
	
	$('.typeadd').click(function(){
		var val = $(this).val();
		if(val == 'New Address')
		{$('#new_info').show();
		}else
		{
			$('#new_info').hide();
		}
	});
	$('#dldl').keydown(function(e){
				var key = e.which;
				var req = $('.required:checked').length;
				var typeadd = $('.typeadd:checked').length;
				var dltype = $('.dltype:checked').length;
				var email = $('.email:checked').length;
				var bank = $('#bank').val();
				var barcode = $('#barcode').val();
				var newradio = $('.newradio:checked').length;
				var news = $('.news');
				var fliers = $('#fliers');
				var fdate = $('#fldate').val();
				var error = 0;
				if(key == 13)
				{
					
						if(req == 0 || typeadd == 0 || dltype ==0 || email ==0 || barcode == '' || bank == '')
						{
								error  = 1;
								alert('Complete the form');
						}
						
						if(fliers.is(':checked'))
						{
							if(fdate == '')
							{
								error  = 1;
								alert('Fliers is checked, need date.');	
							}
						}
						
						if(typeadd == 'New Address')
						{
							if(newradio == 0)
							{
								error  = 1;
								alert('Select New Address Type');
							}
							
							
							news.each(function(index, element) {
                                var val = $(this).val();
								if(val == '')
								{
										error = 1
								}
                            });							
						}
						
						if(error == 0)
						{

							$.ajax({
								url:'save_fieldrequest',
								type:'POST',
								data:{landmark:$('#landmark').val(),bank:bank,field:$('.required:checked').val(),type:$('.typeadd:checked').val(),dltype:$('.dltype:checked').val(),email:$('.email:checked').val(),barcode:barcode,fliers:$('#fliers:checked').val(),fldate:$('#fldate').val(),newaddtype:$('.newradio:checked').val(),newadd:$('#long').val()+" "+$('#street').val()+" "+$('#barangay').val()+" "+$('#town').val()+" "+$('#province').val()},
								dataType:"json",
								beforeSend: function(){
								},
								success:function(data){
										if(data.status)
										{
											$('#display_message').html(data.message);
											$('#display_message').attr('class','');
											$('#display_message').addClass('success');
											$('#leads').flexReload();
											$('#barcode').val('');
											$('#barcode').focus();
											//setInterval($('#display_message').hide(),1000);
										}else
										{
											$('#display_message').html(data.message);
											$('#display_message').attr('class','');
											$('#display_message').addClass('error');
											$('#barcode').val('');
											$('#barcode').focus();
											//setInterval($('#display_message').hide(),1000);
										}
								}
							});
						}else
						{
							alert('Complete the form.');
							return false;
						}
				
				}
				
				
	});
});
</script>
<h1>DL Request</h1>
<div class="left_right">
	<div class="left" style="width:400px">
    	<div class="forms">
        		<form name="" method="post" id="dldl" action="">
                <div class="rows">
                    <label>Banks</label>
                        <?php 
                        $bank  = explode(",",$this->session->userdata('bank'));
                        $options = array();
                        $options[''] = 'Select';
                        foreach($bank as $bnk)
                        {
                            $options[''.$bnk.''] = $bnk;
                        }		
                                echo form_dropdown('agentleads', $options, '','class=fields id=bank');?>
                </div>
              	<ul class="listbox">
                	<li><input type="radio" name="field" value="For Field Manila" class="required"> For Field Manila</li>
                    <li><input type="radio" name="field" value="For Field Cebu" class="required"> For Field Cebu</li>
                    <li><input type="radio" name="field" value="For Field Davao" class="required"> For Field Davao</li>
                    <li><input type="radio" name="field" value="For Field Province" class="required"> For Field Province</li>
                    <li><input type="radio" name="field" value="For Endo Mail" class="required"> For Endo Mail</li>
                    <li><input type="radio" name="field" value="For EMail" class="required"> For EMail</li>
                    <li><input type="checkbox" name="fliers" value="YES" class="" id="fliers"> Fliers  <input type="text" value="" name="fldate" id="fldate" style="display:none;" readonly></li>
                </ul>
                <br / style="clear:both">
                <ul class="listbox">
                	<li>Address Type</li>
                    <li><input type="radio" name="type" value="Home" class="typeadd">Home</li>
                     <li><input type="radio" name="type" value="Office" class="typeadd">Office</li>
                      <li><input type="radio" name="type" value="ALTERNATIVE" class="typeadd">Alternative</li>
                       <li><input type="radio" name="type" value="New Address" class="typeadd">New Address</li>
                </ul>
                 <br / style="clear:both">
                <ul class="listbox">
                	<li>DL Type</li>
                    <li><input type="radio" name="dltype" value="DL 1" class="dltype">DL 1</li>
                    <li><input type="radio" name="dltype" value="DL 2" class="dltype">DL 2</li>
                    <li><input type="radio" name="dltype" value="DL 3" class="dltype">DL 3</li>
                    <li><input type="radio" name="dltype" value="DL 4" class="dltype">DL 4</li>
                </ul>
                 <br / style="clear:both">
                <ul class="listbox">
                	<li><input type="radio" name="email" value="Default Email" class="email">Default Email</li>
                    <li><input type="radio" name="email" value="New Email" class="email">New Email</li>
                </ul>
                 <br / style="clear:both">
                <div class="row">
                	<input type="text" name="barcode" id="barcode" value="" placeholder="Barcode">
                </div>
             <div id="new_info" style="display:none;">   
                            <div class="row">
                                <ul>
                                    <li>New Address</li>
                                    <li><input type="radio" name="new_type" value="Home" class="newradio">Home</li>
                                    <li><input type="radio" name="new_type" value="Office" class="newradio">Office</li>
                                </ul>
                            </div>
                            <div class="row">
                                <input type="text" name="long" value="" id="long" class="news">
                            </div>
                            <div class="row">
                                <label>Street No./Name</label>
                                <input type="text" name="street" value="" id="street" class="news">
                            </div>
                            <div class="row">
                                <label>Barangay</label>
                                <input type="text" name="barang" value="" id="barangay" class="news">
                            </div>
                             <div class="row">
                                <label>City / Town</label>
                                <input type="text" name="city_town" value="" id="town" class="news">
                            </div>
                            <div class="row">
                                <label>Province/Zip</label>
                                <input type="text" name="prov_zip" value="" id="province" class="news">
                            </div>
                            
                              <div class="row">
                                <label>Landmark</label>
                                <input type="text" name="landmark" value="" id="landmark" class="">
                            </div>
               </div>
                </form>
                
              <br / style="clear:both">   
                
        </div>
        
   </div>
   
   <div class="right" style="width:60%">
   		<div class="" id="display_message"></div>
        
        <div id="tbl">
        		<table id="leads"></table>
        </div>
    </div>
     <br / style="clear:both">
</div>