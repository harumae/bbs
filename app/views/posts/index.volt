{{ partial(
  "partials/post_form",
  [
    "action": [base_uri, "posts/new"] | join,
    "btn_label": "投稿",
    "btn_class": "btn btn-primary"
  ]
) }}

<hr/>

<div id="list-area">

  {% for post in page.items %}

    {{ partial("partials/post") }}

    <hr/>

  {% endfor %}

</div><!-- list-area -->

{{ partial("partials/pager") }}
