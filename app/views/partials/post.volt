<div class="post-item">
  <div class="row">

    <div class="col-md-3 text-right">
      <div class="timestamp"><strong>{{ post.registered_at }}</strong></div>
      <div class="post-name">
        {% if post.email is empty %}
          {{ post.name|e }}
        {% else %}
          <a href="mailto:{{ post.email }}">{{ post.name|e }}</a>
        {% endif %}
      </div><!-- post-name -->
    </div><!-- col-md-3 -->

    <div class="col-md-7">
      <div class="panel panel-info">
        <div class="post-title panel-heading">
          <strong>
            <a href="{{ base_uri }}items/{{ post.id }}">{{ post.title|e|url|nl2br }}</a>
          </strong>
        </div>

        <div class="post-desc panel-body">

          {% if post.image_id !== null %}
            <a href="{{ base_uri }}images/raw/{{ post.image_id }}" target="_blank">
              <img src="{{ base_uri }}images/thumb/{{ post.image_id }}"
                   width="{{ post.images.thumb_width }}"
                   height="{{ post.images.thumb_height }}"/>
            </a><br/><br/>
          {% endif %}

          {{ post.comment|e|url|email|nl2br }}

        </div>
      </div><!-- panel -->
    </div><!-- col-md-7 -->

    {% if logged_in is defined and logged_in is true %}

      <div class="col-md-1">
        <div class="post-action text-right">
          <a class="post-menu" href="{{ base_uri }}posts/edit/{{ post.id }}">
            <span class="glyphicon glyphicon-pencil"></span>
          </a>
          <a class="post-menu" href="{{ base_uri }}posts/delete/{{ post.id }}">
            <span class="glyphicon glyphicon-trash"></span>
          </a>
        </div><!-- post-action -->
      </div><!-- col-md-1 -->

    {% endif %}

  </div><!-- row -->
</div><!-- post-item -->
