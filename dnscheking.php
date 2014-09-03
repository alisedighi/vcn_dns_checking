<?php
/*
#Author:      Ali Sedi        
#Language:    PHP
#Date:        31 August 2013  
#--------------------------------------------------------------------
#Description: Script reads the named.conf file and and check domains
#             and assosiated dns. 
#Purpose:     Check if all the zone files are using a certain dns
#Input:       A file which is named.conf file   
#Output:      A string that contains a list of domains
#####################################################################
*/
function extractDomain ($str)
{	
	$fLoc = strpos($str,'"')+1;
	$substrLength = strrpos($str,'"')-$fLoc ;
	$domainName = substr($str,$fLoc,$substrLength);
	return "<br>".$domainName."<br>";
}
$ourhost = "www.vcn.bc.ca";
echo gethostbyname($ourhost)."<br>";
echo "reading the file<br>";
$myfile = fopen("named.conf","r")or die ("unable to open the file!");
{	 
	while(!feof($myfile))	
	{	
		$line =  stream_get_line($myfile , 4096,"\n");
		if(preg_match('/^zone/i',$line))
		{
			echo extractDomain($line);					
		}
	}
	fclose ($myfile);	
}

?>
