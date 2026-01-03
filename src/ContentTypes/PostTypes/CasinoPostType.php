<?php

namespace TestProject\CasinoCards\ContentTypes\PostTypes;

class CasinoPostType
{
    public const POST_TYPE = 'casino';

    public function register(): void
    {
        $labels = [
            'name'          => __('Casinos', 'casino-cards-demo'),
            'singular_name' => __('Casino', 'casino-cards-demo'),
            'add_new_item'  => __('Add New Casino', 'casino-cards-demo'),
            'edit_item'     => __('Edit Casino', 'casino-cards-demo'),
            'view_item'     => __('View Casino', 'casino-cards-demo'),
            'search_items'  => __('Search Casinos', 'casino-cards-demo'),
            'not_found'     => __('No casinos found', 'casino-cards-demo'),
            'menu_name'     => __('Casinos', 'casino-cards-demo'),
        ];

        register_post_type(self::POST_TYPE, [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'casino'],
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
            'menu_icon' => 'dashicons-tickets-alt',
        ]);
    }
}
