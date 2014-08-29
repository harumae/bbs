{{ partial("partials/header") }}

<div id="wrap">
  <div id="contents" class="container panel panel-primary">
    <div id="header" class="row panel-heading">

      <div id="header-title" class="col-md-6">
        <h4><a href="{{ base_uri }}posts">{{ site_title }}</a></h4>
      </div><!-- header-title -->

      <div id="header-login" class="btn-group pull-right">
        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
          <span class="glyphicon glyphicon-cog"</span>
        </button>
        <ul class="dropdown-menu" role="menu">
          {% if logged_in is defined and logged_in is true %}
            <li><a href="{{ base_uri }}posts/csv">CSV ダウンロード</a></li>
            <li><a href="{{ base_uri }}users/logout">ログアウト</a></li>
          {% else %}
            <li class="disabled"><a href="{{ base_uri }}posts/csv">CSV ダウンロード</a></li>
            <li><a href="{{ base_uri }}users">ログイン</a></li>
          {% endif %}
        </ul>
      </div><!-- header-login -->

    </div><!-- header -->

    <div id="main" class="panel-body">

      {{ flashSession.output() }}

      {{ content() }}


    </div><!-- main -->

  </div><!-- contents -->
</div><!-- wrap -->


{{ partial("partials/footer") }}
