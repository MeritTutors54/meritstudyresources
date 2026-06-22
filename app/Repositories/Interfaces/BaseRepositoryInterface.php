<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 15);

    public function find(int|string $id);

    public function create(array $data);

    public function update(array $data, int|string $id);

    public function delete(int|string $id);
}
