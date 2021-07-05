<template>
<el-container>
  <el-header>
  <h2 class="text-center mt-2 pt-3">Trade Depot - Orders</h2>
  </el-header>
  <el-main>
   <el-table
        :data="orderpage"
        border
        @row-click="handle"
        :header-cell-style="boldHeader"
        style="width: 100%">

        <el-table-column
        prop="CustomerID"
        label="Customer ID"
        min-width="20">
        </el-table-column>

        <el-table-column
        prop="RefNumber"
        label="Reference No"
        min-width="20">
        </el-table-column>

        <el-table-column
        prop="Status"
        label="Status"
        min-width="20">
        </el-table-column>

        <el-table-column
        prop="TotalAmount"
        label="Total Amount"
        min-width="20">
        </el-table-column>

        <el-table-column
        prop="TxnDate"
        label="Transaction Date"
        min-width="20">
        </el-table-column>
    </el-table>
    <el-row>
    <el-pagination
        background
        layout="prev, pager, next"
        @current-change="handleCurrentChange"
        :hide-on-single-page="true"
        :page-size="pagesize"
        :total="orders.length">
    </el-pagination>
    </el-row>
<el-dialog title="Order Details" :visible.sync="dialogTableVisible">
<el-row :gutter="12">
  <el-col :span="12">
    <el-card shadow="hover">
      Customer ID - {{rowdata.CustomerID}}
    </el-card>
  </el-col>
  <el-col :span="12">
    <el-card shadow="hover">
      Reference No - {{rowdata.RefNumber}}
    </el-card>
  </el-col>
</el-row>

<el-row :gutter="12">
  <el-col :span="8">
    <el-card shadow="hover" class="boxAmount">
      Total Amount - ${{rowdata.TotalAmount}}
    </el-card>
  </el-col>
  <el-col :span="8">
    <el-card shadow="hover" class="boxStatus">
      Status - {{rowdata.Status}}
    </el-card>
  </el-col>
  <el-col :span="8">
    <el-card shadow="hover" class="boxDate">
      TXN Date - {{rowdata.TxnDate}}
    </el-card>
  </el-col>
</el-row>
</el-dialog>

  </el-main>
</el-container>
</template>

<script>
    export default {
        data() {
      return {
        orders:[],
        currentpage:1,
        pagesize:25,
        orderpage:[],
        dialogTableVisible: false,
        rowdata:{}
      }
    },
        mounted() {
            console.log('Component mounted.');
            this.getOrders();
        },
        computed: {
        datas: function () {

        }
        },
        methods: {
        paginateorders: function(val){
            let start = val == 1 ? 0 : (val - 1) * this.pagesize;
            this.orderpage = this.orders.slice(start, val*this.pagesize);
            console.log(this.orderpage)
        },
        boldHeader({ row, column, rowIndex, columnIndex }) {
            if (rowIndex === 0) {
            return 'background-color: red;color: #fff;font-weight: 500;'
            }
        },
        getOrders: function () {
        axios
        .get('api/orders')
        .then(response => {
        console.log(response.data.data)
        this.orders = response.data.data;
        this.paginateorders(1)
        })
    },
    handle(row, event, column) {
      console.log(row)
      this.dialogTableVisible = true;
      this.rowdata = row;
    },
    handleCurrentChange(val) {
    console.log(val)
        this.paginateorders(val)
    },
  }
    }
</script>

<style>
.el-row {
    text-align: center;
    margin-top: 10px;
}
.boxAmount {
    background: red;
    color: #fff;
}

.boxStatus {

}

.boxDate {
    background: black;
    color: #fff;
}
</style>
