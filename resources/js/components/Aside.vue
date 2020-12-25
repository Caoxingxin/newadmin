<template>
    <el-menu
        :default-active="this.$route.path"
        class="el-menu-vertical-demo"
        :router="true"
        text-color="black"
        active-text-color="bule">
        <el-menu-item index="/school">
            <span slot="title">
                <i class="el-icon-menu"></i><span style="font-size: 15px">学校管理</span>
            </span>
        </el-menu-item>
        <el-menu-item index="/course">
            <span slot="title">
                <i class="el-icon-menu"></i><span style="font-size: 15px">课程管理</span>
            </span>
        </el-menu-item>
        <el-menu-item index="/student">
            <span slot="title">
                <i class="el-icon-menu"></i><span style="font-size: 15px">学员管理</span>
            </span>
        </el-menu-item>
        <el-submenu index="1">
            <template slot="title">
                <i class="el-icon-shopping-cart-full"></i>
                <span style="font-size: 15px">商城管理</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/overviews"><i class="el-icon-goods"></i>商品管理</el-menu-item>
                <el-menu-item index="/tags"><i class="el-icon-s-order"></i>订单管理</el-menu-item>
                <el-menu-item index="/bags"><i class="el-icon-shopping-bag-1"></i>购物袋管理</el-menu-item>
                <el-menu-item index="/categories"><i class="el-icon-present"></i>优惠券管理</el-menu-item>
            </el-menu-item-group>
        </el-submenu>
    </el-menu>
</template>
<script>
    export default {
        name: 'Aside',
    }
</script>
<style scoped>
    .el-menu-item.is-active{
        color: dodgerblue !important;
    }
</style>
