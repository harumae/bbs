<div id="pager-area" class="text-center">
  <ul class="pager">
    {% if page.current <= page.before %}
      <li class="disabled"><a>
    {% else %}
      <li><a href="{{ url("posts") }}/{{ page.before }}">
    {% endif %}
    <span class="glyphicon glyphicon-chevron-left"></span>前へ
    </a></li>
    {% if page.current >= page.next %}
      <li class="disabled"><a>
    {% else %}
      <li><a href="{{ url("posts") }}/{{ page.next }}">
    {% endif %}
    次へ<span class="glyphicon glyphicon-chevron-right"></span>
    </a></li>
  </ul>
</div>
