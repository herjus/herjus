<?php 

if (isset($_GET['file']))
{
	$fileName = $_GET['file'];
	$filePath = '../files/'.$fileName;

	echo $fileName .'<br>';
	echo $filePath .'<br>';
	

	
	if (file_exists($filePath) && is_readable($filePath) && $fileName == "CV-herjus.pdf")
	{
		header('Content-Type: application/pdf');
		header("Content-Disposition: attachment; filename=\"$fileName\"");
		readfile($filePath);
	}
	else
	{
		echo '<br>';
		if(!preg_match('/\.pdf$/',$filePath)) echo "file not .pdf".'<br>';
		if($fileName != "CV-herjus.pdf") echo "file not CV-herjus.pdf".'<br>';
		if (!is_readable($filePath)) echo "file not readable".'<br>';
		if (!file_exists($filePath)) echo "404 file not found".'<br>';
		echo " <br> failed to dl";
	}
}
