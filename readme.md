#管理系统
###运行环境
> php >7.3
> 
> composer >1.8
> 
> Mysql >8.0
> 
> node >7.24.0
>
> 数据库配置见ENV
###运行
>**前端**
> 
> **npm -i** 后接 **npm run watch**
> 
> 运用echarts.js 图表
> 
>1.npm install echarts --save 或者 npm install echarts@4.9.0（推荐）
> 
> **后端**
> 
> 生产app_KEY  php artisan key:generate
> 
> 创建软连接，上传图片并且前端能访问
>php artisan storage:link
> 
> php -S 0.0.0.0:3600 -t public   启动php服务
