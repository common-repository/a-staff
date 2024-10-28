// Gutenberg block editor scripts for a-staff



// Loading required parts
const {
	registerBlockType
} = wp.blocks;

const {
	InspectorControls
} = wp.editor;

const {
	BaseControl,
	PanelBody,
    SelectControl,
	ServerSideRender,
	TextControl
} = wp.components;



// Registering the block itself
registerBlockType( 'a-staff/loop-block', {
    title		: A_STAFF_LOOP_BLOCK.block_title,
    icon		: 'groups',
    category	: 'widgets',
	supports	: {
		anchor	: false,
		customClassName : false
	},

    edit( props ) {
        return [
			<InspectorControls>
				<PanelBody title={ A_STAFF_LOOP_BLOCK.layout_panel_title }>
					<BaseControl
						label={ A_STAFF_LOOP_BLOCK.columns_number_label }>
						<input
							type="number"
							onChange={ ( event ) => {
								props.setAttributes( { columns: parseInt( event.target.value ) } );
							} }
							value={ props.attributes.columns }
							min={ A_STAFF_LOOP_BLOCK.columns_min }
							max={ A_STAFF_LOOP_BLOCK.columns_max }
						/>
					</BaseControl>
					<SelectControl
						label={ A_STAFF_LOOP_BLOCK.orderby_label }
						value={ props.attributes.orderby }
						options={ A_STAFF_LOOP_BLOCK.orderby_options }
						onChange={ ( value ) => {
							props.setAttributes( { orderby: value } );
						} }
					/>
					<SelectControl
						label={ A_STAFF_LOOP_BLOCK.order_label }
						value={ props.attributes.order }
						options={ A_STAFF_LOOP_BLOCK.order_options }
						onChange={ ( value ) => {
							props.setAttributes( { order: value } );
						} }
					/>
					<TextControl
						label={ A_STAFF_LOOP_BLOCK.class_name_label }
						value={ props.attributes.class }
						onChange={ ( value ) => {
							props.setAttributes( { class: value } );
						} }
					/>
				</PanelBody>
				<PanelBody
					title={ A_STAFF_LOOP_BLOCK.filters_panel_title }
					initialOpen={ false }>
					<SelectControl
						label={ A_STAFF_LOOP_BLOCK.ids_label }
						value={ props.attributes.ids }
						options={ A_STAFF_LOOP_BLOCK.ids_options }
						multiple="true"
						onChange={ ( value ) => {
							props.setAttributes( { ids: value } );
						} }
					/>
					<SelectControl
						label={ A_STAFF_LOOP_BLOCK.exclude_label }
						value={ props.attributes.exclude }
						options={ A_STAFF_LOOP_BLOCK.ids_options }
						multiple="true"
						onChange={ ( value ) => {
							props.setAttributes( { exclude: value } );
						} }
					/>
					<SelectControl
						label={ A_STAFF_LOOP_BLOCK.department_label }
						value={ props.attributes.department }
						options={ A_STAFF_LOOP_BLOCK.department_options }
						multiple="true"
						onChange={ ( value ) => {
							props.setAttributes( { department: value } );
						} }
					/>
					<SelectControl
						label={ A_STAFF_LOOP_BLOCK.exclude_department_label }
						value={ props.attributes.exclude_department }
						options={ A_STAFF_LOOP_BLOCK.department_options }
						multiple="true"
						onChange={ ( value ) => {
							props.setAttributes( { exclude_department: value } );
						} }
					/>
				</PanelBody>
			</InspectorControls>,
			<ServerSideRender
                block="a-staff/loop-block"
                attributes={ props.attributes }
            />
		]
    },

    save() {
        return null;
    },
} );


// Preventing the links to be clickable in admin
$(document).on('click','.a-staff-member-box-wrapper a', function(e){
	e.preventDefault();
});
