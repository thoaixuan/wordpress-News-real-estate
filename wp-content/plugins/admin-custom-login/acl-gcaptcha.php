<?php
class ACL_gcaptcha_Login_Form {

	/** @type string private key|public key */
	private $public_key, $private_key;

	/** class constructor */
	public function __construct() {
		$g_page = unserialize(get_option('Admin_custome_login_gcaptcha'));
		if(isset($g_page['site_key']) && isset($g_page['secret_key'])){
			$site_key = $g_page['site_key'];
			$secret_key = $g_page['secret_key'];
			$acl_gcaptcha_theme = $g_page['acl_gcaptcha_theme'];
		} else {
			$site_key = '';
			$secret_key = '';
			$acl_gcaptcha_theme ='yes';
		}
   
		$this->public_key  = $site_key;
		$this->private_key = $secret_key;
        $this->acl_gcaptcha_theme = $acl_gcaptcha_theme;

		// adds the captcha to the login form
		add_action( 'login_form', array( $this, 'captcha_display' ) );

		// authenticate the captcha answer
		add_action( 'wp_authenticate_user', array( $this, 'validate_captcha_field' ), 10, 2 );
	}

	/** Output the ACL_gcaptcha form field. */
	public function captcha_display() {
		if($this->acl_gcaptcha_theme=="yes"){
			$acl_gcaptcha_theme="light";
		} else {
			$acl_gcaptcha_theme="dark";
		}
		?>
		<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $this->public_key ?>"></script>
		<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
			<script>
				grecaptcha.ready(function() {
				grecaptcha.execute('<?php echo $this->public_key ; ?>', {action: 'login'}).then(function(token) {
				// pass the token to the backend script for verification
				document.getElementById("g-recaptcha-response").value = token;
				});
				});
			</script>
		<style type="text/css">
			.g-recaptchag-recaptcha{
				margin-bottom:20px;
			}
            .grecaptcha{
            	width: 302px; height: 422px; position: relative;
            }
            .grecaptcha-kry{
            	width: 302px; height: 422px; position: absolute;
            }
             .grecaptcha-kry iframe{
             width: 302px; height:422px; border-style: none;
            }
            .g-re-captcha{
            	width: 300px; height: 60px; border-style: none;
				bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px;
				background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;
            }
            .g-recaptcha-response{
               width: 250px; height: 40px; border: 1px solid #c1c1c1;
					margin: 10px 25px; padding: 0px; resize: none;
            }
		</style>
		<?php
	}
    
	/**
	 * Verify the captcha answer
	 *
	 * @param $user string login username
	 * @param $password string login password
	 *
	 * @return WP_Error|WP_user
	 */
	public static function validate_captcha_field( $user, $password ) {
		if ( isset( $_POST['g-recaptcha-response'] ) || self::captcha_verification() ) {
			$response1=self::captcha_verification();
			if( $response1->success && $response1->score  ){
				if($response1->success!=false && $response1->score < 0.5){
					 //var_dump($response1);
					return new WP_Error( 'empty_captcha', '<strong>ERROR</strong>:You are a robot' );
				}else{
					return $user;
				}
			}else{
				return new WP_Error( 'empty_captcha', '<strong>ERROR</strong>: Please Enter the reCaptcha valid Key' );
			}
		}
		
	}
	
	/**
	 * Send a GET request to verify captcha challenge
	 *
	 * @return bool
	 */
	public static function captcha_verification() {

		$response = isset( $_POST['g-recaptcha-response'] ) ? esc_attr( $_POST['g-recaptcha-response'] ) : '';
		$remote_ip = $_SERVER["REMOTE_ADDR"];

		// make a GET request to the Google reCAPTCHA Server
		$g_page = unserialize(get_option('Admin_custome_login_gcaptcha'));
		if(isset($g_page['site_key']) && isset($g_page['secret_key'])){
			$site_key = $g_page['site_key'];
			$secret_key = $g_page['secret_key'];
		} else {
			$site_key = '';
			$secret_key = '';
		}
		$request = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$response.'');
		// get the request response body
		echo('<script> console.log('.$secret_key.'); </script>');
		$return = json_decode( $request );

		return $return;
	}
}
new ACL_gcaptcha_Login_Form();
?>