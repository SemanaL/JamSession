<h4 style="float:right"><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout'));?>">Logout</a></h4>
<h2>Re:Jam Session</h2>
<div id='filter-container'>
	<?php
	echo $this->form->create('Filter');
	?>
		<?php 
		echo $this->form->input('id',array('class'=>'filter-input'));
		echo $this->form->input('date',array('class'=>'filter-input'));
		echo $this->form->input('jammeur',array('options'=>$jammeurs,'selected' => 0,'class'=>'filter-input'));
		echo $this->form->input('keyword',array('class'=>'filter-input'));
		$minchar[0]=0;
		$minchar[100]=100;
		$minchar[500]=500;
		$minchar[5000]=5000;
		echo $this->form->input('characters',array('options'=>$minchar, 'class'=>'filter-input','label' => 'Min. de caracteres'));
		?>
	</form>
	</br>
	<input type='submit' name='data[Filter][submit]' id ='FilterSubmit' value='Filtrer' class='btn btn-primary'></input>
</div>

</br>
<div id='list-container'>
	<legend><i class="icon-envelope-alt"></i>&nbsp;Messages</legend>
	<table id='resultList'></table>
</div>
</br>

<div id='Stats'>
	<legend><i class="icon-star-empty"></i>&nbsp;Ranking</legend>
	<?php foreach ($jammeurs as $key => $jammeur) {	if($key>0){?>		
	<div class='jammeurStat'>	
	<h4><?php echo $jammeur;?></h4>
	<ul>
	<li>Mails : <span class='highlight'><?php echo $stats[$key]['total'];?></span></li>
	<li>#Preums : <span class='highlight'><?php echo $stats[$key]['preums'];?></span></li>
	<li>#Deuz : <span class='highlight'><?php echo $stats[$key]['deuz'];?></span></li>
	<li>#Troiz : <span class='highlight'><?php echo $stats[$key]['troiz'];?></span></li>
	</ul>
	</div>	
	<?php }} ?>
</div>

<script>
$('document').ready(function(){	
	$('#FilterDate').datepicker(
		{ dateFormat: "yy-mm-dd"}
	);	
	
	 $(function() {
		var availableKeywords = [
			<?php foreach($words as $word){
			echo '"'.$word.'",';
			}?>
		];
		$( "#FilterKeyword" ).autocomplete({
		source: availableKeywords
		});
	});

	function getList(){
		var request = {};		
		request.id = $('#FilterId').val();
		request.date = $('#FilterDate').val();
		request.jammeur = $('#FilterJammeur').val();
		request.keyword = $('#FilterKeyword').val();
		request.characters = $('#FilterCharacters').val();
		var jsonRequest = JSON.stringify(request);
			$.ajax({
				url: '<?php echo Router::url(array('admin'=>true,'controller'=>'messages','action'=>'getList'),true);?>',
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
								messages+="<td><a href='<?php echo $this->Html->url(array('admin'=>true,'controller' => 'messages', 'action' => 'view'));?>/"+response.Messages[j].id+"' >"+response.Messages[j].id+"</a></td>";
								messages+="<td>"+response.Messages[j].timestamp+"</td>";
								messages+="<td>"+response.Messages[j].jammeur+"</td>";
								messages+="<td>"+response.Messages[j].html+"</td>";
								messages+="</tr>";					
								}
								$resultList.html(messages);	
							}
							else{
								$('#resultList').html("Pas de messages");
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