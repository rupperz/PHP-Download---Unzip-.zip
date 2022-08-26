<?php

$url = "RemoteUrlZipFile"; // URL of what you wan to download
$zipFile = "newNameZipFile"; // Rename .zip file
$extractDir = "folderName_where_unzip"; // Name of the directory where files are extracted


function downloadAndUnzip($url, $zipFile, $extractDir){
	$zipResource = fopen($zipFile, "w");
	// Get The Zip File From Server
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_FILE, $zipResource);

	$page = curl_exec($ch);

	if(!$page) {
		echo "Error :- ".curl_error($ch);
	}

	curl_close($ch);

	/* Open the Zip file */
	$zip = new ZipArchive;
	$extractPath = $extractDir;

	if($zip->open($zipFile) != "true"){
		return "Error :- Unable to open the Zip File";
	} 

	/* Extract Zip File */
	$zip->extractTo($extractPath);
	$zip->close();

	return "Your file was downloaded to $zipFile and extracted to dir $extractDir/, go check.";
}

echo downloadAndUnzip($url, $zipFile, $extractDir);
?>