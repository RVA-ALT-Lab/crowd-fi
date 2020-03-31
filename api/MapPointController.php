<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


class MapPointController {
  // Instance of AWS client used by this particular controller
  public function __construct() {
    $this->namespace = '/crowd-fi/v1';
    $this->resource_endpoint = 'map-point';
  }

  public function init() {
    add_action('rest_api_init', array($this, 'register_routes'));
  }

  public function register_routes() {
    register_rest_route($this->namespace, '/' . $this->resource_endpoint, array(
      'methods' => 'GET',
      'callback' => array($this, 'get_items')
    ));

    register_rest_route($this->namespace, '/' . $this->resource_endpoint . '/(?P<id>[a-zA-Z0-9._-]+)', array(
      'methods' => 'GET',
      'callback' => array($this, 'get_item'),
      'args' => array(
        'id' => array(
          'required' => true
        )
      )
    ));

    register_rest_route($this->namespace, '/' . $this->resource_endpoint, array(
      'methods' => 'POST',
      'permission_callback' => array($this, 'check_can_post'),
      'callback' => array($this, 'create_item')
    ));
  }

  public function get_items (WP_REST_Request $request) {
    try{
      $query = new WP_Query([
        'post_type' => 'map-point',
        'posts_per_page' => -1,
        'post_status' => 'publish'
      ]);

      $query_params = $request->get_query_params();
      $geolocation_query = false;
      if ($query_params['latitude'] && $query_params['longitude']) {
        $geolocation_query = true;
        $user_position = [
          'latitude' => floatval($query_params['latitude']),
          'longitude' => floatval($query_params['longitude'])
        ];
      }

      if ($query->have_posts()) {
        $posts = $query->posts;
        $map_points = [];
        foreach($posts as $post ) {

          $map_point = [
            'id' => intval($post->ID),
            'name' => $post->post_title,
            'description' => $post->post_content,
            'formatted_address' => floatval(get_post_meta($post->ID, 'formatted_address', true)),
            'latitude' => floatval(get_post_meta($post->ID, 'latitude', true)),
            'longitude' => floatval(get_post_meta($post->ID, 'longitude', true)),
          ];

          if($geolocation_query) {
            $map_point['distance'] = MapPointController::distance($user_position['latitude'], $user_position['longitude'], $map_point['latitude'], $map_point['longitude'], 'M');
          }

          array_push($map_points, $map_point);

        }

        function compareDistance($a, $b) {
          return $a['distance'] > $b['distance'];
        }
        usort($map_points, 'compareDistance');

        return $map_points;
      } else {
        return [];
      }
    } catch (Exception $exc) {
      return $exc;
    }
  }

  public function get_item (WP_REST_Request $request) {
    try{
      $query = new WP_Query([
        'p' => $request['id'],
        'post_type' => 'map-point'
      ]);

      if ($query->have_posts()) {
        $posts = $query->posts;
        $map_points = [];
        foreach($posts as $post ) {
          $map_point = [
            'name' => $post->title,
            'formatted_address' => floatval(get_post_meta($post->ID, 'formatted_address', true)),
            'latitude' => floatval(get_post_meta($post->ID, 'latitude', true)),
            'longitude' => floatval(get_post_meta($post->ID, 'longitude', true)),
          ];
          array_push($map_points, $map_point);
        }

        return $map_points;
      } else {
        return [];
      }
    } catch (Exception $exc) {
      return $exc;
    }
  }

  public function create_item (WP_REST_Request $request) {
    try {
      $post_body = json_decode($request->get_body(), TRUE);
      $post_id = wp_insert_post([
        'post_type' => 'map-point',
        'post_title' => $post_body['name'],
        'post_status' => 'publish',
        'post_content' => $post_body['description'],
        'meta_input' => [
          'latitude' => $post_body['latitude'],
          'longitude' => $post_body['longitude'],
          'formatted_address' => $post_body['formatted_address'],
        ]
      ]);
      $post_body['id'] = $post_id;
      return $post_body;
    } catch (Exception $exc) {
      return $exc;
    }
  }
  public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
      return 0;
    }
    else {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);

      if ($unit == "K") {
        return ($miles * 1.609344);
      } else if ($unit == "N") {
        return ($miles * 0.8684);
      } else {
        return $miles;
      }
    }
  }

  public function check_can_post() {
    return true;
  }


}