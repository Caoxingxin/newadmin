<template>
    <div class="home">
        <div class="list-item">
            <div class="item">
                <span>
                    <i class="el-icon-school" style="font-size: 50px;"></i>
                </span>
                <div class="content">
                    <span class="title">学校总数</span>
                    <span class="amount">{{SchoolData.length}}</span>
                </div>
            </div>

            <div class="item">
                <span>
                    <i class="el-icon-paperclip" style="font-size: 50px;"></i>
                </span>
                <div class="content">
                    <span class="title">今日订单金额</span>
                    <span class="amount">${{OrderIsDaySum}}</span>
                </div>
            </div>

            <div class="item">
                <span>
                    <i class="el-icon-edit-outline" style="font-size: 50px;"></i>
                </span>
                <div class="content">
                    <span class="title">总收入</span>
                    <span class="amount">${{OrderAllSum}}</span>
                </div>
            </div>

            <div class="item">
                <span>
                    <i class="el-icon-s-custom" style="font-size: 50px;"></i>
                </span>
                <div class="content">
                    <span class="title">在校人数</span>
                    <span class="amount">{{StudentData.length}}</span>
                </div>
            </div>
        </div>

        <github-corner class="github-corner"></github-corner>

        <div class="line-chart">
            <div id="main2"></div>
        </div>

        <div class="chart-list">
            <div id="main1"></div>
            <div id="main3"></div>
            <div id="main4"></div>
        </div>

        <div class="table-list">
            <financial></financial>
            <notice></notice>
        </div>
    </div>
</template>

<script>
    import GithubCorner from "../GithubCorner";
    import Financial from "./Home/Financial";
    import Notice from "./Home/Notice";
    import westeros from "../../Theme/westeros"

    var servicedata_pie = [];
    var servucedata_line = [];
    var order_data = [];
    var order_year_data = [0,0,0,0,0,0,0,0,0,0,0,0];
    var school_num_pie = [];
    export default {
        name: "Home",
        components: { Notice, Financial, GithubCorner },
        data() {
            return {
                SchoolNum: '',
                OrderData:0,
                OrderIsDaySum:0,
                OrderAllSum: 0,
                StudentData: '',
                SchoolData: '',
                Name: '',
                myChart_pie: '',
                myChart_line: '',
                myChart_bar: '',
                myChart_coolpie: '',
                ceshi: [
                    {
                        'name':'sss','value':0
                    },
                    {
                        'name':'城西','value':14
                    },
                    {
                        'name':'搜索','value':0
                    },
                    {
                        'name':'ss防辐射服s','value':0
                    },
                    {
                        'name':'负数','value':150
                    },
                ]
            }
        },
        methods: {
            //请求list接口
            list() {
                let url = "index/get-school-list";
                this.axios.get(url).then(response => {
                    var Data = response.data;
                    this.SchoolData = Data;
                    console.log(Data);
                    for (var i = 0; i < Data.length; i++) {
                        var obj = new Object();
                        obj.name = Data[i].name;
                        obj.value = Data[i].id;
                        servicedata_pie[i] = obj;
                        servucedata_line[i] = obj.name;
                    }
                    this.student_list();
                    this.order_list();
                    this.school_num();
                    this.barPhoto();
                    this.coolpiePhoto();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            student_list(){
                var url = "index/get-student-list"
                this.axios.get(url).then(response => {
                    this.StudentData = response.data
                }).catch(function (error) {
                    console.log(error);
                });
            },
            order_list(){
                var url = "index/get-order-list"
                this.axios.get(url).then(response => {
                    var Data = response.data;
                    var date = new Date();
                    var year = date.getFullYear();
                    var month = date.getMonth() + 1;
                    month = month<10 ? '0'+month: month;
                    var strDate = date.getDate();
                    var currentDate = year + '-' + month + '-' +strDate
                    for (var i=0;i<Data.length;i++){
                        var date1 = new Date(currentDate);
                        var date2 = new Date((Data[i].created_at).substr(0,10));
                        if (date1.getTime() == date2.getTime())
                        {
                            this.OrderIsDaySum += Number.parseInt(Data[i].actual_total)
                        }
                        if(year == date2.getFullYear()){
                            order_year_data[date2.getMonth()] += Number.parseInt(Data[i].actual_total);
                        }
                        this.OrderAllSum += Number.parseInt(Data[i].actual_total)
                    }
                    for (var j=0;j<12;j++){
                        order_data[j] = order_year_data[j];
                    }
                    this.linePhoto();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            school_num(){
                var url = "index/get-school-num"
                this.axios.get(url).then(response => {
                    this.SchoolNum = response.data
                    for (var i=0;i<this.SchoolNum.length;i++){
                        school_num_pie[i] =  servicedata_pie[i];
                        school_num_pie[i].value = this.SchoolNum[i].number;
                        school_num_pie[i].name = this.SchoolNum[i].name;
                    }
                    console.log(school_num_pie)
                    this.piePhoto();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            piePhoto() {
                this.myChart_pie.setOption({
                    title: {
                        text: '各学校人数统计',
                        left: 'center'
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: '{a} <br/>{b}: {c} ({d}%)',
                    },
                    legend: {
                        orient: 'vertical',
                        left: 10,
                        // data: servicedata_pie
                        data: school_num_pie
                    },
                    series: [
                        {
                            name: '人数统计',
                            type: 'pie',
                            radius: ['35%', '50%'],
                            avoidLabelOverlap: false,
                            label: {
                                show: false,
                                position: 'center'
                            },
                            emphasis: {
                                label: {
                                    show: true,
                                    fontSize: '30',
                                    fontWeight: 'bold'
                                }
                            },
                            labelLine: {
                                show: false
                            },
                            // data: servicedata_pie
                            data: school_num_pie
                        }
                    ]
                });
            },
            linePhoto() {
                this.myChart_line.setOption({
                    tooltip: {
                        trigger: 'axis'
                    },
                    title: {
                        left: 'left',
                        text: '今年收益变化趋势',
                    },
                    legend: {
                        data: ['预期收入', '实际收入']
                    },
                    xAxis: {
                        type: 'category',
                        // data: servucedata_line,
                        data: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
                        boundaryGap: false,
                        axisLine: {
                            lineStyle: {
                                color: '#5793f3'
                            }
                        },
                        axisPointer: {
                            label: {
                                formatter: function (params) {
                                    return params.value;
                                }
                            }
                        },
                    },
                    yAxis: {
                        type: 'value',
                        axisLine: {
                            show: false,
                            lineStyle: {
                                color: '#5793f3'
                            }
                        },
                        axisTick: {
                            show: false
                        },
                        axisPointer: {
                            show: true,
                            triggerTooltip: false
                        }
                    },
                    series: [{
                        name: '实际收入',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        lineStyle: {
                            color: 'blue',
                            width: 5,
                            opacity: 0.6
                        },
                        markLine: {
                            //symbol: ['none', 'none'],
                            label: { show: false },
                        },
                        areaStyle: { color: 'blue', opacity: 0.05 },
                        itemStyle: {
                            color: "blue",
                        },
                        data: order_data,
                        // data: [0,6700],
                        type: 'line'
                    },
                        {
                            name: '预期收入',
                            smooth: true,
                            symbol: 'circle',
                            symbolSize: 8,
                            lineStyle: {
                                color: 'green',
                                width: 5,
                                opacity: 0.6
                            },
                            markLine: {
                                label: { show: false },
                            },
                            areaStyle: { color: 'green', opacity: 0.05 },
                            itemStyle: {
                                color: "green",
                            },
                            data: [20000,30000,40000,20000,30000,60000,70000,30000,25000,40000,35000,20000],
                            type: 'line'
                        },
                    ]
                });
            },
            barPhoto() {
                this.myChart_bar.setOption({
                    color: ['#3398DB'],
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        }
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: servucedata_line,
                            axisTick: {
                                alignWithLabel: true
                            }
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value'
                        }
                    ],
                    series: [
                        {
                            name: '直接访问',
                            type: 'bar',
                            barWidth: '60%',
                            data: servicedata_pie
                        }
                    ]
                })
            },
            coolpiePhoto() {
                this.myChart_coolpie.setOption({
                    title: {
                        text: '学校分布情况',
                        subtext: '暂定',
                        left: 'center'
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: '{a} <br/>{b} : {c} ({d}%)'
                    },
                    legend: {
                        left: 'center',
                        top: 'bottom',
                        data: servicedata_pie
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            mark: { show: true },
                            dataView: { show: true, readOnly: false },
                            magicType: {
                                show: true,
                                type: ['pie', 'funnel']
                            },
                            restore: { show: true },
                            saveAsImage: { show: true }
                        }
                    },
                    series: [
                        {
                            name: '面积模式',
                            type: 'pie',
                            radius: [40, 110],
                            center: ['50%', '50%'],
                            roseType: 'area',
                            data: servicedata_pie
                        }
                    ]
                })
            },
        },
        computed: {
            postName() {
                this.Name = window.postName;
                return window.postName
            }
        },
        mounted() {
            // 基于准备好的dom，初始化echarts实例
            this.myChart_pie = echarts.init(document.getElementById("main1"),'westeros');
            this.myChart_line = echarts.init(document.getElementById("main2"),'westeros');
            this.myChart_bar = echarts.init(document.getElementById("main3"),'westeros');
            this.myChart_coolpie = echarts.init(document.getElementById("main4"),'westeros');
            this.list();
        }
    }
</script>

<style scoped>
    .home {
        flex: 1;
        overflow: auto;
    }
    .list-item {
        display: flex;
        margin-bottom: 32px;
    }

    .item {
        height: 108px;
        width: 24%;
        cursor: pointer;
        font-size: 12px;
        background: #ffffff;
        display: flex;
        justify-content: space-between;
        padding-right: 26px;
        border-radius: 5px;
        margin-right: 40px;
    }

    .el-icon-school {
        color: darkturquoise;
    }

    .el-icon-paperclip {
        color: #36a3f7;
    }

    .el-icon-edit-outline {
        color: #f4516c;
    }

    .el-icon-s-custom {
        color: #34bfa3;
    }

    .item > span {
        margin: 14px 0 0 14px;
        width: 80px;
        height: 80px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item:last-child {
        margin-right: 0;
    }

    .item:nth-of-type(1):hover > span {
        background: darkturquoise;
    }

    .item:nth-of-type(1):hover .el-icon-school,
    .item:nth-of-type(2):hover .el-icon-paperclip,
    .item:nth-of-type(3):hover .el-icon-edit-outline,
    .item:nth-of-type(4):hover .el-icon-s-custom {
        color: #ffffff;
    }

    .item:nth-of-type(2):hover > span {
        background: #36a3f7;
    }

    .item:nth-of-type(3):hover > span {
        background: #f4516c;
    }

    .item:nth-of-type(4):hover > span {
        background: #34bfa3;
    }

    .item > .content {
        font-weight: 700;
        margin-top: 26px;
        display: flex;
        flex-direction: column;
    }

    .item > .content > .title {
        line-height: 18px;
        color: rgba(0, 0, 0, 0.45);
        font-size: 16px;
        margin-bottom: 12px;
    }

    .item > .content > .amount {
        font-size: 20px;
    }

    .line-chart {
        display: flex;
        height: 400px;
        background-color: white;
        margin-bottom: 30px;
    }

    .line-chart #main2 {
        height: 400px;
        display: flex;
        flex: 1;
    }


    .chart-list {
        display: flex;
    }

    .chart-list > #main1,
    .chart-list > #main3,
    .chart-list > #main4 {
        display: flex;
        flex: 1;
        margin-right: 20px;
        height: 500px;
        background: #ffffff;
        padding: 20px;
    }

    .chart-list > #main4 {
        margin: 0;
    }

    .github-corner {
        position: absolute;
        top: 0;
        border: 0;
        right: 0;
        z-index: 9999;
    }

    .table-list {
        margin-top: 30px;
        display: flex;
    }
</style>
