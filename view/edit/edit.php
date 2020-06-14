<?php if($this->getData(['core','dataVersion']) > 10092){ 
	echo '<link rel="stylesheet" href="./site/data/admin.css">';
}
else{ 
	echo '<link rel="stylesheet" href="./core/layout/admin.css">';
} ?>

<?php echo template::formOpen('galleryEditForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('galleryEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('galleryEditSubmit'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Paramétrage du diaporama</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('galleryEditName', [
							'label' => 'Nom',
							'readonly' => true,
							'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'name'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::hidden('galleryEditDirectoryOld', [
							'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'directory']),
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
						<?php echo template::text('galleryEditDirectory', [
							'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'directory']),
							'label' => 'Dossier cible',
							'readonly' => true,
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
					</div>
					<!--Ajout pour paramétrage du diaporama-->
					<div class="col4">
					<?php echo template::select('sliderBoutonsVisibles', $module::$boutonsVisibles,[
							'help' => 'Navigation manuelle par bouton suivant ou précédent ou par zone droite ou gauche de l\'image',
							'label' => 'Navigation avec ou sans boutons',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'boutonsVisibles'])
						]); ?>	
					</div>
					<div class="col4">
					<?php echo template::select('sliderTypeBouton', $module::$bouton,[
							'help' => 'Choix du type de bouton rectangulaire noir ou circulaire blanc.',
							'label' => 'Type de bouton',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'typeBouton'])
						]); ?>	
					</div>
					<div class="col4">
					<?php echo template::select('sliderPagerVisible', $module::$pagerVisible,[
							'help' => 'Visibilité des puces de navigation ou pager',
							'label' => 'Visibilité des puces de navigation',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'pagerVisible'])
						]); ?>	
					</div>
					<div class="col4">
					<?php echo template::select('sliderMaxiWidth', $module::$maxwidth,[
							'help' => 'Largeur maximale du diaporama en pixels. La sélection 100% correspond à la largeur du site définie en configuration - 40 pixels',
							'label' => 'Largeur maxi du diaporama',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'maxiWidth'])
						]); ?>	
					</div>
					<div class="col4">
					<?php echo template::select('sliderFadingTime', $module::$fadingtime,[
							'help' => 'Durée de la transition ou fading en millisecondes ou en secondes',
							'label' => 'Durée de la transition',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'fadingTime'])
						]); ?>	
					</div>
					<div class="col4">
					<?php echo template::select('sliderDiapoTime', $module::$slidertime,[
							'help' => 'Durée totale de la diapositive fading compris en s ou en ms. Elle est au minimum égale à la durée de la transition plus 100 ms',
							'label' => 'Durée de chaque diapositive',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'sliderTime'])
						]); ?>	
					</div>
					<div class="col4">
					<?php echo template::select('sliderVisibiliteLegende', $module::$visibilite_legende,[
							'help' => 'Visibilité de la légende uniquement au survol, toujours visible ou jamais visible.',
							'label' => 'Visibilité de la légende',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'visibiliteLegende'])
						]); ?>	
					</div>
					<div class="col4">
					<?php echo template::select('sliderPositionLegende', $module::$position_legende,[
							'help' => 'Positionnement de la légende en haut ou en bas de l\'image.',
							'label' => 'Position de la légende',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'positionLegende'])
						]); ?>	
					</div>
					<div class="col4">
					<?php echo template::select('sliderTempsApparition', $module::$apparition,[
							'help' => 'Temps d\'apparition de la légende et des boutons.',
							'label' => 'Temps d\'apparition légende et boutons',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'tempsApparition'])
						]); ?>	
					</div>
					<div class="col4">
					<?php echo template::select('sliderTri', $module::$sort,[
							'help' => 'Choix du type de tri des images, l\'ordre de lecture sur le serveur correspond généralement à un tri suivant la date des images, de la plus ancienne à la plus récente.',
							'label' => 'Tri des images',
							'selected' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'tri'])
						]); ?>	
					</div>
					<!--Fin d'ajout-->
				</div>
			</div>
		</div>
	</div>
	<?php  if($module::$pictures):
		echo template::table([4, 8], $module::$pictures, ['Image', 'Légende']);
		endif; 
	echo template::formClose(); 
	?>