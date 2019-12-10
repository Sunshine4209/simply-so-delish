<?php

abstract class JPIBFI_Options {

    abstract function get_option_name();

    abstract function get_default_options();

	/**
	 * @return array
	 */
    protected abstract function get_types();

    function sanitize($input) {
    	$types = $this->get_types();
    	$defaults = $this->get_default_options();
	    foreach ( $types as $key => $type ) {
			$input[ $key ] = $this->sanitize_field( $input[ $key ], $type, $defaults[ $key ] );
	    }
        return $input;
    }

    public function get() {
        $db_options = get_option( $this->get_option_name() );
        $db_options = $db_options != false ? $db_options : array();
        $defaults = $this->get_default_options();
        $merged = array_merge($defaults, $db_options);
        return $this->sanitize($merged);
    }

    public function update( $val ) {
        update_option( $this->get_option_name(), $val );
    }

	private function sanitize_field( $value, $type, $default ) {
    	if ( ! isset($value ) )
    		return $default;
		switch ( $type ) {
			case 'int':
				return is_numeric( $value ) ? intval( $value ) : $default;
			case 'float':
				return is_numeric( $value ) ? floatval( $value ) : $default;
			case 'boolean':
				return is_bool( $value ) ? $value : $default;
			case 'array':
				return is_array( $value ) ? $value : $default;
			case 'string':
				return is_string( $value ) ? $value : $default;
			default:
				return $value;
		}
	}
}