<?php

namespace App\Http\Controllers\Backend\Ecommerce;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreProductRequest;
use App\Http\Requests\Backend\UpdateProductRequest;
use App\Models\BookCategory;
use App\Models\BookSubject;
use App\Models\BookVariant;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\YearGroup;
use App\Operations\Backend\AdminActivity;
use App\Operations\Backend\StripeProductActivity;
use App\Services\FileService;
use App\Services\MoneyService;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Laravel\Cashier\Cashier;
use Money\Currency;
use Money\Money;
use function Symfony\Component\String\s;

class YearGroupController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $year_groups = YearGroup::all();

        return view('backend.ecommerce.year-group.index')
            ->with([
                'year_groups' => $year_groups,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createProduct', Auth::user());

        $statuses = Status::cases();
        $bookVariants = BookVariant::query()
            ->where('status', Status::ACTIVE)
            ->get();

        return view('backend.ecommerce.year-group.form')
            ->with([
                'statuses' => $statuses,
                'bookVariants' => $bookVariants,
            ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'year_name' => 'required|string|max:200'
        ]);

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\YearGroup',
        ];

        $yearGroup = YearGroup::query()->create($validated);

        $this->notification['status'] = 'success';
        $this->notification['message'] = "Year Group has been created";

        return to_route('admin.year-groups.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function edit(YearGroup $yearGroup): View
    {
        return view('backend.ecommerce.year-group.form')
            ->with([
                'year_group' => $yearGroup,
            ]);
    }

    public function update(Request $request, YearGroup $yearGroup): RedirectResponse
    {
        $validated = $request->validate([
            'year_name' => 'required|string|max:200'
        ]);

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\YearGroup',
            'old_data' => json_encode($yearGroup->toArray()),
        ];

        $yearGroup->update($validated);

        $this->notification['status'] = 'success';
        $this->notification['message'] = 'Year Group has been updated';

        return to_route('admin.year-groups.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function destroy(YearGroup $yearGroup): RedirectResponse
    {
        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\YearGroup',
            'old_data' => json_encode($yearGroup->toArray()),
        ];

        $yearGroup->delete();

        $this->notification['status'] = 'success';
        $this->notification['message'] = 'year group has been deleted';

        return to_route('admin.year-groups.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

}
