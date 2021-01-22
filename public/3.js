(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Student.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Head/Student.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! element-ui */ "./node_modules/element-ui/lib/element-ui.common.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(element_ui__WEBPACK_IMPORTED_MODULE_0__);
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

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Student",
  data: function data() {
    return {
      index: 1,
      searchStudentMobile: '',
      currentPage: 1,
      //总条数
      total: 0,
      imageUrl: '',
      updateStatus: false,
      labelPosition: 'right',
      loading: false,
      dialogFormVisible: false,
      formLabelWidth: '120px',
      tableData: [{
        id: '',
        name: '',
        mobile: '',
        email: '',
        gender: '',
        status: '',
        degree: '',
        company: '',
        avatar: '',
        remark: '',
        introduction: ''
      }],
      create_form: {
        id: '',
        name: '',
        mobile: '',
        email: '',
        gender: '',
        status: '',
        degree: '',
        company: '',
        avatar: '',
        remark: '',
        introduction: ''
      },
      rules: {
        name: [{
          required: true,
          message: '请输入名称',
          trigger: 'blur'
        }, {
          min: 2,
          max: 200,
          message: '长度在 3 到 5 个字符',
          trigger: 'blur'
        }],
        mobile: [{
          required: true,
          pattern: /^1[34578]\d{9}$/,
          //可以写正则表达式呦呦呦
          message: '目前只支持中国大陆的手机号码',
          trigger: 'blur'
        }],
        email: [{
          type: 'email',
          message: '请输入正确的邮箱地址',
          trigger: ['blur', 'change']
        }]
      }
    };
  },
  methods: {
    //设置状态值
    ListenStatus: function ListenStatus(row) {
      if (row.status == 10) {
        return "潜在学员";
      } else if (row.status == 20) {
        return "正式学员";
      } else {
        return "已毕业学员";
      }
    },
    //设置刷新按钮
    refresh: function refresh() {
      var _this = this;

      this.loading = true;
      setTimeout(function () {
        _this.loading = false;
      }, 500); //加这个句话是为了避免$refs没有被渲染的情况

      if (this.$refs['form'] !== undefined) {
        this.clearFiles();
      }

      this.list(this.currentPage);
    },
    //请求list接口
    list: function list(currentPage) {
      var _this2 = this;

      var pageSize = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

      if (pageSize) {
        var url = "head/headStudent-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile + "&pageSize=" + pageSize;
      } else {
        var url = "head/headStudent-list?page=" + currentPage + "&searchStudentMobile=" + this.searchStudentMobile;
      }

      this.axios.get(url).then(function (response) {
        _this2.currentPage = response.data.current_page;
        _this2.tableData = response.data.data;
        _this2.total = response.data.total;

        _this2.cleanCreateFormData();

        console.log(_this2.tableData);
      })["catch"](function (error) {
        console.log(error);
      });
    },
    //请求学生更新接口
    submitForm: function submitForm(formName) {
      var _this3 = this;

      this.$refs[formName].validate(function (valid) {
        if (valid) {
          if (_this3.updateStatus) {
            var url = 'head/headStudent-update';

            _this3.axios.post(url, {
              id: _this3.create_form.id,
              name: _this3.create_form.name,
              mobile: _this3.create_form.mobile,
              email: _this3.create_form.email,
              gender: _this3.create_form.gender,
              status: _this3.create_form.status,
              degree: _this3.create_form.degree,
              company: _this3.create_form.company,
              avatar: _this3.create_form.avatar,
              remark: _this3.create_form.remark,
              introduction: _this3.create_form.introduction
            }).then(function (response) {
              _this3.$refs[formName].resetFields();

              _this3.dialogFormVisible = false;

              _this3.list(_this3.currentPage);

              Object(element_ui__WEBPACK_IMPORTED_MODULE_0__["Notification"])({
                title: '信息提示',
                message: '修改成功',
                type: "success",
                duration: 1000
              });
            })["catch"](function (error) {
              var mes = error.response.data['data'];

              if (mes['mobile']) {
                Object(element_ui__WEBPACK_IMPORTED_MODULE_0__["Notification"])({
                  title: '验证错误',
                  message: '手机号不能重复',
                  type: "error",
                  duration: 2000
                });
              } else {
                Object(element_ui__WEBPACK_IMPORTED_MODULE_0__["Notification"])({
                  title: '验证错误',
                  message: mes,
                  type: "error",
                  duration: 2000
                });
              }
            });

            console.log('----------------');
            console.log(_this3.updateStatus);
          }
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    resetForm: function resetForm(formName) {
      this.$refs[formName].resetFields();
      this.cleanCreateFormData();
      this.dialogFormVisible = false;
      this.refresh();
    },
    handleClose: function handleClose(done) {
      done();
      this.$refs['form'].resetFields();
      this.cleanCreateFormData();
      this.refresh();
    },
    //学生信息详情
    Deatil: function Deatil(id) {
      var _this4 = this;

      var url = 'head/headStudent-detail';
      this.axios.post(url, {
        id: id
      }).then(function (response) {
        _this4.dialogFormVisible = true;
        response.data.status = String(response.data.status);
        response.data.degree = String(response.data.degree);
        _this4.create_form = response.data;
        _this4.imageUrl = _this4.create_form.avatar;
        _this4.updateStatus = true;
      })["catch"](function (error) {
        alert('错误');
      });
    },
    //清空表单值
    cleanCreateFormData: function cleanCreateFormData() {
      this.create_form.name = '';
      this.create_form.mobile = '';
      this.create_form.email = '';
      this.create_form.gender = '';
      this.create_form.status = '';
      this.create_form.degree = '';
      this.create_form.company = '';
      this.create_form.avatar = '';
      this.create_form.remark = '';
      this.create_form.introduction = '';
    },
    //上传图片
    handleAvatarSuccess: function handleAvatarSuccess(response) {
      this.imageUrl = '/storage/image/' + response.filepath;
      this.create_form.avatar = this.imageUrl;
      console.log(this.imageUrl);
    },
    beforeAvatarUpload: function beforeAvatarUpload(file) {
      var isJPG = file.type === 'image/jpeg';
      var isLt2M = file.size / 1024 / 1024 < 2;

      if (!isJPG) {
        this.$message.error('上传头像只能是 JPG 格式!');
      }

      if (!isLt2M) {
        this.$message.error('上传头像图片大小不能超过 2MB!');
      }

      return isJPG && isLt2M;
    },
    clearFiles: function clearFiles() {
      this.$refs['myUpload'].clearFiles();
    },
    page: function page(value) {
      var _this5 = this;

      var url = 'head/headStudent-list?page=' + value;
      this.axios.get(url).then(function (response) {
        _this5.currentPage = response.data.current_page;
        _this5.tableData = response.data.data;
        console.log(_this5.tableData);
      })["catch"](function (error) {
        alert('错误');
      });
    },
    indexMethod: function indexMethod(index) {
      //单前页码，具体看组件取值
      var curpage = this.currentPage; //每页条数，具体是组件取值

      var limitpage = 13;
      return index + 1 + (curpage - 1) * limitpage;
    },
    changePageSize: function changePageSize(value) {
      this.list(this.currentPage, value);
    }
  },
  //默认直接请求list接口
  mounted: function mounted() {
    this.list(this.currentPage);
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Head/Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.student-wrap[data-v-c99b3a52] {\n    flex: 1;\n    display: flex;\n    overflow: auto;\n}\n.form-search[data-v-c99b3a52] {\n    display: flex;\n}\n.search[data-v-c99b3a52] {\n    width: 300px;\n    margin-right: 10px;\n}\n.el-form-item[data-v-c99b3a52] {\n    margin-bottom: 15px;\n    margin-left: 20px;\n}\na[data-v-c99b3a52] {\n    color: #3490dc !important;\n}\n.avatar-uploader .el-upload[data-v-c99b3a52] {\n    border: 1px dashed #d9d9d9;\n    border-radius: 6px;\n    cursor: pointer;\n    position: relative;\n    overflow: hidden;\n}\n.avatar-uploader .el-upload[data-v-c99b3a52]:hover {\n    border-color: #409eff;\n}\n.avatar-uploader-icon[data-v-c99b3a52] {\n    background-color: rgb(250, 250, 250);\n    font-size: 28px;\n    color: #8c939d;\n    width: 128px;\n    height: 128px;\n    line-height: 128px;\n    text-align: center;\n    border: 1px dashed #d9d9d9;\n}\n.avatar[data-v-c99b3a52] {\n    background-color: rgb(250, 250, 250);\n    border: 1px dashed #d9d9d9;\n    padding: 10px;\n    width: 128px;\n    height: 128px;\n    display: block;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Head/Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Student.vue?vue&type=template&id=c99b3a52&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Head/Student.vue?vue&type=template&id=c99b3a52&scoped=true& ***!
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
    "div",
    { staticClass: "student-wrap" },
    [
      _c(
        "el-card",
        [
          _c(
            "el-select",
            {
              on: {
                change: function($event) {
                  return _vm.changeSchoolId(_vm.schoolValue)
                }
              },
              model: {
                value: _vm.schoolValue,
                callback: function($$v) {
                  _vm.schoolValue = $$v
                },
                expression: "schoolValue"
              }
            },
            _vm._l(_vm.schoolData, function(item) {
              return _c("el-option", {
                key: item.id,
                attrs: { label: item.name, value: item.id }
              })
            }),
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "search-main" },
            [
              _c(
                "el-row",
                { staticClass: "elRow" },
                [
                  _c(
                    "el-col",
                    { attrs: { span: 7 } },
                    [
                      _c(
                        "el-input",
                        {
                          attrs: {
                            placeholder: "请输入电话",
                            size: "small",
                            clearable: ""
                          },
                          on: {
                            clear: function($event) {
                              return _vm.list(1)
                            }
                          },
                          model: {
                            value: _vm.searchStudentMobile,
                            callback: function($$v) {
                              _vm.searchStudentMobile = $$v
                            },
                            expression: "searchStudentMobile"
                          }
                        },
                        [
                          _c("el-button", {
                            attrs: { slot: "append", icon: "el-icon-search" },
                            on: {
                              click: function($event) {
                                return _vm.list(1)
                              }
                            },
                            slot: "append"
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "el-col",
                    { attrs: { span: 1 } },
                    [
                      _c(
                        "el-button",
                        {
                          attrs: { type: "primary", size: "small" },
                          on: { click: _vm.refresh }
                        },
                        [_c("i", { staticClass: "el-icon-refresh" })]
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c("el-pagination", {
                staticStyle: { "margin-right": "10px" },
                attrs: {
                  "page-sizes": [15, 30, 40, 50],
                  layout: "total, sizes, prev, pager, next, jumper",
                  total: this.total,
                  "current-page": _vm.currentPage
                },
                on: {
                  "current-change": _vm.list,
                  "size-change": _vm.changePageSize
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "table-main" },
            [
              _c(
                "el-table",
                {
                  directives: [
                    {
                      name: "loading",
                      rawName: "v-loading",
                      value: _vm.loading,
                      expression: "loading"
                    }
                  ],
                  staticStyle: { width: "100%" },
                  attrs: { data: _vm.tableData, border: "", stripe: "" }
                },
                [
                  _c("el-table-column", {
                    attrs: {
                      type: "index",
                      index: _vm.indexMethod,
                      width: "50"
                    }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "name", label: "姓名" },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(scope) {
                          return [
                            _c(
                              "a",
                              {
                                on: {
                                  click: function($event) {
                                    return _vm.Deatil(scope.row.id)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  _vm._s(scope.row.name) +
                                    "\n                        "
                                )
                              ]
                            )
                          ]
                        }
                      }
                    ])
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "mobile", label: "联系方式" }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "gender", label: "性别" },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(scope) {
                          return [
                            scope.row.gender === 1
                              ? _c("span", [_vm._v("男")])
                              : _c("span", [_vm._v("女")])
                          ]
                        }
                      }
                    ])
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: {
                      prop: "status",
                      label: "状态",
                      formatter: _vm.ListenStatus
                    }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "degree", label: "注册等级" },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(scope) {
                          return [
                            scope.row.degree === 10
                              ? _c("span", [_vm._v("普通")])
                              : _c("span", [_vm._v("高级")])
                          ]
                        }
                      }
                    ])
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "company", label: "工作单位" }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "remark", label: "备注" }
                  })
                ],
                1
              )
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          attrs: {
            title: "学生信息",
            visible: _vm.dialogFormVisible,
            width: "800px",
            top: "20px",
            "close-on-click-modal": false,
            "before-close": _vm.handleClose
          },
          on: {
            "update:visible": function($event) {
              _vm.dialogFormVisible = $event
            }
          }
        },
        [
          _c(
            "el-form",
            {
              ref: "form",
              attrs: {
                rules: _vm.rules,
                model: _vm.create_form,
                "label-position": _vm.labelPosition,
                "label-width": "100px"
              }
            },
            [
              _c(
                "el-form-item",
                { attrs: { label: "姓名:", prop: "name" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "200px !important" },
                    attrs: {
                      autocomplete: "off",
                      placeholder: "请输入姓名",
                      size: "small"
                    },
                    model: {
                      value: _vm.create_form.name,
                      callback: function($$v) {
                        _vm.$set(_vm.create_form, "name", $$v)
                      },
                      expression: "create_form.name"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "联系电话:", prop: "mobile" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "200px !important" },
                    attrs: {
                      autocomplete: "off",
                      placeholder: "请输入电话",
                      size: "small"
                    },
                    model: {
                      value: _vm.create_form.mobile,
                      callback: function($$v) {
                        _vm.$set(_vm.create_form, "mobile", $$v)
                      },
                      expression: "create_form.mobile"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "图片:", prop: "avatar" } },
                [
                  _c(
                    "el-upload",
                    {
                      ref: "myUpload",
                      staticClass: "avatar-uploader",
                      attrs: {
                        action: "http://localhost:3600/admin/upload",
                        "show-file-list": false,
                        "on-success": _vm.handleAvatarSuccess,
                        "before-upload": _vm.beforeAvatarUpload
                      }
                    },
                    [
                      _vm.imageUrl
                        ? _c("img", {
                            staticClass: "avatar",
                            attrs: { src: this.imageUrl }
                          })
                        : _c("i", {
                            staticClass: "el-icon-plus avatar-uploader-icon"
                          })
                    ]
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "邮箱地址:", prop: "email" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "200px !important" },
                    attrs: {
                      autocomplete: "off",
                      placeholder: "请输入邮箱",
                      size: "small"
                    },
                    model: {
                      value: _vm.create_form.email,
                      callback: function($$v) {
                        _vm.$set(_vm.create_form, "email", $$v)
                      },
                      expression: "create_form.email"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "性别:", prop: "gender" } },
                [
                  _c(
                    "el-radio-group",
                    {
                      model: {
                        value: _vm.create_form.gender,
                        callback: function($$v) {
                          _vm.$set(_vm.create_form, "gender", $$v)
                        },
                        expression: "create_form.gender"
                      }
                    },
                    [
                      _c("el-radio", { attrs: { label: 1 } }, [_vm._v("男")]),
                      _vm._v(" "),
                      _c("el-radio", { attrs: { label: 0 } }, [_vm._v("女")])
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "状态", prop: "status" } },
                [
                  _c(
                    "el-select",
                    {
                      attrs: { placeholder: "请选择" },
                      model: {
                        value: _vm.create_form.status,
                        callback: function($$v) {
                          _vm.$set(_vm.create_form, "status", $$v)
                        },
                        expression: "create_form.status"
                      }
                    },
                    [
                      _c("el-option", {
                        attrs: { label: "潜在", value: "10" }
                      }),
                      _vm._v(" "),
                      _c("el-option", {
                        attrs: { label: "学员", value: "20" }
                      }),
                      _vm._v(" "),
                      _c("el-option", { attrs: { label: "毕业", value: "30" } })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "注册等级", prop: "degree" } },
                [
                  _c(
                    "el-select",
                    {
                      attrs: { placeholder: "请选择" },
                      model: {
                        value: _vm.create_form.degree,
                        callback: function($$v) {
                          _vm.$set(_vm.create_form, "degree", $$v)
                        },
                        expression: "create_form.degree"
                      }
                    },
                    [
                      _c("el-option", {
                        attrs: { label: "普通", value: "10" }
                      }),
                      _vm._v(" "),
                      _c("el-option", { attrs: { label: "高级", value: "20" } })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "工作单位:", prop: "company" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "500px !important" },
                    attrs: {
                      autocomplete: "off",
                      placeholder: "请输入工作单位",
                      size: "small"
                    },
                    model: {
                      value: _vm.create_form.company,
                      callback: function($$v) {
                        _vm.$set(_vm.create_form, "company", $$v)
                      },
                      expression: "create_form.company"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "备注:", prop: "remark" } },
                [
                  _c("el-input", {
                    attrs: {
                      type: "textarea",
                      autocomplete: "off",
                      autosize: { minRows: 4, maxRows: 6 },
                      size: "small"
                    },
                    model: {
                      value: _vm.create_form.remark,
                      callback: function($$v) {
                        _vm.$set(_vm.create_form, "remark", $$v)
                      },
                      expression: "create_form.remark"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "描述:", prop: "introduction" } },
                [
                  _c("el-input", {
                    attrs: {
                      type: "textarea",
                      autocomplete: "off",
                      autosize: { minRows: 4, maxRows: 6 },
                      placeholder: "描述",
                      size: "small"
                    },
                    model: {
                      value: _vm.create_form.introduction,
                      callback: function($$v) {
                        _vm.$set(_vm.create_form, "introduction", $$v)
                      },
                      expression: "create_form.introduction"
                    }
                  })
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "dialog-footer",
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
              _c(
                "el-button",
                {
                  on: {
                    click: function($event) {
                      return _vm.resetForm("form")
                    }
                  }
                },
                [_vm._v("取 消")]
              ),
              _vm._v(" "),
              _c(
                "el-button",
                {
                  attrs: { type: "primary" },
                  on: {
                    click: function($event) {
                      return _vm.submitForm("form")
                    }
                  }
                },
                [_vm._v("保 存")]
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Head/Student.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/Head/Student.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Student_vue_vue_type_template_id_c99b3a52_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Student.vue?vue&type=template&id=c99b3a52&scoped=true& */ "./resources/js/components/Head/Student.vue?vue&type=template&id=c99b3a52&scoped=true&");
/* harmony import */ var _Student_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Student.vue?vue&type=script&lang=js& */ "./resources/js/components/Head/Student.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Student_vue_vue_type_style_index_0_id_c99b3a52_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css& */ "./resources/js/components/Head/Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Student_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Student_vue_vue_type_template_id_c99b3a52_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Student_vue_vue_type_template_id_c99b3a52_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "c99b3a52",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Head/Student.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Head/Student.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Head/Student.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Student.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Student.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Head/Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Head/Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css& ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_style_index_0_id_c99b3a52_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Student.vue?vue&type=style&index=0&id=c99b3a52&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_style_index_0_id_c99b3a52_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_style_index_0_id_c99b3a52_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_style_index_0_id_c99b3a52_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_style_index_0_id_c99b3a52_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/Head/Student.vue?vue&type=template&id=c99b3a52&scoped=true&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/Head/Student.vue?vue&type=template&id=c99b3a52&scoped=true& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_template_id_c99b3a52_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Student.vue?vue&type=template&id=c99b3a52&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Head/Student.vue?vue&type=template&id=c99b3a52&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_template_id_c99b3a52_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Student_vue_vue_type_template_id_c99b3a52_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);