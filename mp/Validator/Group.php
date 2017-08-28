<?php

namespace Mp\Validator;
use Mp\Core\Validator\Validator;

class Group extends Validator {

    public function def() {
        return [
            'title' => [
                'notEmpty' => [
                    'rule' => ['notEmpty'],
                    'message' => __('2011', 'Title cannot be blank')
                ]
            ]
        ];
    }
}