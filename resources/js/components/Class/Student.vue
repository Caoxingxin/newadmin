<template>
    <div class="student-wrap" v-if="schoolData">
        <el-card class="box-card">
            <el-select v-model="schoolValue" @change="changeSchoolId(schoolValue)" style="width:200px">
                <el-option
                    v-for="item in schoolData"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                >
                </el-option>
            </el-select>
            <el-select v-model="classValue" @change="changeClassId(classValue)" style="width:200px; position: absolute;left: 20%;">
                <el-option
                    v-for="item in classData"
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
                                  @clear="list(1,null,classValue)">
                            <el-button slot="append" icon="el-icon-search"
                                       @click="list(1,null,classValue)"></el-button>
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

                </el-row>

                <!--分页-->
                <el-pagination
                    :page-sizes="[15, 30, 40, 50]"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="this.total"
                    style="margin-right: 10px"
                    @current-change="page"
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
                            <a @click="Deatil(scope.row.student_id)">{{scope.row.name}}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="mobile" label="联系方式"></el-table-column>
                    <el-table-column prop="gender" label="性别">
                        <template slot-scope="scope">
                            <span v-if="scope.row.gender === 1">男</span>
                            <span v-else>女</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="status" label="状态" :formatter="ListenStatus"></el-table-column>
                    <el-table-column prop="degree" label="注册等级">
                        <template slot-scope="scope">
                            <span v-if="scope.row.degree === 10">普通</span>
                            <span v-else>高级</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="company" label="工作单位"></el-table-column>
                    <el-table-column prop="remark" label="备注"></el-table-column>
                </el-table>
            </div>

        </el-card>

        <el-dialog title="学生信息" :visible.sync="dialogFormVisible" width="800px" top="20px" :close-on-click-modal="false" :before-close="handleClose">
            <el-form ref="form" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="姓名:" prop="name">
                    <el-input v-model="create_form.name" autocomplete="off" style="width: 200px !important;" placeholder="请输入姓名" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="联系电话:" prop="mobile">
                    <el-input v-model="create_form.mobile" autocomplete="off" style="width: 200px !important;" placeholder="请输入电话" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="图片:" prop="avatar">
                    <el-upload class="avatar-uploader" action="http://localhost:3600/admin/upload"
                               :show-file-list="false"
                               :on-success="handleAvatarSuccess"
                               :before-upload="beforeAvatarUpload" ref="myUpload" :disabled="true">
                        <img v-if="imageUrl" :src="this.imageUrl" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>
                <el-form-item label="邮箱地址:" prop="email">
                    <el-input v-model="create_form.email" autocomplete="off" style="width: 200px !important;" placeholder="请输入邮箱" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="性别:" prop="gender">
                    <el-radio-group v-model="create_form.gender" :disabled="true">
                        <el-radio :label="1">男</el-radio>
                        <el-radio :label="0">女</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="状态" prop="status">
                    <el-select v-model="create_form.status" placeholder="请选择" :disabled="true">
                        <el-option label="潜在" value="10"></el-option>
                        <el-option label="学员" value="20"></el-option>
                        <el-option label="毕业" value="30"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="注册等级" prop="degree">
                    <el-select v-model="create_form.degree" placeholder="请选择" :disabled="true">
                        <el-option label="普通" value="10"></el-option>
                        <el-option label="高级" value="20"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="工作单位:" prop="company">
                    <el-input v-model="create_form.company" autocomplete="off" style="width: 500px !important;" placeholder="请输入工作单位" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="备注:" prop="remark">
                    <el-input type="textarea" v-model="create_form.remark" autocomplete="off" :autosize="{ minRows: 4, maxRows: 6}" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
                <el-form-item label="描述:" prop="introduction">
                    <el-input type="textarea" v-model="create_form.introduction"
                              autocomplete="off"
                              :autosize="{ minRows: 4, maxRows: 6}" placeholder="描述" size="small" :disabled="true">
                    </el-input>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>

<script>
import { Notification } from 'element-ui';
export default {
    name: "Student",
    data() {
        return {
            classData: '',
            classValue: '',
            schoolData: '',
            schoolValue: '',
            index: 1,
            searchStudentMobile: '',
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
                name: '',
                mobile: '',
                email: '',
                gender: '',
                status: '',
                degree: '',
                company: '',
                avatar: '',
                remark: '',
                introduction: ''
            },
        }
    },
    methods: {
        listSchoolData() {
            let url = "head/headSchool-list?status=1";
            this.axios.get(url).then(response => {
                this.schoolData = response.data.data
                this.schoolValue = this.schoolData[0]['id'];
                this.listClassData(this.schoolValue);
                //这里请求默认的下拉选项的值
                // this.list(this.currentPage, null, this.schoolValue);
            }).catch(function (error) {
                console.log(error);
            });
        },
        listClassData(value){
            let url = 'school/get-classes-list?school_id='+value;
            this.axios.get(url).then(response => {
                this.classData = response.data
                this.classValue = this.classData[0]['id'];
                //这里请求默认的下拉选项的值
                this.list(this.currentPage, null, this.classValue);
            }).catch(function (error) {
                console.log(error);
            });
        },
        //设置状态值
        ListenStatus(row) {
            if (row.status == 10) {
                return "潜在学员";
            } else if (row.status == 20) {
                return "正式学员";
            } else {
                return "已毕业学员"
            }
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
            this.list(this.currentPage,null,this.classValue)
        },
        //请求list接口
        list(currentPage, pageSize = null,classId) {
            if (pageSize) {
                var url = "classes/classeStudent-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&pageSize=" + pageSize + "&class_id=" + classId;
            } else {
                var url = "classes/classeStudent-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&class_id=" + classId;
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

        handleClose(done) {
            done();
            this.$refs['form'].resetFields();
            this.cleanCreateFormData()
            this.refresh()
        },
        //学生信息详情
        Deatil(id) {
            let url = 'classes/classeStudent-detail'
            this.axios.post(url, {
                student_id: id,
            }).then(response => {
                this.dialogFormVisible = true
                response.data.status = String(response.data.status)
                response.data.degree = String(response.data.degree)
                this.create_form = response.data
                this.imageUrl = this.create_form.avatar
                this.updateStatus = true
            }).catch(error => {
                alert('错误')
            });
        },
        //清空表单值
        cleanCreateFormData() {
            this.create_form.name = ''
            this.create_form.mobile = ''
            this.create_form.email = ''
            this.create_form.gender = ''
            this.create_form.status = ''
            this.create_form.degree = ''
            this.create_form.company = ''
            this.create_form.avatar = ''
            this.create_form.remark = ''
            this.create_form.introduction = ''
        },
        //上传图片
        handleAvatarSuccess(response) {
            this.imageUrl = '/storage/image/' + response.filepath;
            this.create_form.avatar = this.imageUrl
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
            this.list(value,null,this.schoolValue);
        },
        indexMethod(index) {
            //单前页码，具体看组件取值
            let curpage = this.currentPage
            //每页条数，具体是组件取值
            let limitpage = 15
            return (index + 1) + (curpage - 1) * limitpage
        },
        changePageSize(value) {
            this.list(this.currentPage, value,this.schoolValue);
        },
        changeSchoolId(value) {
            this.currentPage = 1;
            this.classData = '';
            this.classValue = '';
            this.tableData = [];
            this.listClassData(value);
            // this.list(this.currentPage, null, this.schoolValue);
        },
        changeClassId(value) {
            this.currentPage = 1;
            this.list(this.currentPage, null, this.classValue);
        },
    },
    //默认直接请求list接口
    created() {
        this.listSchoolData();
    }
}
</script>

<style scoped>
.student-wrap {
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
