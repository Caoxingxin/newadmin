<template>
    <div class="semester-wrap" v-if="schoolData">
        <el-card class="box-card">
            <el-select v-model="schoolValue" @change="changeSchoolId(schoolValue)">
                <el-option
                    v-for="item in schoolData"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                >
                </el-option>
            </el-select>
            <div class="search-main">
                <el-row class="elRow">
                    <!--搜索框-->
                    <el-col :span="7" style="margin: 10px 10px 0 0">
                        <el-input placeholder="请输入订单号" size="small" v-model="searchOrderId" clearable
                                  @clear="list(1,null,schoolValue)">
                            <el-button slot="append" icon="el-icon-search"
                                       @click="list(1,null,schoolValue)"></el-button>
                        </el-input>
                    </el-col>
                    <el-col :span="1" style="margin-top: 10px">
                        <el-button
                            type="primary"
                            size="small"
                            @click="refresh">
                            <i class="el-icon-refresh"></i>
                        </el-button>
                    </el-col>
                    <!--分页-->

                </el-row>
                <el-pagination
                    :page-sizes="[15, 30, 40, 50]"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="this.total"
                    style="margin-right: 10px"
                    @current-change="page"
                    @size-change="changePageSize"
                    :current-page="currentPage"
                >
                </el-pagination>
            </div>

            <div class="table-main">
                <el-table :data="tableData" style="width: 100%" border stripe v-loading="loading">
                    <el-table-column
                        type="index"
                        :index="indexMethod"
                        width="50">
                    </el-table-column>
                    <el-table-column prop="semester_name" label="学期名称"></el-table-column>
                    <el-table-column prop="student_name" label="学员"></el-table-column>
                    <el-table-column prop="student_mobile" label="手机号"></el-table-column>
                    <el-table-column prop="id" label="订单号">
                        <template slot-scope="scope">
                            <a @click="Deatil(scope.row.id)">{{scope.row.id}}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="total" label="原价"></el-table-column>
                    <el-table-column prop="actual_total" label="实际支付"></el-table-column>
                    <el-table-column prop="status" label="状态">
                        <template slot-scope="scope">
                            <span v-if="scope.row.status === 0">未支付</span>
                            <span v-if="scope.row.status === 8">支付中</span>
                            <span v-if="scope.row.status === 10">支付成功</span>
                            <span v-if="scope.row.status === -10">支付失败</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="type" label="下单类型">
                        <template slot-scope="scope">
                            <span v-if="scope.row.type === 10">付款</span>
                            <span v-if="scope.row.type === -10">退款</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="admin_name" label="操作人"></el-table-column>
                    <el-table-column prop="created_at" label="下单时间"></el-table-column>

                </el-table>
            </div>
        </el-card>

        <el-drawer
            title="分班管理"
            :visible.sync="orderDetail"
            direction="rtl"
            size="50%"
            :with-header="false"
        >
            <div style="font-size: 25px;margin: 20px">订单号</div>
            <el-divider></el-divider>
            <el-form ref="form" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="会员:" prop="name">
                    <el-input v-model="create_form.student_name" autocomplete="off"
                              style="width: 200px !important;" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="订单金额:" prop="name">
                    <el-input v-model="create_form.total" autocomplete="off"
                              style="width: 200px !important;" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="订单状态:" prop="name">
                    <el-input v-model="create_form.status" autocomplete="off"
                              style="width: 200px !important;" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="下单时间:" prop="name">
                    <el-input v-model="create_form.created_at" autocomplete="off"
                              style="width: 200px !important;" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="操作人:" prop="name">
                    <el-input v-model="create_form.admin_name" autocomplete="off"
                              style="width: 200px !important;" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
            </el-form>
            <div style="font-size: 25px;margin: 20px">支付方式</div>
            <el-table
                :data="paymentOrderTableData"
                border
                style="width: 80%;margin-left:50px">
                <el-table-column prop="channel" label="支付方式">
                    <template slot-scope="scope">
                        <span v-if="scope.row.channel === 10">现金</span>
                        <span v-if="scope.row.channel === 20">余额</span>
                        <span v-if="scope.row.channel === 30">微信支付</span>
                        <span v-if="scope.row.channel === 40">支付宝</span>
                        <span v-if="scope.row.channel >=100">后台线下支付</span>
                    </template>
                </el-table-column>
                <el-table-column prop="amount" label="金额" ></el-table-column>
                <el-table-column prop="created_at" label="下单时间">
                </el-table-column>
            </el-table>
        </el-drawer>
    </div>
</template>

<script>
import {Notification} from 'element-ui';

export default {
    name: "Register_order",
    data() {
        return {
            orderDetail: false,
            operate_id: window.postId,
            schoolData: '',
            schoolValue: '',
            index: 1,
            searchOrderId: '',
            currentPage: 1,
            //总条数
            total: 0,
            labelPosition: 'right',
            loading: false,
            dialogFormVisible: false,
            formLabelWidth: '120px',
            tableData: [{}],
            paymentOrderTableData: [{}],
            create_form: {},
        };
    },
    methods: {
        listSchoolData() {
            let url = "head/headSchool-list?status=1";
            this.axios.get(url).then(response => {
                this.schoolData = response.data.data
                this.schoolValue = this.schoolData[0]['id'];
                //这里请求默认的下拉选项的值
                this.list(this.currentPage, null, this.schoolValue);
            }).catch(function (error) {
                console.log(error);
            });
        },
        //设置刷新按钮
        refresh() {
            this.loading = true
            setTimeout(() => {
                this.loading = false
            }, 500);
            this.list(this.currentPage, null, this.schoolValue)
        },
        //请求list接口
        list(currentPage, pageSize = null, schoolId) {
            if (pageSize) {
                var url = "school/schoolOrder-list?page=" + currentPage + "&searchOrderId=" + this.searchOrderId + "&pageSize=" + pageSize + "&school_id=" + schoolId;
            } else {
                var url = "school/schoolOrder-list?page=" + currentPage + "&searchOrderId=" + this.searchOrderId + "&school_id=" + schoolId;
            }
            this.axios.get(url).then(response => {
                this.currentPage = response.data.current_page
                this.tableData = response.data.data;
                this.total = response.data.total;
                this.cleanCreateFormData()
            }).catch(function (error) {
                console.log(error);
            });
        },
        //课程信息详情
        Deatil(id) {
            let url = 'school/schoolOrder-detail'
            this.axios.post(url, {
                id: id,
            }).then(response => {
                this.orderDetail = true
                this.create_form = response.data
                this.paymentOrderTableData = response.data.payment_order
                console.log(this.create_form)
            }).catch(error => {
                alert('错误1')
            });
        },
        //清空表单值
        cleanCreateFormData() {
            this.create_form = {}
        },
        page(value) {
            this.list(value, null, this.schoolValue);
        },
        indexMethod(index) {
            //单前页码，具体看组件取值
            let curpage = this.currentPage
            //每页条数，具体是组件取值
            let limitpage = 15
            return (index + 1) + (curpage - 1) * limitpage
        },
        changePageSize(value) {
            this.list(this.currentPage, value, this.schoolValue);
        },
        changeSchoolId(value) {
            console.log(value);
            this.currentPage = 1
            this.list(this.currentPage, null, this.schoolValue);
        },
    },
    created() {
        this.listSchoolData();
    },
}
</script>

<style scoped>
.semester-wrap {
    flex: 1;
    display: flex;
    overflow: auto;
}

.form-search {
    display: flex;
}

.search {
    width: 300px;
    margin-right: 10px;
}

.el-form-item {
    margin-left: 20px;
}

a {
    color: #3490dc !important;
}

.avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.avatar-uploader .el-upload:hover {
    border-color: #409EFF;
}

.avatar-uploader-icon {
    background-color: rgb(250, 250, 250);
    font-size: 28px;
    color: #8c939d;
    width: 128px;
    height: 128px;
    line-height: 128px;
    text-align: center;
    border: 1px dashed #d9d9d9;
}

.avatar {
    background-color: rgb(250, 250, 250);
    border: 1px dashed #d9d9d9;
    padding: 10px;
    width: 128px;
    height: 128px;
    display: block;
}
</style>
