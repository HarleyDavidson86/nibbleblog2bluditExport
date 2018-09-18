# nibbleblog2bluditExport
This exporter tranforms all your Nibbleblog posts, pages and images to Bludit format.

Preparations:

For better handling I suggest to download the complete Nibbleblog page and run on a 
local webserver (but it works also online, of course). Download the complete zip-File 
and create a new directory called "bluditExport" at [nibbleblog-root-directory]\themes
and copy all files of the exporter in this new directory. Then activate the theme in 
your Nibbleblod-Administration-Panel. After this visit your Blog for further instructions.

## Starting position
I tested the complete process with Nibbleblog 4.0.5 and Bludit Version 1.5.2

This exporter creates Bludit-readable content of all pages and posts and copies all
media in a well-structured zip-file, which you only have to paste into Bludit at the end.


### Step 1
Get the current version of the exporter here at github by clicking the green button 
"Clone or Download" >> "Download ZIP".

### Step 2
Unzip the whole package in the sub-directory "themes" in your Nibbleblog installation.
Entpackt das ZIP-File im Unterordner "themes" der Nibbleblog Installation.

Then log in to the admin area of Nibbleblog.

### Step 3

Enter the "Designs" section and install and activate "bluditExport".

Now do **not** log off and visit the blog (by clickling on "View Blog").
This tools is looking for an active admin-session.

Now just scroll down an click on "START EXPORT!".
After this you get a list of exported files and content.
This procedure may take some time, depending on the speed of the server and the size of the blog.
In the end, be sure to scroll to the bottom of the page and download the export.zip via the button.

### Step 4
You've downloaded the file "bluditExport.zip" successfully!
In this zip you will find a pre-structured directory named "bl-content",
ready to be placed into a bludit-installation.

But if you go to your Bludit homepage now, you will disappointingly see nothing has been done here!

That's because you have to activate the CLI mode once.
This command-line mode used to be accessible via the administration interface
of Bludit, now it must be done by hand in a PHP file.

### Step 5
Open the following file 
```
[bludit-root-directory]/bl-kernel/boot/init.php
```

In Bludit 1.5.2 the switch for the CLI mode can be found right in line 94:

```
// Cli mode status for new posts/pages
define('CLI_MODE', false);
```

Change this value "false" to "true" and save this file.

Now open the file
```
[bludit-root-directory]\bl-kernel\boot\rules\70.posts.php
```

and change the following line
```
if( CLI_MODE && false) {
```
to
```
if( CLI_MODE ) {
```

Now you can open your Bludit Blog and you will see that your content is now visible!

At this point you can revert the changes in the two files above if you want.

That's it. You successfully exported your Nibbleblog Content to Bludit!

## What else needs to be done now?
Now you have transferred all your pages and posts into the new CMS. Check it out for safety's sake.
Bludit saves content in [Markdown-Language](https://de.wikipedia.org/wiki/Markdown). 
Furthermore, the good old HTML still works, which was used in Nibbleblog.

## Broken links?
Nibbleblog always created his pretty URLs with a slash "/" at the end.
However, Bludit does not recognize them and forwards the visitor to a 404 page.
To solve this problem, you need to make a change to the .htaccess file.
Just after the line "RewriteEngine on", insert the following lines:

```
//Allow the following rule if "REQUEST_FILENAME" is not an existing directory on the web server
RewriteCond %{REQUEST_FILENAME} !-d 
//Allow the following rule when "REQUEST_URI" ends with a slash "/"
RewriteCond %{REQUEST_URI} (.+)/$
//Take over the requested URI without the slash.
//%1 is here the first group of the regular expression (. +) /, The part in parentheses
RewriteRule ^ %1 [R=301,L]
```

Now you add the following two lines just before the closing bracket "</ IfModule>":
```
RedirectMatch 301 /tag/(.*)/ <Eure-Domain>/tag/$1
RedirectMatch 301 /page/(.*)/ <Eure-Domain>/$1
```

Now your links are working again in your new Bludit-CMS!