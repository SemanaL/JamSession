<?php
App::uses('AppController', 'Controller');

class MessagesController extends AppController{		
	var $uses = array('Message','Jammeur','Keyword','KeywordsMessage');
	var $components = array();
	var $helpers = array();	

	function index($id=1){
		$jammeurs=$this->Jammeur->find('list');
		$this->set('jammeurs',$jammeurs);
	}
	
	function getList(){
		$response = false;
		$this->layout = 'ajax';
		if(!empty($this->data)){
			$conditions=json_decode($this->data,true);
			// Filter messages
			$messages=$this->Message->find('all');
			foreach ($messages as $key=>$message) {
				$response['Messages'][$key]['id']=$message['Message']['id'];
				$response['Messages'][$key]['timestamp']=$message['Message']['timestamp'];
				
				$jammeur=$this->Jammeur->read(null,$message['Message']['jammeur_id']);
				$response['Messages'][$key]['jammeur']=$jammeur['Jammeur']['name'];
				if(strlen($message['Message']['html'])>30){
					$response['Messages'][$key]['html']=substr($message['Message']['html'],0,30)."...";
				}
				else{
					$response['Messages'][$key]['html']=$message['Message']['html'];
				}
				
			}
			
		}
		echo json_encode($response);
	}

	function view($id){
		$message=$this->Message->read(null,$id);
			$content['id']=$message['Message']['id'];
			$jammeur=$this->Jammeur->read(null,$message['Message']['jammeur_id']);
			$content['jammeur']=$jammeur['Jammeur']['name'];
			$content['timestamp']=$message['Message']['timestamp'];
			$content['html']=$message['Message']['html'];
			$keywords=$this->KeywordsMessage->find('all',array('conditions'=>array('message_id'=>$message['Message']['id'])));
			if($keywords){
				foreach ($keywords as $keyword) {
					$word=$this->Keyword->read(null,$keyword['KeywordsMessage']['keyword_id']);	
					$content['keywords'][]=$word['Keyword']['keyword'];
				}
			}
			else{
				$content['keywords']=null;
			}
			$this->set('content',$content);
	}

}
?>