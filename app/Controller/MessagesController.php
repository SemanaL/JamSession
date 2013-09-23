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

	function import(){
		$current_path='C:/xampp/htdocs/github/jamsession/mails/new/';
		//$current_path='/home/import/Maildir/new/';
		
		$mails=array_diff(scandir($current_path), array('..', '.'));
		foreach($mails as $mail){
			
			$content=file_get_contents($mail);
			if(!is_null($content)){
				
			$translator=array(
				CHR(10)=>'',
				CHR(13)=>'',
				'  '=>' ',
			);				
			$startPosition= 0;
			$startLength = 0;
			$stopPosition = 0;
			$stopLength = 0;
			
			// WARNING : ENTER DATA IN THE APPEARANCE ORDER IN THE MAIL
			
			$keywords=array(
			'email'=>array('start'=>'for <','stop'=>'>; '),
			'dateTime'=>array('start'=>'>Em nome de','stop'=>'min'),
			'html'=>array('start'=>'<td>','stop'=>'</td>'),
			);
			
			foreach ($keywords as $word=>$keyword) {
				$startLength=strlen($keyword['start']);
				$startPosition=stripos($content,$keyword['start'],$stopPosition);
				$stopPosition=stripos($content,$keyword['stop'],$startPosition);
				if(!$startPosition || !$stopPosition){
					$message[$word]=false;
				}
				else{
				$tmpMessage[$word]=trim(strip_tags(substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition)));
				}
			}
			
			//ENTER MESSAGE IN DB
			$message=$this->Message->create();
			$jammeur=$this->Jammeur->findByEmail($tmpMessage['email']);
			$message['Message']['jammeur']=$jammeur['name'];
			$message['Message']['timestamp']=$tmpMessage['dateTime']; // DO SOME CHANGES, PROBABLY
			$message['Message']['html']=$tmpMessage['html'];
			
			$keywords=$this->Keyword->find('list');
			foreach ($keywords as $key => $keyword) {
				if (strpos($message['html'],$keyword) !== false) {
				    $match=$this->KeywordsMessage->create();
					$match['KeywordsMessage']['message_id']=
					$match['KeywordsMessage']['keyword_id']=$key;
					$this->KeywordsMessage->save($match);
				}
			}
			
			
			
			}
			
			$new_path='C:/xampp/htdocs/github/jamsession/mails/parsed/';
			//$new_path='/home/import/Maildir/parsed/';
			rename($current_path.$mail, $new_path.$mail);
		}
		
	}
}
?>