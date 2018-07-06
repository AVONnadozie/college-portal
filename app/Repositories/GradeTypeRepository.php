<?php

namespace App\Repositories;

use App\User;
use App\Models\GradeType;
use App\Filters\GradeTypeFilters;
use Carbon\Carbon;

class GradeTypeRepository
{
    public function model()
    {
        return app(GradeType::class);
    }

    public function list(User $user, GradeTypeFilters $filters) {
        return $this->model()->filter($filters)->paginate()->transform(function ($item) use ($filters) {
            return $filters->transform($item);
        });
    }

    public function single($id, GradeTypeFilters $filters = null) {
        $q = $this->model();
        if ($filters) {
            $q = $q->filter($filters);
        }
        return $filters->transform($q->findOrFail($id));
    }

    public function delete($id) {
        return $this->model()->where('id', $id)->delete();
    }

    public function create($opts) {
        return $this->model()->create($opts);
    }

    public function update($id, $opts = []) {
        $this->model()->where('id', $id)->update($opts);
        return $this->single($id);
    }

    public function count(GradeTypeFilters $filters)
    {
        return $this->model()->filter($filters)->select('id', DB::raw('count(*) as total'))->count();
    }
}