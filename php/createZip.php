<?php

$zip = new ZipArchive();
if ($zip->open(PATH_EXPORT.'/bluditExport.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
die ("Could not open ZIP Archive");
}

//Recursive directory iterator
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PATH_EXPORT_CONTENT), RecursiveIteratorIterator::LEAVES_ONLY);
foreach ($files as $name => $file) {
	//Skip directories (added automatically)
	if (!$file->isDir()) {
		$filePath = $file->getRealPath();
		$relativePath = substr($filePath, strpos($filePath, 'bl-content'));

		//Add to archive
		$zip->addFile($filePath, $relativePath);
	}
}
$zip->close();
echo '<p>Zip created: '.PATH_EXPORT.'/bluditExport.zip</p>';


?>
