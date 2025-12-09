<?php

namespace App\Http\Livewire\Admin;

use App\Models\VisitorRegistration;
use Livewire\Component;
use Livewire\WithPagination;

class VisitorRegistrationsTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $dateFrom = '';
    public string $dateTo = '';

    protected $queryString = [
        'search'   => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo'   => ['except' => ''],
        'page'     => ['except' => 1],
    ];

    public function updating($name)
    {
        if (in_array($name, ['search', 'dateFrom', 'dateTo'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = VisitorRegistration::query();

        if ($this->search !== '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.admin.visitor-registrations-table', [
            'registrations' => $registrations,
        ]);
    }

    public function export()
    {
        return redirect()->route('admin.visitors.export', [
            'search'   => $this->search,
            'dateFrom' => $this->dateFrom,
            'dateTo'   => $this->dateTo,
        ]);
    }
}
