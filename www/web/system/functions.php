<?php

/*
 * Remove entities from string
 *
 * remove_entities()
 */

function remove_entities( $string )
{
 $encoding = mb_detect_encoding( $string, mb_detect_order(), TRUE );
 if ( $encoding !== FALSE )
 {
  $string = mb_convert_encoding( $string, mb_internal_encoding(), $encoding );
 }

 return str_replace(
         array( "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�" ),
         array( "a", "A", "a", "A", "a", "A", "a", "A", "a", "A", "a", "A", "ae", "AE", "c", "C", "e", "E", "e", "E", "e", "E", "e", "E", "i", "I", "i", "I", "i", "I", "i", "I", "n", "N", "o", "O", "o", "O", "o", "O", "o", "O", "o", "O", "o", "O", "oe", "OE", "s", "S", "u", "U", "u", "U", "u", "U", "u", "U", "y", "Y", "y", "Y" ),
         $string
 );
}

/*
 * To convert a string data to a string url data
 *
 * strtouri()
 */

function strtouri( $string )
{
 $string = trim( $string );
 $string = htmlentities_decode( $string );
 $string = remove_entities( $string );
 $string = str_replace( array( "'", " ", "/" ), "-", $string );
 $string = str_replace( array( "@", "*", "\\", "&", "^", "~", "$", "�", "�", "�", "%", "�", ",", "?", ";", ":", "!", "<", ">", "#", "{", "\"", "(", "[", "|", "`", ")", "]", "�", "=", "}", ".", "�", "+", ".", "�", "�", "�" ), "", $string );
 $string = str_replace( array( "-�", "�" ), "-euros", $string );
 $string = strtolower( $string );

 while ( strpos( $string, "--" ) !== FALSE )
  $string = str_replace( "--", "-", $string );

 if ( substr( $string, -1 ) == "-" )
  $string = substr( $string, 0, -1 );
 if ( substr( $string, 0, 1 ) == "-" )
  $string = substr( $string, 1 );

 return $string;
}

/**
 *
 * @param string $string
 * @return string
 */
function htmlentities_decode( $string )
{
 $encoding = mb_detect_encoding( $string, mb_detect_order(), TRUE );
 if ( $encoding !== FALSE )
 {
  $string = mb_convert_encoding( $string, mb_internal_encoding(), $encoding );
 }

 $html_translation_table = get_html_translation_table();
 return str_replace( array_values( $html_translation_table ), array_keys( $html_translation_table ), $string );
}

/*
 * Truncate texts
 *
 * truncate()
 */

const TRUNCATE_LEFT = 1;
const TRUNCATE_RIGHT = 2;
const TRUNCATE_MIDDLE = 3;

function truncate( $text, $nbCar=128, $where=TRUNCATE_RIGHT )
{
 $text = htmlentities_decode( $text );

 if ( strlen( trim( $text ) ) > 0 && strlen( trim( $text ) ) > $nbCar )
 {
  switch ( $where )
  {
   case TRUNCATE_LEFT:
    $text = "<small>(...)</small> " . htmlentities( substr( $text, strlen( $text ) - $nbCar, strlen( $text ) ) );
    break;
   case TRUNCATE_RIGHT:
    $text = htmlentities( substr( $text, 0, $nbCar ) ) . " <small>(...)</small>";
    break;
   case TRUNCATE_MIDDLE:
    $text = htmlentities( substr( $text, 0, ceil( $nbCar / 2 ) ) ) . " <small>(...)</small> " . htmlentities( substr( $text, strlen( $text ) - floor( $nbCar / 2 ), strlen( $text ) ) );
    break;
  }
 }

 return $text;
}

/**
 * return  a date in french language
 * @param string $format
 * @param int $timestamp
 * @return string
 */
function date_french( $format, $timestamp = null )
{
 $param_D = array( '', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim' );
 $param_l = array( '', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche' );
 $param_F = array( '', 'Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre' );
 $param_M = array( '', 'Jan', 'F&eacute;v', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Ao&ucirc;', 'Sep', 'Oct', 'Nov', 'D&eacute;c' );

 $return = '';
 if ( is_null( $timestamp ) )
 {
  $timestamp = time();
 }
 for ( $i = 0, $len = strlen( $format ); $i < $len; $i++ )
 {
  switch ( $format[$i] )
  {
   case '\\' : // fix.slashes
    $i++;
    $return .= isset( $format[$i] ) ? $format[$i] : '';
    break;
   case 'D' :
    $return .= $param_D[date( 'N', $timestamp )];
    break;
   case 'l' :
    $return .= $param_l[date( 'N', $timestamp )];
    break;
   case 'F' :
    $return .= $param_F[date( 'n', $timestamp )];
    break;
   case 'M' :
    $return .= $param_M[date( 'n', $timestamp )];
    break;
   default :
    $return .= date( $format[$i], $timestamp );
    break;
  }
 }
 return $return;
}

?>
