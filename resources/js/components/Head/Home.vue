<template>
    <div>
        <div class="title">
            你好,<span v-if="postName">{{Name}}</span>欢迎使用Admin管理系统
        </div>
        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4 big">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings
                                    (Monthly)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="el-icon-date" style=" font-size: 50px;color: darkturquoise;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings
                                    (Annual)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="el-icon-paperclip" style=" font-size: 50px;color: darkturquoise;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                 aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="el-icon-document" style=" font-size: 50px;color: darkturquoise;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #E6A23C">Pending
                                    Requests
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                            </div>
                            <div class="col-auto">
                                <i class="el-icon-chat-line-round" style=" font-size: 50px;color: darkturquoise;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <github-corner class="github-corner"></github-corner>
        <div class="line-chart">
            <div id="main2" style="width: auto;height:400px;"></div>
        </div>
        <div style="display: flex;flex-wrap:nowrap ">
            <div id="main1" style="width: 600px;height:400px;margin: 20px"></div>
            <div id="main3" style="width: 600px;height:400px;margin: 20px"></div>
            <div id="main4" style="width: 600px;height:400px;margin: 20px"></div>
        </div>
        <div style="display: flex;flex-wrap:nowrap;">
            <div  style="width: 1000px;margin: 20px">
                <financial></financial>
            </div>
            <div style="width: 400px;margin: 20px;">
                <notice></notice>
            </div>
            <div style="width: 400px;height:400px;margin: 20px;background-color: cadetblue"></div>
        </div>
    </div>
</template>

<script>
    import GithubCorner from "../GithubCorner";
    import Financial from "./Home/Financial";
    import Notice from "./Home/Notice";

    var servicedata_pie = [];
    var servucedata_line = [];
    export default {
        name: "Home",
        components: {Notice, Financial, GithubCorner},
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
                            radius: ['50%', '70%'],
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
                                    return '降水量  ' + params.value;
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
                            label: {show: false},
                        },
                        areaStyle: {color: 'blue', opacity: 0.05},
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
                            mark: {show: true},
                            dataView: {show: true, readOnly: false},
                            magicType: {
                                show: true,
                                type: ['pie', 'funnel']
                            },
                            restore: {show: true},
                            saveAsImage: {show: true}
                        }
                    },
                    series: [
                        {
                            name: '面积模式',
                            type: 'pie',
                            radius: [30, 110],
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
            this.myChart_pie = this.$echarts.init(document.getElementById("main1"));
            this.myChart_line = this.$echarts.init(document.getElementById("main2"));
            this.myChart_bar = this.$echarts.init(document.getElementById("main3"));
            this.myChart_coolpie = this.$echarts.init(document.getElementById("main4"));
            this.list();
        }
    }
</script>

<style scoped>
    .title {
        font-size: 20px;
        text-align: center;
        margin-bottom: 20px;
        align-content: center;
        height: 50px;
        width: 100%;
        background-color: white;
    }

    .line-chart {
        width: auto;
        height: 400px;
        background-color: white;
        margin-bottom: 30px;
    }

    .github-corner {
        position: absolute;
        top: 0;
        border: 0;
        right: 0;
    }
</style>
