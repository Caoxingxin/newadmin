<template>
    <div class="nav">
        <div class="title" @click="skipHome">
            <i class="el-icon-data-analysis"></i>
            Laravel-admin后台管理系统
        </div>

        <div class="userInfo">
            <el-dropdown>
                <div class="user">
                    <img src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png">
                </div>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item>
                        <i class="el-icon-user"></i>
                        <span v-if="postName">{{Name}}</span>
                    </el-dropdown-item>
                    <el-dropdown-item>
                        <i class="el-icon-user"></i>
                        <span v-if="postId">{{Id}}</span>
                    </el-dropdown-item>
                    <el-dropdown-item @click.native="onQuit">
                        <i class="el-icon-switch-button"></i>
                        退出登录
                    </el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
    </div>

</template>

<script>
    import RouteTag from "./RouteTag";
    export default {
        components: { RouteTag },
        data() {
            return {
                Name: '',
                Id : ''
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

            skipHome() {
                this.$router.push('/')
            }
        },
        computed: {
            postName() {
                this.Name = window.postName;
                return window.postName
            },
            postId(){
                this.Id = window.postId;
                return window.postId
            }
        }

    }

</script>

<style scoped>
    .nav {
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
        height: 60px;
        background-color: rgb(7, 71, 166);
    }

    .title {
        color: #fff;
        cursor: pointer;
        height: 60px;
        font-size: 20px;
        font-weight: 600;
    }

    .userInfo {
        height: 60px;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .user {
        height: 50px;
        width: 50px;

    }

    .user img {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        vertical-align: inherit;
    }


</style>
