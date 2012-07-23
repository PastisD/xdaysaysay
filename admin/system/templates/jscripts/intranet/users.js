var TABLE_PAGE = 1;
var TABLE_ORDER = null;
var TABLE_ORDER_BY = null;
var TABLE_SEARCH = null;

function loadPage()
{
 var components = parseAjaxQueryString();
 var lastPage = TABLE_PAGE;
 var lastOrder = TABLE_ORDER;
 var lastOrderBy = TABLE_ORDER_BY;

 TABLE_PAGE = ( typeof components.p != "undefined" ? components.p : TABLE_PAGE );
 TABLE_ORDER = ( typeof components.o != "undefined" ? components.o : TABLE_ORDER );
 TABLE_ORDER_BY = ( typeof components.ob != "undefined" ? components.ob : TABLE_ORDER_BY );
 TABLE_SEARCH = ( typeof components.s != "undefined" ? components.s : TABLE_SEARCH );

 if( TABLE_SEARCH == "" || TABLE_SEARCH == null )
 {
  if( lastPage != TABLE_PAGE
   || lastOrder != TABLE_ORDER
   || lastOrderBy != TABLE_ORDER_BY )
   updateListeUtilisateurs();
 }
 else
  searchUser( TABLE_SEARCH, TABLE_PAGE );
}
function updateListeUtilisateurs()
{
 var data = {
  action_form: "list",
  page: ( TABLE_PAGE == null ? '' : TABLE_PAGE ),
  order: ( TABLE_ORDER == null ? '' : TABLE_ORDER ),
  order_by: ( TABLE_ORDER_BY == null ? '' : TABLE_ORDER_BY ),
  search: ( TABLE_SEARCH == null ? '' : TABLE_SEARCH )
 };

 ajaxQueryString( {
  p: TABLE_PAGE,
  o: TABLE_ORDER,
  ob: TABLE_ORDER_BY,
  s: TABLE_SEARCH
 } );

 $.post( URI + "/system/ajax/intranet/users.php",
  data,
  function( data )
  {
   //            if( errorCode( data ) )
   //            {
   $("#listeUtilisateurs").fadeOut( "fast",
    function()
    {
     $("#listeUtilisateurs").empty();
     $("#listeUtilisateurs").html( data.html );
     initContextMenu();
     $("#listeUtilisateurs").fadeIn( "fast" );

     $("#listeUtilisateurs").parent().find("h2 span.nbTotal span").empty();
     $("#listeUtilisateurs").parent().find("h2 span.nbTotal span").html( data.nbTotal );

     $("#navPagesUtilisateurs").empty();
     $("#navPagesUtilisateurs").html( data.navPages );
    } );
  //            }
  }, "json");
}
function movePage( page )
{
 TABLE_PAGE = parseInt( page );
 updateListeUtilisateurs();
}

function searchUser( w, page )
{
 if( ( $.trim(w) ).length < 3 )
 {
  alert( "Le texte de votre recherche doit contenir plus de 3 caractères" );
 }
 else
 {
  var textInput = $("div#search").find( "input.text" );
  var closeInput = $("div#search").find( "input.close" );

  if( closeInput.css( "display" ) == "none" )
   textInput.animate(
   {
    width: "-=20px"
   },
   "fast",
   function(){
    closeInput.fadeIn( "fast" );
   }
   );
  TABLE_PAGE = ( typeof page != "number" ? 1 : parseInt( page ) );
  TABLE_SEARCH = w;
  updateListeUtilisateurs();

  $("span#search_text").html( " - Recherche : &laquo; " + TABLE_SEARCH + " &raquo;" );
 }
}
function stopSearchUser()
{
 if( TABLE_SEARCH != null )
 {
  TABLE_PAGE = 1;
  TABLE_SEARCH = null;
  updateListeUtilisateurs();

  var textInput = $("div#search").find( "input.text" );
  textInput.val( "" );
  var closeInput = $("div#search").find( "input.close" );
  var checkboxInput = $("div#search").find( "input.checkbox" );
  checkboxInput.removeAttr( "checked" );

  $("span#search_text").empty();

  if( closeInput.css( "display" ) != "none" )
   closeInput.fadeOut(
    "fast",
    function(){
     textInput.animate( {
      width: "+=20px"
     }, "fast" );
    });
 }
}

function verif_mail(mail) {
 var mail_regex = /^[\w\-]+(\.[\w\-]+)*@[\w\-]+(\.[\w\-]+)*\.[\w\-]{2,}$/;
 if (mail != '' )
 {
  return mail_regex.test(mail)
 }
 return true;
}

function verif_pass(pass1, pass2, must_be_set) {
 if (pass1 != '' || pass2 != '') {
  if (pass1 != pass2)
   return false;
  else {
   return true;
  }
 }
 if (must_be_set)
  return false;
 else
  return true;
}


function addEditUser( )
{
 if (!verif_mail($("#form_email").val()) )
 {
  alert("L'adresse email n'est pas valide.")
 } else if (!verif_pass($('#form_password').val(), $('#form_password_bis').val(), ($("#form input[name=action_form]").val() == 'add') ? true : false)) {
  alert("Le mot de passe est mal confirmé.")
 } else {
  data_temp = $("#form :input").serializeArray();
  var data = {};
  $.each( data_temp,
   function( i, value )
   {
    if( eval( "typeof data." + value.name + " == 'undefined'" ) )
    {
     eval( "data." + value.name + "=value.value;" );
    }
    else
    {
     eval( "data." + value.name + "+=','+value.value;" );
    }
   });
  delete data_temp;


  $.post( URI + "/system/ajax/intranet/users.php",
   data,
   function( data )
   {
    if( data.status == true )
    {
     switch ($("#form input[name=action_form]").val())
     {
      case 'add' :
       alert( "L'utilisateur a été créé avec succès.",
       {
        submit: function(v,m)
        {
         window.location = URI + '/users/';
         return false;
        }
       });
       break;
      case 'edit' :
       alert( "L'utilisateur a été modifié avec succès.",
       {
        submit: function(v,m)
        {
         window.location = URI + '/users/';
         return false;
        }
       });
       break;
     }
    } else {
     alert( "Une erreur est survenue.");
    }

    $("#form :input[type=submit]").removeAttr( "disabled" );
   }, "json");
 }
}

function effacerUtilisateur_confirm( id )
{
 alert( "Êtes-vous sûr de vouloir supprimer cet utilisateur ?",
 {
  buttons: {
   Oui: true,
   Non: false,
   Annuler: false
  },
  submit: function(v,m)
  {
   if( v == true )
    effacerUtilisateur( id );
   return true;
  }
 }
 );
}
function effacerUtilisateur( id )
{
 var data = {
  action_form: "del",
  id_user: id
 };

 $.post( URI + "/system/ajax/intranet/users.php",
  data,
  function( data )
  {
   if (data.status == true)
   {
    alert( "L'utilisateur a été supprimé avec succès." );
    updateListeUtilisateurs();
   } else {
    alert( "Une erreur est survenue." );
   }
  }, "json");
}

function initContextMenu()
{
 $('.context_menu').contextMenu( 'menu_contextuel',
 {
  menuStyle:
  {
   width: '200px'
  },
  itemStyle :
  {
   padding: '1px 3px',
   color: '#404040'
  },
  itemHoverStyle :
  {
   backgroundColor: '#c7cddd',
   color: '#000'
  },
  onContextMenu: function(e)
  {
   bReturn = true;
   return bReturn;
  },
  bindings:
  {
   'context_menu_add': function(t){
    window.location= URI + '/users/add/';
   },
   'context_menu_edit': function(t)
   {
    var id_element = getIdOfElement_contextMenu( t.id );
    window.location= URI + '/users/edit/' + id_element + '/';
   },
   'context_menu_del': function(t){
    effacerUtilisateur_confirm( getIdOfElement_contextMenu( t.id ) );
   },
   'context_menu_refresh': function(t){
    updateListeUtilisateurs();
   }
  },
  onShowMenu: function(e, menu)
  {
   var id_element = getIdOfElement_contextMenu( $($(e.target).parents('.context_menu')[0]).attr('id') );

   if( id_element == null )
   {
    $('#context_menu_edit', menu).remove();
    $('#context_menu_del', menu).remove();
    $('.separator', menu).remove();
   }
   else
    $($(e.target).parents('.context_menu')[0]).click();
   return menu;
  }
 });
 $('tr.l_0, tr.l_1').click( function(){
  $('tr.l_0, tr.l_1').removeClass( 'l_selected' );
  $(this).addClass( 'l_selected' );
 } );
 $('tr.l_0, tr.l_1').dblclick( function(e)
 {
  var id_element = getIdOfElement_contextMenu( $($(e.target).parents('.context_menu')[0]).attr('id') );
  window.location= URI + '/users/edit/' + id_element + '/';
 } );
}

$(document).ready( function()
{
 initContextMenu();
 loadPage();
} );