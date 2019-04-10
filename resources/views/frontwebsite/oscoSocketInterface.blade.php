<?php
function chkServer($host, $port){ 
	$hostip = @gethostbyname($host); 
	
	if ($hostip == $host){ 
		echo "Server is down or does not exist"; 
	} else { 
		if (!$x = @fsockopen($hostip, $port, $errno, $errstr, 5)){ 
			echo "Port $port is closed."; 
			exit;
		} else { 
			echo "Port $port is open."; 
			if ($x){ 
				@fclose($x); 
			} 
		} 
	} 
}

function getOSCOResults($orderDataXML)
{
	$host    = "osco1.mozula.com";
	$port    = 20046;
	$orderResultsXML = "";
	$addr = gethostbyname($host);
	
	////////////////////////////
	
	//chkServer($host,$port);
	///////////////////////
	
	$client = stream_socket_client("tcp://$addr:$port", $errno, $errorMessage);
	if ($client === false) {
    		$orderResultsXML = ("Error: Failed to connect: $errorMessage");
	}
	else
	{
		$serverReadyMsg =  fgets($client,30);
		if($serverReadyMsg == "")
		{
    			$orderResultsXML = ("Error: Server not ready");
		} 
		else
		{
			fwrite($client, $orderDataXML);
			$orderResultsXML = "";
			while(!feof($client))
			{
				$orderResultsXML .= fgets($client,4048);
			}
		}
		fclose($client);
	}
	return $orderResultsXML;
}
?>
