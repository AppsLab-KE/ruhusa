<?php

namespace AppsLab\Acl\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class SlugRule implements Rule
{
    protected $model;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (request()->method() == 'POST'){
            return ! (bool) $this->model->where('slug', '=', str_slug($value))->first();
        }

        if (request()->method() == 'PUT'){
            return ! (bool) $this->model->where('slug', '=', str_slug($value))->first();
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Already exist.';
    }
}
