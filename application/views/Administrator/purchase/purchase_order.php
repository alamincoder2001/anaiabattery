<style>
	.v-select {
		margin-bottom: 5px;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
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

	#branchDropdown .vs__actions button {
		display: none;
	}

	#branchDropdown .vs__actions .open-indicator {
		height: 15px;
		margin-top: 7px;
	}
</style>

<div class="row" id="purchase">
	<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
		<div class="row">
			<div class="form-group">
				<label class="col-xs-4 col-lg-1 control-label"> Invoice no </label>
				<div class="col-xs-8 col-lg-2">
					<input type="text" id="invoice" name="invoice" class="form-control" v-model="purchase.invoice" readonly style="height:26px;" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-4 col-lg-1 control-label purchase_padding"> Purchase For </label>
				<div class="col-xs-8 col-lg-2">
					<v-select id="branchDropdown" v-bind:options="branches" v-model="selectedBranch" label="Brunch_name" disabled></v-select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-4 col-lg-1 control-label"> Date </label>
				<div class="col-xs-8 col-lg-2">
					<input class="form-control" id="purchaseDate" name="purchaseDate" type="date" v-model="purchase.purchaseDate" v-bind:disabled="userType == 'u' ? true : false" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-4 col-lg-1 control-label"> Reference </label>
				<div class="col-xs-8 col-lg-2">
					<input class="form-control" id="reference" type="text" v-model="purchase.reference" />
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-9 col-md-9 col-lg-9">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Supplier & Product Information</h4>
				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="row">
						<div class="col-xs-12 col-lg-6">
							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Supplier </label>
								<div class="col-xs-7">
									<v-select v-bind:options="suppliers" v-model="selectedSupplier" v-on:input="onChangeSupplier" label="display_name"></v-select>
								</div>
								<div class="col-xs-1" style="padding: 0;">
									<a href="<?= base_url('supplier') ?>" title="Add New Supplier" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
								</div>
							</div>

							<div class="form-group" v-bind:style="{display: selectedSupplier.Supplier_Type == 'G' ? '' : 'none'}">
								<label class="col-lg-4 col-xs-4 control-label no-padding-right"> Name </label>
								<div class="col-lg-8 col-xs-8">
									<input type="text" placeholder="Supplier Name" class="form-control" v-model="selectedSupplier.Supplier_Name" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-4 col-xs-4 control-label no-padding-right"> Mobile No </label>
								<div class="col-lg-8 col-xs-8">
									<input type="text" placeholder="Mobile No" class="form-control" v-model="selectedSupplier.Supplier_Mobile" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? false : true" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-4 col-xs-4 control-label no-padding-right"> Address </label>
								<div class="col-lg-8 col-xs-8">
									<textarea class="form-control" v-model="selectedSupplier.Supplier_Address" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? false : true"></textarea>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-lg-6">
							<form v-on:submit.prevent="addToCart">
								<div class="form-group">
									<label class="col-lg-4 col-xs-4 control-label no-padding-right"> Batch Number </label>
									<div class="col-lg-7 col-xs-7">
										<v-select id="batch" v-bind:options="batches" v-model="selectedBatch" label="Batch_Serial"></v-select>
									</div>
									<div class="col-xs-1" style="padding: 0;">
										<a href="<?= base_url('batch') ?>" title="Add New Batch" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4 col-xs-4 control-label no-padding-right"> Product </label>
									<div class="col-lg-7 col-xs-7">
										<v-select id="product" v-bind:options="products" v-model="selectedProduct" ref="product" label="display_text" v-on:input="onChangeProduct"></v-select>
									</div>
									<div class="col-xs-1" style="padding: 0;">
										<a href="<?= base_url('product') ?>" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4 col-xs-4 control-label no-padding-right"> Pur. Rate </label>
									<div class="col-lg-8 col-xs-8">
										<input type="text" id="purchaseRate" name="purchaseRate" class="form-control" placeholder="Pur. Rate" v-model="selectedProduct.Product_Purchase_Rate" v-on:input="productTotal" autocomplete="off" />
									</div>
								</div>
								<tr>
									<td>
										<div class="form-group">
											<label class="col-lg-4 col-xs-4 control-label no-padding-right">Quantity</label>
											<div class="col-lg-8 col-xs-8">
												<input type="number" step="0.01" id="quantity" name="quantity" ref="quantity" class="form-control" value="0" v-model=" selectedProduct.quantity" v-on:input="productTotal" autocomplete="off" />
											</div>
										</div>
									</td>
								</tr>
								<div class="form-group">
									<label class="col-lg-4 col-xs-4 control-label no-padding-right"> Total Amount </label>
									<div class="col-lg-8 col-xs-8">
										<input type="text" id="productTotal" name="productTotal" class="form-control" readonly v-model="selectedProduct.total" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-4 col-xs-4 control-label no-padding-right"> Selling Price </label>
									<div class="col-lg-8 col-xs-8">
										<input type="text" id="sellingPrice" name="sellingPrice" class="form-control" v-model="selectedProduct.Product_SellingPrice" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-4 col-xs-4 control-label no-padding-right"> </label>
									<div class="col-lg-8 col-xs-8">
										<button type="submit" class="btn btn-default pull-right">Add Cart</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
			<div class="table-responsive">
				<table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
					<thead>
						<tr>
							<th style="width:4%;color:#000;">SL</th>
							<th style="width:20%;color:#000;">Product Name</th>
							<th style="width:20%;color:#000;">Batch Number</th>
							<th style="width:8%;color:#000;">Purchase Rate</th>
							<th style="width:5%;color:#000;">Quantity</th>
							<th style="width:13%;color:#000;">Total Amount</th>
							<th style="width:20%;color:#000;">Action</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
						<tr v-for="(product, sl) in cart">
							<td>{{ sl + 1}}</td>
							<td>{{ product.name }}</td>
							<td>{{ product.Batch_Number }}</td>
							<td>{{ product.purchaseRate }}</td>
							<td>{{ product.quantity }}</td>
							<td>{{ product.total }}</td>
							<td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
						</tr>
						<tr>
							<td colspan="7"></td>
						</tr>
						<tr style="font-weight: bold;">
							<td colspan="3">Note</td>
							<td colspan="2" style="text-align:right">Total Qty = {{
								cart.reduce((prev, cur) => { return prev + parseFloat(cur.quantity)}, 0)
							 }}</td>
							<td colspan="2">Sub Total</td>
						</tr>
						<tr>
							<td colspan="5"><textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="purchase.note"></textarea></td>
							<td colspan="2" style="padding-top: 15px;font-size:18px;">{{ purchase.subTotal }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-md-3 col-lg-3">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Amount Details</h4>
				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive">
								<table style="color:#000;margin-bottom: 0px;">
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Sub Total</label>
												<div class="col-xs-12">
													<input type="number" id="subTotal" name="subTotal" class="form-control" v-model="purchase.subTotal" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right"> Vat </label>
												<div class="col-xs-12">
													<input type="number" id="vatPercent" name="vatPercent" v-model="vatPercent" v-on:input="calculateTotal" style="width:50px;height:25px;" />
													<span style="width:20px;"> % </span>
													<input type="number" id="vat" name="vat" v-model="purchase.vat" readonly style="width:140px;height:25px;" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Discount</label>
												<div class="col-xs-12">
													<input type="number" id="discount" name="discount" class="form-control" v-model="purchase.discount" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Transport / Labour Cost</label>
												<div class="col-xs-12">
													<input type="number" id="freight" name="freight" class="form-control" v-model="purchase.freight" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Total</label>
												<div class="col-xs-12">
													<input type="number" id="total" class="form-control" v-model="purchase.total" readonly />
												</div>
											</div>
										</td>
									</tr>

									<!-- <tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Payment Type</label>
												<div class="col-sm-12">
													<select v-model="purchase.payment_type" class="form-control" style="padding: 1px;">
														<option value="cash">Cash</option>
														<option value="bank">Bank</option>
													</select>
												</div>
											</div>
										</td>
									</tr> -->

									<!-- <tr style="display: none;" :style="{display: purchase.payment_type == 'bank' ? '' : 'none'}">
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Bank Account</label>
												<div class="col-sm-12">
													<v-select v-bind:options="accounts" v-model="account" label="display_text"></v-select>
												</div>
											</div>
										</td>
									</tr> -->

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Paid</label>
												<div class="col-xs-12">
													<input type="number" id="paid" class="form-control" v-model="purchase.paid" @input='calculateTotal' v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? true : false" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label">Due</label>
												<div class="col-sm-6">
													<input type="number" id="due" class="form-control" v-model="purchase.due" readonly />
												</div>
												<div class="col-sm-6">
													<input type="number" id="previousDue" class="form-control" v-model="purchase.previousDue" readonly style="color:red;" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<div class="col-xs-6">
													<input type="button" class="btn btn-success" value="Purchase" v-on:click="savePurchase" v-bind:disabled="purchaseOnProgress == true ? true : false" style="background:#000;color:#fff;padding:3px;width:100%;">
												</div>
												<div class="col-xs-6">
													<input type="button" class="btn btn-info" onclick="window.location = '<?php echo base_url(); ?>purchase'" value="New Purch.." style="background:#000;color:#fff;padding:3px;width:100%;">
												</div>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- app -->
<script src="<?php echo base_url(); ?>assets/js/vue/vue.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script>
	Vue.component('v-select', VueSelect.VueSelect);
	// register modal component
	Vue.component('modal', {
		template: '#serial-modal'
	})
	new Vue({
		el: '#purchase',
		data() {
			return {
				purchase: {
					purchaseId: parseInt('<?php echo $purchaseId; ?>'),
					invoice: '<?php echo $invoice; ?>',
					purchaseFor: '',
					purchaseDate: moment().format('YYYY-MM-DD'),
					supplierId: '',
					subTotal: 0.00,
					vat: 0.00,
					discount: 0.00,
					freight: 0.00,
					total: 0.00,
					paid: 0.00,
					due: 0.00,
					previousDue: 0.00,
					note: '',
					reference: ''
				},
				vatPercent: 0.00,
				branches: [],
				selectedBranch: {
					brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
					Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>"
				},
				suppliers: [],
				selectedSupplier: {
					Supplier_SlNo: null,
					Supplier_Code: '',
					Supplier_Name: '',
					display_name: 'Select Supplier',
					Supplier_Mobile: '',
					Supplier_Address: '',
					Supplier_Type: ''
				},
				oldSupplierId: null,
				oldPreviousDue: 0,
				products: [],
				selectedProduct: {
					Product_SlNo: '',
					Product_Code: '',
					display_text: 'Select Product',
					Product_Name: '',
					Unit_Name: '',
					quantity: '',
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0.00,
					total: '',
				},
				batches: [],
				selectedBatch: null,
				cart: [],
				purchaseOnProgress: false,
				userType: '<?php echo $this->session->userdata("accountType") ?>'
			}
		},
		created() {
			this.getBranches();
			this.getBatches();
			this.getSuppliers();
			this.getProducts();

			if (this.purchase.purchaseId != 0) {
				this.getPurchase();
			}
		},
		methods: {
			getBranches() {
				axios.get('/get_branches').then(res => {
					this.branches = res.data;
				})
			},
			getBatches() {
				axios.get('/get_batchs').then(res => {
					this.batches = res.data;
				})
			},
			getSuppliers() {
				axios.get('/get_suppliers').then(res => {
					this.suppliers = res.data.filter(sup => {
						return sup.Supplier_Type != "G";
					});
					this.suppliers.unshift({
						Supplier_SlNo: 'S01',
						Supplier_Code: '',
						Supplier_Name: '',
						display_name: 'General Supplier',
						Supplier_Mobile: '',
						Supplier_Address: '',
						Supplier_Type: 'G'
					})
				})
			},
			getProducts() {
				axios.post('/get_products', {
					isService: 'false'
				}).then(res => {
					this.products = res.data;
				})
			},
			onChangeSupplier() {
				if(this.selectedSupplier.Supplier_SlNo == null){
					return
				}
				if (this.purchase.purchaseId != 0 && this.oldSupplierId != parseInt(this.selectedSupplier.Supplier_SlNo)) {
					let changeConfirm = confirm('Changing supplier will set previous due to current due amount. Do you really want to change supplier?');
					if (changeConfirm == false) {
						return;
					}
				} else if (this.purchase.purchaseId != 0 && this.oldSupplierId == parseInt(this.selectedSupplier.Supplier_SlNo)) {
					this.purchase.previousDue = this.oldPreviousDue;
					return;
				}
				axios.post('/get_supplier_due', {
					supplierId: this.selectedSupplier.Supplier_SlNo
				}).then(res => {
					if (res.data.length > 0) {
						this.purchase.previousDue = res.data[0].due;
					} else {
						this.purchase.previousDue = 0;
					}
				})
				this.calculateTotal();
			},
			onChangeProduct() {
				if (this.selectedProduct.Product_Name != "") {
					this.$refs.quantity.focus();

				}

			},
			productTotal() {
				this.selectedProduct.total = this.selectedProduct.quantity * this.selectedProduct.Product_Purchase_Rate;
			},
			addToCart() {
				let cartInd = this.cart.findIndex(p => p.productId == this.selectedProduct.Product_SlNo);
				if (cartInd > -1) {
					this.cart.splice(cartInd, 1)
				}
				let product = {
					productId: this.selectedProduct.Product_SlNo,
					Batch_Id: this.selectedBatch.id,
					Batch_Number: this.selectedBatch.Batch_Serial,
					name: this.selectedProduct.Product_Name,
					categoryId: this.selectedProduct.ProductCategory_ID,
					categoryName: this.selectedProduct.ProductCategory_Name,
					purchaseRate: this.selectedProduct.Product_Purchase_Rate,
					salesRate: this.selectedProduct.Product_SellingPrice,
					quantity: this.selectedProduct.quantity,
					total: this.selectedProduct.total,
					discount: this.selectedProduct.discount,
				}

				this.cart.push(product);
				this.clearSelectedProduct();
				this.calculateTotal();
				// document.querySelector('#product input[role="combobox"]').focus();

			},
			async removeFromCart(ind) {
				this.cart.splice(ind, 1);
				this.calculateTotal();
			},
			clearSelectedProduct() {
				this.selectedProduct = {
					Product_SlNo: '',
					Product_Code: '',
					display_text: 'Select Product',
					Product_Name: '',
					Unit_Name: '',
					quantity: '',
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0.00,
					total: '',
					discount: 0
				}
				this.selectedBatch = null
			},
			calculateTotal() {
				this.purchase.subTotal = this.cart.reduce((prev, curr) => {
					return prev + parseFloat(curr.total);
				}, 0);
				this.purchase.vat = (this.purchase.subTotal * this.vatPercent) / 100;
				this.purchase.total = (parseFloat(this.purchase.subTotal) + parseFloat(this.purchase.vat) + parseFloat(this.purchase.freight)) - this.purchase.discount;

				if (this.selectedSupplier != null) {
					if (this.selectedSupplier.Supplier_Type != "G") {
						this.purchase.due = this.purchase.total - this.purchase.paid;
					} else {
						this.purchase.paid = this.purchase.total
						this.purchase.due = 0
					}
				}
			},
			savePurchase() {
				if (this.selectedSupplier.Supplier_SlNo == null) {
					alert('Select supplier');
					return;
				}

				if (this.purchase.purchaseDate == '') {
					alert('Enter purchase date');
					return;
				}

				if (this.cart.length == 0) {
					alert('Cart is empty');
					return;
				}

				this.purchase.supplierId = this.selectedSupplier.Supplier_SlNo;
				this.purchase.purchaseFor = this.selectedBranch.brunch_id;

				this.purchaseOnProgress = true;

				let data = {
					purchase: this.purchase,
					cartProducts: this.cart
				}

				if (this.selectedSupplier.Supplier_Type == 'G') {
					data.supplier = this.selectedSupplier;
				}

				let url = '/add_purchase';
				if (this.purchase.purchaseId != 0) {
					url = '/update_purchase';
				}
				axios.post(url, data).then(async res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						let conf = confirm('Do you want to view invoice?');
						if (conf) {
							window.open(`/purchase_invoice_print/${r.purchaseId}`, '_blank');
							await new Promise(r => setTimeout(r, 1000));
							window.location = '/purchase';
						} else {
							window.location = '/purchase';
						}
					} else {
						this.purchaseOnProgress = false;
					}
				})
			},
			getPurchase() {
				axios.post('/get_purchases', {
					purchaseId: this.purchase.purchaseId
				}).then(res => {
					let r = res.data;
					let purchase = r.purchases[0];

					this.selectedSupplier.Supplier_SlNo = purchase.Supplier_SlNo;
					this.selectedSupplier.Supplier_Code = purchase.Supplier_Code;
					this.selectedSupplier.Supplier_Name = purchase.Supplier_Name;
					this.selectedSupplier.Supplier_Mobile = purchase.Supplier_Mobile;
					this.selectedSupplier.Supplier_Address = purchase.Supplier_Address;
					this.selectedSupplier.Supplier_Type = purchase.Supplier_Type;
					this.selectedSupplier.display_name = purchase.Supplier_Type == 'G' ? 'General Supplier' : `${purchase.Supplier_Code} - ${purchase.Supplier_Name}`;
					this.purchase.invoice = purchase.PurchaseMaster_InvoiceNo;
					this.purchase.purchaseFor = purchase.PurchaseMaster_PurchaseFor;
					this.purchase.purchaseDate = purchase.PurchaseMaster_OrderDate;
					this.purchase.supplierId = purchase.Supplier_SlNo;
					this.purchase.subTotal = purchase.PurchaseMaster_SubTotalAmount;
					this.purchase.vat = purchase.PurchaseMaster_Tax;
					this.purchase.discount = purchase.PurchaseMaster_DiscountAmount;
					this.purchase.freight = purchase.PurchaseMaster_Freight;
					this.purchase.total = purchase.PurchaseMaster_TotalAmount;
					this.purchase.paid = purchase.PurchaseMaster_PaidAmount;
					this.purchase.due = purchase.PurchaseMaster_DueAmount;
					this.purchase.previousDue = purchase.previous_due;
					this.purchase.note = purchase.PurchaseMaster_Description;
					this.purchase.reference = purchase.reference;

					this.oldSupplierId = purchase.Supplier_SlNo;
					this.oldPreviousDue = purchase.previous_due;

					this.vatPercent = (this.purchase.vat * 100) / this.purchase.subTotal;

					r.purchaseDetails.forEach(product => {
						let cartProduct = {
							productId: product.Product_IDNo,
							Batch_Id: product.Batch_Id,
							Batch_Number: product.Batch_Serial,
							name: product.Product_Name,
							categoryId: product.ProductCategory_ID,
							categoryName: product.ProductCategory_Name,
							purchaseRate: product.PurchaseDetails_Rate,
							salesRate: product.Product_SellingPrice,
							quantity: product.PurchaseDetails_TotalQuantity,
							total: product.PurchaseDetails_TotalAmount,
							discount: product.PurchaseDetails_Discount,
						}
						this.cart.push(cartProduct);
					})
				})
			}
		}
	})
</script>