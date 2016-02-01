# Rapporter

## Kmom01

Min utvecklingsmiljö består av Windows 10 eller 7 med xampp, cygwin och atom texteditor. Under oophp-kursen började jag använda git och github som jag börjar få lite grepp om, så detta hade jag tänkt fortsätta med. Repona lägger jag på dropbox med mjuka länkar från webbservern. Jag skall också försöka få igång lintning i min lokala miljö. Windows 10 är nytt för mig sedan någon vecka tillbaks men verkar fungera OK än så länge.  

Jag har inte arbetat med några ramverk tidigare. Om man möjligen räknar WordPress som ett ramverk så har jag viss erfarenhet av att göra små förändringar i funktion och utseende. Där har jag skapat några enkla plugins för att bygga ut funktionalitet samt skapat "child themes" för att ändra utseende på ett grund-tema.

Jag är inte direkt bekant med de olika begreppen runt ramverk, mönster och arkitektur mer än möjligen att jag hört namen. MVC t.ex. är ju ett välkänt namn, så det ska bli kul att se hur det kan användas.

Under denna uppgift har jag lagt in 3 relativt enkla sidor, "Om mig", "Rapport", och "Source", samt 2 extra sidor: "Kasta tärning" och "Kalender". När jag väl förstått vilka delar som behöver uppdateras var nånstans, så har arbetet för att göra själva sidorna gått snabbt och varit rättframt. Det är relativt enkelt att använda de olika tjänsterna i ramverket såsom lägga till stylesheets, skapa "snygga" länkar, filtrera markdown-text till html etc. Strukturen i ramverket uppmuntrar till bättre uppdelning av koden. T.ex. tog jag min kalender-funktion från oophp och anpassade till Anax-MVC. Det första jag fick göra var att dra ur modellen av kalendern och lägga den i app/src/CCalender, samt presentationen/vyn och lägga den i app/view/calender. För att kunna skicka rätt data till app/view/calender, anropar controllern index.php metoderna i CCalender och skickar vidare datat till kalender-vyn via ramverket. Detta känns bra, enkelt och snyggt.

Det verkar lite avigt att filerna för en app ligger utspridda i många olika mappar. Det hade känts smidigare om alla filer för en app/sida låg i en gemensam mapp. T.ex för kalendern så ligger controller-delen i weebroot/index.php, stylesheets under webroot/css, vyn ligger under app/view/calendar, modellen av kalendern ligger under app/src/Calendar samt meny-element läggs in i app/config/navbar_me.php. Det hade kännts smidigare om allt hade kunnat samlas inom en mapp som låg under mappen app/ men med en uppdelning i specifika filer t.ex. vy-, modell-, style-filer, etc.. T.ex. installation av en ny app blir enklare om den är sammanhållen med alla delar som behövs i en mapp.

Filen index.php börjar redan nu bli ganska stor och innehåller flera olika funktioner/appar. Förmodligen finns det ett sätt att ha en tunn index.php som ropar in dedicerade controller-filer efter behov.
