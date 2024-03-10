let app = new Vue({
el: '#app',
vuetify: new Vuetify(),
data: () => ({
snackbar:false,
snackbartext:"",
snackbarcolor:"",
items_css: ['line', 'bar','pie'],
items_pss: ['line', 'bar','pie'],
chart_pss:"",
chart_css:"",
}),


created () {
this.initialize()
},

methods: {
initialize () {

axios.get('/select_chart_settings_css').then(response => {
this.chart_css =  response.data.map(x=> x.chart_name)[0]
console.log("dp", response.data.map(x=> x.chart_name)[0])
})

axios.get('/select_chart_settings_pss').then(response => {
this.chart_pss =  response.data.map(x=> x.chart_name)[0]
console.log("dp", response.data.map(x=> x.chart_name)[0])
})

},


save_btn(){
axios.post('/save_chart_settings', {
chart_css: this.chart_css,
chart_pss: this.chart_pss,
})
.then((response)=> {
console.log(response);
this.snackbar = true
this.snackbarcolor = "success"
this.snackbartext = "Success"
})
}
},
})
