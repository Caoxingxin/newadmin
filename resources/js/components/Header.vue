<template>
    <el-menu index="0" class="el-menu-demo" mode="horizontal" background-color="RGB(7,71,166)" text-color="#fff"
             active-text-color="#ffd04b">
        <div class="menu_icon">
            <router-link to="/" active-class="_active">
                <i class="el-icon-data-analysis"></i>Laravel-admin后台管理系统
            </router-link>
        </div>
        <el-submenu index="1">
            <template slot="title">
                <div>
                    <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
                </div>
            </template>
            <el-menu-item >
                <i class="el-icon-user"></i><span v-if="postName">{{Name}}</span>
            </el-menu-item>
            <el-divider></el-divider>
            <el-menu-item @click="onQuit" >
                <i class="el-icon-switch-button"></i>退出
            </el-menu-item>
        </el-submenu>
    </el-menu>
</template>

<script>
    import RouteTag from "./RouteTag";
    export default {
        components: {RouteTag},
        data() {
            return {
                Name: 123
            };
        },
        methods: {
            onQuit() {
                this.$confirm('如果您准备退出当前用户，请选择下面的“登出”。', 'Ready to Leave?', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios({
                        method: 'post',
                        url: '/admin/logout',
                    }).then(response => {
                        location.reload();
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消退出'
                    });
                });
            },
        },
        computed: {
            postName() {
                this.Name = window.postName;
                return window.postName
            }
        }

    }

</script>

<style scoped>
    .el-menu--horizontal > .el-submenu {
        float: right;
    }

    .menu_icon {
        float: left;
        width: 500px;
        /*text-align: left;*/
        margin-left: 50px;
        font-size: 25px
    }
    .el-divider{
        margin: 5px 0;
        background: 0 0;
        border-top: 1px solid #e8eaec;
    }
    ._active{
        color: darkturquoise;
        text-decoration: none;
    }

</style>
