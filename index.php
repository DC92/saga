<link  href="index.css" type="text/css" rel="stylesheet">

<?php
$id = $_GET ? array_keys($_GET)[0] : 'domcav54';

// Date en année (décimale)
function yearDate ($date) {
	if ($date)
		return strtotime (
			strlen ($date['DATE'][0]) == 4
			? '1 JUN '.$date['DATE'][0]
			: $date['DATE'][0]
			) / 24 / 3600 / 365.25;
}

require_once 'Person.php';

// Read gencom
$gedcom = Person::parse('./base.ged');

// Compute MyId
$pers = [];
foreach ($gedcom['INDI'] as $person) {
	$p =  new Person ($person, $gedcom);

	if (isset ($pers[$p->_data['MYID']]))
		echo"<pre style='background:white;color:black;font-size:16px'>Doublon {$p->_data['MYID']} = ".
		var_export($pers[$p->_data->myid]->_data['_ID'].' -- '.$person['_ID'],true).'</pre>'.PHP_EOL;

	$pers[$p->_data['MYID']] = $p;
}

//*DCMM*/echo"<pre style='background:white;color:black;font-size:16px'>BIRT = ".var_export($pers[$id]->dates('BIRT' ),true).'</pre>'.PHP_EOL;
//*DCMM*/echo"<pre style='background:white;color:black;font-size:16px'> = ".var_export($pers[$id],true).'</pre>'.PHP_EOL;

echo $pers[$id]->tableTree();
