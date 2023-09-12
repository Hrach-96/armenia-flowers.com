<?php


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class modJSCAlert {
    function getCAlert( $params ) {
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('body').cwAllowCookies({
		
		cwmessage: 		"<?php echo $params->get( 'js_cwmessage' ); ?>",
        cwbubblemessage:	"<?php echo $params->get( 'js_cwbubblemessage' ); ?>",
        cwbubbletitle:		"<?php echo $params->get( 'js_cwbubbletitle' ); ?>",
		cwbubbletitlex:		"<?php echo $params->get( 'js_cwbubbletitle' ); ?>",
	    cwhref:			"",
        cwreadmore:		"<?php echo $params->get( 'js_cwreadmore' ); ?>",
        cwagree:		"<?php echo $params->get( 'js_cwagree' ); ?>",
       	cwmoreinfo:		"<?php echo $params->get( 'js_cwmoreinfo' ); ?>",				cwbuttoncolor:		"<?php echo $params->get( 'js_cwbuttoncolor' ); ?>",
		animate:				true,
		europeonly:				false,
		}); 
	});

</script>
<?php
    }
}
?>