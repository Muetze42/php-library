<?php

namespace NormanHuth\Library\Livewire;

use Livewire\Component;

class AbstractComponent extends Component
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
