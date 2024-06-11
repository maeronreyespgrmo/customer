let app = new Vue({
el: '#app',
vuetify: new Vuetify(),
data: () => ({
showButton:true,
loading:false,
loadingProgress: 0,
isLoading: true,
snackbar:false,
snackbartext:"",
snackbarcolor:"",
selectedOption1:'',
sqd: ['1', '2', '3', '4', '5', '6'],
menu: false,
isDisabled: false,
dates: "",
others_remarks:"",
services:[],
radio_arr:[],
office_name:"",
office_items:[],
comments:"",
valid:false,
nameRules: [
v => !!v || 'Name is required',
],
checkbox_data:[],
radio_1:"",
radio_2:"",
checkradioall:null,
client_type:null,
gender:'',
cc1:'',
cc2:'',
cc3:'',
sqd0:'',
sqd1:'',
sqd2:'',
sqd3:'',
sqd4:'',
sqd5:'',
sqd6:'',
sqd7:'',
sqd8:'',
comments:'',
email:''
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
axios.post('/view_csm',{
id:idd
}).then(response => {
console.log(response.data)

this.office_name = response.data[0].office_name
this.client_type = response.data[0].client_type
this.date = response.data[0].date
this.gender = response.data[0].gender
this.age = response.data[0].age
this.services = response.data[0].service_id
this.cc1 = response.data[0].cc1
this.cc2 = response.data[0].cc2
this.cc3 = response.data[0].cc3

axios.post('/change_dropdown',{
office_name: response.data[0].office_name
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

})

}
else{

}

console.log("office_name",this.office_name)

},


save_btn(){
if(this.$refs.form.validate()){
let urrl = window.location.href.split('/')[3];
let idd =  window.location.href.split('/')[5];
let url = (urrl === "edit")? "/edit_css" : "/save_css"

console.log(url)

// console.log(this.services.join(","))
axios.post(url, {
id: idd,
office_name: this.office_name,
name_evaluatee: this.name_evaluatee,
name_evaluator: this.name_evaluator,
})
.then((response)=> {
console.log(response);
this.snackbar = true
this.snackbarcolor = "success"
this.snackbartext = "Save Successfully"
this.valid = false
setTimeout(() => {
this.valid = true
// window.location.reload()
}, 5000);

})
}
},

clear_btn(){
var isConfirmed = window.confirm("Are you sure you want to clear the form");

// Check the user's choice
if (isConfirmed) {
alert("Yes, clearing..");
window.location.reload()

} else {
alert("No, Im staying...");
// Add logic to perform actions on 'No' confirmation or simply do nothing
}



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


},
})
