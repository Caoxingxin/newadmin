<template>
    <div class="school-wrap">
        <el-card class="box-card">
            <div class="search-main">
                <el-row class="elRow">
                    <!--搜索框-->
                    <el-col :span="7" style="margin: 10px 10px 0 0">
                        <el-input placeholder="请输入内容" size="small" v-model="searchSchoolName" clearable
                                  @clear="list(1)">
                            <el-button slot="append" icon="el-icon-search" @click="list(1)"></el-button>
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
                </el-row>
                <!--分页-->
                <el-pagination
                    :page-sizes="[15, 30, 40, 50]"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="this.total"
                    style="margin-right: 10px"
                    @current-change="list"
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
                    <el-table-column prop="phone" label="联系方式"></el-table-column>
                    <el-table-column prop="email" label="邮箱"></el-table-column>
                    <el-table-column prop="address" label="地址"></el-table-column>
                    <el-table-column prop="status" label="状态" :formatter="ListenStatus">
                        <template slot-scope="scope">
                            <span style="color:green" v-if="scope.row.status === 10">{{ListenStatus(scope.row) }}</span>
                            <span style="color:red" v-else>{{ListenStatus(scope.row) }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作">
                        <template slot-scope="scope">
                            <el-button type="text" size="mini" @click="changeStatus(scope.row)">{{options(scope.row)}}
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>

        </el-card>

        <el-dialog title="添加学校" :visible.sync="dialogFormVisible" width="800px" top="20px" :close-on-click-modal="false"
                   :before-close="handleClose">
            <el-form ref="form" :rules="rules" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="学校名称:" prop="name">
                    <el-input v-model="create_form.name" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入学校名称" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="英文名称:" prop="name_en">
                    <el-input v-model="create_form.name_en" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入学校名称" size="small">
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
                <!--                <el-form-item label="图片:" prop="picture">-->
                <!--                    <el-input v-model="create_form.picture" autocomplete="off"-->
                <!--                              style="width: 200px !important;" placeholder="请输入学校名称" size="small">-->
                <!--                    </el-input>-->
                <!--                </el-form-item>-->
                <el-form-item label="联系电话:" prop="phone">
                    <el-input v-model="create_form.phone" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入电话" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="邮箱地址:" prop="email">
                    <el-input v-model="create_form.email" autocomplete="off"
                              style="width: 200px !important;" placeholder="请输入邮箱" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="详细地址:" prop="address">
                    <el-input v-model="create_form.address" autocomplete="off"
                              style="width: 500px !important;" placeholder="请输入详细地址" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="英文地址:" prop="address_en">
                    <el-input v-model="create_form.address_en" autocomplete="off"
                              style="width: 500px !important;" placeholder="请输入英文地址" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item label="描述:" prop="description">
                    <el-input type="textarea" v-model="create_form.description" autocomplete="off"
                              :autosize="{ minRows: 4, maxRows: 6}" placeholder="描述" size="small">
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
        name: "School",
        data() {
            return {
                index: 1,
                searchSchoolName: '',
                currentPage: 1,
                //总条数
                total: 0,
                imageUrl: '',
                updateStatus: false,
                labelPosition: 'right',
                loading: false,
                dialogFormVisible: false,
                formLabelWidth: '120px',
                tableData: [{
                    id: '',
                    name: '',
                    phone: '',
                    email: '',
                    address: '',
                    status: ''
                }],
                create_form: {
                    id: '',
                    name: '',
                    name_en: '',
                    picture: '',
                    phone: '',
                    email: '',
                    address: '',
                    address_en: '',
                    description: '',
                },
                rules: {
                    name: [
                        {required: true, message: '请输入名称', trigger: 'blur'},
                        {min: 2, max: 200, message: '长度在 3 到 5 个字符', trigger: 'blur'}
                    ],
                    picture: [
                        {required: true, message: '请上传图片', trigger: 'blur'}
                    ],
                    phone: [
                        {
                            required: true,
                            pattern: /^1[34578]\d{9}$/,//可以写正则表达式呦呦呦
                            message: '目前只支持中国大陆的手机号码',
                            trigger: 'blur'
                        }
                    ],
                    email: [
                        {
                            type: 'email',
                            message: '请输入正确的邮箱地址',
                            trigger: ['blur', 'change']
                        }
                    ],
                    address: [
                        {
                            required: true,
                            message: '请输入详细地址',
                            trigger: 'blur'
                        }
                    ],
                    address_en: [
                        {
                            required: true,
                            message: '请输入详细英文地址',
                            trigger: 'blur'
                        }
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
                if (row.status == 10) {
                    return "运营中";
                } else {
                    return "暂停中"
                }
            },
            //设置改变状态按钮值
            options(row) {
                if (row.status == 10) {
                    return "暂停使用";
                } else {
                    return "开始运营"
                }
            },
            //请求改变状态接口
            changeStatus(row) {
                let url = "head/headSchool-status"
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
                    var url = "head/headSchool-list?page=" + currentPage + "&searchSchoolName=" + this.searchSchoolName + "&pageSize=" + pageSize;
                } else {
                    var url = "head/headSchool-list?page=" + currentPage + "&searchSchoolName=" + this.searchSchoolName;
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
                if (status == 10) {
                    this.$set(data, 'message', h('p', '暂停运营成功'))
                } else {
                    this.$set(data, 'message', h('p', '恢复运营成功'))
                }
                this.$notify(data);
            },
            //请求学校创建接口
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        if (this.updateStatus) {
                            let url = 'head/headSchool-update'
                            this.axios.post(url, {
                                id: this.create_form.id,
                                name: this.create_form.name,
                                name_en: this.create_form.name_en,
                                picture: this.create_form.picture,
                                phone: this.create_form.phone,
                                email: this.create_form.email,
                                address: this.create_form.address,
                                address_en: this.create_form.address_en,
                                description: this.create_form.description,
                            }).then(response => {
                                this.$refs[formName].resetFields();
                                this.dialogFormVisible = false
                                this.list(this.currentPage)
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
                                        message: '学校名不能重复',
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
                            let url = 'head/headSchool-create'
                            this.axios.post(url, {
                                name: this.create_form.name,
                                name_en: this.create_form.name_en,
                                picture: this.create_form.picture,
                                phone: this.create_form.phone,
                                email: this.create_form.email,
                                address: this.create_form.address,
                                address_en: this.create_form.address_en,
                                description: this.create_form.description,
                            }).then(response => {
                                this.$refs[formName].resetFields();
                                this.dialogFormVisible = false
                                this.list(this.currentPage)
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
                                        message: '学校名不能重复',
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
            //学校信息详情
            Deatil(id) {
                let url = 'head/headSchool-detail'
                this.axios.post(url, {
                    id: id,
                }).then(response => {
                    this.dialogFormVisible = true
                    this.create_form = response.data
                    this.imageUrl = this.create_form.picture
                    this.updateStatus = true
                }).catch(error => {
                    alert('错误')
                });
            },
            //清空表单值
            cleanCreateFormData() {
                this.create_form.name = ''
                this.create_form.name_en = ''
                this.create_form.picture = ''
                this.create_form.phone = ''
                this.create_form.email = ''
                this.create_form.address = ''
                this.create_form.address_en = ''
                this.create_form.description = ''
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
                let url = 'head/headSchool-list?page=' + value
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
            }
        },
        //默认直接请求list接口
        mounted: function () {
            this.list(this.currentPage);
        }
    }
</script>

<style scoped>
    .school-wrap {
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
