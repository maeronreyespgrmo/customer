var appse = new Vue({
    el: '#apps',
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
        side_list:[
        {
          Name:'Home',
          link:'',
          icon:'mdi mdi-home',
          style:'color:white!important;display:flex;align-items: center;',
        },
        {
            Name:'Forms',
            link:`${window.location.href.includes('preview')?'../':''}question_list.html`,
            icon:'mdi mdi-clipboard-text-multiple-outline',
            style:'color:white!important;display:flex;align-items: center;',
        },
        {
          Name:'Acccount',
          link:`${window.location.href.includes('preview')?'../':''}account_list.html`,
          icon:'mdi mdi-account-supervisor-circle',
          style:'color:white!important;display:flex;align-items: center;',
        },
        {
          Name:'List 5',
          link:'',
          icon:'mdi mdi-clipboard-text-multiple-outline',
          style:'color:white!important;display:flex;align-items: center;',
        },
        {
          Name:'List 6',
          link:'',
          icon:'mdi mdi-clipboard-text-multiple-outline',
          style:'color:white!important;display:flex;align-items: center;',
        },
        {
          Name:'Logout',
          link:'',
          icon:'mdi mdi-logout',
          style:'color:white!important;display:flex;align-items: center;margin-top:auto;',
        }
        ],
      })
    
    });
    