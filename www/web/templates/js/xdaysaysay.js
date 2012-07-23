$(document).ready(function () {
	$('.team').next().toggle();
	$('.team').click(function () {
		$(this).next().slideToggle('slow', 
			function() {
				if ($(this).css('display') == 'none') {
					$(this).prev().removeClass('opened');
				} else {
					$(this).prev().addClass('opened');
				}
			});
		return false;
	});

 $('.menuStep').each( function() {
  if( $('a.selected', $(this)).length > 0 )
  {
   $('ul', $(this) ).show();
   $('> a', $(this)).addClass('opened');
  }
 } );
	$('.bot a').click(function () {
		$('.bot a').removeClass('selected');
		$(this).addClass('selected');
//		return false;
	});
});

function link( nick, pack)
{
 prompt('Collez ceci dans votre client IRC:','/msg '+nick+' xdcc send #'+pack);
}