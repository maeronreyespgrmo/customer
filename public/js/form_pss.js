let app = new Vue({
el: '#app',
vuetify: new Vuetify(),
data: () => ({
name:"",
checkbox: true,
snackbar:false,
snackbartext:"",
snackbarcolor:"",
isDisabled: false,
showButton:true,
loading:false,
loadingProgress: 0,
isLoading: true,
currentStep: 1,
totalSteps: 16,
dates: "",
date_in:"",
municipality_name:"",
municipal_items:[],
hospital_items:[],
home_address_items:[],
valid:false,
nameRules: [
v => !!v || 'Name is required',
],
date_out:"",
services:"",
hospital_name:"",
hospital_items:["JP-RIZAL","LPH-BAY"],
radio_arr:[],
options_1: [
{ label: 'Walang isang oras(less than 1 hour)', value: '1' },
{ label: 'Isa hangang dalawang oras(1-2 hours)', value: '2' },
{ label: 'tatlo hangang apat na oras(3-4 hours)', value: '3' },
{ label: 'lima hangang anim na oras(5-6 hours)', value: '4' },
{ label: 'pito hangang walong oras(7-8 hours)', value: '5' },
{ label: 'Not Indicated', value: '6' },
// Add more options as needed
],
options_2: [
{ label: 'Walang isang oras(less than 1 hour)', value: '1' },
{ label: 'Isa hangang dalawang oras(1-2 hours)', value: '2' },
{ label: 'tatlo hangang apat na oras(3-4 hours)', value: '3' },
{ label: 'lima hangang anim na oras(5-6 hours)', value: '4' },
{ label: 'pito hangang walong oras(7-8 hours)', value: '5' },
{ label: 'Not Indicated', value: '6' },
// Add more options as needed
],
selectedOptions_1: "",
selectedOptions_2: "",
comments:"",
patient_name:"",
home_address:"",
snackbar:false,
snackbartext:"",
snackbarcolor:"",
menu: false,
menu_date_in: false,
menu_date_out: false,
checkbox_data:[],
radio1_a:"",
radio1_b:"",
radio1_c:"",
radio1_d:"",
radio1_e:"",
radio1_f:"",
radio1_g:"",
radio2_a:"",
radio2_b:"",
radio2_c:"",
radio2_d:"",
radio2_e:"",
radio3_a:"",
radio3_b:"",
radio3_c:"",
radio3_d:"",
radio3_e:"",
radio4_a:"",
radio4_b:"",
radio4_c:"",
radio4_d:"",
radio5_a:"",
radio5_b:"",
radio5_c:"",
radio5_d:"",
radio5_e:"",
radio6_a:"",
radio6_b:"",
radio6_c:"",
radio6_d:"",
radio6_e:"",
radio7_a:"",
radio7_b:"",
radio7_c:"",
radio7_d:"",
radio7_e:"",
radio8_a:"",
radio8_b:"",
radio8_c:"",
radio8_d:"",
radio8_e:"",
radio9_a:"",
radio9_b:"",
radio9_c:"",
radio9_d:"",
radio9_e:"",
radio10_a:"",
radio10_b:"",
radio10_c:"",
radio10_d:"",
radio10_e:"",
radio11_a:"",
radio11_b:"",
radio11_c:"",
radio11_d:"",
radio12_a:"",
radio12_b:"",
radio12_c:"",
radio12_d:"",
radio12_e:"",
radio13_a:"",
radio13_b:"",
radio13_c:"",
radio13_d:"",
radio13_e:"",
radio14_a:"",
radio14_b:"",
radio14_c:"",
radio14_d:"",
radio14_e:"",
invalidated: false,
isVisible:true,
checkradioall_0:null,
checkradioall_1:null,
checkradioall_2:null,
checkradioall_3:null,
checkradioall_4:null,
checkradioall_5:null,
checkradioall_6:null,
checkradioall_7:null,
checkradioall_8:null,
checkradioall_9:null,
checkradioall_10:null,
checkradioall_11:null,
checkradioall_12:null,
checkradioall_13:null,
checkradioall_14:null,
}),

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

    axios.get('/dropdown_hospitals').then(response => {
        console.log(response.data)
        this.hospital_items = response.data.map(x=> x.hospital_name)
    })

    let urrl = window.location.href.split('/')[3];
    let idd =  window.location.href.split('/')[5];

if(urrl === "edit"){
        this.showButton = true
        axios.post('/view_pss',{
        id:idd
        }).then(response => {
        console.log(response.data[0])
        this.patient_name = response.data[0].patient_name??""
        this.dates = response.data[0].date??""
        this.selectedOptions_1 = response.data[0].checked_doctor??""
        this.selectedOptions_2 = response.data[0].before_admit??""
        this.hospital_name = response.data[0].hospital_name??""
        this.date_in = response.data[0].date_in??""
        this.date_out = response.data[0].date_out??""
        this.home_address = response.data[0].home_address??""
        this.radio1_a = response.data[0].radio1_a??""
        this.radio1_b = response.data[0].radio1_b??""
        this.radio1_c = response.data[0].radio1_c??""
        this.radio1_d = response.data[0].radio1_d??""
        this.radio1_e = response.data[0].radio1_e??""
        this.radio1_f = response.data[0].radio1_f??""
        this.radio1_g = response.data[0].radio1_g??""
        this.radio2_a = response.data[0].radio2_a??""
        this.radio2_b = response.data[0].radio2_b??""
        this.radio2_c = response.data[0].radio2_c??""
        this.radio2_d = response.data[0].radio2_d??""
        this.radio2_e = response.data[0].radio2_e??""
        this.radio3_a = response.data[0].radio3_a??""
        this.radio3_b = response.data[0].radio3_b??""
        this.radio3_c = response.data[0].radio3_c??""
        this.radio3_d = response.data[0].radio3_d??""
        this.radio3_e = response.data[0].radio3_e??""
        this.radio4_a = response.data[0].radio3_a??""
        this.radio4_b = response.data[0].radio3_b??""
        this.radio4_c = response.data[0].radio3_c??""
        this.radio4_d = response.data[0].radio3_d??""
        this.radio4_e = response.data[0].radio3_e??""
        this.radio5_a = response.data[0].radio5_a??""
        this.radio5_b = response.data[0].radio5_b??""
        this.radio5_c = response.data[0].radio5_c??""
        this.radio5_d = response.data[0].radio5_d??""
        this.radio5_e = response.data[0].radio5_e??""
        this.radio6_a = response.data[0].radio6_a??""
        this.radio6_b = response.data[0].radio6_b??""
        this.radio6_c = response.data[0].radio6_c??""
        this.radio6_d = response.data[0].radio6_d??""
        this.radio6_e = response.data[0].radio6_e??""
        this.radio7_a = response.data[0].radio7_a??""
        this.radio7_b = response.data[0].radio7_b??""
        this.radio7_c = response.data[0].radio7_c??""
        this.radio7_d = response.data[0].radio7_d??""
        this.radio7_e = response.data[0].radio7_e??""
        this.radio8_a = response.data[0].radio8_a??""
        this.radio8_b = response.data[0].radio7_b??""
        this.radio8_c = response.data[0].radio7_c??""
        this.radio8_d = response.data[0].radio7_d??""
        this.radio8_e = response.data[0].radio7_e??""
        this.radio9_a = response.data[0].radio9_a??""
        this.radio9_b = response.data[0].radio9_b??""
        this.radio9_c = response.data[0].radio9_c??""
        this.radio9_d = response.data[0].radio9_d??""
        this.radio9_e = response.data[0].radio9_e??""
        this.radio10_a = response.data[0].radio10_a??""
        this.radio10_b = response.data[0].radio10_b??""
        this.radio10_c = response.data[0].radio10_c??""
        this.radio10_d = response.data[0].radio10_d??""
        this.radio10_e = response.data[0].radio10_e??""
        this.radio11_a = response.data[0].radio10_a??""
        this.radio11_a = response.data[0].radio11_a??""
        this.radio11_b = response.data[0].radio11_b??""
        this.radio11_c = response.data[0].radio11_c??""
        this.radio11_d = response.data[0].radio11_d??""
        this.radio12_a = response.data[0].radio12_a??""
        this.radio12_b = response.data[0].radio12_b??""
        this.radio12_c = response.data[0].radio12_c??""
        this.radio12_d = response.data[0].radio12_d??""
        this.radio12_e = response.data[0].radio12_e??""
        this.radio13_a = response.data[0].radio13_a??""
        this.radio13_b = response.data[0].radio13_b??""
        this.radio13_c = response.data[0].radio13_c??""
        this.radio13_d = response.data[0].radio13_d??""
        this.radio13_e = response.data[0].radio13_e??""
        this.radio14_a = response.data[0].radio14_a??""
        this.radio14_b = response.data[0].radio14_b??""
        this.radio14_c = response.data[0].radio14_c??""
        this.radio14_d = response.data[0].radio14_d??""
        this.radio14_e = response.data[0].radio14_e??""
        this.comments = response.data[0].comments??""
        this.invalidated = response.data[0].invalidated??""
        })
    }
    else{

    }
},

save_btn(){
if(this.$refs.form.validate()){
let urrl = window.location.href.split('/')[3];
let idd =  window.location.href.split('/')[5];
let url = (urrl === "edit")? "/edit_pss" : "/save_pss"
axios.post(url, {
id: idd,
hospital_name: this.hospital_name,
patient_name: this.patient_name,
home_address: this.home_address,
date: this.dates,
checked_doctor: this.selectedOptions_1,
before_admit: this.selectedOptions_2,
date_in: this.date_in,
date_out: this.date_out,
radio1_a: this.radio1_a,
radio1_b: this.radio1_b,
radio1_c: this.radio1_c,
radio1_d: this.radio1_d,
radio1_e: this.radio1_e,
radio1_f: this.radio1_f,
radio1_g: this.radio1_g,
radio2_a: this.radio2_a,
radio2_b: this.radio2_b,
radio2_c: this.radio2_c,
radio2_d: this.radio2_d,
radio2_e: this.radio2_e,
radio3_a: this.radio3_a,
radio3_b: this.radio3_b,
radio3_c: this.radio3_c,
radio3_d: this.radio3_d,
radio3_e: this.radio3_e,
radio4_a: this.radio4_a,
radio4_b: this.radio4_b,
radio4_c: this.radio4_c,
radio4_d: this.radio4_d,
radio5_a: this.radio5_a,
radio5_b: this.radio5_b,
radio5_c: this.radio5_c,
radio5_d: this.radio5_d,
radio5_e: this.radio5_e,
radio6_a: this.radio6_a,
radio6_b: this.radio6_b,
radio6_c: this.radio6_c,
radio6_d: this.radio6_d,
radio6_e: this.radio6_e,
radio7_a: this.radio7_a,
radio7_b: this.radio7_b,
radio7_c: this.radio7_c,
radio7_d: this.radio7_d,
radio7_e: this.radio7_e,
radio8_a: this.radio8_a,
radio8_b: this.radio8_b,
radio8_c: this.radio8_c,
radio8_d: this.radio8_d,
radio8_e: this.radio8_e,
radio9_a: this.radio9_a,
radio9_b: this.radio9_b,
radio9_c: this.radio9_c,
radio9_d: this.radio9_d,
radio9_e: this.radio9_e,
radio10_a: this.radio10_a,
radio10_b: this.radio10_b,
radio10_c: this.radio10_c,
radio10_d: this.radio10_d,
radio10_e: this.radio10_e,
radio11_a: this.radio11_a,
radio11_b: this.radio11_b,
radio11_c: this.radio11_c,
radio11_d: this.radio11_d,
radio12_a: this.radio12_a,
radio12_b: this.radio12_b,
radio12_c: this.radio12_c,
radio12_d: this.radio12_d,
radio12_e: this.radio12_e,
radio13_a: this.radio13_a,
radio13_b: this.radio13_b,
radio13_c: this.radio13_c,
radio13_d: this.radio13_d,
radio13_e: this.radio13_e,
radio14_a: this.radio14_a,
radio14_b: this.radio14_b,
radio14_c: this.radio14_c,
radio14_d: this.radio14_d,
radio14_e: this.radio14_e,
comments:this.comments,
invalidated:this.invalidated
})
.then((response)=> {
console.log(response);
this.snackbar = true
this.snackbarcolor = "success"
this.snackbartext = "Save Successfully"
setTimeout(() => {
window.location.reload()
}, 1000);
})
}
else{
let urrl = window.location.href.split('/')[3];
let idd =  window.location.href.split('/')[5];
let url = (urrl === "edit")? "/edit_pss" : "/save_pss"
axios.post(url, {
id: idd,
hospital_name: this.hospital_name,
patient_name: this.patient_name,
home_address: this.home_address,
date: this.dates,
checked_doctor: this.selectedOptions_1,
before_admit: this.selectedOptions_2,
date_in: this.date_in,
date_out: this.date_out,
radio1_a: this.radio1_a,
radio1_b: this.radio1_b,
radio1_c: this.radio1_c,
radio1_d: this.radio1_d,
radio1_e: this.radio1_e,
radio1_f: this.radio1_f,
radio1_g: this.radio1_g,
radio2_a: this.radio2_a,
radio2_b: this.radio2_b,
radio2_c: this.radio2_c,
radio2_d: this.radio2_d,
radio2_e: this.radio2_e,
radio3_a: this.radio3_a,
radio3_b: this.radio3_b,
radio3_c: this.radio3_c,
radio3_d: this.radio3_d,
radio3_e: this.radio3_e,
radio4_a: this.radio4_a,
radio4_b: this.radio4_b,
radio4_c: this.radio4_c,
radio4_d: this.radio4_d,
radio5_a: this.radio5_a,
radio5_b: this.radio5_b,
radio5_c: this.radio5_c,
radio5_d: this.radio5_d,
radio5_e: this.radio5_e,
radio6_a: this.radio6_a,
radio6_b: this.radio6_b,
radio6_c: this.radio6_c,
radio6_d: this.radio6_d,
radio6_e: this.radio6_e,
radio7_a: this.radio7_a,
radio7_b: this.radio7_b,
radio7_c: this.radio7_c,
radio7_d: this.radio7_d,
radio7_e: this.radio7_e,
radio8_a: this.radio8_a,
radio8_b: this.radio8_b,
radio8_c: this.radio8_c,
radio8_d: this.radio8_d,
radio8_e: this.radio8_e,
radio9_a: this.radio9_a,
radio9_b: this.radio9_b,
radio9_c: this.radio9_c,
radio9_d: this.radio9_d,
radio9_e: this.radio9_e,
radio10_a: this.radio10_a,
radio10_b: this.radio10_b,
radio10_c: this.radio10_c,
radio10_d: this.radio10_d,
radio10_e: this.radio10_e,
radio11_a: this.radio11_a,
radio11_b: this.radio11_b,
radio11_c: this.radio11_c,
radio11_d: this.radio11_d,
radio12_a: this.radio12_a,
radio12_b: this.radio12_b,
radio12_c: this.radio12_c,
radio12_d: this.radio12_d,
radio12_e: this.radio12_e,
radio13_a: this.radio13_a,
radio13_b: this.radio13_b,
radio13_c: this.radio13_c,
radio13_d: this.radio13_d,
radio13_e: this.radio13_e,
radio14_a: this.radio14_a,
radio14_b: this.radio14_b,
radio14_c: this.radio14_c,
radio14_d: this.radio14_d,
radio14_e: this.radio14_e,
comments:this.comments,
invalidated:this.invalidated
})
.then((response)=> {
console.log(response);
this.snackbar = true
this.snackbarcolor = "success"
this.snackbartext = "Save Successfully"
setTimeout(() => {
window.location.reload()
}, 1000);
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

toggleVisibility() {
this.isVisible = this.invalidated == "yes" ? false : true
this.home_address = ""
this.patient_name = ""
this.selectedOptions_1 = ""
this.selectedOptions_2 = ""
this.date_in = ""
this.date_out = ""
this.radio1_a = ""
this.radio1_b = ""
this.radio1_c = ""
this.radio1_d = ""
this.radio1_e = ""
this.radio1_f = ""
this.radio1_g = ""
this.radio2_a = ""
this.radio2_b = ""
this.radio2_c = ""
this.radio2_d = ""
this.radio2_e = ""
this.radio3_a = ""
this.radio3_b = ""
this.radio3_c = ""
this.radio3_d = ""
this.radio3_e = ""
this.radio4_a = ""
this.radio4_b = ""
this.radio4_c = ""
this.radio4_d = ""
this.radio5_a = ""
this.radio5_b = ""
this.radio5_c = ""
this.radio5_d = ""
this.radio5_e = ""
this.radio6_a = ""
this.radio6_b = ""
this.radio6_c = ""
this.radio6_d = ""
this.radio6_e = ""
this.radio7_a = ""
this.radio7_b = ""
this.radio7_c = ""
this.radio7_d = ""
this.radio7_e = ""
this.radio8_a = ""
this.radio8_b = ""
this.radio8_c = ""
this.radio8_d = ""
this.radio8_e = ""
this.radio9_a = ""
this.radio9_b = ""
this.radio9_c = ""
this.radio9_d = ""
this.radio9_e = ""
this.radio10_a = ""
this.radio10_b = ""
this.radio10_c = ""
this.radio10_d = ""
this.radio10_e = ""
this.radio11_a = ""
this.radio11_b = ""
this.radio11_c = ""
this.radio11_d = ""
this.radio12_a = ""
this.radio12_b = ""
this.radio12_c = ""
this.radio12_d = ""
this.radio12_e = ""
this.radio13_a = ""
this.radio13_b = ""
this.radio13_c = ""
this.radio13_d = ""
this.radio13_e = ""
this.radio14_a = ""
this.radio14_b = ""
this.radio14_c = ""
this.radio14_d = ""
this.radio14_e = ""
this.comments = ""
this.checkradioall_0 = ""
},


nextStep() {
    if (this.$refs.form.validate()) {
        this.currentStep++;
    }
},
previousStep() {
this.currentStep--;
},

toggleCheckall($value){
console.log($value)
    if($value == 1){
        this.radio1_a = this.checkradioall_1
        this.radio1_b = this.checkradioall_1
        this.radio1_c = this.checkradioall_1
        this.radio1_d = this.checkradioall_1
        this.radio1_e = this.checkradioall_1
        this.radio1_f = this.checkradioall_1
        this.radio1_g = this.checkradioall_1
    }
    else if($value == 2){
        this.radio2_a = this.checkradioall_2
        this.radio2_b = this.checkradioall_2
        this.radio2_c = this.checkradioall_2
        this.radio2_d = this.checkradioall_2
        this.radio2_e = this.checkradioall_2
    }
    else if($value == 3){
        this.radio3_a = this.checkradioall_3
        this.radio3_b = this.checkradioall_3
        this.radio3_c = this.checkradioall_3
        this.radio3_d = this.checkradioall_3
        this.radio3_e = this.checkradioall_3
    }
    else if($value == 4){
        this.radio4_a = this.checkradioall_4
        this.radio4_b = this.checkradioall_4
        this.radio4_c = this.checkradioall_4
        this.radio4_d = this.checkradioall_4
    }
    else if($value == 5){
        this.radio5_a = this.checkradioall_5
        this.radio5_b = this.checkradioall_5
        this.radio5_c = this.checkradioall_5
        this.radio5_d = this.checkradioall_5
        this.radio5_e = this.checkradioall_5
    }
    else if($value == 6){
        this.radio6_a = this.checkradioall_6
        this.radio6_b = this.checkradioall_6
        this.radio6_c = this.checkradioall_6
        this.radio6_d = this.checkradioall_6
        this.radio6_e = this.checkradioall_6
    }
    else if($value == 7){
        this.radio7_a = this.checkradioall_7
        this.radio7_b = this.checkradioall_7
        this.radio7_c = this.checkradioall_7
        this.radio7_d = this.checkradioall_7
        this.radio7_e = this.checkradioall_7
    }
    else if($value == 8){
        this.radio8_a = this.checkradioall_8
        this.radio8_b = this.checkradioall_8
        this.radio8_c = this.checkradioall_8
        this.radio8_d = this.checkradioall_8
        this.radio8_e = this.checkradioall_8
    }
    else if($value == 9){
        this.radio9_a = this.checkradioall_9
        this.radio9_b = this.checkradioall_9
        this.radio9_c = this.checkradioall_9
        this.radio9_d = this.checkradioall_9
        this.radio9_e = this.checkradioall_9
    }
    else if($value == 10){
        this.radio10_a = this.checkradioall_10
        this.radio10_b = this.checkradioall_10
        this.radio10_c = this.checkradioall_10
        this.radio10_d = this.checkradioall_10
        this.radio10_e = this.checkradioall_10
    }
    else if($value == 11){
        this.radio11_a = this.checkradioall_11
        this.radio11_b = this.checkradioall_11
        this.radio11_c = this.checkradioall_11
        this.radio11_d = this.checkradioall_11
    }
    else if($value == 12){
        this.radio12_a = this.checkradioall_12
        this.radio12_b = this.checkradioall_12
        this.radio12_c = this.checkradioall_12
        this.radio12_d = this.checkradioall_12
        this.radio12_e = this.checkradioall_12
    }
    else if($value == 13){
        this.radio13_a = this.checkradioall_13
        this.radio13_b = this.checkradioall_13
        this.radio13_c = this.checkradioall_13
        this.radio13_d = this.checkradioall_13
        this.radio13_e = this.checkradioall_13
    }
    else if($value == 14){
        this.radio14_a = this.checkradioall_14
        this.radio14_b = this.checkradioall_14
        this.radio14_c = this.checkradioall_14
        this.radio14_d = this.checkradioall_14
        this.radio14_e = this.checkradioall_14
    }
    else{
        if (this.$refs.form.validate()) {

            this.checkradioall_1 = this.checkradioall_0
            this.checkradioall_2 = this.checkradioall_0
            this.checkradioall_3 = this.checkradioall_0
            this.checkradioall_4 = this.checkradioall_0
            this.checkradioall_5 = this.checkradioall_0
            this.checkradioall_6 = this.checkradioall_0
            this.checkradioall_7 = this.checkradioall_0
            this.checkradioall_8 = this.checkradioall_0
            this.checkradioall_9 = this.checkradioall_0
            this.checkradioall_10 = this.checkradioall_0
            this.checkradioall_11 = this.checkradioall_0
            this.checkradioall_12 = this.checkradioall_0
            this.checkradioall_13 = this.checkradioall_0
            this.checkradioall_14 = this.checkradioall_0

            this.radio1_a = this.checkradioall_0
            this.radio1_b = this.checkradioall_0
            this.radio1_c = this.checkradioall_0
            this.radio1_d = this.checkradioall_0
            this.radio1_e = this.checkradioall_0
            this.radio1_f = this.checkradioall_0
            this.radio1_g = this.checkradioall_0

            this.radio2_a = this.checkradioall_0
            this.radio2_b = this.checkradioall_0
            this.radio2_c = this.checkradioall_0
            this.radio2_d = this.checkradioall_0
            this.radio2_e = this.checkradioall_0

            this.radio3_a = this.checkradioall_0
            this.radio3_b = this.checkradioall_0
            this.radio3_c = this.checkradioall_0
            this.radio3_d = this.checkradioall_0
            this.radio3_e = this.checkradioall_0

            this.radio4_a = this.checkradioall_0
            this.radio4_b = this.checkradioall_0
            this.radio4_c = this.checkradioall_0
            this.radio4_d = this.checkradioall_0

            this.radio5_a = this.checkradioall_0
            this.radio5_b = this.checkradioall_0
            this.radio5_c = this.checkradioall_0
            this.radio5_d = this.checkradioall_0
            this.radio5_e = this.checkradioall_0

            this.radio6_a = this.checkradioall_0
            this.radio6_b = this.checkradioall_0
            this.radio6_c = this.checkradioall_0
            this.radio6_d = this.checkradioall_0
            this.radio6_e = this.checkradioall_0

            this.radio7_a = this.checkradioall_0
            this.radio7_b = this.checkradioall_0
            this.radio7_c = this.checkradioall_0
            this.radio7_d = this.checkradioall_0
            this.radio7_e = this.checkradioall_0

            this.radio8_a = this.checkradioall_0
            this.radio8_b = this.checkradioall_0
            this.radio8_c = this.checkradioall_0
            this.radio8_d = this.checkradioall_0
            this.radio8_e = this.checkradioall_0

            this.radio9_a = this.checkradioall_0
            this.radio9_b = this.checkradioall_0
            this.radio9_c = this.checkradioall_0
            this.radio9_d = this.checkradioall_0
            this.radio9_e = this.checkradioall_0

            this.radio10_a = this.checkradioall_0
            this.radio10_b = this.checkradioall_0
            this.radio10_c = this.checkradioall_0
            this.radio10_d = this.checkradioall_0
            this.radio10_e = this.checkradioall_0

            this.radio11_a = this.checkradioall_0
            this.radio11_b = this.checkradioall_0
            this.radio11_c = this.checkradioall_0
            this.radio11_d = this.checkradioall_0

            this.radio12_a = this.checkradioall_0
            this.radio12_b = this.checkradioall_0
            this.radio12_c = this.checkradioall_0
            this.radio12_d = this.checkradioall_0
            this.radio12_e = this.checkradioall_0

            this.radio13_a = this.checkradioall_0
            this.radio13_b = this.checkradioall_0
            this.radio13_c = this.checkradioall_0
            this.radio13_d = this.checkradioall_0
            this.radio13_e = this.checkradioall_0

            this.radio14_a = this.checkradioall_0
            this.radio14_b = this.checkradioall_0
            this.radio14_c = this.checkradioall_0
            this.radio14_d = this.checkradioall_0
            this.radio14_e = this.checkradioall_0

            this.currentStep = 16
        }
    }
}
},
})
