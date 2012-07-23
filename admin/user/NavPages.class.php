<?php
 
 class NavPages
 {
  
  public static function getNavPages( $nbTotal, $nbPerPage, $link, $pageActive=NULL, $javascript=NULL )
  {
   $template = "";
   $pageActive = $pageActive == NULL || $pageActive == 0 ? 1 : intval( $pageActive );
   
   $nbPages = ceil( $nbTotal / $nbPerPage );
   //$pageActive = $pageActive == NULL || $pageActive == 0 ? $nbPages : intval( $pageActive );
   
   if( $nbPages > 10000 )
    $nbPagesAutour = 2;
   else if( $nbPages > 1000 )
    $nbPagesAutour = 4;
   else
    $nbPagesAutour = 8;
   
   $iStart = ( ( $pageActive - $nbPagesAutour ) < 1 ? 1 : $pageActive - $nbPagesAutour ) - ( ( $pageActive + $nbPagesAutour ) > $nbPages ? ( $pageActive + $nbPagesAutour ) - $nbPages : 0 );
   if( $iStart < 1 ) $iStart = 1;
   $iEnd = ( ( $pageActive + $nbPagesAutour ) > $nbPages ? $nbPages : $pageActive + $nbPagesAutour ) + ( ( $pageActive - $nbPagesAutour ) < 1 ? abs( $pageActive - $nbPagesAutour ) + 1 : 0 );
   if( $iEnd > $nbPages ) $iEnd = $nbPages;
   if( $iEnd < 1 ) $iEnd = 1;
   
   for( $i=$iStart ; $i<=$iEnd ; $i++ )
    $template .= ( $i > $iStart ? " " : "" ). "<a href=\"". str_replace( "%i", $i, $link ). "\"". ( $javascript !== NULL ? " onclick=\"". str_replace( "%i", $i, $javascript ). "\"" : "" ). ">". ( $i == $pageActive ? "<span>". sprintf( "%0". strlen( $nbPages ). "d", $i ). "</span>" : sprintf( "%0". strlen( $nbPages ). "d", $i ) ). "</a>". ( $i < $iEnd ? "," : "" );
   
   $template = "Page ". ( $iStart > 1 ? "..." : "" ). $template. ( $iEnd < $nbPages ? "..." : "" );
   $template = "<span class=\"left\">". ( $pageActive > $iStart && $iStart != $iEnd ? "<a href=\"". str_replace( "%i", 1, $link ). "\"". ( $javascript !== NULL ? " onclick=\"". str_replace( "%i", 1, $javascript ). "\"" : "" ). ">&lt;&lt;&lt;</a> <a href=\"". str_replace( "%i", ( $pageActive - 1 ), $link ). "\"". ( $javascript !== NULL ? " onclick=\"". str_replace( "%i", ( $pageActive - 1 ), $javascript ). "\"" : "" ). ">&lt;&lt;</a> " : "&lt;&lt;&lt; &lt;&lt; " ). "</span><span class=\"right\">". ( $pageActive < $iEnd && $iStart != $iEnd ? " <a href=\"". str_replace( "%i", ( $pageActive + 1 ), $link ). "\"". ( $javascript !== NULL ? " onclick=\"". str_replace( "%i", ( $pageActive + 1 ), $javascript ). "\"" : "" ). ">&gt;&gt;</a> <a href=\"". str_replace( "%i", $nbPages, $link ). "\"". ( $javascript !== NULL ? " onclick=\"". str_replace( "%i", $nbPages, $javascript ). "\"" : "" ). ">&gt;&gt;&gt;</a>" : " &gt;&gt; &gt;&gt;&gt;" ). "</span>". $template;
   
   return $template;
  }
  
 }

?>