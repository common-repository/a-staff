// Gutenberg block editor scripts for a-staff


// Loading required parts
var registerBlockType = wp.blocks.registerBlockType;
var InspectorControls = wp.editor.InspectorControls;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    SelectControl = _wp$components.SelectControl,
    ServerSideRender = _wp$components.ServerSideRender;

// Registering the block itself

registerBlockType('a-staff/member-block', {
	title: A_STAFF_MEMBER_BLOCK.block_title,
	icon: 'id-alt',
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
				{ title: A_STAFF_MEMBER_BLOCK.block_title },
				wp.element.createElement(SelectControl, {
					label: A_STAFF_MEMBER_BLOCK.select_label,
					value: props.attributes.user_id ? parseInt(props.attributes.user_id) : 0,
					options: A_STAFF_MEMBER_BLOCK.memberlist,
					onChange: function onChange(value) {
						props.setAttributes({ user_id: value });
					}
				})
			)
		), wp.element.createElement(ServerSideRender, {
			block: 'a-staff/member-block',
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
//# sourceMappingURL=map/a-staff-member-block.js.map