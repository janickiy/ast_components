<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\{Customers,
    Complaints,
    News,
    Requests,
    User,
    Feedback,
    Pages,
    Products,
    Settings,
    Seo,
    Redirect,
    Manufacturers,
    ProductDocuments,
    ProductParameters,
    Orders,
    OrderProduct,
    Invites};
use App\Helpers\StringHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;

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
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function redirect(): JsonResponse
    {
        $row = Redirect::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.redirect.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function pages(): JsonResponse
    {
        $row = Pages::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.pages.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
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
            ->editColumn('description', function ($row) {
                return StringHelper::shortText(StringHelper::clearHtmlTags($row->description), 800);
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function seo(): JsonResponse
    {
        $row = Seo::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.seo.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a>';

                return '<div class="nobr"> ' . $editBtn . '</div>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
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
                    $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';
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
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
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
            ->addColumn('action', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.feedback.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('status', function ($row) {
                return '<p class="' . $row->getStatus()?->cssColor() . '">' . $row->getStatus()?->label() . '</p>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['action', 'status'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function products(): JsonResponse
    {
        $row = Products::selectRaw('products.*,catalogs.name AS catalog, manufacturers.title AS manufacturer')
            ->leftJoin('catalogs', 'catalogs.id', '=', 'products.catalog_id')
            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')
            ->groupBy('catalogs.name')
            ->groupBy('manufacturers.title')
            ->groupBy('products.id')
            ->groupBy('products.title')
            ->groupBy('products.catalog_id')
            ->groupBy('products.slug')
            ->groupBy('products.article')
            ->groupBy('products.n_number')
            ->groupBy('products.price')
            ->groupBy('products.in_stock')
            ->groupBy('products.description')
            ->groupBy('products.created_at')
            ->groupBy('products.description');

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary" href="' . URL::route('admin.products.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('message', function ($row) {
                return $row->message ? StringHelper::shortText($row->message) : '';
            })
            ->editColumn('title', function ($row) {
                $title = $row->title;
                $title .= '<br><a href="' . URL::route('admin.product_documents.index', ['product_id' => $row->id]) . '">Техническая документация</a><br>';
                $title .= '<br><a href="' . URL::route('admin.product_parameters.index', ['product_id' => $row->id]) . '">Технические характеристики</a><br>';

                return $title;
            })
            ->editColumn('thumbnail', function ($row) {
                $product = Products::find($row->id);

                return '<img  width="150" src="' . url($product->getThumbnailUrl()) . '" alt="" loading="lazy">';
            })
            ->editColumn('in_stock', function ($row) {
                return $row->in_stock;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
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
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @param int $product_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function productDocuments(int $product_id): JsonResponse
    {
        $row = ProductDocuments::where('product_id', $product_id);

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.product_documents.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @param int $product_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function productParameters(int $product_id): JsonResponse
    {
        $row = ProductParameters::where('product_id', $product_id);

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.product_parameters.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function orders(): JsonResponse
    {
        $row = Orders::selectRaw('orders.*,SUM(order_product.price * order_product.count) as sum, customers.name AS customer')
            ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
            ->leftJoin('order_product', 'order_product.order_id', '=', 'orders.id')
            ->groupBy('orders.id')
            ->groupBy('orders.status')
            ->groupBy('orders.delivery_date')
            ->groupBy('orders.invoice')
            ->groupBy('orders.created_at')
            ->groupBy('customers.name');

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.orders.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';

                return '<div class="nobr"> ' . $editBtn . '</div>';
            })
            ->editColumn('invoice', function ($row) {
                return $row->invoice ? 'есть' : 'нет';
            })
            ->editColumn('customer', function ($row) {
                return '<a href="' . URL::route('admin.order_product.index', ['order_id' => $row->id]) . '">' . $row->customer . '</a>';
            })
            ->editColumn('status', function ($row) {
                return '<p class="' . $row->getStatus()?->cssColor() . '">' . $row->getStatus()?->label() . '</p>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['actions', 'customer', 'status'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function customers(): JsonResponse
    {
        $row = Customers::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.customers.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';

                return '<div class="nobr"> ' . $editBtn . '</div>';
            })
            ->editColumn('name', function ($row) {
                return '<a href="' . URL::route('admin.customer_log.index', ['customer_id' => $row->id]) . '">' . $row->name . '</a>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['actions', 'name'])->make(true);
    }

    /**
     * @param int $order_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function orderProduct(int $order_id): JsonResponse
    {
        $row = OrderProduct::where('order_id', $order_id);

        return Datatables::of($row)
            ->rawColumns([])->make(true);
    }

    /**
     * @param int $customer_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function logs(int $customer_id): JsonResponse
    {
        $customer = Customers::find($customer_id);
        $row = AuthenticationLog::query()->forUser($customer);

        return Datatables::of($row)
            ->editColumn('login_successful', function ($row) {
                return $row->login_successful == 1 ? 'да' : 'нет';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns([])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function invites(): JsonResponse
    {
        $row = Invites::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.invites.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('platform', function ($row) {
                return Invites::getPlatformList()[$row->platform] ?? '';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function complaints(): JsonResponse
    {
        $row = Complaints::selectRaw('complaints.*, products.title AS product, customers.name AS customer')
            ->join('products', 'products.id', '=', 'complaints.product_id')
            ->join('customers', 'customers.id', '=', 'complaints.customer_id')
            ->groupBy('complaints.id')
            ->groupBy('complaints.created_at')
            ->groupBy('complaints.result')
            ->groupBy('complaints.status')
            ->groupBy('complaints.customer_id')
            ->groupBy('complaints.return_count')
            ->groupBy('complaints.order_id')
            ->groupBy('complaints.order_id')
            ->groupBy('products.title')
            ->groupBy('customers.name');

        return Datatables::of($row)
            ->addColumn('action', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.complaints.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->editColumn('status', function ($row) {
                return '<p class="' . $row->getStatus()?->cssColor() . '">' . $row->getStatus()?->label() . '</p>';
            })
            ->editColumn('type', function ($row) {
                return Complaints::$type_name[$row->type] ?? '';
            })
            ->editColumn('product', function ($row) {
                return $row->product;
            })
            ->rawColumns(['action', 'status'])->make(true);

    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function requests(): JsonResponse
    {
        $row = Requests::query();

        return Datatables::of($row)
            ->addColumn('action', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.requests.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-trash"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->editColumn('status', function ($row) {
                return '<p class="' . $row->getStatus()?->cssColor() . '">' . $row->getStatus()?->label() . '</p>';
            })
            ->rawColumns(['action', 'status'])->make(true);
    }
}
