<?php 
$info = "<p>";
foreach($posts as $post) 
{
	//Create subdir for post
	mkdir(PATH_EXPORT_POSTS.'/'.$post['slug'].'/') or die ('Could not create folder in '.PATH_EXPORT_POSTS);
	$path_to_file = PATH_EXPORT_POSTS.'/'.$post['slug'].'/index.txt';

	//Create and open file
	$file = fopen($path_to_file, 'w');

	//Titel
	fwrite($file, 'Title: '.$post['title'].PHP_EOL);

	//Description
	fwrite($file, 'Description: '.$post['description'].PHP_EOL);

	//Tags
	$temp = 'Tags: ';
	foreach($post['tags'] as $tag) {
		$temp .= $tag['name_human'].',';
	}
	fwrite($file, substr($temp, 0, -1).PHP_EOL);

	//Kommentare erlaubt
	fwrite($file, 'AllowComments: '.(($post['allow_comments'] == 1) ? 'True' : 'False').PHP_EOL);

	//Status
	fwrite($file, 'Status: published'.PHP_EOL);

	//Datum
	fwrite($file, 'Date: '.date("Y-m-d H:i:s", $post['pub_date_unix']).PHP_EOL);

	//Username
	fwrite($file, 'Username: admin'.PHP_EOL);

	//Author
	fwrite($file, 'Author: Dominik Sust'.PHP_EOL);

	//Inhalt
	//Imagelinks ersetzen
	$content = $post['content'][0];
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
		//remove p Tags in link and pagebreak
		$content = str_replace("<p>".$bluditImgLink."</p>", $bluditImgLink, $content, $count);
		$content = str_replace("<p><!-- pagebreak --></p>", "<!-- pagebreak -->", $content, $count);
	} 
	fwrite($file, 'Content: '.PHP_EOL.$content);

	//Close File
	fclose($file);

	$info .= 'File written: "'.$path_to_file.'"<br>';
}
echo $info.'</p>';
?>
