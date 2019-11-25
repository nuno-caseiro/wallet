<template>
<div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Tranfer Email</th> 
                <th>Payment Type</th> 
                <th>Category</th>
                <th>Date</th>
                <th>Start Balance</th>
                <th>End Balance</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="movement in movements" :key="movement.id">
            <td>{{ movement.id }}</td>
            <td>{{ movement.type }}</td>
            <td>{{ movement.transfer_wallet_id}}</td>
            <td>{{ movement.type_payment }}</td>
            <td>{{ movement.category_id}}</td>
            <td>{{ movement.date }}</td>
            <td>{{ movement.start_balance}}</td>
            <td>{{ movement.end_balance }}</td>
            <td>{{ movement.value }}</td>
        </tr>
        </tbody>
    </table>
      
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

</div>
</template>


<script type="text/javascript">
import axios from 'axios';
import pagination from '../main/pagination.vue';
import movementVue from './movement.vue';
export default {
    props: ['movements'],
    data() {
        return {
            userTransfer:"",
            emailTransfer:"",
            page: 1,
			perPage: 9,
			pages: [],	

        }
    },

    // components: {
    //     'pagination' : pagination,
    // },
   methods:{
    setPages () {
			let numberOfPages = Math.ceil(movements.length / this.perPage);
			for (let index = 1; index <= numberOfPages; index++) {
				this.pages.push(index);
			}
		},
		paginate (movements) {
			let page = this.page;
			let perPage = this.perPage;
			let from = (page * perPage) - perPage;
			let to = (page * perPage);
			return  movements.slice(from, to);
        }
        

	},
	computed: {
		displayedPosts () {
			return this.paginate(movements);
		}
	},
	watch: {
		movements () {
			this.setPages();
		}
	},
	// created(){
	// 	this.getPosts();
	// },
	filters: {
		trimWords(value){
			return value.split(" ").splice(0,20).join(" ") + '...';
		}
	}
    
    
}
</script>