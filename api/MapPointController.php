<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


class MapPointController {
  // Instance of AWS client used by this particular controller
  public function __construct($resource_endpoint) {
    $this->namespace = '/crowd-fi/v1';
    $this->resource_endpoint = $resource_endpoint;
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

    register_rest_route($this->namespace, '/' . $this->resource, array(
      'methods' => 'POST',
      // 'permission_callback' => array($this, 'check_is_admin'),
      'callback' => array($this, 'create_item')
    ));
  }

  public function get_items () {
    try{
      $buckets = $this->S3_CLIENT->listBuckets()['Buckets'];
      return $buckets;
    } catch (Exception $exc) {
      return $exc;
    }
  }

  public function get_item (WP_REST_Request $request) {
    try {
      $contents = $this->S3_CLIENT->listObjects(['Bucket' => $request['bucket']])['Contents'];
      return $contents;
    } catch (Exception $exc) {
      return $exc;
    }
  }

  public function create_item (WP_REST_Request $request) {
    try {
      $intentToPut = $request->get_body();
      $intent = $this->LEX_MODEL->putIntent($intentToPut);
      return $intent;
    } catch (Exception $exc) {
      return $exc;
    }
  }

}