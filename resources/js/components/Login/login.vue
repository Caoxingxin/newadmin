<template>
    <div class="container">
        <div class="login-container">
            <div class="title">
                <h1>Laravel-admin后台管理系统</h1>
            </div>
            <el-form ref="form" :model="form" label-width="80px">
                <el-form-item label="用户名">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="pass">
                    <el-input type="password" v-model="ruleForm.pass" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">Login</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "login",
        data() {
            return {
                form: {
                    name: '',
                },
                ruleForm: {
                    pass: '',
                },
                // rules: {
                //     pass: [
                //         { validator: validatePass, trigger: 'blur' }
                //     ],
                // }
            };
        },
        methods: {
            onSubmit() {
                console.log('submit!');
            }
        }
    }
</script>

<style scoped lang="less">
    .container {
        height: 100%;
        display: flex;
        align-content: center;
        align-items: center;

        .login-container {
            padding: 0 50px;
            width: 700px;
            margin: 0 auto;

            .title {
                margin-bottom: 40px;
                color: black;
                text-align: center;
                font-size: 26px;
            }

            .btns {
                margin-top: 20px;
            }
        }
        .login_form {
            bottom: 0;
            padding: 0 20px;
        }
    }
</style>
