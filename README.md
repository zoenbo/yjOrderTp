# 昱杰订单管理系统（ThinkPHP版）

《昱杰订单管理系统（ThinkPHP版）》发布于2015年7月24日，因其简单、实用、开源等特点，受到广大用户青睐。但由于昱杰软件的其它产品的开发与维护需要更多的时间及精力，才不得不决定于2016年10月21日停止对《昱杰订单管理系统（ThinkPHP版）》的开发与维护。

据统计，目前仍有一大部分用户在使用本套系统，考虑到本系统使用人数众多、旧版系统长时间不维护得不到安全保障等原因，我们决定：在2020年伊始，对其进行再一次的更新。为了扶持中小商家，更新后的系统，依然免费、开源，甚至允许您进行免费商用、二次开发。

在此，需要和大家作几项说明，便于您更好的使用和了解本系统：

## 一、在线演示

https://www.yvjie.cn/product/demo.html

## 二、更新日志

1、本系统原采用ThinkPHP3.2.3框架开发，现全面升级至ThinkPHP6.0。系统核心代码全部更新，使其适应新版框架。升级后，代码更严谨，系统更安全、稳定；

2、优化及美化后台表单布局；

3、新增模块：权限组、登录记录、导出的数据、个人资料、行政区划；

4、下单时所在地区下拉，引用行政区划模块中的数据，由三联级改为四联级（省、市、区/县、乡镇/街道）；

5、增加手机版下单模板3套；

6、升级现有的支付宝电脑网站支付SDK，并集成支付宝手机网站支付（会自动判断所用设备，并跳转到相应的支付界面；当微信下单，选择支付宝支付时，将提示客户复制支付链接到浏览器进行支付）；

7、集成微信H5支付和JSAPI支付（目前实现：电脑端进行微信支付，显示支付二维码；微信端、移动端浏览器进行微信支付，可直接调起微信支付界面。但注意：此次升级后，需要手动在微信支付商户平台中的产品中心开通H5支付业务）；

8、系统设置中，可更新IP数据库，并显示当前版本号；

9、系统安装成功后，显示后台登录地址、密码重置密钥等信息，便于用户保存；

10、可通过密码重置密钥重置创始人密码；

11、管理员密码算法升级，更安全且不可逆；

12、其它功能完善。

## 三、系统源码获取及安装

我们提供了三个官方途径获取本系统的最新版源码。

1、GitHub：https://github.com/HeroTianTYJ/yjOrderTp （进入GitHub页面，点击右侧的“Clone or download”的绿色按钮，然后点击“Download ZIP”即可进行下载，国内用户下载速度可能会稍慢）；

2、码云：https://gitee.com/tyj568/yjOrderTp （进入码云页面，点击右侧的“克隆/下载”的橙色按钮，然后点击“下载ZIP”，输入验证码后即可进行下载，国内用户下载速度正常）；

3、百度网盘：https://pan.baidu.com/s/1ueBeIikr3eHFG2Jn8NCTeg ，提取码：mmdm（下载方法不用赘述，百度网盘相信大家都会使用）。

另外站长之家、A5下载等源码平台也收录了本系统的源码，但可能会收录不及时，因此我们不能保证源码平台中的源码为最新版。

本系统运行环境为：PHP7.1+、MySQL5.5+，PHP需开启curl、gd2、mbstring、openssl、pdo_mysql等扩展（如果不清楚如何开启PHP扩展，请自行查阅相关文档），另外本系统的所有目录及文件权限需设置为777。

为了统计系统使用量，安装时需要根据页面提示关注我们的微信公众号，回复相应的消息来获取您的openid，在安装表单中输入后即可完成安装，系统使用期间请不要取关公众号，否则将无法登录后台。

这是我们做的唯一限制，仅仅是为了统计系统使用量，为了这一限制的有效性，我们对系统源码中的两个文件做了加密处理，其它源码完全开源，基本上不会影响您进行二次开发。希望这一限制不会给您带来不便，并希望得到您的理解。

系统安装和使用的其它常见问题请见：https://mp.weixin.qq.com/s/ecNJ4ozJy_fX5lmYfZGA3g 。

## 四、增值业务

1、单页制作：您可通过《昱杰单页制作系统》制作出像《昱杰多功能订单管理系统》那样的图文并茂的产品单页，并可嵌入通过《昱杰订单管理系统（ThinkPHP版）》生成的下单界面，《昱杰单页制作系统》入口：https://www.yvjie.cn/web.php （注：通过《昱杰单页制作系统》生成的单页为纯静态页面，无法通过后台可视化修改，如需可通过后台可视化修改的产品单页，推荐您使用《昱杰多功能订单管理系统》）；

2、技术支持：本系统可以免费使用，通过您的自行研究，完全可以掌握本系统的操作方法。但如果仍有使用方面的问题，我们可以提供技术支持，环境搭建200元/每次，系统安装、使用等技术咨询费用为300元（不限制时间，不包含定制、开发指导）；

3、定制及开发指导：您和我们沟通好具体需求后，我们给出报价；

4、域名注册、虚拟主机申请、服务器开通及维护：详情请咨询客服。

## 五、赞助

1、如果您对我们的成果表示认同；

2、如果您觉得我们开发的系统对您有所帮助；

3、或我们开发的系统为您带来了收益。

我们愿意接受来自各方面的赞助，赞助金额不限，无论多少都是您的一份心意，在此表示由衷的感谢，您的帮助是对我们最大的支持和动力！（赞助入口请点击系统后台右上角的“赞助作者”）

您的赞助将用于：

1、鼓励及支持我们将已发布的系统继续运营下去；

2、研发及维护的成本；

3、后续开发更多、更实用的系统。

赞助，只是单纯的赞助，支持我们更好的运营，在这里简单说一下，赞助费用不能用于：

1、低于售后服务价格的赞助，不提供售后服务及问题解答；

2、低于定制价格的赞助，不提供定制服务。

最后，再次感谢您的赞助，谢谢！

## 六、免责声明

我们官方将通过GitHub渠道发布源码及后续更新，可能还会将源码发布到站长之家、A5下载等源码平台。由于源码开源性、易传播性，我们不可保证不会产生本系统的衍生版本，也不可保证其中的衍生版本是否存在后门程序，还请您自行甄别。如果您不具备甄别能力，建议您通过我们官方的GitHub渠道下载源码。