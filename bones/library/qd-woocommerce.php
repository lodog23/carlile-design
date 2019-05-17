<?php

//<-- BEGIN WOOCOMMERCE FUNCTIONS

/*****************************************************************************
THIRD PARTY / CUSTOM / NON-WC THEME COMPATIBILITY

Source: https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
Note: The following codes will make bones compatible with Woocommerce
******************************************************************************/

//First unhook the WooCommerce wrappers:
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

//Then hook in your own functions to display the wrappers your theme requires:
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

//Add the html tags that you want to use in your theme.
//Hint: HTML tags before your the_content(); call
function my_theme_wrapper_start() {
    echo '<div id="content">

            <div id="inner-content" class="wrap cf">

                <main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

                    <article id="post-' . the_ID() . '"' . post_class( 'cf' ) . 'role="article" itemscope itemtype="http://schema.org/BlogPosting">

                        <section class="entry-content cf" itemprop="articleBody">';
}
//Close the html tags above
function my_theme_wrapper_end() {
                    echo '</section>
                    </article>
                </main>
            </div>

        </div>';
}

/***************************************************************************************
DECLARE WOOCOMMERCE SUPPORT
Once you’re happy that your theme fully supports WooCommerce, you should declare it in
the code to hide the, “Your theme does not declare WooCommerce support” message.
Do this by adding the following to your theme support function:
****************************************************************************************/
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
//END WOOCOMMERCE FUNCTIONS -->?>
