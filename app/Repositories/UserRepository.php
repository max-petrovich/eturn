<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

class UserRepository implements RepositoryInterface
{

    /**
     * @param array $columns
     * @return Collection
     */
    public function all($columns = array('*'))
    {
        // TODO: Implement all() method.
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