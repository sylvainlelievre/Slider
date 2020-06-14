<?php 
/*
Création automatique du slider avec les images du dossier sélectionné en configuration du module
puis affichage du slider. 
*/


if($module::$galleries){
	
	//Recherche du nom du dossier contenant le dossier du diaporama
	foreach($module::$galleries as $galleryId => $gallery):
	endforeach;
	$directory = $gallery['config']['directory'];
	
	// Images de la galerie
	if(is_dir($directory)) {
		$iterator = new DirectoryIterator($directory);
		foreach($iterator as $fileInfos) {
			if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
				$module::$pictures[$directory . '/' . $fileInfos->getFilename()] = $this->getData(['module', $this->getUrl(0), $galleryId,'legend', str_replace('.','',$fileInfos->getFilename())]);
			}
		}
		// Tri des images par ordre alphabétique, alphabétique inverse, aléatoire ou pas
		switch ($this->getData(['module', $this->getUrl(0), $galleryId, 'config', 'tri'])) {
			case 'SORT_DSC':
				krsort($module::$pictures,SORT_NATURAL | SORT_FLAG_CASE);
				break;
			case 'SORT_ASC':
				ksort($module::$pictures,SORT_NATURAL | SORT_FLAG_CASE);
				break;
			case 'RAND':
				$tab1 = $module::$pictures;
				// si absence de légende on en place une provisoire
				foreach($tab1 as $key1=>$value1){
					if($value1 == ''){
						$tab1[$key1] = $key1;
					}
				}
				$tab2 = array_flip($tab1);
				shuffle($tab2);
				$tab1 = array_flip($tab2);
				foreach($tab1 as $key1=>$value1){
					$tab1[$key1] = $module::$pictures[$key1];
				}
				$module::$pictures = $tab1;
				break;
			case 'NONE':
				break;
			default:
				break;
		}
		// Information sur la visibilité des boutons
		$view_boutons = $this->getData(['module', $this->getUrl(0), $galleryId, 'config','boutonsVisibles']);
	}
	
	$i = 1; 
	$picturesNb = count($module::$pictures);
	if ($picturesNb!=0){		
		?>
		<div id="wrapper">
		<div class="rslides_container">
		<?php if($view_boutons == "slider1"){
			echo '<ul class="rslides" id="slider1">';
		}
		else{
			echo '<ul class="rslides" id="slider2">';
		}
		foreach($module::$pictures as $picture => $legend):
			if ($legend != ''){
			// Texte dans une balise title se déplaçant avec le pointeur :
			// echo  '<li><img title="'.$legend.'" src="'.helper::baseUrl(false) . $picture.'" alt=""></li>';
			// Texte apparaissant dans la partie inférieure de l'image lors de son survol :
			// echo  '<li><img src="'.helper::baseUrl(false) . $picture.'" alt=""><span>'.$legend.'</span></li>';
				echo  '<li><img src="'.helper::baseUrl(false) . $picture.'" alt=""><span>'.$legend.'</span></li>';
			}
			else{
				echo  '<li><img src="'.helper::baseUrl(false) . $picture.'" alt=""></li>';
			}
		endforeach;
		echo '</ul></div><p>&nbsp;</p></div>';
	}
	else{
		echo template::speech('Aucune image dans le dossier sélectionné.');
	}
}
else{
	echo template::speech('Aucun dossier sélectionné pour les photos du diaporama.'); 
}
?>
<!--Pour liaison entre variables php et javascript-->
<script>
	// Integer: largeur MAXI du diaporama, en pixels. Par exemple : 800, 920, 500
	var maxwidth=<?php echo $this->getData(['module', $this->getUrl(0), $galleryId, 'config','maxiWidth']); ?>;
	// Integer: Vitesse de transition entre 2 diapositives (fading) : de 500 à 3500
	var speed=<?php echo $this->getData(['module', $this->getUrl(0), $galleryId, 'config','fadingTime']); ?>;
	// Integer: Durée d'une diapositive en millisecondes (fading compris) : minimum speed +100
	var timeout=<?php echo $this->getData(['module', $this->getUrl(0), $galleryId, 'config','sliderTime']); ?>;
	// Boolean: visibilité des puces de navigation, true ou false
	var pager=<?php echo $this->getData(['module', $this->getUrl(0), $galleryId, 'config','pagerVisible']); ?>;
	//Visibilité de la légende
	var legendeVisibilite="<?php echo $this->getData(['module', $this->getUrl(0), $galleryId, 'config','visibiliteLegende']); ?>";
	//Position de la légende, "haut" ou "bas"
	var legendePosition="<?php echo $this->getData(['module', $this->getUrl(0), $galleryId, 'config','positionLegende']); ?>";
	//Temps d'apparition de la légende et des boutons
	var timeLegende="<?php echo $this->getData(['module', $this->getUrl(0), $galleryId, 'config','tempsApparition']); ?>";
	//Type de bouton
	var boutonType="<?php echo $this->getData(['module', $this->getUrl(0), $galleryId, 'config','typeBouton']); ?>";	
</script>



