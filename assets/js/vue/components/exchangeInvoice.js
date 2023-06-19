const exchangeInvoice = Vue.component("exchange-invoice", {
  template: `
          <div>
              <div class="row">
                  <div class="col-xs-12">
                      <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
                  </div>
              </div>
              
              <div id="invoiceContent">
                  <div class="row">
                      <div class="col-xs-12 text-center">
                          <div _h098asdh>
                              Exchange Invoice
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-xs-7">
                          <strong>Customer Id:</strong> {{ exchanges.Customer_Code }}<br>
                          <strong>Customer Name:</strong> {{ exchanges.Customer_Name }}<br>
                          <strong>Customer Address:</strong> {{ exchanges.Customer_Address }}<br>
                          <strong>Customer Mobile:</strong> {{ exchanges.Customer_Mobile }}
                      </div>
                      <div class="col-xs-5 text-right">
                          <strong>Exchanges by:</strong> {{ exchanges.AddBy }}<br>
                          <strong>Invoice No:</strong> {{ exchanges.Exchange_Code }}<br>
                          <strong>Exchange Date:</strong> {{ exchanges.Exchange_Date }} {{ exchanges.AddTime | formatDateTime('h:mm a') }}
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-xs-12">
                          <div _d9283dsc></div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-xs-6">
                      <h4 style="margin:0;">Received Product</h4>
                          <table _a584de>
                              <thead>
                                  <tr>
                                      <td>Sl.</td>
                                      <td>Description</td>
                                      <td>Qnty</td>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>1</td>
                                      <td>{{exchanges.receivedProductName}}</td>
                                      <td>{{exchanges.Received_Quantity}}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                      <div class="col-xs-6">
                          <h4 style="margin:0;">Exchange Product</h4>
                          <table _a584de>
                              <thead>
                                  <tr>
                                      <td>Sl.</td>
                                      <td>Description</td>
                                      <td>Qnty</td>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>1</td>
                                      <td>{{exchanges.exchangeProductName}}</td>
                                      <td>{{exchanges.Exchange_Quantity}}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      `,
  props: ["exchange_id"],
  data() {
    return {
      exchanges: {},
      style: null,
      currentBranch: null,
    };
  },
  filters: {
    formatDateTime(dt, format) {
      return dt == "" || dt == null ? "" : moment(dt).format(format);
    },
  },
  created() {
    this.setStyle();
    this.getExchange();
    this.getCurrentBranch();
  },
  methods: {
    getExchange() {
      axios
        .post("/get_exchanges", { exchangeId: this.exchange_id })
        .then((res) => {
            console.log(res.data);
          this.exchanges = res.data[0];
        });
    },
    getCurrentBranch() {
      axios.get("/get_current_branch").then((res) => {
        this.currentBranch = res.data;
      });
    },
    setStyle() {
      this.style = document.createElement("style");
      this.style.innerHTML = `
                  div[_h098asdh]{
                      /*background-color:#e0e0e0;*/
                      font-weight: bold;
                      font-size:15px;
                      margin-bottom:15px;
                      padding: 5px;
                      border-top: 1px dotted #454545;
                      border-bottom: 1px dotted #454545;
                  }
                  .duePart {
                      margin-top:50px;
                  }
                  .tableDue {
                      width:100%;
                  }
                  div[_d9283dsc]{
                      padding-bottom:25px;
                      border-bottom: 1px solid #ccc;
                      margin-bottom: 15px;
                  }
                  table[_a584de]{
                      width: 100%;
                      text-align:center;
                  }
                  table[_a584de] thead{
                      font-weight:bold;
                  }
                  table[_a584de] td{
                      padding: 3px;
                      border: 1px solid #ccc;
                  }
                  table[_t92sadbc2]{
                      width: 100%;
                  }
                  table[_t92sadbc2] td{
                      padding: 2px;
                  }
              `;
      document.head.appendChild(this.style);
    },
    async print() {
      let invoiceContent = document.querySelector("#invoiceContent").innerHTML;
      let printWindow = window.open(
        "",
        "PRINT",
        `width=${screen.width}, height=${screen.height}, left=0, top=0`
      );
      if (this.currentBranch.print_type == "3") {
        printWindow.document.write(`
                      <html>
                          <head>
                              <title>Invoice</title>
                              <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                              <style>
                                  body, table{
                                      font-size:11px;
                                  }
                              </style>
                          </head>
                          <body>
                              <div style="text-align:center;">
                                  <img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:80px;margin:0px;" /><br>
                                  <strong style="font-size:18px;">${this.currentBranch.Company_Name}</strong><br>
                                  <p style="white-space:pre-line;">${this.currentBranch.Repot_Heading}</p>
                              </div>
                              ${invoiceContent}
                          </body>
                      </html>
                  `);
      } else if (this.currentBranch.print_type == "2") {
        printWindow.document.write(`
                      <!DOCTYPE html>
                      <html lang="en">
                      <head>
                          <meta charset="UTF-8">
                          <meta name="viewport" content="width=device-width, initial-scale=1.0">
                          <meta http-equiv="X-UA-Compatible" content="ie=edge">
                          <title>Invoice</title>
                          <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                          <style>
                              html, body{
                                  width:500px!important;
                              }
                              body, table{
                                  font-size: 13px;
                              }
                          </style>
                      </head>
                      <body>
                          <div class="row">
                              <div class="col-xs-2"><img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:80px;" /></div>
                              <div class="col-xs-10" style="padding-top:20px;text-align:center;">
                                  <strong style="font-size:18px;">${this.currentBranch.Company_Name}</strong><br>
                                  <p style="white-space:pre-line;">${this.currentBranch.Repot_Heading}</p>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  ${invoiceContent}
                              </div>
                          </div>
                      </body>
                      </html>
                  `);
      } else {
        printWindow.document.write(`
                      <!DOCTYPE html>
                      <html lang="en">
                      <head>
                          <meta charset="UTF-8">
                          <meta name="viewport" content="width=device-width, initial-scale=1.0">
                          <meta http-equiv="X-UA-Compatible" content="ie=edge">
                          <title>Invoice</title>
                          <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                          <style>
                              body, table{
                                  font-size: 13px;
                              }
                          </style>
                      </head>
                      <body>
                          <div class="container">
                              <table style="width:100%;">
                                  <thead>
                                      <tr>
                                          <td>
                                              <div class="row">
                                                  <div class="col-xs-2"><img src="${
                                                    location.origin +
                                                    "/uploads/company_profile_org/" +
                                                    this.currentBranch
                                                      .Company_Logo_org
                                                  }" alt="Logo" style="height:80px;" /></div>
                                                  <div class="col-xs-10" style="padding-top:20px;text-align:center;">
                                                      <strong style="font-size:18px;">${
                                                        this.currentBranch
                                                          .Company_Name
                                                      }</strong><br>
                                                      <p style="white-space:pre-line;">${
                                                        this.currentBranch
                                                          .Repot_Heading
                                                      }</p>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-xs-12">
                                                      <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                                                  </div>
                                              </div>
                                          </td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                          <td>
                                              <div class="row">
                                                  <div class="col-xs-12">
                                                      ${invoiceContent}
                                                  </div>
                                              </div>
                                          </td>
                                      </tr>
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <td>
                                              <div style="width:100%;height:50px;">&nbsp;</div>
                                          </td>
                                      </tr>
                                  </tfoot>
                              </table>
                              <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:5px;margin-top:30px;padding-bottom:6px;">
                                  <div class="col-xs-6">
                                      <span style="text-decoration:overline;">Received by</span><br><br>
                                      ** THANK YOU FOR YOUR BUSINESS **
                                  </div>
                                  <div class="col-xs-6 text-right">
                                      <span style="text-decoration:overline;">Authorized by</span>
                                  </div>
                              </div>
                              <div style="position:fixed;left:0;bottom:15px;width:100%;">
                                  <div class="row" style="font-size:12px;">
                                      <div class="col-xs-12" style="text-align:center;">
                                          Print Date: ${moment().format(
                                            "DD-MM-YYYY h:mm a"
                                          )}, Printed by: ${this.exchanges.AddBy}
                                      </div>
                                      <!-- <div class="col-xs-6 text-right">
                                          Developed by: Link-Up Technologoy, Contact no: 01911978897
                                      </div> -->
                                  </div>
                              </div>
                          </div>
                          
                      </body>
                      </html>
                  `);
      }
      let invoiceStyle = printWindow.document.createElement("style");
      invoiceStyle.innerHTML = this.style.innerHTML;
      printWindow.document.head.appendChild(invoiceStyle);
      printWindow.moveTo(0, 0);

      printWindow.focus();
      await new Promise((resolve) => setTimeout(resolve, 1000));
      printWindow.print();
      printWindow.close();
    },
  },
});
