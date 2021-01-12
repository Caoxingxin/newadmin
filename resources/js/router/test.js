// resources/assets/js/router/index.js
import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            path: '/',
            name: 'home',
            component: resolve => void(require(['../components/Head/Home.vue'], resolve)),
            meta: {title: '首页'}
        },
        {
            path: '/school/school',
            name: 'school',
            component: resolve => void(require(['../components/Head/School.vue'], resolve)),
            meta: {title: '学校管理'},
        },
        {
            path: '/school/semester',
            name: 'semester',
            component: resolve => void(require(['../components/School/Semester.vue'], resolve)),
            meta: {title: '学期管理'},
        },
        {
            path: '/school/register',
            name: 'register',
            component: resolve => void(require(['../components/School/Register.vue'], resolve)),
            meta: {title: '学员报名'},
        },
        {
            path: '/school/register_order',
            name: 'register_order',
            component: resolve => void(require(['../components/School/Register_order.vue'], resolve)),
            meta: {title: '报名订单'},
        },
        {
            path: '/school/student',
            name: 'student',
            component: resolve => void(require(['../components/School/Student.vue'], resolve)),
            meta: {title: '学员管理'},
        },
        {
            path: '/school/class',
            name: 'class',
            component: resolve => void(require(['../components/School/Class.vue'], resolve)),
            meta: {title: '班级信息管理'},
        },
        {
            path: '/school/allot',
            name: 'allot',
            component: resolve => void(require(['../components/School/Allot.vue'], resolve)),
            meta: {title: '学员分班管理'},
        },
        {
            path: '/school/classroom',
            name: 'classroom',
            component: resolve => void(require(['../components/School/Classroom.vue'], resolve)),
            meta: {title: '教室管理'},
        },
        {
            path: '/school/grade',
            name: 'grade',
            component: resolve => void(require(['../components/School/Grade.vue'], resolve)),
            meta: {title: '成绩单'},
        },
        {
            path: '/head/course',
            name: 'course',
            component: resolve => void(require(['../components/Head/Course.vue'], resolve)),
            meta: {title: '课程管理'}
        },
        {
            path: '/head/student',
            name: 'student',
            component: resolve => void(require(['../components/Head/Student.vue'], resolve)),
            meta: {title: '学生管理'}
        },
        {
            path: '/head/teacher',
            name: 'teacher',
            component: resolve => void(require(['../components/Head/Teacher.vue'], resolve)),
            meta: {title: '教师管理'}
        },
        {
            path: '/class/course_plan',
            name: 'course_plan',
            component: resolve => void(require(['../components/Class/Course_plan.vue'], resolve)),
            meta: {title: '课表'}
        },
        {
            path: '/class/student',
            name: 'student',
            component: resolve => void(require(['../components/Class/Student.vue'], resolve)),
            meta: {title: '学生管理'}
        },
        {
            path: '/class/grade',
            name: 'grade',
            component: resolve => void(require(['../components/Class/Grade.vue'], resolve)),
            meta: {title: '成绩单'}
        },
    ]
});
