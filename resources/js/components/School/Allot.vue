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
                <div v-for="item in tableData" class="table-item" @click="allot(item.semester_name,item.name,item.id,item.semester_id)">
                    <div class="item-avatar">
                        <span>{{ item.name | nameFileter }}</span>
                    </div>
                    <div class="item-class_name">
                        {{ item.name }}
                    </div>
                    <div class="item-semester_name">
                        {{ item.semester_name }}
                    </div>
                    <div class="item-count">
                        <span>学员{{ item.count }}人</span>
                    </div>
                </div>
                <!--      这个班级有哪些学生的弹窗          -->
                <el-drawer
                    title="分班管理"
                    :visible.sync="allotWindow"
                    direction="rtl"
                    size="70%"
                    :with-header="false"
                >
                    <div style="font-size: 25px;margin: 20px">{{ semesterName }}-{{ className }}</div>
                    <div class="search-main">
                        <el-row class="elRow">
                            <!--搜索框-->
                            <el-col :span="7" style="margin: 10px 10px 0 10px">
                                <el-input placeholder="请输入内容" size="small" v-model="searchStudentMobile" clearable
                                          @clear="listAllot(1,null,classValue)">
                                    <el-button slot="append" icon="el-icon-search"
                                               @click="listAllot(1,null,classValue)"></el-button>
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
                                    @click="refreshAllot">
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
                    <el-table :data="allotStudentData" style="width: 100%;margin: 10px" border stripe v-loading="loading">
                        <el-table-column
                            type="index"
                            :index="indexMethod"
                            width="50">
                        </el-table-column>
                        <el-table-column prop="student_name" label="姓名"></el-table-column>
                        <el-table-column prop="student_mobile" label="手机"></el-table-column>
                        <el-table-column prop="admin_name" label="操作人"></el-table-column>
                        <el-table-column prop="updated_at" label="修改时间"></el-table-column>
                        <el-table-column label="操作">
                            <template slot-scope="scope">
                                <el-button type="danger" size="mini" @click="Remove(scope.row)">移除
                                </el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-drawer>
            </div>
        </el-card>

<!--   学员分班时的弹窗     -->
        <el-dialog title="添加学员" :visible.sync="dialogFormVisible" width="80%" top="20px" :close-on-click-modal="false"
                   :before-close="handleClose">
            <div class="search-main">
                <el-row class="elRow">
                    <!--搜索框-->
                    <el-col :span="7" style="margin: 10px 10px 0 10px">
                        <el-input placeholder="请输入内容" size="small" v-model="searchStudentMobile" clearable
                                  @clear="listNotAllot(1,null,schoolValue,semesterValue)">
                            <el-button slot="append" icon="el-icon-search"
                                       @click="listNotAllot(1,null,schoolValue,semesterValue)"></el-button>
                        </el-input>
                    </el-col>
                    <!--添加-->
                    <el-col :span="2" style="margin-top: 10px">
                        <el-button type="primary" size="small" @click="distribute" icon="el-icon-plus">批量添加
                        </el-button>
                    </el-col>
                    <el-col :span="1" style="margin-top: 10px;margin-left:20px">
                        <el-button
                            type="primary"
                            size="small"
                            @click="refreshNotAllot">
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
            <el-table
                :data="notAllotStudentData"
                style="width: 100%;margin: 10px" border stripe v-loading="loading"
                @selection-change="selectStudent"
            >
                <el-table-column
                    type="selection"
                    width="50">
                </el-table-column>
                <el-table-column prop="name" label="姓名"></el-table-column>
                <el-table-column prop="mobile" label="手机"></el-table-column>
                <el-table-column prop="status" label="报道状态">
                    <template slot-scope="scope">
                        <span v-if="scope.row.status === 10" style="color:red">未报到</span>
                        <span v-if="scope.row.status === 20" style="color:green">已报到</span>
                        <span v-if="scope.row.status === 30" style="color:yellow" >延期</span>
                    </template>
                </el-table-column>
            </el-table>
        </el-dialog>
    </div>
</template>

<script>
import {Notification} from 'element-ui';

export default {
    name: "Allot",
    data() {
        return {
            allotWindow:false,
            color: ['rgb(212,164,235)', 'rgb(247,244,148)', 'rgb(114,204,225)', 'rgb(210,245,166)', 'rgb(252,151,175)'],
            semesterDisable: false,
            semesterData: '',
            semesterValue: '',
            semesterName: '',
            className:'',
            classValue: '',
            operate_id: window.postId,
            schoolData: '',
            schoolValue: '',
            studentIds: [],
            index: 1,
            searchClassName: '',
            searchStudentMobile: '',
            currentPage: 1,
            //总条数
            total: 0,
            updateStatus: false,
            labelPosition: 'right',
            loading: false,
            dialogFormVisible: false,
            formLabelWidth: '120px',
            tableData: [],
            allotStudentData:[],
            notAllotStudentData:[],
        };
    },
    methods: {
        selectStudent(val){
            console.log(val)
            for (var i=0;i<val.length;i++)
                 this.studentIds[i] = val[i]['student_id']
        },
        //添加学员到班级
        distribute(){
            console.log( this.studentIds)
            if (this.studentIds.length == 0){
                this.open1(-1);
                return
            }
            let url = "school/schoolClassAllot-distribute";
            this.axios.post(url,{
                'class_id' : this.classValue,
                'semester_id' : this.semesterValue,
                'student_id' : this.studentIds,
                'admin_id' : window.postId
            }).then(response =>{
                this.open1(1);
                this.listNotAllot(this.currentPage, null,this.schoolValue,this.semesterValue);
            }).catch(function (error){

            })
        },
        //对应班级详情入口
        allot(semeseterName,className,classId,semesterId){
            this.allotWindow = true
            this.semesterName = semeseterName
            this.semesterValue = semesterId
            this.className = className
            this.classValue = classId
            this.listAllot(this.currentPage, null, this.classValue)
        },
        //下拉学校选择
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
            // this.listSemesterData();
            this.listNotAllot(this.currentPage, null,this.schoolValue,this.semesterValue);
            this.updateStatus = false;
            this.dialogFormVisible = true;
        },
        //设置刷新按钮
        refresh() {
            this.loading = true
            setTimeout(() => {
                this.loading = false
            }, 500);
            this.list(this.currentPage, null, this.schoolValue)
        },
        //设置该班级学员刷新按钮
        refreshAllot() {
            this.loading = true
            setTimeout(() => {
                this.loading = false
            }, 500);
            this.listAllot(this.currentPage, null, this.classValue)
        },
        //设置未分班学员接口刷新
        refreshNotAllot(){
            this.loading = true
            setTimeout(() => {
                this.loading = false
            }, 500);
            this.listNotAllot(this.currentPage, null, this.schoolValue,this.semesterValue)
        },
        //请求班级list接口
        list(currentPage, pageSize = null, schoolId) {
            if (pageSize) {
                var url = "school/schoolClass-list?page=" + currentPage + "&searchClassName=" + this.searchClassName + "&pageSize=" + pageSize + "&school_id=" + schoolId;
            } else {
                var url = "school/schoolClass-list?page=" + currentPage + "&searchClassName=" + this.searchClassName + "&school_id=" + schoolId;
            }
            this.axios.get(url).then(response => {
                this.currentPage = response.data.current_page
                for (var i=0;i<response.data.data.length;i++)
                {
                    if (response.data.data[i]['status'] == -1)
                        continue
                    this.tableData[i] = response.data.data[i];
                }
                this.total = response.data.total;
            }).catch(function (error) {
                console.log(error);
            });
        },
        //该班级已有学员
        listAllot(currentPage, pageSize = null,classId){
            if (pageSize) {
                var url1 = "school/schoolClassAllot-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&pageSize=" + pageSize + "&class_id=" + classId;
            } else {
                var url1 = "school/schoolClassAllot-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&class_id=" + classId;
            }
            this.axios.get(url1).then(response => {
                this.currentPage = response.data.current_page
                this.allotStudentData = response.data.data;
                this.total = response.data.total;
            }).catch(function (error) {
                console.log(error);
            });
        },
        //请求未分配班级学员
        listNotAllot(currentPage, pageSize = null,schoolId,semesterId){
            if (pageSize) {
                var url2 = "school/schoolClassAllot-showList?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&pageSize=" + pageSize + "&school_id=" + schoolId + "&semester_id=" + semesterId;
            } else {
                var url2 = "school/schoolClassAllot-showList?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&school_id=" + schoolId + "&semester_id=" + semesterId;
            }
            this.axios.get(url2).then(response => {
                this.currentPage = response.data.current_page
                this.notAllotStudentData = response.data.data;
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
                this.$set(data, 'message', h('p', '添加成功'))
            } else if (status == -1) {
                this.$set(data, 'message', h('p', '请选择学生'))
            } else {
                this.$set(data, 'message', h('p', '删除成功'))
            }

            this.$notify(data);
        },
        handleClose(done) {
            done();
            this.refresh()
            this.refreshAllot()
            this.refreshNotAllot()
        },
        page(value) {
            this.list(value, null, this.schoolValue);
        },
        indexMethod(index) {
            //单前页码，具体看组件取值
            let curpage = this.currentPage
            //每页条数，具体是组件取值
            let limitpage = 13
            return (index + 1) + (curpage - 1) * limitpage
        },
        changePageSize(value) {
            this.list(this.currentPage, value, this.schoolValue);
        },
        //移除该班级学生
        Remove(row) {
            let url = "school/schoolClassAllot-remove"
            this.axios.post(url, {
                'class_id': this.classValue,
                'student_id' : row.student_id,
                'semester_id' : this.semesterValue
            }).then(response => {
                this.open1(0);
                this.listAllot(this.currentPage, null, this.classValue);
            }).catch(function (error) {
                console.log(error);
            });
        },
        //切换学校
        changeSchoolId(value) {
            console.log(value);
            this.currentPage = 1
            this.list(this.currentPage, null, this.schoolValue);
        },
    },
    created() {
        this.listSchoolData();
    },
    filters: {
        nameFileter(value) {
            if (value) {
                return value.substr(0, 1)
            }
        },
    }

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

.table-item {
    background-color: rgb(247, 249, 250);
    width: 350px;
    height: 200px;
    margin: 10px;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1)
}

.item-avatar {
    position: relative;
    border-radius: 100%;
    top: 8%;
    left: 10%;
    width: 80px;
    height: 80px;
    background-color: rgb(212, 164, 235);
    font-size: 30px;
    text-align: center;
    display: inline-block;
    line-height: 75px;
    color: white;
    font-weight: bold;
}

.item-class_name {
    position: relative;
    top: -20%;
    font-size: 20px;
    left: 50%;
}

.item-semester_name {
    position: relative;
    left: 50%;
    top: -10%;
    font-size: 15px;
}

.item-count {
    position: relative;
    top: 10%;
    left: 10%;
    letter-spacing: 1px;
}
</style>
