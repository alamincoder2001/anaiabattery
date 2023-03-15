<style>
    .v-select{
		margin-bottom: 5px;
	}
	.v-select.open .dropdown-toggle{
		border-bottom: 1px solid #ccc;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
		height: 25px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
</style>
<div id="exchanges">
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-12">
            <form class="form-horizontal" @submit.prevent="addExchange">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Exchange Code </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Code" class="form-control" v-model="exchange.Exchange_Code" required readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Date </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="date" placeholder="Date" class="form-control" v-model="exchange.Exchange_Date" required/>
                    </div>
				</div>
				
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Product </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
						<v-select v-bind:options="products" label="display_text" v-model="selectedProduct" placeholder="Select Product"></v-select>
                    </div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Exchange Quantity </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="number" placeholder="Quantity" class="form-control" v-model="exchange.Exchange_Quantity" required/>
                    </div>
				</div>

				<!-- <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Exchange Amount </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="number" placeholder="Amount" class="form-control" v-model="exchange.Exchange_Amount" value="0"/>
                    </div>
				</div> -->

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Description </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" placeholder="Description" v-model="exchange.Exchange_Description" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"></label>
                    <label class="col-sm-1 control-label no-padding-right"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-sm btn-success">
                            Submit
                            <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="exchanges" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.Exchange_Code }}</td>
                            <td>{{ row.Exchange_Date }}</td>
                            <td>{{ row.Product_Code }}</td>
                            <td>{{ row.Product_Name }}</td>
                            <td>{{ row.Exchange_Quantity }}</td>
                            <!-- <td>{{ row.damage_amount }}</td> -->
                            <td>{{ row.Exchange_Description }}</td>
                            <td>
                                <?php if($this->session->userdata('accountType') != 'u'){?>
                                <button type="button" class="button edit" @click="editExchange(row)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="button" @click="deleteExchange(row.Exchange_SlNo)">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <?php }?>
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#exchanges',
        data(){
            return {
                exchange: {
                    Exchange_SlNo: 0,
                    Exchange_Code: '<?php echo $exchangeCode;?>',
                    Exchange_Date: moment().format('YYYY-MM-DD'),
                    Exchange_Quantity: 0,
					Product_SlNo: '',
					Exchange_Description: '',
                },
				products: [],
				selectedProduct: null,
                exchanges: [],

				columns: [
                    { label: 'Code', field: 'Exchange_Code', align: 'center', filterable: false },
                    { label: 'Date', field: 'SaleExchange_ExchangeDate', align: 'center' },
                    { label: 'Product Code', field: 'Product_Code', align: 'center' },
                    { label: 'Product Name', field: 'Product_Name', align: 'center' },
                    { label: 'Quantity', field: 'DamageDetails_DamageQuantity', align: 'center' },
                    // { label: 'Damage Amount', field: 'damage_amount', align: 'center' },
                    { label: 'Description', field: 'SaleExchange_Description', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
            }
        },
        created(){
            this.getProducts();
            this.getExchanges();
        },
        methods: {
            getProducts(){
                axios.get('/get_products').then(res => {
                    this.products = res.data;
                })
            },
			addExchange(){
				if(this.selectedProduct == null){
					alert('Select product');
					return;
				}

				this.exchange.Product_SlNo = this.selectedProduct.Product_SlNo;

                let url = '/add_exchange';
                if(this.exchange.Exchange_SlNo != 0){
                    url = '/update_exchange'
                }
				axios.post(url, this.exchange).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.resetForm();
						this.exchange.Exchange_Code = r.newCode;
                        this.getExchanges();
					}
				})
			},

            editExchange(exchange){
                this.exchange = exchange;
                this.selectedProduct = {
                    Product_SlNo: exchange.Product_SlNo,
                    display_text: `${exchange.Product_Name} - ${exchange.Product_Code}`
                }
            },

            deleteExchange(exchangeId){
                let deleteConfirm = confirm('Are you sure?');
                if(deleteConfirm == false){
                    return;
                }
                axios.post('/delete_exchange', {exchangeId: exchangeId}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
                        this.getExchanges();
					}
				})
            },

            getExchanges(){
                axios.get('/get_exchanges').then(res => {
                    this.exchanges = res.data;
                })
            },

			resetForm(){
				this.exchange.Exchange_SlNo = '';
				this.exchange.Exchange_Description = '';
				this.exchange.Product_SlNo = '';
				this.exchange.Exchange_Quantity = 0;
				this.exchange.Exchange_Date = moment().format("YYYY-MM-DD");
				// this.exchange.Exchange_Amount = '';
				this.selectedProduct = null;
			}
        }
    })
</script>
