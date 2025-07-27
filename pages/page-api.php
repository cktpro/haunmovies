<?php

/**
* Template Name: API
*/

header('Content-type: application/json; charset=utf-8');

$url = isset($_GET['url']) ? sanitize_text_field($_GET['url']) : '';

if($url)
{
	$x = parse_url($url);
	$post = get_page_by_path( $x['path'], OBJECT, 'post' );
	$post_id = $post->ID;
	$post_meta = get_post_meta($post_id, '_halim_metabox_options', true );
	$post_meta['halim_poster_url'] = $post_meta['halim_poster_url'] ? home_url($post_meta['halim_poster_url']) : null;
	$post_meta['halim_thumb_url'] = $post_meta['halim_thumb_url'] ? home_url($post_meta['halim_thumb_url']) : null;
	$film_meta = get_post_meta($post_id, '_halimmovies', true);
	$data = json_decode(stripslashes($film_meta), true);

	$post_tags = get_the_tags($post_id);
	foreach ($post_tags as $tags) {
		$list_tags[] = $tags->name;
	}
	$list_tags = implode(', ', $list_tags);

	$directors = get_the_terms($post_id, 'director');
	foreach ($directors as $director) {
		$list_director[] = $director->name;
	}
	$directors = implode(', ', $list_director);

	$actors = get_the_terms($post_id, 'actor');
	foreach ($actors as $actor) {
		$list_actor[] = $actor->name;
	}
	$actors = implode(', ', $list_actor);

	$countries = get_the_terms($post_id, 'country');
	foreach ($countries as $country) {
		$list_country[] = $country->name;
	}
	$countries = implode(', ', $list_country);

	$categories = get_the_terms($post_id, 'category');
	foreach ($categories as $category) {
		$list_category[] = $category->name;
	}
	$categories = implode(', ', $list_category);

	$release = get_the_terms($post_id, 'release');
	foreach ($release as $year) {
		$list_year[] = $year->name;
	}
	$released = implode(', ', $list_year);

	$json_api['data'] = array(
		'post_title' => $post->post_title,
		'post_content' => $post->post_content,
		'post_tags' => $list_tags,
		'actors' => $actors,
		'release' => $released,
		'directors' => $directors,
		'countries' => $countries,
		'category' => $categories,
		'post_meta'  => $post_meta,
		'episode_meta' => $data
	);

	echo json_encode($json_api, JSON_UNESCAPED_UNICODE);
}
