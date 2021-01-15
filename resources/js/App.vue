<template>
    <el-container>
        <el-header>
            <AdminHeader></AdminHeader>
        </el-header>
        <el-container>
            <el-aside width="200px">
                <Aside></Aside>
            </el-aside>
            <el-container>
                <el-header>
                    <RouteTag></RouteTag>
                </el-header>
                <el-main class="animate_fix">        <!--添加动画效果-->
                    <transition name="fade">
                        <router-view/>
                    </transition>
                </el-main>
            </el-container>
        </el-container>
    </el-container>
</template>

<script>
    import Aside from './components/Aside.vue'
    import AdminHeader from './components/Header.vue'
    import Footer from "./components/Footer";
    import RouteTag from "./components/RouteTag";

    export default {
        name: 'App',
        components: {
            RouteTag,
            Footer,
            Aside,
            AdminHeader
        },
    }
</script>

<style>
    .el-header {
        text-align: center;
        line-height: 60px;
        padding: 0;
    }

    .el-aside {
        color: #333;
        background: white;
    }

    .el-menu {
        border: none;
    }
    /*主体内容部分*/
    .el-main {
        background-color: rgb(240,242,246);
        color: #333;
        padding: 0;
    }

    /*全局样式表*/
    html, body, #app {
        height: 100%;
        margin: 0;
        padding: 0;
        min-width: 1366px;
    }

    h1, h2, h3, h4, h5, h6, ul, li {
        margin: 0;
        padding: 0;
    }

    body > .el-container {
        height: 100%;
    }

    .el-container {
        height: 100%;
        background-color: rgb(240,242,246);
    }

    .el-aside {
        height: 100%;
    }

    .el-container:nth-child(5) .el-aside,
    .el-container:nth-child(6) .el-aside {
        line-height: 260px;
    }

    .el-container:nth-child(7) .el-aside {
        line-height: 320px;
    }

    .el-aside::-webkit-scrollbar {
        display: none;
    }

    .has-gutter th div.cell {
        /*text-align: center;*/
    }

    .animate_fix {
        position: relative;
        /*width: 100%;*/
    }

    .animate_fix > div {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        padding: 20px;
    }

    .el-card__body {
        padding: 5px;
    }

    .el-collapse-item:last-child {
        margin: 0;
    }

    .el-collapse-item__header {
        height: 38px;
        line-height: 38px;
    }

    .el-collapse-item__arrow {
        line-height: 38px;
        height: 38px;
    }

    .el-footer {
        margin: auto;
        text-align: center;
    }

    /*滚动条滑块*/
    ::-webkit-scrollbar-thumb {
        border-radius: 6px;
        background-color: #ccc;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.35);
    }


    .el-card {
        flex: 1;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15) !important;
    }

    .el-table {
        margin-top: 15px;
        font-size: 12px;
    }

    .el-pagination {
        margin-top: 15px;
        float: right;
    }

</style>
