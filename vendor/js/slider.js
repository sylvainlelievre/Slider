/*http://responsiveslides.com v1.55 by @viljamis */
(function(c,K,C){c.fn.responsiveSlides=function(m){var a=c.extend({auto:!0,speed:500,timeout:4E3,pager:!1,nav:!1,random:!1,pause:!1,pauseControls:!0,prevText:"Previous",nextText:"Next",maxwidth:"",navContainer:"",manualControls:"",namespace:"rslides",before:c.noop,after:c.noop},m);return this.each(function(){C++;var f=c(this),u,t,v,n,q,r,p=0,e=f.children(),D=e.length,h=parseFloat(a.speed),E=parseFloat(a.timeout),w=parseFloat(a.maxwidth),g=a.namespace,d=g+C,F=g+"_nav "+d+"_nav",x=g+"_here",k=d+"_on",
y=d+"_s",l=c("<ul class='"+g+"_tabs "+d+"_tabs' />"),z={"float":"left",position:"relative",opacity:1,zIndex:2},A={"float":"none",position:"absolute",opacity:0,zIndex:1},G=function(){var b=(document.body||document.documentElement).style,a="transition";if("string"===typeof b[a])return!0;u=["Moz","Webkit","Khtml","O","ms"];var a=a.charAt(0).toUpperCase()+a.substr(1),c;for(c=0;c<u.length;c++)if("string"===typeof b[u[c]+a])return!0;return!1}(),B=function(b){a.before(b);G?(e.removeClass(k).css(A).eq(b).addClass(k).css(z),
p=b,setTimeout(function(){a.after(b)},h)):e.stop().fadeOut(h,function(){c(this).removeClass(k).css(A).css("opacity",1)}).eq(b).fadeIn(h,function(){c(this).addClass(k).css(z);a.after(b);p=b})};a.random&&(e.sort(function(){return Math.round(Math.random())-.5}),f.empty().append(e));e.each(function(a){this.id=y+a});f.addClass(g+" "+d);m&&m.maxwidth&&f.css("max-width",w);e.hide().css(A).eq(0).addClass(k).css(z).show();G&&e.show().css({"-webkit-transition":"opacity "+h+"ms ease-in-out","-moz-transition":"opacity "+
h+"ms ease-in-out","-o-transition":"opacity "+h+"ms ease-in-out",transition:"opacity "+h+"ms ease-in-out"});if(1<e.length){if(E<h+100)return;if(a.pager&&!a.manualControls){var H=[];e.each(function(a){a+=1;H+="<li><a href='#' class='"+y+a+"'>"+a+"</a></li>"});l.append(H);m.navContainer?c(a.navContainer).append(l):f.after(l)}a.manualControls&&(l=c(a.manualControls),l.addClass(g+"_tabs "+d+"_tabs"));(a.pager||a.manualControls)&&l.find("li").each(function(a){c(this).addClass(y+(a+1))});if(a.pager||a.manualControls)r=
l.find("a"),t=function(a){r.closest("li").removeClass(x).eq(a).addClass(x)};a.auto&&(v=function(){q=setInterval(function(){e.stop(!0,!0);var b=p+1<D?p+1:0;(a.pager||a.manualControls)&&t(b);B(b)},E)},v());n=function(){a.auto&&(clearInterval(q),v())};a.pause&&f.hover(function(){clearInterval(q)},function(){n()});if(a.pager||a.manualControls)r.bind("click",function(b){b.preventDefault();a.pauseControls||n();b=r.index(this);p===b||c("."+k).queue("fx").length||(t(b),B(b))}).eq(0).closest("li").addClass(x),
a.pauseControls&&r.hover(function(){clearInterval(q)},function(){n()});if(a.nav){g="<a href='#' class='"+F+" prev'>"+a.prevText+"</a><a href='#' class='"+F+" next'>"+a.nextText+"</a>";m.navContainer?c(a.navContainer).append(g):f.after(g);var d=c("."+d+"_nav"),I=d.filter(".prev");d.bind("click",function(b){b.preventDefault();b=c("."+k);if(!b.queue("fx").length){var d=e.index(b);b=d-1;d=d+1<D?p+1:0;B(c(this)[0]===I[0]?b:d);(a.pager||a.manualControls)&&t(c(this)[0]===I[0]?b:d);a.pauseControls||n()}});
a.pauseControls&&d.hover(function(){clearInterval(q)},function(){n()})}}if("undefined"===typeof document.body.style.maxWidth&&m.maxwidth){var J=function(){f.css("width","100%");f.width()>w&&f.css("width",w)};J();c(K).bind("resize",function(){J()})}})}})(jQuery,this,0);



$(function () {

	//Fonction jquery pour déterminer la largeur du wrapper
	$.wrapper = function(){
	// Adaptation de la largeur du wrapper en fonction de la largeur de la page client et de la largeur du site
	// 10000 pour la sélection 100%
	if(maxwidth != 10000){
		var wclient = document.body.clientWidth,
			largeur_pour_cent,
			largeur,
			largeur_section,
			wsection = getComputedStyle(site).width,
			wcalcul;
		switch (wsection)
		{
			case '750px':
				largeur_section = 750;
				break;
			case '960px':
				largeur_section = 960;
				break;
			case '1170px':
				largeur_section = 1170;
				break;
			default:
				largeur_section = wclient;
		}
		
		// 20 pour les margin du body / html, 40 pour le padding intérieur dans section	
		if(wclient > largeur_section + 20) {wcalcul = largeur_section-40} else {wcalcul = wclient-40};
		largeur_pour_cent = Math.floor(100*(maxwidth/wcalcul));
		if(largeur_pour_cent > 100) { largeur_pour_cent=100;}
		largeur=largeur_pour_cent.toString() + "%";

		$("#wrapper").css('width', largeur);
	}
	else
	{
		$("#wrapper").css('width', "100%");
	}
	//La taille du wrapper étant défini on peut l'afficher
	$("#wrapper").css('visibility', "visible");
	}
	
	//Fonction jquery pour afficher et positionner les éventuels boutons verticalement
	$.bouton = function(){
		//Temps d'apparition de la légende et des boutons	
		$('.rslides span').css('transition',timeLegende);
		$(".centered-btns_nav").css('transition',timeLegende);
		//Type de Boutons
		switch (boutonType){
			case 'rec_noir':
				$(".centered-btns_nav").css('height','61px');
				$(".centered-btns_nav").css('width','38px');
				$(".centered-btns_nav").css('background','transparent url("./module/slider/view/index/themes.gif") no-repeat left top');
				if ($('.rslides img').height() != 0){
					$(".centered-btns_nav").css('top',$('.rslides img').height()/2 - 31);
				}
				else
				{
					$(".centered-btns_nav").css('top','45%');
				}
				break;
			case 'cer_blanc':
				$('.centered-btns_nav').css('height','44px');
				$(".centered-btns_nav").css('width','47px');
				$(".centered-btns_nav").css('background','transparent url("./module/slider/view/index/themes.svg") no-repeat left top');
				if ($('.rslides img').height() != 0){
					$(".centered-btns_nav").css('top',$('.rslides img').height()/2 - 22);
				}
				else
				{
					$(".centered-btns_nav").css('top','45%');
				}
				break;
			default:
				$(".centered-btns_nav").css('height','44px');
				$(".centered-btns_nav").css('width','47px');
				$(".centered-btns_nav").css('background','transparent url("./module/slider/view/index/themes.svg") no-repeat left top');
				if ($('.rslides img').height() != 0){
					$(".centered-btns_nav").css('top',$('.rslides img').height()/2 - 22);
				}
				else
				{
					$(".centered-btns_nav").css('top','45%');
				}

		}
		$(".centered-btns_nav.next").css('background-position','right top');
	}
	
	//Fin des fonctions wrapper et bouton
	
	// Slideshow 1 : version avec boutons
	$("#slider1").responsiveSlides({
		auto: true,
		pager,
		speed,
		timeout,
		nav: true,
		pause: true,
		pauseControls: true,
		namespace: "centered-btns"
	});

	// Slideshow 2 : version sans boutons
	$("#slider2").responsiveSlides({
		auto: true,							// Boolean: Animate automatically, true or false
		pager,								
		speed,
		timeout,
		nav: true,							// Boolean: Show navigation, true or false
		random: false,						// Boolean: Randomize the order of the slides, true or false
		pause: true,						// Boolean: Pause on hover, true or false OK
		pauseControls: true,    			// Boolean: Pause when hovering controls, true or false OK
		namespace: "transparent-btns",		// String: change the default namespace used OK
		navContainer: ""       				// Selector: Where auto generated controls should be appended to, default is after the <ul>
	});
	
	//Exécution des fonctions $.wrapper et $.bouton au ready du document puis sur un redimensionnement de la fenêtre
	//Problème si la fonction responsiveslides() n'est pas finie la hauteur de l'img sera à 0 d'où les conditions 
	//dans la fonction $.bouton(), il faudrait mettre un callback...
	$.wrapper();
	console.log($('.rslides img').height());
	$.bouton();
	$(window).resize(function(){
		$.wrapper();
		$.bouton();
	});
	
	//Limitation de timeout en fonction de speed
	if (timeout < speed + 100) timeout = speed + 100;
	
	//Position de la légende
	switch (legendePosition)
	{
		case 'haut':
			$('.rslides span').css('top',"0");
			break;
		case 'bas':
			$('.rslides span').css('bottom',"0");
			break;
		default:
			$('.rslides span').css('bottom',"0");
	}
	
	//Visibilité de la légende : jamais par défaut dans index.css, au survol voir plus bas, toujours ici
	if (legendeVisibilite=='toujours'){
		$('.rslides span').css('opacity',"0.6");
	}
	
	

	
	//Boutons du slider1 apparaissant seulement au survol du slider
	//Légendes apparaissant seulement au survol du slider
	//Progressivité d'opacité de la légende et des boutons par la classe .load
	$(function() {
        $(".rslides").addClass("load");
		$(".centered-btns_nav").addClass("load");
    });
	
	$(".rslides_container").hover( 
	function() {
		//survol du slider 
		$(".centered-btns_nav.load").css('opacity', "0.5");
		if (legendeVisibilite=='survol'){
			$('.rslides.load span').css('opacity',"0.6");
		}
	}, 
	function() { 
		//sortie
		$(".centered-btns_nav").css('opacity', "0");
		if (legendeVisibilite=='survol'){
			$('.rslides span').css('opacity',"0");
		}
	});
	
	$(".next").hover( 
	function() {
		//survol du bouton next 
		$(".centered-btns1_nav.next").css('opacity', "0.7");
	}, 
	function() { 
		//sortie
		$(".centered-btns1_nav.next").css('opacity', "0.5");
	});
	
	$(".prev").hover( 
	function() {
		//survol du bouton prev 
		$(".centered-btns1_nav.prev").css('opacity', "0.7");
	}, 
	function() { 
		//sortie
		$(".centered-btns1_nav.prev").css('opacity', "0.5");
	});
	
	$(".centered-btns1_nav.next").mousedown(
	function() {
		$(".centered-btns1_nav.next").css('opacity', "1");
	});
	$(".centered-btns1_nav.next").mouseup(
	function() {
		$(".centered-btns1_nav.next").css('opacity', "0.7");
	});	
	$(".centered-btns1_nav.prev").mousedown(
	function() {
		$(".centered-btns1_nav.prev").css('opacity', "1");
	});
	$(".centered-btns1_nav.prev").mouseup(
	function() {
		$(".centered-btns1_nav.prev").css('opacity', "0.7");
	});
	//Fin boutons et légendes
	
});


 

