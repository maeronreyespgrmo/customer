let app = new Vue({
el: '#app',
vuetify: new Vuetify(),
data: () => ({
name:"",
checkbox: true,
showButton:true,
currentStep: 1,
totalSteps: 7,
loading:false,
loadingProgress: 0,
isLoading: true,
snackbar:false,
snackbartext:"",
snackbarcolor:"",
isDisabled: false,
dates: "",
others_remarks:"",
// services:"",
services:[],
radio_arr:[],
office_name:"",
office_items:[],
comments:"",
valid:false,
nameRules: [
v => !!v || 'Name is required',
],
name_evaluator:"",
name_evaluatee:"",
snackbar:false,
snackbartext:"",
snackbarcolor:"",
menu: false,
checkbox_data:[],
radio_1:"",
radio_2:"",
radio_3:"",
radio_4:"",
radio_5:"",
radio_6:"",
radio_7:"",
radio_8:"",
radio_9:"",
radio_10:"",
radio_11:"",
radio_12:"",
}),

mounted() {
// Simulate loading progress

},

created () {
this.initialize()
},

methods: {
initialize () {

const progressInterval = setInterval(() => {
this.loadingProgress += 35;
if (this.loadingProgress >= 100) {
this.isLoading = false;
}
}, 1000);


axios.get('/office_dropdown').then(response => {
// console.log(response.data.map(x=> x.office_name))
this.office_items = response.data.map(x=> x.office_name)

})

axios.post('/change_dropdown',{
    office_name: this.office_name
    }).then(response => {
    this.checkbox_data = response.data.map((item, index) => {
    return {
    id: index + 1, // Add an ID property if needed
    name: item,
    checked: false
    };
    });
    console.log(response.data)
    })

let urrl = window.location.href.split('/')[3];
let idd =  window.location.href.split('/')[5];

if(urrl === "edit"){
this.showButton = true
axios.post('/view_css',{
id:idd
}).then(response => {
console.log(response.data)

this.dates = response.data[0].date
this.name_evaluator = response.data[0].name_evaluator
this.name_evaluatee = response.data[0].name_evaluatee
this.services = response.data[0].service_name
this.office_name = response.data[0].office_name
this.radio_1 = response.data[0].radio_1
this.radio_2 = response.data[0].radio_2
this.radio_3 = response.data[0].radio_3
this.radio_4 = response.data[0].radio_4
this.radio_5 = response.data[0].radio_5
this.radio_6 = response.data[0].radio_6
this.radio_7 = response.data[0].radio_7
this.radio_8 = response.data[0].radio_8
this.radio_9 = response.data[0].radio_9
this.radio_10 = response.data[0].radio_10
this.radio_11 = response.data[0].radio_11
this.radio_12 = response.data[0].radio_12
this.comments = response.data[0].comments
this.others_remarks = response.data[0].others_remarks
// axios.post('/service_dropdown',{
// office_name: response.data[0].office_name
// }).then(response => {
// console.log(response)
// this.checkbox_data = response.data.map((item, index) => {
// return {
// id: index + 1, // Add an ID property if needed
// name: item,
// checked: false
// };
// });

// })
})

}
else{
    // axios.post('/service_dropdown',{
    // office_name: "Management Information Systems Office(MISO)"
    // }).then(response => {
    // console.log(response)
    // this.checkbox_data = response.data.map((item, index) => {
    // return {
    // id: index + 1, // Add an ID property if needed
    // name: item,
    // checked: false
    // };
    // });
    // })

}

console.log("office_name",this.office_name)

},

save_btn(){
if(this.$refs.form.validate()){
let urrl = window.location.href.split('/')[3];
let idd =  window.location.href.split('/')[5];
let url = (urrl === "edit")? "/edit_css" : "/save_css"

console.log(this.services.join(","))
axios.post(url, {
id: idd,
office_name: this.office_name,
name_evaluatee: this.name_evaluatee,
name_evaluator: this.name_evaluator,
date: this.dates,
services: this.services,
radio_1: this.radio_1,
radio_2: this.radio_2,
radio_3: this.radio_3,
radio_4: this.radio_4,
radio_5: this.radio_5,
radio_6: this.radio_6,
radio_7: this.radio_7,
radio_8: this.radio_8,
radio_9: this.radio_9,
radio_10: this.radio_10,
radio_11: this.radio_11,
radio_12: this.radio_12,
comments:this.comments,
others_remarks:this.others_remarks
})
.then((response)=> {
console.log(response);
this.snackbar = true
this.snackbarcolor = "success"
this.snackbartext = "Save Successfully"
setTimeout(() => {
window.location.reload()
}, 2500);

})
}
},

clear_btn(){
this.name_evaluatee = ""
this.name_evaluator = ""
this.dates = ""
this.services = ""
this.radio_1 = ""
this.radio_2 = ""
this.radio_3 = ""
this.radio_4 = ""
this.radio_5 = ""
this.radio_6 = ""
this.radio_7 = ""
this.radio_8 = ""
this.radio_9 = ""
this.radio_10 = ""
this.radio_11 = ""
this.radio_12 = ""
this.comments = ""
this.others_remarks = ""

},
service_dropdown(){
// alert()
axios.post('/change_dropdown',{
office_name: this.office_name
}).then(response => {
this.checkbox_data = response.data.map((item, index) => {
return {
id: index + 1, // Add an ID property if needed
name: item,
checked: false
};
});
console.log(response.data)
})
},

nextStep() {
    if (this.$refs.form.validate()) {
        this.currentStep++;
    }


},
previousStep() {
this.currentStep--;
},

},
})
