/*
 * DetectOffline Web Worker
 */

//TEST CONNECTION FUNCTION DEFINITION
function testConn(){
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4){if(xmlhttp.status==200){postMessage("CONNECTED");}else{postMessage("OFFLINE");}}}
    xmlhttp.open("GET","/bin/detectoffline/heartbeat.servlet.php",true);
    xmlhttp.send();
}

//EXECUTE RUNTIME FUNCTION DEFINITION
function exeRuntime(doFunction){if(doFunction=="TEST_CONN"){testConn();setInterval(function(){testConn();},10000);}}

//HANDLE INBOUND MESSAGES FROM MAIN SCRIPT
self.onmessage=function(e){exeRuntime(e.data);};