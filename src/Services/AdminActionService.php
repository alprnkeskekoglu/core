<?php

namespace Dawnstar\Core\Services;

use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Models\Admin;
use Dawnstar\Core\Models\AdminAction;

/**
 * Class AdminActionService
 * @package Dawnstar\Core\Services
 */
class AdminActionService
{
    /**
     * @var Website
     */
    private Website $website;
    /**
     * @var Admin
     */
    private Admin $admin;

    /**
     * AdminActionService constructor.
     * @param $model
     */
    public function __construct(protected $model)
    {
        $this->website = session('dawnstar.website', collect(['id' => 1]));
        $this->admin = auth('admin')->user();
    }

    /**
     * @param string $type
     */
    public function create(string $type)
    {
        AdminAction::create([
            'website_id' => $this->website->id,
            'admin_id' => $this->admin->id,
            'model_type' => $this->model::class,
            'model_id' => $this->model->id,
            'type' => $type
        ]);
    }
}
