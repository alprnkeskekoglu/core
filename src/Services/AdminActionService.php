<?php

namespace Dawnstar\Services;

use Dawnstar\Models\Website;
use Dawnstar\Models\Admin;
use Dawnstar\Models\AdminAction as Model;

class AdminActionService
{
    private Website $website;
    private Admin $admin;
    private $model;

    public function __construct($model)
    {
        $this->website = Website::find(1); //TODO get from auth()
        $this->admin = Admin::find(1); //TODO get from auth()
        $this->model = $model;
    }

    public function create(string $type)
    {
        Model::create([
            'website_id' => $this->website->id,
            'admin_id' => $this->admin->id,
            'model_type' => $this->model::class,
            'model_id' => $this->model->id,
            'type' => $type
        ]);
    }
}
