<h3>高级搜索</h3>
  <form method="get" action="" class="layui-form">
    <label>关键词：按<select name="field" lay-search>{$Field}</select><input type="text" name="keyword" value="{:input('get.keyword')}" class="input-text"></label>
    <label>订购产品：<select name="product_id" lay-search><option value="0">不限</option>{$Product}</select></label>
    <label>成交单价：<input type="text" name="price1" value="{:input('get.price1')}" class="number">元 ～ <input type="text" name="price2" value="{:input('get.price2')}" class="number">元</label>
    <label>订购数量：<input type="text" name="count1" value="{:input('get.count1')}" class="number"> ～ <input type="text" name="count2" value="{:input('get.count2')}" class="number"></label>
    <label>成交总价：<input type="text" name="total1" value="{:input('get.total1')}" class="number">元 ～ <input type="text" name="total2" value="{:input('get.total2')}" class="number">元</label>
    <label>下单管理员：<select name="manager_id" lay-search><option value="-1">不限</option>{$Manager}</select></label>
    <label>下单时间：<input type="text" name="date1" value="{:input('get.date1')}" class="date"> ～ <input type="text" name="date2" value="{:input('get.date2')}" class="date"></label>
    <label>支付状态：<select name="pay" lay-search><option value="0">不限</option>{$Pay}</select></label>
    <label class="alipay_scene">支付场景：<select name="alipay_scene" lay-search><option value="0">不限</option>{$AlipayScene}</select></label>
    <label class="wxpay_scene">支付场景：<select name="wxpay_scene" lay-search><option value="0">不限</option>{$WxpayScene}</select></label>
    <label>订单状态：<select name="order_state_id" lay-search><option value="0">不限</option>{$OrderState}</select></label>
    <label>物流公司：<select name="logistics_id" lay-search><option value="0">不限</option>{$Logistics}</select></label>
    <label>下单模板：<select name="template_id" lay-search><option value="0">不限</option>{$Template}</select></label>
    <label><input type="submit" value="搜索" class="btn btn-primary radius"></label>
    <p style="clear:both;"></p>
  </form>