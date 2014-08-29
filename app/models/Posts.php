<?php

use Phalcon\Mvc\Model\Validator\InclusionIn as InclusionInValidator,
    Phalcon\Mvc\Model\Validator\PresenceOf as PresenceOf,
    Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;

class Posts extends BaseModel {
    public $id;
    public $registered_at;
    public $updated_at;
    public $title;
    public $name;
    public $email;
    public $comment;
    public $is_deleted;
    public $image_id;

    public function initialize() {
        $this->hasOne('image_id', 'Images', 'id');
    }

    public function beforeValidationOnCreate() {
        $now = date('Y-m-d H:i:s');
        $this->registered_at = $now;
        $this->updated_at = $now;
        $this->is_deleted = 0;
    }

    public function validation() {
        $this->validate(new PresenceOf(array(
            'field' => 'title',
            'message' => 'タイトルは入力必須です。',
        )));

        $this->validate(new PresenceOf(array(
            'field' => 'name',
            'message' => '名前は入力必須です。',
        )));

        $this->validate(new PresenceOf(array(
            'field' => 'comment',
            'message' => 'コメントは入力必須です。',
        )));

        $this->validate(new StringLengthValidator(array(
            'field' => 'title',
            'min'   => 1,
            'max'   => 30,
            'messageMaximum' => 'タイトルは30文字以内です。',
        )));

        $this->validate(new StringLengthValidator(array(
            'field' => 'name',
            'min'   => 1,
            'max'   => 20,
            'messageMaximum' => '名前は20文字以内です。',
        )));

        $this->validate(new StringLengthValidator(array(
            'field' => 'comment',
            'min'   => 1,
            'max'   => 250,
            'messageMaximum' => 'コメントは250文字以内です。',
        )));

        $this->validate(new InclusionInValidator(array(
            'field'     => 'is_deleted',
            'domain'    => array(0, 1),
        )));

        return !$this->validationHasFailed();
    }
}
