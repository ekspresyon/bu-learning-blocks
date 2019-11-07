const { __ } = wp.i18n;
const { RichText } = wp.editor;
const { Fragment } = wp.element;
const { SelectControl } = wp.components;

export default ( {
	index,
	answer = '',
	feedback = '',
	correct = '',
	answerCount,
	feedbackPerAnswer,
	onChangeAnswerValue,
	onChangeFeedback,
	onChangeCorrect,
	onRemoveAnswer,
} ) => (
	<div className="bulb-editor-answer">
		<div className="bulb-answer-content">
			<div className="bulb-editor-answer-label">
				{ __( 'Answer', 'bulearningblocks' ) } { index + 1 }
			</div>
			<RichText
				tagName="p"
				placeholder={ __( 'Answer', 'bulearningblocks' ) }
				keepPlaceholderOnFocus={ true }
				className="answer-text"
				onChange={ newAnswerValue => {
					onChangeAnswerValue( newAnswerValue, index );
				} }
				value={ answer }
			/>
			{ feedbackPerAnswer && (
				<Fragment>
					<div className="bulb-editor-answer-label-feedback">
						{ __( 'Feedback', 'bulearningblocks' ) }
					</div>
					<RichText
						tagName="p"
						placeholder={ __( 'Feedback', 'bulearningblocks' ) }
						keepPlaceholderOnFocus={ true }
						className="answer-feedback"
						onChange={ newFeedback => {
							onChangeFeedback( newFeedback, index );
						} }
						value={ feedback }
					/>
				</Fragment>
			) }
			<SelectControl
				label={ __( 'Correct' ) }
				value={ correct }
				onChange={ newCorrect => onChangeCorrect( newCorrect, index ) }
				// Make A, B, C, D options for as many answers that currently exist.
				options={ Array.from( Array( answerCount ), ( x, i ) => ( { value: String.fromCharCode( 65 + i ), label: String.fromCharCode( 65 + i ) } ) ) }
			/>
			<div className="bulb-answer-controls">
				{ onRemoveAnswer && (
					<button onClick={ () => onRemoveAnswer( index ) }>X</button>
				) }
			</div>
		</div>
	</div>
);
