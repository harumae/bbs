<div id="pager-area" class="text-center">
  <ul class="pager">
    <li {% if page.current == page.before %}class="disabled"{% endif %}>
      <a href="{{ base_uri }}/posts/{{ page.before }}">
        <span class="glyphicon glyphicon-chevron-left"></span>前へ
      </a>
    </li>
    <li {% if page.current == page.next %}class="disabled"{% endif %}>
      <a href="{{ base_uri }}/posts/{{ page.next }}">
        次へ<span class="glyphicon glyphicon-chevron-right"></span>
      </a>
    </li>
  </ul>
</div>
