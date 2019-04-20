<?php

/**
 * Class td_single_date
 */

class tdb_header_categories extends td_block {

    public function get_custom_css() {
        // $unique_block_class - the unique class that is on the block. use this to target the specific instance via css
        $unique_block_class = $this->block_uid . '_rand';

        $compiled_css = '';

        $raw_css =
            "<style>
                
                /* @inline */
                .$unique_block_class {
                    display: inline-block;
                }
                /* @float_right */
                .$unique_block_class {
                    float: right;
                }
                /* @align_horiz_center */
                .$unique_block_class .tdb-block-inner {
                    justify-content: center;
                }
                /* @align_horiz_right */
                .$unique_block_class .tdb-block-inner {
                    justify-content: flex-end;
                }
                
                /* @icon_size */
                .$unique_block_class .tdb-head-cat-toggle {
                    font-size: @icon_size;
                }
                /* @icon_padding */
                .$unique_block_class .tdb-head-cat-toggle {
                    width: @icon_padding;
					height: @icon_padding;
					line-height:  @icon_padding;
                }
                
                
                /* @icon_color */
                .$unique_block_class .tdb-head-cat-toggle {
                    color: @icon_color;
                }
                /* @icon_color_h */
                .$unique_block_class .tdb-head-cat-toggle:hover {
                    color: @icon_color_h;
                }
				
			</style>";


        $td_css_res_compiler = new td_css_res_compiler( $raw_css );
        $td_css_res_compiler->load_settings( __CLASS__ . '::cssMedia', $this->get_all_atts() );

        $compiled_css .= $td_css_res_compiler->compile_css();
        return $compiled_css;
    }

    static function cssMedia( $res_ctx ) {

        // make inline
        $res_ctx->load_settings_raw('inline', $res_ctx->get_shortcode_att('inline'));
        // align to right
        $res_ctx->load_settings_raw('float_right', $res_ctx->get_shortcode_att('float_right'));
        // horizontal align
        $align_horiz = $res_ctx->get_shortcode_att('align_horiz');
        if( $align_horiz == 'content-horiz-center' ) {
            $res_ctx->load_settings_raw('align_horiz_center', 1);
        } else if( $align_horiz == 'content-horiz-right' ) {
            $res_ctx->load_settings_raw('align_horiz_right', 1);
        }



        /*-- ICON -- */
        // icon size
        $icon_size = $res_ctx->get_shortcode_att('icon_size');
        $res_ctx->load_settings_raw('icon_size', $icon_size . 'px');
        // icon padding
        $res_ctx->load_settings_raw('icon_padding', $icon_size * $res_ctx->get_shortcode_att('icon_padding') . 'px');



        /*-- COLORS -- */
        //$res_ctx->load_settings_raw('date_color', $res_ctx->get_shortcode_att('date_color'));



        /*-- FONTS -- */
        //$res_ctx->load_font_settings( 'f_date' );

    }

    /**
     * Disable loop block features. This block does not use a loop and it doesn't need to run a query.
     */
    function __construct() {
        parent::disable_loop_block_features();
    }


    function render( $atts, $content = null ) {
        parent::render( $atts ); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        // toggle icon
        $toggle_icon = $this->get_att('tdicon');
        if( $toggle_icon == '' ) {
            $toggle_icon = 'td-icon-mobile';
        }


        // declare list of arguments
        $args = array(
            'hide_empty' => 0,
            'number' => 8,
            'exclude' => '',
            'include' => ''
        );

        // ids of categories to exclude
        $args['exclude'] = $this->get_att('exclude');
        // ids of categories to include
        $args['include']  = $this->get_att('include');
        // limit categories
        $limit = $this->get_att('limit');
        if( $limit != '' ) {
            $args['number']  = $this->get_att('limit');
        }

        // get list of categories
        $categories = get_categories($args);


        $buffy = ''; //output buffer

        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';

            //get the block css
            $buffy .= $this->get_block_css();

            //get the js for this block
            $buffy .= $this->get_block_js();


            $buffy .= '<div class="tdb-block-inner td-fix-index">';

                $buffy .= '<i class="tdb-head-cat-toggle ' . $toggle_icon . '"></i>';

                $buffy .= '<div class="tdb-head-cat-list">';
                    foreach ( $categories as $category ) {
                        $cat_bg_img = td_util::get_category_option( $category->term_id, 'tdc_image' );
                        $cat_bg_img_html = '';
                        if( $cat_bg_img != '' ) {
                            $cat_bg_img_html = ' style="background-image: url(' . $cat_bg_img . '"';
                        }

                        $buffy .= '<div class="tdb-head-cat-item"><a href="' . get_category_link($category->term_id) .'"' . $cat_bg_img_html . '>' . $category->name . '</a></div>';
                    }
                $buffy .= '</ul>';

            $buffy .= '</div>';

        $buffy .= '</div> <!-- ./block -->';

        return $buffy;
    }

}