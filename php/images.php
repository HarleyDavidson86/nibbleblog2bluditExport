<?php
$info = '<p>';
include("image.class.php");
$Image = new ConvertImage();

if ($handle = openDir(PATH_UPLOAD)){
	while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != ".." && strpos($entry, "_thumb.") === false && strpos($entry, "_nbmedia.") === false) {
		//Create thumbnail
		$Image->setImage(PATH_UPLOAD.$entry, 400, 400, 'crop');
		$Image->saveImage(PATH_EXPORT_THUMBNAILS."/".$entry, 100, true);
		$info .= PATH_EXPORT_THUMBNAILS."/".$entry.'<br>';
		//Copy original
		if (!copy(PATH_UPLOAD.$entry, PATH_EXPORT_IMAGES."/".$entry)) {
			echo "Failed to copy ".$entry;
		}
		$info .= PATH_EXPORT_IMAGES."/".$entry.'<br>';
		}
	}
	closedir($handle);
}
echo $info.'</p>';

?>
