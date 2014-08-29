<?php

class Users extends BaseModel {
    public $id;
    public $registered_at;
    public $updated_at;
    public $name;
    public $password;
    public $is_active;

    public function validation() {
        $this->validate(new InclusionInValidator(array(
            'field'     => 'is_active',
            'domain'    => array(0, 1),
        )));

        return !$this->validationHasFailed();
    }
}
