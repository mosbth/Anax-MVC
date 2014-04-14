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

##KMOM02

Jag började med att installera Composer. Inga större problem mer än att jag är lite noob på Linux. Men fick löst de efter lite hjälp på labben. När jag väl hade fått ner Composer och installerat det så visade det sig att Mos hade gjort en uppdatering i <code>CDIFactoryDefault</code>. Så jag forkade <code>mosbth/Anax-mvc</code> och tog hem det på min dator. Lade in *kmom01* som en ny webroot och tagga de som "kmom01" på git. Skapade en ny webroot med namnet *kmom02* som är en kopia på kmom01 och så va de frid och fröjd.    
Hade lite problem med att förstå hur allting hängde ihop, hur allt kallas, vilka funktioner som kallas och så vidare. Men med lite diskussion mellan mig, Henrik och Kalle så fick vi nog ihop det. 
Gillar starkt Composer och Packagist. Riktigt smidig att hämta paket och plugins via det. Hittade bland annat Twig där som jag har tänkt att använda senare som "View-controller". När vi kommer till <code>php-mvc/comment </code> så fick jag lägga till en del funtioner där för att de skulle fungera. Några av funtionerna: <code>editAction</code>, som körs när doEdit är klickad, <code>saveAction</code> som körs när man ska spara den nya editerade informationen. Börjar greppa hur model-view-controller kommunicerar nu. Riktig lärolikt kursmomänt. Dock förstår jag inte riktigt varför vi inte använde en databas istället för session?



