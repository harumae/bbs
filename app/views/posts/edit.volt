{{ partial(
  "partials/post_form",
  [
    "action": [base_uri, "posts/edit/", item.id] | join,
    "btn_label": "更新",
    "btn_class": "btn btn-primary",
    "with_cancel": true
  ]
) }}
