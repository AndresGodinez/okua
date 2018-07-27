<template>
    <div class="ct-flex ct-flex-col">
    	<app-navbar></app-navbar>
        <div class="ct-inline-flex ct-w-48 ct-mt-4 ct-ml-32">
        	<div class="ct-flex-col">
        		<div class="ct-flex-1 ct-font-sans ct-mb-4">Fecha de Inicio: </div>
        		<div class="ct-flex-1 ct-font-sans ct-mb-4">Fecha fin: </div>
        		<div class="ct-flex-1">
        			<datetime input-class="ct-bg-white ct-shadow ct-border-2 ct-border-grey ct-py-2 ct-rounded-sm ct-font-sans" v-model="date"></datetime>
        		</div>
        	</div>
        </div>
    </div>
</template>

<script>
  import AppNavbar from "../../shared/app-navbar";
  import { Datetime } from 'vue-datetime';
  import 'vue-datetime/dist/vue-datetime.css'
  export default {
  	data(){
        return{
            date: ""
        }
    },
    name: "bills-content",
    components: {
    	AppNavbar,
    	datetime: Datetime
    },
  }
</script>

<style scoped>
    
</style>