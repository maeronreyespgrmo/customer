let app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: () => ({
    dialog: false,
    dates: "",
    menu: false,
    office_name:"",
    office_items: [],
    dialog1: false,
    show1: false,
    valid:false,
    search:"",
    selectedOffice:"",
    selectedItemOffice:[],
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
    text: 'Office Name',
    align: 'start',
    sortable: false,
    value: 'office_name',
    },
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
    axios.get('/select_comments_css',{
    nextpage:0,  
    date:this.dates,
    office_name:this.office_name,
    }).then(response => {
      console.log(response)
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
    axios.post('/select_comments_css2',{
    total:this.page_total,
    nextpage:page,
    date:this.dates,
    office_name:this.office_name,
    }).then(response => {
    setTimeout(() => {
    console.log(response.data) 
    this.data = response.data[0].first_array
    this.loader = false
    }, 1500);
    })
    },
    
    activate(item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    axios.post('/activate_comments_css', {
    id: this.editedItem.id,
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
    axios.post('/deactivate_comments_css', {
    id: this.editedItem.id,
    })
    .then((response)=> {
    console.log(response);
    this.snackbar = true
    this.snackbarcolor = "success"
    this.snackbartext = "Success"
    this.initialize()
    })
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

    filter_btn(){
      this.length = 10
      this.loader = true
      axios.post('/search_display_css',{
      nextpage:0,  
      dates:this.dates,
      office_name:this.office_name,
      }).then(response => {
        console.log(response)
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
      axios.post('/select_comments_css2',{
      search:this.search,
      nextpage:0,  
      office_name:this.selectedOffice,
      dates:this.dates,
      office_name:this.office_name,
      }).then(response => {
        console.log(response)
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
    