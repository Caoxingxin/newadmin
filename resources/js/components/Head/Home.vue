<template>
    <div class="home">
        <div class="list-item">
            <div class="item">
                <span>
                    <i class="el-icon-date" style="font-size: 50px;"></i>
                </span>
                <div class="content">
                    <span class="title">New Visits</span>
                    <span class="amount">102,400</span>
                </div>
            </div>

            <div class="item">
                <span>
                    <i class="el-icon-paperclip" style="font-size: 50px;"></i>
                </span>
                <div class="content">
                    <span class="title">New Visits</span>
                    <span class="amount">102,400</span>
                </div>
            </div>

            <div class="item">
                <span>
                    <i class="el-icon-document" style="font-size: 50px;"></i>
                </span>
                <div class="content">
                    <span class="title">New Visits</span>
                    <span class="amount">102,400</span>
                </div>
            </div>

            <div class="item">
                <span>
                    <i class="el-icon-chat-line-round" style="font-size: 50px;"></i>
                </span>
                <div class="content">
                    <span class="title">New Visits</span>
                    <span class="amount">102,400</span>
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
    export default {
        name: "Home",
        components: { Notice, Financial, GithubCorner },
        data() {
            return {
                Name: '',
                myChart_pie: '',
                myChart_line: '',
                myChart_bar: '',
                myChart_coolpie: '',
            }
        },
        methods: {
            //请求list接口
            list() {
                let url = "head/headSchool-list";
                this.axios.get(url).then(response => {
                    var Data = response.data.data;
                    console.log(Data);
                    for (var i = 0; i < Data.length; i++) {
                        var obj = new Object();
                        obj.name = Data[i].name;
                        obj.value = Data[i].id;
                        servicedata_pie[i] = obj;
                        servucedata_line[i] = obj.name;
                    }
                    console.log(servicedata_pie)
                    this.piePhoto();
                    this.linePhoto();
                    this.barPhoto();
                    this.coolpiePhoto();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            piePhoto() {
                this.myChart_pie.setOption({
                    tooltip: {
                        trigger: 'item',
                        formatter: '{a} <br/>{b}: {c} ({d}%)',
                    },
                    legend: {
                        orient: 'vertical',
                        left: 10,
                        data: servicedata_pie
                    },
                    series: [
                        {
                            name: '访问来源',
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
                            data: servicedata_pie
                        }
                    ]
                });
            },
            linePhoto() {
                console.log(servicedata_pie)
                this.myChart_line.setOption({
                    tooltip: {
                        trigger: 'axis'
                    },
                    xAxis: {
                        type: 'category',
                        data: servucedata_line,
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
                        data: servicedata_pie,
                        type: 'line'
                    }]
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
                        text: '南丁格尔玫瑰图',
                        subtext: '纯属虚构',
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

    .el-icon-date {
        color: darkturquoise;
    }

    .el-icon-paperclip {
        color: #36a3f7;
    }

    .el-icon-document {
        color: #f4516c;
    }

    .el-icon-chat-line-round {
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

    .item:nth-of-type(1):hover .el-icon-date,
    .item:nth-of-type(2):hover .el-icon-paperclip,
    .item:nth-of-type(3):hover .el-icon-document,
    .item:nth-of-type(4):hover .el-icon-chat-line-round {
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
