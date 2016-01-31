# Rapporter

## Kmom01

Min utvecklingsmiljö består av Windows 10 eller 7 med xampp, cygwin och atom texteditor. Under oophp-kursen började jag använda git och github som jag börjar få lite grepp om, så detta hade jag tänkt fortsätta med. Repona lägger jag på dropbox med mjuka länkar från webbservern. Jag skall också försöka få igång lintning i min lokala miljö. Windows 10 är nytt för mig sedan någon vecka tillbaks men verkar fungera OK än så länge.  

Jag har inte arbetat med några ramverk tidigare. Om man möjligen räknar WordPress som ett ramverk så har jag viss erfarenhet av att göra små förändringar i funktion och utseende. Där har jag skapat några enkla plugins för att bygga ut funktionalitet samt skapat "child themes" för att ändra utseende på ett grund-tema.

Jag är inte direkt bekant med de olika begreppen runt ramverk, mönster och arkitektur mer än möjligen att jag hört namen. MVC t.ex. är ju ett välkänt namn, så det ska bli kul att se hur det kan användas.

> Din uppfattning om Anax, och speciellt Anax-MVC?

För att lägga till tärning:

1. skapa routes till sidor i index.php under webroot.
2. lägg till menyval i navbar_me.php som pekar till routes i index.php.
3. Struktur för dice fanns upplagd under app/view/dice/index.tpl.php. Lägg till en div för att styra klass på app-innehållet.
4. Uppdatera webroot/css/dice.css med ny klass som sätter bredd på tärnings-sidan.
