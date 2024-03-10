let app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: () => ({
    dialog: false,
    dates: "",
    menu: false,
    hospital_name:"",
    hospital_items: [],
    dialog1: false,
    show1: false,
    valid:false,
    search:"",
    selectedHospital:"",
    selectedItemHospital:[],
    length_val:'',
    loading_text:'loading',
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
    {
    text: 'Comments',
    align: 'start',
    sortable: false,
    value: 'comments',
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
    axios.get('/select_comments_pss',{
    nextpage:0,
    hospital_name:this.selectedHospital 
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
    axios.post('/select_comments_pss2',{
    total:this.page_total,
    nextpage:page,
    dates:this.dates,
    hospital_name:this.selectedHospital
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
    },
    
    deleteItem (item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    this.dialogDelete = true
    },

    activate(item) {
      this.editedIndex = this.data.indexOf(item)
      this.editedItem = Object.assign({}, item)
      console.log(this.editedItem.id)
      axios.post('/activate_comments_pss', {
      idd: this.editedItem.id,
      })
      .then((response)=> {
      console.log(response);
      this.snackbar = true
      this.snackbarcolor = "success"
      this.snackbartext = "Success"
      this.initialize()
      })
      },
  
      deactivate(item) {
   
      this.editedIndex = this.data.indexOf(item)
      this.editedItem = Object.assign({}, item)

      axios.post('/deactivate_comments_pss', {
      idd: this.editedItem.id,
      })
      .then((response)=> {
      console.log(response);
      this.snackbar = true
      this.snackbarcolor = "success"
      this.snackbartext = "Success"
      this.initialize()
      })
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
    
    filter_btn(){
      axios.post('/search_display_pss',{
      nextpage:0,
      dates:this.dates,
      hospital_name:this.hospital_name
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
    search_btn(){
      this.length = 10
      this.loader = true
      axios.post('/select_comments_pss2',{
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
    },
    })
    