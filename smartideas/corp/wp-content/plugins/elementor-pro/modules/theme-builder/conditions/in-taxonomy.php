<?php
namespace ElementorPro\Modules\ThemeBuilder\Conditions;

use ElementorPro\Modules\QueryControl\Module as QueryModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class In_Taxonomy extends Condition_Base {

	public static function get_type() {
		return 'singular';
	}
	/**
	 * @var \WP_Taxonomy
	 */
	private $taxonomy;

	public function __construct( $data ) {
		parent::__construct();

		$this->taxonomy = $data['object'];
	}

	public function get_name() {
		return 'in_' . $this->taxonomy->name;
	}

	public function get_label() {
		/* translators: %s: Taxonomy Label */
		return sprintf( __( 'In %s', 'elementor-pro' ), $this->taxonomy->labels->singular_name );
	}

	public function check( $args ) {
		return has_term( (int) $args['id'], $this->taxonomy->name );
	}

	protected function _register_controls() {
		$this->add_control(
			'taxonomy',
			[
				'section' => 'settings',
				'type' => QueryModule::QUERY_CONTROL_ID,
				'multiple' => false,
				'filter_type' => 'taxonomy',
				'object_type' => $this->taxonomy->name,
			]
		);
	}
}
