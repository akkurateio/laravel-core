<?php

namespace Akkurate\LaravelCore\Repositories\Admin;

interface AccountsRepositoryInterface
{
    public function search(string $query = null);
}
