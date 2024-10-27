<?php

/*
Plugin Name: AdSense on Top
Plugin URI:  http://www.adsenseoptimizer.de/adtop.php
Version:     1.2
Description: Show Adsense Ad on Top, Bottom, right or left Margin of Window. Only works together with the wonderful Adsense-Optimizer Plugin.
Author:      gnarf
Author URI:  http://www.adsenseoptimizer.de
License:     GNU General Public License
*/


 if (!class_exists("adtop")) { class adtop { var $adtop_version="1.1"; var $opts; function adtop() { $this->getOpts(); } function getOpts() { if (isset($this->opts) AND !empty($this->opts)) {return;} $this->opts=get_option("adsenseontop"); if (!isset($this->opts['vermar']) OR $this->opts['vermar']=="") $this->opts['vermar']="0"; if (!isset($this->opts['hormar']) OR $this->opts['hormar']=="") $this->opts['hormar']="0"; if (!empty($this->opts)) {return;} $this->opts=Array ( 'type' => 1, 'pos' => 'Top', 'bg' => 'trans', 'hormar' => 20, 'vermar' => 5 ) ; } function sanitize_entries($options){ return $options; } function admin_menu() { if (isset($_POST["adtop_submit"])) { $this->opts=$this->sanitize_entries($_POST['adtop'], $sizes); update_option('adsenseontop',$this->opts); echo '<div id="message" class="updated fade"><p><strong>Options Updated!</strong></p></div>'; } ?>
	<div class="wrap">

	<?php
 adopt_installed(true); ?>


    <h2>Adsense on Top V <?php echo $this->adtop_version; ?></h2>

    <p>For further Information visit the <a href="http://www.adsenseoptimizer.de/adtop.php">Plugin Site</a></p>


    <form name="mainform" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

	<h2>Settings</h2>
		<table><tr><td>
		
		Visual Ad type: </td><td>
		<select name="adtop[type]" size="1">
		   <option value="1" <?php if($this->opts['type']=="1") echo(" selected"); ?>>1</option>
		   <option value="2" <?php if($this->opts['type']=="2") echo(" selected"); ?>>2</option>
		   <option value="3" <?php if($this->opts['type']=="3") echo(" selected"); ?>>3</option>
		   <option value="4" <?php if($this->opts['type']=="4") echo(" selected"); ?>>4</option>
		   <option value="5" <?php if($this->opts['type']=="5") echo(" selected"); ?>>5</option>
		   <option value="6" <?php if($this->opts['type']=="6") echo(" selected"); ?>>6</option>
		   <option value="7" <?php if($this->opts['type']=="7") echo(" selected"); ?>>7</option>
		   <option value="8" <?php if($this->opts['type']=="8") echo(" selected"); ?>>8</option>
		</select>
		</td><td style="font-size:85%">(settings from Adsense Optimizer are used)</td></tr>
		<tr><td>
		position:</td><td>
		<select name="adtop[pos]" size="1">
			<option<?php if($this->opts['pos']=="Top") echo(" selected"); ?>>Top</option>
			<option<?php if($this->opts['pos']=="Right") echo(" selected"); ?>>Right</option>
			<option<?php if($this->opts['pos']=="Left") echo(" selected"); ?>>Left</option>
			<option<?php if($this->opts['pos']=="Bottom") echo(" selected"); ?>>Bottom</option>
    	</select>
		</td></tr>
		<tr><td>
		background:</td><td>
		<select name="adtop[bg]" size="1">
			<option<?php if($this->opts['bg']=="trans") echo(" selected"); ?> value="trans">transparent</option>
			<option<?php if($this->opts['bg']=="ad") echo(" selected"); ?> value="ad">Background color from Ad</option>
     	</select>
		</td><td style="font-size:85%">(Only used for Top and Bottom Ads)</td></tr>
		<tr><td>horizontal margin:</td><td><input name="adtop[hormar]" type="text" value="<?php echo($this->opts['hormar']);?>" size="5">px.</td><td style="font-size:85%">(Top and Bottom Ads will be centered !)</td></tr>
		<tr><td>vertical margin:</td><td><input name="adtop[vermar]" type="text"  value="<?php echo($this->opts['vermar']);?>" size="5">px.</td><td style="font-size:85%">(ignored for Bottom Ads !)</td></tr>
		
		</table>

    <div class="submit">
        <input type="submit" name="adtop_submit" value="<?php _e('Update options'); ?> &raquo;" />
    </div>
    </form>

	</div>

<?php
 } function add_js() { echo ('<div id="adtop">'); adopt($this->opts['type']); echo ('</div>'); } function add_style(){ global $adopt; $ao_opts=$adopt->opts; $bg=$ao_opts['col_bg'][$this->opts['type']]; echo ('<style type="text/css">
				#adtop {
					display:block;'); if ($this->opts['bg'] == "trans") echo ('background:transparent;'); else echo ('background:#'.$bg.';'); if ($this->opts['pos'] == "Top") echo ('position:absolute; width:100%; top:'.$this->opts['vermar'].'px; left:0; right:0; margin:0px auto; text-align:center;'); if ($this->opts['pos'] == "Bottom") echo ('margin:0px auto; text-align:center;'); if ($this->opts['pos'] == "Right") echo ('position:absolute; top:'.$this->opts['vermar'].'px; right:'.$this->opts['hormar'].'px;'); if ($this->opts['pos'] == "Left") echo ('position:absolute; top:'.$this->opts['vermar'].'px; left:'.$this->opts['hormar'].'px;'); echo ('		
					}
				</style>
		'); } function add_scripts() { wp_enqueue_script("jquery"); } } } if (!function_exists('adopt_installed')) { function adopt_installed($po=false) { global $adopt; $adopt_version=$adopt->adopt_version; if (!$adopt_version or $adopt_version=="") { if ($po) echo ('<h2 style="color:red">Attention ! You have to install the <a href="http://www.adsenseoptimizer.de">Adsense Optimizer Plugin</a> to use Adsense on Top !!!</h2>'); return false; } if (substr($adopt_version,0,1) < "2") { if ($po) echo ('<h2 style="color:red">Attention ! You have to install a newer Version of <a href="http://www.adsenseoptimizer.de">Adsense Optimizer Plugin</a> to use Adsense on Top !!!</h2>'); return false; } return true; } } $adtop = new adtop(); function adtop_menu() { global $adtop; if (function_exists('add_options_page')) { add_options_page('Adsense on Top', 'Adsense on Top', 'administrator', __FILE__, array(&$adtop, 'admin_menu')); } } add_action('admin_menu', 'adtop_menu'); add_action('wp_footer', array($adtop, 'add_js')); add_action('wp_head', array($adtop, 'add_style')); add_action('wp_enqueue_scripts', array($adtop, 'add_scripts')); ?>
