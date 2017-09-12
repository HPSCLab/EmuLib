<?
class MASE{
	private $url;
	
	function __construct(){
		$this->url = "http://hpsc2.hannam.ac.kr/~ssong/MASE/web/Winterface.php";
	}
	
	public function Connecting(){
		$data = array("test"=>"testing");
		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencoded\r\n"
				//'method' => 'POST',
				//'content' => http_build_query($data)
			)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($this->url, false, $context);
		if ($result == FALSE){
			$returnstring = FALSE;
		}else{
			$returnstring = TRUE;
		}
		return $returnstring;
	} 
	
	public function Downloadaccess($url, $purpose){
		if ($purpose == "File"){
			if ($urlopen = fopen($url, 'r')){
				$content = '';
				while ($line = fgets($urlopen, 1024)){
					$content .= $line; 
				}
				fclose($urlopen);
				return $content; 
			}else{
				return 'Download failed';
			}
		}else if ($purpose == "Pcap"){
			if ($urlopen = fopen($url, 'rb')){
				$content = '';
				while ($line = fgets($urlopen, 1024)){
					$content .= $line; 
				}
				fclose($urlopen);
				return $content; 
			}else{
				return 'Download failed';
			}			
		}else{
			return "Wrong request";
		}
	}
	
	// This public function must be run when before other public function will do any process. 
	// $reqdata argument must be array format.
	public function Sending($reqdata){
		$data = $reqdata;
		$options = array(
			'http' => array(
				//'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'header' => "Accept:text/html,application/xhtml+xml,*/* \r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($this->url,false, $context);
		if ($result == FALSE){
			$returnstring = "Sending fail";
		}else{
			$returnstring = $result;
		}
		return $returnstring;
	}
	
	
	public function Session($id, $pw){
		$CheckConnection = $this->Connecting();
		if ($CheckConnection == TRUE){
			if ($id == NULL || $pw == NULL){
				return "Error:You didn't enter the authentication information";
			}else{
				$encid = base64_encode($id); $encpw = base64_encode($pw); $subject = "Session";
				$data = array("Request"=>$subject, "ID"=>$encid, "PW"=>$encpw);
				$result = $this->Sending($data);
				$result = array("SessionKey"=>$result);
				return $result; // This variable includes session key information.
			}
		}else{
			$result = 'Connecting fail';
			return $result;
		}
	}
	
	public function Sessionlist($id, $pw){
		$CheckConnection = $this->Connecting();
		if ($CheckConnection == TRUE){
			if ($id == NULL || $pw == NULL){
				return "Error:You didn't enter the authentication information";
			}else{
				$encid = base64_encode($id); $encpw = base64_encode($pw); $subject = "Sessionlist";
				$data = array("Request"=>$subject, "ID"=>$encid, "PW"=>$encpw);
				$result = $this->Sending($data);
				$editedString = trim(str_replace("\n","<br/>",$result));
				$return_arr = explode("<br/>",$editedString);
				return $return_arr;//This variable includes session key information.
			}
		}else{
			$result = 'Connecting fail';
			return $result;
		}
	}
	
	public function Progress($session){
		$CheckConnection = $this->Connecting();
		if ($CheckConnection == TRUE){
			if ($session == NULL){
				return "Error:You didn't enter the authentication information";
			}else{
				$payload = array("Request"=>"Status","Session"=>$session);
				$result = $this->Sending($payload);
				return $result;
			}
		}else{
			$result = 'Connecting fail';
			return $result;
		}
	}
	
	public function Argcheck($var1, $var2, $var3, $var4, $var5){
		if ($var1 != "Yes" && $var1 != "No"){
			return "Allowed parameter data is only 'Yes' or 'No'";
		}
		if ($var2 != "Yes" && $var1 != "No"){
			return "Allowed parameter data is only 'Yes' or 'No'";
		}
		if ($var3 != "Yes" && $var1 != "No"){
			return "Allowed parameter data is only 'Yes' or 'No'";
		}
		if ($var4 != "Yes" && $var1 != "No"){
			return "Allowed parameter data is only 'Yes' or 'No'";
		}
		if ($var5 != "Yes" && $var1 != "No"){
			return "Allowed parameter data is only 'Yes' or 'No'";
		}
		return "OK";
	}
	
	public function Analyze($session, $proj, $reboot, $report, $filedump, $registrydump, $trafficdump, $filepath){
		$CheckConnection = $this->Connecting();
		if ($CheckConnection != TRUE){
			$result = 'Connecting fail with MASE Server';
			return $result;
		}
		
		
		if ($session == NULL){
			return 'Error:Session information is null.';
		}
		if ($proj == NULL){
			return 'Error:Proj information is null.';
		}
		
		if ($filedump == "No" && $registrydump == "No" && $trafficdump == "No"){
			return "Analysis options must be selected more than a one";
		}
		
		#file format checking logic. 
		$varcheck = $this->Argcheck($reboot, $report, $filedump, $registrydump, $trafficdump);
		if ($varcheck != "OK"){
			return $varcheck;
		}
		
		// Remove blanks.
		$session = trim($session);
		$proj = trim($proj);
		$reboot = trim($reboot);
		$report = trim($report);
		$filedump = trim($filedump);
		$registrydump = trim($registrydump);
		$trafficdump = trim($trafficdump);
		$filepath = trim($filepath); 
		# End 
		
		$filename = basename(trim($filepath)); // file name extraction. 
		$content = file_get_contents($filepath); // binary of file extraction. 
		$data = array ('Request'=>'Analyze','Session'=>$session,'proj'=>$proj,'reboot'=>$reboot,'report'=>$report,'filedump'=>$filedump,'registrydump'=>$registrydump,
		'trafficdump'=>$trafficdump,'fileinfo'=>$filename,'filecontent'=>$content);  # It generate the array for transporting to the MASE server. 
		$Sending = $this->Sending($data);
		return $Sending;
	}
	
	public function ResultDownload($session, $path){
		
		print "Downloading...";
		$CheckConnection = $this->Connecting();
		if ($CheckConnection == TRUE){
			if ($session == NULL){
				return "Error:You didn't enter the authentication information";
			}else{
				if ($path == NULL){
					$path = getcwd().'/';
				}else{
					if (gettype($path) != "string"){
						$error = "Error: path information must be string format.";
						return $error;
					}else{
						if ($path[strlen($path)] != '/'){
							$path .='/';
						}
					}
				}
				$payload = array("Request"=>"Download","Session"=>$session);
				$downloadpath = $this->Sending($payload);
				if ($downloadpath == "{This project has not been analyzed yet.}"){
					$returnstring = "This project has not been analyzed yet.";
					return $returnstring;
				}else{
					// A string editing logic start. 
					$editing = str_replace('}','',str_replace('{','',$downloadpath));  // String replacing 
					$division = explode(',',$editing); // String division
					$Resultpath = explode('Resultpath:',$division[0])[1]; // It extracts path of the result file which compared dump information before and after file execution.
					$Pcappath = explode('Pcappath:',$division[1])[1];  // It extracts path of the "pcap" file which compared dump information before and after file execution. 
					// The logic end. 
					
					$return_result_arr = array("Analyzed file and registry result" => "", "Analyzed the network traffic result" => "");
					if ($Resultpath == "None"){
						$return_result_arr["Analyzed file and registry result"] = "It wasn't requested";
					}else{
						$Down = $this->Downloadaccess($Resultpath, 'File');
						if ($Down == "Download failed"){
							$return_result_arr["Analyzed file and registry result"] = "Download failed, Donwload path : $Resultpath";
						}else{
							$fp = fopen($path.$session.'.txt', 'w');
							fwrite($fp, $Down);
							fclose($fp);
							$return_result_arr["Analyzed file and registry result"] = "Download Succeeded:$path"."$session"."txt";
						}
					}
					if ($Pcappath == "None"){
						$return_result_arr["Analyzed the network traffic result"] = "It wasn't requested";
					}else{
						$Down = $this->Downloadaccess($Pcappath,'Pcap');
						if ($Down == "Download failed"){
							$return_result_arr["Analyzed the network traffic result"] = "Download failed, Donwload path : $Pcappath";
						}else{
							$fp = fopen($path.$session.'.pcap', 'wb');
							fwrite($fp, $Down);
							fclose($fp);							
							$return_result_arr["Analyzed the network traffic result"] = "Download Succeeded:$path"."$session".".pcap";
						}
					}
					return $return_result_arr;
				}
			}
		}else{
			$result = 'Connecting fail';
			return $result;
		}
	}
}
?>
