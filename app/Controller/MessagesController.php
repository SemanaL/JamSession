<?php
App::uses('AppController', 'Controller');

class MessagesController extends AppController{		
	var $uses = array('Message','Jammeur','Keyword','KeywordsMessage','Father');
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
			$fatherMatch=$this->Father->find('first',array('conditions'=>array(
				'children_id'=>$id
			)));
			
			if($fatherMatch) {
				$father=$this->Message->read(null,$fatherMatch['Father']['father_id']);
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
			$childrenMatches=$this->Father->find('all',array('conditions'=>array(
				'father_id'=>$id
			)));
			
			if($childrenMatches){
				foreach($childrenMatches as $key=>$childrenMatch){
					$child=$this->Message->read(null,$childrenMatch['Father']['children_id']);
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

	function automaticImport(){
		$current_path='C:/xampp/htdocs/github/jamsession/mails/new/';
		//$current_path='/home/import/Maildir/new/';
		$jammeurs=$this->Jammeur->find('all');
				
		foreach ($jammeurs as $jammeur) {
			foreach ($jammeur['Email'] as $email) {
				$addresses[]=$email['email'];	
			}
		}

		
		$mails=array_diff(scandir($current_path), array('..', '.'));
		foreach($mails as $mail){		
			$content=file_get_contents($current_path.$mail);
			if(!is_null($content)){
				$translator=array(
					'>'=>'',
					'  '=>' ',
					'='=>'',
					'E7'=>'ç',
					'E9'=>'é',
					'09'=>CHR(10),
					'20'=>CHR(13)
				);	
							

				$end=strlen($content);

				// Get email - Just pick the first known email to appear
				
				$startPosition=$end;	
				$tmpMessage['email']="";
				foreach ($addresses as $address) { 
					if (stripos($content,$address,0) > 0 && stripos($content,$address,0)<$startPosition){
						$startPosition=stripos($content,$address,0);	
						$tmpMessage['email']=$address;
					}
				}
				$stopPosition=$startPosition+strlen($tmpMessage['email']);
			
				/********************************************************************************/
				
				// Get Date and Time
				
				//Start Parse			
				$startLength=strlen('Date: ');
				$startPosition=stripos($content,'Date: ',0);
				
				//End Parse
				$endTags=array('MIME','Message-ID','From:');
				
				$stopPosition=$end;
				foreach ($endTags as $endTag) {
					if(stripos($content,$endTag,$startPosition)>0 && stripos($content,$endTag,$startPosition)<$stopPosition){
						$stopLength=strlen($endTag);
						$stopPosition=stripos($content,$endTag,$startPosition);
					}
				}
				
				//Build DateTime
				$tmpMessage['dateTime']=trim(strip_tags(substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition)));
				$tmpMessage['dateTime']=date("Y-m-d H:i:s",strtotime($tmpMessage['dateTime']));
				
				/********************************************************************************/

				// Get HTML

				//Start Parse
				$startTags=array('quoted-printable',' quoted-printable
Content-Disposition: inline');
				
				$startPosition=$end;
				foreach ($startTags as $startTag) {
					if(stripos($content,$startTag,$stopPosition)>0 && stripos($content,$startTag,$stopPosition)<$startPosition){
						$startLength=strlen($startTag);
						$startPosition=stripos($content,$startTag,$stopPosition);
					}
				}
				
				//End Parse
				
				$stopPosition=$end;
				foreach ($addresses as $address) {  // Gmail Parsing
					if (stripos($content,$address."> a =E9",$startPosition) > 0 && stripos($content,$address."> a =E9",$startPosition)<$stopPosition){
						$stopLength=strlen($endTag);	
						$stopPosition=stripos($content,$address."> a =E9",$startPosition);
					}
				}
				
				//Other Parsing	
				$endTags=array('-Original Message-','__________','----------','From:');
				
				
				foreach ($endTags as $endTag) {
					if(stripos($content,$endTag,$startPosition)>0 && stripos($content,$endTag,$startPosition)<$stopPosition){
						$stopLength=strlen($endTag);
						$stopPosition=stripos($content,$endTag,$startPosition);
					}
				}

				$subContent=substr($content,0,$stopPosition); // Go backward until first line jump
				$stopPosition=strrpos($subContent,CHR(10));
				
				//Build HTML
				$tmpMessage['html']=substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition);
				
				//Clean HTML
				foreach ($translator as $word=>$translation) {
					$tmpMessage['html']=str_replace($word, $translation, $tmpMessage['html']);
				}
				$tmpMessage['html']=trim($tmpMessage['html']);
				
				/********************************************************************************/
				// Get Father HTML
				if ($stopPosition!=strlen($content)) {

					//Start Parse
					$startTags=array('crit :','JAM SESSION');
					
					$startPosition=$end;
					foreach ($startTags as $startTag) {
						if(stripos($content,$startTag,$stopPosition)>0 && stripos($content,$startTag,$stopPosition)<$startPosition){
							$startLength=strlen($startTag);
							$startPosition=stripos($content,$startTag,$stopPosition);
						}
					}
					
					//End Parse
					$stopPosition=$end;
					foreach ($addresses as $address) {  // Gmail Parsing
						if (stripos($content,$address."> a =E9",$startPosition) > 0 && stripos($content,$address."> a =E9",$startPosition)<$stopPosition){
							$stopLength=strlen($endTag);	
							$stopPosition=stripos($content,$address."> a =E9",$startPosition);
						}
					}
					
					//Other Parsing	
					$endTags=array('-Original Message-','__________','----------','From:');
					
					
					foreach ($endTags as $endTag) {
						if(stripos($content,$endTag,$startPosition)>0 && stripos($content,$endTag,$startPosition)<$stopPosition){
							$stopLength=strlen($endTag);
							$stopPosition=stripos($content,$endTag,$startPosition);
						}
					}
					
					$subContent=substr($content,0,$stopPosition); // Go backward until first line jump
					$stopPosition=strrpos($subContent,CHR(10));
					
					//Build HTML
					$tmpMessage['father_html']=substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition);
					
					//Clean HTML
					foreach ($translator as $word=>$translation) {
						$tmpMessage['father_html']=str_replace($word, $translation, $tmpMessage['father_html']);
					}
					$tmpMessage['father_html']=trim($tmpMessage['father_html']);
				}
				else {
					$tmpMessage['father_html']=null;
				}
		
				//ENTER MESSAGE IN DB
				$message=$this->Message->create();
				$jammeur=$this->Jammeur->find('first',array(
						'conditions'=>array('Email.email'=>$tmpMessage['email']
				)));
				$message['Message']['jammeur_id']=$jammeur['Jammeur']['id'];
				$message['Message']['timestamp']=$tmpMessage['dateTime']; // DO SOME CHANGES, PROBABLY
				$message['Message']['html']=$tmpMessage['html'];
				$message=$this->Message->save($message);
				
				
				//SET KEYWORDS
				$keywords=$this->Keyword->find('all');
				foreach ($keywords as $keyword) {
					if (stripos($tmpMessage['html'],$keyword['Keyword']['keyword']) != false) {
					    $match=$this->KeywordsMessage->create();
						$match['KeywordsMessage']['message_id']=$message['Message']['id'];
						$match['KeywordsMessage']['keyword_id']=$keyword['Keyword']['id'];
						$this->KeywordsMessage->save($match);
					}
				}
				
				//SET FATHER
				if(!is_null($tmpMessage['father_html'])){
					$father=$this->Message->find('first',array('conditions'=>array(
						'Message.html LIKE'=>'%'.substr($tmpMessage['father_html'],0,15).'%',
						'DATE(Message.timestamp) < '=>  date('Y-m-d',strtotime($message['Message']['timestamp'])),
						'DATE(Message.timestamp) > '=>  date('Y-m-d',strtotime($message['Message']['timestamp']." -30days"))
					)));
					if($father){
						$children=$this->Father->create();
						$children['Father']['father_id']=$father['Message']['id'];
						$children['Father']['children_id']=$message['Message']['id'];
						$this->Father->save($children);
					}
				}
			
			}
			$new_path='C:/xampp/htdocs/github/jamsession/mails/parsed/';
			//$new_path='/home/import/Maildir/parsed/';
			rename($current_path.$mail, $new_path.$mail);
		}
		
	}
	
	function import($id){
		$this->set('id',$id);			
		$current_path='C:/xampp/htdocs/github/jamsession/mails/new/';
		//$current_path='/home/import/Maildir/new/';
		
		$jammeurs=$this->Jammeur->find('all');			
		foreach ($jammeurs as $jammeur) {
			foreach ($jammeur['Email'] as $email) {
				$addresses[]=$email['email'];	
			}
		}

		$mails=array_diff(scandir($current_path), array('..', '.'));
		$this->set('count',count($mails));
		
		$mail=$mails[2+$id];
		$tmpMessage['filename']=$mail;
		
		$content=file_get_contents($current_path.$mail);
		if(!is_null($content)){
							
				$tmpMessage['mail_html']=$content;
				
				$translator=array(
					'>'=>'',
					'  '=>' ',
					'='=>'',
					'E7'=>'ç',
					'E9'=>'é',
					'09'=>CHR(10),
					'20'=>CHR(13)
				);	
							

				$end=strlen($content);

				// Get email - Just pick the first known email to appear
				
				$startPosition=$end;	
				$tmpMessage['email']="";
				foreach ($addresses as $address) { 
					if (stripos($content,$address,0) > 0 && stripos($content,$address,0)<$startPosition){
						$startPosition=stripos($content,$address,0);	
						$tmpMessage['email']=$address;
					}
				}
				$stopPosition=$startPosition+strlen($tmpMessage['email']);
			
				/********************************************************************************/
				
				// Get Date and Time
				
				//Start Parse			
				$startLength=strlen('Date: ');
				$startPosition=stripos($content,'Date: ',0);
				
				//End Parse
				$endTags=array('MIME','Message-ID','From:');
				
				$stopPosition=$end;
				foreach ($endTags as $endTag) {
					if(stripos($content,$endTag,$startPosition)>0 && stripos($content,$endTag,$startPosition)<$stopPosition){
						$stopLength=strlen($endTag);
						$stopPosition=stripos($content,$endTag,$startPosition);
					}
				}
				
				//Build DateTime
				$tmpMessage['dateTime']=trim(strip_tags(substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition)));
				$tmpMessage['dateTime']=date("Y-m-d H:i:s",strtotime($tmpMessage['dateTime']));
				
				/********************************************************************************/

				// Get HTML

				//Start Parse
				$startTags=array('quoted-printable',' quoted-printable
Content-Disposition: inline');
				
				$startPosition=$end;
				foreach ($startTags as $startTag) {
					if(stripos($content,$startTag,$stopPosition)>0 && stripos($content,$startTag,$stopPosition)<$startPosition){
						$startLength=strlen($startTag);
						$startPosition=stripos($content,$startTag,$stopPosition);
					}
				}
				
				//End Parse
				
				$stopPosition=$end;
				foreach ($addresses as $address) {  // Gmail Parsing
					if (stripos($content,$address."> a =E9",$startPosition) > 0 && stripos($content,$address."> a =E9",$startPosition)<$stopPosition){
						$stopLength=strlen($endTag);	
						$stopPosition=stripos($content,$address."> a =E9",$startPosition);
					}
				}
				
				//Other Parsing	
				$endTags=array('-Original Message-','__________','----------','From:');
				
				
				foreach ($endTags as $endTag) {
					if(stripos($content,$endTag,$startPosition)>0 && stripos($content,$endTag,$startPosition)<$stopPosition){
						$stopLength=strlen($endTag);
						$stopPosition=stripos($content,$endTag,$startPosition);
					}
				}

				$subContent=substr($content,0,$stopPosition); // Go backward until first line jump
				$stopPosition=strrpos($subContent,CHR(10));
				
				//Build HTML
				$tmpMessage['html']=substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition);
				
				//Clean HTML
				foreach ($translator as $word=>$translation) {
					$tmpMessage['html']=str_replace($word, $translation, $tmpMessage['html']);
				}
				$tmpMessage['html']=trim($tmpMessage['html']);
				
				/********************************************************************************/
				// Get Father HTML
				if ($stopPosition!=strlen($content)) {

					//Start Parse
					$startTags=array('crit :','JAM SESSION');
					
					$startPosition=$end;
					foreach ($startTags as $startTag) {
						if(stripos($content,$startTag,$stopPosition)>0 && stripos($content,$startTag,$stopPosition)<$startPosition){
							$startLength=strlen($startTag);
							$startPosition=stripos($content,$startTag,$stopPosition);
						}
					}
					
					//End Parse
					$stopPosition=$end;
					foreach ($addresses as $address) {  // Gmail Parsing
						if (stripos($content,$address."> a =E9",$startPosition) > 0 && stripos($content,$address."> a =E9",$startPosition)<$stopPosition){
							$stopLength=strlen($endTag);	
							$stopPosition=stripos($content,$address."> a =E9",$startPosition);
						}
					}
					
					//Other Parsing	
					$endTags=array('-Original Message-','__________','----------','From:');
					
					
					foreach ($endTags as $endTag) {
						if(stripos($content,$endTag,$startPosition)>0 && stripos($content,$endTag,$startPosition)<$stopPosition){
							$stopLength=strlen($endTag);
							$stopPosition=stripos($content,$endTag,$startPosition);
						}
					}
					
					$subContent=substr($content,0,$stopPosition); // Go backward until first line jump
					$stopPosition=strrpos($subContent,CHR(10));
					
					//Build HTML
					$tmpMessage['father_html']=substr($content,$startLength+$startPosition,$stopPosition-$startLength-$startPosition);
					
					//Clean HTML
					foreach ($translator as $word=>$translation) {
						$tmpMessage['father_html']=str_replace($word, $translation, $tmpMessage['father_html']);
					}
					$tmpMessage['father_html']=trim($tmpMessage['father_html']);
				}
				else {
					$tmpMessage['father_html']=null;
				}

				$tmpMessage['rest_html']=substr($content,$stopPosition,250)."...";
			
			$this->set('tmpMessage',$tmpMessage);
			}

	}

	function manualImportSave(){
		
		$response = false;
		$this->layout = 'ajax';
		if(!empty($this->data)){
		$tmpMessage=json_decode($this->data,true);

		//ENTER MESSAGE IN DB
		$message=$this->Message->create();
		$jammeur=$this->Jammeur->find('first',array(
				'conditions'=>array('Email.email'=>$tmpMessage['email']
		)));		
		$message['Message']['jammeur_id']=$jammeur['Jammeur']['id'];
		$message['Message']['timestamp']=$tmpMessage['dateTime']; 
		$message['Message']['html']=$tmpMessage['html'];
		
		$response=$message=$this->Message->save($message);
		
		
		//SET KEYWORDS
		$keywords=$this->Keyword->find('all');
		foreach ($keywords as $keyword) {
			if (stripos($tmpMessage['html'],$keyword['Keyword']['keyword']) != false) {
			    $match=$this->KeywordsMessage->create();
				$match['KeywordsMessage']['message_id']=$message['Message']['id'];
				$match['KeywordsMessage']['keyword_id']=$keyword['Keyword']['id'];
				$this->KeywordsMessage->save($match);
			}
		}
		
		//SET FATHER
		if(!is_null($tmpMessage['father_html'])){
			$father=$this->Message->find('first',array('conditions'=>array(
				'Message.html LIKE'=>'%'.substr($tmpMessage['father_html'],0,15).'%',
				'DATE(Message.timestamp) < '=>  date('Y-m-d',strtotime($message['Message']['timestamp'])),
				'DATE(Message.timestamp) > '=>  date('Y-m-d',strtotime($message['Message']['timestamp']." -30days"))
			)));
			if($father){
				$children=$this->Father->create();
				$children['Father']['father_id']=$father['Message']['id'];
				$children['Father']['children_id']=$message['Message']['id'];
				$this->Father->save($children);
			}
		}
			$current_path='C:/xampp/htdocs/github/jamsession/mails/new/';
			$new_path='C:/xampp/htdocs/github/jamsession/mails/parsed/';
			//$new_path='/home/import/Maildir/parsed/';
			rename($current_path.$tmpMessage['filename'], $new_path.$tmpMessage['filename']);
		}
		
		echo json_encode($response);
	}
}
?>