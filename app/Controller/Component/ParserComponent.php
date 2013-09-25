<?php

App::uses('CakeEmail', 'Network/Email');

class ParserComponent extends Component{

	function parse($content,$addresses){
		$tmpMessage['mail_html']=$content;

		$translator=array(
					'>'=>'',
					'  '=>' ',
					'='=>'',
					'E0'=>'à',
					'EA'=>'ê',
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
					if (stripos($content,$address." a =E9",$startPosition) > 0 && stripos($content,$address."> a =E9",$startPosition)<$stopPosition){
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
			
			return $tmpMessage;
		}		
}


?>
