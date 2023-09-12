<?php
defined( '_JEXEC' ) or die;
function comparelistBuildRoute( &$query ){
	//var_dump ($query);
    $segments = array();
    if ( isset( $query['view'] ) ) {
        $segments[] = $query['view'];
        unset( $query['view'] );
    }
    return $segments;
}

function comparelistParseRoute( $segments )
{
    $vars = array();
    $count = count( $segments );
    if ( $count ) {
        $count--;
        $segment = array_shift( $segments );
        $vars['view'] = $segment;
    }
    if ( $count ) {
        $count--;
        $segment = array_shift( $segments );
        $vars['id'] = $segment;
    }
    return $vars;
}
