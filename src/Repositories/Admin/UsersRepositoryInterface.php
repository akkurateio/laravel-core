<?php

namespace Akkurate\LaravelCore\Repositories\Admin;

interface UsersRepositoryInterface
{
	public function search(string $query = null);
}
