<?php
function post_block_render($attributes)
{
    $args = array(
        'posts_per_page' => $attributes['numberOfPosts'],
        'post_status' => 'publish',
        'order' => $attributes['order'],
        'orderby' => $attributes['orderBy'],
    );
    if (isset($attributes['categories'])) {
        $args['category__in'] = array_column($attributes['categories'], 'id');
    }
    $recent_posts = get_posts($args);

    $posts = '<div ' . get_block_wrapper_attributes() . '>';
    $posts .= '<div class="row">';
    foreach ($recent_posts as $post) {
        $title = get_the_title($post);
        $title = $title ? $title : __('(No title)', 'latest-posts');
        $permalink = get_permalink($post);
        $excerpt = get_the_excerpt($post);

        $posts .= '<div class="col-sm-6 col-md-4">';
        $posts .= '<div class="post">';
        if ($attributes["displayFeaturedImage"] && has_post_thumbnail($post)) {
            $posts .= '<div class="post-image">';
            $posts .= '<img src="' . esc_url(get_the_post_thumbnail_url($post, 'medium')) . '" alt="' . esc_attr($title) . '">';
            $posts .= '</div>';
        }
        $posts .= '<div class="post-content">';
        $posts .= '<h3><a href="' . esc_url($permalink) . '">' . $title . '</a></h3>';
        $posts .= '<time datetime="' . esc_attr(get_the_date('c', $post)) . '">' . esc_html(get_the_date('', $post)) . '</time>';

        if (!empty($excerpt)) {
            $posts .= '<p>' . $excerpt . '</p>';
        }

        $posts .= '</div>';
        $posts .= '</div>';
        $posts .= '</div>';
    }
    $posts .= '</div>';
    $posts .= '<a class="btn btn-primary" id="load-more" href="#" data-offset="' . $attributes['numberOfPosts'] . '" data-attributes="' . esc_attr(json_encode($attributes)) . '">' . __('Load more', 'latest-posts') . '</a>';
    $posts .= '</div>';

    return $posts;
}
