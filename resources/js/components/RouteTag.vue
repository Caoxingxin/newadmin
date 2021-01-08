<template>
    <div class="tags" v-if="showTags">

        <ul>
            <li class="tags-li" v-for="(item,index) in tagsList" :class="{'active': isActive(item.path)}" :key="index">
                <router-link :to="item.path" class="tags-li-title">
                    {{item.title}}
                </router-link>
                <span class="tags-li-icon" @click="closeTags(index)" v-if="index"><i class="el-icon-close"></i></span>
            </li>
        </ul>
        <!-- 其他操作按钮 -->
        <div class="tags-close-box">
            <el-dropdown @command="handleTags">
                <el-button size="mini">
                    <i class="el-icon-arrow-down el-icon--right"></i>
                </el-button>
                <el-dropdown-menu size="small" slot="dropdown">
                    <el-dropdown-item command="other">关闭其他</el-dropdown-item>
                    <el-dropdown-item command="all">关闭所有</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
    </div>

</template>

<script>
    export default {
        name: "RouteTag",
        data() {
            return {
                tagsList: [],
                show:true,
            }
        },
        computed: {
            showTags() {
                 return this.tagsList.length > 0;
            }
        },
        watch: {
            // 对router进行监听，每当访问router时，对tags的进行修改
            $route(newValue) {
                this.setTags(newValue);
            }
        },
        created() {
            // 第一次进入页面时，修改tag的值
            this.tagsList.push({
                title: 'home',
                path: '/',
            })
        },
         methods: {
            isActive(path) {
                return path === this.$route.fullPath;
            },
            // 关闭单个标签
            closeTags(index) {
                const delItem = this.tagsList.splice(index, 1)[0];
                const item = this.tagsList[index] ? this.tagsList[index] : this.tagsList[index - 1];
                if (item) {
                    delItem.path === this.$route.fullPath && this.$router.push(item.path);

                } else {
                    this.$router.push('/');
                    this.show=false;
                }
            },
            // 关闭全部标签
            closeAll() {
                //过滤出首页标签，并跳转到首页去
                const curItem = this.tagsList.filter(item => {
                    return item.path === '/';
                })
                this.tagsList = curItem;
                this.$router.push('/');
            },
            // 关闭其他标签
            closeOther() {
                //过滤出首页和当前路由标签
                const curItem = this.tagsList.filter(item => {
                    console.log(item.path)
                    return (item.path === this.$route.fullPath || item.path === '/');
                })
                this.tagsList = curItem;

            },
            // 设置标签
            setTags(route) {
                //用some判断当前监听路由路径是否是tagsList其中一个
                //some如果回调函数中有任意一个满足条件，则返回true；否则为false。
                const isExist = this.tagsList.some(item => {
                    return item.path === route.fullPath;
                })
                //如果tagsList其中没有就添加进去
                if(!isExist && this.tagsList) {
                    this.tagsList.push({
                        title: route.meta.title,
                        path: route.fullPath,
                        name: route.matched[0].components.default.name
                    })
                }
                console.log('2222222222');
                console.log(this.tagsList);
                console.log('2222222222');
            },
            // 当关闭所有页面时隐藏
            handleTags(command) {
                command === 'other' ? this.closeOther() : this.closeAll();
            }
         }

    }
</script>

<style scoped>
    .tags {
        position: relative;
        height: 50px;
        overflow: hidden;
        background: white;
        padding-right: 120px;
    }

    .tags ul {
        box-sizing: border-box;
        width: 100%;
        height: 100%;
    }

    .tags-li {
        float: left;
        margin: 3px 5px 2px 3px;
        border-radius: 3px;
        font-size: 15px;
        overflow: hidden;
        cursor: pointer;
        height: 30px;
        line-height: 23px;
        border: 1px solid #e9eaec;
        background: #fff;
        padding: 0 5px 0 12px;
        vertical-align: middle;
        color: #666;
        -webkit-transition: all .3s ease-in;
        -moz-transition: all .3s ease-in;
        transition: all .3s ease-in;
    }

    .tags-li:not(.active):hover {
        background: #f8f8f8;
    }

    .tags-li-title {
        float: left;
        max-width: 80px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        margin-right: 5px;
        color: #666;
    }

    .tags-li.active {
        color: #fff;
        border: 1px solid #10B9D3;
        background-color: #67C23A;
    }

    .tags-li.active .tags-li-title {
        color: #fff;
    }

    .tags-close-box {
        position: fixed;
        right: 0;
        top: 50px;
        box-sizing: border-box;
        padding-top: 1px;
        text-align: center;
        z-index: 10;
    }

</style>
