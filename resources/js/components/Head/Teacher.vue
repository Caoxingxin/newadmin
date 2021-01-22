<template>
    <div class="teacher-wrap">
        <el-card class="box-card">
            <div class="search-main">
                <el-row class="elRow">
                    <!--搜索框-->
                    <el-col :span="7">
                        <el-input placeholder="请输入内容" size="small" v-model="searchCourseName" clearable @clear="list(1)">
                            <el-button slot="append" icon="el-icon-search" @click="list(1)"></el-button>
                        </el-input>
                    </el-col>
                    <!--添加-->
                    <el-col :span="2" style="margin-left:16px;">
                        <el-button type="primary" size="small" @click="add" icon="el-icon-plus">添加
                        </el-button>
                    </el-col>
                    <el-col :span="1">
                        <el-button type="primary" size="small" @click="refresh">
                            <i class="el-icon-refresh"></i>
                        </el-button>
                    </el-col>
                </el-row>

                <!--分页-->
                <el-pagination :page-sizes="[15, 30, 40, 50]"
                               layout="total, sizes, prev, pager, next, jumper"
                               :total="this.total" style="margin-right: 10px"
                               @current-change="list"
                               @size-change="changePageSize"
                               :current-page="currentPage">
                </el-pagination>
            </div>

            <div class="table-main">
                <el-table :data="tableData" style="width: 100%" border stripe v-loading="loading">
                    <el-table-column type="index" :index="indexMethod" width="50">
                    </el-table-column>
                    <el-table-column prop="name" label="姓名">
                        <template slot-scope="scope">
                            <a @click="Deatil(scope.row.id)">{{scope.row.name}}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="mobile" label="手机号"></el-table-column>
                    <el-table-column prop="gender" label="性别">
                        <template slot-scope="scope">
                            <span v-if="scope.row.gender === 1">男</span>
                            <span v-else>女</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="entry_time" label="入职日期"></el-table-column>
                    <el-table-column prop="status" label="岗位状态">
                        <template slot-scope="scope">
                            <span v-if="scope.row.status === 10">试用期</span>
                            <span v-if="scope.row.status === 20">正式员工</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作">
                        <template slot-scope="scope">
                            <el-button v-if="scope.row.status === 10" type="success" size="mini" @click="statusDialog(scope.row)">转正
                            </el-button>
                            <el-button type="danger" size="mini" @click="Delete(scope.row)">删除
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>

        </el-card>

        <el-dialog title="添加教师" :visible.sync="dialogFormVisible" width="800px" top="20px" :close-on-click-modal="false" :before-close="handleClose">
            <el-form ref="form" :rules="rules" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="姓名:" prop="name">
                    <el-input v-model="create_form.name" autocomplete="off" style="width: 200px !important;" placeholder="请输入姓名" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="手机号:" prop="mobile">
                    <el-input v-model="create_form.mobile" autocomplete="off" style="width: 200px !important;" placeholder="请输入手机号" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="头像:" prop="picture">
                    <el-upload class="avatar-uploader" action="http://localhost:3600/admin/upload" :show-file-list="false" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload" ref="myUpload">
                        <img v-if="imageUrl" :src="this.imageUrl" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>
                <el-form-item label="岗位状态:" prop="status">
                    <el-radio-group v-model="create_form.status">
                        <el-radio v-if="this.radioStatus" :label="10">试用期</el-radio>
                        <el-radio v-else disabled :label="10">试用期</el-radio>
                        <el-radio v-if="this.radioStatus" :label="20">正式员工</el-radio>
                        <el-radio v-else disabled :label="20">正式员工</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="性别:" prop="gender">
                    <el-radio-group v-model="create_form.gender">
                        <el-radio :label="1">男</el-radio>
                        <el-radio :label="0">女</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="入职日期:" prop="entry_time">
                    <el-date-picker v-model="create_form.entry_time" type="date" placeholder="选择日期" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="转正日期:" prop="full_time" v-if="create_form.status===20">
                    <el-date-picker v-model="create_form.full_time" type="date" placeholder="选择日期" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="住址:" prop="address">
                    <el-input type="textarea" v-model="create_form.address" autocomplete="off" :autosize="{ minRows: 4, maxRows: 6}" placeholder="住址" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="描述:" prop="introduction">
                    <el-input type="textarea" v-model="create_form.introduction" autocomplete="off" :autosize="{ minRows: 4, maxRows: 6}" placeholder="描述" size="small">
                    </el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="resetForm('form')">取 消</el-button>
                <el-button type="primary" @click="submitForm('form')">保 存</el-button>
            </div>
        </el-dialog>

        <!--转正dialog-->
        <el-dialog title="转正" :visible.sync="dialogVisible" width="30%">
            <el-form ref="form_status" :rules="status_rules" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="转正日期:" prop="full_time">
                    <el-date-picker v-model="create_form.full_time" type="date" placeholder="选择日期" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="changeStatus('form_status')">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
import { Notification } from 'element-ui';

export default {
    name: "Teacher",
    data() {
        return {
            status_id: '',
            dialogVisible: false,
            radioStatus: true,
            index: 1,
            searchTeacherMobile: '',
            currentPage: 1,
            //总条数
            total: 0,
            imageUrl: '',
            updateStatus: false,
            labelPosition: 'right',
            loading: false,
            dialogFormVisible: false,
            formLabelWidth: '120px',
            tableData: '',
            create_form: {
                id: '',
                name: '',
                mobile: '',
                picture: '',
                gender: '',
                entry_time: '',
                full_time: '',
                status: '',
                address: '',
                introduction: ''
            },
            rules: {
                name: [
                    { required: true, message: '请输入名称', trigger: 'blur' },
                    { min: 2, max: 200, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                ],
                mobile: [
                    {
                        required: true,
                        pattern: /^1[34578]\d{9}$/,//可以写正则表达式呦呦呦
                        message: '目前只支持中国大陆的手机号码',
                        trigger: 'blur'
                    }
                ],
                gender: [
                    { required: true, message: '选择性别' },
                ],
                status: [
                    { required: true, message: '选择入职状态' },
                ],
                entry_time: [
                    { required: true, message: '请输入入职日期', trigger: 'blur' },
                ],
                address: [
                    { required: true, message: '请输入住址', trigger: 'blur' },
                ],
                full_time: [
                    { required: true, message: '请输入转正日期', trigger: 'blur' },
                ]
            },
            status_rules: {
                full_time: [
                    { required: true, message: '请输入转正日期', trigger: 'blur' },
                ]
            }
        }
    },
    methods: {
        //添加按钮
        add() {
            this.updateStatus = false;
            this.imageUrl = '';
            this.dialogFormVisible = true;
        },
        //open选择转正日期框
        statusDialog(row) {
            this.dialogVisible = true
            this.status_id = row.id
        },
        //请求改变状态接口
        changeStatus(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    let url = "head/headTeacher-status"
                    this.axios.post(url, {
                        'full_time': this.create_form.full_time,
                        'status': 10,
                        'id': this.status_id,
                    }).then(response => {
                        this.open1(20);
                        this.$refs[formName].resetFields();
                        this.dialogVisible = false
                        this.list(this.currentPage);
                        this.status_id = '';
                        console.log(response);
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else {
                    console.log('error submit!!');
                    return false;
                }
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
            this.list(this.currentPage)
        },
        //请求list接口
        list(currentPage, pageSize = null) {
            if (pageSize) {
                var url = "head/headTeacher-list?page=" + currentPage + "&searchTeacherMobile=" + this.searchTeacherMobile + "&pageSize=" + pageSize;
            } else {
                var url = "head/headTeacher-list?page=" + currentPage + "&searchTeacherMobile=" + this.searchTeacherMobile;
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
            if (status == 20) {
                this.$set(data, 'message', h('p', '转正成功'))
            }
            if (status == 0) {
                this.$set(data, 'message', h('p', '删除成功'))
            }
            this.$notify(data);
        },
        //请求课程创建接口
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    if (this.updateStatus) {
                        let url = 'head/headTeacher-update'
                        this.axios.post(url, {
                            id: this.create_form.id,
                            name: this.create_form.name,
                            mobile: this.create_form.mobile,
                            picture: this.create_form.picture,
                            gender: this.create_form.gender,
                            entry_time: this.create_form.entry_time,
                            full_time: this.create_form.full_time,
                            status: this.create_form.status,
                            address: this.create_form.address,
                            introduction: this.create_form.introduction
                        }).then(response => {
                            this.$refs[formName].resetFields();
                            this.dialogFormVisible = false
                            this.list(this.currentPage)
                            Notification({
                                title: '信息提示',
                                message: '修改成功',
                                type: "success",
                                duration: 1000
                            });
                        }).catch(error => {
                            let mes = error.response.data['data'];
                            if (mes['mobile']) {
                                Notification({
                                    title: '验证错误',
                                    message: '手机不能重复',
                                    type: "error",
                                    duration: 2000
                                });
                            } else {
                                Notification({
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
                        let url = 'head/headTeacher-create'
                        this.axios.post(url, {
                            name: this.create_form.name,
                            mobile: this.create_form.mobile,
                            picture: this.create_form.picture,
                            gender: this.create_form.gender,
                            entry_time: this.create_form.entry_time,
                            full_time: this.create_form.full_time,
                            status: this.create_form.status,
                            address: this.create_form.address,
                            introduction: this.create_form.introduction
                        }).then(response => {
                            this.$refs[formName].resetFields();
                            this.dialogFormVisible = false
                            this.list(this.currentPage)
                            Notification({
                                title: '信息提示',
                                message: '添加成功',
                                type: "success",
                                duration: 1000
                            });
                        }).catch(error => {
                            let mes = error.response.data['data'];
                            if (mes['mobile']) {
                                Notification({
                                    title: '验证错误',
                                    message: '手机不能重复',
                                    type: "error",
                                    duration: 2000
                                });
                            } else {
                                Notification({
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
            this.radioStatus = true
        },
        handleClose(done) {
            done();
            this.$refs['form'].resetFields();
            this.cleanCreateFormData()
            this.refresh()
        },
        //课程信息详情
        Deatil(id) {
            let url = 'head/headTeacher-detail'
            this.axios.post(url, {
                id: id,
            }).then(response => {
                this.radioStatus = false
                this.dialogFormVisible = true
                this.create_form = response.data
                this.imageUrl = this.create_form.picture
                this.updateStatus = true
                console.log(this.create_form.examine)
            }).catch(error => {
                alert('错误')
            });
        },
        //清空表单值
        cleanCreateFormData() {
            this.create_form.name = ''
            this.create_form.mobile = ''
            this.create_form.picture = ''
            this.create_form.gender = ''
            this.create_form.entry_time = ''
            this.create_form.full_time = ''
            this.create_form.status = ''
            this.create_form.address = ''
            this.create_form.introduction = ''
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
            let url = 'head/headTeacher-list?page=' + value
            this.axios.get(url).then(response => {
                this.currentPage = response.data.current_page
                this.tableData = response.data.data;
                console.log(this.tableData);
            }).catch(error => {
                alert('错误')
            });
        },
        indexMethod(index) {
            //单前页码，具体看组件取值
            let curpage = this.currentPage
            //每页条数，具体是组件取值
            let limitpage = 13
            return (index + 1) + (curpage - 1) * limitpage
        },
        changePageSize(value) {
            this.list(this.currentPage, value);
        },
        Delete(row) {
            let url = "head/headTeacher-delete"
            this.axios.post(url, {
                'id': row.id,
            }).then(response => {
                this.open1(0);
                this.list(this.currentPage);
                console.log(response);
            }).catch(function (error) {
                console.log(error);
            });
        }
    },
    //默认直接请求list接口
    mounted: function () {
        this.list(this.currentPage);
    }
}
</script>

<style scoped>
.teacher-wrap {
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
    margin-bottom: 15px;
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
    border-color: #409eff;
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
