<?php
/*	
* Plugin Name: Nordic Name Days
* Plugin URI: http://foxnet.fi
* Description: Display current day of the weeek, day and name day.
* Version: 0.2
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
* This Plugin will echo current date and namedays using shortcode [sk-nnd-name-days]
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
	if ( function_exists( 'sk_nnd_name_days_shortcode' ) ) {
	
		echo do_shortcode( '[sk-nnd-name-days]' ); 
		
	}
	?>
*/

/* Set up the plugin. */
add_action( 'plugins_loaded', 'sk_nnd_setup' );

/**
* Sets up the Nordic Name Days plugin and loads files at the appropriate time.
* @since 0.2
*/
function sk_nnd_setup() {

	/* Load the translation of the plugin. */
	load_plugin_textdomain( 'nordic-name-days', false, 'nordic-name-days/languages' );
	
	/* Add shortcode [sk-nnd-name-days]. */
	add_shortcode( 'sk-nnd-name-days', 'sk_nnd_name_days_shortcode' );
	
	/* You can also use shortcode in text widget. */
	add_filter( 'widget_text', 'do_shortcode' );

}

/**
* Add shortcode [sk-nnd-name-days].
* @since 0.2
*/
function sk_nnd_name_days_shortcode( $attr ) {

	extract( shortcode_atts( array(
	'before'		=> '',
	'after'			=> '',
	'language'		=> 'fi',
	'separator'		=> '|',
	'dateformat'	=> 'l j.n.Y',
	), $attr ) );
	
	/* Get name of that id from $language array. For example $sk_nnd_namedays[ 'fi' ][ 1 ] returns Aapeli. Default is 'fi'. */
	$sk_nnd_return_name = sk_nnd_name_days( $language );
	
	/* Current day. */
	$sk_nnd_current_day = '<abbr class="sk-nnd-current-day" title="' . date_i18n( $dateformat ) . '">' . date_i18n( $dateformat ) . '</abbr>';
	
	/* Return current weekday, date and names. */
	$sk_nnd_all = $sk_nnd_current_day . ' <span class="sk-nnd-separator">' . $separator . '</span> <span class="sk-nnd-name">' . $sk_nnd_return_name . '</span>';
	
	/* Return shorcode. */
	return $attr['before'] . $sk_nnd_all . $attr['after'];
	
}

/**
* Controls names.
* @since 0.1
*/
function sk_nnd_name_days( $language ) {
	
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
		),
		'nb_NO' => array(
			'Nyttårsdag', 'Dagfinn, Dagfrid', 'Alfred, Alf', 'Roar, Roger',
			'Hanna, Hanne', 'Aslaug, Åslaug', 'Eldbjørg, Knut', 'Turid, Torfinn',
			'Gunnar, Gunn', 'Sigmund, Sigrun', 'Børge, Børre', 'Reinhard, Reinert',
			'Gisle, Gislaug', 'Herbjørn, Herbjørg', 'Laurits, Laura',
			'Hjalmar, Hilmar', 'Anton, Tønnes, Tony', 'Hildur, Hild',
			'Marius, Margunn', 'Fabian, Sebastian, Bastian', 'Agnes, Agnete',
			'Ivan, Vanja', 'Emil, Emilie, Emma', 'Joar, Jarle, Jarl', 'Paul, Pål',
			'Øystein, Esten', 'Gaute, Gurli, Gry', 'Karl, Karoline',
			'Herdis, Hermod, Hermann', 'Gunnhild, Gunda', 'Idun, Ivar',
			'Birte, Bjarte', 'Jomar, Jostein', 'Ansgar, Asgeir', 'Veronika, Vera',
			'Agate, Ågot', 'Dortea, Dorte', 'Rikard, Rigmor, Riborg', 'Åshild, Åsne',
			'Lone, Leikny', 'Ingfrid, Ingrid', 'Ingve, Yngve',
			'Randulf, Randi, Ronja', 'Svanhild, Svanaug', 'Hjørdis, Jardar',
			'Sigfred, Sigbjørn', 'Julian, Juliane, Jill',
			'Aleksandra, Sandra, Sondre', 'Frøydis, Frode', 'Ella, Elna',
			'Halldis, Halldor', 'Samuel, Selma, Celine', 'Tina, Tim',
			'Torstein, Torunn', 'Mattias,Mattis, Mats', 'Viktor, Viktoria',
			'Inger, Ingjerd', 'Laila, Lill', 'Marina, Maren', 'Ingen namnedag',
			'Audny, Audun', 'Erna, Ernst', 'Gunnbjørg, Gunnveig', 'Ada, Adrian',
			'Patrick, Patricia', 'Annfrid, Andor', 'Arild, Are',
			'Beate, Betty, Bettina', 'Sverre, Sindre', 'Edel, Edle', 'Edvin, Tale',
			'Gregor, Gro', 'Greta, Grete', 'Mathilde, Mette',
			'Christel, Christer, Chris', 'Gudmund, Gudny', 'Gjertrud, Trude',
			'Aleksander, Sander, Edvard', 'Josef, Josefine', 'Joakim, Kim',
			'Bendik, Bengt, Bent', 'Paula, Pauline', 'Gerda, Gerd', 'Ulrikke, Rikke',
			'Maria, Marie, Mari', 'Gabriel, Glenn', 'Rudolf, Rudi', 'Åsta, Åste',
			'Jonas, Jonatan', 'Holger, Olga', 'Vebjørn, Vegard', 'Aron, Arve, Arvid',
			'Sigvard, Sivert', 'Gunnvald, Gunvor', 'Nanna, Nancy, Nina',
			'Irene, Eirin, Eiril', 'Åsmund, Asmund', 'Oddveig, Oddvin', 'Asle, Atle',
			'Rannveig, Rønnaug', 'Ingvald, Ingveig', 'Ylva, Ulf', 'Julius, Julie',
			'Asta, Astrid', 'Ellinor, Nora', 'Oda, Odin, Odd', 'Magnus, Mons',
			'Elise, Else, Elsa', 'Eilen, Eilert', 'Arnfinn, Arnstein',
			'Kjellaug, Kjellrun', 'Jeanette, Jannike', 'Oddgeir, Oddny',
			'Georg, Jørgen, Jørn', 'Albert, Olaug', 'Markus, Mark', 'Terese, Tea',
			'Charles, Charlotte, Lotte', 'Vivi, Vivian', 'Toralf, Torolf',
			'Gina, Gitte', 'Filip, Valborg', 'Åsa, Åse', 'Gjermund, Gøril',
			'Monika, Mona', 'Gudbrand, Gullborg', 'Guri, Gyri', 'Maia, Mai, Maiken',
			'Åge, Åke', 'Kasper, Jesper', 'Asbjørg, Asbjørn, Espen', 'Magda, Malvin',
			'Normann, Norvald', 'Linda, Line, Linn', 'Kristian, Kristen, Karsten',
			'Hallvard, Halvor', 'Sara, Siren', 'Harald, Ragnhild',
			'Eirik, Erik, Erika', 'Torjus, Torje, Truls', 'Bjørnar, Bjørnhild',
			'Helene, Ellen, Eli', 'Henning, Henny', 'Oddleif, Oddlaug', 'Ester, Iris',
			'Ragna, Ragnar', 'Annbjørg, Annlaug', 'Katinka, Cato',
			'Vilhelm, William, Willy', 'Magnar, Magnhild', 'Gard, Geir',
			'Pernille, Preben', 'June, Juni', 'Runa, Runar, Rune', 'Rasmus, Rakel',
			'Heidi, Heid', 'Torbjørg, Torbjørn, Torben', 'Gustav, Gyda',
			'Robert, Robin', 'Renate, René', 'Kolbein, Kolbjørn', 'Ingolf, Ingunn',
			'Borgar, Bjørge, Bjørg', 'Sigfrid, Sigrid, Siri', 'Tone, Tonje, Tanja',
			'Erlend, Erland', 'Vigdis, Viggo', 'Torhild, Toril, Tiril',
			'Botolv, Bodil', 'Bjarne, Bjørn', 'Erling, Elling', 'Salve, Sølve, Sølvi',
			'Agnar, Annar', 'Håkon, Maud', 'Elfrid, eldrid', 'Johannes, Jon, Hans',
			'Jørund, Jorunn', 'Jenny, Jonny', 'Aina, Ina, Ine', 'Lea, Leo, Leon',
			'Peter, Petter, Per', 'Solbjørg, Solgunn', 'Ask, Embla',
			'Kjartan, Kjellfrid', 'Andrea, Andrine, André', 'Ulrik, Ulla',
			'Mirjam, Mina', 'Torgrim, Torgunn', 'Håvard, Hulda',
			'Sunniva, Synnøve, Synne', 'Gøran, Jøran, Ørjan', 'Anita, Anja',
			'Kjetil, Kjell', 'Elias, Eldar', 'Mildrid, Melissa, Mia',
			'Solfrid, Solrun', 'Oddmund, Oddrun', 'Susanne, Sanna', 'Guttorm, Gorm',
			'Arnulf, Ørnulf', 'Gerhard, Gjert', 'Margareta, Margit, Marit',
			'Johanne, Janne, Jane', 'Malene, Malin, Mali', 'Brita, Brit, Britt',
			'Kristine, Kristin, Kristi', 'Jakob, Jack, Jim', 'Anna, Anne, Ane',
			'Marita, Rita', 'Reidar, Reidun', 'Olav, Ola, Ole',
			'Aurora, Audhild, Aud', 'Elin, Eline', 'Peder, Petra', 'Karen, Karin',
			'Oline, Oliver, Olve', 'Arnhild, Arna, Arne', 'Osvald, Oskar',
			'Gunnlaug, Gunnleiv', 'Didrik, Doris', 'Evy, Yvonne', 'Ronald, Ronny',
			'Lorents, Lars, Lasse', 'Torvald, Tarald', 'Klara, Camilla',
			'Anny, Anine, Ann', 'Hallgeir, Hallgjerd', 'Margot, Mary, Marielle',
			'Brynjulf, Brynhild', 'Verner, Wenche', 'Tormod, Torodd',
			'Sigvald, Sigve', 'Bernhard, Bernt', 'Ragnvald, Ragni', 'Harriet, Harry',
			'Signe, Signy', 'Belinda, Bertil', 'Ludvig, Lovise, Lousie',
			'Øyvind, Eivind, Even', 'Roald, Rolf', 'Artur, August', 'Johan, Jone, Jo',
			'Benjamin, Ben', 'Berta, Berte', 'Solveig, Solvor', 'Lisa, Lise, Liss',
			'Alise, Alvhild, Vilde', 'Ida, Idar', 'Brede, Brian, Njål',
			'Sollaug, Siril, Siv', 'Regine, Rose', 'Amalie, Alma, Allan',
			'Trygve, Tyra, Trym', 'Tord, Tor', 'Dagny, Dag', 'Jofrid, Jorid',
			'Stian, Stig', 'Ingebjørg, Ingeborg', 'Aslak, Eskil', 'Lillian, Lilly',
			'Hildebjørg, Hildegunn', 'Henriette, Henry', 'Konstanse, Connie',
			'Tobias, Tage', 'Trine, Trond', 'Kyrre, Kåre', 'Snorre, Snefrid',
			'Jan, Jens', 'Ingvar, Yngvar', 'Einar, Endre', 'Dagmar, Dagrun',
			'Lena, Lene', 'Mikael, Mikal, Mikkel', 'Helga, Helge, Hege',
			'Rebekka, Remi', 'Live, Liv', 'Evald, Evelyn', 'Frans, Frank',
			'Brynjar, Boye, Bo', 'Målfrid, Møyfrid', 'Birgitte, Birgit, Berit',
			'Benedikte, Bente', 'Leidulf, Leif', 'Fridtjof, Frida, Frits',
			'Kevin, Kennet, Kent', 'Valter, Vibeke', 'Torgeir, Terje, Tarjei',
			'Kaia, Kai', 'Hedvig, Hedda', 'Flemming, Finn', 'Marta, Marte',
			'Kjersti, Kjerstin', 'Tora, Tore', 'Henrik, Heine, Henrikke',
			'Bergljot, Birger', 'Karianne, Karine, Kine', 'Severin, Søren',
			'Eilif, Eivor', 'Margrete, Merete, Märtha', 'Amandus, Amanda',
			'Sturla, Sture', 'Simon, Simen', 'Noralf, Norunn', 'Aksel, Ånund, Ove',
			'Edit, Edna', 'Veslemøy, Vetle', 'Tove, Tuva', 'Raymond, Roy',
			'Otto, Ottar', 'Egil, Egon', 'Leonard, Lennart', 'Ingebrigt, Ingelin',
			'Ingvild, Yngvild', 'Tordis, Teodor', 'Gudbjørg, Gudveig',
			'Martin, Morten, Martine', 'Torkjell, Torkil', 'Kirsten, Kirsti',
			'Fredrik, Fred, Freddy', 'Oddfrid, Oddvar', 'Edmund, Edgar',
			'Hugo, Hogne, Hauk', 'Magne, Magny', 'Elisabeth, Lisbet',
			'Halvdan, Helle', 'Mariann, Marianne', 'Cecilie, Silje, Sissel',
			'Klement, Klaus', 'Gudrun, Guro', 'Katarina, Katrine, Kari',
			'Konrad, Kurt', 'Torlaug, Torleif', 'Ruben, Rut', 'Sofie, Sonja',
			'Andreas, Anders', 'Arnold, Arnljot, Arnt', 'Borghild, Borgny, Bård',
			'Sveinung, Svein', 'Barbara, Barbro', 'Stine, Ståle', 'Nils, Nikolai',
			'Hallfrid, Hallstein', 'Marlene, Marion, Morgan', 'Anniken, Annette',
			'Judit, Jytte', 'Daniel, Dan', 'Pia, Peggy', 'Lucia, Lydia',
			'Steinar, Stein', 'Hilda, Hilde', 'Oddbjørg, Oddbjørn', 'Inga, Inge',
			'Kristoffer, Kate', 'Iselin, Isak', 'Abraham, Amund', 'Tomas, Tom, Tommy',
			'Ingemar, Ingar', 'Sigurd, Sjur', 'Adam, Eva', 'Første juledag',
			'Stefan, Steffen', 'Narve, Natalie', 'Unni, Une, Unn', 'Vidar, Vemund',
			'David, Diana, Dina', 'Sylfest, Sylvia, Sylvi'
		),
		'sv_SE' => array(
			'Nyårsdagen', 'Svea, Sverker', 'Alfred, Alfrida', 'Rut, Ritva',
			'Hanna, Hannele', 'Kasper, Melker, Baltsar', 'August, Augusta',
			'Erland, Erhard', 'Gunnar, Gunder', 'Sigurd, Sigbritt, Sigmund',
			'Jan, Jannike, Hugo, Hagar', 'Frideborg, Fridolf', 'Knut',
			'Felix, Felicia', 'Laura, Lorentz, Liv', 'Hjalmar, Helmer, Hervor',
			'Anton, Tony', 'Hilda, Hildur', 'Henrik, Henry', 'Fabian, Sebastian',
			'Agnes, Agneta', 'Vincent, Viktor, Veine', 'Frej, Freja, Emilia, Emilie',
			'Erika, Eira', 'Paul, Pål', 'Bodil, Boel', 'Göte, Göta', 'Karl, Karla',
			'Diana, Valter, Vilma', 'Gunilla, Gunhild', 'Ivar, Joar',
			'Max, Maximilian, Magda', 'Marja, Mia', 'Disa, Hjördis', 'Ansgar, Anselm',
			'Agata, Agda, Lisa, Elise', 'Dorotea, Doris, Dora', 'Rikard, Dick',
			'Berta, Bert, Berthold', 'Fanny, Franciska, Betty', 'Iris, Egon, Egil',
			'Yngve, Inge, Ingolf', 'Evelina, Evy', 'Agne, Ove, Agnar',
			'Valentin, Tina', 'Sigfrid, Sigbritt', 'Julia, Julius, Jill',
			'Alexandra, Sandra', 'Frida, Fritiof, Fritz', 'Gabriella, Ella',
			'Vivianne, Rasmus, Ruben', 'Hilding, Hulda', 'Pia, Marina, Marlene',
			'Torsten, Torun', 'Mattias, Mats', 'Sigvard, Sivert', 'Torgny, Torkel',
			'Lage, Laila', 'Maria, Maja', 'Skottdagen', 'Albin, Elvira, Inez',
			'Ernst, Erna', 'Gunborg, Gunvor', 'Adrian, Adriana, Ada',
			'Tora, Tove, Tor', 'Ebba, Ebbe', 'Camilla, Isidor, Doris', 'Siv, Saga',
			'Torbjörn, Torleif', 'Edla, Ada, Ethel', 'Edvin, Egon, Elon',
			'Viktoria, Viktor', 'Greger, Iris', 'Matilda, Maud',
			'Kristoffer, Christel', 'Herbert, Gilbert', 'Gertrud',
			'Edvard, Edmund, Eddie', 'Josef, Josefina', 'Joakim, Kim', 'Bengt, Benny',
			'Kennet, Kent, Viking, Vilgot', 'Gerda, Gerd, Gert', 'Gabriel, Rafael',
			'Mary, Marion', 'Emanuel, Manne', 'Rudolf, Ralf, Raymond',
			'Malkolm, Morgan', 'Jonas, Jens', 'Holger, Holmfrid, Reidar',
			'Ester, Estrid', 'Harald, Hervor, Halvar',
			'Gudmund, Ingemund, Gunnel, Gun', 'Ferdinand, Nanna, Florence',
			'Marianne, Marlene', 'Irene, Irja', 'Vilhelm, Helmi, Willy',
			'Irma, Irmelin, Mimmi', 'Nadja, Tanja, Vanja, Ronja', 'Otto, Ottilia',
			'Ingvar, Ingvor', 'Ulf, Ylva', 'Liv, Julius, Gillis', 'Artur, Douglas',
			'Tiburtius, Tim', 'Olivia, Oliver', 'Patrik, Patricia', 'Elias, Elis',
			'Valdemar, Volmar', 'Olaus, Ola', 'Amalia, Amelie, Emelie',
			'Anneli, Annika', 'Allan, Glenn, Alida', 'Georg, Göran', 'Vega, Viveka',
			'Markus, Mark', 'Teresia, Terese', 'Engelbrekt, Enok', 'Ture, Tyra',
			'Tyko, Kennet, Kent', 'Mariana, Marianne', 'Valborg, Maj',
			'Filip, Filippa', 'John, Jane, Jack', 'Monika, Mona',
			'Gotthard, Erhard, Vivianne, Vivan', 'Marit, Rita',
			'Carina, Carita, Lilian, Lilly', 'Åke', 'Reidar, Reidun, Jonatan, Gideon',
			'Esbjörn, Styrbjörn, Elvira, Elvy', 'Märta, Märit', 'Charlotta, Lotta',
			'Linnea, Linn, Nina', 'Halvard, Halvar, Lillemor, Lill', 'Sofia, Sonja',
			'Ronald, Ronny, Hilma, Hilmer', 'Rebecka, Ruben, Nore, Nora',
			'Erik, Jerker', 'Maj, Majken, Majvor', 'Karolina, Carola, Lina',
			'Konstantin, Conny', 'Hemming, Henning', 'Desideria, Desirée, Renee',
			'Ivan, Vanja, Yvonne', 'Urban, Ursula', 'Vilhelmina, Vilma, Helmy',
			'Beda, Blenda', 'Ingeborg, Borghild', 'Yvonne, Jeanette, Jean',
			'Vera, Veronika, Fritiof, Frej', 'Petronella, Pernilla, Isabella, Isa',
			'Gun, Gunnel, Rune, Runa', 'Rutger, Roger', 'Ingemar, Gudmar',
			'Solbritt, Solveig', 'Bo, Boris', 'Gustav, Gösta', 'Robert, Robin',
			'Eivor, Majvor, Elaine', 'Börje, Birger, Petra, Petronella',
			'Svante, Boris, Kerstin, Karsten', 'Bertil, Berthold, Berit',
			'Eskil, Esbj', 'Aina, Aino, Eila', 'Håkan, Hakon', 'Margit, Margot, Mait',
			'Axel, Axelina', 'Torborg, Torvald', 'Björn, Bjarne',
			'Germund, Görel, Jerry', 'Linda, Linn', 'Alf, Alvar, Alva',
			'Paulina, Paula', 'Adolf, Alice, Adela', 'Johan, Jan', 'David, Salomon',
			'Rakel, Lea, Gunni, Jim', 'Selma, Fingal, Herta', 'Leo, Leopold',
			'Peter, Petra', 'Elof, Leif', 'Aron, Mirjam', 'Rosa, Rosita',
			'Aurora, Adina', 'Ulrika, Ulla', 'Laila, Ritva, Melker, Agaton',
			'Esaias, Jessika, Ronald, Ronny', 'Klas, Kaj', 'Kjell, Tjelvar',
			'Jörgen, Örjan', 'André, Andrea, Anund, Gunda', 'Eleonora, Ellinor',
			'Herman, Hermine', 'Joel, Judit', 'Folke, Odd', 'Ragnhild, Ragnvald',
			'Reinhold, Reine', 'Bruno, Alexis, Alice', 'Fredrik, Fritz, Fred',
			'Sara, Sally', 'Margareta, Greta', 'Johanna, Jane',
			'Magdalena, Madeleine', 'Emma, Emmy', 'Kristina, Kerstin, Stina',
			'Jakob, James', 'Jesper, Jessika', 'Marta, Moa', 'Botvid, Seved',
			'Olof, Olle', 'Algot, Margot', 'Helena, Elin, Elna', 'Per, Pernilla',
			'Karin, Kajsa', 'Tage, Tanja', 'Arne, Arnold', 'Ulrik, Alrik',
			'Alfons, Inez', 'Dennis, Denise, Donald', 'Silvia, Sylvia',
			'Roland, Roine', 'Lars, Lorentz', 'Susanna, Sanna', 'Klara, Clary',
			'Kaj, Hillevi, Gullvi', 'Uno, William, Bill', 'Stella, Estelle, Stefan',
			'Brynolf, Sigyn', 'Verner, Valter, Veronika', 'Ellen, Lena, Helena',
			'Magnus, Måns', 'Bernhard, Bernt', 'Jon, Jonna',
			'Henrietta, Henrika, Henny', 'Signe, Signhild', 'Bartolomeus, Bert',
			'Lovisa, Louise', 'Östen', 'Rolf, Raoul, Rudolf', 'Gurli, Leila, Gull',
			'Hans, Hampus', 'Albert, Albertina', 'Arvid, Vidar', 'Samuel, Sam',
			'Justus, Justina', 'Alfhild, Alva, Alfons', 'Gisela, Glenn',
			'Adela, Heidi, Harry, Harriet', 'Lilian, Lilly, Sakarias, Esaias',
			'Regina, Roy', 'Alma, Hulda, Ally', 'Anita, Annette, Anja',
			'Tord, Turid, Tove', 'Dagny, Helny, Daniela', 'Åsa, Åslög, Tyra',
			'Sture, Styrbj', 'Ida, Ellida', 'Sigrid, Siri', 'Dag, Daga',
			'Hildegard, Magnhild', 'Orvar, Alvar', 'Fredrika, Carita',
			'Elise, Lisa, Agda, Agata', 'Matteus, Ellen, Elly',
			'Maurits, Moritz, Morgan', 'Tekla, Tea', 'Gerhard, Gert', 'Tryggve',
			'Enar, Einar', 'Dagmar, Rigmor', 'Lennart, Leonard', 'Mikael, Mikaela',
			'Helge, Helny', 'Ragnar, Ragna', 'Ludvig, Love, Louis', 'Evald, Osvald',
			'Frans, Frank', 'Bror, Bruno', 'Jenny, Jennifer', 'Birgitta, Britta',
			'Nils, Nelly', 'Ingrid, Inger', 'Harry, Harriet, Helmer, Hadar',
			'Erling, Jarl', 'Valfrid, Manfred, Ernfrid', 'Berit, Birgit, Britt',
			'Stellan, Manfred, Helfrid', 'Hedvig, Hillevi, Hedda', 'Finn, Fingal',
			'Antonia, Toini, Annette', 'Lukas, Matteus', 'Tore, Torleif',
			'Sibylla, Camilla', 'Ursula, Yrsa, Birger', 'Marika, Marita',
			'Severin, Sören', 'Evert, Eilert', 'Inga, Ingalill, Ingvald',
			'Amanda, Rasmus, My', 'Sabina, Ina', 'Simon, Simone', 'Viola, Vivi',
			'Elsa, Isabella, Elsie', 'Edit, Edgar', 'Andre, Andrea', 'Tobias, Toini',
			'Hubert, Hugo, Diana', 'Sverker, Uno, Unn', 'Eugen, Eugenia',
			'Gustav Adolf', 'Ingegerd, Ingela', 'Vendela, Vanda',
			'Teodor, Teodora, Ted', 'Martin, Martina', 'Mårten', 'Konrad, Kurt',
			'Kristian, Krister', 'Emil, Emilia, Mildred', 'Leopold, Katja, Nadja',
			'Vibeke, Viveka, Edmund, Gudmund', 'Naemi, Naima, Nancy',
			'Lillemor, Moa, Pierre, Percy', 'Elisabet, Lisbeth',
			'Pontus, Marina, Pia', 'Helga, Olga', 'Cecilia, Sissela, Cornelia',
			'Klemens, Clarence', 'Gudrun, Rune, Runar', 'Katarina, Katja, Carina',
			'Linus, Love', 'Astrid, Asta', 'Malte, Malkolm', 'Sune, Synn',
			'Andreas, Anders', 'Oskar, Ossian', 'Beata, Beatrice', 'Lydia, Carola',
			'Barbara, Barbro', 'Sven, Svante', 'Nikolaus, Niklas', 'Angela, Angelika',
			'Virginia, Vera', 'Anna, Annie', 'Malin, Malena', 'Daniel, Daniela, Dan',
			'Alexander, Alexis, Alex', 'Lucia', 'Sten, Sixten, Stig',
			'Gottfrid, Gotthard', 'Assar, Astor', 'Stig, Inge, Ingemund',
			'Abraham, Efraim', 'Isak, Rebecka', 'Israel, Moses', 'Tomas, Tom',
			'Natanael, Jonatan, Natalia', 'Adam', 'Eva', 'Juldagen',
			'Stefan, Staffan', 'Johannes, Johan, Hannes', 'Benjamin',
			'Natalia, Natalie', 'Abel, Set, Gunl', 'Sylvester'
		),
		'da_DK' => array(
			'Nytårsdag', 'Abel', 'Enoch', 'Metusalem', 'Simeon', 'Hellige 3 Konger',
			'Knud', 'Erhardt', 'Julianus', 'Paul', 'Hygimus', 'Reinhold', 'Hilarius',
			'Felix', 'Maurus', 'Marcellus', 'Antonius', 'Prisca', 'Pontiaus',
			'Fabian, Sebastian', 'Agnes', 'Vincentius', 'Emerentius', 'Timotheus',
			'Pauli Omvendelsesdag', 'Polycarpus', 'Chrysostomus',
			'Carolus, Magnus, Karl', 'Valerius', 'Adelgunde', 'Vigilius', 'Brigida',
			'Kyndelmisse', 'Blasius', 'Veronica', 'Agathe', 'Dorothea', 'Richard',
			'Corintha', 'Apollonia', 'Scholastica', 'Euphrosyne', 'Eulalia',
			'Benignus', 'Valentinus', 'Faustinus', 'Juliane', 'Findanus', 'Concordia',
			'Ammon', 'Eucharias', 'Samuel', 'Peters Stol', 'Papias', 'Skuddag',
			'Mattias', 'Victorinus', 'Inger', 'Leander', 'Øllegaard', 'Albinus',
			'Simplicius', 'Kunigunde', 'Adrianus', 'Theophillus', 'Gotfred',
			'Perpetua', 'Beata', 'Fyrre riddere', 'Edel', 'Thala', 'Gregorius',
			'Macedonius', 'Eutychius', 'Zacharias', 'Gudmund', 'Gertrud', 'Alexander',
			'Joseph', 'Gordius', 'Benedictus', 'Paulus', 'Fidelis', 'Judica, Ulrica',
			'Maria bebudelsesdag', 'Gabriel', 'Kastor', 'Eustachius', 'Jonas',
			'Quirinus', 'Balbina', 'Hugo', 'Theodosius', 'Nicæas', 'Ambrosius',
			'Irene', 'Sixtus', 'Egesippus', 'Janus', 'Otto, Procopius', 'Ezechiel',
			'Leo', 'Julius', 'Justinus', 'Tiburtius', 'Olympia', 'Mariane',
			'Anicetus', 'Eleutherius', 'Daniel', 'Sulpicius', 'Florentius', 'Cajus',
			'Georgius', 'Albertus', 'Markus', 'Cletus', 'Ananias', 'Vitalis',
			'Peter Martyr', 'Serverus, Valborg', 'Jacob, Philip, Valborg',
			'Athanasius', 'Kormisse', 'Florian', 'Gothard', 'Johannes ante portam',
			'Flavia', 'Stanislaus', 'Caspar', 'Gordianus', 'Mamertus', 'Pancratius',
			'Ingenuus', 'Kristian', 'Sophie', 'Sara', 'Bruno', 'Erik', 'Potentiana',
			'Angelica', 'Helene', 'Castus', 'Desiderus', 'Esther', 'Urbanus', 'Beda',
			'Lucian', 'Vilhelm', 'Maciminus', 'Vigand', 'Petronella', 'Nikodemus',
			'Marcellinus', 'Erasmus', 'Optatus', 'Bonifacius', 'Nobertus', 'Jeremias',
			'Medardus', 'Primus', 'Onuphrius', 'Barnabas', 'Balisius', 'Cyrillus',
			'Rufinus', 'Vitus', 'Tycho', 'Botolphus', 'Leontius', 'Gervasius',
			'Sylverius', 'Albanus', '10.000 martyrer', 'Paulinus', 'Sankt Hans dag',
			'Prosper', 'Pelagius', 'Syvsoverdag', 'Eleonora', 'Petrus, Paulus',
			'Lucina', 'Theobaldus', 'Maria besøgelsesdag', 'Cornelius', 'Ulricus',
			'Anshelmus', 'Dion', 'Villebaldus', 'Kjeld', 'Sostrata', 'Knud Konge',
			'Josva', 'Henrik', 'Margrethe', 'Bonaventura', 'Apostlenes deling',
			'Tychos', 'Alecius', 'Arnolphus', 'Justa', 'Elias', 'Evenus',
			'Maria Magdalene', 'Apollinaris', 'Christina', 'Jacobus', 'Anna',
			'Martha', 'Aurelius', 'Oluf', 'Abdon', 'Helena, Germanus',
			'Peter fængsel', 'Hannibal', 'Nikodemus', 'Dominicus', 'Osvaldus',
			'Kristi forklarelse', 'Donatus', 'Tuth', 'Rosmanus', 'Laurentius',
			'Herman', 'Clara', 'Hippolytus', 'Eusebius', 'Maria himmelfart', 'Rochus',
			'Anastatius', 'Agapetus', 'Selbadus', 'Bernhard, Bernhard', 'Salomon',
			'Symphorian', 'Zakæus', 'Bartholomæus', 'Ludvig', 'Ienæus', 'Gebhardus',
			'Augustinus', 'Johannes halshuggelsesdag', 'Albert, Benjamin', 'Bertha',
			'Ægidius', 'Elisa', 'Seraphia', 'Theodosias', 'Regina', 'Magnus',
			'Robert', 'Maria fødselsdag', 'Gorgonius', 'Buchardt', 'Hillebert',
			'Guido', 'Cyprianus', 'Korsets ophøjelsesdag', 'Eskild', 'Euphemia',
			'Lambertu', 'Titus', 'Constantia', 'Tobias', 'Matthæus', 'Mauritius',
			'Linus', 'Tecla', 'Cleophas', 'Adolph', 'Cosmus', 'Venceslaus',
			'St. Michael', 'Hieronymus', 'Remigius', 'Ditlev', 'Mette', 'Franciscus',
			'Placidus', 'Broderus', 'Amalie', 'Ingeborg', 'Dionysius', 'Gereon',
			'Probus', 'Maximillian', 'Angelus', 'Calixus', 'Hedevig', 'Gallus',
			'Floretinus', 'Lucas', 'Balthasar', 'Felicianus', 'Ursula', 'Cordula',
			'Søren', 'Proclus', 'Crispinus', 'Amandus', 'Sem', 'Judas, Simon',
			'Narcissus', 'Elsa, Absalon', 'Louise', 'Allehelgensdag',
			'Alle sjæles dag', 'Hubertus', 'Otto', 'Malachias', 'Leonhardus',
			'Engelbrecht', 'Cladius', 'Theodor', 'Luther', 'Morten bisp', 'Torkild',
			'Arcadius', 'Frederik', 'Leopold', 'Othenius', 'Anianus', 'Hesychius',
			'Elisabeth', 'Volkmarus', 'Maria ofring', 'Cecilia', 'Clemens',
			'Chrysogonus', 'Catharina', 'Conradus', 'Facindus', 'Sophie, Magdalene',
			'Saturnius', 'Andreas', 'Arnold', 'Bibiana', 'Svend', 'Barbara', 'Sabina',
			'Nikolaus', 'Agathon', 'Maria undfangelse', 'Rudolph', 'Judith',
			'Damasus', 'Epimachus', 'Lucia', 'Crispus', 'Nikatius', 'Lazarus',
			'Albina', 'Lovise', 'Nemesius', 'Abraham', 'Thomas', 'Japetus',
			'Torlacus', 'Adam, Alexandrine', 'Juledag', 'Stefan',
			'Johannes evangeliets dag', 'Børnedag', 'Noa', 'David', 'Sylvester'
		)
	);
	
	// Day id with leading zeros. So 21.2. is day id 0221
	$sk_nnd_dayid = date( 'md' );
	
	// for example 0107 gets id 6 from $sk_nnd_days array
	$sk_nnd_namelistid = $sk_nnd_days[ $sk_nnd_dayid ];
	
	// Get name of that id from fi array. For example $sk_nnd_namedays[ 'fi' ][ 1 ] returns Aapeli
	$sk_nnd_return_name = $sk_nnd_namedays[ $language ][ $sk_nnd_namelistid ];
	
	// Return name of a day
	return $sk_nnd_return_name;
	
}
?>