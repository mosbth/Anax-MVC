Display sourcecode using `source.php` and `CSource.php`
===========================================

*A filebrowser in PHP.*

This is a set of PHP code which displays the files in a directory and makes them clickable to view its source. The file `source.php` renders a webpage listing all files and folders in current directory by using the code in the class `CSource.php` and the style from `source.css`.

Why? To aid in debugging, send the link of the sourcecode to a fellow programmer who can help you out.

By Mikael Roos, me@mikaelroos.se


Warning!
-------------------------------------------

Use this only in internal and secure environments. There is always security considerations when allowing your visitor to display sourceode like this. It might be secure, but you can never know.



License
-------------------------------------------

Opensource and free software. License according to MIT.



How-To-Do-It
-------------------------------------------

###The quick version

Get the code for `source.php` and save it in a directory. Point your browser to it.


###In depth

See the file `example.php` on how to use it in more detail and with code separated in files. 

The basics are:

1. Include the classfile `CSource.php`.
2. Create a object `$source = new CSource()`.
3. Include the stylesheet `source.css`.
4. Call `$source->View()`.

Like this:

```
<?php 
include('CSource.php');
$source = new CSource();

?><!doctype html>
<html lang='en'>
<meta charset='utf-8' />
<title>View sourceode</title>
<meta name="robots" content="noindex" />
<meta name="robots" content="noarchive" />
<meta name="robots" content="nofollow" />
<link rel='stylesheet' type='text/css' href='source.css'/>
<body>
<h1>View sourcecode</h1>
<p>
The following files exists in this folder. Click to view.
</p>
<?=$source->View()?>
```



History
-------------------------------------------

v1.0.x (latest)

* Fixed the password filter in CSource.php


v1.0.1 (2012-01-21)

* Added warning message in README for security considerations.
* Change in-depth description after comment by johan.
* Added argument 'add_ignore' to add filenames that should be ignored by CSource.
* Added 'add_ignore' as array option together with comment. Easier to read.
* Updated source.php with latest CSource.php


v1.0.0 (2013-07-04)

* Moved to own repository to GitHub.
* Rewrote old `source.php` to `CSource.php`.
* Added example and some documentation.
* Live example at http://dbwebb.se/kod-exempel/display-and-browse-files-using-php/



Older History from source.php
-------------------------------------------

2012-08-06: 
Quick fix to display images in base directory. Worked only in subdirectories.

2012-05-30: 
Added meta tags to remove this page from search engines and avoid ending up in search results.

2011-12-15: 
Changed stylesheet to be compatible with blueprintcss style. Made all dirs clickable when traversing down a dir-chain.

2011-05-31: 
The update 2011-04-13 which supported follow symlinks has security issues. The follow of symlinks, where destination path (realpath) is not below $BASEPATH, is disabled.

2011-04-13: 
Improved support for including source.php in another context where header and footer is already set. Added $sourceSubDir, $sourceBaseUrl. Source.php can now display a subdirectory and will work where the directory structure contains symbolic links. Changed all variable names to  isolate them. It's soon time to rewrite the whole code to version 2 of source.php...

2011-04-01: 
Added detection of line-endings, Unix-style (LF) or Windows-style (CRLF).

2011-03-31: 
Feature to try and detect chacter encoding of file by using mb_detect_encoding (if available) and by looking for UTF-8 BOM sequence in the start of the file. $encoding is set to contain the found encoding.

2011-02-21: 
Can now have same link to subdirs, independently on host os. Links that contain / or \ is converted to DIRECTORY_SEPARATOR.

2011-02-04: 
Can now link to #file to start from filename.

2011-01-26: 
Added $sourceBasedir which makes it possible to set which basedir to use. This makes it possible to store source.php in another place. It does not need to be in the same directory it displays. Use it like this (before including source.php):
```
$sourceBasedir=dirname(__FILE__);
```

2011-01-20: 
Can be included and integrated in an existing website where you already have a header and footer. Do like this in another file:

```
$sourceNoEcho=true;
include("source.php");
echo "<html><head><style type='text/css'>$sourceStyle</style></header>";
echo "<body>$sourceBody</body></html>";
```

2010-09-14: 
Thanks to Rocky. Corrected NOTICE when files had no extension.

2010-09-09: 
Changed error_reporting to from E_ALL to -1.
Display images of certain types, configurable option $IMAGES.
Enabled display option of SVG-graphics.

2010-09-07: 
Added replacement of \t with spaces as configurable option ($SPACES).
Removed .htaccess-files. Do not show them.

2010-04-27: 
Hide password even in config.php~.
Added rownumbers and enabled linking to specific row-number.


-------------------------------------------
 .  
..:

Copyright (c) 2010 - 2013 Mikael Roos

