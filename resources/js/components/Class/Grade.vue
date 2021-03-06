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
            <el-select v-model="classValue" @change="changeClassId(classValue)" style="width:200px; position: absolute;left: 15%;">
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
                    <el-table-column prop="semester_name" label="学期"></el-table-column>
                    <el-table-column prop="class_name" label="班级"></el-table-column>
                    <el-table-column prop="student_name" label="学员名"></el-table-column>
                    <el-table-column prop="student_mobile" label="手机"></el-table-column>
                    <el-table-column prop="score" label="综合得分"></el-table-column>
                    <el-table-column prop="admins_name" label="操作人"></el-table-column>
                    <el-table-column prop="audit" label="成绩审核状态">
                        <template slot-scope="scope">
                            <span v-if="scope.row.audit === 10">已审核</span>
                            <span v-else>未审核</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作">
                        <template slot-scope="scope">
                            <a @click="input(scope.row)"
                               v-if="scope.row.audit === -10"
                               style="font-size:13px;margin-right: 5px">
                                成绩录入
                            </a>
                            <el-divider direction="vertical"></el-divider>
                            <a @click="audit(scope.row)"
                               v-if="scope.row.audit === -10">
                                审核
                            </a>
                        </template>
                    </el-table-column>
                </el-table>
            </div>

        </el-card>
        <el-drawer
            title="分班管理"
            :before-close="handleClose"
            :visible.sync="gradeWindow"
            direction="rtl"
            size="30%"
            :with-header="false"
        >
            <div style="font-size: 25px;margin: 20px">成绩单-{{studentName}}</div>
            <el-form ref="form" :model="create_form" :label-position="labelPosition" label-width="100px">
                <div v-for="(item,index) in create_form">
                    <el-form-item :label="item.course_name">
                        <el-input v-model="item.score" autocomplete="off"
                                  style="width: 200px !important;" size="small">
                        </el-input>
                    </el-form-item>
                </div>
            </el-form>
            <div class="demo-drawer__footer" style="display:flex;padding:10px">
                <el-button @click="resetForm('form')" style="flex:1">取 消</el-button>
                <el-button type="primary" @click="submitForm('form')" style="flex:1">保 存</el-button>
            </div>
        </el-drawer>
    </div>
</template>

<script>
import { Notification } from 'element-ui';
export default {
    name: "Grade",
    data() {
        return {
            studentName: '',
            gradeWindow: false,
            classData: '',
            classValue: '',
            schoolData: '',
            schoolValue: '',
            index: 1,
            operate_id: window.postId,
            searchStudentMobile: '',
            currentPage: 1,
            //总条数
            total: 0,
            imageUrl: '',
            labelPosition: 'right',
            loading: false,
            dialogFormVisible: false,
            formLabelWidth: '120px',
            tableData: [],
            create_form: {
                id: '',
                score: '',
                course_name: '',
                student_id: '',
                course_id: '',
            },
            scores: []
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
                var url = "classes/classesStudentGrade-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&pageSize=" + pageSize + "&class_id=" + classId;
            } else {
                var url = "classes/classesStudentGrade-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&class_id=" + classId;
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
        //录入成绩
        submitForm(formName) {
            var student_id
            this.$refs[formName].validate((valid) => {
                if (valid) {

                    for (var i=0;i<this.create_form.length;i++){
                        this.scores[i] = {
                            course_id : this.create_form[i].course_id,
                            score :  this.create_form[i].score,
                        }
                        student_id = this.create_form[i].student_id
                    }
                    let url = 'classes/classesStudentGrade-input'
                    this.axios.post(url, {
                        student_id : student_id,
                        class_id : this.classValue,
                        operator_id: this.operate_id,
                        scores: this.scores,
                    }).then(response => {
                        this.$refs[formName].resetFields();
                        this.gradeWindow = false
                        this.list(this.currentPage, null, this.classValue)
                        Notification({
                            title: '信息提示',
                            message: '录入成功',
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

        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.cleanCreateFormData()
            this.gradeWindow = false
            this.refresh()
        },
        handleClose(done) {
            done();
            this.$refs['form'].resetFields();
            this.cleanCreateFormData()
            this.refresh()
        },
        //清空表单值
        cleanCreateFormData() {
            this.create_form.score = ''
            this.create_form.course_name = ''
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
            let limitpage = 13
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
        input(data){
            this.gradeWindow = true
            this.studentName = data.student_name
            this.Detail(data.id,data.class_id)
        },
        audit(data){
            let url = 'classes/classesStudentGrade-audit'
            this.axios.post(url, {
                class_id: this.classValue,
                student_id: data.id,
            }).then(response => {
                // Notification({
                //     title: '信息提示',
                //     message: '审核成功',
                //     type: "success",
                //     duration: 1000
                // });
            }).catch(error => {
                Notification({
                    title: '错误提示',
                    message: error.response.data['message'],
                    type: "error",
                    duration: 2000
                });
            });
        },
        //具体科目
        Detail(student_id,class_id){
            let url = 'classes/classesStudentGrade-detail'
            this.axios.post(url, {
                student_id: student_id,
                class_id : class_id
            }).then(response => {
                // this.dialogFormVisible = true
                this.create_form = response.data
                console.log(this.create_form)
            }).catch(error => {
                alert('错误1')
            });
        }
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
