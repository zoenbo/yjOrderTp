{extend name="../../common/view/base/form" /}

{block name="title"}{if condition="request()->controller()=='Order'"}订单管理{else/}订单回收站{/if}{/block}
{block name="head"}{/block}

{block name="nav"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.index'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
{if condition="request()->controller()=='Order'"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.multi'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/multi')}">批量修改物流</a></li>{/if}
{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/detail',['id'=>input('get.id')])}">详情</a></li>
{/block}

{block name="form"}
<table class="detail">
  <tr><td class="n">订 单 号：</td><td>{$One['order_id']}</td></tr>
  <tr><td class="n">下单管理员：</td><td>{$One['manager']}</td></tr>
  <tr><td class="n">下单模板：</td><td>{$One['template']}</td></tr>
  <tr><td class="n">订购产品：</td><td>{$One['product']}</td></tr>
  <tr><td class="n">成交单价：</td><td>{$One['price']}元</td></tr>
  <tr><td class="n">订购数量：</td><td>{$One['count']}</td></tr>
  <tr><td class="n">成交总价：</td><td>{$One['total']}元</td></tr>
  <tr><td class="n">姓　　名：</td><td>{$One['name']}</td></tr>
  <tr><td class="n">联系电话：</td><td>{$One['tel']}</td></tr>
  <tr><td class="n">所在地区：</td><td>{$One['province']} {$One['city']} {$One['county']}</td></tr>
  <tr><td class="n">街道地址：</td><td>{$One['address']}</td></tr>
  <tr><td class="n">邮政编码：</td><td>{$One['post']}</td></tr>
  <tr><td class="n">备　　注：</td><td>{$One['note']}</td></tr>
  <tr><td class="n">电子邮箱：</td><td>{$One['email']}</td></tr>
  <tr><td class="n">支付方式：</td><td>{$One['pay']}</td></tr>
  <tr><td class="n">支付订单号：</td><td>{$One['pay_id']}</td></tr>
  <tr><td class="n">支付场景：</td><td>{$One['pay_scene']}</td></tr>
  <tr><td class="n">支付时间：</td><td>{if condition="$One['pay_date']"}{$One['pay_date']|dateFormat}{/if}</td></tr>
  <tr><td class="n">支付链接：</td><td>支付宝 <a href="{$One['payUrl']['alipay']}" target="_blank">{$One['payUrl']['alipay']}</a><br>微信支付 <a href="{$One['payUrl']['wxpay']}" target="_blank">{$One['payUrl']['wxpay']}</a></td></tr>
  <tr><td class="n">下单IP：</td><td>{$One['ip']}</td></tr>
  <tr><td class="n">QQ标识符：</td><td>{$One['qqau']}</td></tr>
  <tr><td class="n">下单来路：</td><td>{if condition="$One['referrer']"}<a href="{$One['referrer']}" target="_blank">{$One['referrer']}</a>{else/}直接进入{/if}</td></tr>
  <tr><td class="n">下单时间：</td><td>{$One['date']|dateFormat}</td></tr>
  <tr><td class="n">订单状态：</td><td>{$One['order_state']}</td></tr>
  <tr><td class="n">物流公司：</td><td>{$One['logistics_name']}</td></tr>
  <tr><td class="n">物流编号：</td><td>{$One['logistics_number']}{if condition="$One['logistics_name']&&$One['logistics_number']"}，<a href="http://www.kuaidi100.com/chaxun?com={$One['logistics_code']}&nu={$One['logistics_number']}" target="_blank">查询进度</a>{/if}</td></tr>
  <tr><td colspan="2" class="center"><a href="{:url('/'.parse_name(request()->controller()).'/update',array('id'=>input('get.id'),'from'=>1))}">修改</a></td></tr>
</table>
{/block}