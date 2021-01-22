<template>
    <div id="app">
        <el-container class="app-container">
            <el-header>
                <AdminHeader></AdminHeader>
            </el-header>
            <el-container style="height: 80%">
                <el-aside width="200px">
                    <Aside></Aside>
                </el-aside>
                <el-main>
                    <RouteTag></RouteTag>
                    <!--添加动画效果-->
                    <div class="container-box">
                        <router-view/>
                    </div>
                </el-main>
            </el-container>
        </el-container>
    </div>

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

    .app-container {
        height: 100%;
    }

    .container-box {
        padding: 16px;
        position: relative;
        display: flex;
        flex: 1;
        overflow: auto;
    }

    /*全局样式表*/
    html,
    body,
    #app {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    ul,
    li {
        margin: 0;
        padding: 0;
    }

    a {
        cursor: pointer;
        text-decoration: none;
    }

    button {
        outline: none;
    }

    .search-main {
        display: flex;
        justify-content: space-between;
    }

    .elRow {
        margin-bottom: 20px;
        flex: 1;
        display: flex;
        align-items: center;
    }

    .form-search {
        display: flex;
    }

    .search {
        width: 300px;
        margin-right: 10px;
    }

    .table-main {
        display: flex;
        overflow: auto;
    }

    /*滚动条整体样式*/
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
        background: 0 0;
    }

    /*滚动条滑块*/
    ::-webkit-scrollbar-thumb {
        border-radius: 6px;
        background-color: #ccc;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.35);
    }

    /*重置element UI 样式*/

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

    .el-main {
        display: flex;
        flex-direction: column;
        background-color: rgb(240, 242, 246);
        color: #333;
        padding: 0;
    }

    .el-card {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 16px;
    }

    .el-card__body {
        flex: 1;
        width: 100%;
        display: flex;
        flex-direction: column;
        padding: 0;
        overflow: auto;
        overflow-x: hidden;
    }

    .el-table {
        font-size: 12px;
        display: flex;
        flex-direction: column;
        overflow: auto;
        overflow-x: hidden;
    }

    .el-table__body-wrapper {
        overflow: auto;
    }

    .el-table__footer-wrapper,
    .el-table__header-wrapper {
        overflow: initial;
    }

    .el-dropdown-menu {
        z-index: 9999999 !important;
    }

    .el-table__row > td,
    .has-gutter > tr > th {
        padding: 8px 0;
    }
    .el-form-item__error{
        color: #F56C6C;
        font-size: 12px;
        line-height: 1;
        position: relative;
        top: 80%;
        left: 0;
    }
</style>
