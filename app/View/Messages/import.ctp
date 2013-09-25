<h4 style="float:right"><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout'));?>">Logout</a></h4>
<h2>Importateur</h2>
<div><span class='highlight'><?php echo $count; ?></span> mails à importer</div>
</br>
<div id='mail-container'>
	<label id='filename-label'>fichier</label>
	<input type='text' id='filename' value="<?php echo $tmpMessage['filename']; ?>" />
	
	<label id='email-label'>email brut</label>
	<textarea id='mail-html'><?php echo $tmpMessage['mail_html']; ?></textarea>
</div>

<div id='import-container'>
		<label id='email-label'>email</label>
		<input type='text' id='email' value="<?php echo $tmpMessage['email']; ?>" />
		<input type='submit' id ='Submit' value='Importer' class='btn btn-primary'></input>
		
		<label id='date-label'>Date</label>
		<input type='date' id='date' value="<?php echo $tmpMessage['dateTime']; ?>" />
		<a href="<?php echo $this->Html->url(array('admin'=>true,'controller' => 'messages', 'action' => 'import'))."/".($id-1);?>">
		<input type='submit' value='Precedent' class='btn btn-primary'></input>
		</a>
		
		<a href="<?php echo $this->Html->url(array('admin'=>true,'controller' => 'messages', 'action' => 'import'))."/".($id+1);?>">
		<input type='submit' value='Suivant' class='btn btn-primary'></input>
		</a>
		
		
		<label id='html-label'>Message</label>
		<textarea id='html'><?php echo $tmpMessage['html']; ?></textarea>
		
		<label id='father-html-label'>Message Precedent</label>
		<textarea id='father-html'><?php echo $tmpMessage['father_html']; ?></textarea>
				
		<label id='rest-html-label'>Reste</label>
		<textarea id='rest-html'><?php echo $tmpMessage['rest_html']; ?></textarea>
</div>

<script>
$('document').ready(function(){	
	function manualImportSave(){
		var request = {};	
		request.filename=$("#filename").val();	
		request.email=$("#email").val();
		request.dateTime=$("#date").val();
		request.html=$("#html").html();
		request.father_html=$("#father-html").html();
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
	
	$("#Submit").click(function(){
		manualImportSave()
	});
		
		
	
	
	
		
		
});
</script>