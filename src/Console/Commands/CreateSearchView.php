<?php

namespace Dawnstar\Console\Commands;

use Illuminate\Console\Command;

class CreateSearchView extends Command
{

    protected $signature = 'ds:search';

    public function handle()
    {
        $view = \DB::select("SELECT TABLE_NAME FROM information_schema.VIEWS WHERE TABLE_NAME='search_data'");

        if(count($view) > 0) {
            \DB::statement("DROP VIEW IF EXISTS search_data");
            $this->info("search_data view dropped!");
        }

        \DB::statement("
            CREATE VIEW search_data AS SELECT
                c.id AS model_id,
                'Dawnstar\\\\Models\\\\Container' AS model_type,
                cd.language_id AS language_id,
                cu.id AS url_id,
                cd.name AS detail_name,
                cd.detail AS detail_detail,
                c.cvar_1,
                c.cvar_2,
                c.ctext_1,
                c.ctext_2,
                c.cint_1,
                c.cint_2,
                cde.key AS 'detail_key',
                cde.value AS 'detail_value',
                Null AS 'key',
                Null AS 'value'
            FROM
                containers AS c
            LEFT JOIN container_details AS cd
            ON
                c.id = cd.container_id
            LEFT JOIN container_detail_extras AS cde
            ON
                cd.id = cde.container_detail_id
            LEFT JOIN urls AS cu
            ON
                cd.id = cu.model_id
            WHERE
                cu.type = 'original' AND
                cu.model_type = 'Dawnstar\\\\Models\\\\ContainerDetail' AND
                c.is_searchable = 1 AND
                c.deleted_at IS NULL
            UNION
            SELECT
                p.id AS model_id,
                'Dawnstar\\\\Models\\\\Page' AS model_type,
                pd.language_id AS language_id,
                pu.id AS url_id,
                pd.name AS detail_name,
                pd.detail AS detail_detail,
                p.cvar_1,
                p.cvar_2,
                p.ctext_1,
                p.ctext_2,
                p.cint_1,
                p.cint_2,
                pde.key AS 'detail_key',
                pde.value AS 'detail_value',
                pe.key AS 'key',
                pe.value AS 'value'
            FROM
                pages AS p
            LEFT JOIN page_details AS pd
            ON
                p.id = pd.page_id
            LEFT JOIN page_detail_extras AS pde
            ON
                pd.id = pde.page_detail_id
            LEFT JOIN page_extras AS pe
            ON
                p.id = pe.page_id
            LEFT JOIN urls AS pu
            ON
                pd.id = pu.model_id
            LEFT JOIN containers AS pc
            ON
                pc.id = p.container_id
            WHERE
                p.status = '1' AND
                pu.type = 'original' AND
                pu.model_type = 'Dawnstar\\\\Models\\\\PageDetail' AND
                pc.is_searchable = 1 AND
                p.deleted_at IS NULL AND
                pc.deleted_at IS NULL
            UNION
            SELECT
                c.id AS model_id,
                'Dawnstar\\\\Models\\\\Category' AS model_type,
                cd.language_id AS language_id,
                cu.id AS url_id,
                cd.name AS detail_name,
                cd.detail AS detail_detail,
                c.cvar_1,
                c.cvar_2,
                c.ctext_1,
                c.ctext_2,
                c.cint_1,
                c.cint_2,
                cde.key AS 'detail_key',
                cde.value AS 'detail_value',
                Null AS 'key',
                Null AS 'value'
            FROM
                categories AS c
            LEFT JOIN category_details AS cd
            ON
                c.id = cd.category_id
            LEFT JOIN category_detail_extras AS cde
            ON
                cd.id = cde.category_detail_id
            LEFT JOIN urls AS cu
            ON
                cd.id = cu.model_id
            WHERE
                c.status = '1' AND
                cu.type = 'original' AND
                cu.model_type = 'Dawnstar\\\\Models\\\\CategoryDetail' AND
                c.deleted_at IS NULL
    ");

        $this->info(PHP_EOL . "search_data table setted !! ". PHP_EOL);
    }
}
