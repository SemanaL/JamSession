<?php

class Keyword extends AppModel {
	var $hasAndBelongsToMany = array('Message');
}

?>