/*
 * ContextMenu - jQuery plugin for right-click context menus
 *
 * Author: Chris Domigan
 * Contributors: Dan G. Switzer, II
 * Parts of this plugin are inspired by Joern Zaefferer's Tooltip plugin
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Version: r2
 * Date: 16 July 2007
 *
 * For documentation visit http://www.trendskitchens.co.nz/jquery/contextmenu/
 *
 */

(function($) {

 	var menu, shadow, trigger, content, hash, currentTarget;
  var defaults = {
    menuStyle: {
      listStyle: 'none',
      padding: '1px',
      margin: '0px',
      backgroundColor: '#fff',
      border: '1px solid #999',
      width: '100px'
    },
    itemStyle: {
      margin: '0px',
      color: '#000',
      display: 'block',
      cursor: 'default',
      padding: '3px',
      border: '1px solid #fff',
      backgroundColor: 'transparent'
    },
    itemHoverStyle: {
      border: '1px solid #0a246a',
      backgroundColor: '#b6bdd2'
    },
    eventPosX: 'pageX',
    eventPosY: 'pageY',
    shadow : true,
    onContextMenu: null,
    onShowMenu: null
 	};

  $.fn.contextMenu = function(id, options) {
    if (!menu) {                                      // Create singleton menu
      menu = $('<div id="jqContextMenu"></div>')
               .hide()
               .css({position:'absolute', zIndex:'500'})
               .appendTo('body')
               .bind('click', function(e) {
                 e.stopPropagation();
               });
    }
    if (!shadow) {
      shadow = $('<div></div>')
                 .css({backgroundColor:'#000',position:'absolute',opacity:0.2,zIndex:499})
                 .appendTo('body')
                 .hide();
    }
    hash = hash || [];
    hash.push({
      id : id,
      menuStyle: $.extend({}, defaults.menuStyle, options.menuStyle || {}),
      itemStyle: $.extend({}, defaults.itemStyle, options.itemStyle || {}),
      itemHoverStyle: $.extend({}, defaults.itemHoverStyle, options.itemHoverStyle || {}),
      bindings: options.bindings || {},
      shadow: options.shadow || options.shadow === false ? options.shadow : defaults.shadow,
      onContextMenu: options.onContextMenu || defaults.onContextMenu,
      onShowMenu: options.onShowMenu || defaults.onShowMenu,
      eventPosX: options.eventPosX || defaults.eventPosX,
      eventPosY: options.eventPosY || defaults.eventPosY
    });

    var index = hash.length - 1;
    $(this).bind('contextmenu', function(e) {
      // Check if onContextMenu() defined
      var bShowContext = (!!hash[index].onContextMenu) ? hash[index].onContextMenu(e) : true;
      if (bShowContext) display(index, this, e, options);
      return false;
    });
    return this;
  };

  function display(index, trigger, e, options) {
    var cur = hash[index];
    content = $('#'+cur.id).find('ul:first').clone(true);
    content.find('ul').hide();
    content.css(cur.menuStyle).find('li:not(.separator)').css(cur.itemStyle).hover(
      function() {
        $(this).css(cur.itemHoverStyle);
      },
      function(){
        $(this).css(cur.itemStyle);
      }
    ).find('img').css({verticalAlign:'middle',paddingRight:'2px'});
    
    // Sub menu
    content.children('li:not(.separator)').each
    (
      function()
      {
        if( $(this).find('ul:eq(0)').length > 0 )
        {
          $(this).css( { backgroundImage: "url( '/imgs/icons/arrow_right.gif' )", backgroundPosition: "right center", backgroundRepeat: "no-repeat" } );
        }
      }
    );
    content.children('li:not(.separator)').mouseover
    (
      function()
      {
        if( $(this).find('ul:eq(0)').length > 0 )
        {
          content.find('ul').hide();
          
          $(this).css( { position: "relative" } );
          $(this).children('ul:first').css( { position: "absolute", zIndex: "501", top: "3px", left: ( parseInt( cur.menuStyle.width ) - 3 ) + "px" } ).show();
          
          
          // Position Top
          if ( !( ( $(window).scrollTop() + $(window).height() ) > ( $(this).children('ul:first').offset().top + $(this).children('ul:first').outerHeight() ) ) )
            $(this).find('ul:first').css( { top: "-" + ( $(this).children('ul:first').outerHeight() - $(this).outerHeight() + 3 ) + "px" } );
          // Position Left
          if ( !( ( $(window).scrollLeft() + $(window).width() ) > ( $(this).parent().offset().left + $(this).parent().outerWidth() + $(this).children('ul:first').outerWidth() ) ) )
            $(this).find('ul:first').css( { left: "-" + cur.menuStyle.width } );
        }
        else
        {
          content.find('ul').hide();
        }
      }
    );
    content.find('ul').css(cur.menuStyle).find('li:not(.separator)').css(cur.itemStyle).hover
    (
      function(){ $(this).css(cur.itemHoverStyle); },
      function(){ $(this).css(cur.itemStyle); }
    ).find('img').css({verticalAlign:'middle',paddingRight:'2px'});
    
    
    // Separator
    content.css(cur.menuStyle).find('li.separator').css
    (
      {
        border: 'none',
        borderTop: cur.menuStyle.border,
        fontSize: '0',
        lineHeight: '0',
        height: '0',
        padding: '0',
        margin: '1px 0',
        backgroundColor: 'transparent'
      }
    );

    // Send the content to the menu
    menu.html(content);

    // if there's an onShowMenu, run it now -- must run after content has been added
		// if you try to alter the content variable before the menu.html(), IE6 has issues
		// updating the content
    if (!!cur.onShowMenu) menu = cur.onShowMenu(e, menu);

    $.each(cur.bindings, function(id, func) {
      $('#'+id, menu).bind('click', function(e) {
        hide();
        func(trigger, currentTarget);
      });
    });
    
    // Position Top
    if ( ( $(window).scrollTop() + $(window).height() - menu.height() ) > e[cur.eventPosY] )
    {
     menu.css({'top':e[cur.eventPosY]}).show();
     if (cur.shadow) shadow.css({width:menu.width(),height:menu.height(),top:e.pageY+2}).show();
    }
    else
    {
     menu.css({'top':e[cur.eventPosY]-menu.height()}).show();
     if (cur.shadow) shadow.css({width:menu.width(),height:menu.height(),top:e.pageY+2-menu.height()}).show();
    }
    // Position Left
    if ( ( $(window).scrollLeft() + $(window).width() - menu.width() ) > e[cur.eventPosX] )
    {
     menu.css({'left':e[cur.eventPosX]}).show();
     if (cur.shadow) shadow.css({width:menu.width(),height:menu.height(),left:e.pageX+2}).show();
    }
    else
    {
     menu.css({'left':e[cur.eventPosX]-menu.width()}).show();
     if (cur.shadow) shadow.css({width:menu.width(),height:menu.height(),left:e.pageX+2-menu.width()}).show();
    }
    $(document).one('click', hide);
  }

  function hide() {
    menu.hide();
    shadow.hide();
  }

  // Apply defaults
  $.contextMenu = {
    defaults : function(userDefaults) {
      $.each(userDefaults, function(i, val) {
        if (typeof val == 'object' && defaults[i]) {
          $.extend(defaults[i], val);
        }
        else defaults[i] = val;
      });
    }
  };

})(jQuery);

$(function() {
  $('div.contextMenu').hide();
});