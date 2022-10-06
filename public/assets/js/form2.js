const form = document.querySelector('form');
const submit = document.querySelector('button[type="submit"]');
let formInputs = []
let formStructure;

submit.addEventListener('click', (e) => {
    e.preventDefault();
    submitForm();
});

const getFormStructure = async function () {
    const response = await fetch('/get_form_structure');
    const data = await response.json();

    formStructure = data;

    // console.table(formStructure);
    console.table(formStructure);
    addFormInputs(formStructure);
};

const addFormInputs = function (formInputs) {
    let renderInput = true;
    let rootBranches = [];

    //Show first qestion of every branch and the questions without one
    formInputs.forEach((formInput, index, arr) => {
        if (
            !rootBranches.includes(formInput.branch) ||
            formInput.branch == '0'
        ) {
            addInput(formInput, false, form);
            rootBranches.push(formInput.branch);
        }
    });

    // formInputs.forEach((formInput) => {
    //     if (renderInput) {
    //         addInput(formInput);

    //         if (formInput.hasBranch) {
    //             renderInput = false;
    //         }
    //     }
    // });
};

const addInput = function (formInput, isHidden = true, placeDom) {
    const firstQuestion = formInput;

    if (firstQuestion.input_type == 'select') {
        //Create select HTML element
        const selectElement = document.createElement('select');
        const answers = firstQuestion.answer;
        // let optionsHTML = '';

        // form.insertAdjacentElement('afterbegin',selectElement)
        selectElement.dataset.inputId = firstQuestion.id;

        //Add all options to the select input
        //First unselectable option(The placeholder of the select input)
        answers.forEach((answer, index) => {
            if (index === 0) {
                const defaultOptionNode = document.createElement('option');
                //Placeholder name
                defaultOptionNode.text = 'Select option';
                defaultOptionNode.setAttribute('hidden', 'true');
                defaultOptionNode.setAttribute('selected', 'true');
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

        //Create select HTML
        const insertedSelectInput = addQuestionElement(
            firstQuestion.question,
            selectElement.outerHTML,
            firstQuestion.id,
            firstQuestion.branch,
            isHidden,
            placeDom //DOM element where to create it
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
            firstQuestion.id,
            firstQuestion.branch,
            isHidden,
            placeDom //DOM element where to create it
        );

        //Get all inputs from the radio container
        const radioButtons = insertedRadioContainer.querySelectorAll(`[name]`);

        radioButtons.forEach((radioBtn) => {
            const nextQ = radioBtn.dataset.nextQ;

            if (Number(nextQ) !== 0) {
                radioBtn.addEventListener(
                    'change',
                    answerSelected.bind(this, firstQuestion.id)
                );
            }
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
        addQuestionElement(
            firstQuestion.question,
            html,
            firstQuestion.id,
            firstQuestion.branch,
            isHidden,
            placeDom
        );
    }
};

const addQuestionElement = function (
    question,
    options,
    dataId,
    branchNr,
    isHidden,
    placeDom = form
) {
    const html = `
        <div ${isHidden ? 'style="display:none"' : ''}
		class="question-container" data-q-id="${dataId}" data-branch-nr="${branchNr}"">
            <div class="question">
                ${question}
            </div>
            ${options}
        </div>
        `;

    const position = placeDom.tagName === 'FORM' ? 'beforeend' : 'afterend';

    placeDom.insertAdjacentHTML(position, html);
    return document.querySelector(`[data-input-id ='${dataId}']`);
};

function answerSelected(id, event) {
    const { type: inputType } = event.target;

    const currentDomQuestion = document.querySelector(`[data-q-id="${id}"]`);
    const currentQuestionBranches = Array.from(
        document.querySelectorAll(
            `[data-branch-nr="${currentDomQuestion.dataset.branchNr}"]`
        )
    );
    let currQuestionIndex = -1;
    currentQuestionBranches.forEach((question, i, arr) => {
        if (question == currentDomQuestion) {
            currQuestionIndex = i;
        }
    });
    const nextBranchElements = currentQuestionBranches.slice(
        currQuestionIndex + 1,
        currentQuestionBranches.length
    );

    console.log(currentDomQuestion);

    nextBranchElements.forEach((nextEl) => nextEl.remove());

    if (inputType === 'select-one') {
        //Get next question form structure data
        const selectedIndex = event.target.options.selectedIndex;
        const selectedOption = event.target.options[selectedIndex];
        const nextQuestionId = selectedOption.dataset.nextQ;

        const nextQuestion = formStructure.find((question) => {
            return question.id == Number(nextQuestionId);
        });

        addInput(nextQuestion, false, currentDomQuestion);

        // console.log(nextQuestionId)
    }

    // //Select all available questions
    // const allQuestionInputs = Array.from(
    //     document.querySelectorAll('.question-container')
    // );
    // let currQuestionIdex = -1;
    // //Get Index of the current question question
    // allQuestionInputs.forEach((input, index) => {
    //     if (id == input.dataset.qId) {
    //         currQuestionIdex = index;
    //     }
    // });
    // //Get the following questions
    // const nextQuestions = allQuestionInputs.slice(
    //     currQuestionIdex + 1,
    //     allQuestionInputs.length
    // );
    // //Remove following questions
    // nextQuestions.forEach((qustion) => qustion.remove());

    if (inputType === 'select-one') {
        const selectedIndex = event.target.options.selectedIndex;
        const selectedOption = event.target.options[selectedIndex];
        const nextQuestionId = selectedOption.dataset.nextQ;

        // addInput(nextQuestion, false, currentDomQuestion);

        // document.querySelector(`[data-q-id="]"`)

        // document.querySelector(`[data-q-id='${nextQuestionId}']`).style = {};

        // return;
        // const nextQuestion = formStructure.find(
        //     (el) => selectedOption.dataset.nextQ == el.id
        // );

        // addInput(nextQuestion);
    }

    if (inputType == 'radio') {
        // const sele
        const nextQuestion = formStructure.find((el) => {
            return event.target.dataset.nextQ == el.id;
        });

        addInput(nextQuestion, false, currentDomQuestion);
    }
}



function submitForm(){
	console.log(form)
}



getFormStructure();
