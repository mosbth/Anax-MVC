# Rapporter

## Kmom02

Den här uppgiften kändes väldigt svår i början men det lossnade allteftersom pusselbitarna föll på plats och jag fick lite bättre översikt på ramverket. Första stora problemet var att förstå hur redirect efter sparande av kommentar skulle fungera och hur värden för redirect-sidan överfördes mellan de olika komponenterna. Spara-kommentar-formuläret postar ett gömt fält som skall innehålla redirect-sidan. Denna hämtas mha getPost i controller-sidan som då kan göra redirect efter att kommentaren sparats. Till att börja med hämtade jag redirect-sidan med getCurrentUrl() i form.tpl.php men flyttade sedan ut det till front-controller index.php och skickar istället in redirect-sidan via variabel för att hålla borta php-kod från template-sidorna.

Nästa större svårighet var att förstå hur dispatcher i förhållande till view skulle fungera. Med en dispatcher kan man flytta ut mer kontroll-logik från front-controller till i detta fall CommentController. Denna CommentController skapar och lägger till en vy i den route den blivit dispatchad från istället för att skapa vyn i front-controller. Vyn skapas med hjälp av modellen som ligger i CommentsInSession.

Det fungerade smidigt att arbeta med composer efter att jag fått det installerat. Jag fick inte igång det när jag hämtade hem det via php utan installerade det via en windows-installer.

Då jag behövde lägga till funktionalitet i de två Comment-klasserna under vendor, valde jag att skapa subklasser till dessa som jag lade under app/src/Comment. Jag håller då isär mina ändringar från ursprungsklasserna och kan uppdatera via Composer för eventuella bugg-rättningar. Mina sub-klasser har samma namn som bas-klasserna så här fick jag chans att lära mig mer om namespace för att hålla isär dem.

Jag browsade runt på Packagist webbplats och hittade en hel del paket som skulle kunna vara intressanta, t.ex. modul för markdown, modul för mail-service, google api-client, blogg för phalcon, rss-feeds, etc. Den stora tröskeln för att använda en modul är nog svårigheten att veta hur mycket arbete det är att integrera en modul, samt kvaliteten på modulen. Antalet nedladdningar och stjärnmärkningar kan kanske kan ge lite vägledning om kvalitet och användbarheten.

Den uppenbara förbättringen var att lägga till stöd för olika kommentars-flöden. Här valde jag att använda mig av kommentars-sidans route som tag för flödet. Denna tag lagras i varje kommentar. Till att börja med lade jag tag-filtreringen i template-filen men fick sedan flyttat filtreringen till CommentsInSession.php. Verkade vettigt då det mer hänger ihop med modelleringen av kommentarer och flödet. Även funktioner för att uppdatera och radera kommentarer har lagts till.

En egen liten förbättringen var att lägga till funktion för att omvandla unix tidsstämpel till en relativ tid, typ "postad för 3 minueter sedan." Hittade en funktion för detta på StackExhange som passade in bra. Då tiden är relativ måste den genereras varje gång en kommentar hämtas från CommentsInSession.

För extrauppgiften att dölja kommentarsformuläret och få fram det genom att klicka på en länk så började jag  att försöka lösa det mha två olika routes: en route som **utan** vyn med kommentarsformuläret samt en route **med** vyn för kommentarsformuläret. Enkel lösning men kändes lite klumpigt att upprepa två nästan identiska routes. Istället använde jag mig av en query-variabel i url'en för att visa formuläret. Är variabeln 'showform' satt så visas formuläret. Annars döljs formuläret mha css display:none. En ännu smidigare och enklare lösning vore att använda js/jquery med .show()/.hide()/.toggle() på något sätt. Men det kommer nog i nästa kurs.

Att lägga till gravatarer gick smidigt. I modellen för kommentarer, CommentsInSession/findAll(), beräknas gravatar-url och läggs till i array för kommentar. Url'en kan sedan läsas ut i vyn för kommentarer i comments.tpl.php.

## Kmom01

Min utvecklingsmiljö består av Windows 10 eller 7 med xampp, cygwin och atom texteditor. Under oophp-kursen började jag använda git och github som jag börjar få lite grepp om, så detta hade jag tänkt fortsätta med. Repona lägger jag på dropbox med mjuka länkar från webbservern. Jag skall också försöka få igång lintning i min lokala miljö. Windows 10 är nytt för mig sedan någon vecka tillbaks men verkar fungera OK än så länge.  

Jag har inte arbetat med några ramverk tidigare. Om man möjligen räknar WordPress som ett ramverk så har jag viss erfarenhet av att göra små förändringar i funktion och utseende. Där har jag skapat några enkla plugins för att bygga ut funktionalitet samt skapat "child themes" för att ändra utseende på ett grund-tema.

Jag är inte direkt bekant med de olika begreppen runt ramverk, mönster och arkitektur mer än möjligen att jag hört namen. MVC t.ex. är ju ett välkänt namn, så det ska bli kul att se hur det kan användas.

Under denna uppgift har jag lagt in 3 relativt enkla sidor, "Om mig", "Rapport", och "Source", samt 2 extra sidor: "Kasta tärning" och "Kalender". När jag väl förstått vilka delar som behöver uppdateras var nånstans, så har arbetet för att göra själva sidorna gått snabbt och varit rättframt. Det är relativt enkelt att använda de olika tjänsterna i ramverket såsom lägga till stylesheets, skapa "snygga" länkar, filtrera markdown-text till html etc. Strukturen i ramverket uppmuntrar till bättre uppdelning av koden. T.ex. tog jag min kalender-funktion från oophp och anpassade till Anax-MVC. Det första jag fick göra var att dra ur modellen av kalendern och lägga den i app/src/CCalender, samt presentationen/vyn och lägga den i app/view/calender. För att kunna skicka rätt data till app/view/calender, anropar controllern index.php metoderna i CCalender och skickar vidare datat till kalender-vyn via ramverket. Detta känns bra, enkelt och snyggt.

Det verkar lite avigt att filerna för en app ligger utspridda i många olika mappar. Det hade känts smidigare om alla filer för en app/sida låg i en gemensam mapp. T.ex för kalendern så ligger controller-delen i weebroot/index.php, stylesheets under webroot/css, vyn ligger under app/view/calendar, modellen av kalendern ligger under app/src/Calendar samt meny-element läggs in i app/config/navbar_me.php. Det hade kännts smidigare om allt hade kunnat samlas inom en mapp som låg under mappen app/ men med en uppdelning i specifika filer t.ex. vy-, modell-, style-filer, etc.. T.ex. installation av en ny app blir enklare om den är sammanhållen med alla delar som behövs i en mapp.

Filen index.php börjar redan nu bli ganska stor och innehåller flera olika funktioner/appar. Förmodligen finns det ett sätt att ha en tunn index.php som ropar in dedicerade controller-filer efter behov.
