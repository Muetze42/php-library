<?php

namespace NormanHuth\Library\Commands\Application;

use Illuminate\Foundation\Console\DownCommand as Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'down')]
class DownCommand extends Command
{
    /**
     * Get the secret phrase that may be used to bypass maintenance mode.
     *
     * @return string|null
     */
    protected function getSecret(): ?string
    {
        if (! $this->option('secret') && $secret = config('app.maintenance.secret')) {
            $this->input->setOption('secret', $secret);
        }

        return parent::getSecret();
    }
}
