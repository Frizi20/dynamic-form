const schema = {
    schema: {
        name: {
            title: 'What is your name',
            description: 'Please enter full name',
            type: 'string',
			required:{

			}

        },
        age: {
            title: 'what s your age',
            type: 'number',
			required:true
        },
        city: {
            title: 'where do you live?',
            description: 'select your city',
            type: 'string',
            enum: ['', 'Slobozia', 'Bucuresti', 'Constanta', 'Brasov']
        },
        gender: {
            title: "What's your gender ",
            description: 'you gender',
            enum: ['male', 'female', 'something'],
			required:true
        },
        friends: {}
    },
    form: [
        {
            key: 'name',
        },
        'age',
        'city',
        {
            key: 'gender',
            type: 'radios',
            titleMap: {
                male: 'Dude',
                female: 'Dudette',
                something: 'No idea'
            }
        },
        {
            type: 'submit',
            title: 'Save Form'
        }
    ],
    validate: false,
    onSubmit: function (err, values) {
        submitForm(err, values);
    },
    displayErrors: function (errors, formElt) {
        for (var i = 0; i < errors.length; i++) {
            errors[i].message = "Avast! Ye best be fixin' that field!";
        }
        $(formElt).jsonFormErrors(errors, formObject);
    }
};








