// Kraken Framework 0.7
;(function ( $, window, document, undefined ) {

var pluginName = "Kraken",
			_default = {
			relative   : { state : true },
			pagesize   : { state : true, width: 1024, },
			overflow   : { state : true, x : false, y : true },
			bgimg      : { state : true, img : '004', size : 'default'},
			bgcolor    : { state : true, color : '0fa1e0' },
			largewrap  : { state : true, rest : 'default' },
			wrapshadow : { state : true, intense : 'default', size : 'default'},
			slider     : { state : true, auto : true, pager : false, nav : true, speed : 500},
			menu       : { state : true, submenu : true, move : true},
			span       : { state : true, multiply : '10' },
			interval   : { state : false, timer : '2000'},
			hide       : { state : true, resize : true, size : 700 },
			show       : { state : false, resize : true, size : 700 },
			footer     : { state : true, resize : true },
			fonts      : {}
	};
var PNTrigger  =  pluginName+'Trigger';
var arrSuccess = [];
var arrError   = [];

var Plugin = function ( _options ){

	this.settings  = $.extend(true, _default, _options);
	this._defaults = _default;
	this._name     = pluginName;
	this.init();

	// if(this.settings.relative.state) 		this.relative(this.settings.relative);
	if(this.settings.pagesize.state) 		this.pagesize(this.settings.pagesize);
	if(this.settings.overflow.state) 		this.overflow(this.settings.overflow);
	if(this.settings.bgimg.state) 			this.bgimg(this.settings.bgimg);
	if(this.settings.bgcolor.state) 		this.bgcolor(this.settings.bgcolor);
	if(this.settings.largewrap.state) 		this.largewrap(this.settings.largewrap);
	if(this.settings.wrapshadow.state) 		this.wrapshadow(this.settings.wrapshadow);
	if(this.settings.slider.state) 			this.slider(this.settings.slider);
	if(this.settings.menu.state) 			this.menu(this.settings.menu, this.settings.hide);
	if(this.settings.span.state) 			this.span(this.settings.span);
	if(this.settings.hide.state) 			this.hide(this.settings.hide);
	if(this.settings.show.state) 			this.show(this.settings.show);
	if(this.settings.footer.state) 			this.footer(this.settings.pagesize);

}

globals = {

	MenuBack : function ( options ){
		$('body').append('<div class="menuBack"></div>');
		if(options){
			$(".nav a").on('click',function(event) {
				if(!$('.menuBack').is(":visible")){
				var altura = $('body').height();
				   	event.preventDefault();
					// $('.nav ul li').addClass('click');
					$('.nav ul li').css({'display' : 'block', 'margin' : '0 0 5px', 'z-index' : '999'});
					$('.menuBack').css({'height' : altura }).animate({ opacity: .8 }).fadeIn();
				}
			});
			$('.menuBack').on('click',function(){
				$('.menuBack').animate({ opacity: 0}).fadeOut();
				$('.nav ul li').removeAttr('style');
			});
		}else{
				$('.menuBack').animate({ opacity: 0}).fadeOut();
				$('.nav ul li').removeAttr('style');
		}
	},
	eval : {
		success: function ( options ){
			arrSuccess.push(options);
		},
		error : function ( options ){
			arrError.push(options);
		},
		count : function (){
			arrShow = arrSuccess;
			arrSuccess = null;
			arrSuccess = Array();
			return arrShow.length;
		}
	}
	

}


Plugin.prototype = {
		init: function () {
			$('.MenuClose').on('click',function(){
				globals.MenuBack(0);
			});
		},
		relative: function(kraken){
				var settings = {};
				settings.basePath = null;

				if (!settings.basePath) {
				  (function (name) {
				    var scripts = document.getElementsByTagName('script');

				    for (var i = scripts.length - 1; i >= 0; --i) {
				      var src = scripts[i].src;
				      var l = src.length;
				      var length = name.length;

				      if (src.substr(l - length) == name) {
				        // set a global propery here
				        settings.basePath = src.substr(0, l - length);

				      }
				    }
				  })('kraken.js');

				  if(settings.basePath != null){
					var spliter = settings.basePath.split('/');
					var location = Array();
					  for (var i = 0; i < spliter.length - 2; i++) {
					  	if(spliter[i]!="") location.push(spliter[i]); location.push('/');
					  	
					  }
					return location.join("");		  
				  };

				}
		},
		pagesize: function (kraken){
			// Page Width size
			$('.grids').css({'max-width' : kraken.width}), $('.wrap').css({'max-width' : kraken.width});
		},
		overflow: function (kraken){
			// Overflow in Short pages
			if(kraken.x) $('html').css('overflow-x','scroll');
			if(kraken.y) $('html').css('overflow-y','scroll');
		},
		bgimg: function (kraken){
			// Background Image in directory img/bg/
			if(this.relative() != null) var path = this.relative();

				$('html').css({'background' : 'url("'+path+'img/bg/'+kraken.img+'.png") fixed' , 'background-size' : kraken.size });
		},
		bgcolor: function (kraken){
			// Background Color
			$('html').css('background-color','#'+kraken.color+'');
		},
		largewrap: function (kraken){
			// Wrap height of the screen
			var wrap = '.wrap';
			var RestWarp = ( kraken.rest == 'default' ) ? '14' : kraken.rest;
			// setTimeout(function(){
			// 	if($(window).height() > $(wrap).height()){
			// 		$(wrap).css('min-height',$(document).height() - (RestWarp * 1.5) - ($('footer').height() / 2) );
			// 	}else{
			// 		$(wrap).css('min-height',$(document).height() - RestWarp - $('footer').height() );
			// 	}
			// },250);
		},
		wrapshadow: function (kraken){
			// BorderShadow on Wrap shadow="on"
			if(kraken.state) $('.wrap').addClass('shadowWrap');
		},
		slider: function (kraken){
			// Slider
			$("#slider").responsiveSlides({
				auto      : kraken.auto,
				pager     : kraken.pager,
				nav       : kraken.nav,
				speed     : kraken.speed,
				namespace : "callbacks",
				before    : function () {
				
				},
				after     : function () {
				
				}
			});
		},
		menu: function (krakenMenu, krakenSize){
			//SubMenu
			$('.grids > #menu').css({'position':'relative', 'width':'auto', 'z-index':'8'});
			$('.subMenu').hide();
			var togglesub = true;
			$('#soluciones').on('click',function(event){
				event.preventDefault();
				console.log('click');
				if(togglesub){
					$('.subMenu').show().effect("slide", { direction:'up', times: 5 }, 450);
					$('.subMenu').show().effect("highlight", { color: "#fff", times: 5 }, 450);
					togglesub = false;
				}else{
					$('.subMenu').hide('slow');
					togglesub = true;
				}

			});
			if($(document).width() > krakenSize.size){
				function openSubMenu() {
					// $(this).find('ul').css({opacity: 0, visibility: "visible"}).animate({opacity: 1, top: 32}, 400);
					 $(this).find('ul').css('visibility', 'visible');
				};
				function closeSubMenu() {
					// $(this).find('ul').css({opacity: 1.0, visibility: "hidden"}).animate({opacity: 0}, 400);
					$(this).find('ul').css('visibility', 'hidden');
				};
				$('.nav > ul > li,a').bind('mouseover', openSubMenu);
				$('.nav > ul > li').bind('mouseout', closeSubMenu);
			}else{
				$(this).find('ul').css('visibility', 'visible');
			}

			if(krakenMenu.move==true){
				 var Menu = '#menu';
				 var pageTop = $(window).scrollTop();
				    if(pageTop==0){
				      $(Menu).addClass('menuTop');
				    }
				  $(window).scroll(function(event) {
				    pageTop = $(window).scrollTop()
				    if(pageTop<20){
				      $(Menu).addClass('menuTop');
				    }else{
				      $(Menu).removeClass('menuTop');
				      $(Menu).addClass('menuMove');
				    }
				  });
			}
		},
		span: function (kraken){
			// Span example in html: <div class="span" value="2.5"></div>
			$('.span').each(function(){
				var spanValue = $(this).attr('value');
				sumValue = spanValue * kraken.multiply;
				$(this).css('margin-bottom',sumValue);
			});
		},
		interval: function (kraken){
			// Set interval to responsive js
			setInterval(function () {
				// Functions here:
				console.log('start');
				// End Functions
			}, kraken.timer);
		},
		hide: function (kraken){
			if($(document).width() < kraken.size){
				$('.hide').each(function(){
					$(this).hide();
				});

			globals.MenuBack(1);
			}
			if(kraken.resize){
				$(window).resize(function(){
					if($(document).width() < kraken.size){
						$('.hide').each(function(){
							$(this).hide();
						});

						// MenuBack();
					}else{
						$('.hide').each(function(){
							$(this).show();
						});
					}
				});
			}
		},
		show: function(kraken){

		},
		footer: function(kraken){

			$('.wrap').css({'margin-bottom': $('footer').height() });
			// $('.footer').css({'max-width': kraken.width});

		}

};

Triggers = function (func, options, element){
	this.element     = element;
	// this.settings = $.extend(true, t_default, t_options);
	this._defaults   = _default;
	this._name       = PNTrigger;

	switch(func){
	case 'Progress':
		$.data(this.element ,"return", this.Progress(this.element, options));
	break;
	case 'Eval':
		$.data(this.element ,"return", this.Eval(this.element, options));
	break;
	default:
		console.log('Trigger undefined');
	break;
	}

}

Triggers.prototype = {

	Progress : function (element, options){
		if(!isNaN(options.progress)){
			$(element).children().css('width',''+options.progress+'%').html('<span>'+options.progress+'%</span>');
			// return this;
			return options.progress;
		}else{
			console.log('Progress is not a number');
		}
	},
	Eval : function(element, options){
		defaults = {
			type : 'none',
			get  : false,
			show : false
		}

    	var settings = $.extend(true, defaults, options);

		var regex = {
			'password': /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/,
			'date'    : /^\d{1,2}\/\d{1,2}\/\d{2,4}$/,
			'email'   : /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/,
			'url'     : /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \?=.-]*)*\/?$/,
			'phone'   : /^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$/,
			'ip'   	  : /^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/,
			'user'    : /^[a-z\d_]{4,15}$/,
			'credit'  : /^((67\d{2})|(4\d{3})|(5[1-5]\d{2})|(6011))(-?\s?\d{4}){3}|(3[4,7])\ d{2}-?\s?\d{6}-?\s?\d{5}$/,
			'zipcode' : /^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$/,
		}

		if(settings.get == true){
			if(settings.show == true ){
				$(element).val(globals.eval.count);
			}
			return globals.eval.count;
		}else{
			if(settings.type in regex && $(element).val().match(regex[settings.type]) && settings.get == false){
				globals.eval.success(settings.type);
			}else{
				$(element).addClass('animated shake');
				globals.eval.error(settings.type);
				setTimeout(function(){
					$(element).removeClass('animated shake');
				},1000);
			}
			return settings.type;
		}

	}

}

$.fn[ PNTrigger ] = function ( func, options ) {
				return this.each(function() {
						// if ( !$.data( this, "plugin_" + PNTrigger ) ) {
								$.data( this, "plugin_" + PNTrigger, new Triggers( func, options, this ));
						// }
				});
		};

$[pluginName] = function (_options) {
    if(!(this instanceof $)) { 
    	var settings = $.extend(true, _default, _options);
    	jQuery.pluginName = new Plugin(settings); 
    }
    return this.each(function () {
        if (!$.data(this, "plugin_" + pluginName)) {
            $.data(this, "plugin_" + pluginName, jQuery.pluginName = new Plugin(this,_options));
        }
    });
};

// var Plugin = function(option){
// 	this.init();
// 	if(option=='hola'){
// 		this.test();
// 	}
// }
// Plugin.prototype = {
// 		init: function () {
// 				console.log("xD");
// 		},
// 		test: function () {
// 				console.log("test");
// 		}
// };
// var tester = Plugin;
// new tester('hola');


})( jQuery, window, document );	