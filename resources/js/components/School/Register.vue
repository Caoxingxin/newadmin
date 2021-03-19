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
                        <el-input placeholder="请输入内容" size="small" v-model="searchStudentMobile" clearable
                                  @clear="list(1,null,schoolValue)">
                            <el-button slot="append" icon="el-icon-search"
                                       @click="list(1,null,schoolValue)"></el-button>
                        </el-input>
                    </el-col>
                    <!--添加-->
                    <el-col :span="2" style="margin-top: 10px">
                        <el-button type="primary" size="small" @click="add" icon="el-icon-plus">添加
                        </el-button>
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
                    <el-table-column label="学员">
                        <template slot-scope="scope">
                            <a @click="Deatil(scope.row.id)">{{ scope.row.student_name }}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="student_mobile" label="手机"></el-table-column>
                    <el-table-column prop="semester_name" label="学期"></el-table-column>
                    <el-table-column prop="class_name" label="班级"></el-table-column>
                    <el-table-column prop="status" label="报道状态">
                        <template slot-scope="scope">
                            <span v-if="scope.row.status === 10">未报到</span>
                            <span style="color:green" v-if="scope.row.status === 20">已报道</span>
                            <span style="color:blue" v-if="scope.row.status === 30">延期</span>
                            <span v-if="scope.row.status === 40">已结业</span>
                            <span style="color:red" v-if="scope.row.status === 50">已取消</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="tuition" label="学费"></el-table-column>
                    <el-table-column label="学费余款">
                        <template slot-scope="scope">
                            <span>{{ scope.row.tuition - scope.row.tuition_paid }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="" label="已付定金"></el-table-column>
                    <el-table-column prop="admin_name" label="销售"></el-table-column>

                    <el-table-column label="操作" width="280px">
                        <template slot-scope="scope">
                            <a @click="report(scope.row)"
                               v-if="scope.row.status === 10 || scope.row.status === 30"
                               style="font-size:13px;margin-right: 5px">
                                报道
                            </a>
                            <el-divider direction="vertical"></el-divider>
                            <a @click="postpone(scope.row.id)"
                               v-if="scope.row.status === 10">
                                延期
                            </a>
                            <el-divider direction="vertical"></el-divider>
                            <a @click="cancelRegister(scope.row)"
                               v-if="scope.row.status === 10">
                                取消报名
                            </a>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </el-card>

        <!--    延期原因对话框     -->
        <el-dialog title="延期报道" :visible.sync="dialogPostponeFormVisible" width="600px" top="20px"
                   :close-on-click-modal="false"
                   :before-close="postpone_handleClose">

            <el-form ref="postpone_form" :model="postpone_form" :label-position="labelPosition">
                <el-form-item label="延期原因:" prop="postpone_remark">
                    <el-input type="textarea"
                              v-model="postpone_form.postpone_remark" autocomplete="off"
                              :autosize="{ minRows: 4, maxRows: 6}" size="small">
                    </el-input>
                </el-form-item>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="postpone_resetForm('postpone_form')">取 消</el-button>
                <el-button type="primary" @click="postpone_submitForm('postpone_form')">保 存</el-button>
            </div>
        </el-dialog>

        <el-dialog title="添加报名" :visible.sync="dialogFormVisible" width="800px" top="20px" :close-on-click-modal="false"
                   :before-close="handleClose">
            <el-form ref="form" :rules="rules" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="手机号:" prop="mobile">
                    <el-input v-model="create_form.mobile" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入手机号" size="small"
                              @change="autoStudentInfo(create_form.mobile)"
                    >
                    </el-input>
                </el-form-item>
                <el-form-item label="学员姓名:" prop="name">
                    <el-input v-model="create_form.name" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入姓名" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="报名学期:" prop="semester_id">
                    <el-select v-model="create_form.semester_id" :disabled="semesterDisable"
                               @change="changeSemesterId(semesterValue)">
                        <el-option
                            v-for="item in semesterData"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="销售员:" prop="admin_id">
                    <el-select v-model="create_form.admin_id" :disabled="adminDisable"
                               @change="changeAdminId(adminValue)">
                        <el-option
                            v-for="item in adminData"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="性别:" prop="gender">
                    <el-radio-group v-model="create_form.gender">
                        <el-radio :label="1">男</el-radio>
                        <el-radio :label="0">女</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="备注:" prop="remark">
                    <el-input type="textarea"
                              v-model="create_form.remark" autocomplete="off" :autosize="{ minRows: 4, maxRows: 6}"
                              placeholder="备注" size="small">
                    </el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="resetForm('form')">取 消</el-button>
                <el-button type="primary" @click="submitForm('form')">保 存</el-button>
            </div>
        </el-dialog>

        <!--    报名详情     -->
        <el-dialog title="报名详情" :visible.sync="dialogDetailFormVisible" width="1200px" top="20px"
                   :close-on-click-modal="false"
                   :before-close="detail_handleClose">
            <el-tabs v-model="activeName" @tab-click="checkTab">
                <el-tab-pane label="报名表单" name="first">
                    <el-form ref="detail_form" :model="detail_form" :label-position="labelPosition" label-width="100px">
                        <p style="font-size: 20px">报名表单</p>
                        <el-form-item label="手机号:" >
                            <el-input v-model="detail_form.student_mobile" autocomplete="off"
                                      style="width: 200px !important;" size="small" :disabled="true"
                            >
                            </el-input>
                        </el-form-item>
                        <el-form-item label="学员姓名:">
                            <el-input v-model="detail_form.student_name" autocomplete="off"
                                      style="width: 200px !important;" size="small" :disabled="true">
                            </el-input>
                        </el-form-item>
                        <el-form-item label="报名学期:">
                            <el-input v-model="detail_form.semester_name" autocomplete="off"
                                      style="width: 200px !important;" size="small" :disabled="true">
                            </el-input>
                        </el-form-item>
                        <el-form-item label="性别:">
                            <el-radio-group v-model="detail_form.student_gender" >
                                <el-radio :label="1" disabled>男</el-radio>
                                <el-radio :label="0" disabled>女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                        <p style="font-size: 20px">报名费用</p>
                        <div style="margin: 15px 15px 15px 60px;">
                            <span>学费：
                                 <el-input v-model="detail_form.tuition" autocomplete="off"
                                           style="width: 90px !important;margin-right: 50px" size="small" :disabled="true">
                            </el-input>
                            </span>
                            <span style="margin-right: 50px">已付：{{this.detail_form.tuition_paid}}</span>
                            <span style="margin-right: 50px">待付：{{this.detail_form.tuition_wait}}</span>
                            <span style="margin-right: 50px">已退：{{this.detail_form.tuition_refund}}</span>
                        </div>
                        <div style="margin: 15px 15px 20px 60px;">
                            <span>总额：
                                 <el-input v-model="detail_form.all" autocomplete="off"
                                           style="width: 90px !important;margin-right: 50px" size="small" :disabled="true">
                            </el-input>
                            </span>
                            <span>已付总额：{{this.detail_form.all_paid}}</span>
                            <el-button @click="orderRefund('detail_form',-10)"
                                       style="margin: 0 50px 0 5px" type="primary" :disabled="ifshow(this.detail_form.all_paid)">退款</el-button>
                            <span>待付总额：{{this.detail_form.all_wait}}</span>
                            <el-button @click="orderCreate('detail_form',10)"
                                       type="primary" style="margin-left:5px" :disabled="ifshow(this.detail_form.all_wait)">付款</el-button>
                        </div>
                    </el-form>
                </el-tab-pane>
                <el-tab-pane label="付款记录" name="second">
                    {{ this.studentRegisterValue }}
                    <div class="search-main">
                        <el-row class="elRow">
                            <!--搜索框-->
                            <el-col :span="10" style="margin: 10px 10px 0 0">
                                <el-input placeholder="请输入内容" size="small" v-model="searchOrderId" clearable
                                          @clear="payment_list(1,null,schoolValue)">
                                    <el-button slot="append" icon="el-icon-search"
                                               @click="payment_list(1,null,schoolValue)"></el-button>
                                </el-input>
                            </el-col>
                            <el-col :span="1" style="margin-top: 10px">
                                <el-button
                                    type="primary"
                                    size="small"
                                    @click="payment_refresh">
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
                        <el-table :data="order_tableData" style="width: 100%" border stripe v-loading="loading">
                            <el-table-column prop="relation_id" label="订单号" ></el-table-column>
                            <el-table-column prop="order_type" label="类型">
                                <template slot-scope="scope">
                                    <span v-if="scope.row.order_type === 10">付款</span>
                                    <span v-if="scope.row.order_type === -10">退款</span>
                                </template>
                            </el-table-column>
                            <el-table-column prop="channel" label="付款方式">
                                <template slot-scope="scope">
                                    <span v-if="scope.row.channel === 10">现金</span>
                                    <span v-if="scope.row.channel === 20">余额</span>
                                    <span v-if="scope.row.channel === 30">微信支付</span>
                                    <span v-if="scope.row.channel === 40">支付宝</span>
                                    <span v-if="scope.row.channel >=100">后台线下支付</span>
                                </template>
                            </el-table-column>
                            <el-table-column prop="amount" label="支付金额"></el-table-column>
                            <el-table-column prop="status" label="状态">
                                <template slot-scope="scope">
                                    <span v-if="scope.row.status === 0">未支付</span>
                                    <span v-if="scope.row.status === 8">支付中</span>
                                    <span v-if="scope.row.status === 10">支付成功</span>
                                    <span v-if="scope.row.status === -10">支付失败</span>
                                </template>
                            </el-table-column>
                            <el-table-column prop="trade_no" label="交易号"></el-table-column>
                            <el-table-column prop="platform" label="下单渠道">
                                <template slot-scope="scope">
                                    <span v-if="scope.row.platform === 1">后台</span>
                                    <span v-if="scope.row.platform === 2">小程序</span>
                                    <span v-if="scope.row.platform === 3">APP</span>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </el-dialog>
        <!--    付款，退款窗口    -->
        <el-dialog :title="this.orderType==10 ? '付款' : '退款'" :visible.sync="dialogOrderFormVisible" width="600px" top="20px"
                   :close-on-click-modal="false"
                   :before-close="order_handleClose">

            <el-form ref="order_form" :model="order_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="学费:">
                    <el-input v-model="ordetTuition" autocomplete="off"
                              style="width: 200px !important;" size="small" >
                    </el-input>
                </el-form-item>
                <el-form-item label="付款总额:">
                    <el-input v-model="ordetTuition" autocomplete="off"
                              style="width: 200px !important;" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="支付方式:" >
                    <el-select v-model="channelValue" @change="changechannelValue(channelValue)">
                        <el-option
                            v-for="item in this.channelData"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="交易号:">
                    <el-input v-model="order_form.trade_no" autocomplete="off"
                              style="width: 200px !important;" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="备注:">
                    <el-input type="textarea"
                              v-model="order_form.order_remark" autocomplete="off"
                              :autosize="{ minRows: 4, maxRows: 6}" size="small">
                    </el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="order_resetForm('detail_form')">取消</el-button>
                <el-button type="primary" @click="order_submitForm('detail_form',orderType)">确定</el-button>
            </div>
        </el-dialog>

    </div>
</template>

<script>
import {Notification} from 'element-ui';

export default {
    name: "Register",
    data() {
        return {
            ordetTuition: '',
            orderType: '',
            studentRegisterValue : '',
            tabIndex: true,
            activeName: 'first',
            adminDisable: false,
            adminData: '',
            adminValue: '',
            semesterDisable: false,
            semesterData: '',
            semesterValue: '',
            operate_id: window.postId,
            radio: '1',
            schoolData: '',
            schoolValue: '',
            index: 1,
            searchStudentMobile: '',
            searchOrderId: '',
            currentPage: 1,
            //总条数
            total: 0,
            labelPosition: 'right',
            loading: false,
            dialogFormVisible: false,
            dialogPostponeFormVisible: false,
            dialogDetailFormVisible: false,
            dialogOrderFormVisible: false,
            formLabelWidth: '120px',
            tableData: [{}],
            order_tableData:[{}],
            create_form: {
                id: '',
                school_id: '',
                semester_id: '',
                semester_name: '',
                mobile: '',
                name: '',
                admin_id: '',
                gender: '',
                remark: '',
            },
            postpone_form: {
                id: '',
                postpone_remark: '',
            },
            detail_form: {
                id: '',
                semester_id: '',
                semester_name: '',
                student_id: '',
                student_name: '',
                student_mobile: '',
                student_gender: '',
                tuition : '',
                tuition_paid: '',
                tuition_wait: '',
                tuition_refund: '',
                all_paid: '',
                all_wait: '',
                all: '',
                trade_no: '',
                remark: '',
            },
            order_form:{
                id: '',
                semester_id: '',
                semester_name: '',
                student_id: '',
                student_name: '',
                student_mobile: '',
                student_gender: '',
                tuition : '',
                tuition_paid: '',
                tuition_wait: '',
                tuition_refund: '',
                all_paid: '',
                all_wait: '',
                all: '',
                trade_no: '',
                order_remark: '',
            },
            channelData:[
                {id:10,name:'现金'},
                {id:20,name:'余额'},
                {id:30,name:'微信支付'},
                {id:40,name:'支付宝'},
            ],
            channelValue: '',
            rules: {
                name: [
                    {required: true, message: '请输入名称', trigger: 'blur'},
                    {min: 2, max: 200, message: '长度在 3 到 5 个字符', trigger: 'blur'}
                ],
                mobile: [
                    {
                        required: true,
                        pattern: /^1[34578]\d{9}$/,//可以写正则表达式呦呦呦
                        message: '目前只支持中国大陆的手机号码',
                        trigger: 'blur'
                    }
                ],
            },
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
        //添加按钮
        add() {
            this.listSemesterData();
            this.listAdminData();
            this.dialogFormVisible = true;
            this.create_form.semester_id = ''
        },
        //设置刷新按钮
        refresh() {
            this.loading = true
            setTimeout(() => {
                this.loading = false
            }, 500);
            this.list(this.currentPage, null, this.schoolValue)
        },
        payment_refresh(){
            this.loading = true
            setTimeout(() => {
                this.loading = false
            }, 500);
            this.payment_list(this.currentPage, null, this.schoolValue)
        },
        //请求list接口
        list(currentPage, pageSize = null, schoolId) {
            if (pageSize) {
                var url = "school/schoolStudentRegister-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&pageSize=" + pageSize + "&school_id=" + schoolId;
            } else {
                var url = "school/schoolStudentRegister-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&school_id=" + schoolId;
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
        payment_list(currentPage, pageSize = null, schoolId){
            if (pageSize) {
                var urlorder = "school/schoolPaymentOrder-list?page=" + currentPage + "&searchOrderId=" + this.searchOrderId + "&pageSize=" + pageSize + "&school_id=" + schoolId + "&student_id=" + this.detail_form.student_id + "&semester_id=" + this.detail_form.semester_id;
            } else {
                var urlorder = "school/schoolPaymentOrder-list?page=" + currentPage + "&searchOrderId=" + this.searchOrderId + "&school_id=" + schoolId + "&student_id=" + this.detail_form.student_id + "&semester_id=" + this.detail_form.semester_id;;
            }
            this.axios.get(urlorder).then(response => {
                this.currentPage = response.data.current_page
                this.order_tableData = response.data.data;
                this.total = response.data.total;
            }).catch(function (error) {
                console.log(error);
            });
        },
        //显示提示
        open1(status) {
            const h = this.$createElement;
            let data = {
                title: '提示信息',
                type: 'success',
            }
            if (status == 1) {
                this.$set(data, 'message', h('p', '禁用成功'))
            } else if (status == -1) {
                this.$set(data, 'message', h('p', '启用成功'))
            } else {
                this.$set(data, 'message', h('p', '删除成功'))
            }

            this.$notify(data);
        },
        //请求课程创建接口
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    let url = 'school/schoolStudentRegister-create'
                    this.axios.post(url, {
                        mobile: this.create_form.mobile,
                        name: this.create_form.name,
                        semester_id: this.create_form.semester_id,
                        admin_id: this.create_form.admin_id,
                        gender: this.create_form.gender,
                        remark: this.create_form.remark,
                        school_id: this.schoolValue,
                        operator_id: this.operate_id,
                    }).then(response => {
                        console.log(response)
                        this.$refs[formName].resetFields();
                        this.dialogFormVisible = false
                        this.list(this.currentPage, null, this.schoolValue)
                        Notification({
                            title: '信息提示',
                            message: '添加成功',
                            type: "success",
                            duration: 1000
                        });
                    }).catch(error => {
                        Notification({
                            title: '错误提示',
                            message: error.response.data['message'],
                            type: "error",
                            duration: 2000
                        });
                    });
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },

        //提交延时原因
        postpone_submitForm(formName) {
            let url = 'school/schoolStudentRegister-postpone'
            this.axios.post(url, {
                id: this.postpone_form.id,
                remark: this.postpone_form.postpone_remark,
                operate_id: this.operate_id
            }).then(response => {
                this.$refs[formName].resetFields();
                this.dialogPostponeFormVisible = false;
                this.list(this.currentPage, null, this.schoolValue);
                Notification({
                    title: '信息提示',
                    message: '延期成功',
                    type: "success",
                    duration: 1000
                });
            }).catch(error => {
                Notification({
                    title: '错误提示',
                    message: error.response.data['message'],
                    type: "error",
                    duration: 2000
                });
            });
        },

        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.cleanCreateFormData()
            this.dialogFormVisible = false
            this.refresh()
        },
        postpone_resetForm(formName) {
            this.$refs[formName].resetFields();
            this.cleanPostponeFormData();
            this.dialogPostponeFormVisible = false
            this.refresh()
        },
        order_resetForm(formName){
            this.$refs[formName].resetFields();
            this.dialogOrderFormVisible = false
            this.cleanOrderFormData();
            this.refresh()
        },
        //添加报名窗口关闭
        handleClose(done) {
            done();
            this.$refs['form'].resetFields();
            this.cleanCreateFormData()
            this.refresh()
        },
        //延期原因窗口关闭
        postpone_handleClose(done) {
            done();
            this.$refs['postpone_form'].resetFields();
            this.cleanPostponeFormData();
            this.refresh()
        },
        //详情窗口关闭
        detail_handleClose(done) {
            done();
            // this.$refs['form'].resetFields();
            // this.cleanCreateFormData()
            this.tabIndex = true;
            this.studentRegisterValue = '';
            this.activeName = 'first'
            this.refresh()
        },
        //支付窗口关闭
        order_handleClose(done){
            done();
            this.channelValue= '';
            this.Deatil(this.studentRegisterValue);
            this.refresh();
            this.orderType = '';
        },
        //报名表单信息详情
        Deatil(id) {
            let url = 'school/schoolStudentRegister-detail'
            this.axios.post(url, {
                id: id,
            }).then(response => {
                this.dialogDetailFormVisible = true
                this.detail_form = response.data
                this.order_form =  this.detail_form
                this.studentRegisterValue = this.detail_form.id
            }).catch(error => {
                alert('错误1')
            });
        },
        //清空表单值
        cleanCreateFormData() {
            this.create_form.name = ''
            this.create_form.mobile = ''
            this.create_form.admin_id = ''
            this.create_form.gender = ''
            this.create_form.remark = ''
            this.semesterDisable = false
            this.adminDisable = false
        },
        //清空延期原因表单值
        cleanPostponeFormData() {
            this.postpone_form.id = ''
            this.postpone_form.postpone_remark = ''
        },
        cleanOrderFormData(){
                this.channelValue= '';
                this.order_form.trade_no = ''
                this.order_form.order_remark = ''
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
            this.currentPage = 1
            this.list(this.currentPage, null, this.schoolValue);
        },
        changeSemesterId(value) {
            this.semesterValue = value
        },
        changeAdminId(value) {
            this.adminValue = value
        },
        //获取所有管理员
        listAdminData() {
            let url_admin = 'admin/get-admin-list'
            this.axios.get(url_admin).then(response => {
                this.adminData = response.data
            }).catch(error => {
                alert('错误获取销售员值')
            })
        },
        //获取所有学期
        listSemesterData() {
            let url_semester = 'school/get-semester-list'
            this.axios.post(url_semester, {
                school_id: this.schoolValue,
            }).then(response => {
                this.semesterData = response.data
                this.semesterValue = this.schoolData[0]['id'];
            }).catch(error => {
                alert('错误获取学期')
            });
        },
        autoStudentInfo(value) {
            if (value.length === 11) {
                this.axios.post('school/get-student-list', {
                    mobile: value
                }).then(response => {
                    if (response) {
                        this.create_form.name = response.data.name
                        this.create_form.gender = response.data.gender
                    }
                }).catch(errpr => {
                    alert('错误获取学生')
                });
            }
        },
        //延期
        postpone(value) {
            this.dialogPostponeFormVisible = true;
            this.postpone_form.id = value;
        },
        //取消报名
        cancelRegister(data) {
            this.$confirm('确认要取消报名吗？', 'Ready to Leave?', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                axios({
                    method: 'post',
                    url: 'school/schoolStudentRegister-cancelRegister',
                    data: {
                        id: data.id,
                        semester_id: data.semester_id,
                        operator_id: this.operate_id
                    }
                }).then(response => {
                    this.list(this.currentPage, null, this.schoolValue);
                    Notification({
                        title: '信息提示',
                        message: '取消成功',
                        type: "success",
                        duration: 1000
                    });
                }).catch(error => {
                    alert('取消报名错误');
                });
            }).catch(() => {
            });
        },
        //报道
        report(data) {
            this.$confirm('确认报道吗？', 'Ready to Leave?', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                axios({
                    method: 'post',
                    url: 'school/schoolStudentRegister-report',
                    data: {
                        id: data.id,
                        semester_id: data.semester_id,
                        operator_id: this.operate_id
                    }
                }).then(response => {
                    this.list(this.currentPage, null, this.schoolValue);
                    Notification({
                        title: '信息提示',
                        message: '报道成功',
                        type: "success",
                        duration: 1000
                    });
                }).catch(error => {
                    Notification({
                        title: '错误提示',
                        message: error.response.data['message'],
                        type: "error",
                        duration: 2000
                    });
                });
            }).catch(() => {
            });
        },
        ifshow(value){
            if(value > 0)
                return false;
            else
                return true;
        },
        checkTab(tab){
            if (tab.name == 'second' && this.tabIndex == true){
                //请求付款记录接口
                this.payment_list(this.currentPage, null, this.schoolValue);
                this.tabIndex = false;
            }

        },
        orderRefund(formName,orderType){
            this.$refs[formName].validate((valid) => {
                this.orderType = orderType
                this.dialogOrderFormVisible =true
                this.ordetTuition = this.detail_form.tuition_paid
                this.order_form =  this.detail_form
            })
        },
        orderCreate(formName,orderType){
            this.$refs[formName].validate((valid) => {
                this.orderType = orderType
                this.dialogOrderFormVisible =true
                this.ordetTuition = this.detail_form.tuition_wait
                console.log( this.ordetTuition)
                this.order_form =  this.detail_form
            })
        },
        //更换支付方式
        changechannelValue(value){
            this.channelValue = value;
        },
        //提交付款or退款请求
        order_submitForm(formName,orderType){
            let url = 'school/schoolOrder-create'
            this.axios.post(url,{
                'remark': this.order_form.order_remark ? this.order_form.order_remark : '' ,
                'tuition_wait':this.detail_form.tuition_wait,
                'tuition_paid':this.detail_form.tuition_paid,
                'operate_id':this.operate_id,
                'student_id': this.detail_form.student_id,
                'semester_id': this.detail_form.semester_id,
                'actual_total':this.ordetTuition,
                'platform': this.channelValue,
                'type': this.orderType,
                'payment_order':{
                    'amount': this.ordetTuition,
                    'channel': this.channelValue ,
                    'trade_no': this.order_form.trade_no,
                },
            }).then(res => {
                this.dialogOrderFormVisible =false
                this.Deatil(this.studentRegisterValue);
                Notification({
                    title: '提示',
                    message: '付款成功',
                    type: "success",
                    duration: 2000
                });
            }).catch(error => {
                Notification({
                    title: '错误提示',
                    message: error.response.data['message'],
                    type: "error",
                    duration: 2000
                });
            })
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
