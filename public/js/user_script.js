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
    total_count:'',
    total_records:'',
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
      v => !!v || 'Name is required',
    ],
    headers: [
    {
    text: 'Username',
    align: 'start',
    sortable: false,
    value: 'username',
    },
    {
    text: 'Firstname',
    align: 'start',
    sortable: false,
    value: 'first_name',
    },
    {
    text: 'Middle Name',
    align: 'start',
    sortable: false,
    value: 'middle_name',
    },
    {
    text: 'LastName',
    align: 'start',
    sortable: false,
    value: 'last_name',
    },
    {
    text: 'User Type',
    align: 'start',
    sortable: false,
    value: 'user_type',
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
       axios.get('/select_user',{
       search:this.search,
       nextpage:0  
       }).then(response => {
         setTimeout(() => {
         this.data = response.data[0].first_array
         this.page_total = response.data[0].last_array
         let length_val = this.data.length
         this.total_count  = Math.ceil(length_val/2)
         this.total_records = response.data[0].total_count
         this.length_val =  this.total_count
         this.loader = false
         }, 1500);
      })
    },
    next(page){
    console.log(page)
    this.loader = true
    this.loading_text = "wew"
    axios.post('/select_user2',{
    search:this.search,
    total:this.page_total,
    nextpage:page
    }).then(response => {
    setTimeout(() => {
    console.log(response.data) 
    this.data = response.data[0].first_array
    this.total_records = response.data[0].total_count
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
    axios.post('/delete_user', {
    id: this.editedItem.id,
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
    url ="/update_user"
    }
    else {
    url ="/save_user"
    this.data.push({
    first_name: this.editedItem.first_name,
    middle_name: this.editedItem.middle_name,
    last_name: this.editedItem.last_name,
    username: this.editedItem.username,
    password: this.editedItem.password,
    user_type: this.editedItem.user_type,
    status: "Active"
    })
    }
    console.log(url)
    axios.post(url, {
    id: this.editedItem.id,
    firstname: this.editedItem.first_name,
    middlename: this.editedItem.middle_name,
    lastname: this.editedItem.last_name,
    username: this.editedItem.username,
    password: this.editedItem.password,
    user_type: this.editedItem.user_type,
    status: 1
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
       axios.post('/select_user2',{
       search:this.search,
       nextpage:0  
       }).then(response => {
         setTimeout(() => {
         this.data = response.data[0].first_array
         this.page_total = response.data[0].last_array
         let length_val = this.data.length
         this.total_count  = Math.ceil(length_val/2)
         this.total_records = response.data[0].total_count
         this.length_val =  this.total_count
         this.loader = false
         }, 1500);
      })
    }
    },
    })
    