let app = new Vue({
el: '#app',
vuetify: new Vuetify(),
data: () => ({
dialog: false,
dates: "",
menu: false,
office_name:"",
office_items: [],
isButtonDisabled: false,
dialog1: false,
selectedOffice:"",
selectedItemOffice:[],
show1: false,
valid:false,
search:"",
test:'',
length_val:'',
loading_text:'loading',
uploadedfile:'',
total_res:'',
total_count:'',
page_total:'',
dialogDelete: false,
snackbar:false,
snackbartext:"",
snackbarcolor:"",
loader:true,
page: 1,
itemsPerPage: 1,
loader_text:"Now loading..",
name: '',
nameRules: [
v => !!v || 'Name is required',
],
headers: [
{
text: 'ID ',
align: 'start',
sortable: false,
value: 'id',
},
{
text: 'Office Name',
align: 'start',
sortable: false,
value: 'office_name',
},
// {
// text: 'Services',
// align: 'start',
// sortable: false,
// value: 'service_name',
// },
{
text: 'Name of Evalualator',
align: 'start',
sortable: false,
value: 'name_evaluator',
},
{
text: 'Name of Evaluatee',
align: 'start',
sortable: false,
value: 'name_evaluatee',
},
{
text: 'Date',
align: 'start',
sortable: false,
value: 'date',
},
{
text: 'Invalidated?',
align: 'start',
sortable: false,
value: 'invalidated',
},
{ text: 'Actions', value: 'actions', sortable: false },
],
data: [],
editedIndex: -1,
editedItem: {
name: '',
calories: 0,
fat: 0,
carbs: 0,
protein: 0,
},
defaultItem: {
name: '',
calories: 0,
fat: 0,
carbs: 0,
protein: 0,
},
}),

computed: {
formTitle () {
return this.editedIndex === -1 ? 'Create Item' : 'Edit Item'
},
pageCount() {
return Math.ceil(this.page_total / this.itemsPerPage)
// return this.itemsPerPage / this.totalRecords
},
},

watch: {
dialog (val) {
val || this.close()
},
dialogDelete (val) {
val || this.closeDelete()
},
},

created () {
this.initialize()
},

methods: {
initialize () {
this.length = 10
this.loader = true
axios.get('/select_import_css',{
nextpage:0  
}).then(response => {
setTimeout(() => {
this.data = response.data[0].first_array
this.page_total = response.data[0].last_array
let length_val = this.data.length
this.total_count  = Math.ceil(length_val/2)
this.length_val =  this.total_count
this.loader = false
}, 1500);
})

axios.get('/dropdown_offices').then(response => {
this.office_items =  response.data.map(x=> x.office_name)
this.selectedItemOffice =  response.data.map(x=> x.office_name)
console.log("dp",response.data.map(x=> x.office_name))
})

},
next(page){
console.log(page)
this.loader = true
this.loading_text = "wew"
axios.post('/select_import_css2',{
search:this.search,
total:this.page_total,
nextpage:page
}).then(response => {
setTimeout(() => {
console.log(response.data) 
this.data = response.data[0].first_array
this.loader = false
}, 1500);
})
},

editItem (item) {
this.editedIndex = this.data.indexOf(item)
this.editedItem = Object.assign({}, item)
// this.dialog = true
window.open(`/view/css/${this.editedItem.id}`, '_blank');
// window.location.href=`/view/css/${this.editedItem.id}`
},

deleteItem (item) {
this.editedIndex = this.data.indexOf(item)
this.editedItem = Object.assign({}, item)
this.dialogDelete = true
},

deleteItemConfirm () {

},

close () {
this.dialog = false
this.$nextTick(() => {
this.editedItem = Object.assign({}, this.defaultItem)
this.editedIndex = -1
})
},

closeDelete () {
this.dialogDelete = false
this.$nextTick(() => {
this.editedItem = Object.assign({}, this.defaultItem)
this.editedIndex = -1
})
},

upload(e){
this.uploadedfile = e.target.files[0]

},

save_btn(){
var reader = new FileReader();
reader.onload = function (e) {
var data = new Uint8Array(e.target.result);
var workbook = XLSX.read(data, { type: 'array' });
workbook.SheetNames.map((_,y)=> {
var sheetName = workbook.SheetNames[y];
var worksheet = workbook.Sheets[sheetName];
var jsonData = XLSX.utils.sheet_to_json(worksheet, {raw:false,dateNF:'yyyy-mm-dd'});
console.log(jsonData)
let ff = [
          'Timestamp',
          '_EMPTY'
         ]

let final = jsonData.map(x=> Object.keys(x).filter((a,b)=>!ff.includes(a)).reduce((a,b)=> {
            a[b] = x[b]
            return a
            },{}))
         

          let names = final.map(x=> Object.keys(x))[0]
          let new_names = [
            "date",
            "name_evaluator",
            "name_evaluatee",
            "services_id",
            "radio_1",
            "radio_2",
            "radio_3",
            "radio_4",
            "radio_5",
            "radio_6",
            "radio_7",
            "radio_8",
            "radio_9",
            "radio_10",
            "radio_11",
            "radio_12",
            "comments"]
          final.map((_,b)=>{
            names.map((_,y)=>{
              final[b][new_names[y]] = final[b][names[y]]
              delete final[b][names[y]];
            })
          })
         console.log(final[0])
         app.isButtonDisabled = true
         
        setTimeout(() => {
          axios.post('/import_css', {
            arr: final,
            office_name:workbook.SheetNames[y].split("-")[1],
            len:final.map(x=>Object.values(x)).length,
            })
            .then((response)=> {
            console.log(response);
            app.initialize()
            app.dialog1 = false
            app.isButtonDisabled = false
            })
        }, 1500);

})
},
reader.readAsArrayBuffer(this.uploadedfile);
},
search_btn(){
this.loader = true
axios.post('/select_import_css2',{
search:this.search,
office_name:this.selectedOffice,
nextpage:0  
}).then(response => {
setTimeout(() => {
this.data = response.data[0].first_array
this.page_total = response.data[0].last_array
let length_val = this.data.length
this.total_count  = Math.ceil(length_val/2)
this.length_val =  this.total_count
this.loader = false
}, 1500);
})
}
}
})
