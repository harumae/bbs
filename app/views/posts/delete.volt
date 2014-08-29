{{ partial(
  "partials/post_form",
  [
    "action": [base_uri, "posts/delete/", item.id] | join,
    "btn_label": "削除",
    "btn_class": "btn btn-danger",
    "with_cancel": true,
    "is_disable": true
  ]
) }}
