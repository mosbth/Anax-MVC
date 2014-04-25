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

Jag började med att installera Composer. Inga större problem mer än att jag är lite noob på Linux. Men fick löst de efter lite hjälp på labben. När jag väl hade fått ner Composer och installerat det så visade det sig att Mos hade gjort en uppdatering i <code>CDIFactoryDefault</code>. Så jag forkade <code>mosbth/Anax-mvc</code> och tog hem det på min dator. Lade in *kmom01* som en ny webroot och tagga de som "*kmom01*" på git. Skapade en ny webroot med namnet *kmom02* som är en kopia på *kmom01* och så va de frid och fröjd.
Hade lite problem med att förstå hur allting hängde ihop, hur allt kallas, vilka funktioner som kallas och så vidare. Men med lite diskussion mellan mig, Henrik och Kalle så fick vi nog ihop det.
Gillar starkt Composer och Packagist. Riktigt smidig att hämta paket och plugins via det. Hittade bland annat Twig där som jag har tänkt att använda senare som "View-controller". När vi kommer till <code>php-mvc/comment </code> så fick jag lägga till en del funtioner där för att de skulle fungera. Några av funtionerna: <code>editAction</code>, som körs när doEdit är klickad, <code>saveAction</code> som körs när man ska spara den nya editerade informationen. Börjar greppa hur model-view-controller kommunicerar nu. Riktig lärolikt kursmomänt. Dock förstår jag inte riktigt varför vi inte använde en databas istället för session?


##KMOM03

Tyckte det var fult med att ha ett "php-biblotek" i [codi]webroot/css/anax-grid/lesscphp[/codi] så jag tänkte att jag skulle flytta ut dessa filerna till någon annan map. Mappen blev [codi]3pp/lessphp[/codi].

Jag började med att flytta ut Lessc-klasserna till [codi]3pp/lessphp/[/codi]  där efter la jag till ett [codi]namespace[/codi] i filen [codi]lessc.php[/codi]
Sen fixade jag så att Anax-Mvc loadade klasserna:
[code]call_user_func(function() {
    $loader = new \Anax\Loader\CPsr4Autoloader();
    $loader->addNameSpace('Anax', ANAX_INSTALL_PATH . 'src')
           ->addNameSpace('', ANAX_APP_PATH . 'src')
           ->addNameSpace('Michelf', ANAX_INSTALL_PATH . '3pp/php-markdown/Michelf')
           // Denna raden fixar de
           ->addNamespace('Lessc', ANAX_INSTALL_PATH . '3pp/lessphp')
           ->register();
});
[/code]
Där efter flyttade jag ut samtliga .less-filer till theme/anax-grid/css.
Dock [b]inte[/b] [codi]Style.php[/codi] eller [codi]style_config.php[/codi]

Där efter redigerade jag [codi]style_config.php[/codi] och la in en funktion som letar upp vägen till temat.
Temas sätt i [codi]config/theme.php.[/codi]
[code]'settings' => [
        'path' => ANAX_INSTALL_PATH . 'theme/',
        'name' => 'anax-grid',
    ],
[/code]
Här är funktionen som hämtar ut temats sökväg:
[code]
 'style_file' => function() use ($app) {
        $settings = $app->theme->getVariable('settings');
        $path = $settings['path'];
        $name = $settings['name'];
        $fileName = 'style';
        return $path . $name . '/css/' . $fileName;
 },[/code]
Men för att få funtionen ovanför att fungera var jag tvungen att ändra i [codi]src/ThemeEngine/CThemeBasic.php[/codi]
Jag redigerade funktionen [codi]getVarible($which);[/codi]
[code]public function getVariable($which)
{
    //  Här jag fixade till
    if ($which == 'settings') {
        return $this->config['settings'];
    } elseif (isset($this->data[$which])) {
        return $this->data[$which];
    } elseif (isset($this->config['data'])) {
        return $this->config['data'][$which];
    }
    return null;
}[/code]
Kanske inte den snyggaste lösningen. Men den funkar... [url]http://en.wikipedia.org/wiki/Principle_of_good_enough[/url]

Det som återstår nu är att fixa så att [codi]style.php[/codi] kan ta hand om sökvägen, köra autoloaden samt att använda [codi]Lessc[/codi]
Det löste jag med dessa raderna:
[code]
// Ser till så att configen kommer med vilket gör att autoloaden också körs
require '../config.php';
// Talar om att jag använder Lessc
use \Lessc;
// ...
// ...
// Ser till att style_config Closure-objekten blir "strängar"
$less = $config['style_file']() . '.less';
$css = $config['style_file']() . '.css';
[/code]

Efter jag var klar med alla dessa stegen så tänkte jag att jag skulle fixa i ordning mitt tema. Jag bestämde mig för att börja med lägga in samtliga filer i rätt mapp de vill säga [codi]theme/css/anax-grid/css/[/codi]. Fixade och pillade lite med min design där och så funka det klockrent. Valde att dela upp rätt mycket av min less-kod. till exempel är [codi]responsiv.less[/codi] där samtliga filer som har med [codi]media[/codi] att göra. Ändrade en hel del i [codi]anax-grid/variables.less[/codi], lade till varablar såsom [codi]bgColorMain @bgColorWrap-featured [/codi] och så vidare. Detta gjorde jag för att lätt kunna ändra samtliga färger utan större problem.

Där efter började jag med Font-awesome. Hade lite små problem med detta momäntet med kan man säga... Jag följde mos guide men märkte genast att efter sin jag [codi]style.less[/codi] i [codi] theme/anax-grid/css/ [/codi] så funkarde inte detta. Lösningen blev att jag skapade [codi]webroot/fonts[/codi] där jag lade in font-awesomes samtliga font filer. Men jag flyttade dock ut alla less filer till där dom hör hemma. Det vill säga [codi] theme/../css/font-awesome-4.0.3/[/codi].

Tyckte detta kursmomäntet var svårt. Dock var det nog mest för att jag gjorde de krågligt för mig, men det var lärorikt! Har tidigare erfarenhet av Bootstraps css-biblotek. Borde den nyaste varianten och den äldre varianten. Gillar Bootstrap mycket starkt, dock så märker man att det är många som använder det. Så för att va lite hipp så borde man kanske börja göra sina egna varianter (dvs bygga vidare på detta kursmomäntet).


