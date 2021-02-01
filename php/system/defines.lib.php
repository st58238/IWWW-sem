<?php

// Version constant ------------------------------------------------------
define('WEB_VERSION', '0.0.1');
define('PHP_MIN_VERSION', '7.1.0');


// DB constants ----------------------------------------------------------
define('DB_DRIVER', 'mysql');
define('DB_SERVER', 'localhost');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'iwww-sem');

define('PDO_DSN', (DB_DRIVER . ':host=' . DB_SERVER . ';port=' . DB_PORT . ';charset=' . DB_CHARSET . ';dbname=' . DB_NAME));
define('PDO_USER', DB_USER);
define('PDO_PASSWORD', DB_PASSWORD);

// System constants ------------------------------------------------------
define('PAGE_SECURITY_ALGO', PASSWORD_BCRYPT);
define('PAGE_SECURITY_ALGO_OPTIONS', ['cost' => 13]);

define('DATE_GENERAL_FORMAT', 'j. n. Y G:i:s');

/**
* Email address regular expression that 99.99% works
* https://emailregexp.com/
*/
define('EMAIL_REGEXP', '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD');

// Role constants --------------------------------------------------------
define('USER', 100);
define('STORAGE', 500);
define('ADMIN', 1000);

// Additional constants --------------------------------------------------
define('VAT_COMMON', 21);
define('VAT_USAGE', 15);

define('VAT', VAT_USAGE);

// Debug defines ---------------------------------------------------------
define('DEBUG_FULL', 252600);
define('DEBUG_PRINT', 126500);
define('DEBUG_NULL', 900000);

define('DEBUG', DEBUG_NULL);

// Country codes (indexes) -----------------------------------------------
define('COUNTRIES', array('Abcházie', 'Afghánistán', 'Albánie', 'Alžírsko', 'Andorra', 'Angola', 'Antigua a Barbuda', 'Argentina', 'Arménie', 'Austrálie', 'Ázerbájdžán', 'Bahamy', 'Bahrajn', 'Bangladéš', 'Barbados', 'Belgie', 'Belize', 'Bělorusko', 'Benin', 'Bhútán', 'Bolívie', 'Bosna a Hercegovina', 'Botswana', 'Brazílie', 'Brunej', 'Bulharsko', 'Burkina Faso', 'Burundi', 'Chile', 'Chorvatsko', 'Čad', 'Černá Hora', 'Česká Republika', 'Čína', 'Čínská republika', 'Dánsko', 'Demokratická republika Kongo', 'Dominika', 'Dominikánská republika', 'Džibutsko', 'Egypt', 'Ekvádor', 'Eritrea', 'Estonsko', 'Etiopie', 'Fidži', 'Filipíny', 'Finsko', 'Francie', 'Gabon', 'Gambie', 'Ghana', 'Grenada', 'Gruzie', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Indie', 'Indonésie', 'Irák', 'Írán', 'Irská republika', 'Island', 'Itálie', 'Izrael', 'Jamajka', 'Japonsko', 'Jemen', 'Jihoafrická republika', 'Jižní Korea', 'Jižní Osetie', 'Jižní Súdán', 'Jordánsko', 'Kambodža', 'Kamerun', 'Kanada', 'Kapverdy', 'Katar', 'Kazachstán', 'Keňa', 'Kiribati', 'Kolumbie', 'Komory', 'Konžská republika', 'Kosovo', 'Kostarika', 'Kuba', 'Kuvajt', 'Kypr', 'Kyrgyzstán', 'Laos', 'Lesotho', 'Libanon', 'Libérie', 'Libye', 'Lichtenštejnsko', 'Litva', 'Lotyšsko', 'Lucembursko', 'Madagaskar', 'Maďarsko', 'Makedonie', 'Malajsie', 'Malawi', 'Maledivy', 'Mali', 'Malta', 'Maroko', 'Marshallovy ostrovy', 'Mauricius', 'Mauritánie', 'Mexiko', 'Mikronésie', 'Moldavsko', 'Monako', 'Mongolsko', 'Mosambik', 'Myanmar', 'Náhorně-karabašská republika', 'Namibie', 'Nauru', 'Německo', 'Nepál', 'Nigérie', 'Nikaragua', 'Nizozemsko', 'Norsko', 'Nový Zéland', 'Omán', 'Pákistán', 'Palau', 'Panama', 'Papua-Nová Guinea', 'Paraguay', 'Peru', 'Pobřeží slonoviny', 'Podněstří', 'Polsko', 'Portugalsko', 'Rakousko', 'Rovníková Guinea', 'Rumunsko', 'Rusko', 'Rwanda', 'Řecko', 'Saharská arabská demokratická republika', 'Salvador', 'Samoa', 'San Marino', 'Saúdská Arábie', 'Senegal', 'Severní Korea', 'Severní Kypr', 'Seychely', 'Sierra Leone', 'Singapur', 'Slovensko', 'Slovinsko', 'Somaliland', 'Somálsko', 'Spojené arabské emiráty', 'Spojené státy americké', 'Srbsko', 'Srí Lanka', 'Stát Palestina', 'Středoafrická republika', 'Súdán', 'Surinam', 'Svatá Lucie', 'Svatý Kryštof a Nevis', 'Svatý Tomáš a Princův ostrov', 'Svatý Vincenc a Grenadiny', 'Svazijsko', 'Sýrie', 'Šalomounovy ostrovy', 'Španělsko', 'Švédsko', 'Švýcarsko', 'Tádžikistán', 'Tanzanie', 'Thajsko', 'Togo', 'Tonga', 'Trinidad a Tobago', 'Tunisko', 'Turecko', 'Turkmenistán', 'Tuvalu', 'Ukrajina', 'Uruguay', 'Uzbekistán', 'Vanuatu', 'Vatikán', 'Velká Británie', 'Venezuela', 'Vietnam', 'Východní Timor', 'Zambie', 'Zimbabwe'));
define('COUNTRY_CZECH', 32);

?>