<?php

include('./config.php');
include('./xdcc.class.php');

//                if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");
//                // log in at server1.example.com on port 22
//                if(!($con = ssh2_connect('ns301839.ovh.net', 2226))){
//                    echo "fail: unable to establish connection\n";
//                } else {
//                    // try to authenticate with username root, password secretpassword
//                    if(!ssh2_auth_password($con, 'xdcc', 'OR5F1OBSe1YgU6q8')) {
//                        echo "fail: unable to authenticate\n";
//                    } else {
//                        // allright, we're in!
//                        echo "okay: logged in...\n";
//
//                        // execute a command
//                        if(!($stream = ssh2_exec($con, "ls -al" )) ){
//                            echo "fail: unable to execute command\n";
//                        } else{
//                            // collect returning data from command
//                            stream_set_blocking( $stream, true );
//                            $data = "";
//                            while( $buf = fread($stream,4096) ){
//                                $data .= $buf;
//                            }
//                            fclose($stream);
//                            echo $data;
//                        }
//                    }
//                }


$con = new mysqli( $hostname, $user, $pass, $database );
$xdcc_class = new xdcc( $con );
$servers = array( );
if ( $result = $con->query( 'SELECT LOWER( s.`host` ) AS host,
                                    s.`http_port`,
                                    s.`ssl`,
                                    x.`url`,
                                    x.`id`
                             FROM `xdccs` x
                             LEFT JOIN `servers` s ON ( s.`id` = x.`id_server` )' ) )
{
 while ( $ligne = $result->fetch_object() )
 {
  if ( !isset( $servers[$ligne->host] ) )
  {
   $servers[$ligne->host] = array( );
  }
  if ( !isset( $servers[$ligne->host][$ligne->http_port] ) )
  {
   $servers[$ligne->host][$ligne->http_port] = array( );
  }
  $servers[$ligne->host][$ligne->http_port][$ligne->id] = array( "ssl" => ($ligne->ssl == "yes"), "url" => $ligne->url );
 }
 $result->close();
 $xdcc_class->update( $servers );
}
else
{
 die( 'Erreur lors de la récupération de la liste des xdccs' );
}
?>