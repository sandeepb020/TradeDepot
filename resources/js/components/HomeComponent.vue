<template>
<el-container>
  <el-header>
  <h2 class="text-center mt-2">Trade Depot - Orders</h2>
  </el-header>
  <el-main>
   <el-table
        :data="orderpage"
        border
        style="width: 100%">
        <el-table-column
        prop="CustomerID"
        label="Customer ID"
        width="180">
        </el-table-column>

        <el-table-column
        prop="RefNumber"
        label="Reference No"
        width="180">
        </el-table-column>

        <el-table-column
        prop="Status"
        label="Status"
        width="180">
        </el-table-column>

        <el-table-column
        prop="TotalAmount"
        label="Total Amount"
        width="180">
        </el-table-column>

        <el-table-column
        prop="TxnDate"
        label="Transaction Date"
        width="180">
        </el-table-column>
    </el-table>
    <el-pagination
  background
  layout="prev, pager, next"
  @current-change="handleCurrentChange"
        :hide-on-single-page="true"
        :page-size="pagesize"
        :total="orders.length">
</el-pagination>

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
        orderpage:[]
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
        getOrders: function () {
        axios
      .get('api/orders')
      .then(response => {
      console.log(response.data.data)
      this.orders = response.data.data;
            this.paginateorders(1)
      })
    },
    handleCurrentChange(val) {
    console.log(val)
        this.paginateorders(val)
    },
  }
    }
</script>
