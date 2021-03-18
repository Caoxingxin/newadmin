<template>
    <div class="box-card">
        <p style="font-size: 18px;">优秀讲师</p>
        <div v-for="item in list" :key="item.id" class="text item">
            <div style="margin: 10px 10px 40px 10px;display: flex;flex-wrap:nowrap">
                <div style="margin-right: 10px">
                    <img width="200" height="200" :src=" item.picture" style="border-radius: 50%">
                </div>
                <div>
                    <p style="font-size: 16px">优秀教师：{{item.name}}</p>
                    <p style="font-size: 16px">简介：{{item.introduction}}</p>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "Notice",
    data() {
        return {
            list: [{
                id: '',
                name:'',
                picture: '',
                mobile: '',
                introduction: '',
            }]
        }
    },
    created() {
        this.teacher_list()
    },
    methods: {
        teacher_list(){
            var url = "index/get-teacher-list"
            this.axios.get(url).then(response => {
                this.list = response.data.slice(0, 2)
            }).catch(function (error) {
                console.log(error);
            });
        },
    }
}
</script>

<style scoped>
.box-card {
    background: #ffffff;
    flex: 1;
    border-radius: 5px;
    padding: 20px;
}
.text {
    font-size: 14px;
}
.item {
    margin-bottom: 18px;
}
.clearfix:before,
.clearfix:after {
    display: table;
    content: "";
}
.clearfix:after {
    clear: both;
}
</style>
