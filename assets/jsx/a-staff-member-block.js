// Gutenberg block editor scripts for a-staff



// Loading required parts
const {
	registerBlockType
} = wp.blocks;

const {
	InspectorControls
} = wp.editor;

const {
	PanelBody,
    SelectControl,
	ServerSideRender
} = wp.components;



// Registering the block itself
registerBlockType( 'a-staff/member-block', {
    title		: A_STAFF_MEMBER_BLOCK.block_title,
    icon		: 'id-alt',
    category	: 'widgets',
	supports	: {
		anchor	: false,
		customClassName : false
	},

    edit( props ) {
        return [
			<InspectorControls>
				<PanelBody title={ A_STAFF_MEMBER_BLOCK.block_title }>
					<SelectControl
						label={ A_STAFF_MEMBER_BLOCK.select_label }
						value={ props.attributes.user_id ? parseInt(props.attributes.user_id) : 0 }
						options={ A_STAFF_MEMBER_BLOCK.memberlist }
						onChange={ ( value ) => {
							props.setAttributes( { user_id: value } );
						} }
					/>
				</PanelBody>
			</InspectorControls>,
			<ServerSideRender
                block="a-staff/member-block"
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
