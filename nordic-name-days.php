<?php
/*	
* Plugin Name: Nordic Name Days
* Plugin URI: http://foxnet.fi
* Description: Display current day of the weeek, day and name day.
* Version: 0.1
* Author: Sami Keijonen
* Author URI: http://foxnet.fi
* Licence: GPLv2

	Copyright 2012 Sami Keijonen (email : sami.keijonen@foxnet.fi)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

* Display current date and namedays
*
* This Plugin will echo current date and namedays using function sk_nnd_nimipaivat()
*
* @return	string		Echos current date and namedays
*
*
--------------------------------------------------------------------------------
Usage
--------------------------------------------------------------------------------
Original idea from International Namedays plugin
@link: http://kgyt.hu/

Put this code in your template file to show name days

   <?php 
	// Display name of the day
	if ( function_exists( 'sk_nnd_nimipaivat' ) ) {
  		sk_nnd_nimipaivat(); 
}
	?>
*/

// Loads Plugin textdomain
	load_plugin_textdomain( 'nordic-name-days', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

function sk_nnd_nimipaivat() {
	
	// Current day
	$sk_nnd_today = date( 'j.n.Y' );
	
	// Day id with leading zeros. So 21.2 is day id 0221
	$sk_nnd_dayid = date( 'md' );
	
	// Numeric representation of the day of the week. 0 is Sunday, 6 is Saturday.
	$sk_nnd_day_week = date( 'w' );
	
	// Translate to finnish Maanantai, Tiistai etc.
	$sk_nnd_week_days = array(
		'0' => __( 'Sunday', 'nordic-name-days' ),
		'1' => __( 'Monday', 'nordic-name-days' ),
		'2' => __( 'Tuesday', 'nordic-name-days' ),
		'3' => __( 'Wednesday', 'nordic-name-days' ),
		'4' => __( 'Thursday', 'nordic-name-days' ),
		'5' => __( 'Friday', 'nordic-name-days' ),
		'6' => __( 'Saturday', 'nordic-name-days' )
		);
	
	// Initialize days
	$sk_nnd_days = array(
		'0101' =>   0, '0102' =>   1, '0103' =>   2, '0104' =>   3, '0105' =>   4,
		'0106' =>   5, '0107' =>   6, '0108' =>   7, '0109' =>   8, '0110' =>   9,
		'0111' =>  10, '0112' =>  11, '0113' =>  12, '0114' =>  13, '0115' =>  14,
		'0116' =>  15, '0117' =>  16, '0118' =>  17, '0119' =>  18, '0120' =>  19,
		'0121' =>  20, '0122' =>  21, '0123' =>  22, '0124' =>  23, '0125' =>  24,
		'0126' =>  25, '0127' =>  26, '0128' =>  27, '0129' =>  28, '0130' =>  29,
		'0131' =>  30, '0201' =>  31, '0202' =>  32, '0203' =>  33, '0204' =>  34,
		'0205' =>  35, '0206' =>  36, '0207' =>  37, '0208' =>  38, '0209' =>  39,
		'0210' =>  40, '0211' =>  41, '0212' =>  42, '0213' =>  43, '0214' =>  44,
		'0215' =>  45, '0216' =>  46, '0217' =>  47, '0218' =>  48, '0219' =>  49,
		'0220' =>  50, '0221' =>  51, '0222' =>  52, '0223' =>  53, '0224' =>  54,
		'0225' =>  55, '0226' =>  56, '0227' =>  57, '0228' =>  58, '0229' =>  59,
		'0301' =>  50, '0302' =>  61, '0303' =>  62, '0304' =>  63, '0305' =>  64,
		'0306' =>  65, '0307' =>  66, '0308' =>  67, '0309' =>  68, '0310' =>  69,
		'0311' =>  70, '0312' =>  71, '0313' =>  72, '0314' =>  73, '0315' =>  74,
		'0316' =>  75, '0317' =>  76, '0318' =>  77, '0319' =>  78, '0320' =>  79,
		'0321' =>  80, '0322' =>  81, '0323' =>  82, '0324' =>  83, '0325' =>  84,
		'0326' =>  85, '0327' =>  86, '0328' =>  87, '0329' =>  88, '0330' =>  89,
		'0331' =>  90, '0401' =>  91, '0402' =>  92, '0403' =>  93, '0404' =>  94,
		'0405' =>  95, '0406' =>  96, '0407' =>  97, '0408' =>  98, '0409' =>  99,
		'0410' => 100, '0411' => 101, '0412' => 102, '0413' => 103, '0414' => 104,
		'0415' => 105, '0416' => 106, '0417' => 107, '0418' => 108, '0419' => 109,
		'0420' => 110, '0421' => 111, '0422' => 112, '0423' => 113, '0424' => 114,
		'0425' => 115, '0426' => 116, '0427' => 117, '0428' => 118, '0429' => 119,
		'0430' => 120, '0501' => 121, '0502' => 122, '0503' => 123, '0504' => 124,
		'0505' => 125, '0506' => 126, '0507' => 127, '0508' => 128, '0509' => 129,
		'0510' => 130, '0511' => 131, '0512' => 132, '0513' => 133, '0514' => 134,
		'0515' => 135, '0516' => 136, '0517' => 137, '0518' => 138, '0519' => 139,
		'0520' => 140, '0521' => 141, '0522' => 142, '0523' => 143, '0524' => 144,
		'0525' => 145, '0526' => 146, '0527' => 147, '0528' => 148, '0529' => 149,
		'0530' => 150, '0531' => 151, '0601' => 152, '0602' => 153, '0603' => 154,
		'0604' => 155, '0605' => 156, '0606' => 157, '0607' => 158, '0608' => 159,
		'0609' => 160, '0610' => 161, '0611' => 162, '0612' => 163, '0613' => 164,
		'0614' => 165, '0615' => 166, '0616' => 167, '0617' => 168, '0618' => 169,
		'0619' => 170, '0620' => 171, '0621' => 172, '0622' => 173, '0623' => 174,
		'0624' => 175, '0625' => 176, '0626' => 177, '0627' => 178, '0628' => 179,
		'0629' => 180, '0630' => 181, '0701' => 182, '0702' => 183, '0703' => 184,
		'0704' => 185, '0705' => 186, '0706' => 187, '0707' => 188, '0708' => 189,
		'0709' => 190, '0710' => 191, '0711' => 192, '0712' => 193, '0713' => 194,
		'0714' => 195, '0715' => 196, '0716' => 197, '0717' => 198, '0718' => 199,
		'0719' => 200, '0720' => 201, '0721' => 202, '0722' => 203, '0723' => 204,
		'0724' => 205, '0725' => 206, '0726' => 207, '0727' => 208, '0728' => 209,
		'0729' => 210, '0730' => 211, '0731' => 212, '0801' => 213, '0802' => 214,
		'0803' => 215, '0804' => 216, '0805' => 217, '0806' => 218, '0807' => 219,
		'0808' => 220, '0809' => 221, '0810' => 222, '0811' => 223, '0812' => 224,
		'0813' => 225, '0814' => 226, '0815' => 227, '0816' => 228, '0817' => 229,
		'0818' => 230, '0819' => 231, '0820' => 232, '0821' => 233, '0822' => 234,
		'0823' => 235, '0824' => 236, '0825' => 237, '0826' => 238, '0827' => 239,
		'0828' => 240, '0829' => 241, '0830' => 242, '0831' => 243, '0901' => 244,
		'0902' => 245, '0903' => 246, '0904' => 247, '0905' => 248, '0906' => 249,
		'0907' => 250, '0908' => 251, '0909' => 252, '0910' => 253, '0911' => 254,
		'0912' => 255, '0913' => 256, '0914' => 257, '0915' => 258, '0916' => 259,
		'0917' => 260, '0918' => 261, '0919' => 262, '0920' => 263, '0921' => 264,
		'0922' => 265, '0923' => 266, '0924' => 267, '0925' => 268, '0926' => 269,
		'0927' => 270, '0928' => 271, '0929' => 272, '0930' => 273, '1001' => 274,
		'1002' => 275, '1003' => 276, '1004' => 277, '1005' => 278, '1006' => 279,
		'1007' => 280, '1008' => 281, '1009' => 282, '1010' => 283, '1011' => 284,
		'1012' => 285, '1013' => 286, '1014' => 287, '1015' => 288, '1016' => 289,
		'1017' => 290, '1018' => 291, '1019' => 292, '1020' => 293, '1021' => 294,
		'1022' => 295, '1023' => 296, '1024' => 297, '1025' => 298, '1026' => 299,
		'1027' => 300, '1028' => 301, '1029' => 302, '1030' => 303, '1031' => 304,
		'1101' => 305, '1102' => 306, '1103' => 307, '1104' => 308, '1105' => 309,
		'1106' => 310, '1107' => 311, '1108' => 312, '1109' => 313, '1110' => 314,
		'1111' => 315, '1112' => 316, '1113' => 317, '1114' => 318, '1115' => 319,
		'1116' => 320, '1117' => 321, '1118' => 322, '1119' => 323, '1120' => 324,
		'1121' => 325, '1122' => 326, '1123' => 327, '1124' => 328, '1125' => 329,
		'1126' => 330, '1127' => 331, '1128' => 332, '1129' => 333, '1130' => 334,
		'1201' => 335, '1202' => 336, '1203' => 337, '1204' => 338, '1205' => 339,
		'1206' => 340, '1207' => 341, '1208' => 342, '1209' => 343, '1210' => 344,
		'1211' => 345, '1212' => 346, '1213' => 347, '1214' => 348, '1215' => 349,
		'1216' => 350, '1217' => 351, '1218' => 352, '1219' => 353, '1220' => 354,
		'1221' => 355, '1222' => 356, '1223' => 357, '1224' => 358, '1225' => 359,
		'1226' => 360, '1227' => 361, '1228' => 362, '1229' => 363, '1230' => 364,
		'1231' => 365
	);
	
$sk_nnd_namedays = array(
		'fi' => array(
			'Uudenvuodenpäivä', 'Aapeli', 'Elmo, Elmeri, Elmer', 'Ruut',
			'Lea, Leea', 'Harri', 'Aku, Aukusti, August',
			'Titta, Hilppa', 'Veikko, Veli, Veijo, Veikka', 'Nyyrikki',
			'Kari, Karri', 'Toini', 'Nuutti',
			'Sakari, Saku', 'Solja', 'Ilmari, Ilmo',
			'Toni, Anton, Antto, Anttoni', 'Laura', 'Heikki, Henrik, Henna, Henriikka, Henri', 'Sebastian',
			'Aune, Oona, Auni, Netta', 'Visa', 'Enni, Eine, Eini',
			'Senja', 'Paavo, Pauli, Paavali, Paul', 'Joonatan', 'Viljo', 'Kalle, Kaarlo, Kaarle, Mies',
			'Valtteri', 'Irja', 'Alli', /* Tammikuu päättyy */
			'Riitta', 'Jemina, Aamu, Lumi', 'Valo', 'Armi, Ronja',
			'Asser', 'Terhi, Teija, Tiia, Tea, Terhikki', 'Riku, Rikhard',
			'Laina', 'Raija, Raisa', 'Elina, Ella, Ellen',
			'Talvikki', 'Elma, Elmi', 'Sulo, Sulho',
			'Voitto, Valentin, Tino', 'Sipi, Sippo', 'Kai',
			'Väinö, Väinämö, Karita, Rita', 'Kaino', 'Eija',
			'Heli, Helinä, Hely', 'Keijo', 'Tuulikki, Tuuli, Tuulia, Hilda',
			'Aslak', 'Matti, Matias', 'Tuija, Tuire', 'Nestori',
			'Torsti', 'Onni', 'Karkauspäivä', /* Helmikuu loppuu */
			'Alpo, Alpi, Alvi',
			'Virve, Virva, Fanni', 'Kauko', 'Ari, Arsi, Atro',
			'Leila, Laila', 'Tarmo', 'Tarja, Taru', 'Vilppu',
			'Auvo', 'Aurora, Aura, Auri', 'Kalervo',
			'Reijo, Reko', 'Erno, Ernesti, Tarvo', 'Matilda, Tilda, Mette',
			'Risto', 'Ilkka', 'Kerttu, Kerttuli',
			'Eetu, Edvard', 'Juuso, Josefiina, Joosef, Jooseppi', 'Aki, Kim, Joakim, Jaakkima', 'Pentti',
			'Vihtori', 'Akseli', 'Gabriel, Kaapo, Kaappo, Kaapro',
			'Aija', 'Manu, Manne, Immanuel, Immo', 'Sauli, Saul',
			'Armas', 'Jouni, Joni, Joonas, Joona, Jonne, Jonni', 'Usko',
			'Irma, Irmeli', /* Maaliskuu päättyy */
			'Raita, Pulmu, Peppi',
			'Pellervo', 'Sampo, Veeti',
			'Ukko', 'Irene, Irina, Ira, Iro', 'Ville, Vilho, Viljami, Jami, Vilhelm, Vili',
			'Allan, Ahvo', 'Suoma, Suometar', 'Elias, Eelis, Eeli, Eljas',
			'Tero', 'Verna, Minea', 'Julia, Julius, Janna, Juliaana', 'Tellervo',
			'Taito', 'Linda, Tuomi', 'Jalo, Patrik', 'Otto',
			'Valto, Valdemar', 'Pilvi, Pälvi', 'Lauha, Nella',
			'Anssi, Anselmi', 'Alina', 'Yrjö, Jyrki, Jyri, Jiri, Jori, Yrjänä', 'Pertti, Albert, Altti',
			'Markku, Marko, Markus', 'Terttu, Tessa, Teresa', 'Merja', 'Ilpo, Tuure, Ilppo',
			'Teijo', 'Mirja, Miia, Mira, Mirva, Mirjami, Mirka, Mirkka', /* Huhtikuu päättyy */
			'Vappu, Valpuri', 'Vuokko, Viivi', 'Outi', 'Roosa, Ruusu, Rosa',
			'Maini, Melina', 'Ylermi',
			'Helmi, Kastehelmi', 'Heino', 'Timo, Timi',
			'Aino, Aini, Aina, Ainikki', 'Osmo', 'Lotta',
			'Kukka, Floora', 'Tuula', 'Sofia, Sonja, Sohvi',
			'Ester, Essi, Esteri', 'Maila, Rebekka, Maili, Mailis, Maisa',
			'Erkki, Eero, Eerika, Eerik, Eerikki, Erkka', 'Emilia, Emma, Mila, Amalia, Emmi, Milja, Milka, Milla',
			'Lilja, Karoliina, Lilli', 'Kosti, Konsta, Konstantin', 'Hemminki, Hemmo', 'Lyydia, Lyyli',
			'Tuukka, Touko', 'Urpo', 'Minna, Vilma, Miina, Mimmi, Vilhelmiina',
			'Ritva', 'Alma', 'Oiva, Oliver, Olivia',
			'Pasi', 'Helka, Helga', /* Toukokuu päättyy */
			'Teemu, Nikodemus', 'Venla', 'Orvokki, Viola',
			'Toivo', 'Sulevi', 'Kustaa, Kyösti, Kustavi', 'Suvi, Roope, Robert',
			'Salomon, Salomo', 'Ensio',
			'Seppo', 'Impi, Immi',
			'Esko', 'Raili, Raila', 'Kielo, Pihla', 'Vieno, Moona, Viena',
			'Päivi, Päivikki, Päivä', 'Urho', 'Tapio',
			'Siiri', 'Into', 'Ahti, Ahto',
			'Paula, Pauliina, Liina', 'Aatu, Aatto, Aadolf', 'Johannes, Juhani, Jussi, Jani, Janne, Juha, Juhana, Juho, Jukka', 'Uuno',
			'Jorma, Jarmo, Jarkko, Jarno, Jere, Jeremias', 'Elviira, Elvi', 'Leo',
			'Pekka, Petri, Petra, Pekko, Petteri, Pietari', 'Päiviö, Päivö', /* Kesäkuu loppuu */
			'Aaro, Aaron', 'Maria, Maija, Mari, Meeri, Kukka-Maaria, Maaria, Maiju, Maikki, Marika, Riia', 
			'Arvo', 'Ulla, Ulpu', 'Unto, Untamo',
			'Esa, Esaias', 'Klaus, Launo', 'Turo, Turkka',
			'Jasmin, Ilta, Jade', 'Saima, Saimi', 'Elli, Noora, Nelli, Eleonoora',
			'Hermanni, Herkko, Herman', 'Joel, Ilari, Lari', 'Aliisa, Alisa', 'Rauni, Rauna',
			'Reino', 'Ossi, Ossian', 'Riikka',
			'Sari, Saara, Sara, Salla, Salli', 'Marketta, Maarit, Maaret, Margareeta, Reeta, Reetta',
			'Johanna, Hanna, Jenni, Hanne, Hannele, Jenna, Joanna',
			'Leena, Leeni, Lenita, Matleena', 'Olga, Oili', 
			'Tiina, Kirsti, Kirsi, Kiia, Krista, Kristiina, Tinja',
			'Jaakko, Jimi, Jaakob, Jaakoppi', 'Martta', 'Heidi', 'Atso',
			'Olavi, Olli, Uolevi, Uoti', 'Asta', 'Helena, Elena', /* Heinäkuu päättyy */
			'Maire', 'Kimmo', 'Nea, Linnea, Neea, Vanamo', 'Veera', 'Salme, Sanelma',
			'Toimi, Keimo', 'Lahja', 'Sylvi, Sylvia, Silva',
			'Erja, Eira', 'Lauri, Lasse, Lassi', 'Sanna, Susanna, Sanni, Susanne', 'Klaara',
			'Jesse', 'Onerva, Kanerva', 'Marjatta, Marja, Jaana, Marianna, Marjo, Marjut',
			'Aulis', 'Verneri', 'Leevi',
			'Mauno, Maunu', 'Sami, Samuli, Samu, Samuel', 'Soini, Veini',
			'Iivari, Iivo', 'Signe, Varma', 'Perttu',
			'Loviisa', 'Ilmi, Ilma, Ilmatar', 'Rauli', 'Tauno',
			'Iina, Iines, Inari', 'Eemil, Eemeli', 'Arvi', /* Elokuu päättyy */
			'Pirkka', 'Sinikka, Sini, Justus', 'Soile, Soili, Soila', 'Ansa',
			'Roni, Mainio', 'Asko',
			'Miro, Arho, Arhippa', 'Taimi', 'Eevert, Isto, Vertti',
			'Kalevi, Kaleva', 'Santeri, Aleksanteri, Aleksandra, Ale, Ali, Sandra', 'Valma, Vilja',
			'Orvo', 'Iida', 'Sirpa', 'Hilla, Hellevi, Hille, Hillevi',
			'Aili, Aila', 'Tyyne, Tytti, Tyyni', 'Reija',
			'Varpu, Vaula', 'Mervi',
			'Mauri', 'Mielikki, Miisa, Minja', 'Alvar, Auno', 'Kullervo',
			'Kuisma', 'Vesa', 'Arja, Lenni', 'Mikko, Mika, Mikael, Mikaela, Miika, Miikka, Miko, Miska',
			'Sirja, Sorja, Siru', /* Syyskuu päättyy */
			'Rauno, Rainer, Raine', 'Valio', 'Raimo',
			'Saija, Saila, Frans', 'Inkeri, Inka', 'Pinja, Minttu', 'Pirkko, Pirjo, Birgitta, Pirita, Piritta',
			'Hilja', 'Ilona', 'Aleksi, Aleksis',
			'Otso, Ohto', 'Aarre, Aarto', 'Taina, Tanja, Taija',
			'Elsa, Else, Elsi', 'Helvi, Heta', 'Sirkka, Sirkku',
			'Saana, Saini', 'Satu, Säde, Luukas', 'Uljas',
			'Kasperi, Kauno, Jasper, Jesper', 'Ursula', 'Anja, Anita, Anniina, Anitta, Anette',
			'Severi', 'Rasmus, Asmo', 'Sointu',
			'Niina, Nina, Amanda, Manta, Ninni', 'Helli, Hellin, Helle, Hellä', 'Simo', 'Alfred, Urmas',
			'Eila', 'Arto, Arttu, Artturi', /* Lokakuu päättyy */
			'Pyry, Lyly', 'Topi, Topias', 'Terho', 'Hertta', 'Reima',
			'Kustaa Aadolfin päivä', 'Taisto', 'Aatos',
			'Teuvo', 'Martti', 'Panu', 'Virpi',
			'Kristian, Ano', 'Iiris', 'Janina, Janika, Janita, Janette',
			'Aarne, Aarno, Aarni', 'Eino, Einari',
			'Tenho, Jousia, Max', 'Liisa, Elisa, Eliisa, Elisabet, Elise, Liisi',
			'Jari, Jalmari', 'Hilma', 'Silja, Selja',
			'Ismo', 'Lempi, Lemmikki, Sivi', 'Katri, Kaija, Katja, Kaisa, Kati, Kaarina, Kaisu, Katariina, Katriina, Riina',
			'Sisko', 'Hilkka', 'Heini, Kaisla', 'Aimo',
			'Antti, Antero, Atte', /* Marraskuu päättyy */
			'Oskari', 'Anelma, Unelma', 'Meri, Vellamo',
			'Airi, Aira', 'Selma', 'Niilo, Niko, Niki, Niklas, Nikolai', 'Sampsa',
			'Kyllikki, Kylli', 'Anna, Anne, Anni, Anu, Anneli, Annika, Annikki, Annukka', 'Jutta', 'Tatu, Taneli, Daniel',
			'Tuovi', 'Seija', 'Jouko',
			'Heimo', 'Auli, Aulikki, Aada', 'Raakel',
			'Aapo, Rami, Aappo', 'Iiro, Iisakki, Iikka, Isko', 'Benjamin, Kerkko', 'Tuomas, Tomi, Tommi, Tuomo',
			'Raafael', 'Senni', 'Aatami, Eeva, Eevi, Eveliina', 'Joulupäivä',
			'Tapani, Teppo, Tahvo', 'Hannu, Hannes, Hans', 'Piia',
			'Rauha', 'Taavetti, Taavi, Daavid', 'Sylvester, Silvo'
		)
	);
	// for example 0107 gets id 6 from $sk_nnd_days array
	$sk_nnd_namelistid = $sk_nnd_days[ $sk_nnd_dayid ];
	
	// Get name of that id from fi array. For example $sk_nnd_namedays[ 'fi' ][ 1 ] returns Aapeli
	$sk_nnd_return_name = $sk_nnd_namedays[ 'fi' ][ $sk_nnd_namelistid ];
	
	// Get week day: Sunday, Monday, etc.
	$sk_nnd_week_day = $sk_nnd_week_days[ $sk_nnd_day_week ]; 
	
	// echo current weekday, date and names
	echo $sk_nnd_week_day . ' ' .$sk_nnd_today . ' | ' .$sk_nnd_return_name;
	
}
?>