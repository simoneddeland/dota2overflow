Redovisning
====================================
 
Kmom01: PHP-baserade och MVC-inspirerade ramverk
------------------------------------
 
#### Vilken utvecklingsmiljö använder du?
Jag har tidigare använt XAMPP på Windows 10 med Atom som texteditor. Inför denna kurs har jag dock bestämt mig för att testa Visual Studio Code från Microsoft. Jag har använt Visual Studio som IDE när jag arbetat med C# och gillar det väldigt mycket, så jag tänkte ge VS Code en chans också. VS Code har Intellisense (smart kodkomplettering till t.ex. PHP) som hittills fungerar bra, så även om jag saknat vissa saker från Atom och dess plugins så tänker jag fortsätta något/några kursmoment till.

#### Är du bekant med ramverk sedan tidigare?
Jag är bekant med vissa typer av ramverk (t.ex. XNA) men inte den typ av ramverk som vi testat nu, d.v.s. ramverk likt Phalcon eller Anax-MVC. Det som känns svårast hittills är att komma ihåg var alla filer/mappar ligger i katalogstrukturen. Efter en hel del arbete och tänkande så tycker jag ändå att jag har förstått hur koden i Anax-MVC fungerar (fast jag är rädd att jag kommer glömma bort det om jag inte fortsätter med kodantet under sommaren.

#### Är du sedan tidigare bekant med de lite mer avancerade begrepp som introduceras?
Både och, traits var t.ex. nytt för mig. Jag är dock ganska bekant med objektorienterande begrepp som arv, polymorfism och interface. En sak som jag hade svårighet med var att förstå det arbete som den "magiska get-metoden" i PHP gör. Jag kände inte till denna metod innan och försökte hitta var i koden som fileContent och textFilter var deklarerade. Efter att jag läst på om get-metoden på Phalcons hemsida så blev allt klart.

Dependency Injection är ett begrepp som jag har hört talas om tidigare ("låt inte klasserna skapa egna objekt, skicka in dem till klassen istället"), men jag har aldrig arbetat med dem på detta sätt (med en service locator). Jag har läst lite om detta designmönster på [GameProgrammingPatterns](http://www.gameprogrammingpatterns.com) tidigare så tankesättet är inte helt främmande.

#### Din uppfattning om Anax, och speciellt Anax-MVC?
I den förra kursen (oohphp) använde vi en annan version av Anax och den känner jag mig hemnma i vid det här laget. Anax-MVC känns mycket mer komplext och mycket större än så länge. Det finns en del mappar/filer i katalogstrukturen som jag inte ens öppnat än. Jag hoppas (och tror) att jag kommer känna mig mer hemma i Anax-MVC efter de kommande kursmomenten. Det som känns svårast är att veta hur jag ska göra något som inte har visats i artiklarna/övningarna.
 
Kmom02: Kontroller och Modeller
------------------------------------

#### Hur känns det att jobba med Composer?
Det var inga problem att jobba med Composer, men jag har ju dock inte använt det mer än det som visades i övningen. Det som gör det bra är att man smidigt ska kunna få uppdateringar till de paket som ett projekt kräver. Dock så kan jag tycka att det kändes som att man hade kunnat få hem phpmvc/comment på ett smidigare sätt när jag ändå har arbetat vidare med en egen version av det (som Mos tipsade en annan användare om i forumet). Om man bara ska ladda ner kod en gång så tycker jag att git fungerar smidigare, men det är en vanesak helt enkelt.

#### Vad tror du om de paket som finns i Packagist, är det något du kan tänka dig att använda och hittade du något spännande att inkludera i ditt ramverk?
Jag har bara tittat en ganska kort bit på Packagist, så än så länge vet jag inte om det finns något intressant paket där. Det skulle kanske vara intressant att undersöka mer under projektet i slutet av kursen, men då får jag kolla på forumet först om det är OK. Det går i alla fall lätt att hitta saker på deras sida.

#### Hur var begreppen att förstå med klasser som kontroller som tjänster som dispatchas, fick du ihop allt?
Det var ganska krångligt att få koll på i början, men nu känns det som att detta sitter fint. En sak som var svår var att hitta hur man lade till parametrar till en url som routras till en kontroller, men lyckades hitta det efter lite detektivarbete i koden. Jag hade först försökt hitta lösningen i dokumentationen till Phalcon men lyckades inte där (vet inte om det görs exakt likadant i Phalcon och Anax). 

Överlag så känns hela mappstrukturen i Anax fortfarande lite svårövergriplig (vad gör mappen 3pp? borde jag lägga till något i docs?), men det har blivit lättare att hitta de filer jag vill ändra på under detta kursmoment. Än så länge känns det dock som att det hade gått lika bra (kanske lättare/snabbare?) att använda det designmönster som vi använde oss av i oophp, men poängen med MVC är väl att det ska vara lätt att bygga stora modulära projekt, och vi har väl kanske inte kommit till det stadiet än.

#### Hittade du svagheter i koden som följde med phpmvc/comment? Kunde du förbättra något? 
Det kändes lite lustigt att varje metod skapade ett eget CommentsInSession-objekt, jag hade nog valt att skapa en konstruktor och skicka in ett objekt via den istället. Jag valde dock att fortsätta på det sätt som fanns i filerna, jag tänker att Mos kan detta bättre än mig och det finns säkert en anledning som dyker upp längre fram som förklarar varför en konstruktor var ett sämre alternativ.

Jag tyckte att kommentarerna som man skriver borde visas i ordningen "senast skriven längst upp", så där gjorde jag en ändring från foreach till for för att kunna ha det på detta vis. Förutom denna ändring så gjorde jag de utökningar av klasserna som krävdes (men inga extrauppgifter).

Kmom03: Bygg ett eget tema
------------------------------------

#### Vad tycker du om CSS-ramverk i allmänhet och vilka tidigare erfarenheter har du av dem?
Jag har inte någon direkt tidigare erfarenhet av CSS-ramverk. Jag kände till Bootstrap sedan tidigare, men jag har aldrig testat det själv. En kollega har dock visat Bootstrap för mig en kort stund, så jag kände till var syftet med Bootstrap var.

#### Vad tycker du om LESS, lessphp och Semantic.gs?
Äntligen får vi variabler till CSS! Det har man verkligen saknat i de tidigare kurserna. Det ska bli skönt att kunna ställa in t.ex. färger med variabler som jag sedan enkelt kan återanvända i flera olika element. LESS känns alltså väldigt bra (även om jag inte kan precis allt som man kan göra med LESS). Supersmidigt att använda lessphp för kompileringen (har dock inte testat något alternativ så vet inte hur jobbigt det hade varit). Semantic.gs har jag använt på det sätt som visades och det var inga problem med det, smidigt med "antal kolumner" via LESS.

#### Vad tycker du om gridbaserad layout, vertikalt och horisontellt?
Det blir väldigt snyggt med den gridbaserade layouten. Den vertikala kändes inte så krånglig, men den horisontella med typografin var väldigt avancerad (det svåraste i kursmomentet var att fixa h3-headern och det horisontella rutnätet). Jag vet inte om det horisontella rutnätet verkligen är värt mödan, men nu har vi ju fått kod som ska klara av det så förhoppningsvis kan jag använda det i kursens projekt.

#### Har du några kommentarer om Font Awesome, Bootstrap, Normalize?
Font Awesome är fantastiskt, jag testade det lite redan i htmlphp-kursen men tog inte med det p.g.a. av klagomål när jag skulle validera min HTML. Jag har inte använt Bootstrap nu men kände till det tidigare, jag tror att jag skulle använda mig av Bootstrap om jag skulle bygga upp en ny sida från grunden utanför denna kurs. Normalize var nytt men gör det som den ska.

#### Beskriv ditt tema, hur tänkte du när du gjorde det, gjorde du några utsvävningar?
Jag har arbetat igenom övningen där man skapat temat och använde det som grund. Tema-sidorna är integrerade i navbaren på min me-sida och nås via frontkontrollern theme.php. Jag har utökat den responsiva designen med en brytpunkt till som gäller raderna med tre box-element (featured och triptych). Bakgrundsbilden och bakgrundsfärgerna för box-elementen är lagda i en egen css-fil och visas i routrarna för temat och font awesome (men inte för typografin). Temat fick också en ny header då den tidigare headern inte var särskilt responsiv med absolut positionering.

#### Antog du utmaningen som extra uppgift?
Nej, jag nöjde mig med grunduppgiften (men jag kan använda git och GitHub).
 
Kmom04: Databasdrivna modeller
------------------------------------
 
#### Vad tycker du om formulärhantering som visas i kursmomentet?
Jag gillar det, framförallt att man inte behöver arbeta själv med valideringen av formulärdatan. Det var lite krångligt att sätta sig in i hur formuläret fungerade med alla callbacks och de olika sätt som man kan använda CForm på. Jag känner att man verkligen inte vill gå tillbaka till att skriva egna formulär efter att ha använt CForm, med undantag om jag vill ha en viss speciell layout på formuläret.

#### Vad tycker du om databashanteringen som visas, föredrar du kanske traditionell SQL?
Jag tror egentligen jag föredrar traditionell SQL framför att skriva egna abstraktionsmetoder ovanför SQL-koden. Jag förstår att det kan bli problem om man t.ex. vill byta vilken sorts SQL-databas man använder, jag vet inte hur vanligt detta är men jag har aldrig funderat på det själv. Troligen så har det väl med vana att göra, och om det är detta sätt att bygga querys som används i ramverk så är det ju bra att vi har lärt oss det.

#### Gjorde du några vägval, eller extra saker, när du utvecklade basklassen för modeller?
Jag följde övningen och mos anvisningar ganska direkt när jag gjorde min CDatabaseModel. Jag är väldigt nöjd med hur basklassen blev, den känns väldigt användbar efter att ha utnyttjat den för både kommentarer och användare. Det ska bli skönt att slippa skriva boilerplate-kod i framtida moment.

#### Beskriv vilka vägval du gjorde och hur du valde att implementera kommentarer i databasen.
Jag valde att implementera klassen Comment på samma sätt som klassen User. Både klasserna ärver från CDatabaseModel och därmed slipper jag skriva boilerplate-koden för någon av klasserna individuellt. Jag har uppdaterat kontrollern för kommentarerna så att den använder den nya modellen med databaser istället för sessionen. En sak som skiljer sig åt mellan hur Users och Comments lagras är att varje Comment har en sida som den hör ihop med. Jag har valt att lägga alla Comments i samma tabell i databasen, värdet av en av kolumnerna avgör vilken sida som kommentaren tillhör. Kontrollern för kommentarerna ser till att välja ut de kommentarer som ska visas. 

Detta kursmoment har tagit väldigt lång tid och varit väldigt omfattande, det absolut största kursmomentet hittills i denna kurs.

#### Gjorde du extrauppgiften? Beskriv i så fall hur du tänkte och vilket resultat du fick.
Nej, jag gjorde inte extrauppgiften.

Kmom05: Bygg ut ramverket
------------------------------------
#### Var hittade du inspiration till ditt val av modul och var hittade du kodbasen som du använde?
Jag valde att göra en loggningsmodul. Inspirationen till mitt val fick jag av artikeln. I artikeln hittade jag även mos lösning av CLog vilken jag använde som grund för min egen CLog.

#### Hur gick det att utveckla modulen och integrera i ditt ramverk?
Jag sparar timestamps i CLog på ett väldigt likt sätt som mos, och även tabellpresentationen tog jag efter. Däremot så lade jag till en valfri parameter i konstruktorn som avgör hur många decimaler som visas i tabellpresentationen. Alla beräkningar/data som sparas sker utan avrundning, endast vid presentation ska värdena avrundas. Jag valde även att lägga till lite fler metoder för att få information om loggningen. Överlag så var det inga problem med utvecklandet av modulen.

#### Hur gick det att publicera paketet på Packagist?
Jag hade ganska mycket problem med att ens komma igång eftersom jag inte fick composer att funka först (och därmed inte kunde testa att mitt paket gick att ladda ner). Efter någon timmes felsökande och slit löste jag problemet, det var jag som försökte använda composer med cygwin men jag hade tidigare installerat det i kommandotolken i Windows (så kan det gå när man är glömsk!). När jag väl fattat detta så gick det ganska OK, det hade gärna fått vara med beskrivning av innehållet i composer.json på dbwebb (fick leta själv på andra ställen nu).

#### Hur gick det att skriva dokumentationen och testa att modulen fungerade tillsammans med Anax MVC?
Det var inga problem, jag gjorde en testinstallation av Anax MVC och allt fungerade som det ska. Dokumentationen var det sista jag gjorde och det gick också smidigt.

#### Gjorde du extrauppgiften? Beskriv i så fall hur du tänkte och vilket resultat du fick.
Nej, jag nöjde mig med grunden.
 
Kmom06: Verktyg och CI
------------------------------------
 
#### Var du bekant med några av dessa tekniker innan du började med kursmomentet?
Jag har läst om tester innan i andra programmeringsspråk med aldrig testat själv (pun intended), även om jag känner till lite om tanken med testande och att t.ex. globala variabler gör testande svårt. CI och kodbedömning var jag inte lika bekant med som testning.

#### Hur gick det att göra testfall med PHPUnit?
Det gick bra att skriva själva testandet, det som krånglat mest i kursmomentet dock var installationen av PHPUnit (det är ett återkommande problem att få allt att funka bra på Windows tycker jag).

#### Hur gick det att integrera med Travis?
Det var inga problem att få Travis att fungera, det gick väldigt smidigt och snabbt för testerna där att köras.

#### Hur gick det att integrera med Scrutinizer?
Scrutinizer gick också att använda utan större problem. Det var lite svårt att hitta information om resultatet på Scrutinizer till att börja med, men efter lite letande så hittade jag. Scrutinizer tog ganska lång tid att köra några gånger när jag använde det, men jag fick ett mail dagen efteråt från dem att de hade haft driftstörningar så förhoppningsvis händer det inte så ofta.

#### Hur känns det att jobba med dessa verktyg, krångligt, bekvämt, tryggt? Kan du tänka dig att fortsätta använda dem?
När man väl fått allt "installerat" för projektet man arbetar med känns det smidigt. Scrutinizer är vad jag fattat det inte gratis för privat kod så det gör att jag nog inte skulle använda det i framtiden, Travis är inte heller gratis men erbjöd en viktigare tjänst tycker jag. Jag hade gärna lärt mig hur man kan arbeta med Git och pull requests med testande och automatisk deployment. Jag har läst lite själv om det och pillar lite med en server på Raspberry Pi och kommer nog att fortsätta med det i framtiden. Jag kan tänka mig att jag försöker installera någon lokal CI-server där, och det jag har lärt mig i detta kursmoment kommer vara till stor nytta då. Jag har läst att man kan koppla in t.ex. PHPUnit med hooks i Git så det kanske jag testar där också. Överlag så är dock webtjänsterna trevliga att använda eftersom de erbjuder ett väldigt trevligt gränssnitt för testandet och CI.

#### Gjorde du extrauppgiften? Beskriv i så fall hur du tänkte och vilket resultat du fick.
Nej, jag skippade extrauppgiften.

Kmom07-10: Projekt och examination
------------------------------------
 
Fin redovisningstext om kursmoment 07-10.
 