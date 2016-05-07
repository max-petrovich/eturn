<?php namespace App\Repositories;

use App\Models\AdditionalService;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class AdditionalServiceRepository implements RepositoryInterface
{

    public function all($columns = array('*'))
    {
        return AdditionalService::orderBy('title')->get($columns);
    }


    /**
     * @param Service $service
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function forService(Service $service)
    {
        return $service->additionalServices()->orderBy('title')->get();
    }

    public function hasMastersForService(Service $service)
    {
        return $service->additionalServices()->has('users')->orderBy('title')->get();
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        // TODO: Implement paginate() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function find($id, $columns = array('*'))
    {
        // TODO: Implement find() method.
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        // TODO: Implement findBy() method.
    }
}