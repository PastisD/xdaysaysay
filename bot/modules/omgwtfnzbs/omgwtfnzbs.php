<?php

/*
+---------------------------------------------------------------------------
|   PHP-IRC Omgwtfnzbs search engine
|   ========================================
|     by Fl0w3D
+---------------------------------------------------------------------------
|   > This program is free software; you can redistribute it and/or
|   > modify it under the terms of the GNU General Public License
|   > as published by the Free Software Foundation; either version 2
|   > of the License, or (at your option) any later version.
|   >
|   > This program is distributed in the hope that it will be useful,
|   > but WITHOUT ANY WARRANTY; without even the implied warranty of
|   > MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
|   > GNU General Public License for more details.
|   >
|   > You should have received a copy of the GNU General Public License
|   > along with this program; if not, write to the Free Software
|   > Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
+---------------------------------------------------------------------------
*/

class omgwtfnzbs_mod extends module {

	public $title = 'omgwtfnzbs';
	public $author = 'Fl0w3D';
	public $version = '0.1';
	private $api_user = '';
	private $api_key = '';
	private $limit = 8;

	public function init() {
	}

	public function destroy() {
	}

	public function omg_search($line, $args) {
	    if ($this->ircClass->isMode($line['fromNick'], $line['to'], "o"))
	    {
	        if ($args['nargs'] >= 1)
	        {
	            $q = $args ['query'];
	
	            $xml_filepath = 'http://api.omgwtfnzbs.org/xml/?search='.$q.'&eng=1&user='.$this->api_user.'&api='.$this->api_key;
	            
	            if($xml_reader = simplexml_load_file($xml_filepath))
	            {
	                $array = $xml_reader->xpath('search_req/post');
	                $preg_pattern = '/('.$q.')/i';
			$preg_replacement = '$1';

                    	foreach(array_slice($array, 0, (count($array) > 5 ? $this->limit : count($array))) as $post)
			{
			    $post->release = preg_replace($preg_pattern, $preg_replacement, $post->release);
 			    $this->ircClass->privMsg( $line['to'], '07['.$post->nzbid. '07] - ' . $post->release . ' 07@ '.$post->cattext);
			}
		        $results_left = count($array) - $this->limit;
			if($results_left > 0) 
			{
				$q = str_replace(' ', '+', $q);
		                $this->ircClass->privMsg( $line['to'], $results_left . ' autres résultats : http://omgwtfnzbs.org/browse?search=' . $q);
	                }
			if(count($array) == 0) $this->ircClass->privMsg( $line['to'], 'Aucun résultat !');
	            } else {
		            $this->ircClass->privMsg( $line['to'], 'Bon bah... Ça a planté, désolé. :D');
	            }
		} else {
			$this->ircClass->privMsg( $line['to'], 'T\'aurais pas oublié un truc par hasard ?');
		}
		return;
	   }
	}
}

?>
