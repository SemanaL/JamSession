<h4 style="float:right"><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout'));?>">Logout</a></h4>
<h2>Importateur</h2>
<div><span class='highlight'><?php echo $count; ?></span> mails à importer</div>
</br>
<div id='mail-container'>
	<label id='filename-label'>fichier</label>
	<input type='text' id='filename' />
	
	<label id='email-label'>email brut</label>
	<textarea id='mail-html'></textarea>
</div>

<div id='import-container'>
		<label id='email-label'>email</label>
		<input type='text' id='email' />
		<input type='submit' id ='Submit' value='Importer' class='btn btn-primary'></input>
		
		<label id='date-label'>Date</label>
		<input type='date' id='date' />
		<input type='submit' id ='Next' value='Prochain' class='btn btn-primary'></input>
		
		<label id='html-label'>Message</label>
		<textarea id='html'></textarea>
		
		<label id='father-html-label'>Message Precedent</label>
		<textarea id='father-html'></textarea>
				
		<label id='rest-html-label'>Reste</label>
		<textarea id='rest-html'></textarea>
</div>

<script>
$('document').ready(function(){	
	var index=0;
	function manualImportGet(){
			var jsonRequest = JSON.stringify(index);
			$.ajax({
				url: '<?php echo Router::url(array('admin'=>true,'controller'=>'messages','action'=>'manualImportGet'),true);?>',
				type: 'post',
				dataType: 'json',
				data: {data: jsonRequest},
					success: function(tmpMessage) {
						if(tmpMessage){
							$("#email").val(tmpMessage.email);
							$("#date").val(tmpMessage.dateTime);
							$("#html").val(tmpMessage.html);
							$("#father-html").val(tmpMessage.father_html);
							$("#rest-html").val(tmpMessage.rest_html);
							$("#mail-html").val(tmpMessage.mail_html);
							$("#filename").val(tmpMessage.filename);
						}	
					},
					error:function( req, status, err ) {
						console.log( 'Impossible to open the profile edition');
					}
			});	
	}
	
	function manualImportSave(){
		var request = {};	
		request.filename=$("#filename").val();	
		request.email=$("#email").val();
		request.dateTime=$("#date").val();
		request.html=$("#html").val();
		request.father_html=$("#father-html").val();
		var jsonRequest = JSON.stringify(request);
			$.ajax({
				url: '<?php echo Router::url(array('admin'=>true,'controller'=>'messages','action'=>'manualImportSave'),true);?>',
				type: 'post',
				dataType: 'json',
				data: {data: jsonRequest},
					success: function(response) {
						 location.reload();
					},
					error:function( req, status, err ) {
						console.log( 'Impossible to open the profile edition');
					}
			});	
	}
	
	
	manualImportGet(index);
	
	$("#Next").click(function(){
		index++;
		manualImportGet(index);
	});
	
	$("#Submit").click(function(){
		manualImportSave()
	});
		
		
	
	
	
		
		
});
</script>