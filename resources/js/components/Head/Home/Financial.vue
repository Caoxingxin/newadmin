<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>近7日收入订单</span>
        </div>
        <el-table :data="list" style="width: 100%;" class="text item">
            <el-table-column label="Order_No" min-width="100px">
                <template slot-scope="scope">
                    <!--                {{ scope.row.id | orderNoFilter }}-->
                    {{ scope.row.id }}
                </template>
            </el-table-column>
            <el-table-column label="Price" width="195" align="center">
                <template slot-scope="scope">
                    ¥{{ scope.row.address_en}}
                </template>
            </el-table-column>
            <el-table-column label="Status" width="100" align="center">
                <template slot-scope="{row}">
                    <el-tag :type="row.status | statusFilter">
                        {{ row.status }}
                    </el-tag>
                </template>
            </el-table-column>
        </el-table>
    </el-card>
</template>

<script>
    export default {
        name: "Financial",
        data() {
            return {
                list: [{
                    id: '',
                    address_en: '',
                    status: ''
                }]
            }
        },
        filters: {
            statusFilter(status) {
                const statusMap = {
                    '10': '',
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
            this.listData()
        },
        methods: {
            listData() {
                let url = "head/headSchool-list";
                this.axios.get(url).then(response => {
                    this.list = response.data.data.slice(0, 8)
                }).catch(function (error) {
                    console.log(error);
                });
            },
        }
    }
</script>

<style scoped>
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
        clear: both
    }

</style>
