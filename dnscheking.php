<?php
/*
#Author:      Ali Sedi        
#Language:    PHP
#Date:        31 August 2014  
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
	return $domainName;
}
function aorptr ($str)
{
	echo "[".$str."] is :";
	$ptr = ".in-addr.arpa";
	if (strpos($str,$ptr) !== false)
	    {
	    	echo " <b>A PTR</b><br>";
//		echo gethostbyaddr($str)."<br>";
	    }
	    else
	    {
	    	echo " <b>A record</b><br>";
	//	echo gethostbyname($str)."<br>";
	    }
}

function getwhoisfromiana($server , $ip)
{
	$data='';
	$f = fsockopen($server , 43 , $errno , $errstr , 3);
	if (!$f)
	{
		return '';
	}
	if(!stream_set_timeout($f,3))
	{
		die('unable to set set_timeout');
	}
	if($f)
	{
		fputs($f,"$iprn")
	}
	
	if(!stream_set_timeout($f,3))
	{
		die('unable to stream_set_timeout');
	}
	stream_set_blocking($f,0);
	if($f)
	{
		while (!feof($f)
		{
			$data .= fread ($f , 128);
		}
	}
	return $data;
}

function get_whois($ip)
{
        $ianawhois= getwhoisfromiana('whois.iana.org',$ip);
        preg_match('@whois.[w.]*@si'.$ianawhois,$data);
        $whois_server=$data[0];
        print $whois_server."<br>";

        $whois_data = getwhoisfromiana($whois_server,$ip);
        return $whois_data;
}




$ourhost = "www.vcn.bc.ca";
$ip= gethostbyname($ourhost);
echo $ip."<br>";
$mytest = get_whois($ip);
print_r $mytest;


echo "reading the file<br>";
$myfile = fopen("named.conf","r")or die ("unable to open the file!");
{	 
	while(!feof($myfile))	
	{	
		$line =  stream_get_line($myfile , 4096,"\n");
		if(preg_match('/^zone/i',$line))
		{
			aorptr(extractDomain($line));						    
		}
	}
	fclose ($myfile);	
}

?>
