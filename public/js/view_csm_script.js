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
    text: 'Services',
    align: 'start',
    sortable: false,
    value: 'service_name',
    },
    {
    text: 'Client Type',
    align: 'start',
    sortable: false,
    value: 'client_type',
    },
    {
    text: 'Gender',
    align: 'start',
    sortable: false,
    value: 'gender',
    },
    {
    text: 'Age',
    align: 'start',
    sortable: false,
    value: 'age',
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
    axios.get('/select_csm',{
    nextpage:0,
    office_name:this.selectedOffice
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

    axios.get('/office_dropdown_csm').then(response => {
    // console.log(response.data.map(x=> x.office_name))
    this.office_items = response.data.map(x=> x.office_name)
    this.selectedItemOffice = response.data.map(x=> x.office_name)
    })


    },

    editItem (item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    // this.dialog = true
    window.location.href=`/edit/csm/${this.editedItem.id}`
    },
      
    
    viewItem (item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    // this.dialog = true
    window.open(`/view/csm/${this.editedItem.id}`, '_blank');
    // window.location.href=`/view/css/${this.editedItem.id}`
    },
    
    deleteItem (item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    this.dialogDelete = true
    },
    
    deleteItemConfirm () {
    this.data.splice(this.editedIndex, 1)
    axios.post('/delete_csm', {
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
    
    export_btn(){
      let year = this.dates.split("-")[0]
      let month = this.dates.split("-")[1]
      window.location.href = `/reports1/csm/${this.dates}/${year}/${month}/${this.office_name}`
    },
    search_btn(){
      this.length = 10
      this.loader = true
      axios.post('/select_csm2',{
      search:this.search,
      office_name:this.office_name,
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
    