let app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: () => ({
    dialog: false,
    dates: "",
    dates_items:[],
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
    text: 'Hospital Name',
    align: 'start',
    sortable: false,
    value: 'hospital_name',
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
    this.generate_year()
    },

    methods: {
    generate_year(){
      var startYear = 1910; // Start year
      var endYear = 2050; // End year
      var years = [];

      for (var year = startYear; year <= endYear; year++) {
      years.push(year);
      }
      this.dates_items = years.sort((a,b)=> a-b)
      console.log(years.sort((a,b)=> b-a)); // Array containing all the years
    },
    initialize () {
    this.length = 10
    this.loader = true
    axios.get('/select_pss',{
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
    axios.post('/select_pss2',{
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

    viewItem (item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    // this.dialog = true
    window.open(`/view/pss/${this.editedItem.id}`, '_blank');
    // window.location.href=`/view/pss/${this.editedItem.id}`
    },

    editItem (item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    // this.dialog = true
    window.location.href=`/edit/pss/${this.editedItem.id}`
    },

    deleteItem (item) {
    this.editedIndex = this.data.indexOf(item)
    this.editedItem = Object.assign({}, item)
    this.dialogDelete = true
    },

    deleteItemConfirm () {
        this.data.splice(this.editedIndex, 1)
        axios.post('/delete_pss', {
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
      let year = this.dates
      // let month = this.dates.split("-")[1]
      // window.location.href = `/reports1/pss/${this.dates}/${year}/${month}/${this.hospital_name}`
      window.location.href = `/reports1/pss/${year}/${this.hospital_name}`
    },

    search_btn(){
      this.length = 10
      this.loader = true
      this.data = [];
      axios.post('/select_pss2',{
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
