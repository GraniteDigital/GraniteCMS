var app = new Vue({
  el: '#app',
  data: {
    searchInput: "",
    sites: [],
    currentSiteCounter: 0,


    siteCounterStep: 20,
    siteCounterBase: 0,
  },
  methods: {
    init: function(){
      let self = this;
      let hash = window.location.hash.substring(1);
      self.performSearch(hash);
    }, 

  	search: function(event){
      let self = this;

  		event.preventDefault();
      self.currentSiteCounter = 0;

  		if( self.searchInput !== "" ){
	  		self.performSearch(self.searchInput);
        history.pushState({}, null, "#"+self.searchInput);
  		}
  	},

    performSearch: function(input){
      let self = this;

      $.ajax({
          url: "/api/search/" + input,
          method: "GET",
          dataType: "json",
          success: function(result){
            let incSites = [];

            $.each(result.data, function(key, value){
              incSites.push(key);
            });

            let siteIDs = incSites.join();

            $.ajax({
              url: "/api/get_site_info/" + siteIDs,
              method: "GET",
              dataType: "json",
              success: function(result){
                self.sites = result.data;
              }
            });

          }
      });
    }
  }
})

app.init();