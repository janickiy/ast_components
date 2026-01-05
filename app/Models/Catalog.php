<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Catalog extends Model
{
    protected $table = 'catalogs';

    protected $fillable = [
        'name',
        'parent_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'seo_h1',
        'seo_url_canonical',
        'seo_sitemap',
        'parent_id',
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'catalog_id', 'id')->where('published', 1);
    }

    /**
     * @return mixed
     */
    public static function getOption()
    {
        return self::orderBy('name')->get()->pluck('name', 'id');
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return self::where('parent_id', $this->id)->count() > 0 ? true : false;
    }

    /**
     * @param array $topbar
     * @param int $parent_id
     * @return array
     */
    public static function topbarMenu(array &$topbar, int $parent_id): array
    {
        $result = self::where('id', $parent_id);

        if ($result->count() > 0) {
            $catalog = $result->first();
            $topbar[] = [$catalog->id, $catalog->name, $catalog->slug];

            self::topbarMenu($topbar, $catalog->parent_id);
        }

        sort($topbar);

        return $topbar;
    }

    /**
     * @return int
     */
    public function getProductCount(): int
    {
        return (int)Products::where('catalog_id', $this->id)->where('published', 1)->count();
    }

    /**
     * @param int $parent_id
     * @return void
     */
    public static function removeCatalogs(int $parent_id): void
    {
        $parent = self::findOrFail($parent_id);
        $array_of_ids = self::getChildren($parent);
        array_push($array_of_ids, $parent_id);

        $catalogs = self::whereIn('id', $array_of_ids)->get();

        foreach ($catalogs as $catalog) {
            self::removeCatalog($catalog);
        }

        self::removeCatalog($parent);
    }

    /**
     * @return int
     */
    public function getTotalProductCount(): int
    {
        $allChildren = [$this->id];

        self::getAllChildren(self::query()->orderBy('name')->get(), $allChildren, $this->id);

        return Products::query()->whereIn('catalog_id', $allChildren)->count();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        foreach ($this->products as $product) {
            $product->remove();
        }

        $this->delete();
    }

    /**
     * @param $category
     * @return array
     */
    private static function getChildren($category): array
    {
        $ids = [];

        foreach ($category->children ?? [] as $row) {
            $ids[] = $row->id;
            $ids = array_merge($ids, self::getChildren($row));
        }

        return $ids;
    }


    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    /**
     * @param array $option
     * @param int $parent_id
     * @param int $lvl
     * @return array
     */
    public static function showTree(array &$option, int $parent_id, int &$lvl = 0)
    {
        $lvl++;
        $rows = self::where('parent_id', $parent_id)->orderBy('name')->get();

        foreach ($rows as $row) {
            $indent = '';
            for ($i = 1; $i < $lvl; $i++) $indent .= '-';

            $option[$row->id] = $indent . " " . $row->name;
            self::showTree($option, $row->id, $lvl);
            $lvl--;
        }

        return $option;
    }

    /**
     * @param array $catalogs
     * @param int $parent_id
     * @param bool $only_parent
     * @return string
     */
    public static function buildTree(array $catalogs, int $parent_id, bool $only_parent = false): string
    {
        $cl = '';

        if (isset($catalogs[$parent_id])) {
            $cl .= '<ul>';
            if ($only_parent === false) {
                foreach ($catalogs[$parent_id] as $catalog) {
                    $cl .= '<li>' . $catalog['name'] . ' <a title="Добавить подкатегорию" href="' . URL::route('admin.catalog.create', ['parent_id' => $catalog['id']]) . '"> <span class="fa fa-plus"></span> </a> <a title="Редактировать" href="' . URL::route('admin.catalog.edit', ['id' => $catalog['id']]) . '"> <span class="fa fa-edit"></span> </a> <a title="Удалить" href="' . URL::route('admin.catalog.destroy', ['id' => $catalog['id']]) . '"> <span class="fa fa-trash"></span> </a>';
                    $cl .= self::buildTree($catalogs, $catalog['id']);
                    $cl .= '</li>';
                }
            } else {
                $catalog = $catalogs[$parent_id][$only_parent];
                $cl .= '<li>' . $catalog['name'] . ' #' . $catalog['id'];
                $cl .= self::buildTree($catalogs, $catalog['id'], true);
                $cl .= '</li>';
            }
            $cl .= '</ul>';
        }

        return $cl;
    }

    /**
     * @param object $categories
     * @param array $allChildren
     * @param int $parent_id
     * @return void
     */
    public static function getAllChildren(object $categories, array &$allChildren, int $parent_id = 0): void
    {
        $cats = $categories->filter(function ($item) use ($parent_id) {
            return $item->parent_id == $parent_id;
        });

        foreach ($cats as $cat) {
            array_push($allChildren, $cat->id);
            self::getAllChildren($categories, $allChildren, $cat->id);
        }
    }

    /**
     * @return array
     */
    public static function getCatalogList(): array
    {
        $catalogs = self::query()->orderBy('name')->get();
        $catalogsList = [];

        foreach ($catalogs->toArray() ?? [] as $catalog) {
            $catalogsList[$catalog['parent_id']][$catalog['id']] = $catalog;
        }

        return $catalogsList;
    }
}
