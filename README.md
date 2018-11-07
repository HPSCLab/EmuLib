# EmuLib

## Overview 
EmuLib is PHP and Python languages based library that has been developed to provide bare-metal based malware analysis environment for an analyst, developer, etc.  
EmulLib focus on utilized by anyone that needs a bare-metal based environment for analyzing malware as free.  
Our system's main resource is Emulab on KREONET EMULAB shown at "https://www.emulab.kreonet.net/".  

## Usage
### Python 
#### Library importing 
	import EMMA 
	
#### Session creating function 
This "Session" function returns session id that will be used to an argument of requesting analysis if an inputted argument is sure as the available account.  

	EMMA.Session(id="user", pw="passwd")
	
#### Analysis requesting function  
This "Analyze" function requires argument data shown in below.  
A session argument must be an issued id depend on "Session" function.  
	
	EMMA.Analyze(session="sessionid",proj="PROJECTNAME",reboot="YESorNo", report="YESorNo", filedump="YESorNo", trafficdump="YESorNo", uploaded_filepath="filepath+filename") 

#### Session's list providing function 
This "sessionlist" function returns a list of a session id that a user has.  

	EMMA.Sessionlist(id="user", pw="passwd") 
	
#### Progress rate providing function
This "Progress" function returns progress rate of analysis according to a session id.  

	EMMA.Progress("Sessionid") 
	
#### Result downloading function
This "ResultDownload" function download an analyzed files if the analysis has been completed.  

	EMMA.ResultDownload(session="Sessionid", path="Downloadpath") 
	
### PHP
#### Library including  
	include ("EMMA.php"); 
	
#### Instance creating  
	$EMMA_obj = new EMMA; 
	
#### Session creating function 
This "Session" function returns session id that will be used to an argument of requesting analysis if an inputted argument is sure as the available account.
Arguments used to "Session" function same Python language based library's Sesson function. 

	$Sessionid = $EMMA_obj -> Session("user","passwd") 
	
#### Analysis requesting function  
This "Analyze" function requires argument data shown in below.  
A session argument must be an issued id depend on "Session" function.  
The first argument means session's id and second argument means project name a user want.  
The third argument means whether a user wants analysis after rebooting. if this argument value is "Yes" analysis will be progressed after rebooting.  
A fourth argument means notification about analysis through a mail. If this argument value is "Yes", a user will receive a result of analysis through a mail when all analysis progress ended.  
A fifth argument means whether a user wants a result of the file analyzed.  
A sixth argument means whether a user wants a result of the traffic analyzed.  
A seventh argument means a file and file path information a user wanna analyze.  
	
	$Analysis_request = $EMMA_obj->Analyze($Sessionid, "projName", "No", "Yes", "Yes", "Yes", "./test.exe"); 

#### Session's list providing function 
This "sessionlist" function returns a list of a session id that a user has.  

	#Sessionlist = $EMMA_obj -> Sessionlist("user", "passwd"); 
	
#### Progress rate providing function
This "Progress" function returns progress rate of analysis according to a session id.  

	$progressS_rate = $EMMA_obj->Progress("Sessionid"); 
	
#### Result downloading function
This "ResultDownload" function download an analyzed files if the analysis has been completed.  

	$result = $EMMA_obj->ResultDownload("Sessionid","path"); 
