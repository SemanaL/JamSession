<?php
App::uses('AppController', 'Controller');

class MessagesController extends AppController{		
	var $uses = array('Message','Jammeur','Keyword','KeywordsMessage','Children');
	var $components = array();

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
			
			$messages=$this->Message->find('all', array('conditions'=>$conditions,'order'=>'Message.timestamp DESC LIMIT 20'));
			

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
		
		$jammeurs=$this->Jammeur->find('all');
		foreach ($jammeurs as $jammeur) {
			$addresses[]=$jammeur['Jammeur']['email'];
		}
		
		$mails=array_diff(scandir($current_path), array('..', '.'));
		foreach($mails as $mail){		
			$content=file_get_contents($current_path.$mail);
			if(!is_null($content)){
				
				$translator=array(
					//CHR(10)=>'',
					//CHR(13)=>'',
					'>'=>'',
					'  '=>' ',
				);	
							
				$startPosition= 0;
				$startLength = 0;
				$stopPosition = 0;
				$stopLength = 0;
				
				// WARNING : ENTER DATA IN THE APPEARANCE ORDER IN THE MAIL

				// Get email
				$startLength=strlen('Return-Path: <');
				$startPosition=stripos($content,'Return-Path: <',$stopPosition);
				$stopPosition=stripos($content,'>',$startPosition);

				$tmpMessage['email']=trim(strip_tags(substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition)));
				
			
				// Get Date and Time
				$startLength=strlen('Date: ');
				$startPosition=stripos($content,'Date: ',$stopPosition);
				$stopPosition=stripos($content,'Message-ID',$startPosition);

				$tmpMessage['dateTime']=trim(strip_tags(substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition)));
				$tmpMessage['dateTime']=date("Y-m-d H:i:s",strtotime($tmpMessage['dateTime']));
				

				// Get HTML
				
				$startLength=strlen('quoted-printable');
				$startPosition=stripos($content,'quoted-printable',$stopPosition);
				$tmpStopPosition=strlen($content);
					foreach ($addresses as $address) {
						if (stripos($content,$address,$startPosition)<$tmpStopPosition){
							$tmpStopPosition=stripos($content,$address,$startPosition);
						}
					}
				$subContent=substr($content,0,$tmpStopPosition);
				$stopPosition=strrpos($subContent,CHR(10));
				$tmpMessage['html']=trim(substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition));
				
				foreach ($translator as $word=>$translation) {
					$tmpMessage['html']=str_replace($word, $translation, $tmpMessage['html']);
				}
				
				
				
				if ($stopPosition!=strlen($content)) {
					// Get Father HTML

					$GmailStartPosition=stripos($content,'crit :',$stopPosition);
					$OutlookStartPosition=stripos($content,'JAM SESSION',$stopPosition);
					
					if($GmailStartPosition<$OutlookStartPosition){
						$startLength=strlen('crit :');	
						$startPosition=$GmailStartPosition;
					}
					else{
						$startLength=strlen('JAM SESSION');	
						$startPosition=$OutlookStartPosition;
					}

					$tmpStopPosition=strlen($content);
					foreach ($addresses as $address) {
						if (stripos($content,$address,$startPosition)<$tmpStopPosition){
							$tmpStopPosition=stripos($content,$address,$startPosition);
						}
					}
					$subContent=substr($content,0,$tmpStopPosition);
					$stopPosition=strrpos($subContent,CHR(10));
					$tmpMessage['father_html']=substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition);
					
					foreach ($translator as $word=>$translation) {
						$tmpMessage['father_html']=str_replace($word, $translation, $tmpMessage['father_html']);
					}
					$tmpMessage['father_html']=trim($tmpMessage['father_html']);
				}
				else {
					$tmpMessage['father_html']=null;
				}
				
				var_dump($tmpMessage);

				//ENTER MESSAGE IN DB
				$message=$this->Message->create();
				$jammeur=$this->Jammeur->findByEmail($tmpMessage['email']);
				$message['Message']['jammeur_id']=$jammeur['Jammeur']['id'];
				$message['Message']['timestamp']=$tmpMessage['dateTime']; // DO SOME CHANGES, PROBABLY
				$message['Message']['html']=$tmpMessage['html'];
				$message=$this->Message->save($message);
				
				
				//SET KEYWORDS
				$keywords=$this->Keyword->find('list');
				foreach ($keywords as $key => $keyword) {
					if (strpos($tmpMessage['html'],$keyword) !== false) {
					    $match=$this->KeywordsMessage->create();
						$match['KeywordsMessage']['message_id']=$message['Message']['id'];
						$match['KeywordsMessage']['keyword_id']=$key;
						$this->KeywordsMessage->save($match);
					}
				}
				
				//SET FATHER
				if(!is_null($tmpMessage['father_html'])){
					$father=$this->Message->find('first',array('conditions'=>array(
						'Message.html'=>$tmpMessage['father_html'],
						//'DATEDIFF(day, DATE(Message.timestamp), DATE('.$message['Message']['timestamp'].')) < '=>  30
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
			//rename($current_path.$mail, $new_path.$mail);
		}
		
	}
}
?>