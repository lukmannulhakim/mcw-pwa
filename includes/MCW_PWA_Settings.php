<?php
require_once(MCW_PWA_DIR.'/includes/MCW_PWA_Service_Worker.php');
require_once(MCW_PWA_DIR.'/includes/MCW_PWA_LazyLoad.php');
require_once(MCW_PWA_DIR.'includes/MCW_PWA_Assets.php');

class MCW_PWA_Settings {

    private static $__instance = null;
	/**
	 * Singleton implementation
	 *
	 * @return MCW_PWA_Settings instance
	 */
	public static function instance() {
		if ( ! is_a( self::$__instance, 'MCW_PWA_Settings' ) ) {
			self::$__instance = new MCW_PWA_Settings();
		}

		return self::$__instance;
	}

	protected function __construct() {
        add_action( 'admin_menu', array($this,'addSettingMenu'));
        add_action('admin_init',array($this,'addSettingSections'));
    }

    public function addSettingSections(){
        // Add the section to reading settings so we can add our
        // fields to it
        add_settings_section(
            MCW_SECTION_PERFORMANCE,
            'Performance',
            array($this,'sectionPerformance'),
            MCW_PWA_SETTING_PAGE
        );

        add_settings_section(
            MCW_SECTION_PWA,
            'Progressive Web App (PWA)',
            array($this,'sectionPWA'),
            MCW_PWA_SETTING_PAGE
        );
    }
    public function sectionPerformance() {
        echo '<p>Adjust setting below to boost your site performance:</p>';
    }

    public function sectionPWA() {
        echo '<p>Adjust setting below enhance your site experiences:</p>';
    }

    public function addSettingMenu(){
        add_options_page(
            'Setting for Minimum Configuration PWA', 
            'MCW PWA Settings',
            'manage_options', 
            'mcw_setting_page', 
            array( $this, 'renderSettingPage' )
        );
    }

    public function renderSettingPage(){
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
            
        // add error/update messages
        
        // check if the user have submitted the settings
        // wordpress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
            //add_settings_error( 'mcw_messages', 'mcw_messages', __( 'Settings Saved', 'mcw' ), 'updated' );
            
        }
        ?>
        <div class="wrap">
            <h1>Minimum Configuration WordPress PWA Settings</h1>
            <?php 
                // show error/update messages
                settings_errors( 'mcw_messages' );
            ?>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( MCW_PWA_OPTION);
                do_settings_sections( MCW_PWA_SETTING_PAGE );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }
    
    
}