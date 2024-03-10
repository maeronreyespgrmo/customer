let app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: () => ({
    dialog: false,
    show1: false,
    valid:false,
    search:"",
    length_val:'',
    loading_text:'loading',
    total_res:'',
    hospital_items:[],
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
    user_type_item:["Manager","Supervisor"],
    nameRules: [
      v => !!v || 'This is required',
    ],
    headers: [
    {
    text: 'Doctor Name',
    align: 'start',
    sortable: false,
    value: 'doctor_name',
    },
    {
    text: 'Position',
    align: 'start',
    sortable: false,
    value: 'position',
    },
    {
    text: 'Hospital Name',
    align: 'start',
    sortable: false,
    value: 'hospital_name',
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

    axios.get('/dropdown_hospitals').then(response => {
    console.log(response.data.map(x=> x.hospital_name))
    this.hospital_items = response.data.map(x=> x.hospital_name)
    })
        

    axios.get('/select_doctor',{
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
    },
    next(page){
    console.log(page)
    this.loader = true
    this.loading_text = "wew"
    axios.post('/select_doctor2',{
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
    this.dialog = true
    },
    
    deleteItem (item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    this.dialogDelete = true
    },
    
    deleteItemConfirm () {
    // this.data.splice(this.editedIndex, 1)
    axios.post('/delete_doctor', {
    idd: this.editedItem.id,
    })
    .then((response)=> {
    console.log(response);
    this.snackbar = true
    this.snackbarcolor = "success"
    this.snackbartext = "Delete Successfully"
    this.initialize();
    })
    this.closeDelete()
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
    
    save () {
    let url
    if(this.$refs.form.validate()){
    if (this.editedIndex > -1) {
    Object.assign(this.data[this.editedIndex], this.editedItem)
    url ="/update_doctor"
    }
    else {
    url ="/save_doctor"
    this.data.push({
    hospital_name: this.editedItem.hospital_name,
    doctor_name: this.editedItem.doctor_name,
    position: this.editedItem.position,
    })
    }
    console.log(url)
    axios.post(url, {
    id: this.editedItem.id,
    hospital_name: this.editedItem.hospital_name,
    doctor_name: this.editedItem.doctor_name,
    position: this.editedItem.position,
    })
    .then((response)=> {
    console.log(response);
    this.snackbar = true
    this.snackbarcolor = "success"
    this.snackbartext = "Success"
    })
    this.close()
    }
    else{
    
    }
    },  
    getColor (status) {
    if (status == "Inactive")     'grey'
        else return 'green'
    },
    search_btn(){
      this.length = 10
      this.loader = true
      axios.post('/select_doctor2',{
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
    },
    },
    })
    