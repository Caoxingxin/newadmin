<template>
    <el-row class="tac">
        <el-col :span="24">
            <el-menu
                :default-active="this.$route.path"
                class="el-menu-vertical-demo"
                :router="true"
                text-color="black"
                active-text-color="bule">
                <el-menu-item index="/head/course">
                    <span slot="title">
                     <i class="el-icon-notebook-1"></i><span style="font-size: 15px">课程管理</span>
                    </span>
                </el-menu-item>
                <el-menu-item index="/head/student">
                    <span slot="title">
                     <i class="el-icon-user"></i><span style="font-size: 15px">学员管理</span>
                    </span>
                </el-menu-item>
                <el-menu-item index="/head/teacher">
                    <span slot="title">
                     <i class="el-icon-user-solid"></i><span style="font-size: 15px">教师管理</span>
                    </span>
                </el-menu-item>
                <el-submenu index="school">
                    <template slot="title">
                        <i class="el-icon-school"></i>
                        <span style="font-size: 15px">学校管理</span>
                    </template>
                    <el-menu-item index="/school/school"><i class="el-icon-school"></i>学校信息管理</el-menu-item>
                    <el-submenu index="school-semester">
                        <template slot="title">
                            <i class="el-icon-date"></i>学期管理
                        </template>
                        <el-menu-item index="/school/semester">学期信息管理</el-menu-item>
                    </el-submenu>
                    <el-submenu index="school-register">
                        <template slot="title">
                            <i class="el-icon-edit"></i>报名管理
                        </template>
                        <el-menu-item index="/school/register">学生报名</el-menu-item>
                        <el-menu-item index="/school/register_order">报名订单</el-menu-item>
                    </el-submenu>
                    <el-menu-item index="/school/student"><i class="el-icon-user"></i>学员管理</el-menu-item>
                    <el-submenu index="school-class">
                        <template slot="title">
                            <i class="el-icon-guide"></i>班级管理
                        </template>
                        <el-menu-item index="/school/class">班级信息管理</el-menu-item>
                        <el-menu-item index="/school/allot">学员分班管理</el-menu-item>
                    </el-submenu>
                    <el-menu-item index="/school/classroom"><i class="el-icon-house"></i>教室管理</el-menu-item>
                    <el-menu-item index="/school/grade"><i class="el-icon-document"></i>成绩单</el-menu-item>
                </el-submenu>
                <el-submenu index="class">
                    <template slot="title">
                        <i class="el-icon-guide"></i>
                        <span style="font-size: 15px">班级管理</span>
                    </template>
                    <el-menu-item index="/class/course_plan"><i class="el-icon-takeaway-box"></i>课表</el-menu-item>
                    <el-menu-item index="/class/student"><i class="el-icon-user"></i>学员管理</el-menu-item>
                    <el-menu-item index="/class/grade"><i class="el-icon-document"></i>成绩单</el-menu-item>
                </el-submenu>
                <el-submenu>
                    <template slot="title">
                        <i class="el-icon-guide"></i>
                        <span style="font-size: 15px">收益管理</span>
                    </template>
                </el-submenu>
            </el-menu>
        </el-col>
    </el-row>

</template>
<script>
    export default {
        name: 'Aside',
    }
</script>
<style scoped>
    .el-menu-item.is-active {
        color: dodgerblue !important;
    }

    .el-menu-item {
        text-align: left;
    }
</style>
