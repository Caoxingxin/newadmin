(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/GithubCorner.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/GithubCorner.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "GithubCorner"
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Home.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Head/Home.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _GithubCorner__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../GithubCorner */ "./resources/js/components/GithubCorner.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

var servicedata_pie = [];
var servucedata_line = [];
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Home",
  components: {
    GithubCorner: _GithubCorner__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      Name: '',
      myChart_pie: '',
      myChart_line: ''
    };
  },
  methods: {
    //请求list接口
    list: function list() {
      var _this = this;

      var url = "head/headSchool-list";
      this.axios.get(url).then(function (response) {
        var Data = response.data.data;
        console.log(Data);

        for (var i = 0; i < Data.length; i++) {
          var obj = new Object();
          obj.name = Data[i].name;
          obj.value = Data[i].id;
          servicedata_pie[i] = obj;
          servucedata_line[i] = obj.name;
        }

        console.log(servicedata_pie);

        _this.piePhoto();

        _this.linePhoto();
      })["catch"](function (error) {
        console.log(error);
      });
    },
    piePhoto: function piePhoto() {
      this.myChart_pie.setOption({
        tooltip: {
          trigger: 'item',
          formatter: '{a} <br/>{b}: {c} ({d}%)'
        },
        legend: {
          orient: 'vertical',
          left: 10,
          data: servicedata_pie
        },
        series: [{
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
        }]
      });
    },
    linePhoto: function linePhoto() {
      console.log(servicedata_pie);
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
              formatter: function formatter(params) {
                return '降水量  ' + params.value;
              }
            }
          }
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
            label: {
              show: false
            }
          },
          areaStyle: {
            color: 'blue',
            opacity: 0.05
          },
          itemStyle: {
            color: "blue"
          },
          data: servicedata_pie,
          type: 'line'
        }]
      });
    }
  },
  computed: {
    postName: function postName() {
      this.Name = window.postName;
      return window.postName;
    }
  },
  mounted: function mounted() {
    // 基于准备好的dom，初始化echarts实例
    this.myChart_pie = this.$echarts.init(document.getElementById("main1"));
    this.myChart_line = this.$echarts.init(document.getElementById("main2"));
    this.list();
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.github-corner:hover .octo-arm[data-v-9c5d27fa] {\n    -webkit-animation: octocat-wave-data-v-9c5d27fa 560ms ease-in-out;\n            animation: octocat-wave-data-v-9c5d27fa 560ms ease-in-out\n}\n@-webkit-keyframes octocat-wave-data-v-9c5d27fa {\n0%,\n    100% {\n        transform: rotate(0)\n}\n20%,\n    60% {\n        transform: rotate(-25deg)\n}\n40%,\n    80% {\n        transform: rotate(10deg)\n}\n}\n@keyframes octocat-wave-data-v-9c5d27fa {\n0%,\n    100% {\n        transform: rotate(0)\n}\n20%,\n    60% {\n        transform: rotate(-25deg)\n}\n40%,\n    80% {\n        transform: rotate(10deg)\n}\n}\n@media (max-width:500px) {\n.github-corner:hover .octo-arm[data-v-9c5d27fa] {\n        -webkit-animation: none;\n                animation: none\n}\n.github-corner .octo-arm[data-v-9c5d27fa] {\n        -webkit-animation: octocat-wave-data-v-9c5d27fa 560ms ease-in-out;\n                animation: octocat-wave-data-v-9c5d27fa 560ms ease-in-out\n}\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Head/Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.title[data-v-12d3aaf3] {\n    font-size: 20px;\n    text-align: center;\n    margin-bottom: 20px;\n    align-content: center;\n    height: 50px;\n    width: 100%;\n    background-color: white;\n}\n.line-chart[data-v-12d3aaf3]{\n    width: auto;\n    height: 400px;\n    background-color: white;\n    margin-bottom: 30px;\n}\n.github-corner[data-v-12d3aaf3] {\n    position: absolute;\n    top: 0;\n    border: 0;\n    right: 0;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Head/Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/GithubCorner.vue?vue&type=template&id=9c5d27fa&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/GithubCorner.vue?vue&type=template&id=9c5d27fa&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "a",
    {
      staticClass: "github-corner",
      attrs: {
        href: "https://github.com/Caoxingxin/newadmin",
        target: "_blank",
        "aria-label": "View source on Github"
      }
    },
    [
      _c(
        "svg",
        {
          staticStyle: { fill: "#40c9c6", color: "#fff" },
          attrs: {
            width: "80",
            height: "80",
            viewBox: "0 0 250 250",
            "aria-hidden": "true"
          }
        },
        [
          _c("path", {
            attrs: { d: "M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z" }
          }),
          _vm._v(" "),
          _c("path", {
            staticClass: "octo-arm",
            staticStyle: { "transform-origin": "130px 106px" },
            attrs: {
              d:
                "M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2",
              fill: "currentColor"
            }
          }),
          _vm._v(" "),
          _c("path", {
            staticClass: "octo-body",
            attrs: {
              d:
                "M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z",
              fill: "currentColor"
            }
          })
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Home.vue?vue&type=template&id=12d3aaf3&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Head/Home.vue?vue&type=template&id=12d3aaf3&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("div", { staticClass: "title" }, [
        _vm._v("\n        你好,"),
        _vm.postName ? _c("span", [_vm._v(_vm._s(_vm.Name))]) : _vm._e(),
        _vm._v("欢迎使用Admin管理系统\n    ")
      ]),
      _vm._v(" "),
      _vm._m(0),
      _vm._v(" "),
      _vm._m(1),
      _vm._v(" "),
      _vm._m(2),
      _vm._v(" "),
      _c("github-corner", { staticClass: "github-corner" })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-xl-3 col-md-6 mb-4 big" }, [
        _c(
          "div",
          { staticClass: "card border-left-primary shadow h-100 py-2" },
          [
            _c("div", { staticClass: "card-body" }, [
              _c("div", { staticClass: "row no-gutters align-items-center" }, [
                _c("div", { staticClass: "col mr-2" }, [
                  _c(
                    "div",
                    {
                      staticClass:
                        "text-xs font-weight-bold text-primary text-uppercase mb-1"
                    },
                    [_vm._v("Earnings (Monthly)")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "h5 mb-0 font-weight-bold text-gray-800" },
                    [_vm._v("$40,000")]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-auto" }, [
                  _c("i", {
                    staticClass: "el-icon-date",
                    staticStyle: { "font-size": "50px", color: "darkturquoise" }
                  })
                ])
              ])
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-xl-3 col-md-6 mb-4" }, [
        _c(
          "div",
          { staticClass: "card border-left-success shadow h-100 py-2" },
          [
            _c("div", { staticClass: "card-body" }, [
              _c("div", { staticClass: "row no-gutters align-items-center" }, [
                _c("div", { staticClass: "col mr-2" }, [
                  _c(
                    "div",
                    {
                      staticClass:
                        "text-xs font-weight-bold text-success text-uppercase mb-1"
                    },
                    [_vm._v("Earnings (Annual)")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "h5 mb-0 font-weight-bold text-gray-800" },
                    [_vm._v("$215,000")]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-auto" }, [
                  _c("i", {
                    staticClass: "el-icon-paperclip",
                    staticStyle: { "font-size": "50px", color: "darkturquoise" }
                  })
                ])
              ])
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-xl-3 col-md-6 mb-4" }, [
        _c("div", { staticClass: "card border-left-info shadow h-100 py-2" }, [
          _c("div", { staticClass: "card-body" }, [
            _c("div", { staticClass: "row no-gutters align-items-center" }, [
              _c("div", { staticClass: "col mr-2" }, [
                _c(
                  "div",
                  {
                    staticClass:
                      "text-xs font-weight-bold text-info text-uppercase mb-1"
                  },
                  [_vm._v("Tasks")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "row no-gutters align-items-center" },
                  [
                    _c("div", { staticClass: "col-auto" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "h5 mb-0 mr-3 font-weight-bold text-gray-800"
                        },
                        [_vm._v("50%")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "col" }, [
                      _c("div", { staticClass: "progress progress-sm mr-2" }, [
                        _c("div", {
                          staticClass: "progress-bar bg-info",
                          staticStyle: { width: "50%" },
                          attrs: {
                            role: "progressbar",
                            "aria-valuenow": "50",
                            "aria-valuemin": "0",
                            "aria-valuemax": "100"
                          }
                        })
                      ])
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-auto" }, [
                _c("i", {
                  staticClass: "el-icon-document",
                  staticStyle: { "font-size": "50px", color: "darkturquoise" }
                })
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-xl-3 col-md-6 mb-4" }, [
        _c(
          "div",
          { staticClass: "card border-left-warning shadow h-100 py-2" },
          [
            _c("div", { staticClass: "card-body" }, [
              _c("div", { staticClass: "row no-gutters align-items-center" }, [
                _c("div", { staticClass: "col mr-2" }, [
                  _c(
                    "div",
                    {
                      staticClass:
                        "text-xs font-weight-bold text-uppercase mb-1",
                      staticStyle: { color: "#E6A23C" }
                    },
                    [_vm._v("Pending Requests")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "h5 mb-0 font-weight-bold text-gray-800" },
                    [_vm._v("18")]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-auto" }, [
                  _c("i", {
                    staticClass: "el-icon-chat-line-round",
                    staticStyle: { "font-size": "50px", color: "darkturquoise" }
                  })
                ])
              ])
            ])
          ]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "line-chart" }, [
      _c("div", {
        staticStyle: { width: "auto", height: "400px" },
        attrs: { id: "main2" }
      })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticStyle: { display: "flex", "flex-wrap": "nowrap" } },
      [
        _c("div", {
          staticStyle: { width: "600px", height: "400px", margin: "20px" },
          attrs: { id: "main1" }
        }),
        _vm._v(" "),
        _c("div", {
          staticStyle: {
            width: "600px",
            height: "400px",
            "background-color": "red",
            margin: "20px"
          }
        }),
        _vm._v(" "),
        _c("div", {
          staticStyle: {
            width: "600px",
            height: "400px",
            "background-color": "deepskyblue",
            margin: "20px"
          }
        })
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/GithubCorner.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/GithubCorner.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _GithubCorner_vue_vue_type_template_id_9c5d27fa_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./GithubCorner.vue?vue&type=template&id=9c5d27fa&scoped=true& */ "./resources/js/components/GithubCorner.vue?vue&type=template&id=9c5d27fa&scoped=true&");
/* harmony import */ var _GithubCorner_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./GithubCorner.vue?vue&type=script&lang=js& */ "./resources/js/components/GithubCorner.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _GithubCorner_vue_vue_type_style_index_0_id_9c5d27fa_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css& */ "./resources/js/components/GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _GithubCorner_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _GithubCorner_vue_vue_type_template_id_9c5d27fa_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _GithubCorner_vue_vue_type_template_id_9c5d27fa_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "9c5d27fa",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/GithubCorner.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/GithubCorner.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/GithubCorner.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./GithubCorner.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/GithubCorner.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css& ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_style_index_0_id_9c5d27fa_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/GithubCorner.vue?vue&type=style&index=0&id=9c5d27fa&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_style_index_0_id_9c5d27fa_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_style_index_0_id_9c5d27fa_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_style_index_0_id_9c5d27fa_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_style_index_0_id_9c5d27fa_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/GithubCorner.vue?vue&type=template&id=9c5d27fa&scoped=true&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/GithubCorner.vue?vue&type=template&id=9c5d27fa&scoped=true& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_template_id_9c5d27fa_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./GithubCorner.vue?vue&type=template&id=9c5d27fa&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/GithubCorner.vue?vue&type=template&id=9c5d27fa&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_template_id_9c5d27fa_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubCorner_vue_vue_type_template_id_9c5d27fa_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Head/Home.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/Head/Home.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Home_vue_vue_type_template_id_12d3aaf3_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Home.vue?vue&type=template&id=12d3aaf3&scoped=true& */ "./resources/js/components/Head/Home.vue?vue&type=template&id=12d3aaf3&scoped=true&");
/* harmony import */ var _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Home.vue?vue&type=script&lang=js& */ "./resources/js/components/Head/Home.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Home_vue_vue_type_style_index_0_id_12d3aaf3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css& */ "./resources/js/components/Head/Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Home_vue_vue_type_template_id_12d3aaf3_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Home_vue_vue_type_template_id_12d3aaf3_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "12d3aaf3",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Head/Home.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Head/Home.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/components/Head/Home.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Home.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Head/Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Head/Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css& ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_style_index_0_id_12d3aaf3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Home.vue?vue&type=style&index=0&id=12d3aaf3&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_style_index_0_id_12d3aaf3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_style_index_0_id_12d3aaf3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_style_index_0_id_12d3aaf3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_style_index_0_id_12d3aaf3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/Head/Home.vue?vue&type=template&id=12d3aaf3&scoped=true&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Head/Home.vue?vue&type=template&id=12d3aaf3&scoped=true& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_12d3aaf3_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=template&id=12d3aaf3&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Home.vue?vue&type=template&id=12d3aaf3&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_12d3aaf3_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_12d3aaf3_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);