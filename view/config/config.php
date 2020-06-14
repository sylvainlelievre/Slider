<?php if($this->getData(['core','dataVersion']) > 10092){ 
	echo '<link rel="stylesheet" href="./site/data/admin.css">';
}
else{ 
	echo '<link rel="stylesheet" href="./core/layout/admin.css">';
} ?>

<?php echo template::formOpen('galleryConfigForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('galleryConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Nommez le diaporama et sélectionnez le dossier contenant les images</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('galleryConfigName', [
							'label' => 'Nom'
						]); ?>
					</div>
					<div class="col5">
						<?php echo template::hidden('galleryConfigDirectoryOld', [
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
						<?php echo template::select('galleryConfigDirectory', [], [
							'label' => 'Dossier cible',
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
					</div>
					<div class="col1 verticalAlignBottom">
						<?php echo template::submit('galleryConfigSubmit', [
							'ico' => '',
							'value' => template::ico('folder')
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if($module::$galleries): ?>
		<?php echo template::table([4, 6, 1], $module::$galleries, ['Nom', 'Dossier cible', 'Paramétrage du Diaporama']); ?>
	<?php else: ?>
		<?php echo template::speech('Aucune galerie.'); ?>
	<?php endif; ?>
<?php echo template::formClose(); ?>
<div class="moduleVersion">Module Slider version n°
	<?php echo $module::SLIDER_VERSION; ?>
</div>