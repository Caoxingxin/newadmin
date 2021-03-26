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
                        <el-input placeholder="请输入内容" size="small" v-model="searchSemesterName" clearable
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
                    <el-table-column prop="name" label="学期名称">
                        <template slot-scope="scope">
                            <a @click="Deatil(scope.row.id)">{{scope.row.name}}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="registered_number" label="已报名">
                        <template slot-scope="scope">
                            <span>{{scope.row.registered_number}}/{{scope.row.number}}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="number" label="报名名额"></el-table-column>
                    <el-table-column prop="contact" label="联系电话"></el-table-column>
                    <el-table-column prop="status" label="状态">
                        <template slot-scope="scope">
                            <span v-if="scope.row.status === 1">上线</span>
                            <span style="color:red" v-if="scope.row.status === -1">下线</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作">
                        <template slot-scope="scope">
                            <el-button type="success" size="mini" @click="changeStatus(scope.row)">
                                {{options(scope.row)}}
                            </el-button>
                            <el-button type="danger" size="mini" @click="Delete(scope.row)">删除
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </el-card>

        <el-dialog title="添加学期" :visible.sync="dialogFormVisible" width="800px" top="20px" :close-on-click-modal="false"
                   :before-close="handleClose">
            <el-form ref="form" :rules="rules" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="学期名称:" prop="name">
                    <el-input v-model="create_form.name" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入学期名称" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="图片:" prop="picture">
                    <el-upload
                        class="avatar-uploader"
                        action="http://localhost:3600/admin/upload"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload"
                        ref="myUpload"
                    >
                        <img v-if="imageUrl" :src="this.imageUrl" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>
                <el-form-item label="联系电话:" prop="contact">
                    <el-input v-model="create_form.contact" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入电话" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="微信号:" prop="wechat">
                    <el-input v-model="create_form.wechat" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入微信" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="培训时间:" prop="train_time">
                    <el-date-picker
                        v-model="create_form.train_time"
                        type="daterange"
                        range-separator="至"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期"
                        value-format="yyyy-MM-dd"
                        :picker-options="pickerOptionsTime"

                    >
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="报名时间:" prop="register_time">
                    <el-date-picker
                        v-model="create_form.register_time"
                        type="daterange"
                        range-separator="至"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期"
                        value-format="yyyy-MM-dd"
                        :picker-options="pickerOptionsTime"
                    >
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="报名名额:" prop="number">
                    <el-input v-model="create_form.number" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入报名名额" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="学费:" prop="tuition">
                    <el-input v-model="create_form.tuition" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入学费" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="学期介绍:" prop="introduction">
                    <el-input type="textarea" v-model="create_form.introduction" autocomplete="off"
                              :autosize="{ minRows: 4, maxRows: 6}" placeholder="请输入学期介绍" size="small">
                    </el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="resetForm('form')">取 消</el-button>
                <el-button type="primary" @click="submitForm('form')">保 存</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import {Notification} from 'element-ui';

    export default {
        name: "Semester",
        data() {
            return {
                radio: '1',
                schoolData: '',
                schoolValue: '',
                index: 1,
                searchSemesterName: '',
                currentPage: 1,
                //总条数
                total: 0,
                imageUrl: '',
                updateStatus: false,
                labelPosition: 'right',
                loading: false,
                dialogFormVisible: false,
                formLabelWidth: '120px',
                tableData: [],
                create_form: {
                    id: '',
                    school_id: '',
                    name: '',
                    picture: '',
                    start_date: '',
                    end_date: '',
                    train_time: '',
                    contact: '',
                    wechat: '',
                    register_start_at: '',
                    register_end_at: '',
                    register_time: '',
                    number: '',
                    registered_number: '',
                    tuition: '',
                    introduction: '',
                    status: '',
                },
                rules: {
                    name: [
                        {required: true, message: '请输入名称', trigger: 'blur'},
                        {min: 2, max: 200, message: '长度在 3 到 5 个字符', trigger: 'blur'}
                    ],
                    contact: [
                        {
                            required: true,
                            pattern: /^1[34578]\d{9}$/,//可以写正则表达式呦呦呦
                            message: '目前只支持中国大陆的手机号码',
                            trigger: 'blur'
                        }
                    ],
                    train_time:[
                        { required: true, message: '请填写培训时间' },
                    ],
                    register_time:[
                        { required: true, message: '请填写报名时间' },
                    ],
                    number:[
                        { required: true, message: '请填写报名名额' },
                    ],
                    tuition:[
                        { required: true, message: '请填写学费金额' },
                    ],
                },
                pickerOptionsTime:{
                    disabledDate(time) {
                        return time.getTime() < Date.now() - 8.64e7;
                    }
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
                this.updateStatus = false;
                this.imageUrl = '';
                this.dialogFormVisible = true;
            },
            //设置改变状态按钮值
            options(row) {
                if (row.status == 1) {
                    return "下线";
                } else {
                    return "上线"
                }
            },
            //请求改变状态接口
            changeStatus(row) {
                let url = "school/schoolSemester-status"
                this.axios.post(url, {
                    'status': row.status,
                    'id': row.id,
                }).then(response => {
                    this.open1(row.status);
                    this.list(this.currentPage, null, this.schoolValue);
                    console.log(response);
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
                //加这个句话是为了避免$refs没有被渲染的情况
                if (this.$refs['form'] !== undefined) {
                    this.clearFiles()
                }
                this.list(this.currentPage, null, this.schoolValue)
            },
            //请求list接口
            list(currentPage, pageSize = null, schoolId) {
                if (pageSize) {
                    var url = "school/schoolSemester-list?page=" + currentPage + "&searchSemesterName=" + this.searchSemesterName + "&pageSize=" + pageSize + "&school_id=" + schoolId;
                } else {
                    var url = "school/schoolSemester-list?page=" + currentPage + "&searchSemesterName=" + this.searchSemesterName + "&school_id=" + schoolId;
                }
                this.axios.get(url).then(response => {
                    this.currentPage = response.data.current_page
                    this.tableData = response.data.data;
                    this.total = response.data.total;
                    this.cleanCreateFormData()
                    console.log(this.tableData);
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
                    this.$set(data, 'message', h('p', '下线成功'))
                } else if (status == -1) {
                    this.$set(data, 'message', h('p', '上线成功'))
                } else {
                    this.$set(data, 'message', h('p', '删除成功'))
                }

                this.$notify(data);
            },
            //请求课程创建接口
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.create_form.start_date = this.create_form.train_time[0];
                        this.create_form.end_date = this.create_form.train_time[1];
                        this.create_form.register_start_at = this.create_form.register_time[0];
                        this.create_form.register_end_at = this.create_form.register_time[1];
                        if (this.updateStatus) {
                            let url = 'school/schoolSemester-update'
                            this.axios.post(url, {
                                id: this.create_form.id,
                                school_id: this.schoolValue,
                                name: this.create_form.name,
                                picture: this.create_form.picture,
                                start_date: this.create_form.start_date,
                                end_date: this.create_form.end_date,
                                contact: this.create_form.contact,
                                wechat: this.create_form.wechat,
                                register_start_at: this.create_form.register_start_at,
                                register_end_at: this.create_form.register_end_at,
                                number: this.create_form.number,
                                tuition: this.create_form.tuition,
                                introduction: this.create_form.introduction,
                            }).then(response => {
                                this.$refs[formName].resetFields();
                                this.dialogFormVisible = false
                                this.list(this.currentPage, null, this.schoolValue)
                                this.$notify({
                                    title: '信息提示',
                                    message: '修改成功',
                                    type: "success",
                                    duration: 1000
                                });
                            }).catch(error => {
                                let mes = error.response.data['data'];
                                if (mes['name']) {
                                    this.$notify({
                                        title: '验证错误',
                                        message: '课程名不能重复',
                                        type: "error",
                                        duration: 2000
                                    });
                                } else {
                                    this.$notify({
                                        title: '验证错误',
                                        message: mes,
                                        type: "error",
                                        duration: 2000
                                    });
                                }
                            });
                            console.log('----------------')
                            console.log(this.updateStatus)
                        } else {
                            let url = 'school/schoolSemester-create'
                            this.axios.post(url, {
                                school_id: this.schoolValue,
                                name: this.create_form.name,
                                picture: this.create_form.picture,
                                start_date: this.create_form.start_date,
                                end_date: this.create_form.end_date,
                                contact: this.create_form.contact,
                                wechat: this.create_form.wechat,
                                register_start_at: this.create_form.register_start_at,
                                register_end_at: this.create_form.register_end_at,
                                number: this.create_form.number,
                                tuition: this.create_form.tuition,
                                introduction: this.create_form.introduction,
                            }).then(response => {
                                this.$refs[formName].resetFields();
                                this.dialogFormVisible = false
                                this.list(this.currentPage, null, this.schoolValue)
                                this.$notify({
                                    title: '信息提示',
                                    message: '添加成功',
                                    type: "success",
                                    duration: 1000
                                });
                            }).catch(error => {
                                let mes = error.response.data['data'];
                                if (mes['name']) {
                                    this.$notify({
                                        title: '验证错误',
                                        message: '课程名不能重复',
                                        type: "error",
                                        duration: 2000
                                    });
                                } else {
                                    this.$notify({
                                        title: '验证错误',
                                        message: mes,
                                        type: "error",
                                        duration: 2000
                                    });
                                }
                            });
                        }
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
                this.cleanCreateFormData()
                this.dialogFormVisible = false
                this.refresh()
            },
            handleClose(done) {
                done();
                this.$refs['form'].resetFields();
                this.cleanCreateFormData()
                this.refresh()
            },
            //课程信息详情
            Deatil(id) {
                let url = 'school/schoolSemester-detail'
                this.axios.post(url, {
                    id: id,
                }).then(response => {
                    this.dialogFormVisible = true
                    this.create_form = response.data
                    this.$set(this.create_form,'train_time',[this.create_form.start_date, this.create_form.end_date])
                    this.$set(this.create_form,'register_time',[this.create_form.register_start_at, this.create_form.register_end_at])
                    // this.create_form.train_time = [this.create_form.start_date, this.create_form.end_date]
                    // this.create_form.register_time = [this.create_form.register_start_at, this.create_form.register_end_at]
                    this.imageUrl = this.create_form.picture
                    this.updateStatus = true
                    console.log(this.create_form)
                }).catch(error => {
                    alert('错误')
                });
            },
            //清空表单值
            cleanCreateFormData() {
                this.create_form.name = ''
                this.create_form.picture = ''
                this.create_form.start_date = ''
                this.create_form.end_date = ''
                this.create_form.train_time = ''
                this.create_form.contact = ''
                this.create_form.wechat = ''
                this.create_form.register_start_at = ''
                this.create_form.register_end_at = ''
                this.create_form.register_time = ''
                this.create_form.number = ''
                this.create_form.registered_number = ''
                this.create_form.tuition = ''
                this.create_form.introduction = ''
                this.create_form.status = ''
            },
            //上传图片
            handleAvatarSuccess(response) {
                this.imageUrl = '/storage/image/' + response.filepath;
                this.create_form.picture = this.imageUrl
                console.log(this.imageUrl)
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG) {
                    this.$message.error('上传头像只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            },
            clearFiles() {
                this.$refs['myUpload'].clearFiles();
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
            Delete(row) {
                let url = "school/schoolSemester-delete"
                this.axios.post(url, {
                    'id': row.id,
                }).then(response => {
                    this.open1(0);
                    this.list(this.currentPage, null, this.schoolValue);
                    console.log(response);
                }).catch(function (error) {
                    console.log(error);
                });
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
