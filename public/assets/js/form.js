const form = document.querySelector('form')
const submit = document.querySelector('button[type="submit"]')



let formStructure 

submit.addEventListener('click',(e)=>{
    e.preventDefault()
    console.log(e)
})



const getFormStructure = async function(){
    const response = await fetch('/get_form_structure')
    const data = await response.json()

    formStructure = data

    console.log(formStructure)
    
    addFormInputs(data)
}

const addFormInputs = function(formInputs){


    let renderInput = true

    formInputs.forEach(formInput => {

        if(renderInput){
            
            addInput(formInput)

            if(formInput.hasBranch){
                renderInput = true
            }
        }
    });

}


const addInput = function(formInput) {


    const firstQuestion = formInput

    if(firstQuestion.input_type == 'select'){
        const selectElement = document.createElement('select')
        const answers = firstQuestion.answer
        let optionsHTML = ''
        
        // form.insertAdjacentElement('afterbegin',selectElement)
        selectElement.dataset.inputId = firstQuestion.id
        

        answers.forEach((answer, index) => {
            
            const optionNode = document.createElement('option')
            optionNode.text = answer.option
            optionNode.value = answer.option
            optionNode.dataset.nextQ = answer.next_question
            optionsHTML+= optionNode.outerHTML
            selectElement.insertAdjacentElement('afterbegin', optionNode)
        });

        optionsHTML+= ''



        //Create select HTML
        const createdInput = addQuestionElement(firstQuestion.question, selectElement.outerHTML,firstQuestion.id)

        //Add next element basted on option selection

        createdInput.addEventListener('change',answerSelected.bind(this, firstQuestion.id))

        

    }
    

}

const addQuestionElement = function($question, options,dataId){
    const html =  `
        <div class="question-container">
            <div class="question">
                ${$question}
            </div>
            ${options}
        </div>
        `
    form.insertAdjacentHTML('beforeend', html)

    return document.querySelector(`[data-input-id = '${dataId}']`)

}

function answerSelected(id,event){

    const selectedIndex = event.target.options.selectedIndex
    const selectedOption = event.target.options[selectedIndex]
    const nextQuestion = formStructure.find(el=>selectedOption.dataset.nextQ == el.id)


    console.log(nextQuestion)
    addInput(nextQuestion)
}


getFormStructure()