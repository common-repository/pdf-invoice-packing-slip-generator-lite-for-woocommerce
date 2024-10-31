<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       www.redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    rtwcpiglw_Woocommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_Woocommerce_Pdf_Invoice_Generator/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    rtwcpiglw_Woocommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_Woocommerce_Pdf_Invoice_Generator/includes
 * @author     RedefiningTheWeb <developer@redefiningtheweb.com>
 */
class rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $rtwcpiglw_actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $rtwcpiglw_actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $rtwcpiglw_filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $rtwcpiglw_filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->rtwcpiglw_actions = array();
		$this->rtwcpiglw_filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $rtwcpiglw_hook             The name of the WordPress action that is being registered.
	 * @param    object               $rtwcpiglw_component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $rtwcpiglw_callback         The name of the function definition on the $rtwcpiglw_component.
	 * @param    int                  $rtwcpiglw_priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $rtwcpiglw_accepted_args    Optional. The number of arguments that should be passed to the $rtwcpiglw_callback. Default is 1.
	 */
	public function rtwcpiglw_add_action( $rtwcpiglw_hook, $rtwcpiglw_component, $rtwcpiglw_callback, $rtwcpiglw_priority = 10, $rtwcpiglw_accepted_args = 1 ) {
		$this->rtwcpiglw_actions = $this->rtwcpiglw_add( $this->rtwcpiglw_actions, $rtwcpiglw_hook, $rtwcpiglw_component, $rtwcpiglw_callback, $rtwcpiglw_priority, $rtwcpiglw_accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $rtwcpiglw_hook             The name of the WordPress filter that is being registered.
	 * @param    object               $rtwcpiglw_component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $rtwcpiglw_callback         The name of the function definition on the $rtwcpiglw_component.
	 * @param    int                  $rtwcpiglw_priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $rtwcpiglw_accepted_args    Optional. The number of arguments that should be passed to the $rtwcpiglw_callback. Default is 1
	 */
	public function rtwcpiglw_add_filter( $rtwcpiglw_hook, $rtwcpiglw_component, $rtwcpiglw_callback, $rtwcpiglw_priority = 10, $rtwcpiglw_accepted_args = 1 ) {
		$this->rtwcpiglw_filters = $this->rtwcpiglw_add( $this->rtwcpiglw_filters, $rtwcpiglw_hook, $rtwcpiglw_component, $rtwcpiglw_callback, $rtwcpiglw_priority, $rtwcpiglw_accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $rtwcpiglw_hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $rtwcpiglw_hook             The name of the WordPress filter that is being registered.
	 * @param    object               $rtwcpiglw_component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $rtwcpiglw_callback         The name of the function definition on the $component.
	 * @param    int                  $rtwcpiglw_priority         The priority at which the function should be fired.
	 * @param    int                  $rtwcpiglw_accepted_args    The number of arguments that should be passed to the $rtwcpiglw_callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function rtwcpiglw_add( $rtwcpiglw_hooks, $rtwcpiglw_hook, $rtwcpiglw_component, $rtwcpiglw_callback, $rtwcpiglw_priority, $rtwcpiglw_accepted_args ) {

		$rtwcpiglw_hooks[] = array(
			'hook'          => $rtwcpiglw_hook,
			'component'     => $rtwcpiglw_component,
			'callback'      => $rtwcpiglw_callback,
			'priority'      => $rtwcpiglw_priority,
			'accepted_args' => $rtwcpiglw_accepted_args
		);

		return $rtwcpiglw_hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function rtwcpiglw_run() {

		foreach ( $this->rtwcpiglw_filters as $rtwcpiglw_hook ) {
			add_filter( $rtwcpiglw_hook['hook'], array( $rtwcpiglw_hook['component'], $rtwcpiglw_hook['callback'] ), $rtwcpiglw_hook['priority'], $rtwcpiglw_hook['accepted_args'] );
		}

		foreach ( $this->rtwcpiglw_actions as $rtwcpiglw_hook ) {
			add_action( $rtwcpiglw_hook['hook'], array( $rtwcpiglw_hook['component'], $rtwcpiglw_hook['callback'] ), $rtwcpiglw_hook['priority'], $rtwcpiglw_hook['accepted_args'] );
		}

	}

}
