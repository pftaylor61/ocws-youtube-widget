<?php
/*
Plugin Name: OCWS YouTube Widget
Plugin URI: http://www.oldcastleweb.com/pws/plugins/
Description: This plugin adds a new widget to your Wordpress installation, called 'OCWS YouTube Widget'. This widget enables YouTube videos to be added to your sidebar. The widget form enables the pasted dimensions to be recalculated to whatever width the user has set.
Version: 0.4
Author: Paul Taylor
Author URI: http://www.oldcastleweb.com/pws/about/
License: GPL2
GitHub Plugin URI: https://github.com/pftaylor61/ocws-youtube-widget
GitHub Branch:     master
*/
/*  Copyright 2012  Paul Taylor  (email : info@oldcastleweb.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



/**
 * Adds OCWS_YouTube_Widget widget.
 * Much of the code for this widget plugin was found on the Wordpress.org site at:
 * http://codex.wordpress.org/Widgets_API
 */
 

 
class OCWS_YouTube_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'ocws_youtube_widget', // Base ID
			'OCWS YouTube Widget', // Name
			array( 'description' => __( 'OCWS YouTube Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$oc_width = $instance['oc_width'];
		$oc_ytc = $instance['oc_ytc'];

		// test values (delete or comment out)
		// $co_width = "300";
		// $oc_ytc = "<iframe width=\"560\" height=\"315\" src=\"http://www.youtube.com/embed/Wn2GcmYN2wM\" frameborder=\"0\" allowfullscreen></iframe>";
		
// this code needs amending

		

		$htmlcode = "";
		$htmlcode .= "\n<div id=\"ytbox\" style=\"width:".$oc_width."; margin-left:auto;margin-right:auto;\">\n";
		$htmlcode .= reduceyt($oc_ytc,$oc_width)."<br/>\n";
		$htmlcode .= "</div>\n";
		

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		echo __( $htmlcode, 'text_domain' );
		echo $after_widget;
	}
// end of bit that needs editing
	
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['oc_width'] = strip_tags( $new_instance['oc_width'] );
		$instance['oc_ytc'] = mysql_real_escape_string( $new_instance['oc_ytc'] );

		

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) && isset( $instance[ 'oc_width' ]) && isset( $instance[ 'oc_ytc' ])  ) {
			$title = $instance[ 'title' ];
			$oc_width = $instance[ 'oc_width' ];
			$oc_ytc = $instance[ 'oc_ytc' ];

		}
		else {
			$title = "";
			$oc_width = "300";
			$oc_ytc = __( 'YouTube Code', 'text_domain' );

		}
		?>
		<p>
		
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title: (If not required, leave blank)' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		
		<div id="im_wg_instr" style="border:1px black dotted; background-color:cornsilk; font-size:8pt; color:black; padding:5px;-moz-border-radius: 15px;
border-radius: 15px;">
			<p>
				The YouTube code should be pasted into the box, in the newer iframe format (the older format will not work). You should set the width to recalculate the code. If you do not do so, a default width of 300 will be used.
			</p>
		</div>
		
		<label for="<?php echo $this->get_field_id( 'oc_width' ); ?>"><?php _e( 'Width:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'oc_width' ); ?>" name="<?php echo $this->get_field_name( 'oc_width' ); ?>" type="text" value="<?php echo esc_attr( $oc_width ); ?>" />
		
		<label for="<?php echo $this->get_field_id( 'oc_ytc' ); ?>"><?php _e( 'YouTube Code:' ); ?></label> 
		<textarea class="widefat" style="height:150px;" id="<?php echo $this->get_field_id( 'oc_ytc' ); ?>" name="<?php echo $this->get_field_name( 'oc_ytc' ); ?>"><?php echo stripslashes( $oc_ytc ); ?></textarea>
		
		



		<table><tr>
		<td><img src="http://www.oldcastleweb.com/pws/wp-content/uploads/2012/08/castlelogo16x16.png" width="16" height="16" alt="OCWS Logo" title="" /></td>
		<td style="font-size:8pt;"><a style="text-decoration:none" href="http://www.oldcastleweb.com/pws/plugins/" target="_blank">Old Castle Web Services</a></td>
		</tr></table>
		
		</p>
		<?php 
	}

} // class OCWS_YouTube_Widget

function reduceyt($ytc,$nwid) {
	
	$chopstr =$ytc;
	$chopstr = str_replace("\'","\"",$chopstr);
	$chopstr = str_replace("'","\"",$chopstr);


	$wpos = strpos($chopstr, "width");
	$chopstr = substr($chopstr, $wpos);


	$wpos = strpos($chopstr, "\"");

	$chopstr = substr($chopstr, $wpos+1);
	
	$wend = strpos($chopstr, "\"");

	$ytwid = substr($chopstr,0,$wend);
	
	$chopstr = $ytc;
	
	$chopstr = substr($chopstr,$wend);

	$hpos = strpos($chopstr,"height");
	$chopstr = substr($chopstr, $hpos);

	$hpos = strpos($chopstr, "\"");
	$chopstr = substr($chopstr, $hpos+1);

	$hend = strpos($chopstr, "\"");

	$ytht = substr($chopstr,0,$hend);
	
	$chopstr = $ytc;
	$spos = strpos($chopstr,"src");
	$chopstr = substr($chopstr, $spos);
	$spos = strpos($chopstr, "\"");
	$chopstr = substr($chopstr, $spos+1);
	

	$spos = strpos($chopstr,"\"");
	$ysrc = substr($chopstr,0,$spos);
	

	$chopstr = "<iframe width=\"".$nwid."\" height=\"".intval(($nwid*$ytht/$ytwid)+0.5)."\" src=\"".$ysrc."\" frameborder=\"0\" allowfullscreen></iframe>";
	
	return $chopstr;
} // end function reduceyt

// register OCWS_YouTube_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "ocws_youtube_widget" );' ) );







?>