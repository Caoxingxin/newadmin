<template>
    <div class="container">
        <el-card class="box-card">
            <el-row :gutter="20">
                <!--搜索框-->
                <el-col :span="6" style="margin: 10px 10px 0 0">
                    <el-input placeholder="请输入内容" size="small" clearable>
                        <el-button slot="append" icon="el-icon-search"></el-button>
                    </el-input>
                </el-col>
                <!--添加-->
                <el-col :span="4" style="margin-top: 10px">
                    <el-button type="primary" size="small" @click="add" icon="el-icon-plus">添加</el-button>
                </el-col>
                <!--分页-->
                <el-pagination
                    :page-sizes="[100, 200, 300, 400]"
                    :page-size="100"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="400"
                    style="margin-right: 10px"
                >
                </el-pagination>
            </el-row>


            <el-table :data="tableData" style="width: 100%" border stripe>
                <el-table-column
                    type="index"
                    width="50">
                </el-table-column>
                <el-table-column prop="name" label="名称"></el-table-column>
                <el-table-column prop="phone" label="联系方式"></el-table-column>
                <el-table-column prop="email" label="邮箱"></el-table-column>
                <el-table-column prop="address" label="地址"></el-table-column>
                <el-table-column prop="status" label="状态">
                    <template slot-scope="scope">
                        <span :style="{color : activeColor}">{{ListenStatus(scope.row.status)}}</span>
                    </template>
                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <el-button type="primary" icon="el-icon-edit" size="mini">编辑</el-button>
                        <el-button type="danger" icon="el-icon-delete" size="mini">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>

        </el-card>
    </div>
</template>

<script>
    export default {
        name: "School",
        data() {
            return {
                activeColor:'',
                tableData: [{
                    name: '',
                    phone: '',
                    email: '',
                    address: '',
                    status: ''
                }]
            }
        },
        methods: {
            add() {

            },
            ListenStatus(value){
                console.log(value)
                console.log('-------');
                if (value == 10)
                {
                    this.activeColor = 'blue'
                    return '筹备中'
                }else if(value == 20){

                    this.activeColor = 'green'
                    return '运营中'
                }else if(value == -20){

                    this.activeColor = 'red'
                    return '暂停中'
                }
            }
        },
        mounted: function () {
            let url = "head/headSchool-list";
            this.axios.post(url).then(response => {
                this.tableData = response.data;
                console.log(this.tableData);
            });
        }
    }
</script>

<style scoped>
    .container {
        display: flex;
        height: 100%;
        max-width: 2250px;
    }

    .form-search {
        display: flex;
    }

    .search {
        width: 300px;
        margin-right: 10px;
    }
</style>
