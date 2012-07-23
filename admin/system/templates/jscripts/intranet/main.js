$.ajaxSetup({
             beforeSend: function(){ ajaxLoading_start(); },
             complete: function(){ ajaxLoading_stop(); }
           });

var iAjaxLoading = 0;
function ajaxLoading_start()
{
 if( iAjaxLoading == 0)
 {
  $("body").append( "<div id=\"waiting\" style=\"display: none;\">Merci de patienter...</div>" );
  $("#waiting").slideDown( "normal" );
 }
 iAjaxLoading++;
}
function ajaxLoading_stop()
{
 iAjaxLoading--;
 if( iAjaxLoading <= 0 )
 {
  $("#waiting").slideUp( "normal", function(){ $("#waiting").remove(); } );
  iAjaxLoading = 0;
 }
}

/* Return the ID of an element, ex : e_xxx : xxx is the ID */

function getIdOfElement_contextMenu( id )
{
 var id_element = null;

 if( id != undefined && id != "" )
 {
  var idArray = id.split( '_' );
  if( $(idArray).get( 0 ) == 'e' )
   //if( !isNaN( $(idArray).get( $(idArray).size()-1 ) ) )
    id_element = $(idArray).get( $(idArray).size()-1 );
 }

 return id_element;
}

function parseAjaxQueryString()
{
 var components = {};
 var hash = window.location.hash;
 hash = hash.replace(/^.*#/, '');

 hash = hash.split( ";" );
 $.each( hash,
         function( i, n )
         {
          n = n.split( "=" );
          if( typeof n[0] == "string" && $.trim( n[0] ) != ""
           && typeof n[1] == "string" && $.trim( n[1] ) != "" )
           eval( "components." + n[0] + "=decodeURIComponent( n[1] );" );
         } );

 return components;
}

function ajaxQueryString( querystring )
{
 if( typeof querystring == "object" )
 {
  var query = "";
  var j =0;

  $.each( querystring,
          function( i, n )
          {
           if( typeof i == "string" && $.trim( i ) != "" && n != null )
            query += ( j>0 ? ";" : "" ) + i + "=" + n;

           j++;
          } );

  if( $.trim( query ) )
  {
   //$.historyLoad( query );
   window.location = "#" + query;
  }
 }
}

function changeOrder( order_by, element )
{
 if( !( typeof TABLE_ORDER == "undefined" && typeof TABLE_ORDER_BY == "undefined" ) )
 {
  if( order_by != TABLE_ORDER_BY )
   if( TABLE_ORDER == "desc" )
    TABLE_ORDER = "asc";
   else
    TABLE_ORDER = "desc";

  if( TABLE_ORDER == "desc" )
  {
   TABLE_ORDER = "asc";
   $("a.order_none, a.order_asc, a.order_desc").attr( "class", "order_none" );
   $(element).attr( "class", "order_asc" );
  }
  else
  {
   TABLE_ORDER = "desc";
   $("a.order_none, a.order_asc, a.order_desc").attr( "class", "order_none" );
   $(element).attr( "class", "order_desc" );
  }

  TABLE_ORDER_BY = order_by;
 }
}



