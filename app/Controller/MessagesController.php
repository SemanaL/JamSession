<?php
App::uses('AppController', 'Controller');

class MessagesController extends AppController{		
	var $uses = array('Message','Jammeur','Keyword','KeywordsMessage','Children');
	var $components = array();
	var $helpers = array();	

	function index($id=1){
		$jammeurs=$this->Jammeur->find('list');
		$jammeurs[0]="Tous, même Gamin !";
		$this->set('jammeurs',$jammeurs);
		
		$keywords=$this->Keyword->find('all');
		foreach ($keywords as $keyword) {
			$words[]=$keyword['Keyword']['keyword'];
		}
		$this->set('words',$words);
	
		//Stats	
		foreach ($jammeurs as $key => $jammeur) {
			$stats[$key]['total']=$this->Message->find('count',array('conditions'=>array('jammeur_id'=>$key)));
			$stats[$key]['preums']=$this->Message->find('count',array('conditions'=>array(
				'jammeur_id'=>$key,
				'html LIKE'=>'%preum%'
				)));
			$stats[$key]['deuz']=$this->Message->find('count',array('conditions'=>array(
				'jammeur_id'=>$key,
				'html LIKE'=>'%deuz%'
				)));
			$stats[$key]['troiz']=$this->Message->find('count',array('conditions'=>array(
				'jammeur_id'=>$key,
				'html LIKE'=>'%troiz%'
				)));
		}
		$this->set('stats',$stats);
	}
	
	function getList(){
		$response = false;
		$this->layout = 'ajax';
		if(!empty($this->data)){
			$filters=json_decode($this->data,true);
			$conditions=array();
			
			if($filters['jammeur']>0){
				$conditions['Message.jammeur_id']=$filters['jammeur'];
			}	
			if(!empty($filters['date'])){
				$conditions['DATE(Message.timestamp)']=$filters['date'];
			}
			
			if($filters['id']!=""){
				$conditions['Message.id']=$filters['id'];
			}

			if(!empty($filters['characters'])){
				$conditions['CHAR_LENGTH(Message.html) > ']=$filters['characters'];
			}
			
			// Filter messages
			
			$messages=$this->Message->find('all', array('conditions'=>$conditions));
			

			foreach ($messages as $key=>$message) {
				$match=null;
				
				if($filters['keyword']!=""){
					$keyword=$this->Keyword->findByKeyword($filters['keyword']);
					
					$match=$this->KeywordsMessage->find('first', array('conditions'=>array(
							'KeywordsMessage.message_id'=>$message['Message']['id'],
							'KeywordsMessage.keyword_id'=>$keyword['Keyword']['id']
						)));
				}

				if($filters['keyword']=="" || $match){	
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
			
		}
		echo json_encode($response);
	}

	function view($id){
		$message=$this->Message->read(null,$id);
			if(!$message){
				$content['404']=true;
			}
		else{
			$content['404']=false;
			$content['id']=$id;
			$jammeur=$this->Jammeur->read(null,$message['Message']['jammeur_id']);
			$content['jammeur']=$jammeur['Jammeur']['name'];
			$content['timestamp']=$message['Message']['timestamp'];
			$content['html']=$message['Message']['html'];
			$keywords=$this->KeywordsMessage->find('all',array('conditions'=>array('message_id'=>$id)));
			if($keywords){
				foreach ($keywords as $keyword) {
					$word=$this->Keyword->read(null,$keyword['KeywordsMessage']['keyword_id']);	
					$content['keywords'][]=$word['Keyword']['keyword'];
				}
			}
			else{
				$content['keywords']=null;
			}
			
			// Get Father
			$fatherMatch=$this->Children->find('first',array('conditions'=>array(
				'children_id'=>$id
			)));
			
			if($fatherMatch) {
				$father=$this->Message->read(null,$fatherMatch['Children']['father_id']);
				$content['father']['id']=$father['Message']['id'];
				$content['father']['timestamp']=$father['Message']['timestamp'];
				
				$jammeur=$this->Jammeur->read(null,$father['Message']['jammeur_id']);
				$content['father']['jammeur']=$jammeur['Jammeur']['name'];
				
				if(strlen($father['Message']['html'])>30){
					$content['father']['html']=substr($father['Message']['html'],0,30)."...";
				}
				else{
					$content['father']['html']=$father['Message']['html'];
				}
			}
			else{
				$content['father']=null;
			}

			// Get Children
			$childrenMatches=$this->Children->find('all',array('conditions'=>array(
				'father_id'=>$id
			)));
			
			if($childrenMatches){
				foreach($childrenMatches as $key=>$childrenMatch){
					$child=$this->Message->read(null,$childrenMatch['Children']['children_id']);
					$content['children'][$key]['id']=$child['Message']['id'];
					$content['children'][$key]['timestamp']=$child['Message']['timestamp'];
					
					$jammeur=$this->Jammeur->read(null,$child['Message']['jammeur_id']);
					$content['children'][$key]['jammeur']=$jammeur['Jammeur']['name'];
					
					if(strlen($child['Message']['html'])>30){
						$content['children'][$key]['html']=substr($child['Message']['html'],0,30)."...";
					}
					else{
						$content['children'][$key]['html']=$child['Message']['html'];
					}
				}
			}
			else{
				$content['children'][0]=null;
			}
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
				'father_html'=>array('start'=>'<td>','stop'=>'</td>')
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
				$message=$this->Message->save($message);
				
				
				//SET KEYWORDS
				$keywords=$this->Keyword->find('list');
				foreach ($keywords as $key => $keyword) {
					if (strpos($message['html'],$keyword) !== false) {
					    $match=$this->KeywordsMessage->create();
						$match['KeywordsMessage']['message_id']=$message['Message']['id'];
						$match['KeywordsMessage']['keyword_id']=$key;
						$this->KeywordsMessage->save($match);
					}
				}
				
				//SET FATHER
				if(!is_null($message['father_html'])){
					$father=$this->Message->find('first',array('conditions'=>array(
						'Message.html'=>$message['father_html'],
						'DATEDIFF(day, DATE(Message.timestamp), DATE('.$message['Message']['timestamp'].')) < '=>  5
					)));

					if($father){
						$children=$this->Children->create();
						$children['Children']['father_id']=$father['Message']['id'];
						$children['Children']['children_id']=$message['Message']['id'];
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