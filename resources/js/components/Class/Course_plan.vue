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
            <el-select v-model="classValue" @change="changeClassId(classValue)"
                       style="width:200px; position: absolute;left: 15%;">
                <el-option
                    v-for="item in classData"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                >
                </el-option>
            </el-select>
            <el-date-picker
                v-model="train_time"
                type="daterange"
                range-separator="至"
                start-placeholder="开始日期"
                end-placeholder="结束日期"
                value-format="yyyy-MM-dd"
                style="width:400px; position: absolute;left: 28%;"
                :disabled="!changeModel"
            >
            </el-date-picker>
            <div class="search-main">
                <el-row class="elRow">
                    <!--添加-->
                    <el-col :span="2" style="margin-top: 10px">
                        <el-button type="primary" size="small" @click="add" icon="el-icon-plus">添加
                        </el-button>
                    </el-col>
                    <!--搜索框-->
                    <el-col :span="6" style="margin: 10px 10px 0 0">
                        <el-input placeholder="请输入内容" size="small" v-model="searchCourseName" clearable
                                  @clear="list(1,null,classValue)" :disabled="!changeModel">
                            <el-button slot="append" icon="el-icon-search"
                                       @click="list(1,null,classValue)" :disabled="!changeModel"></el-button>
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
                    <!--切换模式-->
                    <el-col :span="10"></el-col>
                    <el-col :span="2" style="margin-top: 10px">
                        <el-button type="primary" size="small" @click="Change(changeModel)" icon="el-icon-plus">切换模式
                        </el-button>
                    </el-col>
                    <el-col :span="1" style="margin-top: 10px">
                        <el-button type="primary" size="small" @click="check" icon="el-icon-plus">批量审核
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
                <el-table :data="tableData" style="width: 100%" border stripe v-loading="loading"
                          v-if="changeModel" @selection-change="selectCoursePlan">
                    <el-table-column
                        type="selection"
                        width="50">
                    </el-table-column>
                    <el-table-column label="班级">
                        <template slot-scope="scope">
                            <a @click="Deatil(scope.row.id)">{{ scope.row.class_name }}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="classroom_name" label="教室"></el-table-column>
                    <el-table-column prop="course_name" label="课程"></el-table-column>
                    <el-table-column prop="teacher_name" label="教师"></el-table-column>
                    <el-table-column prop="max_number" label="容纳人数"></el-table-column>
                    <el-table-column prop="date" label="日期"></el-table-column>
                    <el-table-column prop="start_at" label="开始时间"></el-table-column>
                    <el-table-column prop="end_at" label="结束时间"></el-table-column>
                    <el-table-column prop="status" label="状态">
                        <template slot-scope="scope">
                            <span v-if="scope.row.status === 10">已审核</span>
                            <span v-if="scope.row.status === 20">未审核</span>
                            <span v-if="scope.row.status === 30">已取消</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作" width="280px">
                        <template slot-scope="scope">
                            <a @click="cancel(scope.row.id)"
                               v-if="scope.row.status === 20">
                                取消
                            </a>
                        </template>
                    </el-table-column>
                </el-table>


                <!--                <el-table :data="cousrePlanTableData" style="width: 100%" border stripe v-loading="loading" v-else>-->
                <!--                    <el-table-column v-for="(item,index) in weekDayTableData[0]"-->
                <!--                                     :key="index"-->
                <!--                                     :prop="index"-->
                <!--                                     :label="item+' '+weekString[index-1]"-->
                <!--                                     height="200px"-->
                <!--                                     align="center">-->
                <!--                    </el-table-column>-->
                <!--                </el-table>-->
                <div v-else>
                    <el-button-group>
                        <el-button @click="preNextBtn('pre')">《</el-button>
                        <el-button @click="today">今天</el-button>
                        <el-button @click="preNextBtn('next')">》</el-button>
                    </el-button-group>
                    <el-calendar :range="[ this.weekDayTableData[0][1],this.weekDayTableData[0][7]]">
                        <!--                <el-calendar v-else :range="train_time">-->
                        <!--                <el-calendar v-else>-->
                        <!-- 这里使用的是 2.5 slot 语法，对于新项目请使用 2.6 slot 语法-->
                        <template
                            slot="dateCell"
                            slot-scope="{date, data}"
                        >
                            <p>
                                {{ data.day.split('-').slice(1).join('-') }}
                            </p>
                            <div v-for="item in tableData">
                                <div v-if="item.date == data.day"
                                     style="height: 100px;width: 100%;margin: 20px 0 5px 0;border-bottom: solid 1px">
                                    <p>{{ item.course_name }}</p>
                                    <p>{{ item.start_at }} ~ {{ item.end_at }}</p>
                                    <p>{{ item.teacher_name }}</p>
                                </div>
                            </div>
                        </template>
                    </el-calendar>
                </div>
            </div>

        </el-card>

        <el-dialog title="学生信息" :visible.sync="dialogFormVisible" width="800px" top="20px" :close-on-click-modal="false"
                   :before-close="handleClose">
            <el-form ref="form" :model="create_form" :label-position="labelPosition" label-width="100px">
                <el-form-item label="课程名称:" prop="course_id">
                    <el-select v-model="create_form.course_id" @change="changeCourseId(create_form.course_id)">
                        <el-option
                            v-for="item in courseData"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="教师:" prop="teacher_id">
                    <el-select v-model="create_form.teacher_id" @change="changeTeacherId(create_form.teacher_id)"
                               :disabled="create_form.status==10">
                        <el-option
                            v-for="item in teacherData"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="教室:" prop="classroom_id">
                    <el-select v-model="create_form.classroom_id" @change="changeClassRoomId(create_form.classroom_id)">
                        <el-option
                            v-for="item in classroomData"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="容纳人数:">
                    <el-input v-model="create_form.max_num" autocomplete="off" style="width: 200px !important;"
                              size="small">
                    </el-input>
                </el-form-item>
                <el-form-item v-if="!detailStatus">
                    <el-button-group>
                        <el-button @click="dayButtion=true">单日</el-button>
                        <el-button @click="dayButtion=false">周期</el-button>
                    </el-button-group>
                </el-form-item>
                <el-form-item v-if="dayButtion" label="日期:">
                    <el-date-picker
                        v-model="create_form.date"
                        type="date"
                        value-format="yyyy-MM-dd"
                        placeholder="选择日期"
                        :disabled="create_form.status==10"
                    >
                    </el-date-picker>
                </el-form-item>
                <el-form-item v-else>
                    <el-date-picker
                        v-model="create_form.startAndEndDate"
                        type="daterange"
                        range-separator="至"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期"
                        value-format="yyyy-MM-dd"
                        :picker-options="pickerOptionsTime"
                    >
                    </el-date-picker>
                </el-form-item>
                <el-form-item>
                    <el-time-picker
                        is-range
                        v-model="create_form.startAndEndAt"
                        range-separator="至"
                        start-placeholder="开始时间"
                        end-placeholder="结束时间"
                        value-format="HH:mm"
                        placeholder="选择时间范围"
                        :disabled="create_form.status==10"
                    >
                    </el-time-picker>
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
    name: "Course_plan",
    data() {
        return {
            ids: [],
            detailStatus: false,
            dayButtion: true,          //切换单日周期
            classroomData: '',        //教室所有值
            classroomValue: '',       //教室id
            teacherData: '',          //教师所有值
            teacherValue: '',         //教师id
            courseData: '',         //课程所有值
            courseValue: '',        //课程id
            train_time: '',         //筛选日期值
            changeModel: true,
            classData: '',
            classValue: '',
            schoolData: '',
            schoolValue: '',
            index: 1,
            searchCourseName: '',
            currentPage: 1,
            operate_id: window.postId,
            //总条数
            total: 0,
            imageUrl: '',
            updateStatus: false,
            labelPosition: 'right',
            loading: false,
            dialogFormVisible: false,
            formLabelWidth: '120px',
            tableData: [],
            weekDayTableData: [],
            cousrePlanTableData: [],
            weekString: [
                '周一', '周二', '周三', '周四', '周五', '周六', '周天'
            ],
            create_form: {
                id: '',
                course_id: '',
                teacher_id: '',
                classroom_id: '',
                max_num: '',
                date: '',       //单日传
                startAndEndDate: '',   //周期传
                startAndEndAt: '',
                status: '',
            },
            pickerOptionsTime: {
                disabledDate(time) {
                    return time.getTime() < Date.now() - 8.64e7;
                }
            },
        }
    },
    methods: {
        selectCoursePlan(val){
            for (var i = 0; i < val.length; i++)
                this.ids[i] = val[i]['id']
        },
        //切换模式
        Change(value) {
            this.changeModel = !value;
            if (!this.changeModel) {
                this.train_time = [
                    this.weekDayTableData[0][1],
                    this.weekDayTableData[0][7]
                    // '2021-02-22',
                    // '2021-02-28'
                ]
            } else {
                this.train_time = ''
            }
            this.list(this.currentPage, null, this.classValue)
        },
        //list学校
        listSchoolData() {

            let url = "head/headSchool-list?status=1";
            this.axios.get(url).then(response => {
                this.schoolData = response.data.data
                this.schoolValue = this.schoolData[0]['id'];
                this.listCourseData();
                this.listTeacherData();
                this.listClassRoomData();

                this.listClassData(this.schoolValue);
                //这里请求默认的下拉选项的值
                // this.list(this.currentPage, null, this.schoolValue);
            }).catch(function (error) {
                console.log(error);
            });
        },
        //list对应学校下的班级
        listClassData(value) {
            let url = 'school/get-classes-list?school_id=' + value;
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
            this.list(this.currentPage, null, this.classValue)
        },

        //添加按钮
        add() {
            this.updateStatus = false;
            this.dialogFormVisible = true;
        },

        //请求list接口
        list(currentPage, pageSize = null, classId) {
            if (!this.train_time) {
                this.train_time = ''
            }
            var date = {
                'start': this.train_time[0],
                'end': this.train_time[1],
            }
            var url = "classes/classesCoursePlan-list"
            if (pageSize) {
                var data = {
                    'page': currentPage,
                    'searchCourseName': this.searchCourseName,
                    'date': date,
                    'pageSize': pageSize,
                    'class_id': classId,
                    'school_id': this.schoolValue
                }
            } else {
                var data = {
                    'page': currentPage,
                    'searchCourseName': this.searchCourseName,
                    'date': date,
                    'class_id': classId,
                    'school_id': this.schoolValue,
                }
            }
            this.axios.post(url, data).then(response => {
                this.currentPage = response.data.current_page
                this.weekDayTableData = response.data.weekday
                this.tableData = response.data.data

                console.log('--------------------')
                console.log(this.weekDayTableData)
                this.total = response.data.total;
                this.cleanCreateFormData()
            }).catch(function (error) {
                console.log(error);
            });
        },
        //请求课表创建接口
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    if (this.updateStatus) {
                        let url = 'classes/classesCoursePlan-update'
                        this.axios.post(url, {
                            id: this.create_form.id,
                            class_id: this.classValue,
                            course_id: this.create_form.course_id,
                            teacher_id: this.create_form.teacher_id,
                            classroom_id: this.create_form.classroom_id,
                            max_num: this.create_form.max_num,
                            date_type: true,
                            date: this.create_form.date,
                            start_at: this.create_form.startAndEndAt[0],
                            end_at: this.create_form.startAndEndAt[1],
                            operate_id: this.operate_id,
                            status: this.create_form.status,
                        }).then(response => {
                            this.$refs[formName].resetFields();
                            this.dialogFormVisible = false
                            this.list(this.currentPage, null, this.classValue)
                            Notification({
                                title: '信息提示',
                                message: '修改成功',
                                type: "success",
                                duration: 1000
                            });
                        }).catch(error => {
                            this.$alert(error.response.data['data'][0] + ',' + error.response.data['data'][1] + ',' + error.response.data['data'][2], error.response.data['message'], {
                                confirmButtonText: '确定',
                                callback: action => {
                                    this.$refs[formName].resetFields();
                                    this.dialogFormVisible = false
                                    this.list(this.currentPage, null, this.classValue)
                                }
                            });
                        });
                    } else {
                        var data = {
                            class_id: this.classValue,
                            course_id: this.create_form.course_id,
                            teacher_id: this.create_form.teacher_id,
                            classroom_id: this.create_form.classroom_id,
                            max_num: this.create_form.max_num,
                            date_type: this.dayButtion,
                            operate_id: this.operate_id,
                        }
                        if (this.dayButtion) {
                            data.date = this.create_form.date,
                                data.end_at = this.create_form.startAndEndAt[1],
                                data.start_at = this.create_form.startAndEndAt[0]
                        } else {
                            console.log(this.create_form.startAndEndAt)
                            data.start_date = this.create_form.startAndEndDate[0],
                                data.end_date = this.create_form.startAndEndDate[1],
                                data.end_at = this.create_form.startAndEndAt[1],
                                data.start_at = this.create_form.startAndEndAt[0]
                        }
                        let url = 'classes/classesCoursePlan-create'
                        this.axios.post(url, data).then(response => {
                            this.$refs[formName].resetFields();
                            this.dialogFormVisible = false
                            this.list(this.currentPage, null, this.classValue)
                            Notification({
                                title: '信息提示',
                                message: '添加成功',
                                type: "success",
                                duration: 1000
                            });
                        }).catch(error => {
                            this.$alert(error.response.data['data'][0] + ',' + error.response.data['data'][1] + ',' + error.response.data['data'][2], error.response.data['message'], {
                                confirmButtonText: '确定',
                                callback: action => {
                                    this.$refs[formName].resetFields();
                                    this.dialogFormVisible = false
                                    this.list(this.currentPage, null, this.classValue)
                                }
                            });
                        });
                    }
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        handleClose(done) {
            done();
            this.$refs['form'].resetFields();
            this.detailStatus = false
            this.cleanCreateFormData()
            this.refresh()
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.cleanCreateFormData()
            this.dialogFormVisible = false
            this.detailStatus = false
            this.refresh()
        },
        //课表信息详情
        Deatil(id) {
            let url = 'classes/classesCoursePlan-detail'
            this.axios.post(url, {
                id: id,
            }).then(response => {
                this.dialogFormVisible = true
                this.detailStatus = true


                this.create_form = response.data
                this.$set(this.create_form, 'startAndEndAt', [this.create_form.start_at, this.create_form.end_at])
                console.log(this.create_form)
                this.updateStatus = true
            }).catch(error => {
                alert('错误')
            });
        },
        //清空表单值
        cleanCreateFormData() {
            this.create_form.course_id = '',
                this.create_form.teacher_id = '',
                this.create_form.classroom_id = '',
                this.create_form.max_num = '',
                this.create_form.date = '',
                this.create_form.startAndEndDate = '',
                this.create_form.startAndEndAt = ''
        },
        page(value) {
            this.list(value, null, this.schoolValue);
        },
        changePageSize(value) {
            this.list(this.currentPage, value, this.schoolValue);
        },
        changeSchoolId(value) {
            this.currentPage = 1;
            this.classData = '';
            this.classValue = '';
            this.tableData = [];
            this.schoolValue = value;
            this.listClassRoomData();
            this.listClassData(value);
            // this.list(this.currentPage, null, this.schoolValue);
        },
        changeClassId(value) {
            this.currentPage = 1;
            this.list(this.currentPage, null, this.classValue);
        },
        //下拉选择课程
        changeCourseId(value) {
            this.courseValue = value
            console.log(this.courseValue)
        },
        //获取课程
        listCourseData() {
            let url_course = 'head/get-course-list'
            this.axios.get(url_course).then(response => {
                this.courseData = response.data
                this.courseValue = this.courseData[0]['id'];
                console.log(this.courseData)
            }).catch(error => {
                alert('错误2')
            });
        },
        //下拉获取教师
        changeTeacherId(value) {
            this.teacherValue = value
        },
        //获取教师
        listTeacherData() {
            let url_teacher = 'head/get-teacher-list'
            this.axios.get(url_teacher).then(response => {
                this.teacherData = response.data
                this.teacherValue = this.teacherData[0]['id'];
            }).catch(error => {
                alert('错误3')
            });
        },
        //下拉获取教室
        changeClassRoomId(value) {
            this.classroomValue = value
            this.create_form.max_num = ''
            for (var s = 0; s < this.classroomData.length; s++) {
                if (this.classroomData[s]['id'] === this.classroomValue) {
                    this.create_form.max_num = this.classroomData[s]['max_number']
                }
            }
        },
        //获取教室
        listClassRoomData() {
            let url_classroom = 'school/get-classroom-list'
            this.axios.post(url_classroom, {
                school_id: this.schoolValue,
            }).then(response => {
                this.classroomData = response.data
                if (this.classroomData.length !== 0) {
                    this.classroomValue = this.classroomData[0]['id'];
                }
            }).catch(error => {
                alert('错误4')
            });
        },
        //审核
        check(){
            if (this.ids.length == 0) {
                return
            }
            let url = 'classes/classesCoursePlan-check'
            this.axios.post(url, {
                ids: this.ids,
            }).then(response => {
                Notification({
                    title: '信息提示',
                    message: '取消成功',
                    type: "success",
                    duration: 1000
                });
                this.list(this.currentPage, null, this.classValue)
            }).catch(error => {
                alert('错误4')
            });
        },
        //取消课程
        cancel(id){
            let url = 'classes/classesCoursePlan-cancel'
            this.axios.post(url, {
                id: id,
            }).then(response => {
                Notification({
                    title: '信息提示',
                    message: '取消成功',
                    type: "success",
                    duration: 1000
                });
                this.list(this.currentPage, null, this.classValue)
            }).catch(error => {
                alert('错误4')
            });
        },
        //今天
        today(){

        },
        //上,下一周
        /*preNextBtn(val){*/

        /*    var date_start = new Date( this.weekDayTableData[0][1]);*/
        /*    var date_end = new Date(this.weekDayTableData[0][7]);*/
        /*    if (val == 'pre'){*/
        /*        date_start.setDate(date_start.getDate() - 7);*/
        /*        date_end.setDate(date_end.getDate() - 7);*/

        /*    }else{*/
        /*        date_start.setDate(date_start.getDate() + 7);*/
        /*        date_end.setDate(date_end.getDate() + 7);*/
        /*    }*/
        //
        //     var year_start = date_start.getFullYear();
        //     var month_start = date_start.getMonth() + 1;
        //     var day_start = date_start.getDate();
        //
        //     var year_end = date_end.getFullYear();
        //     var month_end = date_end.getMonth() + 1;
        //     var day_end = date_end.getDate();
        //
        //     this.weekDayTableData[0][1] = year_start+'-'+month_start+'-'+day_start
        //     this.weekDayTableData[0][7] = year_end+'-'+month_end+'-'+day_end
        //
        //
        //     this.train_time = [
        //         this.weekDayTableData[0][1],
        //         this.weekDayTableData[0][7]
        //     ]
        //     console.log('aaaaaaaaaaa')
        //     console.log(this.train_time)
        //     this.list(this.currentPage, null, this.classValue);
        //
        // }
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
