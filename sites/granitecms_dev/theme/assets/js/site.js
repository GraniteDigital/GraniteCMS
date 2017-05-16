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
  	search: function(event){
  		event.preventDefault();
      this.currentSiteCounter = 0;

  		if( this.searchInput !== "" ){
	  		$.ajax({
          url: "/api/search/"+this.searchInput,
          method: "GET",
          dataType: "json",
          success: function(result){
            this.sites = result.data;
            this.renderSites( this.siteCounterBase, this.siteCounterBase + this.siteCounterStep );
          }
        });
  		}
  	},

    renderSites: function( lower, upper ){



      this.currentSiteCounter = this.currentSiteCounter + this.siteCounterStep;
    }
  }
})