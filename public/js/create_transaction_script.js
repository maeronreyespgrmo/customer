let app = new Vue({
el: '#app',
vuetify: new Vuetify(),
data: () => ({
name:"",
checkbox: true,
dates: "",
services:"",
radio_arr:[],
comments:"",
name_evaluator:"",
name_evaluatee:"",
id:"",
menu: false,
checkbox_data:[],
data:[
{
name: 1,
calories: "Training Computer Graphics",
},
{
name: 2,
calories: "Training Computer Graphics",
},
],
test:[],
data_delivery:[],
// data_delivery:[
// {
// table_title: ["Serbisyo Title",1,2,3,4],
// value: [
// {
// table_question:["How satisfied are you overall with the service you recieved?"],
// table_value:[1,2,3,4],
// },
// {
// table_question:["How satisfied are you with the speed in which the service was delivered?"],
// table_value:[1,2,3,4],   
// },
// ]
// },
// {
// table_title: ["Communications",1,2,3,4],
// value: [
// {
// table_question:["How satisfied are you with the ease of contacting the person you needed?"],
// table_value:[1,2,3,4],
// },
// {
// table_question:["How satisfied are you with the clarity of information or advice provided?"],
// table_value:[1,2,3,4],   
// },
// {
// table_question:["How satisfied are you with the time taken to respond to inquiries?"],
// table_value:[1,2,3,4],   
// },
// ]
// },
// {
// table_title: ["Quality of Staff",1,2,3,4],
// value: [
// {
// table_question:["How satisfied are you with the relevant knowledge of the staff you dealt directly with?"],
// table_value:[1,2,3,4],
// },
// {
// table_question:["How satisfied are you with the courtesy of the staff?"],
// table_value:[1,2,3,4],   
// },
// {
// table_question:["How satisfied are you with the helpfullness of the staff?"],
// table_value:[1,2,3,4],   
// },
// {
// table_question:["How satisfied are you that the staff showed interest in you as an individual/treated you as a valued customer?"],
// table_value:[1,2,3,4],   
// },
// ]
// },
// {
// table_title: ["Problem Solving",1,2,3,4],
// value: [
// {
// table_question:["How satisfied are you with the quality of work/service by the staff you dealt directly with in terms of accuracy and completeness?"],
// table_value:[1,2,3,4],
// },
// {
// table_question:["How satisfied are you with the works undertaken?"],
// table_value:[1,2,3,4],   
// },
// ]
// }
// ],
header_answer:[1,2],
snackbar:false,
snackbartext:"",  
snackbarcolor:"", 
}),

created () {
this.initialize()
},

methods: {
initialize () {


axios.get('/service_dropdown').then(response => {
this.checkbox_data = response.data.map((item, index) => {
return { 
id: index + 1, // Add an ID property if needed
name: item,
checked: false 
};
});
console.log(response.data)
})

axios.get('/data_delivery_arr').then(response => {
this.test = response.data
console.log(response.data.map(x=> x.table_title))

const arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
const count_arr = [1,2,4,2,1]
const newArr = [];

let xx = this.test.map(x=> x.value.length).map(x=> {
    newArr.push(arr.splice(0, x)); 
})
console.log("New Arr",newArr)

this.radio_arr.push([1,2],[3,4],[5,6,7,8,9],[10],[11])
})


let currentUrl = window.location.href.split("/").filter((x,y)=> y==3).join()
let test_id = +window.location.href.split("/").filter((x,y)=> y==4).join()
console.log(test_id);
if(currentUrl == "edit_transaction"){
axios.post('/edit_transaction_arr', {
testid: test_id
})
.then((response)=> {
this.name_evaluatee = response.data[0].name_evaluatee
this.name_evaluator = response.data[0].name_evaluator
this.dates = response.data[0].date
this.services = response.data[0].service_name
console.log(response);
})
}
console.log(currentUrl);
},
btn_submit() {
console.log("yey",Object.values(this.radio_arr))

let currentUrl = window.location.href.split("/").filter((x,y)=> y==3).join()
let url

if(currentUrl == "edit_transaction"){
url = "edit_transaction"
}
else{
url = "save_transaction"
}

console.log(this.radio_arr,url)

axios.post(url, {
id: this.id,
name_evaluatee: this.name_evaluatee, 
name_evaluator: this.name_evaluator, 
date: this.dates, 
services: this.services,
answer: this.radio_arr.flat(),
comments:this.comments 
})
.then((response)=> {
console.log(response);
this.snackbar = true
this.snackbarcolor = "success"
this.snackbartext = "Save Successfully"

})
},
wew(item){
console.log(item)   
}
},
})
