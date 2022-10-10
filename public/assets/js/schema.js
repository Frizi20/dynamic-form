// const schema = {
//     title: '',
//     type: 'object',
//     required: [
//         'name',
//         'age',
//         'date',
//         'favorite_color',
//         'gender',
//         'location',
//         'pets'
//     ],
//     properties: {
//         name: {
//             type: 'string',
//             description: 'First and Last name',
//             minLength: 4,
//             default: 'Jeremy Dorn'
//         },
//         age: {
//             type: 'integer',
//             default: 25,
//             minimum: 18,
//             maximum: 99
//         },
//         favorite_color: {
//             type: 'string',
//             format: 'color',
//             title: 'favorite color',
//             default: '#ffa500'
//         },
//         gender: {
//             type: 'string',
//             enum: ['male', 'female', 'other']
//         },
//         date: {
//             type: 'string',
//             format: 'date',
//             options: {
//                 flatpickr: {}
//             }
//         },
//         location: {
//             type: 'object',
//             title: 'Location',
//             properties: {
//                 city: {
//                     type: 'string',
//                     default: 'San Francisco'
//                 },
//                 state: {
//                     type: 'string',
//                     default: 'CA'
//                 },
//                 citystate: {
//                     type: 'string',
//                     description:
//                         'This is generated automatically from the previous two fields',
//                     template: '{{city}}, {{state}}',
//                     watch: {
//                         city: 'location.city',
//                         state: 'location.state'
//                     }
//                 }
//             }
//         },
//         pets: {
//             type: 'array',
//             format: 'table',
//             title: 'Pets',
//             uniqueItems: true,
//             items: {
//                 type: 'object',
//                 title: 'Pet',
//                 properties: {
//                     type: {
//                         type: 'string',
//                         enum: ['cat', 'dog', 'bird', 'reptile', 'other'],
//                         default: 'dog'
//                     },
//                     name: {
//                         type: 'string'
//                     }
//                 }
//             },
//             default: [
//                 {
//                     type: 'dog',
//                     name: 'Walter'
//                 }
//             ]
//         }
//     }
// };

const schema = {
    title: 'Json Form',
    type: 'object',
    options: {
        // collapsed:true
    },
    properties: {
        firstName: {
            type: 'string',
            title: 'Nume de familie'
        },
        lastName: {
            type: 'string',
            title: 'Prenume'
        },
        age: {
            title: 'Varsta',
            type: 'integer',
            default: ''
        },
        address: {
            title: 'Adresa',
            type: 'string'
			
        },
        city: {
            type: 'select',
			title:'Oras',
			default:"",
			required:true,
            format: 'select',
			enum: ['', '1', '2', '3', '4'],
			options:{
				enum_titles:['Slobozia','Bucuresti','Timisioara','Brasov']
			}

        },
        gender: {
            type: 'string',
            title: 'Gender',
            description: 'Active Radio buttons',
            format: 'radio',
            enum: ['1', '2', '3', '4'],
            options: {
                input_height: '450px',
                enum_titles: ['ceva', 'doi', 'trei', 'patru']
            }
        },
        submit: {
            type: 'button',
            title: 'Submit',
            options: {
                button: {
                    action: 'submitForm',
                    // validated:true
                    rqeuired: false
                },
                inputAttributes: {
                    class: 'btn btn-secondary btn-sm json-editor-btn btn-center'
                },
                containerAttributes: {
                    class: 'myContainer'
                }
            }
        }
    },
    required: []
};
