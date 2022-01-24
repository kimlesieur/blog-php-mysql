<?php
namespace App\Validators;

use Valitron\Validator;

abstract class AbstractValidator {

    protected $data;
    protected $validator;

    public function __construct(array $data)
    {
        $this->data = $data;
        Validator::lang('fr');
        $v = new Validator($data);
        $this->validator = $v;
    }

    public function validate(): bool
    {
        return $this->validator->validate();
    }

    public function errors(): array
    {
        return $this->validator->errors();
    }


    
}

