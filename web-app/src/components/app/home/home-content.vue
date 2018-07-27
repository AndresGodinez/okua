<template>
<div class="ct-flex ct-flex-col">
<app-navbar></app-navbar>
<div class="ct-inline-flex ct-w-48 ct-mt-4 ct-ml-32">
	<ul class="ct-list-reset ct-flex">
		<li class="ct-mr-3">
			<div class="ct-inline-block ct-border ct-border-blue ct-rounded ct-py-1 ct-px-3 ct-bg-blue ct-text-white" style="cursor: pointer;">Sem</div>
		</li>
		<li class="ct-mr-3">
			<div class="ct-inline-block ct-border ct-border-white ct-rounded ct-hover:border-grey-lighter ct-text-blue hover:bg-grey-lighter ct-py-1 ct-px-3" style="cursor: pointer;">Mes</div>
		</li>
		<li class="ct-mr-3">
			<div class="ct-inline-block ct-border ct-border-white ct-rounded ct-hover:border-grey-lighter ct-text-blue hover:bg-grey-lighter ct-py-1 ct-px-3" style="cursor: pointer;">Año</div>
		</li>
	</ul>
</div>
<div class="ct-flex ct-flex-col ct-m-auto ct-border-2 ct-p-4">
	<div class="ct-flex-1 ct-text-center ct-mb-6 ct-font-sans ct-font-medium ct-tracking-wide ct-text-2xl">$0000</div>
	<div class="ct-flex-1 ct-text-center ct-uppercase ct-font-sans ct-tracking-wide ct-text-xl">Monto general en facturas</div>
</div>
<div class="ct-flex ct-flex-col ct-mt-12">
	<div class="ct-flex-1 ct-w-48 ct-ml-32 ct-tracking-wide ct-text-sm ct-font-sans">Agrupar:</div>
	<div class="ct-inline-flex ct-w-1/6 ct-mt-2 ct-ml-32">
		<ul class="ct-list-reset ct-flex">
			<li class="ct-mr-3">
				<div class="ct-inline-block ct-border ct-border-blue ct-rounded ct-py-1 ct-px-3 ct-bg-blue ct-text-white" style="cursor: pointer;">Cliente</div>
			</li>
			<li class="ct-mr-3">
				<div class="ct-inline-block ct-border ct-border-white ct-rounded ct-hover:border-grey-lighter ct-text-blue hover:bg-grey-lighter ct-py-1 ct-px-3" style="cursor: pointer;">Uso CFDI</div>
			</li>
			<li class="ct-mr-3">
				<div class="ct-inline-block ct-border ct-border-white ct-rounded ct-hover:border-grey-lighter ct-text-blue hover:bg-grey-lighter ct-py-1 ct-px-3" style="cursor: pointer;">Estados</div>
			</li>
		</ul>
	</div>
</div>
<div class="ct-flex ct-flex-col ct-m-auto ct-border-2 ct-mt-4 ct-border-black ct-w-5/6">
	<div class="ct-flex ct-inline-flex">
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-8 ct-border-b-2">Fecha de Registro</div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-8 ct-border-b-2">Cliente</div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-8 ct-border-b-2">RFC</div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-8 ct-border-b-2">Uso</div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-8 ct-border-b-2">Estatus</div>
		<div class="ct-flex-1 ct-text-center ct-p-8 ct-border-b-2 ct-border-b-black">Monto</div>
	</div>
	<div class="ct-flex ct-inline-flex">
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-p-4 ct-border-b-2 ct-border-b-black">   </div>
	</div>
	<div class="ct-flex ct-inline-flex">
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-p-4 ct-border-b-2 ct-border-b-black">   </div>
	</div>
	<div class="ct-flex ct-inline-flex">
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-border-r-2 ct-p-4 ct-border-b-2">   </div>
		<div class="ct-flex-1 ct-text-center ct-p-4 ct-border-b-2 ct-border-b-black">   </div>
	</div>
</div>
</div>
</template>
<script>
	import AppNavbar from "../../shared/app-navbar";
	export default {
		name: "home-content",
		components: {AppNavbar}
	}
</script>
<style scoped>
</style>