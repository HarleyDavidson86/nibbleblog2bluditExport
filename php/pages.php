<?php 
$info = "<p>";
$pages = $_DB_PAGES->get_all();
foreach($pages as $page) 
{
	//Create subdir for page
	mkdir(PATH_EXPORT_PAGES.'/'.$page['slug'].'/') or die ('Could not create folder in '.PATH_EXPORT_PAGES);
	$path_to_file = PATH_EXPORT_PAGES.'/'.$page['slug'].'/index.txt';

	//Create and open file
	$file = fopen($path_to_file, 'w');

	//Titel
	fwrite($file, 'Title: '.$page['title'].PHP_EOL);

	//Description
	fwrite($file, 'Description: '.$page['description'].PHP_EOL);

	//Keywords
	fwrite($file, 'Tags: '.$page['keywords'].PHP_EOL);

	//Status
	fwrite($file, 'Status: published'.PHP_EOL);

	//Datum
	fwrite($file, 'Date: '.date("Y-m-d H:i:s", $page['pub_date_unix']).PHP_EOL);

	//Inhalt
	$content = $page['content'];
	//get all image links
	preg_match_all('/<img[^>]+>/i', $content, $imgarray);
	foreach ($imgarray[0] as $link) {
		//get the filename
		$filename = substr(strstr($link, 'src="/'), 6);
		$filename = strstr($filename, '"', true);
		$filename = substr($filename, strrpos($filename, '/')+1);

		//get the alt text
		$alt_text = substr(strstr($link, 'alt="'), 5);
		$alt_text = strstr($alt_text, '"', true);

		//Build bludit image link
		//![alt text](02.jpg)
		$bluditImgLink = '!['.$alt_text.']('.$filename.')';
		$content = str_replace($link, $bluditImgLink, $content, $count);
		//remove p Tags 
		$content = str_replace("<p>".$bluditImgLink."</p>", $bluditImgLink, $content, $count);
	} 
	fwrite($file, 'Content: '.PHP_EOL.$content);

	//Close File
	fclose($file);

	$info .= 'File written: "'.$path_to_file.'"<br>';
}
echo $info.'</p>';
?>
