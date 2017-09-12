# EmulLib

## Overview 
EmulLib is PHP and Python languages based library that has been developed to provide bare-metal based malware analysis environment for an analyst, developer, etc.  
EmulLib focus on utilized by anyone that needs a bare-metal based environment for analyzing malware as free.  
Our system's main resource is Emulab on KREONNET EMULAB shown at "https://www.emulab.kreonet.net/".  

## Usage per languages
### Python 
#### Module importing 
	import MASE 
	
#### Session creating function 
This "Session" function returns session id that will be used to an argument of requesting analysis, if an inputted argument is sure as the available account.  

	MASE.Session(id="user", pw="passwd")
	
#### Analysis requesting function  
This "Analyze" function requires argument data shown in below.  
A session argument must be an issued id depend on "Session" function.  
	
	MASE.Analyze(session="sessionid",proj="PROJECTNAME",reboot="YESorNo", report="YESorNo", filedump="YESorNo", trafficdump="YESorNo", uploaded_filepath="filepath+filename") 

#### Session's list providing function 
This "sessionlist" function returns a list of a session id that a user has.  

	MASE.Sessionlist(id="user", pw="passwd") 
	
#### Progress rate providing function
This "Progress" function returns progress rate of analysis according to a session id.  

	MASE.Progress("Sessionid") 
	
#### Result downloading function
This "ResultDownload" function download an analyzed files if the analysis has been completed.  

	MASE.ResultDownload(session="Sessionid", path="Downloadpath") 
