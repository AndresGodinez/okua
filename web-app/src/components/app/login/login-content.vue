<template>
<div class="ct-flex ct-flex-col ct-text-center ct-mt-8">
	<div class="ct-bg-blue-light ct-w-1/3 ct-m-auto ct-mt-8 ct-mb-8 ct-p-6">
		<h1 class="text-blue-darker ct-font-sans ct-font-normal">OKUA</h1>
	</div>
	<form class="ct-w-1/3 ct-m-auto ct-mt-8 ct-border-2 ct-p-6">
		<div class="ct-flex ct-items-center ct-mb-6">
			<div class="ct-w-1/3">
				<label class="ct-block ct-text-black ct-font-bold ct-text-right ct-mb-1 ct-mb-0 ct-pr-4" for="inline-full-name">
					Username
				</label>
			</div>
			<div class="">
				<input class="ct-bg-grey-lighter ct-appearance-none ct-border-2 ct-border-grey-lighter ct-hover:border-purple ct-rounded ct-w-full ct-py-2 ct-px-4 ct-text-grey-darker ct-leading-tight" id="inline-full-name" type="text" value="Username">
			</div>
		</div>
		<div class="ct-flex ct-items-center ct-mb-6">
			<div class="ct-w-1/3">
				<label class="ct-block ct-text-black ct-font-bold ct-text-right ct-mb-1 ct-mb-0 ct-pr-4" for="inline-username">
					Password
				</label>
			</div>
			<div class="">
				<input class="ct-bg-grey-lighter ct-appearance-none ct-border-2 ct-border-grey-lighter ct-hover:border-purple ct-rounded ct-w-full ct-py-2 ct-px-4 ct-text-grey-darker ct-leading-tight" id="inline-username" type="password" placeholder="******************">
			</div>
		</div>
		<div class="ct-m-auto">
			<button class="ct-pr-8 ct-pl-8 ct-shadow ct-bg-blue ct-hover:bg-blue-light ct-text-white ct-font-bold ct-py-2 ct-px-4 ct-rounded" type="button">
			Login
			</button>
		</div>
	</form>
</div>
</template>
<script>
export default {
name: "login-content",
}
</script>
<style scoped>
</style>