<?php

/**
 * Plugin Name: iMW WooCommerce Custom Add to Cart Button
 * Plugin URI: https://imakewebsites.co
 * Author: <a href="https://imakewebsites.co" target="_blank">Alex Zarov</a>
 * Description: Allows toggleable replacement of Woocommerce add to cart button with custom link/text, with custom styling and settings for each product.
 * Version: 0.4.1
 * License: GPLv2
 * License URL: https://imakewebsites.co
 * Text Domain: iMW-woocommerce-custom-add-to-cart-button
 */

// Github Repo: https://github.com/Triex/iMW-woocommerce-custom-add-to-cart-button

if (!defined('ABSPATH')) {
    exit;
}

// This plugin allows us to set a custom button, styles, text and link for each product - even if it has no price.

add_filter('woocommerce_product_data_tabs', 'add_imw_custom_button_tab');
function add_imw_custom_button_tab($tabs)
{
    $tabs['custom_button'] = array(
        'label' => __('Custom Add To Cart', 'woocommerce'),
        'target' => 'imw_custom_button_options',
        'class' => array('show_if_simple', 'show_if_variable'),
    );
    return $tabs;
}

add_action('woocommerce_product_data_panels', 'add_imw_custom_button_tab_options');
function add_imw_custom_button_tab_options()
{
    global $post;
    $custom_button_hook_action = get_post_meta($post->ID, 'imw_custom_button_hook_action', true);
    $custom_button_hook_text = get_post_meta($post->ID, 'imw_custom_button_hook_text', true);
    $custom_button_text = get_post_meta($post->ID, 'imw_custom_button_text', true);
    $custom_button_link = get_post_meta($post->ID, 'imw_custom_button_link', true);
    $custom_button_toggle = get_post_meta($post->ID, 'imw_custom_button_toggle', true);
    $custom_button_toggle_button_class = get_post_meta($post->ID, 'imw_custom_button_toggle_button_class', true);
    $custom_button_custom_classes = get_post_meta($post->ID, 'imw_custom_button_custom_classes', true);
    $custom_button_color = get_post_meta($post->ID, 'imw_custom_button_color', true);
    $custom_button_text_color = get_post_meta($post->ID, 'imw_custom_button_text_color', true);
    $custom_button_text_size = get_post_meta($post->ID, 'imw_custom_button_text_size', true);
    $custom_button_line_height = get_post_meta($post->ID, 'imw_custom_button_line_height', true);
    $custom_button_padding_topbottom = get_post_meta($post->ID, 'imw_custom_button_padding_topbottom', true);
    $custom_button_padding_leftright = get_post_meta($post->ID, 'imw_custom_button_padding_leftright', true);
    $custom_button_open_in_new_tab = get_post_meta($post->ID, 'imw_open_in_new_tab', true);
    $custom_button_hover_color = get_post_meta($post->ID, 'imw_custom_button_hover_color', true);
    $custom_button_text_hover_color = get_post_meta($post->ID, 'imw_custom_button_text_hover_color', true);
    $custom_button_border_radius = get_post_meta($post->ID, 'imw_custom_button_border_radius', true);
    $custom_button_border_color = get_post_meta($post->ID, 'imw_custom_button_border_color', true);
    $custom_button_border_thickness = get_post_meta($post->ID, 'imw_custom_button_border_thickness', true);
    $custom_button_border_hover_color = get_post_meta($post->ID, 'imw_custom_button_border_hover_color', true);
    // $custom_button_icon = get_post_meta($post->ID, 'imw_custom_button_icon', true);
    // $custom_button_icon_toggle = get_post_meta($post->ID, 'imw_custom_button_icon_toggle', true);
    $replace_add_to_cart_toggle = get_post_meta($post->ID, 'imw_replace_add_to_cart_toggle', true);
    $custom_button_archives_toggle = get_option('imw_custom_button_archives_toggle');
    $hide_all_other_buttons_archive_toggle = get_option('imw_hide_all_other_buttons_archive_toggle');

?>
    <div id="imw_custom_button_options" class="panel woocommerce_options_panel">
        <div class="options_group">
            <p>To start: press the `Auto-set Defaults` button below to set the styles to default, then you can customize them and set the `Button Link` etc.</p>
            <?php
            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_text',
                'label' => __('Button Text', 'woocommerce'),
                'placeholder' => 'Get the Book',
                'desc_tip' => 'true',
                'description' => __('Enter the text for the custom button.', 'woocommerce'),
                'value' => $custom_button_text,
            ));
            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_link',
                'label' => __('Button Link', 'woocommerce'),
                'placeholder' => 'https://book.com',
                'desc_tip' => 'true',
                'description' => __('Enter the link for the custom button.', 'woocommerce'),
                'value' => $custom_button_link,
            ));
            woocommerce_wp_checkbox(array(
                'id' => 'imw_open_in_new_tab',
                'label' => __('Open in New Tab', 'woocommerce'),
                'desc_tip' => 'true',
                'description' => __('Check to open link in new tab.', 'woocommerce'),
                'value' => $custom_button_open_in_new_tab,
            ));

            echo '<hr>';

            woocommerce_wp_checkbox(array(
                'id' => 'imw_custom_button_toggle',
                'label' => __('Toggle Custom Button', 'woocommerce'),
                'desc_tip' => 'true',
                'description' => __('Check to enable on this product.', 'woocommerce'),
                'value' => $custom_button_toggle,
            ));
            woocommerce_wp_checkbox(array(
                'id' => 'imw_replace_add_to_cart_toggle',
                'label' => __('Hide Add To Cart Button', 'woocommerce'),
                'desc_tip' => 'true',
                'description' => __('Check to replace the Woocommerce add to cart button with the custom button.', 'woocommerce'),
                'value' => $replace_add_to_cart_toggle,
            ));

            // TODO: should add some form of visual reference.
            // Visual guide for hooks: https://rudrastyh.com/woocommerce/before-and-after-add-to-cart.html#single_product_page
            woocommerce_wp_select(array(
                'id' => 'imw_custom_button_hook_action',
                'label' => __('Custom Button Hook', 'woocommerce'),
                'desc_tip' => 'true',
                'description' => __("Choose the hook you want to use for the custom button. Defaults to `imw_custom_button_action`, which you need to add to your child theme. eg: `do_action('imw_custom_button_action');`. Alternatively enter a custom hook, or choose one of the standard `woocommerce_add_to_cart` hooks below.", "woocommerce"),
                'options' => array(
                    'imw_custom_button_action' => 'imw_custom_button_action',
                    'woocommerce_before_add_to_cart_button' => 'woocommerce_before_add_to_cart_button',
                    'woocommerce_after_add_to_cart_button' => 'woocommerce_after_add_to_cart_button',
                    'woocommerce_after_add_to_cart_quantity' => 'woocommerce_after_add_to_cart_quantity',
                    'woocommerce_before_add_to_cart_quantity' => 'woocommerce_before_add_to_cart_quantity',
                    'woocommerce_before_add_to_cart_form' => 'woocommerce_before_add_to_cart_form',
                    'woocommerce_after_add_to_cart_form' => 'woocommerce_after_add_to_cart_form',
                    'custom_hook_name' => 'custom_hook_name',
                ),
                'value' => $custom_button_hook_action,
            ));

            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_hook_text',
                'label' => __('Custom Hook Name', 'woocommerce'),
                'placeholder' => 'my_custom_hook',
                'desc_tip' => 'true',
                'description' => __('Enter the name of the hook you want to use. eg; `woocommerce_before_add_to_cart_button`', 'woocommerce'),
                'value' => $custom_button_hook_text,
            ));

            echo '<script type="text/javascript">
                jQuery(document).ready(function($) {
                    $(".imw_custom_button_hook_text_field").hide();
                });
                jQuery(document).ready(function($) {
                    $("#imw_custom_button_hook_action").change(function() {
                        if ($(this).val() == "custom_hook_name") {
                            $(".imw_custom_button_hook_text_field").show();
                        } else {
                            $(".imw_custom_button_hook_text_field").hide();
                        }
                    });
                });
            </script>';

            echo '<hr>';

            woocommerce_wp_checkbox(array(
                'id' => 'imw_custom_button_archives_toggle',
                'label' => __('Show on Archives', 'woocommerce'),
                'desc_tip' => 'true',
                'description' => __('Check to show on archive pages, otherwise it will only show the defaults eg; "Add to Cart" / "Read More" etc.', 'woocommerce'),
                'value' => $custom_button_archives_toggle,
            ));

            woocommerce_wp_checkbox(array(
                'id' => 'imw_hide_all_other_buttons_archive_toggle',
                'label' => __('Hide All Other Buttons', 'woocommerce'),
                'desc_tip' => 'true',
                'description' => __('Check to hide all other buttons on archive pages, otherwise it will continue to show the defaults eg; "Add to Cart" / "Read More" etc. Note: this is a global option, so it will update on all products.', 'woocommerce'),
                'value' => $hide_all_other_buttons_archive_toggle,
            ));

            echo '<hr>';

            echo '<p>Note: You must enter all styles (radius optional), or override them by toggling the `button` class - for it to render correctly.</p>';
            woocommerce_wp_checkbox(array(
                'id' => 'imw_custom_button_toggle_button_class',
                'label' => __('Toggle Button Class', 'woocommerce'),
                'description' => __('Check to enable the default theme button styles.', 'woocommerce'),
                'value' => $custom_button_toggle_button_class,
            ));
            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_custom_classes',
                'label' => __('Custom Classes', 'woocommerce'),
                'placeholder' => '',
                'desc_tip' => 'true',
                'description' => __('Enter custom classes for the button. (Unfortunately even if ticked; the preview below will not show Woocommerce page styles)', 'woocommerce'),
                'value' => $custom_button_custom_classes,
            ));

            // // custon button icon
            // woocommerce_wp_text_input(array(
            //     'id' => 'imw_custom_button_icon',
            //     'label' => __('Odrin Icon', 'woocommerce'),
            //     'placeholder' => 'fas fa-book',
            //     'desc_tip' => 'true',
            //     'description' => __('Enter the icon class for the button.', 'woocommerce'),
            //     'value' => $custom_button_icon,
            // ));
            // //js to show the icon preview and icon choices
            // echo '<script>
            // jQuery(document).ready(function($){
            //     // show the icon preview
            //     $("#imw_custom_button_icon").on("keyup", function(){
            //         var icon = $(this).val();
            //         $("#imw_custom_button_icon_preview").html("<i class=\'" + icon + "\'></i>");
            //     });
            //     $("#imw_custom_button_icon").on("click", function(){
            //         $("#imw_custom_button_icon_choices").toggle();
            //     });

            //     $("#imw_custom_button_icon_preview").on("click", function(){
            //         $("#imw_custom_button_icon_choices").toggle();
            //     });
            // });
            // </script>';
            // // add a button to show the icon preview
            // echo '<div style="padding-bottom: 10px; display: block; margin: 0 auto; width: fit-content;">';
            // echo '<span id="imw_custom_button_icon_preview" style="cursor:pointer; text-decoration:underline; color: #2271b1;">Show Icon Preview</span>';
            // echo '</div>';
            // // add the icon choices
            // echo '<div id="imw_custom_button_icon_choices" style="display:none;">';
            // echo '<p>Click on an icon to copy the class name to the input field above.</p>';
            // echo '<div style="display: flex; flex-wrap: wrap; justify-content: space-between;">';
            // echo '<div style="width: 33%; padding: 10px; box-sizing: border-box;">';
            // echo '<i class="icon-book-open" onclick="jQuery(\'#imw_custom_button_icon\').val(\'icon-book-open\');"></i>';
            // echo '</div>';
            // echo '<div style="width: 33%; padding: 10px; box-sizing: border-box;">';
            // echo '<i class="icon-book" onclick="jQuery(\'#imw_custom_button_icon\').val(\'icon-book\');"></i>';
            // echo '</div>';
            // echo '<div style="width: 33%; padding: 10px; box-sizing: border-box;">';
            // echo '<i class="icon-bookmark" onclick="jQuery(\'#imw_custom_button_icon\').val(\'icon-bookmark\');"></i>';
            // echo '</div>';
            // echo '<div style="width: 33%; padding: 10px; box-sizing: border-box;">';
            // echo '<i class="icon-bookmark-empty" onclick="jQuery(\'#imw_custom_button_icon\').val(\'icon-bookmark-empty\');"></i>';
            // echo '</div>';
            // echo '</div>';
            // echo '</div>';

            echo '<hr>';

            echo '<h4 style="margin-left:10px;">Button Styles</h4>';

            echo
            '<div style="padding-bottom: 10px; display: block; margin: 0 auto; width: fit-content;">';
            // button to fill in all fields with their placeholder values
            echo '<span id="imw-custom-button-set-placeholder-defaults" onclick="imwCustomButtonSetPlaceholderDefaults()" style="cursor:pointer; text-decoration:underline; color: #2271b1;">Auto-set Defaults</span>';
            echo '<span class="woocommerce-help-tip" data-tip="This button will fill in the `Button Text`, and all the fields below with their default values."></span>';

            echo '</div>';

            // add the placeholder defaults script
            echo '<script>
                function imwCustomButtonSetPlaceholderDefaults() {
                    jQuery("#imw_custom_button_text").val("Get the Book");
                    jQuery("#imw_custom_button_color").val("#d274e8");
                    jQuery("#imw_custom_button_hover_color").val("#444444");
                    jQuery("#imw_custom_button_text_color").val("#ffffff");
                    jQuery("#imw_custom_button_text_hover_color").val("#ffffff");
                    jQuery("#imw_custom_button_border_color").val("#d274e8");
                    jQuery("#imw_custom_button_border_hover_color").val("#d274e8");
                    jQuery("#imw_custom_button_text_size").val("17px");
                    jQuery("#imw_custom_button_line_height").val("1.424");
                    jQuery("#imw_custom_button_padding_topbottom").val("16px");
                    jQuery("#imw_custom_button_padding_leftright").val("40px");
                    jQuery("#imw_custom_button_border_thickness").val("1px");
                    jQuery(".wp-color-picker").each(function() {
                        jQuery(this).iris("color", jQuery(this).val());
                    });
                    jQuery("#imw_custom_button_toggle_button_class").prop("checked", false);
                    jQuery("#imw_open_in_new_tab").prop("checked", true);
                    jQuery("#imw_custom_button_hook_action").val("imw_custom_button_action");

                    // now update the preview button styles:
                    jQuery(".imw-custom-button").css("background-color", jQuery("#imw_custom_button_color").val());
                    jQuery(".imw-custom-button").css("color", jQuery("#imw_custom_button_text_color").val());
                    jQuery(".imw-custom-button").css("font-size", jQuery("#imw_custom_button_text_size").val());
                    jQuery(".imw-custom-button").css("border-radius", jQuery("#imw_custom_button_border_radius").val());
                    jQuery(".imw-custom-button").css("padding", jQuery("#imw_custom_button_padding_topbottom").val() + " " + jQuery("#imw_custom_button_padding_leftright").val());
                    jQuery(".imw-custom-button").css("font-weight", "600");
                    jQuery(".imw-custom-button").css("letter-spacing", "0.05em");
                    jQuery(".imw-custom-button").css("text-transform", "uppercase");
                    jQuery(".imw-custom-button").css("font-family", "Gentium Book Basic");
                    jQuery(".imw-custom-button").css("margin-top", "10px");
                    jQuery(".imw-custom-button").css("margin-left", "10px");
                    jQuery(".imw-custom-button").css("margin-right", "4px");
                    jQuery(".imw-custom-button").css("text-decoration", "none");
                    jQuery(".imw-custom-button").css("font-family", "Gentium Book Basic");
                    jQuery(".imw-custom-button").css("text-transform", "uppercase");
                    jQuery(".imw-custom-button").css("line-height", jQuery("#imw_custom_button_line_height").val());
                    jQuery(".imw-custom-button").css("border", jQuery("#imw_custom_button_border_thickness").val() + " solid " + jQuery("#imw_custom_button_border_color").val());
                    jQuery(".imw-custom-button").css("display", "inline-block");
                    jQuery(".imw-custom-button").css("cursor", "pointer");
                    jQuery(".imw-custom-button").css("transition", "all 0.2s ease-in-out");
                    jQuery(".imw-custom-button").css("text-align", "center");
                    jQuery(".imw-custom-button").css("vertical-align", "middle");
                    jQuery(".imw-custom-button").css("white-space", "nowrap");
                    jQuery(".imw-custom-button").css("border-radius", jQuery("#imw_custom_button_border_radius").val());
                    // update the button text
                    jQuery(".imw-custom-button").html(jQuery("#imw_custom_button_text").val());
                    // add the hover styles
                    jQuery(".imw-custom-button").hover(function() {
                        jQuery(this).css("background-color", jQuery("#imw_custom_button_hover_color").val());
                        jQuery(this).css("color", jQuery("#imw_custom_button_text_hover_color").val());
                        jQuery(this).css("border", jQuery("#imw_custom_button_border_thickness").val() + " solid " + jQuery("#imw_custom_button_border_hover_color").val());
                    }, function() {
                        jQuery(this).css("background-color", jQuery("#imw_custom_button_color").val());
                        jQuery(this).css("color", jQuery("#imw_custom_button_text_color").val());
                        jQuery(this).css("border", jQuery("#imw_custom_button_border_thickness").val() + " solid " + jQuery("#imw_custom_button_border_color").val());
                    });
                }
                function imw_custom_button_admin_preview() {
                  var buttonColor = document.getElementById(
                    "imw_custom_button_color"
                  ).value;
                  var buttonHoverColor = document.getElementById(
                    "imw_custom_button_hover_color"
                  ).value;
                  var buttonTextColor = document.getElementById(
                    "imw_custom_button_text_color"
                  ).value;
                  var buttonTextHoverColor = document.getElementById(
                    "imw_custom_button_text_hover_color"
                  ).value;
                  var buttonBorderColor = document.getElementById(
                    "imw_custom_button_border_color"
                  ).value;
                  var buttonBorderHoverColor = document.getElementById(
                    "imw_custom_button_border_hover_color"
                  ).value;
                  var buttonTextSize = document.getElementById(
                    "imw_custom_button_text_size"
                  ).value;
                  var buttonLineHeight = document.getElementById(
                    "imw_custom_button_line_height"
                  ).value;
                  var buttonPaddingTopBottom = document.getElementById(
                    "imw_custom_button_padding_topbottom"
                  ).value;
                  var buttonPaddingLeftRight = document.getElementById(
                    "imw_custom_button_padding_leftright"
                  ).value;
                  var buttonBorderRadius = document.getElementById(
                    "imw_custom_button_border_radius"
                  ).value;
                  var buttonBorderThickness = document.getElementById(
                    "imw_custom_button_border_thickness"
                  ).value;
                  var buttonPreview = document.getElementById(
                    "imw-custom-button-preview"
                  );
                  buttonPreview.style.backgroundColor = buttonColor;
                  buttonPreview.style.color = buttonTextColor;
                  buttonPreview.style.fontSize = buttonTextSize;
                  buttonPreview.style.borderRadius = buttonBorderRadius;
                  buttonPreview.style.padding =
                    buttonPaddingTopBottom + " " + buttonPaddingLeftRight;
                  buttonPreview.style.fontWeight = "600";
                  buttonPreview.style.letterSpacing = "0.05em";
                  buttonPreview.style.textTransform = "uppercase";
                  buttonPreview.style.fontFamily = "Gentium Book Basic";
                  buttonPreview.style.border =
                    buttonBorderThickness + " solid " + buttonBorderColor;
                  buttonPreview.style.lineHeight = buttonLineHeight;
                  buttonPreview.onmouseover = function () {
                    buttonPreview.style.backgroundColor = buttonHoverColor;
                    buttonPreview.style.color = buttonTextHoverColor;
                    buttonPreview.style.border =
                      buttonBorderThickness +
                      " solid " +
                      buttonBorderHoverColor;
                  };
                  buttonPreview.onmouseout = function () {
                    buttonPreview.style.backgroundColor = buttonColor;
                    buttonPreview.style.color = buttonTextColor;
                    buttonPreview.style.border =
                      buttonBorderThickness + " solid " + buttonBorderColor;
                  };
                }
            </script>';

            $buttoncolorfield = array(
                'id' => 'imw_custom_button_color',
                'label' => __('Button Color', 'woocommerce'),
                'placeholder' => '#d274e8',
                'desc_tip' => 'true',
                'description' => __('Enter the color for the custom button.', 'woocommerce'),
                'value' => $custom_button_color,
            );
            woocommerce_wp_text_input($buttoncolorfield);

            $buttonhovercolorfield = array(
                'id' => 'imw_custom_button_hover_color',
                'label' => __('Button Hover Color', 'woocommerce'),
                'placeholder' => '#444444',
                'desc_tip' => 'true',
                'description' => __('Enter the color for the custom button on hover.', 'woocommerce'),
                'value' => $custom_button_hover_color,
            );
            woocommerce_wp_text_input($buttonhovercolorfield);

            $buttontextcolorfield = array(
                'id' => 'imw_custom_button_text_color',
                'label' => __('Button Text Color', 'woocommerce'),
                'placeholder' => '#ffffff',
                'desc_tip' => 'true',
                'description' => __('Enter the color for the custom button text.', 'woocommerce'),
                'value' => $custom_button_text_color,
            );
            woocommerce_wp_text_input($buttontextcolorfield);

            $buttontexthovercolorfield = array(
                'id' => 'imw_custom_button_text_hover_color',
                'label' => __('Button Text Hover Color', 'woocommerce'),
                'placeholder' => '#ffffff',
                'desc_tip' => 'true',
                'description' => __('Enter the color for the custom button text on hover.', 'woocommerce'),
                'value' => $custom_button_text_hover_color,
            );
            woocommerce_wp_text_input($buttontexthovercolorfield);

            $buttonbordercolor = array(
                'id' => 'imw_custom_button_border_color',
                'label' => __('Button Border Color', 'woocommerce'),
                'placeholder' => '#d274e8',
                'desc_tip' => 'true',
                'description' => __('Enter the color for the custom button border.', 'woocommerce'),
                'value' => $custom_button_border_color,
            );
            woocommerce_wp_text_input($buttonbordercolor);

            $buttonborderhovercolor = array(
                'id' => 'imw_custom_button_border_hover_color',
                'label' => __('Button Border Hover Color', 'woocommerce'),
                'placeholder' => '#d274e8',
                'desc_tip' => 'true',
                'description' => __('Enter the color for the custom button border on hover.', 'woocommerce'),
                'value' => $custom_button_border_hover_color,
            );
            woocommerce_wp_text_input($buttonborderhovercolor);

            ?>
            <script>
                jQuery(document).ready(function($) {
                    $('#<?php echo $buttoncolorfield['id']; ?>').wpColorPicker();
                    $('#<?php echo $buttonhovercolorfield['id']; ?>').wpColorPicker();
                    $('#<?php echo $buttontextcolorfield['id']; ?>').wpColorPicker();
                    $('#<?php echo $buttontexthovercolorfield['id']; ?>').wpColorPicker();
                    $('#<?php echo $buttonbordercolor['id']; ?>').wpColorPicker();
                    $('#<?php echo $buttonborderhovercolor['id']; ?>').wpColorPicker();

                });
            </script>
            <?php
            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_text_size',
                'label' => __('Button Text Size', 'woocommerce'),
                'placeholder' => '16px',
                'desc_tip' => 'true',
                'description' => __('Enter the size for the custom button text.', 'woocommerce'),
                'value' => $custom_button_text_size,
            ));

            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_line_height',
                'label' => __('Button Line Height', 'woocommerce'),
                'placeholder' => '1.424',
                'desc_tip' => 'true',
                'description' => __('Enter the line height for the custom button text.', 'woocommerce'),
                'value' => $custom_button_line_height,
            ));
            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_padding_topbottom',
                'label' => __('Button Padding (top/bottom)', 'woocommerce'),
                'placeholder' => '16px',
                'desc_tip' => 'true',
                'description' => __('Enter the padding for the custom button (top/bottom).', 'woocommerce'),
                'value' => $custom_button_padding_topbottom,
            ));
            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_padding_leftright',
                'label' => __('Button Padding (left/right)', 'woocommerce'),
                'placeholder' => '40px',
                'desc_tip' => 'true',
                'description' => __('Enter the padding for the custom button (left/right).', 'woocommerce'),
                'value' => $custom_button_padding_leftright,
            ));
            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_border_radius',
                'label' => __('Button Border Radius', 'woocommerce'),
                'placeholder' => '0px',
                'desc_tip' => 'true',
                'description' => __('Enter the border radius for the custom button.', 'woocommerce'),
                'value' => $custom_button_border_radius,
            ));

            woocommerce_wp_text_input(array(
                'id' => 'imw_custom_button_border_thickness',
                'label' => __('Button Border Thickness', 'woocommerce'),
                'placeholder' => '1px',
                'desc_tip' => 'true',
                'description' => __('Enter the thickness for the custom button border.', 'woocommerce'),
                'value' => $custom_button_border_thickness,
            ));

            echo '<hr>';
            // preview
            echo
            '<h3 id="imw_update_preview_button" onclick="imw_custom_button_admin_preview()" style="margin-left: 10px; margin-top: 10px; margin-bottom: 10px; padding: 10px; background-color: #f1f1f1; border: 1px solid #e1e1e1; border-radius: 3px; cursor: pointer;">Click To Update Preview</h3>';
            echo '<a href="' . $custom_button_link . '" id="imw-custom-button-preview" class="imw-custom-button" style="background-color: ' . $custom_button_color . '; color: ' . $custom_button_text_color . '; font-size: ' . $custom_button_text_size . '; border-radius: ' . $custom_button_border_radius . '; padding: ' . $custom_button_padding_topbottom . ' ' . $custom_button_padding_leftright . '; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; font-family: Gentium Book Basic; margin-top: 10px; margin-left: 10px; margin-right: 4px; text-decoration: none; font-family: Gentium Book Basic; text-transform: uppercase; line-height: ' . $custom_button_line_height . '; border: ' . $custom_button_border_thickness . ' solid ' . $custom_button_border_color . ';" ' . ($custom_button_open_in_new_tab == 'yes' ? 'target="_blank"' : '') . ' onmouseover="this.style.backgroundColor=\'' . $custom_button_hover_color . '\'; this.style.color=\'' . $custom_button_text_hover_color . '\'; this.style.borderColor=\'' . $custom_button_border_hover_color . '\';" onmouseout="this.style.backgroundColor=\'' . $custom_button_color . '\'; this.style.color=\'' . $custom_button_text_color . '\'; this.style.borderColor=\'' . $custom_button_border_color . '\';">' . $custom_button_text . '</a>';
            echo '<hr style="margin-top: 25px;">';

            echo '<button type="submit" class="button button-primary button-large" name="save">Save</button>';

            ?>
        </div>
    </div>
<?php
}

add_action('woocommerce_process_product_meta', 'save_imw_custom_button_tab_options');
function save_imw_custom_button_tab_options($post_id)
{
    $custom_button_hook_action = $_POST['imw_custom_button_hook_action'];
    $custom_button_hook_text = $_POST['imw_custom_button_hook_text'];
    $custom_button_text = $_POST['imw_custom_button_text'];
    $custom_button_link = $_POST['imw_custom_button_link'];
    $custom_button_toggle = $_POST['imw_custom_button_toggle'];
    $custom_button_toggle_button_class = $_POST['imw_custom_button_toggle_button_class'];
    $custom_button_custom_classes = $_POST['imw_custom_button_custom_classes'];
    $custom_button_color = $_POST['imw_custom_button_color'];
    $custom_button_text_color = $_POST['imw_custom_button_text_color'];
    $custom_button_text_size = $_POST['imw_custom_button_text_size'];
    $custom_button_line_height = $_POST['imw_custom_button_line_height'];
    $custom_button_padding_topbottom = $_POST['imw_custom_button_padding_topbottom'];
    $custom_button_padding_leftright = $_POST['imw_custom_button_padding_leftright'];
    $custom_button_open_in_new_tab = $_POST['imw_open_in_new_tab'];
    $custom_button_hover_color = $_POST['imw_custom_button_hover_color'];
    $custom_button_text_hover_color = $_POST['imw_custom_button_text_hover_color'];
    $custom_button_border_color = $_POST['imw_custom_button_border_color'];
    $custom_button_border_hover_color = $_POST['imw_custom_button_border_hover_color'];
    $custom_button_border_radius = $_POST['imw_custom_button_border_radius'];
    $custom_button_border_thickness = $_POST['imw_custom_button_border_thickness'];
    $replace_add_to_cart_toggle = $_POST['imw_replace_add_to_cart_toggle'];
    $custom_button_archives_toggle = $_POST['imw_custom_button_archives_toggle'];
    $hide_all_other_buttons_archive_toggle = $_POST['imw_hide_all_other_buttons_archive_toggle'];
    update_post_meta($post_id, 'imw_custom_button_hook_action', $custom_button_hook_action);
    update_post_meta($post_id, 'imw_custom_button_hook_text', $custom_button_hook_text);
    update_post_meta($post_id, 'imw_custom_button_text', $custom_button_text);
    update_post_meta($post_id, 'imw_custom_button_link', $custom_button_link);
    update_post_meta($post_id, 'imw_custom_button_toggle', $custom_button_toggle);
    update_post_meta($post_id, 'imw_custom_button_toggle_button_class', $custom_button_toggle_button_class);
    update_post_meta($post_id, 'imw_custom_button_custom_classes', $custom_button_custom_classes);
    update_post_meta($post_id, 'imw_custom_button_color', $custom_button_color);
    update_post_meta($post_id, 'imw_custom_button_text_color', $custom_button_text_color);
    update_post_meta($post_id, 'imw_custom_button_text_size', $custom_button_text_size);
    update_post_meta($post_id, 'imw_custom_button_line_height', $custom_button_line_height);
    update_post_meta($post_id, 'imw_custom_button_padding_topbottom', $custom_button_padding_topbottom);
    update_post_meta($post_id, 'imw_custom_button_padding_leftright', $custom_button_padding_leftright);
    update_post_meta($post_id, 'imw_open_in_new_tab', $custom_button_open_in_new_tab);
    update_post_meta($post_id, 'imw_custom_button_hover_color', $custom_button_hover_color);
    update_post_meta($post_id, 'imw_custom_button_text_hover_color', $custom_button_text_hover_color);
    update_post_meta($post_id, 'imw_custom_button_border_color', $custom_button_border_color);
    update_post_meta($post_id, 'imw_custom_button_border_hover_color', $custom_button_border_hover_color);
    update_post_meta($post_id, 'imw_custom_button_border_radius', $custom_button_border_radius);
    update_post_meta($post_id, 'imw_custom_button_border_thickness', $custom_button_border_thickness);
    update_post_meta($post_id, 'imw_replace_add_to_cart_toggle', $replace_add_to_cart_toggle);
    update_option('imw_custom_button_archives_toggle', $custom_button_archives_toggle);
    update_option('imw_hide_all_other_buttons_archive_toggle', $hide_all_other_buttons_archive_toggle);
}

//  * @hooked woocommerce_template_single_add_to_cart - 30 priority (make it higher priority here if using standard hooks)

// do actions

add_action('wp', 'imw_custom_button_init');
function imw_custom_button_init()
{
    if (is_woocommerce() && !is_admin() && !is_cart() && !is_checkout()) {
        if (is_product()) {
            global $post;
            $replace_add_to_cart_toggle = get_post_meta($post->ID, 'imw_replace_add_to_cart_toggle', true);
            if ($replace_add_to_cart_toggle == 'yes') {
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            }
            $custom_button_hook_action = get_post_meta($post->ID, 'imw_custom_button_hook_action', true);
            $custom_button_hook_text = get_post_meta($post->ID, 'imw_custom_button_hook_text', true);
            $custom_button_toggle = get_post_meta($post->ID, 'imw_custom_button_toggle', true);

            if ($custom_button_toggle == 'yes') {
                if ($custom_button_hook_action == '' || $custom_button_hook_action == null) {
                    $custom_button_hook_action = 'imw_custom_button_action';
                }
                if ($custom_button_hook_action == 'custom_hook_name') {
                    // TODO: consider allowing different priority settings
                    add_action($custom_button_hook_text, 'imw_custom_button');
                } else {
                    add_action('imw_custom_button_action', 'imw_custom_button');
                }
            }
        }
    }
}

// add_action('woocommerce_before_add_to_cart_button', 'imw_custom_button', 1, 2);

add_action('woocommerce_after_shop_loop_item_title', 'imw_custom_button_archives');
function imw_custom_button_archives()
{
    $custom_button_archives_toggle = get_option('imw_custom_button_archives_toggle');

    hide_all_other_buttons();
    if ($custom_button_archives_toggle == 'yes' && !is_admin()) {
        add_action('woocommerce_after_shop_loop_item', 'imw_custom_button');
    }
}

function hide_all_other_buttons()
{
    if (did_action('hide_all_other_buttons')) {
        return;
    }

    $hide_all_other_buttons_archive_toggle = get_option('imw_hide_all_other_buttons_archive_toggle');
    // if not admin page && hide all other buttons is enabled
    if ($hide_all_other_buttons_archive_toggle == 'yes' && !is_admin()) {
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 10);
    }
}

function imw_custom_button_style()
{
    // if is_admin `get_post_meta($product->get_id()` should return "preview"
    global $product;
    $custom_button_color = get_post_meta($product->get_id(), 'imw_custom_button_color', true);
    $custom_button_text_color = get_post_meta($product->get_id(), 'imw_custom_button_text_color', true);
    $custom_button_text_size = get_post_meta($product->get_id(), 'imw_custom_button_text_size', true);
    $custom_button_line_height = get_post_meta($product->get_id(), 'imw_custom_button_line_height', true);
    $custom_button_padding_topbottom = get_post_meta($product->get_id(), 'imw_custom_button_padding_topbottom', true);
    $custom_button_padding_leftright = get_post_meta($product->get_id(), 'imw_custom_button_padding_leftright', true);
    $custom_button_hover_color = get_post_meta($product->get_id(), 'imw_custom_button_hover_color', true);
    $custom_button_text_hover_color = get_post_meta($product->get_id(), 'imw_custom_button_text_hover_color', true);
    $custom_button_border_color = get_post_meta($product->get_id(), 'imw_custom_button_border_color', true);
    $custom_button_border_hover_color = get_post_meta($product->get_id(), 'imw_custom_button_border_hover_color', true);
    $custom_button_border_radius = get_post_meta($product->get_id(), 'imw_custom_button_border_radius', true);
    $custom_button_border_thickness = get_post_meta($product->get_id(), 'imw_custom_button_border_thickness', true);
    $custom_button_style = "
      .imw-custom-button-{$product->get_id()} {
      display: inline-block;
      background-color: $custom_button_color;
      color: $custom_button_text_color;
      font-size: $custom_button_text_size;
      line-height: $custom_button_line_height;
      padding: $custom_button_padding_topbottom $custom_button_padding_leftright;
      border-radius: $custom_button_border_radius;
      border: $custom_button_border_thickness solid $custom_button_border_color;
      text-decoration: none;
      font-family: Gentium Book Basic;
      text-transform: uppercase;
      }
      ul.products .imw-custom-button-{$product->get_id()} {
          display: flex !important;
          align-items: center;
          justify-content: center;
          flex-wrap: wrap;
          width: 100%;
      }
      .imw-custom-button-{$product->get_id()}:hover {
          background-color: $custom_button_hover_color;
          color: $custom_button_text_hover_color;
          border-color: $custom_button_border_hover_color;
      }

      @media only screen and (max-width: 768px) {
          .imw-custom-button-{$product->get_id()} {
              width: 100%;
              margin-bottom: 15px;
          }
      }
      @media only screen and (max-width: 480px) {
          .imw-custom-button-{$product->get_id()} {
              width: calc(100% - 20px);
              margin-left: 10px;
          }
      }
      @media only screen and (max-width: 320px) {
          .imw-custom-button-{$product->get_id()} {
              width: calc(100% - 30px);
              margin-left: 15px;
          }
      }
    ";
    return $custom_button_style;
}

function imw_custom_button()
{
    global $product;
    $custom_button_toggle = get_post_meta($product->get_id(), 'imw_custom_button_toggle', true);
    if ($custom_button_toggle == 'yes') {
        $custom_button_style = imw_custom_button_style();

        wp_register_style('imw-custom-button-style', false);
        wp_enqueue_style('imw-custom-button-style');
        wp_add_inline_style('imw-custom-button-style', $custom_button_style);

        add_action('wp_enqueue_scripts', 'imw_custom_button_style');

        $custom_button_text = get_post_meta($product->get_id(), 'imw_custom_button_text', true);
        $custom_button_link = get_post_meta($product->get_id(), 'imw_custom_button_link', true);
        $custom_button_open_in_new_tab = get_post_meta($product->get_id(), 'imw_open_in_new_tab', true);
        $custom_button_toggle_button_class = get_post_meta($product->get_id(), 'imw_custom_button_toggle_button_class', true);
        $custom_button_custom_classes = get_post_meta($product->get_id(), 'imw_custom_button_custom_classes', true);
        echo '<a href="' . $custom_button_link . '" class="btn imw-custom-button-' . $product->get_id() . ($custom_button_toggle_button_class == 'yes' ? 'button' : '') . ' ' . $custom_button_custom_classes . '" ' . ($custom_button_open_in_new_tab == 'yes' ? 'target="_blank"' : '') . '>' . $custom_button_text . '</a>';

        // if ($replace_add_to_cart_toggle == 'yes') {
        //     echo '<style>.single_add_to_cart_button {display: none;}</style>';
        // // done in single-product/add-to-cart/simple.php
        // }
    }
}
