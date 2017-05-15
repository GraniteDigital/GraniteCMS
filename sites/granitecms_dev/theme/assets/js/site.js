var app = new Vue({
  el: '#app',
  data: {
    searchInput: ""
  },
  methods: {
  	search: function(event){
  		event.preventDefault();

  		if( this.searchInput !== "" ){
	  		$.ajax({
			  url: "/api/search/"+this.searchInput,
			  method: "GET",
			  dataType: "json",
			  success: function(result){
			  	console.log(result);
			  }
			});
  		}
  	}
  }
})