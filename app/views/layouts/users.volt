<form
  action="{{ url("users/login") }}"
  method="post"
  id="login-form"
  class="form-inline text-center"
  role="form"
>

<div class="form-group">
  <label for="pass" id="pass-label" class="control-label text-right">パスワード：</label>
  <input
    type="password"
    name="pass"
    id="pass"
    class="form-control"
    placeholder="管理者パスワードは 'xyz'"
    data-validetta="required"
  />
</div><!-- form-group -->
<div class="form-group">
  <input
   type="submit"
   name="submit"
   id="submit"
   class="btn btn-success"
   value="ログイン"
  />
</div><!-- form-group -->

</form>
