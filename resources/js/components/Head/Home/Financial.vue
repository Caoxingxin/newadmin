<template>
    <div class="box-card">
        <p style="font-size: 18px;">近10笔订单</p>
        <el-table :data="list" style="width: 100%;" class="text item">
            <el-table-column label="Order_No" min-width="100px">
                <template slot-scope="scope">
                    <!--                {{ scope.row.id | orderNoFilter }}-->
                    {{ scope.row.id }}
                </template>
            </el-table-column>
            <el-table-column label="Price" width="195" align="center">
                <template slot-scope="scope">
                    ¥{{ scope.row.actual_total}}
                </template>
            </el-table-column>
            <el-table-column label="Status" width="100" align="center">
                <template slot-scope="{row}">
                    <el-tag :type="row.type | statusFilter">
                        {{ row.type==10 ? '付款' : '退款'  }}
                    </el-tag>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
export default {
    name: "Financial",
    data() {
        return {
            list: [{
                id: '',
                actual_total: '',
                type: ''
            }]
        }
    },
    filters: {
        statusFilter(status) {
            const statusMap = {
                '10': 'success',
                '-10': 'danger'
            }
            return statusMap[status]
        },
        orderNoFilter(str) {
            console.log(str);
            return str.substring(0, 30)
        }
    },
    created() {
        this.order_list()
    },
    methods: {
        order_list(){
            var url = "index/get-order-list"
            this.axios.get(url).then(response => {
                this.list = response.data.slice(0, 10)
            }).catch(function (error) {
                console.log(error);
            });
        },
    }
}
</script>

<style scoped>
.box-card {
    flex: 1;
    margin-right: 20px;
    background: #ffffff;
    border-radius: 5px;
    padding: 20px;
}

.text {
    font-size: 14px;
}

.item {
    margin-top: 0;
}
.clearfix:before,
.clearfix:after {
    display: table;
    content: "";
}
.clearfix:after {
    clear: both;
}
</style>
