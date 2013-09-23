<h4><a href="<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'index'));?>">Retour</a></h4>
</br>
<?php 
if($content['404']==true){ ?>
<h4>Message non trouvé</h4>
<?php } else { ?>
<h4>ID : <span id='id'><?php echo $content['id'];?></span></h4>
<h4>Envoyé par : <span id='jammeur'><?php echo $content['jammeur'];?></span></h4>
<h4>Date : <span id='date'><?php echo $content['timestamp'];?></span></h4>
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
</br>
<div id='html'><?php echo $content['html'];?></div>
</br>
<div id='nav'>
<a id='previous'  href='<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'view'))."/".($content['id']-1);?>'>PREC</a>
<a id='next' href='<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'view'))."/".($content['id']+1);?>'>SUIV</a>
</div>
</br>
<?php if($content['father']){ ?>
<h4>En réponse à :</h4>
<table>
	<tr>
		<td><a href='<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'view'))."/".$content['father']['id'];?>'><?php echo $content['father']['id'];?></a></td>
		<td><?php echo $content['father']['timestamp'];?></td>
		<td><?php echo $content['father']['jammeur'];?></td>
		<td><?php echo $content['father']['html'];?></td>
	</tr>
</table>
</br>
<?php } 
if($content['children'][0]){ ?>
<h4>Suite :</h4>
<table>
	<?php foreach ($content['children'] as $child) { ?>
	<tr>
		<td><a href='<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'view'))."/".$child['id'];?>'><?php echo $child['id'];?></a></td>
		<td><?php echo $child['timestamp'];?></td>
		<td><?php echo $child['jammeur'];?></td>
		<td><?php echo $child['html'];?></td>
	</tr>
	<?php }	?>
</table>

<?php }} ?>