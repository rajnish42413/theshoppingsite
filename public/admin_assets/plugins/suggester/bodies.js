var bodies = [
	{"value": "Sun", "cssClass": "star"},	
	{"value": "Mercury", "cssClass": "planet"},
	{"value": "Venus", "cssClass": "planet"},
	{"value": "Earth", "cssClass": "planet"},
	{"value": "Mars", "cssClass": "planet"},
	{"value": "Asteroid Belt", "cssClass": "object"},
	{"value": "Jupiter", "cssClass": "planet"},
	{"value": "Saturn", "cssClass": "planet"},
	{"value": "Uranus", "cssClass": "planet"},
	{"value": "Neptune", "cssClass": "planet"},
	{"value": "Pluto", "cssClass": "dwarf-planet"},
	{"value": "Eres", "cssClass": "dwarf-planet"},
	{"value": "Andromeda", "cssClass": "constellation"},
	{"value": "Mirach", "cssClass": "star"},
	{"value": "Almach", "cssClass": "star"},
	{"value": "Adhil", "cssClass": "star"},
	{"value": "Antlia", "cssClass": "constellation"},
	{"value": "Apus", "cssClass": "constellation"},
	{"value": "Aquarius", "cssClass": "constellation"},
	{"value": "Sadal Melik", "cssClass": "star"},
	{"value": "Sadal Suud", "cssClass": "star"},
	{"value": "Sadachbia", "cssClass": "star"},
	{"value": "Scheat", "cssClass": "star"},
	{"value": "Al Bali", "cssClass": "star"},
	{"value": "Ancha", "cssClass": "star"},
	{"value": "Situla", "cssClass": "star"},
	{"value": "Aquila", "cssClass": "constellation"},
	{"value": "Altair", "cssClass": "star"},
	{"value": "Alshain", "cssClass": "star"},
	{"value": "Tarazed", "cssClass": "star"},
	{"value": "Al Thalimain", "cssClass": "star"},
	{"value": "Ara", "cssClass": "constellation"},
	{"value": "Tchou", "cssClass": "star"},
	{"value": "Aries", "cssClass": "constellation"},
	{"value": "Hamal", "cssClass": "star"},
	{"value": "Sheratan", "cssClass": "star"},
	{"value": "Mesarthim", "cssClass": "star"},
	{"value": "Botein", "cssClass": "star"},
	{"value": "Auriga", "cssClass": "constellation"},
	{"value": "Capella", "cssClass": "star"},
	{"value": "Menkalinan", "cssClass": "star"},
	{"value": "Prijipati", "cssClass": "star"},
	{"value": "Maaz", "cssClass": "star"},
	{"value": "Sadatoni", "cssClass": "star"},
	{"value": "Kabdhilinan", "cssClass": "star"},
	{"value": "Bootes", "cssClass": "constellation"},
	{"value": "Arcturus", "cssClass": "star"},
	{"value": "Nakkar", "cssClass": "star"},
	{"value": "Seginus", "cssClass": "star"},
	{"value": "Muphrid", "cssClass": "star"},
	{"value": "Alkalurops", "cssClass": "star"},
	{"value": "Caelum", "cssClass": "constellation"},
	{"value": "Camelopardalis", "cssClass": "constellation"},
	{"value": "Cancer", "cssClass": "constellation"},
	{"value": "Acubens", "cssClass": "star"},
	{"value": "Tarf", "cssClass": "star"},
	{"value": "Asellus Borealis", "cssClass": "star"},
	{"value": "Asellus Australis", "cssClass": "star"},
	{"value": "Tegmine", "cssClass": "star"},
	{"value": "Canes Venatici", "cssClass": "constellation"},
	{"value": "Cor Caroli", "cssClass": "star"},
	{"value": "Chara", "cssClass": "star"},
	{"value": "Canis Major", "cssClass": "constellation"},
	{"value": "Sirius", "cssClass": "star"},
	{"value": "Mirzam", "cssClass": "star"},
	{"value": "Muliphein", "cssClass": "star"},
	{"value": "Wezen", "cssClass": "star"},
	{"value": "Adhara", "cssClass": "star"},
	{"value": "Furud", "cssClass": "star"},
	{"value": "Aludra", "cssClass": "star"},
	{"value": "Canis Minor", "cssClass": "constellation"},
	{"value": "Procyon", "cssClass": "star"},
	{"value": "Gomeisa", "cssClass": "star"},
	{"value": "Capricornus", "cssClass": "constellation"},
	{"value": "Al Giedi", "cssClass": "star"},
	{"value": "Dabih", "cssClass": "star"},
	{"value": "Nashira", "cssClass": "star"},
	{"value": "Deneb Algiedi", "cssClass": "star"},
	{"value": "Carina", "cssClass": "constellation"},
	{"value": "Canopus", "cssClass": "star"},
	{"value": "Miaplacidus", "cssClass": "star"},
	{"value": "Avior", "cssClass": "star"},
	{"value": "Aspidiske", "cssClass": "star"},
	{"value": "Cassiopeia", "cssClass": "constellation"},
	{"value": "Schedar", "cssClass": "star"},
	{"value": "Caph", "cssClass": "star"},
	{"value": "Tsih", "cssClass": "star"},
	{"value": "Ruchbah", "cssClass": "star"},
	{"value": "Navi", "cssClass": "star"},
	{"value": "Achird", "cssClass": "star"},
	{"value": "Centaurus", "cssClass": "constellation"},
	{"value": "Rigel Kentaurus", "cssClass": "star"},
	{"value": "Hadar", "cssClass": "star"},
	{"value": "Muhlifain", "cssClass": "star"},
	{"value": "Menkent", "cssClass": "star"},
	{"value": "Ke Kwan", "cssClass": "star"},
	{"value": "Cepheus", "cssClass": "constellation"},
	{"value": "Alderamin", "cssClass": "star"},
	{"value": "Alfirk", "cssClass": "star"},
	{"value": "Er Rai", "cssClass": "star"},
	{"value": "Kurhah", "cssClass": "star"},
	{"value": "The Garnet Star", "cssClass": "star"},
	{"value": "Cetus", "cssClass": "constellation"},
	{"value": "Menkar", "cssClass": "star"},
	{"value": "Deneb Kaitos", "cssClass": "star"},
	{"value": "Kaffaljidhmah", "cssClass": "star"},
	{"value": "Baten Kaitos", "cssClass": "star"},
	{"value": "Schemali", "cssClass": "star"},
	{"value": "Mira", "cssClass": "star"},
	{"value": "Chamaeleon", "cssClass": "constellation"},
	{"value": "Circinus", "cssClass": "constellation"},
	{"value": "Columba", "cssClass": "constellation"},
	{"value": "Phact Of Phaet", "cssClass": "star"},
	{"value": "Wezn", "cssClass": "star"},
	{"value": "Tsze", "cssClass": "star"},
	{"value": "Coma Berenices", "cssClass": "constellation"},
	{"value": "Corona Australis", "cssClass": "constellation"},
	{"value": "Corona Borealis", "cssClass": "constellation"},
	{"value": "Alphecca", "cssClass": "star"},
	{"value": "Nusakan", "cssClass": "star"},
	{"value": "Corvus", "cssClass": "constellation"},
	{"value": "Alchibah", "cssClass": "star"},
	{"value": "Gienah", "cssClass": "star"},
	{"value": "Algorab", "cssClass": "star"},
	{"value": "Minkar", "cssClass": "star"},
	{"value": "Crater", "cssClass": "constellation"},
	{"value": "Alkes", "cssClass": "star"},
	{"value": "Crux", "cssClass": "constellation"},
	{"value": "Acrux", "cssClass": "star"},
	{"value": "Mimosa", "cssClass": "star"},
	{"value": "Gacrux", "cssClass": "star"},
	{"value": "Cygnus", "cssClass": "constellation"},
	{"value": "Deneb", "cssClass": "star"},
	{"value": "Albireo", "cssClass": "star"},
	{"value": "Sadr", "cssClass": "star"},
	{"value": "Gienah", "cssClass": "star"},
	{"value": "Ruchba", "cssClass": "star"},
	{"value": "Azelfafage", "cssClass": "star"},
	{"value": "Delphinus", "cssClass": "constellation"},
	{"value": "Sualocin", "cssClass": "star"},
	{"value": "Rotanev", "cssClass": "star"},
	{"value": "Deneb", "cssClass": "star"},
	{"value": "Dorado", "cssClass": "constellation"},
	{"value": "Draco", "cssClass": "constellation"},
	{"value": "Thuban", "cssClass": "star"},
	{"value": "Rastaban", "cssClass": "star"},
	{"value": "Eltanin", "cssClass": "star"},
	{"value": "Nodus Secundus", "cssClass": "star"},
	{"value": "Kaou Pih", "cssClass": "star"},
	{"value": "Edasich", "cssClass": "star"},
	{"value": "Giauzar", "cssClass": "star"},
	{"value": "Arrakis", "cssClass": "star"},
	{"value": "Kuma", "cssClass": "star"},
	{"value": "Grumium", "cssClass": "star"},
	{"value": "Alsafi", "cssClass": "star"},
	{"value": "Dziban", "cssClass": "star"},
	{"value": "Equuleus", "cssClass": "constellation"},
	{"value": "Kitalpha", "cssClass": "star"},
	{"value": "Eridanus", "cssClass": "constellation"},
	{"value": "Achernar", "cssClass": "star"},
	{"value": "Cursa", "cssClass": "star"},
	{"value": "Zaurak", "cssClass": "star"},
	{"value": "Rana", "cssClass": "star"},
	{"value": "Azha", "cssClass": "star"},
	{"value": "Acamar", "cssClass": "star"},
	{"value": "Beid", "cssClass": "star"},
	{"value": "Keid", "cssClass": "star"},
	{"value": "Angetenar", "cssClass": "star"},
	{"value": "Fornax", "cssClass": "constellation"},
	{"value": "Gemini", "cssClass": "constellation"},
	{"value": "Castor", "cssClass": "star"},
	{"value": "Pollux", "cssClass": "star"},
	{"value": "Almeisan", "cssClass": "star"},
	{"value": "Wasat", "cssClass": "star"},
	{"value": "Mebsuta", "cssClass": "star"},
	{"value": "Mekbuda", "cssClass": "star"},
	{"value": "Grus", "cssClass": "constellation"},
	{"value": "Al Dhanab", "cssClass": "star"},
	{"value": "Hercules", "cssClass": "constellation"},
	{"value": "Ras Algethi", "cssClass": "star"},
	{"value": "Kornephoros", "cssClass": "star"},
	{"value": "Sarin", "cssClass": "star"},
	{"value": "Maasim", "cssClass": "star"},
	{"value": "Marfik", "cssClass": "star"},
	{"value": "Cujam", "cssClass": "star"},
	{"value": "Horologium", "cssClass": "constellation"},
	{"value": "Hydra", "cssClass": "constellation"},
	{"value": "Alphard", "cssClass": "star"},
	{"value": "Minhar Al Shuja", "cssClass": "star"},
	{"value": "Ukdah", "cssClass": "star"},
	{"value": "Hydrus", "cssClass": "constellation"},
	{"value": "Indus", "cssClass": "constellation"},
	{"value": "Al Nair", "cssClass": "star"},
	{"value": "Lacerta", "cssClass": "constellation"},
	{"value": "Leo", "cssClass": "constellation"},
	{"value": "Denebola", "cssClass": "star"},
	{"value": "Al Gieba", "cssClass": "star"},
	{"value": "Zozma", "cssClass": "star"},
	{"value": "Ras Elased", "cssClass": "star"},
	{"value": "Adhafera", "cssClass": "star"},
	{"value": "Coxa", "cssClass": "star"},
	{"value": "Tsze Tseang", "cssClass": "star"},
	{"value": "Alterf", "cssClass": "star"},
	{"value": "Rasalas", "cssClass": "star"},
	{"value": "Leo Minor", "cssClass": "constellation"},
	{"value": "Praecipula", "cssClass": "star"},
	{"value": "Lepus", "cssClass": "constellation"},
	{"value": "Arneb", "cssClass": "star"},
	{"value": "Nihal", "cssClass": "star"},
	{"value": "Libra", "cssClass": "constellation"},
	{"value": "Zuben El Genubi", "cssClass": "star"},
	{"value": "Zuben Eschamali", "cssClass": "star"},
	{"value": "Zubenhakrabi", "cssClass": "star"},
	{"value": "Lupus", "cssClass": "constellation"},
	{"value": "Men", "cssClass": "star"},
	{"value": "Lynx", "cssClass": "constellation"},
	{"value": "Lyra", "cssClass": "constellation"},
	{"value": "Vega", "cssClass": "star"},
	{"value": "Sheliak", "cssClass": "star"},
	{"value": "Sulafat", "cssClass": "star"},
	{"value": "Aladfar", "cssClass": "star"},
	{"value": "Al Athfar", "cssClass": "star"},
	{"value": "Mensa", "cssClass": "constellation"},
	{"value": "Microscopium", "cssClass": "constellation"},
	{"value": "Monoceros", "cssClass": "constellation"},
	{"value": "Musca", "cssClass": "constellation"},
	{"value": "Norma", "cssClass": "constellation"},
	{"value": "Octans", "cssClass": "constellation"},
	{"value": "Ophiuchus", "cssClass": "constellation"},
	{"value": "Ras Alhague", "cssClass": "star"},
	{"value": "Cheleb", "cssClass": "star"},
	{"value": "Yed Prior", "cssClass": "star"},
	{"value": "Yed Posterior", "cssClass": "star"},
	{"value": "Sabik", "cssClass": "star"},
	{"value": "Marfik", "cssClass": "star"},
	{"value": "Orion", "cssClass": "constellation"},
	{"value": "Betelgeuse", "cssClass": "star"},
	{"value": "Rigel", "cssClass": "star"},
	{"value": "Bellatrix", "cssClass": "star"},
	{"value": "Mintaka", "cssClass": "star"},
	{"value": "Alnilam", "cssClass": "star"},
	{"value": "Alnitak", "cssClass": "star"},
	{"value": "Saiph", "cssClass": "star"},
	{"value": "Heka", "cssClass": "star"},
	{"value": "Thabit", "cssClass": "star"},
	{"value": "Pavo", "cssClass": "constellation"},
	{"value": "The Peacock Star", "cssClass": "star"},
	{"value": "Pegasus", "cssClass": "constellation"},
	{"value": "Markab", "cssClass": "star"},
	{"value": "Scheat", "cssClass": "star"},
	{"value": "Algenib", "cssClass": "star"},
	{"value": "Enif", "cssClass": "star"},
	{"value": "Homam", "cssClass": "star"},
	{"value": "Matar", "cssClass": "star"},
	{"value": "Baham", "cssClass": "star"},
	{"value": "Sadalbari", "cssClass": "star"},
	{"value": "Perseus", "cssClass": "constellation"},
	{"value": "Mirfak", "cssClass": "star"},
	{"value": "Algol", "cssClass": "star"},
	{"value": "Menkib", "cssClass": "star"},
	{"value": "Atik", "cssClass": "star"},
	{"value": "Phoenix", "cssClass": "constellation"},
	{"value": "Ankaa", "cssClass": "star"},
	{"value": "Pictor", "cssClass": "constellation"},
	{"value": "Pisces", "cssClass": "constellation"},
	{"value": "Al Rescha", "cssClass": "star"},
	{"value": "Fum Al Samakah", "cssClass": "star"},
	{"value": "Piscis Austrinus", "cssClass": "constellation"},
	{"value": "Fomalhaut", "cssClass": "star"},
	{"value": "Puppis", "cssClass": "constellation"},
	{"value": "Naos", "cssClass": "star"},
	{"value": "Asmidiske", "cssClass": "star"},
	{"value": "Pyxis", "cssClass": "constellation"},
	{"value": "Reticulum", "cssClass": "constellation"},
	{"value": "Sagitta", "cssClass": "constellation"},
	{"value": "Sagittarius", "cssClass": "constellation"},
	{"value": "Rukbat", "cssClass": "star"},
	{"value": "Arkab", "cssClass": "star"},
	{"value": "Kaus Media", "cssClass": "star"},
	{"value": "Kaus Australis", "cssClass": "star"},
	{"value": "Ascella", "cssClass": "star"},
	{"value": "Kaus Borealis", "cssClass": "star"},
	{"value": "Nunki", "cssClass": "star"},
	{"value": "Scorpius", "cssClass": "constellation"},
	{"value": "Antares", "cssClass": "star"},
	{"value": "Graffias", "cssClass": "star"},
	{"value": "Dschubba", "cssClass": "star"},
	{"value": "Sargas", "cssClass": "star"},
	{"value": "Shaula", "cssClass": "star"},
	{"value": "Jabbah", "cssClass": "star"},
	{"value": "Al Niyat", "cssClass": "star"},
	{"value": "Lesath", "cssClass": "star"},
	{"value": "Jabhat Al Akrab", "cssClass": "star"},
	{"value": "Sculptor", "cssClass": "constellation"},
	{"value": "Scutum", "cssClass": "constellation"},
	{"value": "Serpens", "cssClass": "constellation"},
	{"value": "Unuk Al Hay", "cssClass": "star"},
	{"value": "Chow", "cssClass": "star"},
	{"value": "Alya", "cssClass": "star"},
	{"value": "Sextans", "cssClass": "constellation"},
	{"value": "Taurus", "cssClass": "constellation"},
	{"value": "Aldebaran", "cssClass": "star"},
	{"value": "El Nath", "cssClass": "star"},
	{"value": "Primus Hyadum", "cssClass": "star"},
	{"value": "Ain", "cssClass": "star"},
	{"value": "Atlas", "cssClass": "star"},
	{"value": "Electra", "cssClass": "star"},
	{"value": "Maia", "cssClass": "star"},
	{"value": "Merope", "cssClass": "star"},
	{"value": "Taygeta", "cssClass": "star"},
	{"value": "Celaeno", "cssClass": "star"},
	{"value": "Telescopium", "cssClass": "constellation"},
	{"value": "Triangulum", "cssClass": "constellation"},
	{"value": "Mothallah", "cssClass": "star"},
	{"value": "Triangulum Australe", "cssClass": "constellation"},
	{"value": "Atria", "cssClass": "star"},
	{"value": "Tucana", "cssClass": "constellation"},
	{"value": "Ursa Major", "cssClass": "constellation"},
	{"value": "Merak", "cssClass": "star"},
	{"value": "Phad", "cssClass": "star"},
	{"value": "Megrez", "cssClass": "star"},
	{"value": "Alioth", "cssClass": "star"},
	{"value": "Mizar", "cssClass": "star"},
	{"value": "Alcor", "cssClass": "star"},
	{"value": "Alkaid", "cssClass": "star"},
	{"value": "Al Haud", "cssClass": "star"},
	{"value": "Talitha Boreali", "cssClass": "star"},
	{"value": "Talitha Australis", "cssClass": "star"},
	{"value": "Tania Borealis", "cssClass": "star"},
	{"value": "Tania Australis", "cssClass": "star"},
	{"value": "Alula Borealis", "cssClass": "star"},
	{"value": "Alula Australis", "cssClass": "star"},
	{"value": "Muscida", "cssClass": "star"},
	{"value": "Ursa Minor", "cssClass": "constellation"},
	{"value": "Polaris", "cssClass": "star"},
	{"value": "Kochab", "cssClass": "star"},
	{"value": "Pherkab", "cssClass": "star"},
	{"value": "Yildun", "cssClass": "star"},
	{"value": "Vela", "cssClass": "constellation"},
	{"value": "Suhail", "cssClass": "star"},
	{"value": "Markab", "cssClass": "star"},
	{"value": "Suhail", "cssClass": "star"},
	{"value": "Tseen Ke", "cssClass": "star"},
	{"value": "Virgo", "cssClass": "constellation"},
	{"value": "Spica", "cssClass": "star"},
	{"value": "Zavijava", "cssClass": "star"},
	{"value": "Porrima", "cssClass": "star"},
	{"value": "Auva", "cssClass": "star"},
	{"value": "Vindemiatrix", "cssClass": "star"},
	{"value": "Heze", "cssClass": "star"},
	{"value": "Zaniah", "cssClass": "star"},
	{"value": "Syrma", "cssClass": "star"},
	{"value": "Volans", "cssClass": "constellation"},
	{"value": "Vulpecula", "cssClass": "constellation"}	
]