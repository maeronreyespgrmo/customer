let app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: () => ({
    dialog: false,
    dates: "",
    menu: false,
    hospital_name:"",
    isButtonDisabled: false,
    hospital_items: [],
    dialog1: false,
    show1: false,
    valid:false,
    search:"",
    length_val:'',
    loading_text:'loading',
    total_res:'',
    total_count:'',
    uploadedfile:'',
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
    text: 'Patient Name',
    align: 'start',
    sortable: false,
    value: 'patient_name',
    },
    {
    text: 'Home Addresss',
    align: 'start',
    sortable: false,
    value: 'home_address',
    },
    {
    text: 'Date',
    align: 'start',
    sortable: false,
    value: 'date',
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
    axios.get('/select_import_pss',{
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

    axios.get('/dropdown_hospitals').then(response => {
       this.hospital_items =  response.data.map(x=> x.hospital_name)
      // console.log("dp",response.data.map(x=> x.office_name))
      })

    },
    next(page){
    console.log(page)
    this.loader = true
    this.loading_text = "wew"
    axios.post('/select_import_pss2',{
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
    window.location.href=`/view/pss/${this.editedItem.id}`
    },
    
    deleteItem (item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    this.dialogDelete = true
    },
    
    deleteItemConfirm () {
    // this.data.splice(this.editedIndex, 1)
    // axios.post('/delete_services', {
    // id: this.editedItem.id,
    // })
    // .then((response)=> {
    // console.log(response);
    // this.snackbar = true
    // this.snackbarcolor = "success"
    // this.snackbartext = "Delete Successfully"
    // this.initialize();
    // })
    // this.closeDelete()
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
    
    export_btn(){
      let year = this.dates.split("-")[0]
      let month = this.dates.split("-")[1]
      window.location.href = `/reports1/pss/${this.dates}/${year}/${month}/${this.hospital_name}`
    },

    upload(e){
    this.uploadedfile = e.target.files[0]

    },

    save_btn(){
var reader = new FileReader();
reader.onload = function (e) {
var data = new Uint8Array(e.target.result);
var workbook = XLSX.read(data, { type: 'array' });
var sheetName = workbook.SheetNames[0];
var worksheet = workbook.Sheets[sheetName];
var jsonData = XLSX.utils.sheet_to_json(worksheet, {raw:false,dateNF:'yyyy-mm-dd'});
console.log(jsonData)
let arr = []
Array.from({ length: jsonData.length  }).map((_, index) => {

  if (worksheet && worksheet[`C${index+2}`].v !== undefined) {
    // Access cell.v safely
    console.log(worksheet[`C${index+2}`]['v']) 
  } 

  // let arr_values = 
  // {
  // date: worksheet[`B${index+2}`].w,
  // patient_name:worksheet[`C${index+2}`].w,
  // home_address:worksheet[`D${index+2}`].w,
  // date_in:worksheet[`E${index+2}`].w,
  // date_out:worksheet[`F${index+2}`].w,
  // checked_doctor:worksheet[`G${index+2}`].w,
  // before_admit:worksheet[`H${index+2}`].w,
  // radio1_a:worksheet[`I${index+2}`].w,
  // radio1_b:worksheet[`J${index+2}`].w,
  // radio1_c:worksheet[`K${index+2}`].w,
  // radio1_d:worksheet[`L${index+2}`].w,
  // radio1_e:worksheet[`M${index+2}`].w,
  // radio1_f:worksheet[`N${index+2}`].w,
  // radio1_g:worksheet[`O${index+2}`].w,
  // radio2_a:worksheet[`P${index+2}`].w,
  // radio2_b:worksheet[`Q${index+2}`].w,
  // radio2_c:worksheet[`R${index+2}`].w,
  // radio2_d:worksheet[`S${index+2}`].w,
  // radio2_e:worksheet[`T${index+2}`].w,
  // radio3_a:worksheet[`U${index+2}`].w,
  // radio3_b:worksheet[`V${index+2}`].w,
  // radio3_c:worksheet[`W${index+2}`].w,
  // radio3_d:worksheet[`X${index+2}`].w,
  // radio3_e:worksheet[`Y${index+2}`].w,
  // radio4_a:worksheet[`Z${index+2}`].w,
  // radio4_b:worksheet[`AA${index+2}`].w,
  // radio4_c:worksheet[`AB${index+2}`].w,
  // radio4_d:worksheet[`AC${index+2}`].w,
  // radio5_a:worksheet[`AD${index+2}`].w,
  // radio5_b:worksheet[`AE${index+2}`].w,
  // radio5_c:worksheet[`AF${index+2}`].w,
  // radio5_d:worksheet[`AG${index+2}`].w,
  // radio5_e:worksheet[`AH${index+2}`].w,
  // radio6_a:worksheet[`AI${index+2}`].w,
  // radio6_b:worksheet[`AJ${index+2}`].w,
  // radio6_c:worksheet[`AK${index+2}`].w,
  // radio6_d:worksheet[`AL${index+2}`].w,
  // radio6_e:worksheet[`AM${index+2}`].w,
  // radio7_a:worksheet[`AN${index+2}`].w,
  // radio7_b:worksheet[`AO${index+2}`].w,
  // radio7_c:worksheet[`AP${index+2}`].w,
  // radio7_d:worksheet[`AQ${index+2}`].w,
  // radio7_e:worksheet[`AR${index+2}`].w,
  // radio8_a:worksheet[`AS${index+2}`].w,
  // radio8_b:worksheet[`AT${index+2}`].w,
  // radio8_c:worksheet[`AU${index+2}`].w,
  // radio8_d:worksheet[`AV${index+2}`].w,
  // radio8_e:worksheet[`AW${index+2}`].w,
  // radio9_a:worksheet[`AX${index+2}`].w,
  // radio9_b:worksheet[`AY${index+2}`].w,
  // radio9_c:worksheet[`AZ${index+2}`].w,
  // radio9_d:worksheet[`BA${index+2}`].w,
  // radio9_e:worksheet[`BB${index+2}`].w,
  // radio10_a:worksheet[`BC${index+2}`].w,
  // radio10_b:worksheet[`BD${index+2}`].w,
  // radio10_c:worksheet[`BE${index+2}`].w,
  // radio10_d:worksheet[`BF${index+2}`].w,
  // radio10_e:worksheet[`BG${index+2}`].w,
  // radio11_a:worksheet[`BH${index+2}`].w,
  // radio11_b:worksheet[`BI${index+2}`].w,
  // radio11_c:worksheet[`BJ${index+2}`].w,
  // radio11_d:worksheet[`BK${index+2}`].w,
  // radio12_a:worksheet[`BL${index+2}`].w,
  // radio12_b:worksheet[`BM${index+2}`].w,
  // radio12_c:worksheet[`BN${index+2}`].w,
  // radio12_d:worksheet[`BO${index+2}`].w,
  // radio12_e:worksheet[`BP${index+2}`].w,
  // radio13_a:worksheet[`BQ${index+2}`].w,
  // radio13_b:worksheet[`BR${index+2}`].w,
  // radio13_c:worksheet[`BS${index+2}`].w,
  // radio13_d:worksheet[`BT${index+2}`].w,
  // radio13_e:worksheet[`BU${index+2}`].w,
  // radio14_a:worksheet[`BV${index+2}`].w,
  // radio14_b:worksheet[`BW${index+2}`].w,
  // radio14_c:worksheet[`BX${index+2}`].w,
  // radio14_d:worksheet[`BY${index+2}`].w,
  // radio14_e:worksheet[`BZ${index+2}`].w,
  // comments:worksheet[`CA${index+2}`].w
  // }
  // arr.push(arr_values)
});




// workbook.SheetNames.map((_,y)=> {
// var sheetName = workbook.SheetNames[y];
// var worksheet = workbook.Sheets[sheetName];
// var jsonData = XLSX.utils.sheet_to_json(worksheet, {raw:false,dateNF:'yyyy-mm-dd'});
// console.log(JSON.stringify(jsonData))
// let ff = [
//           'Timestamp',
//          ]


// let final = jsonData.map(x=> Object.keys(x).filter((a,b)=>!ff.includes(a)).reduce((a,b)=> {
//             a[b] = x[b]
//             return a
//             },{}))

//             console.log("final",jsonData)
   


//   let names = final.map(x=> Object.keys(x))[0]
//   let new_names = [
//     "date",
//     "patient_name",
//     "home_address",
//     "date_in",
//     "date_out",
//     "checked_doctor",
//     "before_admit",
//     "radio1_a",
//     "radio1_b",
//     "radio1_c",
//     "radio1_d",
//     "radio1_e",
//     "radio1_f",
//     "radio1_g",
//     "radio2_a",
//     "radio2_b",
//     "radio2_c",
//     "radio2_d",
//     "radio2_e",
//     "radio3_a",
//     "radio3_b",
//     "radio3_c",
//     "radio3_d",
//     "radio3_e",
//     "radio4_a",
//     "radio4_b",
//     "radio4_c",
//     "radio4_d",
//     "radio5_a",
//     "radio5_b",
//     "radio5_c",
//     "radio5_d",
//     "radio5_e",
//     "radio6_a",
//     "radio6_b",
//     "radio6_c",
//     "radio6_d",
//     "radio6_e",
//     "radio7_a",
//     "radio7_b",
//     "radio7_c",
//     "radio7_d",
//     "radio7_e",
//     "radio8_a",
//     "radio8_b",
//     "radio8_c",
//     "radio8_d",
//     "radio8_e",
//     "radio9_a",
//     "radio9_b",
//     "radio9_c",
//     "radio9_d",
//     "radio9_e",
//     "radio10_a",
//     "radio10_b",
//     "radio10_c",
//     "radio10_d",
//     "radio10_e",
//     "radio11_a",
//     "radio11_b",
//     "radio11_c",
//     "radio11_d",
//     "radio12_a",
//     "radio12_b",
//     "radio12_c",
//     "radio12_d",
//     "radio12_e",
//     "radio13_a",
//     "radio13_b",
//     "radio13_c",
//     "radio13_d",
//     "radio13_e",
//     "radio14_a",
//     "radio14_b",
//     "radio14_c",
//     "radio14_d",
//     "radio14_e",
//     "comments"]
//   final.map((_,b)=>{
//     names.map((_,y)=>{
//       final[b][new_names[y]] = final[b][names[y]]
//       delete final[b][names[y]];
//     })
//   })

  


  
  
//   console.log(workbook.SheetNames)
//   app.isButtonDisabled = true
//         setTimeout(() => {
//           axios.post('/import_pss', {
//             arr: final,
//             hospital_name:workbook.SheetNames[y].split("_")[1],
//             len:final.map(x=>Object.values(x)).length,
//             })
//             .then((response)=> {
//             // console.log(response);
//             this.snackbar = true
//             this.snackbarcolor = "success"
//             this.snackbartext = "Import Successful"
//             app.initialize()
//             app.dialog1 = false
//             app.isButtonDisabled = false
//             })
//         }, 1500);
// })
},
reader.readAsArrayBuffer(this.uploadedfile);
    },

    search_btn(){
      this.loader = true
      axios.post('/select_import_pss2',{
      search:this.search,
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
    