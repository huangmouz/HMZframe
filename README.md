HMZframe
=======
框架学习过程

##第一天
composer的下载与配置，各级目录的分配，Boot类的测试。

##第二天
公共控制器Controller类，用于其他的类继承，自动加载模板类View，用来加载模板和自动分配变量到页面，数据库链接处理类Model，用来链接数据库并查询处理数据库中的数据

##第三天
c函数，配置config，完善model类

##第四天
继续完善model类，composer下载whoop错误提示

####composer配置
####目录结构
```
fream 框架主目录
|--app/
|  |--app/admin 后台的东西
|  |--app/home 前台的东西
|--hmz/
|--public/ 公共目录，主要用于存储公共资源，静态资源类
|--system/ 系统核心目录，主要存储配置项文件和框架运行必需的方法和设置
|--vendor/ composer插件目录，由composer配置项自动生成，不能修改，不需处理
|--composer.json composer的配置项
```
####核心类库`core`
```
初始化类Boot
|--hmz/core/Boot.php
|  |--
```
```
公共方法类Controller
|--hmz/core/Controller.php
|  |--message方法 用来传递需要提示的信息，用来对用户的操作进行提示成功或者失败
|  |--setRedirect方法 用来跳转的方法，操作成功或者失败后需要跳转时启用
```
####自动加载模板类`view`
```
|--hmz/view/View.php
|  |--View.php 不做具体的事情，只负责调用Base里的方法，主要作用是为了在调用方法的时候可以随意使用静态或实例化调用
|  |  |--__call方法，调用类里不存在方法时触发用来接收方法名和参数
|  |  |--__callStatic方法，调用类里不存在的静态方法时触发用来接收方法名和参数
|  |  |--runParse方法，用来接收上面两个方法接收的方法名然后new Base类，调用Base类里的对应方法
```
```
|--hmz/view/Base.php
|  |--Base.php 处理类，用来处理用户提交上来的请求，加载页面和分配变量
|  |  |--make方法，用来接收传进来的参数并存入file属性中，主要用于分配模板
|  |  |--with方法，用来接收传进来的参数并存入date属性中，主要用于分配变量
|  |  |--__toString方法，加载模板，分配变量，在echo一个对象的时候会触发，使用这个方法主要是为了能
|  |  |  够在调用的时候无需注意make和with的顺序，书写起来更方便，为了达成这个效果，需要echo输出对象
|  |  |  (tips：需要注意的是为了不报语法错误，__toString必须要返回一个东西，一般默认返回空字符串)
```
####数据库链接处理类
```
|--hmz/model/Model.php
|  |--Model.php 不做具体的事情，只负责调用Base里的方法，主要作用是为了在调用的时候可以随意使用静态和实例化方式
```