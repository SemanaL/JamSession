<?php
echo $this->form->create('Filter');
echo $this->form->input('date');
echo $this->form->input('jammeur',array('options'=>$jammeurs));
echo $this->form->input('keyword');
?>
</form>
<input type='submit' name='data[Filter][submit]' id ='FilterSubmit' value='Filter' class='btn btn-primary'></input>


<table id='resultList'></table>
<script>
$('document').ready(function(){	
	$('#FilterDate').datepicker(
		{ dateFormat: "yy-mm-dd"}
	);	
	
	function getList(){
		var request = {};		
		request.date = $('#FilterDate').val();
		request.jammeur = $('#FilterJammeur').val();
		request.keyword = $('#FilterKeyword').val();
		var jsonRequest = JSON.stringify(request);
			$.ajax({
				url: '<?php echo Router::url(array('controller'=>'messages','action'=>'getList'),true);?>',
				type: 'post',
				dataType: 'json',
				data: {data: jsonRequest},
					success: function(response) {
					if(response){
								$resultList = $('#resultList');
								messages="";
								for (var j in response.Messages)
								{
								messages+="<tr>";
								messages+="<td><a href='<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'view'));?>/"+response.Messages[j].id+"' >"+response.Messages[j].id+"</a></td>";
								messages+="<td>"+response.Messages[j].timestamp+"</td>";
								messages+="<td>"+response.Messages[j].jammeur+"</td>";
								messages+="<td>"+response.Messages[j].html+"</td>";
								messages+="</tr>";					
								}
								$resultList.html(messages);	
							}
					},
					error:function( req, status, err ) {
						console.log( 'Impossible to open the profile edition');
					}
			});	
	}
	
	$("#FilterSubmit").click(function(){
		getList();
	});
	
});
</script>