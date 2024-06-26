/**
 * Custom scripts for Toggle Control
 *
 * @package StoreFlex
 */

wp.customize.controlConstructor['mt-toggle'] = wp.customize.Control.extend({
	ready: function(){
		'use strict';

		var control = this,
            checkboxValue = control.setting._value;

		// Save the value
		this.container.on( 'change', 'input', function() {
			checkboxValue = ( jQuery( this ).is( ':checked' ) ) ? true : false;
			control.setting.set( checkboxValue );
		});
	}
});