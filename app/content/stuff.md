#DetFinaGruppnamnet

Beskrivning
===========

Ett nytt innovativt spelsystem med exceptionella möjligheter till användarhantering och valuta transaktioner.

En användare måste vara registrerad och ha pengar på sitt konto för att kunna spela.

Systemet har många betalningsalternativ vilket gör det enkelt för alla användare att sätta in och ta ut pengar i/från systemet.

All användarhantering hanteras via administratörens eget gränsnitt.

Ett tärningsspel som är beroendeframkallande och framförallt roligt.


Datorbaserat system för att hantera spel
========================================

Funktionella
------------
* Gränssnitt för administratören
* (Admin) skapa account
* Logga in
* Logga ut
* Sätta in pengar
* Ta ut pengar
* Kolla saldo
* (Admin) Redigera information
* (Admin) Pausa account
* (Admin) Ta bort account
* Säkerhet vid betalning
* Beställa mat via programmet!
* Hantera flera spel
* Starta ett spel

Icke funktionella
-----------------
* Inget lagg när man starta ett spel 
* Bekväma betalningar
* Sköna stolar, vilket gör att folk spelar längre
* Service! 
* Användarvänligt
* Man ska förstå vad nästa steg är i interfacet
 

User Interface
--------
* Lista över spel som finns i spelhuset
* Visa saldo
* Gränssnitt för betalning
* Köra in kortet


System
------
* Windows baserat system
* Java

Spelet 100
==========

Funktionella
----------
* Nytt spel
* Slå tärning
* Spara poäng
* Summera tärningar
* Börja om
* Finnas en maxgräns
* Om man vinner får man pengar
* Välja mellan möta en spelare eller en dator(bot).
* Avsluta spel

Icke funktionella
-----------------
* Snyggt
* Flashy
* Awesome funktion för att visa att man har vunnit
* Beroende framkallande

User Interface
--------
* Högupplösta texturer i spelet
* Visa summa
* Visa knappar
  * Visa knapp för kasta
  * Visa knapp för spara
  * Visa knapp börja om
  * Visa knapp för avsluta spelet

System
------
* Java
* Lager utanpå systemet

---------------------------------------------------------------------------------------

User cases (SYSTEM)
============

User case 
----------
Skapa konto

ACTORS
------ 
Användare, admin

Description
-------------
Användare går till info-desk  
Admin frågar om personuppgifter       
Om man är okej i ålder skapar admin ett konto för användare   
Admin ger ett inloggningsuppgifter för användaren       

---------------------------------------------------------------

User case 
----------
Lägga in pengar

ACTORS
------ 
Användare

Description  
-------------
Användare går till spelmaskin   
Användare loggar in     
Användare klickar på fyll på saldo   
Användare väljer betalningsmetod   
Användare anger betalningsuppgifter    
Användare får ett kvitto   

---------------------------------------------------------------

User case 
----------
Ta ut pengar

ACTORS
------ 
Användare, admin

Description
-------------
Användare går till info-desk   
Användaren ger personuppgifter   
Admin slår in personuppgifter   
Användare säger hur mycket pengar    
Admin slår in summa i system   
Användare får pengar    

---------------------------------------------------------------

User case 
----------
Spela ett spel

ACTORS
------ 
Användare

Description
-------------
Användare går till spelautomat    
Användare slår in personuppgifter (loggar in)   
Användare gör sig bekväm framför spelautomat   
Användare väljer ett spel    
Användare börjar spela  

---------------------------------------------------------------

User case 
----------
Kolla saldo

ACTORS
------ 
Användare 

Description
-------------
Användare kollar ner på skärm vid spelmaskin   


---------------------------------------------------------------

User case 
----------
Redigera användarkonto

ACTORS
------ 
Användare, admin

Description
-------------
Användaren går till info desk   
Användaren ger personuppgifter   
Användaren ger nya uppgifter (konto)   
Admin tar emot informationen   
Admin ändrar kontouppgifterna   


---------------------------------------------------------------

User case
----------
Pausa konto

ACTORS
------ 
Användare, admin

Description
-------------
Användaren går till info desk   
Användaren ger personuppgifter   
Användaren ber om att pausa konto   
Admin pausar kontot


---------------------------------------------------------------

User case
----------
Frysa / Ta bort konto

ACTORS
------ 
Admin

Description
-------------
Admin väljer användare   
Admin fryser / Tar bort kontot   


---------------------------------------------------------------

User case
----------
Logga in

ACTORS
------ 
Användare

Description
-------------
Användaren går till spelmaskin   
Användaren trycker in personuppgifter   
Användaren trycker på logga in   


---------------------------------------------------------------

User case
----------
Logga ut

ACTORS
------ 
Användare

Description
-------------
Användaren trycker på logga ut   

---------------------------------------------------------------

User case
----------
Beställa mat via programmet!

ACTORS
------ 
Användare, Admin

Description
-------------
Användaren trycker upp listan med beställbar mat   
Användaren väljer det han/hon önskar i listan   
Användaren trycker på beställ   
Admin ser beställningen i systemet   
Admin betjänar kunden     

---------------------------------------------------------------

User case
----------
Starta ett spel

ACTORS
------ 
Användare

Description
-------------
Användaren trycker upp listan med spel   
Användaren trycker på ett av spelen i listan    

UTÖKADE USER CASE 
---------------------------------------------------------------

User case
----------
Skapa konto   

ACTORS
------ 
Användare, admin   


Description
-------------
Användare går till infodesk och ger admin förfrågan om att skapa ett konto   
Admin frågar om personuppgifter   
Admin kontrollerar uppgifter:   
	Om åldern är mindre än 18   
		Användaren är för ung för att ha ett konto i systemet och kontot skapas ej.   
	
	Om personen redan har ett konto i systemet   
		Personen finns redan i systemet så vi framför det till personen   
		
	Annars   
		Admin skapar ett konto med dem angivna uppgifterna   
		Ger användaren inloggningsuppgifter   

---------------------------------------------------------------


User case
----------
Lägga in pengar   


ACTORS
------
Användare   


Description  
-------------
Användare går till spelmaskin   
Användare loggar in     
Användare klickar på fyll på saldo   
Användare väljer lämplig betalningsmetod   
Användare anger betalningsuppgifter
Om betalningsuppgifterna inte är giltiga   
Systemet förfrågar om alternativa betalningsuppgifter   

	Om användaren inte har tillräckligt med tillgångar på dem valda betalningsuppgifterna   
		Systemet ger användaren information om vad som gick fel   
		Systemet förfrågar om alternativ betalningsmetod eller alternativa betalningsuppgifter   

	Om uppkopplingen vid elektronisk överföring bryts   
		Systemet ger användaren information om vad som gick fel   
		Transaktionen bryts och inga pengar dras från användarens tillgångar   

	Annars
		Systemet drar angiven summa från användarens tillgångar   
		Systemet lägger in motsvarande saldo på användarens konto

Användare får ett kvitto   


---------------------------------------------------------------

User case
----------
Ta ut pengar  


ACTORS
------
Användare, admin    


Description  
-------------
Användare går till info-desk   
Användaren ger personuppgifter   
Admin slår in personuppgifter   
	Om personuppgifterna inte stämmer överens med något konto i systemet
		Admin frågar användaren om dem korrekta uppgifterna

Användare säger hur mycket pengar han/hon vill ta ut   
Admin slår in summa i system   
	Om summan överskrider användarens saldo   
		Inga pengar dras ut från systemet   
		Användaren får information om hur mycket han/hon har på kontot   

Användare får pengar   

---------------------------------------------------------------

User case
----------
Spela ett spel   


ACTORS
------
Användare   


Description  
-------------
Användare går till spelautomat   
Användare slår in personuppgifter (loggar in)   
Användare gör sig bekväm framför spelautomat   
Användare väljer ett spel   
Användare börjar spela   
	Om användaren inte har tillräckligt med tillgångar på sitt saldo   
		Systemet ger användaren information om hur läget är   
		Användaren blir hänvisad till att lägga till pengar på saldot för att kunna spela spelet   

---------------------------------------------------------------

User case
----------
Kolla saldo   


ACTORS
------
Användare   


Description  
-------------
Användaren loggar in på maskinen   
Användaren ber om att få sitt saldo utskrivet på skärmen   
Användare kollar ner på skärm vid spelmaskin   

---------------------------------------------------------------

User case
----------
Redigera användarkonto


ACTORS
------
Användare, admin   


Description  
-------------
Användaren går till info desk   
Användaren ger personuppgifter   
Användaren ger nya uppgifter (konto)   
Admin tar emot informationen   
	Om dem givna uppgifterna inte är giltiga
		Admin frågar användaren om dem korrekta uppgifterna

Admin ändrar kontouppgifterna   

---------------------------------------------------------------

User case
----------
Pausa användarkonto


ACTORS
------
Användare, admin   


Description  
-------------
Användaren går till info desk   
Användaren ger personuppgifter   
	Om dem givna uppgifterna inte matchar något konto
		Admin ber om dem korrekta uppgifterna

Användaren ber om att pausa konto   
	Om kontot redan är pausat
		Admin ger användaren information om hur läget är
		

Admin pausar kontot  

---------------------------------------------------------------

User case
----------
Frysa / Ta bort användarkonto


ACTORS
------
Admin   


Description  
-------------
Admin ger systemet kontouppgifter  
Om dem givna uppgifterna inte matchar något konto   
Systemet ger informationen till admin  
Systemet ber om dem korrekta uppgifterna  

Om ett konto matchar uppgifterna  
Systemet frågar admin om han/hon är säker på att det är det korrekta kontot  
   
Admin fryser / Tar bort kontot   
Systemet skickar ut ett meddelande till vald kontaktuppgift för kontot om varför deras konto blev fryst / borttaget  

---------------------------------------------------------------

User case
----------
Logga in  


ACTORS
------
Användare  


Description  
-------------
Användaren går till spelmaskin   
Användaren ger kontouppgifter   
Användaren trycker på logga in   
	Om dem givna uppgifterna inte matchar ett konto i systemet   
Systemet ger användaren information om vad som gick fel på skärmen   

Om kontot är fryst   
Systemet visar för användaren att kontot är fryst   
Användaren hänvisas till info-desken för mer information    

---------------------------------------------------------------

User case
----------
Logga ut  


ACTORS
------
Användare  


Description  
-------------
Användaren trycker på logga ut   


---------------------------------------------------------------

User case
----------
Beställa mat via programmet!

ACTORS
------ 
Användare, Admin

Description
-------------
Användaren trycker upp listan med beställbar mat   	
Användaren väljer det han/hon önskar i listan   
Användaren trycker på beställ   
	Om saldot är otillräckligt   
		Köp avbryts   
		Användare meddelas   
	Annars   
Om varan inte finns   
Användare meddelas   
Beställningen avbryts   
Om varorna finns   
	Pengar dras ifrån saldot   
Beställningen skickas   
Admin ser beställningen i systemet   
Admin betjänar kunden   
	
---------------------------------------------------------------

User case
----------
Starta ett spel

ACTORS
------ 
Användare

Description
-------------
Användaren trycker upp listan med spel   
Användaren trycker på ett av spelen i listan    

---------------------------------------------------------------

User cases (GAME)
========

User case
----------
Nytt spel

ACTORS
------ 
Spelare

Description
-------------
Spelaren trycker på knappen “Nytt spel”   

---------------------------------------------------------------

User case
----------
Slå tärning

ACTORS
------ 
Spelare

Description
-------------
Spelaren trycker på knappen “Kasta träning”   

---------------------------------------------------------------

User case
----------
Spara poäng

ACTORS
------ 
Spelare

Description
-------------
Spelaren trycker på knappen “Spara poäng”   

---------------------------------------------------------------

User case
----------
Börja om

ACTORS
------ 
Spelare

Description
-------------
Spelaren trycker på knappen börja om   

---------------------------------------------------------------

User case
----------
Avsluta spel

ACTORS
------ 
Spelare

Description
-------------
Spelaren trycker på knappen “Avsluta spel”   

---------------------------------------------------------------

User case
----------
Välja mellan att möta spelare eller dator(bot)   

ACTORS
------ 
Spelare

Description
-------------
Spelaren väljer motståndare vid start

---------------------------------------------------------------


# UTÖKADE USER CASE 
---------------------------------------------------------------

User case
----------
Nytt spel

ACTORS
------ 
Spelare

Description
-------------
Spelaren trycker på knappen “Nytt spel”   
Om saldot är tomt   
Meddela spelaren   
Avsluta spelet   
Om saldot är tillräckligt   
	Gå vidare till att välja motståndare   
	Starta spel   

---------------------------------------------------------------

User case
----------
Slå tärning

ACTORS
------ 
Spelare

Description
-------------
Spelaren trycker på knappen “Kasta träning”   

---------------------------------------------------------------

User case
----------
Spara poäng

ACTORS
------ 
Spelare

Description
-------------
Spelaren trycker på knappen “Spara poäng”     
Om poängen är 0   
Spara knappen syns inte   

---------------------------------------------------------------

User case
----------
Börja om

ACTORS
------ 
Spelare

Description
-------------
Spelaren trycker på knappen “börja om”     
Om saldot är tomt   
Meddela spelaren    
Avsluta spelet    
Om saldot är tillräckligt     
	Gå vidare till nytt spel     

---------------------------------------------------------------

User case
----------
Avsluta spel   

ACTORS
------ 
Spelare   

Description
-------------
Spelaren trycker på knappen “Avsluta spel”   
	Om ett spel är aktivt   
		(Popup) Varna spelaren att rundan går förlorad   
			Om Spelare trycker JA   
				Avsluta spel   
			Om spelare trycker NEJ   
				Fortsätt spel   

---------------------------------------------------------------

User case
----------
Välja mellan att möta spelare eller dator(bot)

ACTORS
------ 
Spelare





Description
-------------
Spelaren väljer motståndare vid start   
Om de finns spelare    
		Välj en spelare   
		Starta spelet      
	Om val BOT  
		Välj svårighets nivå   
		Starta spelet     

---------------------------------------------------------------


System: https://www.dropbox.com/s/ypmibce91ojwmlq/UseCase_Diagram_System.jpg

Spelet: https://www.dropbox.com/s/3qq3ygsp3p6o85r/UseCase_Diagram_Game.jpg


