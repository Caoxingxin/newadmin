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
                        <el-input placeholder="请输入内容" size="small" v-model="searchClassName" clearable
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
                    <el-table-column prop="name" label="名称">
                        <template slot-scope="scope">
                            <a @click="Deatil(scope.row.id)">{{scope.row.name}}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="school_name" label="学校"></el-table-column>
                    <el-table-column prop="semester_name" label="学期"></el-table-column>
                    <el-table-column prop="count" label="当前人数"></el-table-column>
                    <el-table-column prop="status" label="状态">
                        <template slot-scope="scope">
                            <span v-if="scope.row.status === 1">启用</span>
                            <span style="color:red" v-if="scope.row.status === -1">禁用</span>
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

        <el-dialog title="添加班级" :visible.sync="dialogFormVisible" width="800px" top="20px" :close-on-click-modal="false"
                   :before-close="handleClose">
            <el-form ref="form" :rules="rules" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="班级名称:" prop="name">
                    <el-input v-model="create_form.name" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入教室名称" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="学期:" prop="semester_id">
                    <el-select v-model="create_form.semester_id" :disabled="semesterDisable" @change="changeSemesterId(semesterValue)">
                        <el-option
                            v-for="item in semesterData"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
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
        name: "Class",
        data() {
            return {
                semesterDisable: false,
                semesterData: '',
                semesterValue: '',
                operate_id: window.postId,
                radio: '1',
                schoolData: '',
                schoolValue: '',
                index: 1,
                searchClassName: '',
                currentPage: 1,
                //总条数
                total: 0,
                updateStatus: false,
                labelPosition: 'right',
                loading: false,
                dialogFormVisible: false,
                formLabelWidth: '120px',
                tableData: [{}],
                create_form: {
                    id: '',
                    school_id: '',
                    semester_id: '',
                    semester_name: '',
                    name: '',
                    status: '',
                },
                rules: {
                    name: [
                        {required: true, message: '请输入名称', trigger: 'blur'},
                        {min: 2, max: 200, message: '长度在 3 到 5 个字符', trigger: 'blur'}
                    ],
                    semester_id: [
                        { required: true, message: '请选择学期', trigger: 'change' }
                    ]
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
                this.updateStatus = false;
                this.dialogFormVisible = true;
                this.create_form.semester_id = ''
            },
            //设置改变状态按钮值
            options(row) {
                if (row.status == 1) {
                    return "禁用";
                } else {
                    return "启用"
                }
            },
            //请求改变状态接口
            changeStatus(row) {
                let url = "school/schoolClass-status"
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
                this.list(this.currentPage, null, this.schoolValue)
            },
            //请求list接口
            list(currentPage, pageSize = null, schoolId) {
                if (pageSize) {
                    var url = "school/schoolClass-list?page=" + currentPage + "&searchClassName=" + this.searchClassName + "&pageSize=" + pageSize + "&school_id=" + schoolId;
                } else {
                    var url = "school/schoolClass-list?page=" + currentPage + "&searchClassName=" + this.searchClassName + "&school_id=" + schoolId;
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
                        if (this.updateStatus) {
                            let url = 'school/schoolClass-update'
                            this.axios.post(url, {
                                id: this.create_form.id,
                                school_id: this.schoolValue,
                                name: this.create_form.name,
                                operate_id:this.operate_id,
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
                                        message: '班级名不能重复',
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
                            let url = 'school/schoolClass-create'
                            this.axios.post(url, {
                                school_id: this.schoolValue,
                                name: this.create_form.name,
                                semester_id: this.create_form.semester_id,
                                operate_id:this.operate_id,
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
                                        message: '班级名不能重复',
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
                let url = 'school/schoolClass-detail'
                this.axios.post(url, {
                    id: id,
                }).then(response => {
                    this.dialogFormVisible = true
                    this.create_form = response.data
                    this.updateStatus = true
                    console.log(this.create_form)
                }).catch(error => {
                    alert('错误1')
                });
                //请求对应学习下的所以学期
                this.listSemesterData();
                this.semesterDisable = true;
            },
            //清空表单值
            cleanCreateFormData() {
                this.create_form.name = ''
                this.create_form.semester_name = ''
                this.create_form.status = ''
                this.semesterDisable = false
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
                let url = "school/schoolClass-delete"
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
            changeSemesterId(value){
                this.semesterValue = value
            },
            listSemesterData(){
                let url_semester = 'school/get-semester-list'
                this.axios.post(url_semester, {
                    school_id: this.schoolValue,
                }).then(response => {
                    this.semesterData = response.data
                    this.semesterValue = this.schoolData[0]['id'];
                    console.log(this.semesterData)
                }).catch(error => {
                    alert('错误2')
                });
            }
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
