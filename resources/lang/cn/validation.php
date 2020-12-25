<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => ' 必须接受。',
    'active_url'           => ' 不是一个有效的网址。',
    'after'                => ' 必须要晚于 :date。',
    'after_or_equal'       => ' 必须要等于 :date 或更晚。',
    'alpha'                => ' 只能由字母组成。',
    'alpha_dash'           => ' 只能由字母、数字和斜杠组成。',
    'alpha_num'            => ' 只能由字母和数字组成。',
    'array'                => ' 必须是一个数组。',
    'before'               => ' 必须要早于 :date。',
    'before_or_equal'      => ' 必须要等于 :date 或更早。',
    'between'              => [
        'numeric' => ' 必须介于 :min - :max 之间。',
        'file'    => ' 必须介于 :min - :max kb 之间。',
        'string'  => ' 必须介于 :min - :max 个字符之间。',
        'array'   => ' 必须只有 :min - :max 个单元。',
    ],
    'boolean'              => ' 必须为布尔值。',
    'confirmed'            => ' 两次输入不一致。',
    'date'                 => ' 不是一个有效的日期。',
    'date_format'          => ' 的格式必须为 :format。',
    'different'            => ' 和 :other 必须不同。',
    'digits'               => ' 必须是 :digits 位的数字。',
    'digits_between'       => ' 必须是介于 :min 和 :max 位的数字。',
    'dimensions'           => ' 图片尺寸不正确。',
    'distinct'             => ' 已经存在。',
    'email'                => ' 不是一个合法的邮箱。',
    'exists'               => ' 不存在。',
    'file'                 => ' 必须是文件。',
    'filled'               => ' 不能为空。',
    'image'                => ' 必须是图片。',
    'in'                   => '已选的属性  非法。',
    'in_array'             => ' 没有在 :other 中。',
    'integer'              => ' 必须是整数。',
    'ip'                   => ' 必须是有效的 IP 地址。',
    'ipv4'                 => ' 必须是有效的 IPv4 地址。',
    'ipv6'                 => ' 必须是有效的 IPv6 地址。',
    'json'                 => ' 必须是正确的 JSON 格式。',
    'max'                  => [
        'numeric' => ' 不能大于 :max。',
        'file'    => ' 不能大于 :max kb。',
        'string'  => ' 不能大于 :max 个字符。',
        'array'   => ' 最多只有 :max 个单元。',
    ],
    'mimes'                => ' 必须是一个 :values 类型的文件。',
    'mimetypes'            => ' 必须是一个 :values 类型的文件。',
    'min'                  => [
        'numeric' => ' 必须大于等于 :min。',
        'file'    => ' 大小不能小于 :min kb。',
        'string'  => ' 至少为 :min 个字符。',
        'array'   => ' 至少有 :min 个单元。',
    ],
    'not_in'               => '已选的属性  非法。',
    'numeric'              => ' 必须是一个数字。',
    'present'              => ' 必须存在。',
    'regex'                => ' 格式不正确。',
    'not_regex'            => ' 格式不正确。',
    'required'             => ' 不能为空。',
    'required_if'          => '当 :other 为 :value 时  不能为空。',
    'required_unless'      => '当 :other 不为 :value 时  不能为空。',
    'required_with'        => '当 :values 存在时  不能为空。',
    'required_with_all'    => '当 :values 存在时  不能为空。',
    'required_without'     => '当 :values 不存在时  不能为空。',
    'required_without_all' => '当 :values 都不存在时  不能为空。',
    'same'                 => ' 和 :other 必须相同。',
    'size'                 => [
        'numeric' => ' 大小必须为 :size。',
        'file'    => ' 大小必须为 :size kb。',
        'string'  => ' 必须是 :size 个字符。',
        'array'   => ' 必须为 :size 个单元。',
    ],
    'string'               => ' 必须是一个字符串。',
    'timezone'             => ' 必须是一个合法的时区值。',
    'unique'               => ' 已经存在。',
    'uploaded'             => ' 上传失败。',
    'url'                  => ' 格式不正确。',

    'mobile' => [
        'number' => '手机号必须是数字',
        'invalid' => '请输入正确的手机号',
    ],

    'id_card' => [
        'invalid' => '请输入正确的身份证',
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention 'attribute.rule' to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'card_grades.per_recharge'=>[
            'required_without_all'=>'至少填写一项'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of 'email'. This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [
        'name'                  => '名称',
        'username'              => '用户名',
        'email'                 => '邮箱',
        'first_name'            => '名',
        'last_name'             => '姓',
        'password'              => '密码',
        'password_confirmation' => '确认密码',
        'city'                  => '城市',
        'country'               => '国家',
        'address'               => '地址',
        'phone'                 => '电话',
        'mobile'                => '手机',
        'age'                   => '年龄',
        'sex'                   => '性别',
        'gender'                => '性别',
        'day'                   => '天',
        'month'                 => '月',
        'year'                  => '年',
        'hour'                  => '时',
        'minute'                => '分',
        'second'                => '秒',
        'title'                 => '标题',
        'content'               => '内容',
        'description'           => '描述',
        'excerpt'               => '摘要',
        'date'                  => '日期',
        'time'                  => '时间',
        'available'             => '可用的',
        'size'                  => '大小',
        'card_grades.give_points' => '赠送积分',
    ],

//    'distinct' =>"xxxx"

];
