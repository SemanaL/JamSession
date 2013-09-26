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
					'E7'=>'ç',
					'E9'=>'é',
					'E8'=>'è',
					'F9'=>'ù',
					'EA'=>'ê',
					'92'=>'\'',
					'93'=>'\'',
					'94'=>'\'',
					'09'=>CHR(10),
					'20'=>CHR(13),
					'bgcolor"#ffffff"'=>'',
					'bgcolor"#FFFFFF"'=>'',
					'text"#000000"'=>'',
					'Content-Disposition: inline'=>'',
					'Content-Type: text/plain;'=>'',
					'charsetutf-8'=>'',
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
				$endTags=array('X-MIME','X-Mailer','MIME','Message-ID','From:','To:');
				
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
				
				$currentTag="";
				$startTags=array('0'=>'Content-Transfer-Encoding: base64','1'=>'Content-Transfer-Encoding: quoted-printable','2'=>'<body');
					$startPosition=$end;
					foreach ($startTags as $key=>$startTag) {
						if(stripos($content,$startTag,$stopPosition)>0 && stripos($content,$startTag,$stopPosition)<$startPosition){
							$currentTag=$key;	
							$startLength=strlen($startTag);
							$startPosition=stripos($content,$startTag,$stopPosition);
						}
					}
					
				if ($currentTag=='0') {
					$code64 = substr($content,stripos($content,"Content-Transfer-Encoding: base64",$stopPosition)+strlen("Content-Transfer-Encoding: base64"));
					
					// Following part strips non-alphanumeric characters after Base 64
					preg_match("/[^a-zA-Z0-9\s]/", $code64, $match, PREG_OFFSET_CAPTURE);
					$index=$match[0][1];
					$content= base64_decode(substr($code64,0,$index));	
					
					$end=strlen($content);
					$stopPosition=0;
					$startLength=0;
					$startPosition=0;
				}
							
				//End Parse
				
				// Gmail Parsing
				$stopPosition=$end;
				foreach ($addresses as $address) {  
					if (stripos($content,"<".$address,$startPosition) > 0 && stripos($content,"<".$address,$startPosition)<$stopPosition){
						$stopLength=strlen($endTag);	
						$stopPosition=stripos($content,"<".$address,$startPosition);
					}
				}
				
				//Other Parsing	
				$endTags=array('-Original Message-','__________','----------','From:','mailto:');
				
				
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
				$tmpMessage['html']=trim(strip_tags($tmpMessage['html']));
												
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
						if (stripos($content,"<".$address,$startPosition) > 0 && stripos($content,"<".$address,$startPosition)<$stopPosition){
							$stopLength=strlen($endTag);	
							$stopPosition=stripos($content,"<".$address,$startPosition);
						}
					}
					
					//Other Parsing	
					$endTags=array('-Original Message-','__________','----------','From:','mailto:');
					
					
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
					$tmpMessage['father_html']=trim(strip_tags($tmpMessage['father_html']));
				}
				else {
					$tmpMessage['father_html']="";
				}
				$tmpMessage['rest_html']=substr($content,$stopPosition,250)."...";
			
			return $tmpMessage;
		}		
}


?>
