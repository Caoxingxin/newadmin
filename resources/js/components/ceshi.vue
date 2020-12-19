<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        请选择您的汽车品牌：
                    </div>
                    <el-select v-model="brand" placeholder="选择汽车品牌">
                        <el-option
                            v-for="brand in brands"
                            :key="brand.value"
                            :label="brand.label"
                            :value="brand.value"
                        ></el-option>
                    </el-select>
                </div>
            </div>
        </div>
        {{schoolData}}
    </div>
</template>

<script>
    export default {
        mounted: function() {
            let url = "/headSchool-list";
            this.axios.post(url).then(response => {
                this.schoolData = response;
                console.log("加载成功");
            });
        },
        data: function () {
            return {
                schoolData : '',
                brand: '',
                brands: [
                    {label: '宝马', value: 'option1'},
                    {label: '比亚迪', value: 'option2'},
                    {label: '丰田', value: 'option3'},
                    {label: '本田', value: 'option4'},
                    {label: '吉利', value: 'option5'},
                    {label: '马自达', value: 'option6'},
                    {label: '长城', value: 'option7'},
                ]
            }
        }
    }
</script>
