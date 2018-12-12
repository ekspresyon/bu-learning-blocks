/**
 * BULB Frontend
 *
 * Handles frontend logic...
 */
import ReactDOM from 'react-dom';

// Import the react-questions library.
import { Question } from 'react-questions';

// Find all .bulb-question DOM containers, collect their data from window and render <Questions> into them.
document.querySelectorAll( '.bulb-question' ).forEach( questionContainer => {
	const questionId = questionContainer.id;
	const questionData = window[ questionId ];
	ReactDOM.render( <Question questionData={ questionData } />, questionContainer );
} );
