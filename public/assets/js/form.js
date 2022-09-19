const form = document.querySelector('form');
const submit = document.querySelector('button[type="submit"]');

let formStructure;

submit.addEventListener('click', (e) => {
    e.preventDefault();
    console.log(e);
});

const getFormStructure = async function () {
    const response = await fetch('/get_form_structure');
    const data = await response.json();

    formStructure = data;

    console.log(formStructure);

    addFormInputs(data);
};

const addFormInputs = function (formInputs) {
    let renderInput = true;

    formInputs.forEach((formInput) => {
        if (renderInput) {
            addInput(formInput);

            if (formInput.hasBranch) {
                renderInput = false;
            }
        }
    });
};

const addInput = function (formInput) {
    const firstQuestion = formInput;

    if (firstQuestion.input_type == 'select') {
        const selectElement = document.createElement('select');
        const answers = firstQuestion.answer;
        // let optionsHTML = '';

        // form.insertAdjacentElement('afterbegin',selectElement)
        selectElement.dataset.inputId = firstQuestion.id;

        answers.forEach((answer, index) => {
            //First unselectable option
            if (index === 0) {
                const defaultOptionNode = document.createElement('option');
                defaultOptionNode.text = 'Select option';
                // defaultOptionNode.selected = true
                defaultOptionNode.setAttribute('hidden', 'true');
                defaultOptionNode.setAttribute('selected', 'true');
                // console.dir(defaultOptionNode);
                defaultOptionNode.disabled = 'disabled';
                selectElement.insertAdjacentElement(
                    'afterbegin',
                    defaultOptionNode
                );
            }

            const optionNode = document.createElement('option');
            optionNode.text = answer.option;
            optionNode.value = answer.option;
            optionNode.dataset.nextQ = answer.next_question;
            // optionsHTML += optionNode.outerHTML;

            selectElement.insertAdjacentElement('beforeend', optionNode);
        });

        // optionsHTML += '';

        //Create select HTML
        const insertedSelectInput = addQuestionElement(
            firstQuestion.question,
            selectElement.outerHTML,
            firstQuestion.id
        );

        //Add next element basted on option selection

        insertedSelectInput.addEventListener(
            'change',
            answerSelected.bind(this, firstQuestion.id)
        );
    }

    // Create radio input
    if (firstQuestion.input_type == 'radio') {
        const radioButttonsContainer = document.createElement('div');
        const answers = firstQuestion.answer;

        radioButttonsContainer.classList.add('radio-container');
        radioButttonsContainer.dataset.inputId = firstQuestion.id;

        answers.forEach((answer, index) => {
            const html = `
        	<div class= "radio-wrapper">
        	    <input type="radio" id="${firstQuestion.name}-${answer.id}" name="${firstQuestion.name}" value="${answer.option}" data-next-q="${answer.next_question}">
        	    <label for="${firstQuestion.name}-${answer.id}">${answer.option}</label><br>
        	</div>`;

            radioButttonsContainer.insertAdjacentHTML('beforeend', html);
        });

        const insertedRadioContainer = addQuestionElement(
            firstQuestion.question,
            radioButttonsContainer.outerHTML,
            firstQuestion.id
        );

        const radioButtons = insertedRadioContainer.querySelectorAll(`[name]`);

        radioButtons.forEach((radioBtn) => {
            radioBtn.addEventListener('change', (e) => {
                answerSelected(firstQuestion.id, e);
            });
        });

        //Create radio HTML
        // const createdInput = addQuestionElement(firstQuestion.question, selectElement.outerHTML,firstQuestion.id)
    }

    if (firstQuestion.input_type == 'text') {
        const html = `
			<div class="input-wrapper">
				<input type="text" name="${firstQuestion.name}" id="${firstQuestion.name}">
			</div>
		`;
        addQuestionElement(firstQuestion.question, html, firstQuestion.id);
    }
};

const addQuestionElement = function ($question, options, dataId) {
    const html = `
        <div class="question-container" data-q-id="${dataId}">
            <div class="question">
                ${$question}
            </div>
            ${options}
        </div>
        `;
    form.insertAdjacentHTML('beforeend', html);

    return document.querySelector(`[data-input-id = '${dataId}']`);
};

function answerSelected(id, event) {
    const { type: inputType } = event.target;

    //Select all available questions
    const allQuestionInputs = Array.from(
        document.querySelectorAll('.question-container')
    );

    let currQuestionIdex = -1;

    //Get Index of the current question question
    allQuestionInputs.forEach((input, index) => {
        if (id == input.dataset.qId) {
            currQuestionIdex = index;
        }
    });

    //Get the following questions
    const nextQuestions = allQuestionInputs.slice(
        currQuestionIdex + 1,
        allQuestionInputs.length
    );

    //Remove following questions
    nextQuestions.forEach((qustion) => qustion.remove());

    console.log(inputType);

    if (inputType === 'select-one') {
        const selectedIndex = event.target.options.selectedIndex;
        const selectedOption = event.target.options[selectedIndex];
        const nextQuestion = formStructure.find(
            (el) => selectedOption.dataset.nextQ == el.id
        );

        addInput(nextQuestion);
    }

    if (inputType == 'radio') {
        // const sele
        const nextQuestion = formStructure.find((el) => {
            return event.target.dataset.nextQ == el.id;
        });
        console.log(nextQuestion);
        addInput(nextQuestion);
    }
}

getFormStructure();
