<?php

namespace App\Http\Controllers\Admin;


use App\Models\News;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Products;
use App\Models\Settings;
use App\Models\Manufacturers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class DataTableController extends Controller
{

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function news(): JsonResponse
    {
        $row = News::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.news.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function manufacturers(): JsonResponse
    {
        $row = Manufacturers::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.manufacturers.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function users(): JsonResponse
    {
        $row = User::query();

        return Datatables::of($row)
            ->addColumn('action', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.users.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';

                if ($row->id !== Auth::id())
                    $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';
                else
                    $deleteBtn = '';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('role', function ($row) {
                switch ($row->role) {
                    case 'admin':
                        return 'админ';
                    case 'editor':
                        return 'редактор';
                    case 'moderator':
                        return 'модератор';
                    default:
                        return '';
                }
            })
            ->rawColumns(['action', 'id'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function feedback(): JsonResponse
    {
        $row = Feedback::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.feedback.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function products(): JsonResponse
    {
        $row = Products::selectRaw('products.id,products.title,products.article,products.n_number,products.price,products.published,products.catalog_id,products.slug,products.created_at,products.description,catalog.name AS catalog')
            ->leftJoin('catalog', 'catalog.id', '=', 'products.catalog_id')
            ->groupBy('catalog.name')
            ->groupBy('products.id')
            ->groupBy('products.title')
            ->groupBy('products.catalog_id')
            ->groupBy('products.slug')
            ->groupBy('products.article')
            ->groupBy('products.n_number')
            ->groupBy('products.price')
            ->groupBy('products.published')
            ->groupBy('products.description')
            ->groupBy('products.created_at')
            ->groupBy('products.description');

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary" href="' . URL::route('cp.products.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('title', function ($row) {
                $title = $row->title;
                $title .= '<br><a href="' . URL::route('cp.product_documents.index', ['product_id' => $row->id]) . '">Техническая документация</a><br>';
                $title .= '<br><a href="' . URL::route('cp.product_parameters.index', ['product_id' => $row->id]) . '">Технические характеристики</a><br>';

                return $title;
            })
            ->editColumn('thumbnail', function ($row) {
                $product = Products::find($row->id);

                return '<img  height="150" src="' . url($product->getThumbnailUrl()) . '" alt="" loading="lazy">';
            })
            ->editColumn('published', function ($row) {
                return $row->published == 1 ? 'опубликован' : 'не опубликован';
            })
            ->rawColumns(['actions', 'title', 'thumbnail'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function settings(): JsonResponse
    {
        $row = Settings::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.settings.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('published', function ($row) {
                return $row->published == 1 ? 'да' : 'нет';
            })
            ->rawColumns(['actions'])->make(true);
    }
}
