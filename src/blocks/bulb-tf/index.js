/**
 * Block dependencies
 */
import classnames from 'classnames'; // Helper library to add classnames to a component
import blockAttributes from './attributes';
import './styles/style.scss';
import './styles/editor.scss';
import Answers from '../../components/Answers';

import Inspector from './inspector';
import Controls from './controls';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { RichText } = wp.editor;
const { Fragment } = wp.element;

// Register the block
export default registerBlockType( 'bulb/question-tf', {
	title: __( 'BULB - T/F', 'bulearningblocks' ),
	description: __( 'Add a TRUE/FALSE question to your learning module.' ),
	icon: 'welcome-learn-more',
	category: 'bu-learning-blocks',
	keywords: [
		__( 'bu-learning-block', 'bulearningblocks' ),
		__( 'BULB', 'bulearningblocks' ),
		__( 'True False Question', 'bulearningblocks' ),
	],
	attributes: blockAttributes,

	getEditWrapperProps( editWrapperProps ) {
		const { blockAlignment } = editWrapperProps;
		if (
			'left' === blockAlignment ||
			'right' === blockAlignment ||
			'full' === blockAlignment
		) {
			return { 'data-align': blockAlignment };
		}
	},

	edit: props => {
		const {
			attributes: {
				id,
				header,
				body,
				answers,
				fontSize,
				textAlignment,
				textColorControl,
				backgroundColorControl,
			},
			className,
			setAttributes,
			clientId,
		} = props;

		if ( ! id ) {
			setAttributes( {
				id: 'bulb_question_' + clientId.replace( /-/g, '' ),
			} );
		}

		// Handle input field changes
		const onChangeHeader = newHeader => {
			setAttributes( {
				header: newHeader,
			} );
		};
		const onChangeBody = newBody => {
			setAttributes( {
				body: newBody,
			} );
		};

		const onChangeAnswers = newAnswers => {
			setAttributes( {
				answers: newAnswers,
			} );
		};

		return (
			<div className="quizDescription">
				<Fragment>
					<Inspector { ...{ setAttributes, ...props } } />
					<div id={ id } className={ classnames( 'question', className ) }>
						<h5>Question Header:</h5>
						<RichText
							tagName="p"
							// multiline="p"
							placeholder={ __( 'Question Header', 'bulearningblocks' ) }
							keepPlaceholderOnFocus={ true }
							className={ classnames( 'question-header' ) }
							style={ {
								textAlign: textAlignment,
								color: textColorControl,
								backgroundColor: backgroundColorControl,
								fontSize: fontSize ? fontSize + 'px' : undefined,
							} }
							onChange={ onChangeHeader }
							value={ header }
						/>
						<h5>Question Body:</h5>
						<RichText
							tagName="p"
							// multiline="p"
							placeholder={ __( 'Question Body', 'bulearningblocks' ) }
							keepPlaceholderOnFocus={ true }
							className={ classnames( 'question-body' ) }
							style={ {
								textAlign: textAlignment,
								color: textColorControl,
								backgroundColor: backgroundColorControl,
								fontSize: fontSize ? fontSize + 'px' : undefined,
							} }
							onChange={ onChangeBody }
							value={ body }
						/>
						<Answers
							answers={ answers }
							onChangeAnswers={ onChangeAnswers }
							multipleCorrectAllowed={ false }
						/>
					</div>
					<Controls { ...{ setAttributes, ...props } } />
				</Fragment>
			</div>
		);
	},
	save: () => null,
} );
