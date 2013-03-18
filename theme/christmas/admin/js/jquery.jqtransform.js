/*
 * UPDATED: 25.09.08
 *
 * jqTransform
 * by mathieu vilaplana mvilaplana@dfc-e.com
 * Designer ghyslain armand garmand@dfc-e.com
 *
 *
 * Version 1.0
 *
 ******************************************** */
 
(function(jQuery){
	var defaultOptions = {preloadImg:true};
	var jqTransformImgPreloaded = false;

	var jqTransformPreloadHoverFocusImg = function(strImgUrl) {
		//guillemets to remove for ie
		strImgUrl = strImgUrl.replace(/^url\((.*)\)/,'jQuery1').replace(/^\"(.*)\"jQuery/,'jQuery1');
		var imgHover = new Image();
		imgHover.src = strImgUrl.replace(/\.([a-zA-Z]*)jQuery/,'-hover.jQuery1');
		var imgFocus = new Image();
		imgFocus.src = strImgUrl.replace(/\.([a-zA-Z]*)jQuery/,'-focus.jQuery1');				
	};

	
	/***************************
	  Labels
	***************************/
	var jqTransformGetLabel = function(objfield){
		var selfForm = jQuery(objfield.get(0).form);
		var oLabel = objfield.next();
		if(!oLabel.is('label')) {
			oLabel = objfield.prev();
			if(oLabel.is('label')){
				var inputname = objfield.attr('id');
				if(inputname){
					oLabel = selfForm.find('label[for="'+inputname+'"]');
				} 
			}
		}
		if(oLabel.is('label')){return oLabel.css('cursor','pointer');}
		return false;
	};
	
	/* Hide all open selects */
	var jqTransformHideSelect = function(oTarget){
		var ulVisible = jQuery('.jqTransformSelectWrapper ul:visible');
		ulVisible.each(function(){
			var jQueryselect = jQuery(this).parents(".jqTransformSelectWrapper:first").find("select").get(0);
			//do not hide if clicke on the label object associated to the select
			if( !(oTarget && jQueryselect.oLabel && jQueryselect.oLabel.get(0) == oTarget.get(0)) ){jQuery(this).hide();}
		});
	};
	/* Check for an external click */
	var jqTransformCheckExternalClick = function(event) {
		if (jQuery(event.target).parents('.jqTransformSelectWrapper').length === 0) { jqTransformHideSelect(jQuery(event.target)); }
	};

	/* Apply document listener */
	var jqTransformAddDocumentListener = function (){
		jQuery(document).mousedown(jqTransformCheckExternalClick);
	};	
			
	/* Add a new handler for the reset action */
	var jqTransformReset = function(f){
		var sel;
		jQuery('.jqTransformSelectWrapper select', f).each(function(){sel = (this.selectedIndex<0) ? 0 : this.selectedIndex; jQuery('ul', jQuery(this).parent()).each(function(){jQuery('a:eq('+ sel +')', this).click();});});
		jQuery('a.jqTransformCheckbox, a.jqTransformRadio', f).removeClass('jqTransformChecked');
		jQuery('input:checkbox, input:radio', f).each(function(){if(this.checked){jQuery('a', jQuery(this).parent()).addClass('jqTransformChecked');}});
	};

	/***************************
	  Buttons
	 ***************************/
	jQuery.fn.jqTransInputButton = function(){
		return this.each(function(){
			jQuery(this).replaceWith('<button id="'+ this.id +'" name="'+ this.name +'" type="'+ this.type +'" class="'+ this.className +' jqTransformButton"><span><span>'+ jQuery(this).attr('value') +'</span></span>');
		});
	};
	
	/***************************
	  Text Fields 
	 ***************************/
	jQuery.fn.jqTransInputText = function(){
		return this.each(function(){
			var safari = jQuery.browser.safari; /* We need to check for safari to fix the input:text problem */
			var jQueryinput = jQuery(this);
	
			if(jQueryinput.hasClass('jqtranformdone') || !jQueryinput.is('input')) {return;}
			jQueryinput.addClass('jqtranformdone');
	
			var oLabel = jqTransformGetLabel(jQuery(this));
			oLabel && oLabel.bind('click',function(){jQueryinput.focus();});
	
			var inputSize=jQueryinput.width();
			if(jQueryinput.attr('size')){
				inputSize = jQueryinput.attr('size')*10;
				jQueryinput.css('width',inputSize);
			}
			
			jQueryinput.addClass("jqTransformInput").wrap('<div class="jqTransformInputWrapper"><div class="jqTransformInputInner"><div></div></div></div>');
			var jQuerywrapper = jQueryinput.parent().parent().parent();
			jQuerywrapper.css("width", inputSize+10);
			jQueryinput
				.focus(function(){jQuerywrapper.addClass("jqTransformInputWrapper_focus");})
				.blur(function(){jQuerywrapper.removeClass("jqTransformInputWrapper_focus");})
				.hover(function(){jQuerywrapper.addClass("jqTransformInputWrapper_hover");},function(){jQuerywrapper.removeClass("jqTransformInputWrapper_hover");})
			;
	
			/* If this is safari we need to add an extra class */
			safari && jQuerywrapper.addClass('jqTransformSafari');
			safari && jQueryinput.css('width',jQuerywrapper.width()+16);
			this.wrapper = jQuerywrapper;
			
		});
	};
	
	/***************************
	  Check Boxes 
	 ***************************/	
	jQuery.fn.jqTransCheckBox = function(){
		return this.each(function(){
			var jQueryinput = jQuery(this);
			var inputSelf = this;
			
			if(jQueryinput.hasClass('jqTransformHidden')) {return;}
	
			var oLabel=jqTransformGetLabel(jQueryinput);
			jQueryinput.addClass('jqTransformHidden').wrap('<span class="jqTransformCheckboxWrapper"></span>');
			var jQuerywrapper = jQueryinput.parent();
			var aLink = jQuery('<a href="#" class="jqTransformCheckbox"></a>');
			jQuerywrapper.prepend(aLink);
			// Click Handler
			aLink.click(function(){
					var jQuerya = jQuery(this);
					if (inputSelf.checked===true){
						inputSelf.checked = false;
						jQuerya.removeClass('jqTransformChecked');
					}
					else {
						inputSelf.checked = true;
						jQuerya.addClass('jqTransformChecked');
					}
					
					inputSelf.onchange && inputSelf.onchange();
					return false;
			});
			oLabel && oLabel.click(function(){aLink.trigger('click');});
			// set the default state
			this.checked && aLink.addClass('jqTransformChecked');		
		});
	};
	/***************************
	  Radio Buttons 
	 ***************************/	
	jQuery.fn.jqTransRadio = function(){
		return this.each(function(){
			var jQueryinput = jQuery(this);
			var inputSelf = this;
				
			if(jQueryinput.hasClass('jqTransformHidden')) {return;}
	
			oLabel = jqTransformGetLabel(jQueryinput);
			jQueryinput.addClass('jqTransformHidden').wrap('<span class="jqTransformRadioWrapper"></span>');
			var jQuerywrapper = jQueryinput.parent();
			var aLink = jQuery('<a href="#" class="jqTransformRadio" rel="'+ this.name +'"></a>');
			jQuerywrapper.prepend(aLink);
			// Click Handler
			aLink
				.each(function(){
					this.radioElem = inputSelf;
					jQuery(this).click(function(){
						var jQuerya = jQuery(this).addClass('jqTransformChecked');
						inputSelf.checked = true;
						if(inputSelf.onclick)
							inputSelf.click();

						// uncheck all others of same name
						jQuery('a.jqTransformRadio[rel="'+ jQuerya.attr('rel') +'"]',inputSelf.form).not(jQuerya).each(function(){
							jQuery(this).removeClass('jqTransformChecked');
							this.radioElem.checked = false;
						});
						
						inputSelf.onchange && inputSelf.onchange();
						return false;					
					});
				});
			oLabel && oLabel.click(function(){aLink.trigger('click');});
			// set the default state
			inputSelf.checked && aLink.addClass('jqTransformChecked');
		});
	};
	
	/***************************
	  TextArea 
	 ***************************/	
	jQuery.fn.jqTransTextarea = function(){
		return this.each(function(){
			var textarea = jQuery(this);
	
			if(textarea.hasClass('jqtransformdone')) {return;}
			textarea.addClass('jqtransformdone');
	
			oLabel = jqTransformGetLabel(textarea);
			oLabel && oLabel.click(function(){textarea.focus();});
			
			var strTable = '<table cellspacing="0" cellpadding="0" border="0" class="jqTransformTextarea">';
			strTable +='<tr><td id="jqTransformTextarea-tl">&nbsp;</td><td id="jqTransformTextarea-tm">&nbsp;</td><td id="jqTransformTextarea-tr">&nbsp;</td></tr>';
			strTable +='<tr><td id="jqTransformTextarea-ml">&nbsp;</td><td id="jqTransformTextarea-mm"><div></div></td><td id="jqTransformTextarea-mr">&nbsp;</td></tr>';	
			strTable +='<tr><td id="jqTransformTextarea-bl">&nbsp;</td><td id="jqTransformTextarea-bm">&nbsp;</td><td id="jqTransformTextarea-br">&nbsp;</td></tr>';
			strTable +='</table>';					
			var oTable = jQuery(strTable)
					.insertAfter(textarea)
					.hover(function(){
						!oTable.hasClass('jqTransformTextarea-focus') && oTable.addClass('jqTransformTextarea-hover');
					},function(){
						oTable.removeClass('jqTransformTextarea-hover');					
					})
				;
				
			textarea
				.focus(function(){oTable.removeClass('jqTransformTextarea-hover').addClass('jqTransformTextarea-focus');})
				.blur(function(){oTable.removeClass('jqTransformTextarea-focus');})
				.appendTo(jQuery('#jqTransformTextarea-mm div',oTable))
			;
			this.oTable = oTable;
			if(jQuery.browser.safari){
				jQuery('#jqTransformTextarea-mm',oTable)
					.addClass('jqTransformSafariTextarea')
					.find('div')
						.css('height',textarea.height())
						.css('width',textarea.width())
				;
			}
		});
	};
	
	/***************************
	  Select 
	 ***************************/	
	jQuery.fn.jqTransSelect = function(){
		return this.each(function(index){
			var jQueryselect = jQuery(this);
			if(jQueryselect.hasClass('jqTransformHidden')) {return;}
	
			var oLabel  =  jqTransformGetLabel(jQueryselect);
			/* First thing we do is Wrap it */
			jQueryselect
				.addClass('jqTransformHidden')
				.wrap('<div class="jqTransformSelectWrapper"></div>')
			;
			var jQuerywrapper = jQueryselect.parent().css({zIndex: 10-index});
			
			/* Now add the html for the select */
			jQuerywrapper.prepend('<div><span></span><a href="#" class="jqTransformSelectOpen"></a></div><ul></ul>');
			var jQueryul = jQuery('ul', jQuerywrapper).css('width',jQueryselect.width());
			/* Now we add the options */
			jQuery('option', this).each(function(i){
				var oLi = jQuery('<li><a href="#" index="'+ i +'">'+ jQuery(this).html() +'</a></li>');
				jQueryul.append(oLi);
			});
			/* Hide the ul and add click handler to the a */
			jQueryul.hide().find('a').click(function(){
					jQuery('a.selected', jQuerywrapper).removeClass('selected');
					jQuery(this).addClass('selected');	
					/* Fire the onchange event */
					if (jQueryselect[0].selectedIndex != jQuery(this).attr('index') && jQueryselect[0].onchange) { jQueryselect[0].selectedIndex = jQuery(this).attr('index'); jQueryselect[0].onchange(); }
					jQueryselect[0].selectedIndex = jQuery(this).attr('index');
					jQuery('span:eq(0)', jQuerywrapper).html(jQuery(this).html());
					jQueryul.hide();
					return false;
			});
			/* Set the default */
			jQuery('a:eq('+ this.selectedIndex +')', jQueryul).click();
			jQuery('span:first', jQuerywrapper).click(function(){jQuery("a.jqTransformSelectOpen",jQuerywrapper).trigger('click');});
			oLabel && oLabel.click(function(){jQuery("a.jqTransformSelectOpen",jQuerywrapper).trigger('click');});
			this.oLabel = oLabel;
			
			/* Apply the click handler to the Open */
			var oLinkOpen = jQuery('a.jqTransformSelectOpen', jQuerywrapper)
				.click(function(){
					//Check if box is already open to still allow toggle, but close all other selects
					if( jQueryul.css('display')=='none' ) {jqTransformHideSelect();} 
					jQueryul.slideToggle('normal', function(){					
						var offSet = (jQuery('a.selected', jQueryul).offset().top - jQueryul.offset().top);
						jQueryul.animate({scrollTop: offSet});
					});
					return false;
				})
			;
			//set the new width
			var iSelectWidth = jQueryselect.width();
			var oSpan = jQuery('span:first',jQuerywrapper);
			var newWidth = (iSelectWidth > oSpan.innerWidth())?iSelectWidth+oLinkOpen.outerWidth():jQuerywrapper.width();
			jQuerywrapper.css('width',newWidth);
			jQueryul.css('width',newWidth-2);
			oSpan.css('width',iSelectWidth);
			
		});
	};
	jQuery.fn.jqTransform = function(options){
		var self = this;
		var safari = jQuery.browser.safari; /* We need to check for safari to fix the input:text problem */
		var opt = jQuery.extend({},defaultOptions,options);
		
		/* each form */
		 return this.each(function(){
			var selfForm = jQuery(this);
			if(selfForm.hasClass('jqtransformdone')) {return;}
			selfForm.addClass('jqtransformdone');
			
			jQuery('input:submit, input:reset, input[type="button"]', this).jqTransInputButton();			
			jQuery('input:text, input:password', this).jqTransInputText();			
			jQuery('input:checkbox', this).jqTransCheckBox();
			jQuery('input:radio', this).jqTransRadio();
			jQuery('textarea', this).jqTransTextarea();
			
			if( jQuery('select', this).jqTransSelect().length > 0 ){jqTransformAddDocumentListener();}
			selfForm.bind('reset',function(){var action = function(){jqTransformReset(this);}; window.setTimeout(action, 10);});
			
			//preloading
			if(opt.preloadImg && !jqTransformImgPreloaded){
				jqTransformImgPreloaded = true;
				var oInputText = jQuery('input:text:first', selfForm);
				if(oInputText.length > 0){
					//pour ie on eleve les ""
					var strWrapperImgUrl = oInputText.get(0).wrapper.css('background-image');
					jqTransformPreloadHoverFocusImg(strWrapperImgUrl);					
					var strInnerImgUrl = jQuery('div.jqTransformInputInner',jQuery(oInputText.get(0).wrapper)).css('background-image');
					jqTransformPreloadHoverFocusImg(strInnerImgUrl);
				}
				
				var oTextarea = jQuery('textarea',selfForm);
				if(oTextarea.length > 0){
					var oTable = oTextarea.get(0).oTable;
					jQuery('td',oTable).each(function(){
						var strImgBack = jQuery(this).css('background-image');
						jqTransformPreloadHoverFocusImg(strImgBack);
					});
				}
			}
			
			
		}); /* End Form each */
				
	};/* End the Plugin */

})(jQuery);
				   