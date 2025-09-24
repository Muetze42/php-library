<?php

namespace NormanHuth\Library\Livewire;

use Livewire\Form;

class AbstractForm extends Form
{
    use LivewireTrait;

    /**
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    protected function prepareForValidation($attributes): array
    {
        return $this->transformAttributesForValidation(parent::prepareForValidation($attributes));
    }
}
