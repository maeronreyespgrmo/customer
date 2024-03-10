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
    selectedHospital:"",
    selectedItemHospital:[],
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
       this.selectedItemHospital =  response.data.map(x=> x.hospital_name)
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
    // window.location.href=`/view/pss/${this.editedItem.id}`
    window.open(`/view/pss/${this.editedItem.id}`, '_blank');
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
workbook.SheetNames.map((_,y)=> {
var sheetName = workbook.SheetNames[y];
var worksheet = workbook.Sheets[sheetName];
var jsonData = XLSX.utils.sheet_to_json(worksheet, {raw:false,dateNF:'yyyy-mm-dd'});
// console.log(jsonData)
let ff = [
          'Timestamp',
         ]


let final = jsonData.map(x=> Object.keys(x).filter((a,b)=>!ff.includes(a)).reduce((a,b)=> {
            a[b] = x[b]
            return a
            },{}))

// let final = jsonData.map(x=> Object.keys(x).filter((a,b)=>!ff.includes(a)).map(a=> a.replace(/\t/g, ' ')).map(x=> sort_ff.indexOf(x)))[0]


        


  let names = final.map(x=> Object.keys(x))[0]
  let new_names = [
    "date",
    "patient_name",
    "home_address",
    "date_in",
    "date_out",
    "checked_doctor",
    "before_admit",
    "radio1_a",
    "radio1_b",
    "radio1_c",
    "radio1_d",
    "radio1_e",
    "radio1_f",
    "radio1_g",
    "radio2_a",
    "radio2_b",
    "radio2_c",
    "radio2_d",
    "radio2_e",
    "radio3_a",
    "radio3_b",
    "radio3_c",
    "radio3_d",
    "radio3_e",
    "radio4_a",
    "radio4_b",
    "radio4_c",
    "radio4_d",
    "radio5_a",
    "radio5_b",
    "radio5_c",
    "radio5_d",
    "radio5_e",
    "radio6_a",
    "radio6_b",
    "radio6_c",
    "radio6_d",
    "radio6_e",
    "radio7_a",
    "radio7_b",
    "radio7_c",
    "radio7_d",
    "radio7_e",
    "radio8_a",
    "radio8_b",
    "radio8_c",
    "radio8_d",
    "radio8_e",
    "radio9_a",
    "radio9_b",
    "radio9_c",
    "radio9_d",
    "radio9_e",
    "radio10_a",
    "radio10_b",
    "radio10_c",
    "radio10_d",
    "radio10_e",
    "radio11_a",
    "radio11_b",
    "radio11_c",
    "radio11_d",
    "radio12_a",
    "radio12_b",
    "radio12_c",
    "radio12_d",
    "radio12_e",
    "radio13_a",
    "radio13_b",
    "radio13_c",
    "radio13_d",
    "radio13_e",
    "radio14_a",
    "radio14_b",
    "radio14_c",
    "radio14_d",
    "radio14_e",
    "comments"]
  final.map((_,b)=>{
    names.map((_,y)=>{
      final[b][new_names[y]] = final[b][names[y]]
      delete final[b][names[y]];
    })
  })

  
  
  console.log(workbook.SheetNames)
  app.isButtonDisabled = true
        setTimeout(() => {
          axios.post('/import_pss', {
            arr: final,
            hospital_name:workbook.SheetNames[y].split("_")[1],
            len:final.map(x=>Object.values(x)).length,
            })
            .then((response)=> {
            // console.log(response);
            this.snackbar = true
            this.snackbarcolor = "success"
            this.snackbartext = "Import Successful"
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
      axios.post('/select_import_pss2',{
      search:this.search,
      hospital_name:this.selectedHospital,
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
    