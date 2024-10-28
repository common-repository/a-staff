// Gutenberg block editor scripts for a-staff


// Loading required parts
var registerBlockType = wp.blocks.registerBlockType;
var InspectorControls = wp.editor.InspectorControls;
var _wp$components = wp.components,
    BaseControl = _wp$components.BaseControl,
    PanelBody = _wp$components.PanelBody,
    SelectControl = _wp$components.SelectControl,
    ServerSideRender = _wp$components.ServerSideRender,
    TextControl = _wp$components.TextControl;

// Registering the block itself

registerBlockType('a-staff/loop-block', {
	title: A_STAFF_LOOP_BLOCK.block_title,
	icon: 'groups',
	category: 'widgets',
	supports: {
		anchor: false,
		customClassName: false
	},

	edit: function edit(props) {
		return [wp.element.createElement(
			InspectorControls,
			null,
			wp.element.createElement(
				PanelBody,
				{ title: A_STAFF_LOOP_BLOCK.layout_panel_title },
				wp.element.createElement(
					BaseControl,
					{
						label: A_STAFF_LOOP_BLOCK.columns_number_label },
					wp.element.createElement('input', {
						type: 'number',
						onChange: function onChange(event) {
							props.setAttributes({ columns: parseInt(event.target.value) });
						},
						value: props.attributes.columns,
						min: A_STAFF_LOOP_BLOCK.columns_min,
						max: A_STAFF_LOOP_BLOCK.columns_max
					})
				),
				wp.element.createElement(SelectControl, {
					label: A_STAFF_LOOP_BLOCK.orderby_label,
					value: props.attributes.orderby,
					options: A_STAFF_LOOP_BLOCK.orderby_options,
					onChange: function onChange(value) {
						props.setAttributes({ orderby: value });
					}
				}),
				wp.element.createElement(SelectControl, {
					label: A_STAFF_LOOP_BLOCK.order_label,
					value: props.attributes.order,
					options: A_STAFF_LOOP_BLOCK.order_options,
					onChange: function onChange(value) {
						props.setAttributes({ order: value });
					}
				}),
				wp.element.createElement(TextControl, {
					label: A_STAFF_LOOP_BLOCK.class_name_label,
					value: props.attributes.class,
					onChange: function onChange(value) {
						props.setAttributes({ class: value });
					}
				})
			),
			wp.element.createElement(
				PanelBody,
				{
					title: A_STAFF_LOOP_BLOCK.filters_panel_title,
					initialOpen: false },
				wp.element.createElement(SelectControl, {
					label: A_STAFF_LOOP_BLOCK.ids_label,
					value: props.attributes.ids,
					options: A_STAFF_LOOP_BLOCK.ids_options,
					multiple: 'true',
					onChange: function onChange(value) {
						props.setAttributes({ ids: value });
					}
				}),
				wp.element.createElement(SelectControl, {
					label: A_STAFF_LOOP_BLOCK.exclude_label,
					value: props.attributes.exclude,
					options: A_STAFF_LOOP_BLOCK.ids_options,
					multiple: 'true',
					onChange: function onChange(value) {
						props.setAttributes({ exclude: value });
					}
				}),
				wp.element.createElement(SelectControl, {
					label: A_STAFF_LOOP_BLOCK.department_label,
					value: props.attributes.department,
					options: A_STAFF_LOOP_BLOCK.department_options,
					multiple: 'true',
					onChange: function onChange(value) {
						props.setAttributes({ department: value });
					}
				}),
				wp.element.createElement(SelectControl, {
					label: A_STAFF_LOOP_BLOCK.exclude_department_label,
					value: props.attributes.exclude_department,
					options: A_STAFF_LOOP_BLOCK.department_options,
					multiple: 'true',
					onChange: function onChange(value) {
						props.setAttributes({ exclude_department: value });
					}
				})
			)
		), wp.element.createElement(ServerSideRender, {
			block: 'a-staff/loop-block',
			attributes: props.attributes
		})];
	},
	save: function save() {
		return null;
	}
});

// Preventing the links to be clickable in admin
$(document).on('click', '.a-staff-member-box-wrapper a', function (e) {
	e.preventDefault();
});
//# sourceMappingURL=map/a-staff-loop-block.js.map