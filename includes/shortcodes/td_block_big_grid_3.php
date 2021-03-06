<?php

/**
 *
 * Class td_block_big_grid_3
 */
class td_block_big_grid_3 extends td_block {

    const POST_LIMIT = 2;

    function render($atts, $content = null){

        // for big grids, extract the td_grid_style
        extract(shortcode_atts(
            array(
                'td_grid_style' => 'td-grid-style-1'
            ), $atts));


        $atts['limit'] = self::POST_LIMIT;

	    parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)


	    $buffy = '';

        $buffy .= '<div class="' . $this->get_block_classes(array($td_grid_style, 'td-hover-1 td-big-grids')) . '" ' . $this->get_block_html_atts() . '>';

            //get the block css
            $buffy .= $this->get_block_css();

            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
                $buffy .= $this->inner($this->td_query->posts, $this->get_att('td_column_number')); //inner content of the block
            $buffy .= '</div>';
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {

        $buffy = '';

        $td_block_layout = new td_block_layout();

        if (!empty($posts)) {

            $td_count_posts = count($posts); // post count number

            if ($td_column_number==1 || $td_column_number==2) {
                $buffy .= '<div class="td-block-missing-settings">';
                $buffy .= '<span>Big grid 3</span>';
                $buffy .= 'Please move this shortcode on a full row in order for it to work.';
                $buffy .= '</div>';
            } else {
                $buffy .= '<div class="td-big-grid-wrapper td-posts-' . $td_count_posts . '">';

                $post_count = 0;

                foreach ($posts as $post) {

                    $td_module_mx4 = new td_module_mx4($post);
                    $buffy .= $td_module_mx4->render($post_count);

                    $post_count++;
                }

                if ($post_count < self::POST_LIMIT) {

                    for ($i = $post_count; $i < self::POST_LIMIT; $i++) {

                        $td_module_mx_empty = new td_module_mx_empty();
                        $buffy .= $td_module_mx_empty->render($i, 'td_module_mx4'); // module used
                    }
                }
                $buffy .= '<div class="clearfix"></div>';
                $buffy .= '</div>'; // close td-big-grid-wrapper
            }
        }

        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}