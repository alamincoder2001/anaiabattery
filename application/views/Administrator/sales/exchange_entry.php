<style>
    .v-select {
        margin-bottom: 5px;
    }

    .v-select.open .dropdown-toggle {
        border-bottom: 1px solid #ccc;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
        height: 25px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
    }

    .v-select .vs__selected-options {
        overflow: hidden;
        flex-wrap: nowrap;
    }

    .v-select .selected-tag {
        margin: 2px 0px;
        white-space: nowrap;
        position: absolute;
        left: 0px;
    }

    .v-select .vs__actions {
        margin-top: -5px;
    }

    .v-select .dropdown-menu {
        width: auto;
        overflow-y: auto;
    }
</style>
<div id="exchanges">
    <div class="row" style="margin-top: 15px;">
        <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 col-xs-4 control-label no-padding-right"> Exchange Code </label>
                    <div class="col-md-2 col-xs-8">
                        <input type="text" placeholder="Code" class="form-control" v-model="exchange.Exchange_Code" required readonly />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 col-xs-4 control-label no-padding-right"> Customer </label>
                    <div class="col-md-3 col-xs-8">
                        <v-select v-bind:options="customers" label="display_name" v-model="selectedCustomer" placeholder="Select Customer"></v-select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 col-xs-4 control-label no-padding-right"> Date </label>
                    <div class="col-md-3 col-xs-8">
                        <input type="date" placeholder="Date" class="form-control" v-model="exchange.Exchange_Date" required />
                    </div>
                </div>
            </div>
        </div>
        <form class="form-horizontal" @submit.prevent="addExchange">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label no-padding-right"></label>
                    <label class="col-md-1 control-label no-padding-right"></label>
                    <div class="col-md-7">
                        <h4 style="margin: 0;">Received Product</h4>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5 control-label no-padding-right"></label>
                    <div class="col-md-7">
                        <v-select v-bind:options="products" label="display_text" v-model="selectedProduct" placeholder="Select Product"></v-select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-5 control-label no-padding-right"></label>
                    <div class="col-md-7">
                        <input type="number" class="form-control" v-model="exchange.Received_Quantity" required />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-md-7">
                        <h4 style="margin: 0;">Exchange Product</h4>
                    </div>
                    <label class="col-md-5 control-label no-padding-right"></label>
                </div>
                <div class="form-group">
                    <div class="col-md-7">
                        <v-select v-bind:options="productExchange" label="display_text" v-model="selectedExchangeProduct" placeholder="Select Product"></v-select>
                    </div>
                    <label class="col-md-5 control-label no-padding-right"></label>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="number" class="form-control" v-model="exchange.Exchange_Quantity" required />
                    </div>
                    <label class="col-md-5 control-label no-padding-right"></label>
                </div>
            </div>

            <div class="col-md-6 col-md-offset-3">
                <textarea class="form-control" placeholder="Description" v-model="exchange.Exchange_Description" required></textarea>
            </div>

            <div class="col-md-12 text-center" style="margin-top: 10px;">
                <button type="submit" class="btn btn-sm btn-success">
                    Submit
                    <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12 form-inline">
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
                            <td>{{ row.Customer_Name }}</td>
                            <td>{{ row.receivedProductName }} - {{ row.receivedProductCode }}</td>
                            <td>{{ row.Received_Quantity }}</td>
                            <td>{{ row.exchangeProductName }} - {{ row.exchangeProductCode }}</td>
                            <td>{{ row.Exchange_Quantity }}</td>
                            <td>{{ row.Exchange_Description }}</td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" class="button edit" @click="editExchange(row)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="button" @click="deleteExchange(row.Exchange_SlNo)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                <?php } ?>
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#exchanges',
        data() {
            return {
                exchange: {
                    Exchange_SlNo: 0,
                    Exchange_Code: '<?php echo $exchangeCode; ?>',
                    Exchange_Date: moment().format('YYYY-MM-DD'),
                    receivedProduct: '',
                    Received_Quantity: 0,
                    exchangeProduct: '',
                    Exchange_Quantity: 0,
                    Exchange_Description: '',
                    CustomerID: '',
                },
                products: [],
                selectedProduct: null,
                productExchange: [],
                selectedExchangeProduct: null,
                customers: [],
                selectedCustomer: null,
                exchanges: [],

                columns: [
                    {label: 'Code',field: 'Exchange_Code',align: 'center',filterable: false},
                    {label: 'Date',field: 'SaleExchange_ExchangeDate',align: 'center'},
                    {label: 'Customer Name',field: 'Customer_Name',align: 'center'},
                    {label: 'Received Product',field: 'receivedProductName',align: 'center'},
                    {label: 'ReceivedQty',field: 'ReceivedQty',align: 'center'},
                    {label: 'Exchange Product',field: 'exchangeProductName',align: 'center'},
                    {label: 'ExchangeQty',field: 'ExchangeQty',align: 'center'},
                    {label: 'Description',field: 'SaleExchange_Description',align: 'center'},
                    {label: 'Action',align: 'center',filterable: false}
                ],
                page: 1,
                per_page: 10,
                filter: ''
            }
        },
        created() {
            this.getProducts();
            this.getCustomers();
            this.getExchanges();
        },
        methods: {
            getCustomers() {
                axios.post('/get_customers', {
                    id: ''
                }).then(res => {
                    this.customers = res.data;
                    this.customers.unshift({
                        Customer_SlNo: 'C01',
                        Customer_Code: '',
                        Customer_Name: '',
                        display_name: 'General Customer',
                        Customer_Mobile: '',
                        Customer_Address: '',
                        Customer_Type: 'G'
                    })
                })
            },
            getProducts() {
                axios.get('/get_products').then(res => {
                    this.products = res.data;
                    this.productExchange = res.data;
                })
            },
            addExchange() {
                if (this.selectedCustomer == null) {
                    alert('Select Customer');
                    return;
                }
                if (this.selectedProduct == null) {
                    alert('Select received product');
                    return;
                }
                if (this.selectedExchangeProduct == null) {
                    alert('Select exchange product');
                    return;
                }
                if (parseFloat(this.exchange.Received_Quantity) == 0 || this.exchange.Received_Quantity == '') {
                    alert('Received Qty is required');
                    return;
                }
                if (parseFloat(this.exchange.Exchange_Quantity) == 0 || this.exchange.Exchange_Quantity == '') {
                    alert('Exchange Qty is required');
                    return;
                }

                this.exchange.receivedProduct = this.selectedProduct.Product_SlNo;
                this.exchange.exchangeProduct = this.selectedExchangeProduct.Product_SlNo;
                this.exchange.CustomerID      = this.selectedCustomer.Customer_SlNo;

                let url = '/add_exchange';
                if (this.exchange.Exchange_SlNo != 0) {
                    url = '/update_exchange'
                }
                axios.post(url, this.exchange).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.resetForm();
                        this.exchange.Exchange_Code = r.newCode;
                        this.getExchanges();
                    }
                })
            },

            editExchange(exchange) {
                this.exchange = exchange;
                this.selectedProduct = {
                    Product_SlNo: exchange.receivedProduct,
                    display_text: `${exchange.receivedProductName} - ${exchange.receivedProductCode}`
                }
                this.selectedExchangeProduct = {
                    Product_SlNo: exchange.exchangeProduct,
                    display_text: `${exchange.exchangeProductName} - ${exchange.exchangeProductCode}`
                }
                this.selectedCustomer = {
                    Customer_SlNo: exchange.CustomerID,
                    display_name: exchange.CustomerID == 0 ? 'General Customer' : exchange.display_name,
                }
            },

            deleteExchange(exchangeId) {
                let deleteConfirm = confirm('Are you sure?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete_exchange', {
                    exchangeId: exchangeId
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getExchanges();
                    }
                })
            },

            getExchanges() {
                axios.get('/get_exchanges').then(res => {
                    this.exchanges = res.data;
                })
            },

            resetForm() {
                this.exchange.Exchange_SlNo        = '';
                this.exchange.Exchange_Date        = moment().format("YYYY-MM-DD");
                this.exchange.Exchange_Description = '';
                this.exchange.receivedProduct      = '';
                this.exchange.exchangeProduct      = '';
                this.exchange.Received_Quantity    = 0;
                this.exchange.Exchange_Quantity    = 0;
                this.selectedCustomer              = null;
                this.selectedProduct               = null;
                this.selectedExchangeProduct       = null;
            }
        }
    })
</script>