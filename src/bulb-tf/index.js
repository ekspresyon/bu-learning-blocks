/**
 * Block dependencies
 */
import classnames from 'classnames'; // Helper library to add classnames to a component
import Inspector from './inspector';
import Controls from './controls';
import attributes from './attributes';
import './styles/style.scss';
import './styles/editor.scss';

const { __ } = wp.i18n;
const {
	registerBlockType,
} = wp.blocks;
const {
	RichText,
} = wp.editor;

// Register the block
export default registerBlockType( 'bulb/question-tf',
	{
		title: __( 'BULB - T/F', 'bulearningblocks' ),
		description: __( 'Add a TRUE/FALSE question to your learning module.' ),
		icon: 'welcome-learn-more',
		category: 'bu-learning-blocks',
		keywords: [
			__( 'bu-learning-block', 'bulearningblocks' ),
			__( 'BULB', 'bulearningblocks' ),
			__( 'True False Question', 'bulearningblocks' ),
		],
		attributes,
		getEditWrapperProps( attributes ) {
			const { blockAlignment } = attributes;
			if ( 'left' === blockAlignment || 'right' === blockAlignment || 'full' === blockAlignment ) {
				return { 'data-align': blockAlignment };
			}
		},
		edit: props => {
			const { attributes: { textAlignment, question, highContrast }, className, setAttributes } = props;
			const onChangeMessage = question => { setAttributes( { question } ); };

			return [
				<Inspector { ...{ setAttributes, ...props } } />,
				<div
					className={ classnames(
						className,
						{ 'high-contrast': highContrast },
					) }
				>
					<RichText
						tagName="div"
						multiline="p"
						placeholder={ __( 'Enter your question here..', 'bulearningmodules' ) }
						className={ classnames( 'question-body', ) }
						style={ { textAlign: textAlignment } }
						onChange={ onChangeMessage }
						value={ question }
					/>
				</div>,
				<Controls { ...{ setAttributes, ...props } } />,
			];
		},
		save: props => {
			const { attributes: { highContrast, textAlignment, blockAlignment, question } } = props;
			return (
				<div
					className={classnames(
						`align${ blockAlignment }`,
						{ 'high-contrast': highContrast },
						'question-body',
					) }
					style={ { textAlign: textAlignment } }
				>
					{ question }
				</div>
			);
		},
	},
);
