<?php
/**
 * Customizer Slider Control.
 * 
 * @package Storeflex
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'StoreFlex_Control_Slider' ) ) :

    /**
     * Slider control
     *
     * @since 1.0.0
     */
    class StoreFlex_Control_Slider extends WP_Customize_Control {

        /**
         * The control type.
         *
         * @access public
         * @var string
         * @since 1.0.0
         */
        public $type = 'mt-slider';

        /**
         * The control version.
         *
         * @static
         * @access public
         * @var string
         * @since 1.0.0
         */
        public static $control_version = '1.0.0';

         public function enqueue() {            
            wp_enqueue_style( 'storeflex-slider-style', get_template_directory_uri() . '/inc/customizer/custom-controls/slider/slider.css', null );
            wp_enqueue_script( 'storeflex-slider-script', get_template_directory_uri() . '/inc/customizer/custom-controls/slider/slider.js', array( 'jquery' ), false, true );
        }

        /**
         * Renders the control wrapper and calls $this->render_content() for the internals.
         *
         * @see WP_Customize_Control::render()
         */
        protected function render() {
            $id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
            $class = 'customize-control has-switchers customize-control-' . $this->type;
        ?>
            <li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
                <?php $this->render_content(); ?>
            </li>
        <?php
        }

        /**
         * Refresh the parameters passed to the JavaScript via JSON.
         *
         * @see WP_Customize_Control::to_json()
         */
        public function to_json() {
            parent::to_json();

            $this->json['id']       = $this->id;

            $this->json['inputAttrs'] = '';
            foreach ( $this->input_attrs as $attr => $value ) {
                $this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
                if ( $attr == 'unit' ) {
                    $this->json['unit']          =  $value;
                }
            }

            $this->json['desktop'] = array();
            $this->json['tablet']  = array();
            $this->json['mobile']  = array();

            foreach ( $this->settings as $setting_key => $setting ) {
                $this->json[ $setting_key ] = array(
                    'id'        => $setting->id,
                    'default'   => $setting->default,
                    'link'      => $this->get_link( $setting_key ),
                    'value'     => $this->value( $setting_key ),
                );
            }

        }

        /**
         * An Underscore (JS) template for this control's content (but not its container).
         *
         * Class variables for this control class are available in the `data` JS object;
         * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
         *
         * @see WP_Customize_Control::print_template()
         *
         * @access protected
         */
        protected function content_template() {
            ?>
            <# if ( data.label ) { #>
                <span class="customize-control-title">
                    <span>{{{ data.label }}}</span>

                    <ul class="responsive-switchers">
                        <li class="desktop">
                            <button type="button" class="preview-desktop active" data-device="desktop">
                                <i class="dashicons dashicons-desktop"></i>
                            </button>
                        </li>
                        <li class="tablet">
                            <button type="button" class="preview-tablet" data-device="tablet">
                                <i class="dashicons dashicons-tablet"></i>
                            </button>
                        </li>
                        <li class="mobile">
                            <button type="button" class="preview-mobile" data-device="mobile">
                                <i class="dashicons dashicons-smartphone"></i>
                            </button>
                        </li>
                    </ul>

                </span>
            <# } #>

            <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>

            <# if ( data.desktop ) { #>
                <div class="desktop control-wrap active">
                    <div class="mt-slider desktop-slider"></div>
                    <div class="mt-slider-input">
                        <input {{{ data.inputAttrs }}} type="number" class="slider-input desktop-input" value="{{ data.desktop.value }}" {{{ data.desktop.link }}} />
                        <span class="mt-slider-unit">{{{ data.unit }}}</span>
                    </div>
                </div>
            <# } #>

            <# if ( data.tablet ) { #>
                <div class="tablet control-wrap">
                    <div class="mt-slider tablet-slider"></div>
                    <div class="mt-slider-input">
                        <input {{{ data.inputAttrs }}} type="number" class="slider-input tablet-input" value="{{ data.tablet.value }}" {{{ data.tablet.link }}} />
                        <span class="mt-slider-unit">{{{ data.unit }}}</span>
                    </div>
                </div>
            <# } #>

            <# if ( data.mobile ) { #>
                <div class="mobile control-wrap">
                    <div class="mt-slider mobile-slider"></div>
                    <div class="mt-slider-input">
                        <input {{{ data.inputAttrs }}} type="number" class="slider-input mobile-input" value="{{ data.mobile.value }}" {{{ data.mobile.link }}} />
                        <span class="mt-slider-unit">{{{ data.unit }}}</span>
                    </div>
                </div>
            <# } #>

        <?php
        }

    }

endif;