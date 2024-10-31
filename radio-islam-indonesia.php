<?php
/*
Plugin Name: Radio Islam Indonesia
Plugin URI: http://www.radioislamindonesia.com/
Description: Kumpulan streaming radio Islam di Indonesia yang Insya Allah berdasarkan pengajaran Al Qur'an dan As Sunnah [Al Hadits] dan pemahaman para Shahabat. Tambahkan Radio Islam Indonesia di widget atau dengan shortcode <code>[radio-islam-indonesia]</code>. Semoga bermanfaat.
Author: Darto KLoning
Version: 3.15.2015
Author URI: http://www.kloningspoon.com/

Copyright 2014  Darto KLoning (email: darto@kloningspoon.com)

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

if (!is_admin()) add_action("wp_enqueue_scripts", "rido_script", 11);
function rido_script() {
   $rido_jplayer = 'jquery.jplayer.min.js';
   $rido_jplayer_playlist = 'jplayer.playlist.min.js';
   $list = 'enqueued';
   if (wp_script_is( $rido_jplayer, $list )) {
       return;
     } else {
       wp_register_script( 'jQuery-jPlayer', plugins_url('/js/jquery.jplayer.min.js', __FILE__), array('jquery'), null, false);
       wp_enqueue_script( 'jQuery-jPlayer' );
     }
	 
	if (wp_script_is( $rido_jplayer_playlist, $list )) {
       return;
     } else {
       wp_register_script( 'jQuery-jPlayer-Playlist', plugins_url('/js/jplayer.playlist.min.js', __FILE__), '', null, false);
       wp_enqueue_script( 'jQuery-jPlayer-Playlist' );
     }
   wp_enqueue_script('jquery');
	   
   wp_register_style( 'jPlayer-pink-flag', plugins_url('/css/jplayer.pink.flag.css', __FILE__) );
   wp_enqueue_style('jPlayer-pink-flag');
}

// create Radio Islam Indonesia shortcode
add_shortcode("radio-islam-indonesia", "rido");
function rido() {
    return '<div id="jquery_jplayer_radio_islam_indonesia" class="jp-jplayer"></div>
<div id="jp_container_radio_islam_indonesia" class="jp-audio" role="application" aria-label="media player">
	<div class="jp-type-playlist">
		<div class="jp-gui jp-interface">
			<div class="jp-volume-controls">
				<button class="jp-mute" role="button" tabindex="0">mute</button>
				<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
			</div>
			<div class="jp-controls-holder">
				<div class="jp-controls">
					<button class="jp-previous" role="button" tabindex="0">previous</button>
					<button class="jp-play" role="button" tabindex="0">play</button>
					<button class="jp-stop" role="button" tabindex="0">stop</button>
					<button class="jp-next" role="button" tabindex="0">next</button>
				</div>
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
			</div>
		</div>
		<div class="jp-playlist">
			<ul>
				<li>&nbsp;</li>
			</ul>
		</div>
		<div class="jp-no-solution">
			<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
</div>';  
}

// Creating the widget 
class radio_islam_indonesia_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'radio_islam_indonesia_widget', 

// Widget name will appear in UI
__('Radio Islam Indonesia', 'radio_islam_indonesia_kloningspoon'), 

// Widget description
array( 'description' => __( 'Widget Radio Islam Indonesia', 'radio_islam_indonesia_kloningspoon' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
echo do_shortcode( '[radio-islam-indonesia]' );
echo $args['after_widget'];
}
        
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Radio Islam Indonesia', 'radio_islam_indonesia_kloningspoon' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
    
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
add_action( 'widgets_init', 'radio_islam_indonesia_load_widget' );
function radio_islam_indonesia_load_widget() {
    register_widget( 'radio_islam_indonesia_widget' );
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'radio_islam_indonesia_action_links' );
function radio_islam_indonesia_action_links( $links ) {
   $links[] = '<a href="https://profiles.wordpress.org/darto#content-plugins" target="_blank">More plugins by Darto KLoning</a>';
   return $links;
}

add_action('wp_head', 'radio_islam_indonesia_scripts');
function radio_islam_indonesia_scripts() {
	echo "\r\n\r\n\r\n<!-- Radio Islam Indonesia adalah kumpulan streaming radio Islam di Indonesia -->\r\n";
	echo "<!-- yang Insya Allah berdasarkan pengajaran Al Qur'an dan As Sunnah [Al Hadits] dan pemahaman para Shahabat. -->\r\n";
	echo "<!-- get it at http://www.radioislamindonesia.com -->\r\n\r\n\r\n";
	echo "<script type=\"text/javascript\">";
	echo "//<![CDATA[
var $$j = jQuery.noConflict();
$$j(document).ready(function(){	
		// Radio Islam Indonesia Playlist instance
		new jPlayerPlaylist({
			jPlayer: \"#jquery_jplayer_radio_islam_indonesia\",
			cssSelectorAncestor: \"#jp_container_radio_islam_indonesia\",
		}, [ 
				{
					title:\"Server Luar Negeri / Singapore\",
					artist:\"Radio Rodja 756AM - www.radiorodja.com\",
					mp3:\"http://live2.radiorodja.com/;stream.mp3\"
				},
				{
					title:\"Server Indonesia\",
					artist:\"Radio Rodja 756AM - www.radiorodja.com\",
					mp3:\"http://live.radiorodja.com/;stream.mp3\"
				},
				{
					title:\"Server Indonesia AAC\",
					artist:\"Radio Rodja 756AM - www.radiorodja.com\",
					mp3:\"http://live.radiorodja.com:2000/;stream.mp3\"
				},
				{
					title:\"Server Indonesia (low version)\",
					artist:\"Radio Rodja 756AM - www.radiorodja.com\",
					mp3:\"http://live.radiorodja.com:1000/;stream.mp3\"
				},
				{
					title:\"Rodja Bandung\",
					artist:\"Radio Rodja Bandung 1476AM - www.radiorodjabandung.com\",
					mp3:\"http://live.radiorodjabandung.com/;stream.mp3\"
				},
				{
					title:\"Bass FM\",
					artist:\"Radio Bass 93.2FM Salatiga - www.bassfmsalatiga.com\",
					mp3:\"http://live.bassfmsalatiga.com/;stream.mp3\"
				},
				{
					title:\"RayFM\",
					artist:\"Radio RayFM 95.1MHz Padang - www.radiorayfm.com\",
					mp3:\"http://live.radiorayfm.com/;stream.mp3\"
				},
				{
					title:\"Kita\",
					artist:\"Radio Kita 105.2FM Madiun - www.radiokita.or.id\",
					mp3:\"http://live.radiokita.or.id/;stream.mp3\"
				},
				{
					title:\"Shahabat Muslim\",
					artist:\"Radio Shahabat Muslim 107.7FM Tegal - www.radioshahabat.net\",
					mp3:\"http://119.82.232.92/;stream.mp3\"
				},
				{
					title:\"Idza'atul Khoir\",
					artist:\"Radio Idza'atul Khoir 92.7FM Ponorogo - www.idzaatulkhoirfm.com\",
					mp3:\"http://live.idzaatulkhoirfm.com/;stream.mp3\"
				},
				{
					title:\"Kita\",
					artist:\"Radio Kita 94.3FM Cirebon - www.radioassunnah.com\",
					mp3:\"http://live.radiosunnah.net/;stream.mp3\"
				},
				{
					title:\"Suara Qur'an\",
					artist:\"Radio Suara Qur'an Abror 94.4FM Sukoharjo - www.alukhuwah.com\",
					mp3:\"http://113.20.29.219:8010/;stream.mp3\"
				},
				{
					title:\"Hidayah\",
					artist:\"Radio Hidayah 103.4FM Pekanbaru - www.hidayahfm.com\",
					mp3:\"http://radio.hidayahfm.com:9988/;stream.mp3\"
				},
				{
					title:\"Hang\",
					artist:\"Radio Hang 106FM Batam - www.hang106.com\",
					mp3:\"http://live.hang106.com/;stream.mp3\"
				},
				{
					title:\"Suara Qur'an\",
					artist:\"Radio Suara Quran 100FM Lombok - www.assunnahfm.com\",
					mp3:\"http://assunnahfm.com:9010/;stream.mp3\"
				},
				{
					title:\"Muslim\",
					artist:\"Radio Muslim 107.8FM Yogyakarta - www.radiomuslim.com\",
					mp3:\"http://live.radiomuslim.com/;stream.mp3\"
				},
				{
					title:\"Suara Al Iman\",
					artist:\"Radio Suara Al Iman 846AM Surabaya - www.suaraaliman.com\",
					mp3:\"http://live.suaraaliman.com/;stream.mp3\"
				},
				{
					title:\"Mutiara Sunnah\",
					artist:\"Radio Mutiara Sunnah 90.5FM Magelang - www.radiomutiarasunnah.com\",
					mp3:\"http://live.radiomutiarasunnah.com/;stream.mp3\"
				},
				{
					title:\"SNTV\",
					artist:\"Radio SNTV - www.sntivi.id\",
					mp3:\"http://www.sntivi.id:8000/stream\"
				},
				{
					title:\"Dakwah Sunnah\",
					artist:\"Radio Dakwah Sunnah - www.dakwahsunnah.com\",
					mp3:\"http://199.167.134.163:7010/;stream.mp3\"
				},
				{
					title:\"Gema Madinah\",
					artist:\"Radio Gema Madinah 93.7FM Martapura - Kalimantan Selatan - www.gemamadinah.com\",
					mp3:\"http://113.20.29.219:8022/;stream.mp3\"
				},
				{
					title:\"Majas\",
					artist:\"Radio Majas 91.9FM Yogyakarta - www.radiomajas.com\",
					mp3:\"http://113.20.29.219:9998/;stream.mp3\"
				}
			], 
		{
			playlistOptions: {
			  autoPlay: true
			},
			swfPath: \"".plugins_url('/js/jquery.jplayer.swf', __FILE__)."\",
			supplied: \"mp3\",
			wmode: \"window\",
			useStateClassSkin: true,
			autoBlur: false,
			smoothPlayBar: true,
			keyEnabled: true
		});
	});
//]]>";
	echo "</script>";
	echo "\r\n<!-- get it at http://www.radioislamindonesia.com -->\r\n\r\n\r\n";
}