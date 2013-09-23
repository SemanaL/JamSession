<h4>ID : <span id='id'><?php echo $content['id'];?></span></h4>
<h3>Envoyé par : <span id='jammeur'><?php echo $content['jammeur'];?></span></h3>
<h3>Date : <span id='date'><?php echo $content['timestamp'];?></span></h3>
<h4>Hashtags : 
	<span id='keywords'>
		<?php 
		$keywords=$content['keywords'];
		if (!is_null($keywords)) {
			foreach($keywords as $keyword){
				echo "#".$keyword." ";
			}
		}
?>
	</span>
</h4>
<div id='html'><?php echo $content['html'];?></div>
<a id='previous' class='nav' href='<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'view'))."/".($content['id']-1);?>'>PREC</a>
<a id='next' class='nav' href='<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'view'))."/".($content['id']+1);?>'>SUIV</a>

