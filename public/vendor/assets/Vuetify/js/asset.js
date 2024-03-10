
      function logout(){
        localStorage.clear()
        window.location.href = "login.html"
      }
      $( () => {
          var apps = new Vue({
          el: '#app',
          vuetify: new Vuetify({
            theme: {
            themes: {
              light: {
                primary: '#3f51b5',
                secondary: '#b0bec5',
                anchor: '#8c9eff',
              },
            },
          },
          
          }),
          
          data: () => ({
            loader:true,
            title_id:'',    
            disable:0,      // 1 = disable all create_survey ~ 0 = enable edit survey
            ex_disable:false,            // disable export button
            results:[],
            float_bot:true,
            indi_page:false,
            response_result:0,
            idnumber:null,
            visibletab:false,
            response_tab:false,
            response_tab2:false,
            tab: null,
            tabs: "active",
            eventListener:true,
          //  select: { qtype: 'Mutiple', abbr: 'Choose One' },
            
            dialog:false,
            selected:null,
            counter:0,
            valid: true,
            page: 1,
            pages: true,
            select_question:true,
            chosenFile: null,
            //////
            displayError: false,
            success_snackbar: false,
            fail_snackbar: false,
            success_timeout: 3000,
            text: '',
            vertical: true,
            indi_card:'',
            /////
            DateRule:[
            x=>x.split(' ~ ').length != 1 || 'please pick more',
            x=>x.split(' ~ ').reduce((a,b)=>a==b || a<b) || 'Range is invalid'
      
            ],
            Cardrule: [
            v => !!v || 'This is required'
            ],
            addoption:'',
            shortDisable:true,
            parDisable:true,
            fab:false,
            top: false,
            right: true,
            bottom: true,
            left: false,
            direction: 'top',
            hover: false,
            transition: 'slide-y-reverse-transition',
            menu: false,
            sidebar_list:{
                Home:{
                    title:'Home',
                    Icon:'mdi-home',
                },
                Statistic:{
                    title:'Statistic',
                    Icon:'mdi-chart-bar',
                },
                Table:{
                    title:'Table',
                    Icon:'mdi-table',
                }
            },
            get_opt:[0,1],
            
            get_opt2:[1,2,3,4,5,6,7,8,9,10],
            items: [],
            questions_:[],
            questions_selected:'',
            form:{
              dateCreated:"",
              creator:"",
              uniq_id:"",
              qtitle:"",
              dtitle:"",
              mindate:new Date().toISOString().substr(0, 10),
              dates: [new Date().toISOString().substr(0, 10), new Date().toISOString().substr(0, 10)],
              cards: [{ 
                time_menu:false,
                menu: false,
                switch1:false,
                time:null,
                dates:null,
                ddown_select:[],
                radioGroup:'',
                title: "", 
                flex: 12 ,
                
                selected1:[],
                selected2:[],
                selected3:[],
                select:  {
                  qtype: 'Multiple Choice', 
                  abbr: 'One answer only',
                  icon:'mdi-radiobox-marked' ,
                  kword:'multi',
                  id:4, 
                },
                checkbox:[
                {
                    option:'',
                }
                ],
                multiple:[
                {
                    option:'',
                }
                ],
                dropdown:[
                {
                    option:'',
                }  
                ],
               //  mgrid:[{
          
               //    row:[{
          
               //      column:[{
               //        value:"",
               //      }]
          
               //    }],
               //    column_n:["",]
          
               //  }],
                shortanswer:'',
                paranswer:'',
                dateanswer:'',
                timeanswer:'',
                type:"text",
                getopt1:null,
                getopt2:null,
                slides:'',
                isActive: false,
                displayError:false,
              }],
            },
           
             
          }),
          computed: {
            // onload function compute
            dateRangeText () {
             return this.form.dates.join(' ~ ')
            },
          
          },
          mounted:() =>{
            window.addEventListener("storage", a=>{
                console.log(localStorage)
             
                // do your checks to detect
                //detect if localstorage change
                console.log("localStorage \""+a.key 
                + "\" Value is change from "+a.oldValue+" to "+a.newValue+"\nlocation:"+a.url)
               
                if(a.key=="idnumber" || localStorage.length == 0) location.reload() 
                
            
             }, false);

            setTimeout(
            async ()=>{
              
             await  apps.load()
            apps.title_id = localStorage.title_id
            },300)
            
             var fullname = localStorage.fullname
          
             var idnumber = localStorage.idnumber
            
        //     apps.idnumber = idnumber
        
               this.idnumber = idnumber
             console.log(this.idnumber)
         
             fullname == null ? window.location.href = "login.html" : 
             fullname.replace(null,"")
             document.getElementById("name_user").innerHTML = fullname
             document.getElementById("id_num").innerHTML = idnumber
           
            document.addEventListener("keydown", e=> {
            if(apps.eventListener && apps.disable == 0){
                if ((window.navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey) && e.keyCode == 83) {
                   e.preventDefault()
      
                   apps.validate()
      
                }
                if ((e.ctrlKey || e.metaKey) && (e.keyCode == 13 || e.keyCode == 10)) {
                   apps.addQuestion()
                }
               
            }
            
            if (e.keyCode == 13 && e.altKey) {
                apps.PreviewQuestion()
             }
            
             }, false);
               // let dataform = new FormData()
            
               // dataform.append( 'idnumber', localStorage.idnumber)

               let data = {
                  idnumber : localStorage.idnumber,
               }
               let url = "config/typeofchoices.php"
               const options = {
                    
                    method: 'POST',
                    mode: 'no-cors',
                    credentials: 'same-origin',
                    body:JSON.stringify(data),
                    headers: {
                      'content-type': 'application/x-www-form-urlencoded',
                    },
                  
                } 
        
                fetch(url,options)
                  .then(response => {
               return response.json();
               }).then(json => {
                  
                  apps.form.uniq_id = json[json.length-1].uniq_id
                  json.pop()
                
                  
                  console.log(apps.form.uniq_id)
                  apps.items = json
                  
                  
               }).catch(e=>{
                  this.submit = false
                  console.log(e)
                  console.log("no data found!ss")
               });
      
                  ////////////

                  
      
          
          },
          
          methods:{
            question_se(){
              let a = this.results.map(x=>{
               return x.map(z=>z.filter(f=>f.title))
              })

              console.log(a)
            },
          async exporttoexcel(){
       
           
               let title_q = this.results.map(x=>x.map(x=>x.title))[this.results.length - 1]
               let answers = this.results.map(x=>x.map(data=>
                  data.select.kword == 'short' ? data.shortanswer
                  :data.select.kword == 'slide' ? data.slides
                  :data.select.kword == 'date' ? data.dates
                  :data.select.kword == 'multi' ? data.radioGroup
                  :data.select.kword == 'par' ? data.paranswer
                  :data.select.kword == 'ddown' ? data.ddown_select
                  :data.select.kword == 'check' ? data.selected1
                  :data.select.kword == 'time' ? data.time
                  : ''
               ).filter(x=>x!=""))

                           console.log(title_q)
                           console.log(answers)
                           
                   let response_get = this.results[0].filter(x=>x.select.kword=='hidden')[0]
                    let time = response_get.times_response
                    let date = response_get.date_response


                   
                   document.getElementById("parameter").value = this.form.qtitle;
                   document.getElementById("title_id").value = this.title_id;
                   document.getElementById("time_response").value = time;
                   document.getElementById("date_response").value = date;
                    document.getElementById("parameter1").value = JSON.stringify(title_q);
                    document.getElementById("parameter2").value = JSON.stringify(answers);
                    document.getElementById("invisible_form").submit();
           
               // document.getElementById("invisible_form").submit();
                           
            },
           async fetchingdata(count){
              
               const len = this.results.length
              
               for(let i =len; i<count ; i++){
                  let url = `answers/${localStorage.idnumber}/${this.form.uniq_id}/${i+1}.json`    
                   fetch(url)
                     .then(x=>{
                        return x.json()
                        
                     })
                     .then(x=>{
                        
                        this.results[i] = x

                       
                     })
                     .catch(er=>{
                        console.log(err)
                     })
               }
               
              console.log(this.results,"wew")
           
            },
             summary(){
               this.indi_page = false
               this.pages = false
               this.select_question = false
             },
             question(){
               this.indi_page = true
               this.pages = false
               this.select_question = true
               
               let questions_ = this.results.map(x=>x.map(x=>x.title))[this.results.length - 1]
              
               this.questions_ = questions_.filter(x=>x!=undefined)

            },
             individual(){ 
               this.indi_page = true
               this.pages = true
               this.select_question = false
           
             },
             swipetab(){
               this.tab=='tab-2'?this.getResponse():this.float_bot = true

             },
         
            next (page) {
              
               const url = `answers/${localStorage.idnumber}/${this.form.uniq_id}/${page}.json`
               fetch(url,{
                  method:'POST',
                  mode:'no-cors',
                  body:JSON.stringify({
                     idnumber:localStorage.idnumber,
                     uniq_id:this.form.uniq_id
                  })
               })
               .then(res=>{return res.json()})
               .then(json=>{
                  this.indi_card = json
               
                  

               })
               .catch(e=>{})
            },
           async getResponse(){
               this.float_bot = false
               console.log("----")
                this.loader = true
               this.eventListener=false
               const url = 'config/checkresponse.php'
            await  fetch(url,{
                  method:'POST',
                  mode:'no-cors',
                  body:JSON.stringify({
                     idnumber:localStorage.idnumber,
                     uniq_id:this.form.uniq_id
                  })
               })
               .then(res=>{return res.json()})
               .then(json=>{
                 
                    if(this.response_result != json){
                     this.response_result = json
                     this.fetchingdata(json)
                    }
                    else{
                       console.log("ok pa!")
                    }
                  
                 
                    this.loader = false

               })
               .catch(e=>{})

            },
               importTxt() {
         
                  if (this.chosenFile) {
                  var reader = new FileReader();
                  
          
                     reader.readAsText(this.chosenFile);
                     reader.onload = () => {
                   
                     console.log(this.form.uniq_id)
                     try{
                        json = JSON.parse(reader.result);
                        let b = json.hasOwnProperty("uniq_id")
                        if(b){
                           json.uniq_id = this.form.uniq_id
                           json.creator = null
                           console.log(json)
                           this.form = json
                                 this.text = "Form Successfuly Uploaded"
                                 this.success_snackbar = true
                                 this.dialog = false
                        }
                        else{
                           console.log("error!")
                           this.text = "Invalid File upload"
                           this.fail_snackbar = true
                        }
                     }
                     catch(e){
                        console.log("error!")
                        this.text = "Invalid File upload"
                        this.fail_snackbar = true
                     }
              
                     }
                     
                  }
                  else{
                     console.log("no file")
                  }
      
               },
           
               validate () {
   
                  if(this.$refs.form.validate()){

                     console.log(this.form.idnumber)
                       this.QuestionSave()
                  }
                  else{
                     this.text = "Please Fill all required"
                     this.fail_snackbar = true
                  }
                  
               },
               async load(){
               if(localStorage.hasOwnProperty('uniq_id')){
                        this.visibletab = true
                        const stor = localStorage.idnumber
                        const uniq = localStorage.uniq_id
                        const file = "questions/"+stor+"/"+uniq+".json?_="+ new Date().getTime()
                        

                        let data = {
                           idnumber : localStorage.idnumber,
                           uniq_id : localStorage.uniq_id,
                        }
                        let url = "config/checkfile.php"
                      
                        await fetch(url,{
                           method:'POST',
                           mode : 'no-cors',
                           body:JSON.stringify(data)
                        }).then(response=>
                           response.json()
                        ).then(results=>{
                           console.log(results)
                           if(results>0){

                              let ansfile = "answers/"+stor+"/"+uniq+"/1.json?_="+ new Date().getTime()
                              console.log(ansfile)
                              fetch(ansfile)
                              .then(response=>{
                                
                                return response.json()
                              }
                              )
                              .then(result=>{
                                 
                                 this.indi_card = result
                                 console.log(result[0],"nc")
                              })
                              .catch(error=>{
                                 console.log(error, "gg")
                              })
                           }
                           
                        },error=>{
                           console.log(error)
                        })

                        await  fetch(file).then(response => {
                         
                         return response.json();
                         
                        }).then(json => {
      
                           this.form = json
                           localStorage.removeItem("uniq_id");
                           console.log(localStorage.getItem("uniq_id"))

                        }).catch(e=>{
                           this.submit = false
                           console.log("no data found!")
                        });
                      /////////////////////////////////////////////////
                    
                    
                        
                      
               }
               else{
                  console.log("no men!")
                  
               }

           

            },
            selecting(get){
            this.selected = get
            },
            addQuestion(){
          
              this.form.cards.push({ 
                time_menu:false,
                menu: false,
                time:null,
                switch1:false,
                dates:null,
                ddown_select:'',
                displayError:false,
                selected1:[],
                selected2:[],
                selected3:[],
                title: "", 
                flex: 12 ,
             
                select:  { 
                  qtype: 'Multiple Choice', 
                  abbr: 'One answer only',
                  icon:'mdi-radiobox-marked' ,
                  kword:'multi',
                  id:4,
                },
                checkbox:[
                {
                    option:'',
          
                }
                ],
                multiple:[
                {
                    option:'',
          
                }
                ],
                dropdown:[
                {
                    option:'',
              
                }
                ],
                shortanswer:'',
                paranswer:'',
                type:"text",
                dateanswer:'',
                timeanswer:'',
                getopt1:null,
                getopt2:null,
                slides:'',
                isActive: false,
              })
          
          
          
            },
          
            removequestion(count){
          
          
              this.form.cards.splice(count-1, 1)
              
          
            },
            QuestionSave(){
               
              
               this.displayError=false

               

               let arrraaa = new Array()
              this.form.cards.map(x=>arrraaa.push(x.getopt1,x.getopt2))
           
             let z = this.form.cards.map((data,index) =>
      
                data.select.kword == "multi"?  data.multiple.map(x=>x.option) 
               :data.select.kword == "check"? data.checkbox.map(x=>x.option)
               :data.select.kword == "ddown"? data.dropdown.map(x=>x.option)
               :data.select.kword == "short"? "shorttext"
               :data.select.kword == "par"? "paragraph"
               :data.select.kword == "date"? "date"
               :data.select.kword == "time"? "time"
               :data.select.kword == "slide"? [data.getopt1,data.getopt2].flat()
               : "null"
                
              )
              
                let type_id = this.form.cards.map(x=>x.select.id)
                this.form.creator = localStorage.idnumber
               
           
                this.form.dateCreated == ''||new Date().toISOString().substr(0, 10)
               
                var obj = JSON.stringify(this.form,null,4);
             
               
                  f = new FormData()
                this.form.uniq_id != "" ? f.append( 'uniq_id',this.form.uniq_id):""
                  let p = apps.form.cards.map(data => data.title)
                
                f.append( 'formdata', JSON.stringify(obj))
                f.append( 'formtitle', apps.form.qtitle)
                f.append( 'formdescription', apps.form.dtitle)
                f.append( 'dateduration', apps.form.dates)
                f.append( 'formquestions',  JSON.stringify(p))
                f.append( 'idnumber', localStorage.getItem("idnumber"))
                f.append( 'savechoices',JSON.stringify(z))
                f.append( 'uniq_id',apps.form.uniq_id)
                f.append( 'type_id',type_id)
      
              let dataform = f
              const options = {
                    
                      method: 'POST',
                      mode: 'no-cors',
                      credentials: 'same-origin',
                      data: dataform,
                      headers: {
                        'content-type': 'application/x-www-form-urlencoded',
                      },
                      url: 'config/save_question.php',
                  } 
                    axios(options)
                      .then(response =>{
                
                      this.text = "Form Successfuly Saved!"
                      this.success_snackbar = true
                      this.visibletab = true
                      })
                      .catch(error => {
                        console.log(error)
                      });
            
          
            },
            DuplicateQuestion(index){
          
              let stringy = JSON.stringify(this.form.cards[index-1])
              stringy = JSON.parse(stringy)
          
              this.form.cards.splice(index,0 ,stringy)
            
            },
            toggleswitch(val,index){
             val ? this.form.cards[index-1].type = "number" : this.form.cards[index-1].type = "text"
            },
            downloadQuestion() {
              
             this.form.dateCreated != '' || new Date().toISOString().substr(0, 10)
             var myJSON = JSON.stringify(this.form, null, 4);
          
            var blob = new Blob([myJSON], { type: "text/plain;charset=utf-8" });
            saveAs(blob, "data_form.json");
            },
            PreviewQuestion(){
            
            
              var obj = JSON.stringify(this.form, null, 4);
              
              f = new FormData()
              f.append( 'formdata', JSON.stringify(obj))
              f.append( 'idnumber', localStorage.getItem("idnumber"))
              let dataform = f
              const options = {
                    
                      method: 'POST',
                      mode: 'no-cors',
                      credentials: 'same-origin',
                      data: dataform,
                      headers: {
                        'content-type': 'application/x-www-form-urlencoded',
                      },
                      url: 'config/prev_question.php',
                  } 
                    axios(options)
                    .then(function (response) {
                    //  let obj = JSON.parse(response)
                     window.open("preview/Preview.html",'f');
                    
                    })
                    .catch(function (error) {
                      console.log(error)
                    });
            },
            deletethis(card,index){
            
              if(card.select.qtype === "Checkbox"){
                  const remove = card.checkbox.indexOf(index)
                  card.checkbox.splice(remove,1)
             
              }
              else if(card.select.qtype === "Multiple Choice"){
            
                  card.multiple.splice(index,1)
          
              }
              else if(card.select.qtype === "Dropdown"){
                     
                     card.dropdown.splice(index,1)
            
               }
            },
            addcheckbox(card){
             
              card.checkbox.push({
                option:''
              })
            },
            addmultiple(card){
             
             card.multiple.push({
               option:''
             })
           },
           adddrop(card){
            card.dropdown.push({
               option:''
             })
           },
           slider_opt(value){
            
            this.get_opt2 =this.get_opt2.filter(val => val>value)
           
            if(value == 0) this.get_opt2.unshift(1)
          },
          testing(a){
           
                        
       
      
            
          }
          
          }
          })
          ////////////////////////////////////////////////////////
          
          
          });
      
       