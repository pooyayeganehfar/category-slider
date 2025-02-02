<?php
/*
Plugin Name: Category Slider
Description: A responsive slider for WooCommerce product categories with Elementor shortcode.
Version: 1.1
Author: Pooya
*/

// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

// اضافه کردن شرت‌کد برای اسلایدر
function kalakasht_category_slider_shortcode() {
    // استایل‌های مورد نیاز رو داخل تگ <style> اضافه می‌کنیم
    echo '<style>
        .kalakasht-category-slider {
            display: flex;
            overflow-x: auto;
        }
        .slider-item {
            flex: 0 0 auto;
            margin: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .slider-item img {
            width: 100%;
            max-width: 150px;
            border-radius: 10px;
        }
        .slider-item h3 {
            font-size: 11px;
            margin-top: 5px;
        }
        .slider-item a:hover {
            transform: scale(1.05);
        }
    </style>';

    // فراخوانی تابع برای نمایش اسلایدر
    ob_start();
    kalakasht_render_category_slider();
    return ob_get_clean();
}
add_shortcode('kalakasht_category_slider', 'kalakasht_category_slider_shortcode');

// تابع برای دریافت دسته‌بندی‌ها و نمایش اسلایدر
function kalakasht_render_category_slider() {
    // دریافت دسته‌بندی‌های ووکامرس
    $args = array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    );
    $product_categories = get_terms($args);

    if (!empty($product_categories) && !is_wp_error($product_categories)) {
        echo '<div class="kalakasht-category-slider">';
        foreach ($product_categories as $category) {
            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
            $image = wp_get_attachment_url($thumbnail_id);
            $link = get_term_link($category);
            echo '<div class="slider-item">';
            echo '<a href="' . esc_url($link) . '">';
            echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($category->name) . '">';
            echo '<h3>' . esc_html($category->name) . '</h3>';
            echo '</a>';
            echo '</div>';
        }
        echo '</div>';
    }
}
?>