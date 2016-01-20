<div class="header">
    
      <div class="dl-title">
        <a href="http://www.builive.com" title="文档库地址" target="_blank">
          <span class="lp-title-port">Phalcon</span><span class="dl-title-text"> Demo后台系统</span>
        </a>
      </div>

    <div class="dl-log">欢迎您，<span class="dl-log-user"><?php echo $username; ?></span><a href="?_url=/login/logout" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title">贴心小秘书<s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
        <li class="nav-item dl-selected"><div class="nav-item-inner nav-home">权限管理</div></li>

      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>

  <script>
    BUI.use('common/main',function(){
      var config = [

          {
          id:'menu', 
          homePage : 'rbac',
          menu:[{
              text:'用户管理',
              items:[
                {id:'rbac',text:'用户管理',href:'?_url=/index/web',closeable : false},
              ]
            },{
              text:'细节管理',
              items:[
                {id:'operation',text:'角色管理',href:'#'},
                {id:'quick',text:'节点管理',href:'#'},
                {id:'quick',text:'规则管理',href:'#'}
              ]
            }]
          },


          ];
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });





  </script>






