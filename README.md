# 项目描述
仿商城做的一个系统，电商或电商类型的服务在目前来看依旧是非常常用，虽然纯电商的创业已经不太容易，但是各个公司都有变现的需要，所以在自身应用中嵌入电商功能是非常普遍的做法。
          为了让大家掌握企业开发特点，以及解决问题的能力，我们开发一个电商项目，项目会涉及非常有代表性的功能。
          为了让大家掌握公司协同开发要点，我们使用git管理代码。
          在项目中会使用很多前面的知识，比如架构、维护等等。
          
#主要功能模块

系统包括：
后台：品牌管理、商品分类管理、商品管理、订单管理、系统管理和会员管理六个功能模块。
前台：首页、商品展示、商品购买、订单管理、在线支付等。

# 系统功能模块
品牌管理：
商品分类管理：
商品管理：
账号管理：
权限管理：
菜单管理：
订单管理：

# 流程
自动登录流程
购物车流程
订单流程

# 设计要点(数据库和页面交互)

系统前后台设计：前台www.yiishop.com 后台admin.yiishop.com 对url地址美化
商品无限级分类设计：
购物车设计

# 品牌功能模块
品牌管理功能涉及品牌的列表展示、品牌添加、修改、删除功能。
品牌需要保存缩略图和简介。
品牌删除使用逻辑删除。

# 要点难点及解决方案
1.删除使用逻辑删除,只改变status属性,不删除记录
2.使用uploadify插件,提升用户体验
3.使用composer下载和安装uploadify
4.composer安装插件报错,解决办法:
composer global require "fxp/composer-asset-plugin:^1.2.0"
5.注册七牛云账号

2017.11.03

实现品牌列表功能模块

# 文章分类管理需求

创建分类article_category表，字段，分类名称、简介、状态、排序、是否是帮助相关的分类

创建管理article表，字段、文章名称、文章分类id、简介、状态(1=是&0=否)、排序、录入时间

创建内容article_detail表，字段，文章管理id、文章内容

# 遇到的错误
七牛云 $_FILE['file']['tmp_name']

# 难点
文章内容表和文章管理表的关联

2017.11.04

# 商品分类需求
### 流程

创建商品分类表

商品分类的增删改查

利用yii2 tree_grid创建树形

难点：

树形编辑的回显

