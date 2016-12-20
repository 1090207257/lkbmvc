# lkbmvc
本人开发的一个PHP的MVC框架，借鉴了CI和Thinkphp框架，实现了基本的MVC，采用smarty模板技术。
框架整理
1.初始化：先定义一些常量，比如框架路径，可以用这些常量来判断有没有从单一入口进入，设置单一入口的原因是可以实现动静分离，还有自定义错误处理函数，自动加载，函数库等等
2.路由：使用全局变量数组$_SERVER下的PATH_INFO进行路径解析（用到字符串函数：explode，ucfirst，is_callable判断方法可不可调用），并且实现伪静态（最后可以加一个.html）和.htaccess（可以去掉index.php）
3.数据库单例连接类（用到一个静态方法和一个静态属性，静态方法里面判断静态属性有无赋值，没有就赋值并返回数据库连接，有就直接返回）和数据库操作的工厂类（里面包含一些数据库操作的方法，比如增删查改，执行sql语句和获取结果集等等）
4.控制器和模型的公共基类（用来初始化数据库工厂类的对象给属性db，可以供给调用数据库工厂类里面的方法）
5.控制器的基类（继承于控制器和模型的公共基类，加载模型方法，加载配置方法，初始化smarty配置方法，smarty的assign和display方法）
6.模型的基类（继承于控制器和模型的公共基类，主要进行一些数据库操作）
7.session的处理，自己编写了一个session函数，用于session的设置和查询，可以支持查询全部session
8.获取对应方法的url的方法get_url，用来获取对应方法的url，一般模板中使用，用来ajax到某个方法获取数据
9.redirect方法，用来做跳转，支持跳转到带http或https头的其他网址上去，也支持跳转本地方法，跳转本地方法的与get_url的参数一样
10.在Application/home/Controller/Index.php的index类中有具体的使用场景
