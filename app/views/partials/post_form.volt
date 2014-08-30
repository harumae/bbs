<form
  action="{{ action }}"
  method="post"
  id="bbs-form"
  class="form-horizonal"
  role="form"
  enctype="multipart/form-data"
>

<input type="hidden" name="MAX_FILE_SIZE" value="2048000"/>

<div class="form-group row">
  <label for="title" id="title-label" class="col-md-4 control-label text-right"><span class="req">*</span>タイトル：</label>
  <p class="col-md-8">
    <input
     type="text"
     id="title"
     name="title"
     class="form-control"
     placeholder="タイトルは30文字以内"
     data-validetta="required,maxLength[30]"
     {% if item is defined %}value="{{ item.title }}"{% endif %}
     {% if is_disable is defined and is_disable == true %}
     disabled="disabled"
     {% endif %}
   />
  </p>
</div><!-- form-group -->

<div class="form-group row">
  <label for="name" id="name-label" class="col-md-4 control-label text-right"><span class="req">*</span>名前：</label>
  <p class="col-md-8">
    <input
     type="text"
     id="name"
     name="name"
     class="form-control"
     placeholder="名前は20文字以内"
     data-validetta="required,maxLength[20]"
     {% if item is defined %}value="{{ item.name }}"{% endif %}
     {% if cookie is defined %}value="{{ cookie['name'] }}"{% endif %}
     {% if is_disable is defined and is_disable == true %}
     disabled="disabled"
     {% endif %}
   />
  </p>
</div><!-- form-group -->

<div class="form-group row">
  <label for="email" id="email-label" class="col-md-4 control-label text-right">メールアドレス：</label>
  <p class="col-md-8">
    <input
     type="text"
     id="email"
     name="email"
     class="form-control"
     placeholder="メールアドレスは任意"
     data-validetta="maxLength[250]"
     {% if item is defined %}value="{{ item.email }}"{% endif %}
     {% if cookie is defined %}value="{{ cookie['email']|e }}"{% endif %}
     {% if is_disable is defined and is_disable == true %}
     disabled="disabled"
     {% endif %}
   />
  </p>
</div><!-- form-group -->

<div class="form-group row">
  <label for="comment" id="comment-label" class="col-md-4 control-label text-right"><span class="req">*</span>コメント：</label>
  <p class="col-md-8">
    <textarea
     rows="5"
     id="comment"
     name="comment"
     class="form-control"
     placeholder="コメントは250文字以内"
     data-validetta="required,maxLength[250]"
     {% if is_disable is defined and is_disable == true %}
     disabled="disabled"
     {% endif %}
    >{% if item is defined %}{{ item.comment }}{% endif %}</textarea>
  </p>
</div><!-- form-group -->

{% if item.image_id is empty %}

  {% if is_disable is not defined %}

  <div class="form-group row">
    <label id="file-label" class="col-md-4 control-label text-right">画像アップロード：</label>
    <div class="col-md-8">
      <input type="file" name="image-file" id="image-file"/>
      <div class="input-append">
        <input
          type="text"
          id="image"
          name="image"
          class="form-control"
          placeholder="アップロードする画像を選択"
        />
        <a id="upload-btn" class="btn btn-default">参照</a>
      </div>
    </div>
  </div><!-- form-group -->

  {% endif %}

{% else %}

<div class="row">
  <label id="file-label" class="col-md-4 control-label text-right">アップロード画像：</label>
  <div class="col-md-5">
    <a href="{{ url("images/raw") }}/{{ item.image_id }}" target="_blank">
      <img src="{{ url("images/thumb") }}/{{ item.image_id }}"/>
    </a>
    <br/><br/>
  </div>

  {% if is_disable is not defined %}

  <div class="col-md-3">
    <label class="checkbox"><input type="checkbox" id="delete" name="delete"/>この画像を削除する</label>
  </div>

  {% endif %}

</div>

{% endif %}

<div class="form-group row">
  <div class="col-md-4"></div>
  <div class="col-md-1">
    {% if is_disable is defined and is_disable == true %}
      <input type="button" class="{{ btn_class }}" value="{{ btn_label }}" data-toggle="modal" data-target="#myModal"/>
    {% else %}
      <input type="submit" id="submit" name="submit" class="{{ btn_class }}" value="{{ btn_label }}"/>
    {% endif %}
  </div>

  {% if with_cancel is defined and with_cancel is true %}
  <div class="col-md-1">
    <input type="button" id="cancel" name="cancel" class="btn btn-default" value="戻る"/>
  </div>
  {% endif %}

</div><!-- form-group -->

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel" class="modal-title">確認</h4>
      </div>
      <div class="modal-body">
        この投稿を削除してよろしいですか？
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">削除</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
      </div>
    </div>
  </div>
</div>

</form>
