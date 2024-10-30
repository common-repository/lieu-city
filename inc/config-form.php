<?php
/**
 * @package LieuCityPlugin
 */

namespace LieuCityPlugin;

class lieu_Configform {
    public const PLUGIN_PAGE_NAME = "lieucity_plugin";

    function __construct() {}
   
    function lieu_shortcode( $atts, $content) {
        $data = explode(';',$content);
        
        if (!$this->check_shortcode_data($data)) {
            return 'shortcode non valido';
        }
       
        $exhibition_id=$data[0];
        $iframe_height=$data[1];
        $iframe_widht=$data[2];    
        return '<div class="alignleft" style="margin-block-start: 0;margin-block-end: 0; width: 100%; height:100vh"><iframe src="https://vr.lieu.city/vr_anon.php?exhibition=' . $exhibition_id . '" 
            style="top:0; left:0; bottom:0; right:0; width:' . $iframe_widht . '; height:' . $iframe_height . '; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"></iframe></div>';
   }

    function check_shortcode_data($data): bool
    {
        if (count($data)!=3) {
            return false;
        }

        if (!is_numeric($data[0])) {
            return false;
        }

        if (!str_contains($data[1],'%') && !str_contains($data[1],'px')) {
            return false;
        }

        if (!str_contains($data[2],'%') && !str_contains($data[2],'px')) {
            return false;
        }

        return true;     
    }
   
    function register(): void
    {    //_pt:serve per aggiungere azioni con trigger evitando di usare il costruttore
        add_action('admin_menu',array($this,'add_admin_pages') );
        
        add_action( 'admin_enqueue_scripts',array($this,'enqueue') );
        add_shortcode( 'lieucity', array($this,'lieu_shortcode') );
    }

    function check_plugin_page(): bool
    {
        return isset($_REQUEST["page"]) && $_REQUEST["page"] === Self::PLUGIN_PAGE_NAME;
    }
   
    function enqueue(): void
    {
        if (!$this->check_plugin_page()) {
            return;
        }

        $lieu_apikey= $this->read_api_key();
        //todo check_token_validity($lieu_apikey);
       
        if (!$lieu_apikey) {
            wp_enqueue_script( 'login', plugins_url( ('/../js/login.js?'. uniqid()), __FILE__ ) );
            wp_enqueue_style ( 'lieu-login', plugins_url( ('/../css/login.css?'. uniqid()), __FILE__ )); 
        } else {

            wp_enqueue_script( 'shufflerjs', plugins_url( ('/../node_modules/shufflejs/dist/shuffle.min.js?' . uniqid()), __FILE__ ) );

            wp_enqueue_script( 'jquery-nice-select', plugins_url( ('/../node_modules/jquery-nice-select/js/jquery.nice-select.min.js?' . uniqid()), __FILE__ ) );
            wp_enqueue_style ( 'jquery-nice-select', plugins_url( ('/../node_modules/jquery-nice-select/css/nice-select.css?'. uniqid()), __FILE__ )); 

            wp_enqueue_script( 'exhibition-list', plugins_url( ('/../js/exhibition-list.js?' . uniqid()), __FILE__ ) );
            wp_localize_script('exhibition-list', 'lieu_options', [ 'token' => $lieu_apikey["token"] ]);

            wp_enqueue_style ( 'lieu-exhibition-css', plugins_url( ('/../css/exhibition-list.css?'. uniqid()), __FILE__ )); 
        }

        wp_enqueue_script( 'bootstrap', plugins_url( ('/../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js?' . uniqid()), __FILE__ ) );
        wp_enqueue_style ( 'bootstrap', plugins_url( ('/../node_modules/bootstrap/dist/css/bootstrap.min.css?'. uniqid()), __FILE__ )); 
        wp_enqueue_style ( 'font-awesome', plugins_url( ('/../node_modules/@fortawesome/fontawesome-free/css/all.min.css?'. uniqid()), __FILE__ )); 

        wp_enqueue_style ( 'lieu-buttons', plugins_url( ('/../css/buttons.css?'. uniqid()), __FILE__ )); 
        wp_enqueue_style ( 'lieu-checkbox-radio', plugins_url( ('/../css/checkbox-radio.css?'. uniqid()), __FILE__ )); 
        wp_enqueue_style ( 'lieu-common', plugins_url( ('/../css/common.css?'. uniqid()), __FILE__ )); 
    }


    function add_admin_pages(): void
    {
        add_menu_page( 
            'Lieu-city ',
            'Lieucity', 
            'manage_options', 
            Self::PLUGIN_PAGE_NAME, 
            [ $this,'admin_index' ], 
            plugins_url(('/../assets/svg/vr_icon.png'), __FILE__), 
            110 
        );
    }

    function admin_index(): void
    {
        $this->read_api_key() === null ? $this->handle_login_page() : $this->handle_exhibitions_page();
    }

    function handle_exhibitions_page(): void
    {
        if (isset($_POST["lieu_logout_button"])) {
            $this->delete_token();
            $this->render_reload();
        } else {
            $this->render_exhibitions_page();
        }
    }

    function handle_login_page(): void
    {
        if (isset($_POST["lieu_login_button"]) && $this->create_token()) {
            $this->render_reload();
        } else {
            $this->render_login_page();
        }
    }

    function create_token(): bool 
    {
        $p = sanitize_text_field($_POST['lieu_password']);
        $m = sanitize_email($_POST['lieu_email']);   
        
        $args = [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode( $m . ':' . $p ),
                'Origin' => get_site_url("")
            ]
        ];
        
        $url='https://api.lieu.city/v1/login/wordpress/authorizations';        
        $response =wp_remote_post( $url, $args );
        $body= wp_remote_retrieve_body( $response );
        $json= json_decode(json_encode($body),true);
        $response_code = wp_remote_retrieve_response_code( $response );
        
        if ($response_code==200) {
            add_option( "lieucity_login_info", $json);
            return true;
        } else {
            return false;
        }
    }

    function render_reload(): void
    {
        echo '<script type="text/javascript">','document.location.reload(true);','</script>';
    }

    function render_login_page(): void
    {
        require_once plugin_dir_path(__FILE__) . '../pages/login.php';
    }

    function render_exhibitions_page(): void
    {
        require_once plugin_dir_path(__FILE__) . '../pages/exhibition-list.php';
    }

    function delete_token(): void
    {
        delete_option( "lieucity_login_info" );
    }
   
    function check_token_validity($lieu_apikey) {}

    function read_api_key(): ?array 
    {
        $apiKey = get_option("lieucity_login_info");
        return $apiKey === false ? null : json_decode($apiKey, true);
    }
}