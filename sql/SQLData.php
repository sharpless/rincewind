<?php
$queryData = <<< EOD
INSERT INTO {$tableUsers} (user_login, user_password, user_name, user_email, user_created_date) VALUES
  ('mikael', MD5('hemligt'), 'Mikael Roos', 'mos@bth.se', NOW()),
  ('john', MD5('doe'), 'John Doe', 'john@example.com', NOW());
INSERT INTO {$tableGroups} (group_name) VALUES
  ('adm'),
  ('user');
INSERT INTO {$tableGroupMember} (member_id, group_id) VALUES
  (1, 1),
  (2, 2);
INSERT INTO {$tableThreadPosts} (post_author_id, post_thread_id, post_topic, post_content, post_created_date) VALUES
  (1, 1, 'Hejsan', '<p>Välkommen till mitt forum, här kan du inte göra så mycket ännu</p>', NOW()),
  (2, 1, 'Sv: Hejsan', '<blockquote><p>Välkommen till mitt forum, här kan du inte göra så mycket ännu</p></blockquote><p>Vet inte om jag håller med om det.</p>', NOW()),
  (2, 2, 'Testar lite', '<p>Vem är du, vem är jag</p>', NOW());

INSERT INTO {$tableThreads} (thread_topic, thread_author_id) VALUES
  ('Hejsan', 1),
  ('Testar lite', 2);

INSERT INTO {$tableBlogPosts} (`post_author`, `post_content`, `post_title`, `post_date`, `post_modified_date`) VALUES
(1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque lectus lectus, pretium eu hendrerit eget, consectetur vel purus. Phasellus fringilla dictum sodales. Curabitur tristique pulvinar mauris, dictum ullamcorper tellus semper vel. Donec posuere rhoncus blandit. Integer tincidunt tortor at tellus placerat porttitor. Praesent sed ipsum a velit vehicula feugiat nec eget urna. Pellentesque lobortis dignissim nunc ut congue. Sed est dui, sollicitudin vitae varius aliquet, feugiat eget ipsum. In hac habitasse platea dictumst. Suspendisse vel odio elit. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin nibh tellus, molestie ut blandit a, porta consectetur ante.</p><p>Sed malesuada bibendum metus at laoreet. Maecenas magna diam, tincidunt ut iaculis sit amet, imperdiet nec justo. Donec magna erat, semper ac luctus nec, scelerisque et ligula. Nullam sollicitudin lorem a ipsum sodales tempor. Nullam ac mauris eget turpis posuere scelerisque. Etiam porttitor mi at lectus ultrices eget porta lacus posuere. Mauris elementum massa justo, non ultricies purus. Duis dapibus felis sed quam euismod luctus. Phasellus sit amet erat lorem. Pellentesque posuere purus vitae sem semper mollis. Fusce dolor tellus, molestie at facilisis at, malesuada eu nulla.</p><p>Sed mi dui, vulputate eget scelerisque cursus, dignissim nec massa. Aliquam facilisis libero eu ligula euismod euismod condimentum augue fermentum. Vivamus pretium ante ac dolor sodales egestas. In ut massa nec sem lobortis bibendum. Morbi porttitor, enim auctor posuere feugiat, justo purus ultrices elit, vitae mollis leo ligula id arcu. Quisque malesuada neque at elit gravida non euismod erat pulvinar. Aliquam mollis purus ac leo egestas et dapibus ipsum pellentesque. Nam sed metus turpis. Nunc purus nulla, rhoncus ac lacinia vel, tristique sit amet lorem. Sed orci sapien, luctus ac imperdiet facilisis, vestibulum blandit elit. Sed rutrum faucibus gravida. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur adipiscing ligula in nibh iaculis at auctor magna aliquet. Ut eget venenatis nunc. Aliquam blandit sagittis eleifend. Fusce sit amet tortor in turpis egestas dictum. Sed nec commodo nibh. Phasellus mi diam, convallis at mattis sed, dictum vitae lectus. Vestibulum sollicitudin tristique elit, vel convallis sapien consequat nec. Donec quam dolor, venenatis eu sodales sit amet, ultrices non nisi.</p><p>Suspendisse potenti. Suspendisse quis risus neque, eu varius risus. Nullam ultrices lectus sed risus consectetur in fermentum justo fermentum. In hac habitasse platea dictumst. Curabitur nibh lectus, laoreet eu consequat vitae, dignissim sed libero. Nulla aliquam adipiscing adipiscing. Nulla fringilla, nibh sed imperdiet scelerisque, sapien erat malesuada lacus, nec auctor tellus tellus id justo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque placerat urna in justo fermentum vel tincidunt ipsum suscipit. Sed justo nisi, tincidunt a semper sit amet, porttitor eget dui. Vivamus rhoncus eleifend pellentesque. Nunc vehicula pharetra odio, at lobortis libero vulputate in. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Quisque varius, justo et fermentum aliquet, ligula lectus pharetra dolor, vitae ullamcorper augue diam at mi. Ut et turpis quis nisl vulputate ullamcorper.</p><p>Phasellus ac luctus metus. Donec sed consequat neque. Quisque in risus ipsum. Nulla ut risus dapibus urna sodales accumsan vitae sit amet elit. Nam leo odio, tempor malesuada gravida sit amet, cursus eget orci. Vivamus enim orci, placerat non aliquet sed, fringilla nec lorem. Pellentesque vestibulum mattis elit, sed dictum ante laoreet sed. Nunc dapibus pharetra sodales. Pellentesque in lacus id lacus vestibulum fringilla a eget eros. Suspendisse pellentesque nisi ac magna molestie sed consectetur massa congue. Etiam tincidunt diam vitae dolor ultricies rutrum. Maecenas vel justo nisl, iaculis aliquet ligula. Aenean nec dui ut ante porta auctor eget ornare turpis. Nam ultrices viverra urna ut tincidunt.</p>', 'Lorem ipsum', '2010-01-01 11:44:34', '2010-01-01 11:44:34'),
(2, '<p>Första kursmomentet bjöd inte på några större överraskningar eller problem för mig. Detta då jag sedan tidigare hade en server (OpenSUSE 11.2) med Apache 2.2, MySQL 5.1 och PHP 5.3 igång och använt den för utveckling på den förra kursen jag läste (Databaser och objektorienterad programmering i PHP). Den webbläsare jag använder är Firefox (just nu version 3.6 RC1). I det här momentet gjorde jag ett par ändringar i php.ini, bland annat valde jag att aktivera display_errors och att färgkoda felmeddelanden. Kom fram till att det kan vara bra att få dem direkt i webbläsaren istället för att ha dem i en loggfil man inte alltid kommer ihåg att titta i.<br /> Eftersom jag hade en fungerande installation hoppade jag över att göra de flesta av testerna för att kontrollera att allt fungerade. Det jag gjorde var att kopiera och testa felmeddelanden, så att de visades korrekt på skärmen. Nu är det bara att hoppas att det blir lagom mycket utmaningar i kommande kursmoment.</p>', 'Kursmoment 1', '2010-01-16 22:40:40', '2010-01-16 22:40:40'),
(2, '<p>Inga direkta överraskningar i det här momentet, möjligtvis att jag inte skrivit helt optimal kod i kalendern. Mina kunskaper från objektorienterad programmering härrör sig från föregående kurs, så jag kan inte påstå att jag är någon guru direkt. PHP har jag väl en del erfarenhet av sedan tidigare, och har svaga minnen av programmering i Pascal och Scheme, från gymnasium och tidigare högskolestudier. Jag kände inte för att göra en "Månadens babe", så istället tog jag lite bilder från mitt bildarkiv och förstärkte det lite med bilder från en kompis.</p>', 'Kursmoment 3', '2010-02-09 23:21:32', '2010-02-09 23:21:32'),
(2, '<p>Gick överlag rätt smidigt det här momentet, testade att använda "mysqli_stmt" för databasfrågorna istället för standardgränssnittet. Programmerade det mesta själv, men tittade även på exempelkällkoden för att se om jag missat något. Måste dock säga att jag tycker det är ansvarslöst att använda ofiltrerade &#36;_GET-variabler till SQL-frågor. Som tidigare så består mina tidigare erfarenheter av PHP/MySQL i att jag läste föregående kurs, samt viss egenhändigt hackande på hobbybasis. Min mallsida är väl mest kopierad kod (åtminstone om man bortser från CHTMLPage.php, där det finns några enstaka modifierade rader). Modifierade även min source.php att använda CHTMLPage istället för common.php. </p>', 'Kursmoment 4', '2010-02-26 21:19:02', '2010-02-26 21:19:02'),
(2, '<p>En aning sent lämnar jag äntligen in det här kursmomentet. Största orsakerna till förseningen har dock inte berott på att det varit svårt att få ordning på koden, snarare på grund av andra omständigheter. Inte varit några större problem med själva kodandet som sådant, även om själva tänket har krävt en del anpassning av mig. Lade även till en enkel formulärvalidering med jQuery och ett (modifierat) valideringscript jag hittade på nätet. Hoppas att jag ska kunna få ordning på mig till kommande moment, känns lite som att jag nog tänker för linjärt för att det ska gå helt bra det här.</p>', 'Kursmoment 5', '2010-04-05 22:55:45', '2010-04-05 22:55:45'),
(2, '<p>Börjar bli en ovana detta, med sena inlämningar. Inga stora problem att få det hela att funka, förutom vissa smärre problem av typen trötthetsmisstag. Uppgiften gick betydligt lättare att göra än föregående, även om jag tittade en del på lärarkoden. Skrev dock det mesta av koden på egen hand, förutom databasinnehåll och liknande, där det kändes onödigt att skriva eget. Har inte tidigare jobbat med att hantera lösenord och inloggningar, men väl sessioner i föregående kurs. Rent allmänt känns det bättre att "gömma" P-, C- och F-filer i någon katalog som inte webbservern har direkt tillåtelse att visa (så slipper man göra ett specialfall för folk som försöker komma åt exempelvis PLogin.php utan att gå "via" index.php). Tankenöten fixade jag genom att (hårdkoda) in en redirect, främst pga varierande filstruktur i utvecklings- och driftsversion. Känns som om det här sättet kanske kan gå att jobba i, även om det känns som om en stor switch-sats i index.php kanske kan bli lite otymplig i längden, samt att det är alldeles för lätt att missa att lägga till en ny rad när man lägger till en ny sida.</p>', 'Kursmoment 6', '2010-04-24 20:41:13', '2010-04-24 20:41:13'),
(2, '<p>Övningen gick rätt lätt att genomföra, har arbetat en del med CSS förut, även om jag inte haft varierande antal kolumner förut. Det känns som att det hela börjar likna en fullvärdig mall snart, även om jag kan behöva spendera ett par dagar åt att få en stilmall som man inte kräks av. Löste tankenöten på ett annat sätt än mos, istället för negativa marginaler använde jag mig av absolut positionering, kanske inte det mest praktiska lösningen, men den verkar fungera delvis. Blir dock problem när sidan blir för liten.</p>', 'Kursmoment 7', '2010-04-26 22:20:02', '2010-04-26 22:20:02'),
(2, '<p>Det här kursmomentet var lagom svårt, inget moment som var oöverkomligt, men ändå krävde en hel del tankearbete för att få det att fungera som en helhet. För övrigt borde jag nog gå en kurs i projekthantering, eller ha någon som slår mig på fingrarna till dess att jag lyckas strukturera upp saker och ting innan jag börjar programmera. Jag valde att implementera rss-flöde och se till att koden följer XHTML- och CSS-standarderna. Hade lite problem med att CSS-koden inte ville riktigt som jag, eller rättare sagt, jag hade klantat mig och satt stilattribut på samma element på olika ställen. Tidsåtgången är som vanligt svår att uppskatta, då jag inte arbetat sammanhängande.</p><p>Kursen har överlag varit bra, lite mer säkerhetstänk än föregående kurs. Handledningen har varit bra, hjälp har oftast funnits inom en kort tidsrymd. Mitt omdöme vad gäller innehåll och rekommendationer är nog liknande som föregående kurs: Jag skulle helt klart rekommendera kursen till någon i min bekantskapskrets som är sugen på att lära sig PHP/MySQL. Som helhet sätter jag nog betyget 9/10, överlag bra.</p>', 'Kursmoment 8', '2010-05-24 14:58:00', '2010-05-24 14:58:00'),
(2, '<p>Snart dags för examinationen, hoppas det går bra.</p>', 'Examination', '2010-05-25 10:00:00', '2010-05-25 10:00:00'),
(1, '<p>Ett mycket tråkigt blogginlägg, utan något som helst innehåll</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Nu är det slut</p>', 'Inlägg utan innehåll', '2010-05-25 11:00:00', '2010-05-25 11:00:00');

INSERT INTO {$tableBlogComments} (comment_post_id, comment_author, comment_content, comment_title, comment_email, comment_date) VALUES
  (1, 'Fredrik', 'Mycket bra inlägg!', 'Strålande', 'frela273@gmail.com', '2010-05-07 11:46:50'),
  (2, 'Mikael', 'Uruselt! Gör om, gör rätt', 'Kasst', 'mos@bth.se', '2010-05-06 11:48:00'),
  (3, 'John', 'Toppenbra! Fortsätt så!', 'Bra jobbat', 'john@example.com', '2010-05-08 11:48:30'),
  (3, 'Mikael', 'Bra skrivet, mer sånt.', 'Bra!', 'mos@bth.se', '2010-05-09 11:48:30'),
  (9, 'alöhlg', '&lt;a href="http://www.spam.com/lötsäpörn&gt;Click here&lt;/a&gt;', 'lahhå', 'spamalot', '2010-05-24 16:00:00');
EOD;
?>
