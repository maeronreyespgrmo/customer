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
services_external:[],
services_internal:[],
radio_arr:[],
office_name:"",
office_items:[],
comments:"",
valid:false,
nameRules: [
v => !!v || 'Name is required',
],
emailRules: [
v => !!v || 'E-mail is required',
v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
],
checkbox_data:[],
checkbox_data_external:[],
checkbox_data_internal:[],
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
email:'',
age:'',
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

axios.get('/office_dropdown_csm').then(response => {
this.office_items = response.data.map(x=> x.office_name)
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
this.dates = response.data[0].date
this.gender = response.data[0].gender
this.age = response.data[0].age
this.services = [response.data[0].service_name]
this.cc1 = response.data[0].cc1
this.cc2 = response.data[0].cc2
this.cc3 = response.data[0].cc3
this.sqd0 = response.data[0].sqd0
this.sqd1 = response.data[0].sqd1
this.sqd2 = response.data[0].sqd2
this.sqd3 = response.data[0].sqd3
this.sqd4 = response.data[0].sqd4
this.sqd5 = response.data[0].sqd5
this.sqd6 = response.data[0].sqd6
this.sqd7 = response.data[0].sqd7
this.sqd8 = response.data[0].sqd8
this.comments = response.data[0].comments
this.email = response.data[0].email

axios.post('/change_dropdown_csm',{
office_name: response.data[0].office_name
}).then(response => {
let external = response.data.filter(x=> x.service_type == "0").map(x=> x)
console.log(external)
// this.checkbox_data = response.data.map((item, index) => {
// return {
// id: index + 1, // Add an ID property if needed
// name: item,
// checked: false
// };
// });
// console.log(response.data)
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
let url = (urrl === "edit")? "/edit_csm" : "/save_csm"

console.log(url)
// console.log(this.services.join(","))
axios.post(url, {
id: idd,
office_name: this.office_name,
client_type: this.client_type,
date: this.dates,
gender: this.gender,
age: this.age,
services_internal: this.services_internal,
services_external: this.services_external,
cc1: this.cc1,
cc2: this.cc2,
cc3: this.cc3,
sqd0: this.sqd0,
sqd1: this.sqd1,
sqd2: this.sqd2,
sqd3: this.sqd3,
sqd4: this.sqd4,
sqd5: this.sqd5,
sqd6: this.sqd6,
sqd7: this.sqd7,
sqd8: this.sqd8,
comments: this.comments,
email: this.email,
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
}

},
service_dropdown(){
// alert()
axios.post('/change_dropdown_csm',{
office_name: this.office_name
}).then(response => {
let external = response.data.filter(x=> x.service_type == "0").map(x=> x.service_name)
let internal = response.data.filter(x=> x.service_type == "1").map(x=> x.service_name)

this.checkbox_data_external = external.map((item, index) => {
return {
id: index + 1, // Add an ID property if needed
name: item,
checked: false
};
});

this.checkbox_data_internal = internal.map((item, index) => {
return {
id: index + 1, // Add an ID property if needed
name: item,
checked: false
};
});

})

},

},
})
