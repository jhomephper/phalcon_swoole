
{{ partial("partials/header") }}

<ul class="breadcrumb">
          <li>
            {{ link_to('?_url=/index/index/','权限管理') }} <span class="divider">/</span>
          </li>
          <li>
            {{ link_to('?_url=/index/index/','权限管理') }} <span class="divider">/</span>
          </li>
          <li class="active">用户管理</li>
</ul>

<!-- 简单搜索页 ================================================== -->
<div  class="row-fluid"  style="overflow:scroll;height:800px;">

      <div class="doc-content">
          <div class="row-fluid show-grid  span23">

        <form class="form-panel" method="post"  id="J_Form" action="?_url=/index/search">
          <div class="panel-title">
            <span>
              <label>创建日期：</label><input type="text" class="calendar" value="<?php  echo date('Y-m-d',strtotime('-7 days'));  ?>" /> <label>至</label> <input type="text" class="calendar"  value="<?php  echo date('Y-m-d',time());  ?>"/>
            </span>

          </div>
          <ul class="panel-content">

             <label class="control-label">搜索名称：</label>
             <input name="username" type="text" class="input-large">

             <label class="control-label">搜索邮箱：</label>
             <input name="email" type="text" class="input-large">

             <label class="control-label">搜索真名：</label>
             <input name="realname" type="text" class="input-large">

             <button type="submit" class="button button-info">查询>></button>

             {{ link_to('?_url=/index/index/','<button type="button" class="button button-success">新增</button>') }}
          </ul>
        </form>


        <table cellspacing="0" class="table table-bordered">
          <thead>

            <tr>
              <th width="15"></th>
              <th>用户编号</th>
              <th>名称</th>
              <th>邮箱</th>
              <th>真名</th>
              <th>创建时间</th>
              <th>操作</th>
            </tr>
          </thead>
           <tbody>

           {% if page.items is defined %}
                 {% for data in page.items %}
                    <tr>
                      <td><input type="checkbox"></td>
                      <td >{{ data.getId() }}</td>
                      <td>{{ data.getUsername() }}</td>
                      <td>{{ data.getEmail() }}</td>
                      <td>{{ data.getRealname() }}</td>
                      <td>{{ data.getCreatedAt() }}</td>
                      <td>
                         {{ link_to('index/index/','<span class="x-icon x-icon-error"><i class="icon icon-white icon-trash"></i></span>') }}
                         {{ link_to('index/index/','<span class="x-icon x-icon-warning"><i class="icon icon-white icon-edit"></i></span>') }}
                         {{ link_to('index/index/','<span class="x-icon x-icon-info"><i class="icon icon-white icon-fullscreen"></i></span>') }}
                      </td>
                    </tr>
                 {% endfor %}
           {% endif %}

          </tbody>
        </table>


        <div>
          <ul class="toolbar pull-left">
            <li><label class="checkbox"><input type="checkbox"><a href="#">全选</a></label></li>
            <li><button class="button button-danger"><i class="icon-white icon-trash"></i>批量删除</button></li>
          </ul>
          <div class="pagination pull-right">
            <ul class="pagination">
              <li>{{ link_to("?_url=/index/web&page=1", "第一页") }}</li>
              <li>{{ link_to("?_url=/index/web&page="~page.before, "上一页") }}</li>
              <li class="active">{{ link_to("?_url=/index/web&page="~page.current, "当前页") }}</li>
              <li>{{ link_to("?_url=/index/web&page="~page.next, "下一页") }}</li>
              <li>{{ link_to("?_url=/index/web&page="~page.last, "最后一页") }}</li>
            </ul>
          </div>
        </div>


      </div>
    </div>
<!-- script end -->
</div>


<!-- script start -->
    <script type="text/javascript">
        BUI.use('bui/calendar',function(Calendar){
          var datepicker = new Calendar.DatePicker({
            trigger:'.calendar',
            autoRender : true
          });
        });
    </script>
<!-- script end -->


<!-- script start -->
    <script type="text/javascript">
      BUI.use('bui/form',function(Form){
      new Form.Form({
        srcNode : '#J_Form'
      }).render();
  });
</script>
<!-- script end -->



{{ partial("partials/footer") }}
