<template>
    <div class="course-container">
        <el-card>
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
                <el-pagination :page-sizes="[15, 30, 40, 50]" layout="total, sizes, prev, pager, next, jumper" :total="this.total" style="margin-right: 10px" @current-change="list" @size-change="changePageSize" :current-page="currentPage">
                </el-pagination>
            </div>

            <div class="table-main">
                <el-table :data="tableData" border stripe v-loading="loading">
                    <el-table-column type="index" :index="indexMethod">
                    </el-table-column>
                    <el-table-column prop="name" label="课程名称" width="200px">
                        <template slot-scope="scope">
                            <a @click="Deatil(scope.row.id)">{{scope.row.name}}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="type" label="课程类型"></el-table-column>
                    <el-table-column prop="duration" label="时长(分)"></el-table-column>
                    <el-table-column prop="created_at" label="创建时间"></el-table-column>
                    <el-table-column prop="examine" label="是否考核">
                        <template slot-scope="scope">
                            <span v-if="scope.row.examine === 1">考核</span>
                            <span style="color:red" v-if="scope.row.examine === 0">不考核</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="status" label="状态">
                        <template slot-scope="scope">
                            <span v-if="scope.row.status === 1">{{ListenStatus(scope.row) }}</span>
                            <span style="color:red" v-if="scope.row.status === -1">{{ListenStatus(scope.row) }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作">
                        <template slot-scope="scope">
                            <el-button type="success" size="mini" @click="changeStatus(scope.row)">{{options(scope.row)}}
                            </el-button>
                            <el-button type="danger" size="mini" @click="Delete(scope.row)">删除
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>

        </el-card>

        <el-dialog title="添加课程" :visible.sync="dialogFormVisible" width="800px" top="20px" :close-on-click-modal="false" :before-close="handleClose">
            <el-form ref="form" :rules="rules" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="课程名称:" prop="name">
                    <el-input v-model="create_form.name" autocomplete="off" style="width: 200px !important;" placeholder="请输入课程名称" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="课程类型:" prop="type">
                    <el-input v-model="create_form.type" autocomplete="off" style="width: 200px !important;" placeholder="请输入课程类型" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="图片:" prop="picture">
                    <el-upload class="avatar-uploader" action="http://localhost:3600/admin/upload" :show-file-list="false" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload" ref="myUpload">
                        <img v-if="imageUrl" :src="this.imageUrl" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>
                <el-form-item label="时长(分):" prop="duration">
                    <el-input v-model="create_form.duration" autocomplete="off" style="width: 200px !important;" placeholder="请输入时长" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="是否考核:" prop="description">
                    <el-radio-group v-model="create_form.examine">
                        <el-radio :label="1">是</el-radio>
                        <el-radio :label="0">否</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="描述:" prop="description">
                    <el-input type="textarea" v-model="create_form.remark" autocomplete="off" :autosize="{ minRows: 4, maxRows: 6}" placeholder="描述" size="small">
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
import { Notification } from 'element-ui';

export default {
    name: "Course",
    data() {
        return {
            index: 1,
            searchCourseName: '',
            currentPage: 1,
            //总条数
            total: 0,
            imageUrl: '',
            updateStatus: false,
            labelPosition: 'right',
            loading: false,
            dialogFormVisible: false,
            formLabelWidth: '120px',
            tableData: [{}],
            create_form: {
                id: '',
                name: '',
                type: '',
                duration: '',
                remark: '',
                picture: '',
                examine: '',
            },
            rules: {
                name: [
                    { required: true, message: '请输入名称', trigger: 'blur' },
                    { min: 2, max: 200, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                ],
                type: [
                    { required: true, message: '请输入课程类型', trigger: 'blur' },
                ],
                duration: [
                    { required: true, message: '请输入时长', trigger: 'blur' },
                ],
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
        //设置状态值
        ListenStatus(row) {
            if (row.status == 1) {
                return "启用";
            } else {
                return "禁用"
            }
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
            let url = "head/headCourse-status"
            this.axios.post(url, {
                'status': row.status,
                'id': row.id,
            }).then(response => {
                this.open1(row.status);
                this.list(this.currentPage);
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
            this.list(this.currentPage)
        },
        //请求list接口
        list(currentPage, pageSize = null) {
            if (pageSize) {
                var url = "head/headCourse-list?page=" + currentPage + "&searchCourseName=" + this.searchCourseName + "&pageSize=" + pageSize;
            } else {
                var url = "head/headCourse-list?page=" + currentPage + "&searchCourseName=" + this.searchCourseName;
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
                        let url = 'head/headCourse-update'
                        this.axios.post(url, {
                            id: this.create_form.id,
                            name: this.create_form.name,
                            picture: this.create_form.picture,
                            type: this.create_form.type,
                            duration: this.create_form.duration,
                            remark: this.create_form.remark,
                            examine: this.create_form.examine,
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
                            if (mes['name']) {
                                Notification({
                                    title: '验证错误',
                                    message: '课程名不能重复',
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
                        let url = 'head/headCourse-create'
                        this.axios.post(url, {
                            name: this.create_form.name,
                            picture: this.create_form.picture,
                            type: this.create_form.type,
                            duration: this.create_form.duration,
                            remark: this.create_form.remark,
                            examine: this.create_form.examine,
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
                            if (mes['name']) {
                                Notification({
                                    title: '验证错误',
                                    message: '课程名不能重复',
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
        },
        handleClose(done) {
            done();
            this.$refs['form'].resetFields();
            this.cleanCreateFormData()
        },
        //课程信息详情
        Deatil(id) {
            let url = 'head/headCourse-detail'
            this.axios.post(url, {
                id: id,
            }).then(response => {
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
            this.create_form.picture = ''
            this.create_form.type = ''
            this.create_form.duration = ''
            this.create_form.remark = ''
            this.create_form.examine = ''
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
            let url = 'head/headCourse-list?page=' + value
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
            let limitpage = 15
            return (index + 1) + (curpage - 1) * limitpage
        },
        changePageSize(value) {
            this.list(this.currentPage, value);
        },
        Delete(row) {
            let url = "head/headCourse-delete"
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
.course-container {
    flex: 1;
    display: flex;
    overflow: auto;
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
