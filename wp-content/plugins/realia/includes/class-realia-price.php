<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Realia_Price
 *
 * @class Realia_Price
 * @package Realia/Classes
 * @author Pragmatic Mates
 */
class Realia_Price {
	/**
	 * Gets property price
	 *
	 * @access public
	 * @param null $post_id
	 * @return bool|string
	 */
	public static function get_property_price( $post_id = null ) {
		if ( null == $post_id ) {
			$post_id = get_the_ID();
		}

		$custom = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price_custom', true );

		if ( ! empty( $custom ) ) {
			return $custom;
		}

		$price = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price', true );

		if ( empty( $price ) || ! is_numeric( $price ) ) {
			return false;
		}

		$price = self::format_price( $price );

		$prefix = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price_prefix', true );
		$suffix = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price_suffix', true );

		if ( ! empty( $prefix ) ) {
			$price = $prefix . ' ' . $price;
		}

		if ( ! empty( $suffix ) ) {
			$price = $price .  ' ' . $suffix;
		}

		return $price;
	}

	/**
	 * Formats price
	 *
	 * @access public
	 * @param $price
	 * @return bool|string
	 */
	public static function format_price( $price ) {
		if ( empty( $price ) || ! is_numeric( $price ) ) {
			return false;
		}

		$price = Realia_Utilities::format_number( $price );

		$currency_index = 0;
		$currencies = get_theme_mod( 'realia_currencies' );
		$currency_symbol = ! empty( $currencies[ $currency_index ]['symbol'] ) ? $currencies[ $currency_index ]['symbol'] : '$';
		$currency_show_symbol_after = ! empty( $currencies[ $currency_index ]['show_after'] ) ? true : false;

		if ( ! empty( $currency_symbol ) ) {
			if ( $currency_show_symbol_after ) {
				$price = $price .  ' ' . $currency_symbol;
			} else {
				$price = $currency_symbol . ' ' . $price;
			}
		}

		return $price;
	}
}
