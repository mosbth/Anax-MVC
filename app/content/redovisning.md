Redovisningar
===================

##KMOM01

Detta kursmomentet var alldeles lagom svårt att börja med. Då jag inte har någon erfarenhet av ramverk tidigare så hade jag lite svårt att greppa hur man skulle lägga upp sin frontcontroller. Men efter att ha läst om Mos artikel om Anax-mvc en gång till så fick jag till det. 
Hade lite problem med CUrl::URL_CLEAN, men var med på labben och då visade det sig att Mos hade missat att de skulle vara
```
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
```
Men rättade snabbt till de och så funkade de klockrent.   
Tyckte det var intressant med namespaces också. Tycker de verkar va ett smidigt sätt att hålla variablar på sina ställe. Det var också riktigt smidig när man skulle ansluta ett annat projekt till detta projeket. 
Jag kallade bara på Anax->addNamespace() och så va de fixat! Smidigt.
```
call_user_func(function() {
    $loader = new \Anax\Loader\CPsr4Autoloader();
    $loader->addNameSpace('Anax', ANAX_INSTALL_PATH . 'src')
           ->addNameSpace('', ANAX_APP_PATH . 'src')
           ->addNameSpace('Michelf', ANAX_INSTALL_PATH . '3pp/php-markdown/Michelf')
           ->register();
});
```
###Min utvecklingsmiljö

När jag är hemma sitter jag på windows 7. Använder SublimeText 2 som editor och SFTP-client. Tycker verkligen om Sublimetext, riktigt bra editor.   
När jag är på andra ställen än hemma så använder jag min lapptop där jag kör Xubuntu och även där kör jag Sublimetext som editor och SFTP-client.



