<?php

namespace Dawnstar\Core\Console\Commands;

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
            CREATE VIEW search_data AS
            SELECT
                c.id AS model_id,
                'Dawnstar\\\\Models\\\\Container' AS model_type,
                ct.language_id AS language_id,
                cu.id AS url_id,
                ct.name AS translation_name,
                ct.detail AS translation_detail,
                c.cvar_1,
                c.cvar_2,
                c.ctext_1,
                c.ctext_2,
                c.cint_1,
                c.cint_2,
                cte.key AS 'translation_key',
                cte.value AS 'translation_value',
                Null AS 'key',
                Null AS 'value'
            FROM structures AS s
            LEFT JOIN containers AS c ON s.id  = c.structure_id
            LEFT JOIN container_translations AS ct ON c.id = ct.container_id
            LEFT JOIN container_translation_extras AS cte ON ct.id = cte.container_translation_id
            LEFT JOIN urls AS cu ON ct.id = cu.model_id
            WHERE
                s.is_searchable = 1 AND
                cu.type = 1 AND
                cu.model_type = 'Dawnstar\\\\Models\\\\ContainerTranslation' AND
                c.deleted_at IS NULL
            UNION
            SELECT
                p.id AS model_id,
                'Dawnstar\\\\Models\\\\Page' AS model_type,
                pt.language_id AS language_id,
                pu.id AS url_id,
                pt.name AS translation_name,
                pt.detail AS translation_detail,
                p.cvar_1,
                p.cvar_2,
                p.ctext_1,
                p.ctext_2,
                p.cint_1,
                p.cint_2,
                pte.key AS 'translation_key',
                pte.value AS 'translation_value',
                pe.key AS 'key',
                pe.value AS 'value'
            FROM structures AS s
            LEFT JOIN pages AS p ON s.id  = p.structure_id
            LEFT JOIN page_translations AS pt ON  p.id = pt.page_id
            LEFT JOIN page_translation_extras AS pte ON pt.id = pte.page_translation_id
            LEFT JOIN page_extras AS pe ON p.id = pe.page_id
            LEFT JOIN urls AS pu ON pt.id = pu.model_id
            WHERE
                s.is_searchable = 1 AND
                p.status = '1' AND
                pu.type = 1 AND
                pu.model_type = 'Dawnstar\\\\Models\\\\PageTranslation' AND
                p.deleted_at IS NULL AND
                s.deleted_at IS NULL
            UNION
            SELECT
                c.id AS model_id,
                'Dawnstar\\\\Models\\\\Category' AS model_type,
                ct.language_id AS language_id,
                cu.id AS url_id,
                ct.name AS translation_name,
                ct.detail AS translation_detail,
                c.cvar_1,
                c.cvar_2,
                c.ctext_1,
                c.ctext_2,
                c.cint_1,
                c.cint_2,
                cte.key AS 'translation_key',
                cte.value AS 'translation_value',
                Null AS 'key',
                Null AS 'value'
            FROM structures AS s
            LEFT JOIN categories AS c ON s.id  = c.structure_id
            LEFT JOIN category_translations AS ct ON c.id = ct.category_id
            LEFT JOIN category_translation_extras AS cte ON ct.id = cte.category_translation_id
            LEFT JOIN urls AS cu ON ct.id = cu.model_id
            WHERE
                s.is_searchable = 1 AND
                c.status = '1' AND
                cu.type = '1' AND
                cu.model_type = 'Dawnstar\\\\Models\\\\CategoryTranslation' AND
                c.deleted_at IS NULL
    ");

        $this->info(PHP_EOL . "search_data table setted !! ". PHP_EOL);
    }
}
