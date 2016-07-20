<?php
//Deletes export directory
function rrmdir($dir) {
  $files = array_diff(scandir($dir), array('.','..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? rrmdir("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}


//Delete if exists
rrmdir(PATH_PUBLIC.'export');
//Export Ordner erstellen
mkdir(PATH_PUBLIC.'export/') or die ('Could not create export-folder in '.PATH_PUBLIC);
echo "<p>".PATH_PUBLIC.'export/'."<br>";
mkdir(PATH_PUBLIC.'export/bl-content/') or die ('Could not create content-folder in '.PATH_PUBLIC.'/export/');
echo PATH_PUBLIC.'export/bl-content/'."<br>";
mkdir(PATH_PUBLIC.'export/bl-content/posts/') or die ('Could not create posts-folder in '.PATH_PUBLIC.'/export/bl-content/');
echo PATH_PUBLIC.'export/bl-content/posts/'."<br>";
mkdir(PATH_PUBLIC.'export/bl-content/pages/') or die ('Could not create pages-folder in '.PATH_PUBLIC.'export/bl-content/');
echo PATH_PUBLIC.'export/bl-content/pages/'."<br>";
mkdir(PATH_PUBLIC.'export/bl-content/uploads/') or die ('Could not create uploads-folder in '.PATH_PUBLIC.'export/bl-content/');
echo PATH_PUBLIC.'export/bl-content/uploads/'."<br>";
mkdir(PATH_PUBLIC.'export/bl-content/uploads/thumbnails/') or die ('Could not create thumbnails-folder in '.PATH_PUBLIC.'export/bl-content/uploads/');
echo PATH_PUBLIC.'export/bl-content/uploads/thumbnails/'."</p>";
?>
