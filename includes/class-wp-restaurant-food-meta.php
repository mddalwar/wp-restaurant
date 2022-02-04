<?php 
/**
 * Retrieving the values:
 * Food Quantity = get_post_meta( get_the_ID(), 'wp_restaurant_foodsfood-quantity', true )
 * Regular Price = get_post_meta( get_the_ID(), 'wp_restaurant_foodsregular-price', true )
 * Sell Price = get_post_meta( get_the_ID(), 'wp_restaurant_foodssell-price', true )
 */
class Wp_Restaurant_Food_Meta {
	private $config = '{"title":"Food Options","description":"Choose options for food.","prefix":"wp_restaurant_foods","domain":"food-options","class_name":"food-meta","post-type":["post"],"context":"normal","priority":"default","cpt":"wp-restaurant-foods","fields":[{"type":"number","label":"Food Quantity","id":"wp_restaurant_foodsfood-quantity"},{"type":"number","label":"Regular Price","default":"1","min":"1","id":"wp_restaurant_foodsregular-price"},{"type":"number","label":"Sell Price","default":"1","min":"1","id":"wp_restaurant_foodssell-price"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		$this->process_cpts();
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'admin_head', [ $this, 'admin_head' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function process_cpts() {
		if ( !empty( $this->config['cpt'] ) ) {
			if ( empty( $this->config['post-type'] ) ) {
				$this->config['post-type'] = [];
			}
			$parts = explode( ',', $this->config['cpt'] );
			$parts = array_map( 'trim', $parts );
			$this->config['post-type'] = array_merge( $this->config['post-type'], $parts );
		}
	}

	public function add_meta_boxes() {
		foreach ( $this->config['post-type'] as $screen ) {
			add_meta_box(
				sanitize_title( $this->config['title'] ),
				$this->config['title'],
				[ $this, 'add_meta_box_callback' ],
				$screen,
				$this->config['context'],
				$this->config['priority']
			);
		}
	}

	public function admin_head() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			?><?php
		}
	}

	public function save_post( $post_id ) {
		foreach ( $this->config['fields'] as $field ) {
			switch ( $field['type'] ) {
				default:
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
			}
		}
	}

	public function add_meta_box_callback() {
		$this->fields_table();
	}

	private function fields_table() {
		?>
		<div id="wp-restaurant-food-meta-tabs">
			<ul>
			    <li><a href="#wp-restaurant-food-price">Price</a></li>
			    <li><a href="#wp-restaurant-food-stock">Stock</a></li>
			    <li><a href="#wp-restaurant-food-ingredients">Ingredients</a></li>
			</ul>
			<div id="wp-restaurant-food-price">
				<table class="form-table" role="presentation">
					<tbody>
						<?php
							foreach ( $this->config['fields'] as $field ) {
								?><tr>
									<th scope="row"><?php $this->label( $field ); ?></th>
									<td><?php $this->field( $field ); ?></td>
								</tr><?php
							}
						?>
					</tbody>
				</table>
			</div>
			<div id="wp-restaurant-food-stock">
				<table class="form-table" role="presentation">
					<tbody>
						<?php
							foreach ( $this->config['fields'] as $field ) {
								?><tr>
									<th scope="row"><?php $this->label( $field ); ?></th>
									<td><?php $this->field( $field ); ?></td>
								</tr><?php
							}
						?>
					</tbody>
				</table>
			</div>
			<div id="wp-restaurant-food-ingredients">
				<table class="form-table" role="presentation">
					<tbody>
						<?php
							foreach ( $this->config['fields'] as $field ) {
								?><tr>
									<th scope="row"><?php $this->label( $field ); ?></th>
									<td><?php $this->field( $field ); ?></td>
								</tr><?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			default:
				printf(
					'<label class="" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			case 'number':
				$this->input_minmax( $field );
				break;
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		printf(
			'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s">',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function input_minmax( $field ) {
		printf(
			'<input class="regular-text" id="%s" %s %s name="%s" %s type="%s" value="%s">',
			$field['id'],
			isset( $field['max'] ) ? "max='{$field['max']}'" : '',
			isset( $field['min'] ) ? "min='{$field['min']}'" : '',
			$field['id'],
			isset( $field['step'] ) ? "step='{$field['step']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

}
new Wp_Restaurant_Food_Meta();