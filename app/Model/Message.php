<?php

class Message extends AppModel {

	var $belongsTo = array('Jammeur');
	var $hasAndBelongsToMany = array('Keyword');
}

?>