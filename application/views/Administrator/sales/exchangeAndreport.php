<div id="exchangeInvoice">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<exchange-invoice v-bind:exchange_id="exchangeId"></exchange-invoice>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/components/exchangeInvoice.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script>
	new Vue({
		el: '#exchangeInvoice',
		components: {
			exchangeInvoice
		},
		data(){
			return {
				exchangeId: parseInt('<?php echo $exchangeId;?>')
			}
		}
	})
</script>

