<?php namespace App\Repositories;

use App\Models\Service;

class ServiceRepository
{

    /**
     * Get all services, ordered by title
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Service::orderBy('title')->get();
    }

    /**
     * Get all services which associated at least with one master
     */
    public function hasMasters()
    {
        return Service::has('users')->get();
    }

}