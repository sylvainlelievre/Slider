<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 *
 * Module slider
 * Développé à partir du module gallery par Sylvain Lelièvre
 */

class slider extends common {

	public static $actions = [
		'config' => self::GROUP_MODERATOR,
		'delete' => self::GROUP_MODERATOR,
		'dirs' => self::GROUP_MODERATOR,
		'edit' => self::GROUP_MODERATOR,
		'index' => self::GROUP_VISITOR
	];

	public static $directories = [];

	public static $firstPictures = [];

	public static $galleries = [];

	public static $pictures = [];

	//Visibilité des boutons de navigation
	public static $boutonsVisibles = [
		'slider1' => 'Bouton suivant ou précédent',
		'slider2' => 'Zone droite ou gauche de l\'image'
	];

	//Visibilité des puces de navigation ou pager
	public static $pagerVisible = [
		'true' => 'Puces visibles',
		'false' => 'Puces invisibles'
	];

	//Largeur du diaporama
	public static $maxwidth = [
		'400' => '400 pixels',
		'500' => '500 pixels',
		'600' => '600 pixels',
		'710' => '710 pixels',
		'800' => '800 pixels',
		'920' => '920 pixels',
		'1130' => '1130 pixels',
		'10000' => '100%'
	];

	//Temps de transition entre diapo
	public static $fadingtime = [
		'500' => '500 ms',
		'1000' => '1000 ms',
		'1500' => '1.5 s',
		'2000' => '2 s',
		'2500' => '2.5 s',
		'3000' => '3 s',
		'3500' => '3.5 s'
	];

	//Temps total entre 2 diapo
	public static $slidertime = [
		'600' => '600 ms',
		'1000' => '1 s',
		'1500' => '1.5 s',
		'2000' => '2 s',
		'3000' => '3 s',
		'5000' => '5 s',
		'7000' => '7 s',
		'10000' => '10 s'
	];

	//Visibilité de la lègende
	public static $visibilite_legende = [
		'survol' => 'Au survol',
		'toujours' => 'Toujours visible',
		'jamais' => 'Jamais visible'
	];

	//Position de la lègende
	public static $position_legende = [
		'haut' => 'En haut',
		'bas' => 'En bas'
	];

	//Temps d'apparition légende et boutons
	public static $apparition = [
		'opacity 0.2s ease-in' => '0.2s',
		'opacity 0.5s ease-in' => '0.5s',
		'opacity 1s ease-in' => '1s',
		'opacity 2s ease-in'	=> '2s'
	];

	//Type de boutons
	public static $bouton= [
		'rec_noir' => 'rectangle noir',
		'cer_blanc' => 'cercle blanc'
	];

	//Choix du tri
	public static $sort = [
		'SORT_ASC' => 'Alphabétique naturel',
		'SORT_DSC' => 'Alphabétique naturel inverse',
		'RAND' => 'Aléatoire',
		'NONE' => 'Par défaut, sans tri',
	];

	const SLIDER_VERSION = '3.1';

	/**
	 * Configuration
	 */
	public function config() {
		// Liste des galeries
		$galleries = $this->getData(['module', $this->getUrl(0)]);
		if($galleries) {
			//ksort($galleries);
			foreach($galleries as $galleryId => $gallery) {
				// Erreur dossier vide
				if(is_dir($gallery['config']['directory'])) {
					if(count(scandir($gallery['config']['directory'])) === 2) {
						$gallery['config']['directory'] = '<span class="galleryConfigError">' . $gallery['config']['directory'] . ' (dossier vide)</span>';
					}
				}
				// Erreur dossier supprimé
				else {
					$gallery['config']['directory'] = '<span class="galleryConfigError">' . $gallery['config']['directory'] . ' (dossier introuvable)</span>';
				}
				// Met en forme le tableau meilleure solution $galleries[count($galleries)-1]
				self::$galleries[] = [
					$gallery['config']['name'],
					$gallery['config']['directory'],
					template::button('galleryConfigEdit' . $galleryId, [
						'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $galleryId  . '/' . $_SESSION['csrf'],
						'value' => template::ico('pencil')
					])
				];
			}
		}
		// Soumission du formulaire
		if($this->isPost()) {
			// Ajout pour effacer les anciens dossiers cible
			foreach($galleries as $galleryId => $gallery) {
				$this->deleteData(['module', $this->getUrl(0), $galleryId]);
			}
			//Fin d'ajout
			$galleryId = helper::increment($this->getInput('galleryConfigName', helper::FILTER_ID, true), (array) $this->getData(['module', $this->getUrl(0)]));
			$this->setData(['module', $this->getUrl(0), $galleryId, [
				'config' => [
					'name' => $this->getInput('galleryConfigName'),
					//Ajout pour paramétrage par défaut du diaporama
					'boutonsVisibles' => 'slider2',
					'pagerVisible' => 'true',
					'maxiWidth' => '800',
					'fadingTime' => '1500',
					'sliderTime' => '5000',
					'visibiliteLegende' => 'survol',
					'positionLegende' => 'bas',
					'tempsApparition' => 'opacity 2s ease-in',
					'typeBouton' => 'cer_blanc',
					'tri' => 'SORT_ASC',
					//Fin d'ajout
					'directory' => $this->getInput('galleryConfigDirectory', helper::FILTER_STRING_SHORT, true)
				],
				'legend' => []
			]]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'notification' => 'Modifications enregistrées',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Configuration du module',
			'view' => 'config'
		]);
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// $url prend l'adresse sans le token
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Jeton incorrect
		if ($this->getUrl(3) !== $_SESSION['csrf']) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => 'Suppression  non autorisée'
			]);
		}
		// Suppression
		else {
			$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => 'Galerie supprimée',
				'state' => true
			]);
		}
	}

	/**
	 * Liste des dossiers
	 */
	public function dirs() {
		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_JSON,
			'content' => galleriesHelper::scanDir(self::FILE_DIR.'source')
		]);
	}

	/**
	 * Édition
	 */
	public function edit() {
		// Jeton incorrect
		if ($this->getUrl(3) !== $_SESSION['csrf']) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => 'Action  non autorisée'
			]);
		}
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// La galerie existe
		else {
			// Soumission du formulaire
			if($this->isPost()) {
				// Si l'id a changée
				$galleryId = $this->getInput('galleryEditName', helper::FILTER_ID, true);
				if($galleryId !== $this->getUrl(2)) {
					// Incrémente le nouvel id de la galerie
					$galleryId = helper::increment($galleryId, $this->getData(['module', $this->getUrl(0)]));
					// Supprime l'ancienne galerie
					$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
				}
				$legends = [];
				foreach((array) $this->getInput('legend', null) as $file => $legend) {
					$file = str_replace('.','',$file);
					$legends[$file] = helper::filter($legend, helper::FILTER_STRING_SHORT);
				}

				$this->setData(['module', $this->getUrl(0), $galleryId, [
					'config' => [
						'name' => $this->getInput('galleryEditName', helper::FILTER_STRING_SHORT, true),

						//Ajout pour paramétrage du diaporama
						'boutonsVisibles' => $this->getInput('sliderBoutonsVisibles', helper::FILTER_STRING_SHORT, true),
						'pagerVisible' => $this->getInput('sliderPagerVisible', helper::FILTER_STRING_SHORT, true),
						'maxiWidth' => $this->getInput('sliderMaxiWidth', helper::FILTER_STRING_SHORT, true),
						'fadingTime' => $this->getInput('sliderFadingTime', helper::FILTER_STRING_SHORT, true),
						'sliderTime' => $this->getInput('sliderDiapoTime', helper::FILTER_STRING_SHORT, true),
						'visibiliteLegende' => $this->getInput('sliderVisibiliteLegende', helper::FILTER_STRING_SHORT, true),
						'positionLegende' => $this->getInput('sliderPositionLegende', helper::FILTER_STRING_SHORT, true),
						'tempsApparition' => $this->getInput('sliderTempsApparition', helper::FILTER_STRING_SHORT, true),
						'typeBouton' => $this->getInput('sliderTypeBouton', helper::FILTER_STRING_SHORT, true),
						'tri' => $this->getInput('sliderTri', helper::FILTER_STRING_SHORT, true),
						//Fin d'ajout

						'directory' => $this->getInput('galleryEditDirectory', helper::FILTER_STRING_SHORT, true)
					],
					'legend' => $legends
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => 'Modifications enregistrées',
					'state' => true
				]);
			}
			// Met en forme le tableau
			$directory = $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'directory']);
			if(is_dir($directory)) {
				$iterator = new DirectoryIterator($directory);
				foreach($iterator as $fileInfos) {
					if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
						self::$pictures[$fileInfos->getFilename()] = [
							$fileInfos->getFilename(),
							template::text('legend[' . $fileInfos->getFilename() . ']', [
								'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'legend', str_replace('.','',$fileInfos->getFilename())])
							])
						];
					}
				}
				// Tri des images pour affichage de la liste dans la page d'édition
				switch ($this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'tri'])) {
						case 'SORT_DSC':
							krsort(self::$pictures,SORT_NATURAL | SORT_FLAG_CASE);
							break;
						case 'SORT_ASC':
							ksort(self::$pictures,SORT_NATURAL | SORT_FLAG_CASE);
							break;
						case 'RAND':
							// sans intérêt ici
							break;
						case 'NONE':
							break;
						default:
							break;
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'name']),
				'view' => 'edit'
			]);
		}
	}

	/**
	 * Fonction index() modifiée par rapport au module Gallery
	 */
	public function index() {
		// Liste des galeries
		foreach((array) $this->getData(['module', $this->getUrl(0)]) as $galleryId => $gallery) {
			if(is_dir($gallery['config']['directory'])) {
				$iterator = new DirectoryIterator($gallery['config']['directory']);
				foreach($iterator as $fileInfos) {
					if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
						self::$galleries[$galleryId] = $gallery;
						self::$firstPictures[$galleryId] = $gallery['config']['directory'] . '/' . $fileInfos->getFilename();
						continue(2);
					}
				}

			}
		}
		// Valeurs en sortie
		$this->addOutput([
			'showBarEditButton' => true,
			'showPageContent' => true,
			'vendor' => [
				'js'
			],
			'view' => 'index'
		]);
	}

}

class galleriesHelper extends helper {

	/**
	 * Scan le contenu d'un dossier et de ses sous-dossiers
	 * @param string $dir Dossier à scanner
	 * @return array
	 */
	public static function scanDir($dir) {
		$dirContent = [];
		$iterator = new DirectoryIterator($dir);
		foreach($iterator as $fileInfos) {
			if($fileInfos->isDot() === false AND $fileInfos->isDir()) {
				$dirContent[] = $dir . '/' . $fileInfos->getBasename();
				$dirContent = array_merge($dirContent, self::scanDir($dir . '/' . $fileInfos->getBasename()));
			}
		}
		return $dirContent;
	}
}
