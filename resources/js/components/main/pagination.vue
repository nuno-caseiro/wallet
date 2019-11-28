<template id="pagination">
  <nav aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item">
					<button type="button" class="page-link" v-if="page != 1" @click="page--"> Previous </button>
				</li>
				<li class="page-item">
					<button type="button" class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)" @click="page = pageNumber"> {{pageNumber}} </button>
				</li>
				<li class="page-item">
					<button type="button" @click="page++" v-if="page < pages.length" class="page-link"> Next </button>
				</li>
			</ul>
		</nav>	
</template>
<script>
    module.exports = {

        data: function() {
            return {
                pagination: {},
            }
        },

        methods: {
            paginate(page){
                axios.get('/api/movements?page=' + page)
                .then(function(response){
                    console.log(response.data.data);
                    
        }).catch(function(error){
            console.log(error);
        })
        }
        },
        mounted(){
            this.paginate();
        }

        
    }
</script>
